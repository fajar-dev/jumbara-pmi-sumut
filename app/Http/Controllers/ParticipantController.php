<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParticipantAssignment;

class ParticipantController extends Controller
{
    public function activity()
    {
        $acivity = ParticipantAssignment::where('participant_id', Auth::user()->participant->id)
            ->with(['activity' => function ($query) {
                $query->orderBy('start', 'asc');
            }])
            ->get();
        // dd($acivity);
        $data = [
            'title' => 'My Activities',
            'subTitle' => null,
            'activity' => $acivity,
        ];
        return view('app.participant.activity', $data);
    }

}
