<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityAttendance;
use Illuminate\Http\Request;
use App\Models\CrewAssignment;
use Illuminate\Support\Facades\Auth;
use App\Models\ParticipantAssignment;

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

    public function assignmentAttendance($id)
    {
        $userCrewId = Auth::user()->crew->id;
        $now = now();

        $activity = Activity::find($id);

        if (!$activity) {
            return redirect()->route('crew.assignment')->with('error', 'Activity not found');
        }

        $allowedAccessTime = $activity->start->subMinutes(15);

        if ($now->lt($allowedAccessTime) || $now->gt($activity->end)) {
            return redirect()->route('crew.assignment')->with('error', 'Forbidden');
        }

        $assignment = CrewAssignment::where('crew_id', $userCrewId)
            ->where('activity_id', $id)
            ->with('activity')
            ->first();

        if (!$assignment) {
            return redirect()->route('crew.assignment')->with('error', 'Forbidden');
        }

        $data = [
            'title' => 'Assignment',
            'subTitle' => $activity->name,
            'assignment' => $assignment,
            'activity' => $activity,
        ];

        return view('app.crew.attendance', $data);
    }

    public function assignmentAttendancePresent($id, Request $request)
    {

        $assignment = ParticipantAssignment::where('activity_id', $id)
            ->whereHas('participant', function ($query) use ($request) {
                $query->whereHas('user', function ($subQuery) use ($request) {
                    $subQuery->where('member_id', $request->input('memberId'));
                });
            })->first();

        if (!$assignment) {
            return response()->json(['message' => 'Participant not registered this activity'], 403);
        }

        $checkAttendance = ActivityAttendance::where('participant_assignment_id', $assignment->id)
            ->exists();

        if ($checkAttendance) {
            return response()->json(['message' => 'Attendance already marked as present'], 403);
        }

        $crewAssignment = CrewAssignment::where('activity_id', $id)
            ->where('crew_id', Auth::user()->crew->id)
            ->first();

        if (!$crewAssignment) {
            return response()->json(['message' => 'Crew assignment not found'], 403);
        }

        $attendance = new ActivityAttendance();
        $attendance->participant_assignment_id = $assignment->id;
        $attendance->crew_assignment_id = $crewAssignment->id;
        $attendance->ip_address = $request->ip();
        $attendance->user_agent = $request->header('User-Agent');
        $attendance->save();

        return response()->json(['message' => 'Attendance success'], 200);
    }



}
