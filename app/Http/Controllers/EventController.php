<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contingent;
use App\Models\ActivityType;
use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Http\Request;
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
        $user = New User();
        $user->member_id = $request->input('memberId');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->data = $request->input('json');
        $user->role = 'coordinator';
        $user->save();

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
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.event.activity')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $activity = New Activity();
        $activity->name = $request->input('name');
        $activity->description = $request->input('description');
        $activity->activity_type_id = $request->input('type');
        $activity->start = $request->input('start');
        $activity->name = $request->input('name');
        $activity->end = $request->input('end');
        $activity->save();

        return redirect()->route('admin.event.activity')->with('success', 'Activity has been added successfully');
    }
}
