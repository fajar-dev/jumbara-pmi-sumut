<?php

namespace App\Http\Controllers;

use App\Models\MemberType;
use App\Models\Coordinator;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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


}
