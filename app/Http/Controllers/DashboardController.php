<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Activity;
use App\Models\Religion;
use App\Models\BloodType;
use App\Models\Contingent;
use App\Models\MemberType;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\ParticipantType;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $contingentId = $request->input('contingentId');

        // Dasar query peserta (bukan draft)
        $participantQuery = Participant::query()->where('is_draft', false);
        if(Auth::user()->crew OR Auth::user()->admin) {
            if ($contingentId) {
                $participantQuery->where('contingent_id', $contingentId);
            }
        }elseif(Auth::user()->coordinator) {
            $participantQuery->where('contingent_id', Auth::user()->coordinator->contingent_id);
        }else{
            $participantQuery->where('contingent_id', null);
        }

        // Ambil semua master kategori
        $allGenders = Gender::all();
        $allReligions = Religion::all();
        $allBloodTypes = BloodType::all();
        $allMemberTypes = MemberType::all();
        $allParticipantTypes = ParticipantType::all();

        // Fungsi helper untuk hitung kategori dengan handling Unknown (id=0)
        $countByCategory = function($query, $relation, $getId) {
            return (clone $query)
                ->with($relation)
                ->get()
                ->groupBy($getId)
                ->map->count();
        };

        // Hitung kategori peserta
        $genderCounts = $countByCategory($participantQuery, 'user.gender', fn($p) => $p->user->gender->id ?? 0);
        $religionCounts = $countByCategory($participantQuery, 'user.religion', fn($p) => $p->user->religion->id ?? 0);
        $bloodTypeCounts = $countByCategory($participantQuery, 'user.bloodType', fn($p) => $p->user->bloodType->id ?? 0);
        $memberTypeCounts = $countByCategory($participantQuery, 'user.memberType', fn($p) => $p->user->memberType->id ?? 0);
        $participantTypeCounts = $countByCategory($participantQuery, 'participantType', fn($p) => $p->participantType->id ?? 0);

        // Hitung siamo verified dan not verified
        $siamoVerifiedCount = (clone $participantQuery)
            ->whereHas('user', fn($q) => $q->whereNotNull('secretariat_id'))
            ->count();
        $siamoNotVerifiedCount = (clone $participantQuery)
            ->whereHas('user', fn($q) => $q->whereNull('secretariat_id'))
            ->count();

        // Fungsi merge hasil hitung kategori dengan master list dan tambahkan 'Unknown' jika perlu
        $mergeWithUnknown = function($allItems, $counts) {
            $unknownCount = $counts->get(0, 0);
            $final = $allItems->mapWithKeys(fn($item) => [$item->name => $counts->get($item->id, 0)]);
            if ($unknownCount > 0) {
                $final['Unknown'] = $unknownCount;
            }
            return $final;
        };

        $genderFinal = $mergeWithUnknown($allGenders, $genderCounts)->toArray();
        $religionFinal = $mergeWithUnknown($allReligions, $religionCounts)->toArray();
        $bloodTypeFinal = $mergeWithUnknown($allBloodTypes, $bloodTypeCounts)->toArray();
        $memberTypeFinal = $mergeWithUnknown($allMemberTypes, $memberTypeCounts)->toArray();
        $participantTypeFinal = $mergeWithUnknown($allParticipantTypes, $participantTypeCounts)->toArray();

        // Ambil semua activities dengan relasi participantAssignment dan filter contingent_id di participant
        $activities = Activity::with(['participantAssignment' => function($query) use ($contingentId) {
            if(Auth::user()->crew OR Auth::user()->admin) {
                    if ($contingentId) {
                        $query->whereHas('participant', function($q) use ($contingentId) {
                            $q->where('contingent_id', $contingentId);
                        });
                    }
                }elseif(Auth::user()->coordinator) {
                    $contingent_id = Auth::user()->coordinator->contingent_id;
                    $query->whereHas('participant', function($q) use ($contingent_id) {
                        $q->where('contingent_id', $contingent_id);
                    });
                }else{
                    $query->whereHas('participant', function($q){
                        $q->where('contingent_id', null);
                    });
                }
            $query->with('activityAttendance');
        }])->get();

        $activityStats = $activities->map(function($activity) {
            $totalParticipants = $activity->participantAssignment->count();
            $attendanceCount = $activity->participantAssignment->filter(fn($pa) => $pa->activityAttendance !== null)->count();
            return [
                'name' => $activity->name,
                'attendance' => $attendanceCount,
                'notAttendance' => $totalParticipants - $attendanceCount,
            ];
        });

        $data = [
            'title' => 'Dashboard',
            'subTitle' => null,
            'page_id' => null,
            'genderCounts' => $genderFinal,
            'religionCounts' => $religionFinal,
            'bloodTypeCounts' => $bloodTypeFinal,
            'memberTypeCounts' => $memberTypeFinal,
            'participantTypeCounts' => $participantTypeFinal,
            'siamoVerified' => [
                'verified' => $siamoVerifiedCount,
                'notVerified' => $siamoNotVerifiedCount,
            ],
            'activity' => $activityStats,
            'contingent' => Contingent::all(),
            'selectedContingentId' => $contingentId,
        ];

        return view('app.dashboard', $data);
    }

}
