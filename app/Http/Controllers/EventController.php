<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Contingent;
use App\Models\Coordinator;
use App\Models\Secretariat;
use App\Models\ActivityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('app.event.contingent',  $data);
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
            if ($data->photo) {
                $photoUrl = $data->photo;
                $headers = get_headers($photoUrl, 1);
                $httpStatus = substr($headers[0], 9, 3);
                if ($httpStatus == '404') {
                    $user->photo_path = null;
                } else {
                    $photoContent = file_get_contents($photoUrl);
                    $photoName = basename($photoUrl);
                    $path = Storage::disk('public')->put('user/' . $photoName, $photoContent);
                    $user->photo_path = 'user/' . $photoName;
                }
            } else {
                $user->photo_path = null;
            }
            $user->secretariat_id = $secretariat->id;
            $user->member_type_id = $data->category->id;
            $user->data = $request->input('json');
            $user->joined_at = $data->membership->joinedAt;
            $user->save();
        }

        $checkPermission = Coordinator::where('user_id', $user->id)->exists();
        if ($checkPermission) {
            return redirect()->route('admin.event.contingent')->with('error', 'Coordinator already exists');
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
            'max' => 'required|integer',
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
        $activity->max_participant = $request->input('max');
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
            'max' => 'required|integer',
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
        $contingent->max_participant = $request->input('max');
        $contingent->save();


        return redirect()->route('admin.event.activity')->with('success', 'Activity has been updated successfully');
    }

    public function activityDestroy($id){
        $contingent = Activity::findOrFail($id);
        $contingent->delete();
        return redirect()->route('admin.event.activity')->with('success', 'Activity has been deleted successfully');
    }
}
