<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\User;
use App\Models\Admin;
use App\Models\MemberType;
use App\Models\Coordinator;
use App\Models\Participant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\ParticipantAssignment;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ServiceController extends Controller
{
    public function handle(Request $request)
    {
        $memberId = $request->input('memberId');

        if (!$memberId) {
            return response()->json(['error' => 'memberId is required'], 400);
        }

        $targetUrl = 'https://siamo.pmi.or.id/apimis/control/get_mis.php';

        $response = Http::get($targetUrl, [
            'memberId' => $memberId,
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
    }

    public function participantType($id){
        $memberType = MemberType::with(['memberParticipations.participantType'])->find($id);

        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();

        if (!$memberType || !$coordinator) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $result = [];

        foreach ($memberType->memberParticipations as $participation) {
            $participantType = $participation->participantType;

            if (!$participantType) continue;

            // Hitung jumlah peserta yang sudah ada
            $currentCount = Participant::where('contingent_id', $coordinator->contingent_id)
                ->where('participant_type_id', $participantType->id)
                // ->where('is_draft', true)
                ->count();

            $max = $participantType->max_participant;

            $available = $max - $currentCount;

            $result[] = [
                'id' => $participantType->id,
                'name' => $participantType->name,
                'max_participant' => $max,
                'available' => $available,
                'disabled' => $available <= 0
            ];
        }

        return response()->json($result);
    }

    public function participant(Request $request, $id = null)
    {
        $q = $request->input('q');
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        if (!$coordinator) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $participantQuery = Participant::where('contingent_id', $coordinator->contingent_id)
            ->where('is_draft', false)
            ->whereHas('user', function ($query) use ($q) {
                if ($q) {
                    $query->where('name', 'like', '%' . $q . '%')
                        ->orWhere('member_id', 'like', '%' . $q . '%');
                }
            });

        if ($id) {
            $participantQuery->where('participant_type_id', $id);
        };

        $participants = $participantQuery->with('user')->get();

        $result = [];
        foreach ($participants as $p) {
            $result[] = [
                'id' => $p->id,
                'name' => $p->user->name,
                'memberId' => $p->user->member_id,
            ];
        }

        return response()->json($result);
    }

    public function member(Request $request, $id = null)
    {
        $q = $request->input('q');
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        if (!$coordinator) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $participantQuery = Participant::where('contingent_id', $coordinator->contingent_id)
            ->where('is_draft', false);

        if ($id || $q) {
            $participantQuery->whereHas('user', function ($query) use ($id, $q) {
                if ($id) {
                    $query->where('member_type_id', $id);
                }
                if ($q) {
                    $query->where(function ($subQuery) use ($q) {
                        $subQuery->where('name', 'like', '%' . $q . '%')
                                ->orWhere('member_id', 'like', '%' . $q . '%');
                    });
                }
            });
        } else {
            $participantQuery->with('user');
        }

        $participants = $participantQuery->with('user')->get();

        $result = [];
        foreach ($participants as $p) {
            $result[] = [
                'id' => $p->id,
                'name' => $p->user->name,
                'memberId' => $p->user->member_id,
            ];
        }

        return response()->json($result);
    }

    public function activity($id, Request $request)
    {
        $search = $request->input('q');
        $attendanceStatus = $request->input('attendance'); // 'true', 'false', atau null
        $contingentId = $request->input('contingentId');

        $userId = Auth::user()->id;

        $coordinator = Coordinator::where('user_id', $userId)->first();
        $isAdmin = Admin::where('user_id', $userId)->exists();
        $isCrew = Crew::where('user_id', $userId)->exists();

        $participantQuery = Participant::with([
                'user.gender',
                'user.memberType',
                'contingent',
                'participantType',
                'participantAssignment' => function ($query) use ($id) {
                    $query->where('activity_id', $id)
                        ->with('activityAttendance');
                }
            ])
            ->where('is_draft', false)
            ->whereHas('user', function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            })
            ->whereHas('participantAssignment', function ($query) use ($id) {
                $query->where('activity_id', $id);
            });

        // Filter berdasarkan status kehadiran
        if (!is_null($attendanceStatus)) {
            if ($attendanceStatus === 'true') {
                $participantQuery->whereHas('participantAssignment', function ($query) use ($id) {
                    $query->where('activity_id', $id)
                        ->whereHas('activityAttendance');
                });
            } elseif ($attendanceStatus === 'false') {
                $participantQuery->whereHas('participantAssignment', function ($query) use ($id) {
                    $query->where('activity_id', $id)
                        ->whereDoesntHave('activityAttendance');
                });
            }
        }

        // Filter contingent berdasarkan role
        if (!$isAdmin && !$isCrew && $coordinator) {
            // Jika bukan admin atau crew, batasi ke contingent milik koordinator
            $participantQuery->where('contingent_id', $coordinator->contingent_id);
        } elseif ($contingentId) {
            // Jika admin atau crew dan ada contingentId yang dikirim
            $participantQuery->where('contingent_id', $contingentId);
        }

        $participants = $participantQuery
            ->orderBy('contingent_id', 'desc')
            ->orderBy('participant_type_id', 'desc')
            ->paginate(10);

        // Transformasi hasil agar hanya data penting yang dikembalikan
        $transformed = $participants->getCollection()->transform(function ($item) {
            return [
                'name' => $item->user->name ?? null,
                'memberId' => $item->user->member_id ?? null,
                'photoPath' => $item->user->photo_path 
                    ? Storage::url($item->user->photo_path) 
                    : null,
                'gender' => $item->user->gender->name ?? null,
                'memberType' => $item->user->memberType->name ?? null,
                'participantType' => $item->participantType->name ?? null,
                'contingent' => $item->contingent->name ?? null,
                'isVerified' => (bool) $item->user->secretariat_id,
                'attendance' => $item->participantAssignment->map(function ($assignment) {
                    return [
                        'attendance' => (bool) $assignment->activityAttendance,
                        'attendanceDate' => optional($assignment->activityAttendance)->created_at,
                    ];
                })->toArray(),
            ];
        });
        $participants->setCollection($transformed);
        return response()->json($participants);
    }

    public function idCard($id)
    { 
        $user = User::where('member_id', $id)->whereHas('participant', function ($query) {
            $query->where('is_draft', false);
        })->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->participant->participant_type_id == 2) {
            $background = public_path('id-card/mula.jpg');
        }
        elseif ($user->participant->participant_type_id == 3) {
            $background = public_path('id-card/madya.jpg');
        }
        elseif ($user->participant->participant_type_id == 4) {
            $background = public_path('id-card/wira.jpg');
        }
        elseif ($user->participant->participant_type_id == 5) {
            if ($user->gender_id == 1) {
                $background = public_path('id-card/pem-putra.jpg');
            } else {
                $background = public_path('id-card/pem-putri.jpg');
            }
        }
        elseif ($user->participant->participant_type_id == 7) {
            $background = public_path('id-card/fasil.jpg');
        }
        elseif ($user->participant->participant_type_id == 8) {
            $background = public_path('id-card/peninjau.jpg');
        } else {
            return response()->json(['message' => 'Invalid participant type'], 400);
        }
        
        $png = QrCode::size(150)->generate($id);
        $qrCodeSvg = base64_encode($png);
        // return $qrCodeSvg;
        $data = [
            'name' => $user->name,
            'kontingen' => $user->participant->contingent->name,
            'foto' => public_path('storage/'.$user->photo_path), // ganti sesuai foto peserta
            'qrcode' => $qrCodeSvg,
            'background' => $background,
            'memberId' => $user->member_id,
        ];

        $pdf = PDF::loadView('app.pdf.id-card', $data);
        $pdf->setPaper('a6', 'portrait');

        return $pdf->stream($id.'.pdf');
    }

}
