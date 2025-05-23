<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gender;
use App\Models\Activity;
use App\Models\Contingent;
use App\Models\MemberType;
use App\Models\Coordinator;
use App\Models\Participant;
use App\Models\Secretariat;
use App\Models\ActivityType;
use Illuminate\Http\Request;
use App\Models\ParticipantType;
use Illuminate\Support\Facades\Hash;
use App\Models\ActicityParticipation;
use App\Models\ParticipantAssignment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function contingent(Request $request){
        $search = $request->input('q');
        $data = Contingent::where('name', 'LIKE', '%' . $search . '%')->with('coordinator')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Event',
            'subTitle' => 'Contingent',
            'page_id' => null,
            'contingent' => $data
        ];
        return view('app.event.contingent.contingent',  $data);
    }

    public function contingentStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'provinceId' => 'required',
            'cityId' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.event.contingent')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $contingent = New Contingent();
        $contingent->name = $request->input('name');
        $contingent->administrative_area_level_1 = $request->input('provinceId');
        $contingent->administrative_area_level_2 = $request->input('cityId');
        $contingent->save();

        return redirect()->route('admin.event.contingent')->with('success', 'Contingent has been added successfully');
    }

    public function contingentUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'provinceId' => 'required',
            'cityId' => 'required'        
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.event.contingent')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $contingent = Contingent::findOrFail($id);
        $contingent->name = $request->input('name');
        $contingent->administrative_area_level_1 = $request->input('provinceId');
        $contingent->administrative_area_level_2 = $request->input('cityId');
        $contingent->save();

        return redirect()->route('admin.event.contingent')->with('success', 'Contingent has been updated successfully');
    }

    public function contingentDestroy($id){
        $contingent = Contingent::findOrFail($id);
        $contingent->delete();
        return redirect()->route('admin.event.contingent')->with('success', 'Contingent has been deleted successfully');
    }

    public function coordinatorStore($id, Request $request){  
        $data =json_decode($request->input('json'));
        // dd($data->domicile->address);

        $secretariat = Secretariat::where('name', $data->membership->name)->first();
        if (!$secretariat) {
            $secretariat = New Secretariat();
            $secretariat->category = $data->membership->type->category;
            $secretariat->type = $data->membership->type->subCategory;
            $secretariat->name = $data->membership->name;
            $secretariat->address = $data->membership->address;
            $secretariat->phone = $data->membership->phone;
            $secretariat->email = $data->membership->email;
            $secretariat->administrative_area_level_1 = $data->membership->administrativeAreaLevel1;
            $secretariat->administrative_area_level_2 = $data->membership->administrativeAreaLevel2;
            $secretariat->save();
        }
        
        $user = User::where('member_id', $request->input('memberId'))->first();
        if (!$user) {
            $user = New User();
            $user->member_id = $request->input('memberId');
            $user->name = $data->name;
            $user->email = $data->email;
            $user->gender_id = $data->gender->id;
            $user->religion_id = $data->religion->id;
            $user->blood_type_id = $data->bloodType->id;
            $user->phone_number = $data->phone;
            $user->birth_place = $data->birthPlace;
            $user->birth_date = $data->birthDate;
            $user->password = Hash::make($request->input('memberId'));
            $user->secretariat_id = $secretariat->id;
            $user->member_type_id = $data->category->id;
            $user->address -> $data->domicile->address ?? null;
            $user->data = $request->input('json');
            $user->joined_at = $data->membership->joinedAt;
            $user->save();
        }

        $checkPermission = Coordinator::where('user_id', $user->id)->exists();
        if ($checkPermission) {
            return redirect()->route('admin.event.contingent')->with('error', 'Coordinator already exists');
        }

        $coordinator = Coordinator::where('contingent_id', $id)->first();
        if($coordinator){
            $coordinator->delete();
        }

        $permission = New Coordinator();
        $permission->user_id = $user->id;
        $permission->contingent_id = $id;
        $permission->save();

        return redirect()->route('admin.event.contingent')->with('success', 'Coordinator has been added successfully');
    }

    public function activity(Request $request){
        $search = $request->input('q');
        $data = Activity::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Event',
            'subTitle' => 'Activity',
            'page_id' => null,
            'activity' => $data,
            'activityType' => ActivityType::all(),
            'participantType' => ParticipantType::all(),
            'memberType' => MemberType::all() 
        ];
        return view('app.event.activity',  $data);
    }

    public function activityStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.event.activity')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $activity = New Activity();
        $activity->name = $request->input('name');
        $activity->description = $request->input('description');
        $activity->activity_type_id = $request->input('type');
        $activity->start = $request->input('start');
        $activity->end = $request->input('end');
        $activity->save();

        return redirect()->route('admin.event.activity')->with('success', 'Activity has been added successfully');
    }

    public function activityUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.event.activity')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $contingent = Activity::findOrFail($id);
        $contingent->name = $request->input('name');
        $contingent->description = $request->input('description');
        $contingent->activity_type_id = $request->input('type');
        $contingent->start = $request->input('start');
        $contingent->end = $request->input('end');
        $contingent->save();
        return redirect()->route('admin.event.activity')->with('success', 'Activity has been updated successfully');
    }

    public function activityDestroy($id){
        $contingent = Activity::findOrFail($id);
        $contingent->delete();
        return redirect()->route('admin.event.activity')->with('success', 'Activity has been deleted successfully');
    }

    public function participationRule($id, Request $request)
    {
        ActicityParticipation::where('activity_id', $id)->delete();

        if($request->delete == "true"){
            ParticipantAssignment::where('activity_id', $id)->delete();
        };

        // Simpan data participant type baru
        if ($request->participantTypes && $request->participantCounts) {
            foreach ($request->participantTypes as $key => $participantTypeId) {
                ActicityParticipation::updateOrInsert([
                    'activity_id' => $id,
                    'participant_type_id' => $participantTypeId,
                ], [
                    'max_participant' => $request->participantCounts[$key]
                ]);
            }
        }

        // Simpan data member type baru (termasuk kondisi All)
        if ($request->memberTypes && $request->memberCounts) {
            foreach ($request->memberTypes as $key => $memberTypeId) {
                ActicityParticipation::updateOrInsert([
                    'activity_id' => $id,
                    'member_type_id' => $memberTypeId ?: null,
                ], [
                    'max_participant' => $request->memberCounts[$key]
                ]);
            }
        }

        return redirect()->back()->with('success', 'Participation rules updated successfully.');
    }

    public function contingentParticipant($id, Request $request)
    {
        $search = $request->input('q');
        $gender = $request->input('gender');
        $memberType = $request->input('memberType');
        $participantType = $request->input('participantType');

        $participant = Participant::with('user')
            ->where('contingent_id', $id)
            ->where('is_draft', false)
            ->whereHas('user', function ($query) use ($search, $gender, $memberType) {
                if ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                }

                if ($gender) {
                    $query->where('gender_id', $gender);
                }

                if ($memberType) {
                    $query->where('member_type_id', $memberType);
                }
            })
            ->when($participantType, function ($query) use ($participantType) {
                $query->where('participant_type_id', $participantType);
            })
            ->orderBy('participant_type_id', 'desc')
            ->paginate(10);

        $participant->appends($request->all());

        $memberTypeList = MemberType::with(['memberParticipations.participantType'])->find($memberType);

        $participantTypeList = [];
        if ($memberType) {
            foreach ($memberTypeList->memberParticipations as $participation) {
                $participantType = $participation->participantType;
                $participantTypeList[] = [
                    'id' => $participantType->id,
                    'name' => $participantType->name,
                ];
            }
        }

        // return $participantTypeList;
        return view('app.event.contingent.participant', [
            'title' => 'Event',
            'subTitle' => 'Contingent',
            'participant' => $participant,
            'gender' => Gender::all(),
            'memberType' => MemberType::all(),
            'participantTypeList' => $participantTypeList,
            'contingent' => Contingent::find($id)
        ]);
    }

}
