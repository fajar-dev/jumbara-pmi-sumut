<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrewAssignment;
use Illuminate\Support\Facades\Auth;

class CrewController extends Controller
{
    public function assignment()
    {
        $assignment = CrewAssignment::where('crew_id', Auth::user()->crew->id)
            ->with(['activity' => function ($query) {
                $query->orderBy('start', 'asc');
            }])
            ->get();
        $data = [
            'title' => 'Assignment',
            'subTitle' => null,
            'assignment' => $assignment,
        ];
        return view('app.crew.assignment', $data);
    }
}
