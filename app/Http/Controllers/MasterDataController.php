<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\MemberType;
use App\Models\ParticipantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterDataController extends Controller
{
    public function member(Request $request){
        $search = $request->input('q');
        $data = MemberType::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Master Data',
            'subTitle' => 'Member Type',
            'page_id' => null,
            'memberType' => $data
        ];
        return view('app.master-data.member-type',  $data);
    }

    public function memberStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.member')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $member = New MemberType();
        $member->name = $request->input('name');
        $member->description = $request->input('description');
        $member->save();

        return redirect()->route('admin.master-data.member')->with('success', 'Member has been added successfully');
    }

    public function memberUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.member')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $member = MemberType::findOrFail($id);
        $member->name = $request->input('name');
        $member->description = $request->input('description');
        $member->save();

        return redirect()->route('admin.master-data.member')->with('success', 'Member has been updated successfully');
    }

    public function participant(Request $request){
        $search = $request->input('q');
        $data = ParticipantType::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Master Data',
            'subTitle' => 'Participant Type',
            'page_id' => null,
            'participantType' => $data
        ];
        return view('app.master-data.participant-type',  $data);
    }

    public function participantStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.participant')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $participant = New ParticipantType();
        $participant->name = $request->input('name');
        $participant->description = $request->input('description');
        $participant->save();

        return redirect()->route('admin.master-data.participant')->with('success', 'Participant has been added successfully');
    }

    public function participantUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.participant')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $participant = ParticipantType::findOrFail($id);
        $participant->name = $request->input('name');
        $participant->description = $request->input('description');
        $participant->save();

        return redirect()->route('admin.master-data.participant')->with('success', 'Participant has been updated successfully');
    }

    public function activity(Request $request){
        $search = $request->input('q');
        $data = ActivityType::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Master Data',
            'subTitle' => 'Activity Type',
            'page_id' => null,
            'activityType' => $data
        ];
        return view('app.master-data.activity-type',  $data);
    }

    public function activityStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.activity')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $activity = New ActivityType();
        $activity->name = $request->input('name');
        $activity->description = $request->input('description');
        $activity->save();

        return redirect()->route('admin.master-data.activity')->with('success', 'Activity has been added successfully');
    }

    public function activityUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.activity')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $activity = ActivityType::findOrFail($id);
        $activity->name = $request->input('name');
        $activity->description = $request->input('description');
        $activity->save();

        return redirect()->route('admin.master-data.activity')->with('success', 'Activity has been updated successfully');
    }
}
