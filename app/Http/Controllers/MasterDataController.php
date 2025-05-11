<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\BloodType;
use App\Models\Gender;
use App\Models\MemberType;
use App\Models\ParticipantType;
use App\Models\Religion;
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

    public function blood(Request $request){
        $search = $request->input('q');
        $data = BloodType::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Master Data',
            'subTitle' => 'Blood Type',
            'page_id' => null,
            'bloodType' => $data
        ];
        return view('app.master-data.blood-type',  $data);
    }

    public function bloodStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.blood')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $blood = New BloodType();
        $blood->name = $request->input('name');
        $blood->description = $request->input('description');
        $blood->save();

        return redirect()->route('admin.master-data.blood')->with('success', 'Blood has been added successfully');
    }

    public function bloodUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.blood')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $blood = BloodType::findOrFail($id);
        $blood->name = $request->input('name');
        $blood->description = $request->input('description');
        $blood->save();

        return redirect()->route('admin.master-data.blood')->with('success', 'Blood has been updated successfully');
    }

    public function gender(Request $request){
        $search = $request->input('q');
        $data = Gender::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Master Data',
            'subTitle' => 'Gender',
            'page_id' => null,
            'gender' => $data
        ];
        return view('app.master-data.gender',  $data);
    }

    public function genderStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.gender')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $gender = New Gender();
        $gender->name = $request->input('name');
        $gender->description = $request->input('description');
        $gender->save();

        return redirect()->route('admin.master-data.gender')->with('success', 'Gender has been added successfully');
    }

    public function genderUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.gender')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $gender = Gender::findOrFail($id);
        $gender->name = $request->input('name');
        $gender->description = $request->input('description');
        $gender->save();

        return redirect()->route('admin.master-data.gender')->with('success', 'Gender has been updated successfully');
    }

    public function religion(Request $request){
        $search = $request->input('q');
        $data = Religion::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Master Data',
            'subTitle' => 'Religion',
            'page_id' => null,
            'religion' => $data
        ];
        return view('app.master-data.religion',  $data);
    }

    public function religionStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.religion')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $religion = New Religion();
        $religion->name = $request->input('name');
        $religion->description = $request->input('description');
        $religion->save();

        return redirect()->route('admin.master-data.religion')->with('success', 'Religion has been added successfully');
    }

    public function religionUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.master-data.religion')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $religion = Religion::findOrFail($id);
        $religion->name = $request->input('name');
        $religion->description = $request->input('description');
        $religion->save();

        return redirect()->route('admin.master-data.religion')->with('success', 'Religion has been updated successfully');
    }
}
