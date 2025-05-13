<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\User;
use App\Models\Admin;
use App\Models\Activity;
use App\Models\CrewAssignment;
use App\Models\Secretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function admin(Request $request){
        $search = $request->input('q');
        $admins = Admin::with('user')
            ->whereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $admins->appends(['q' => $search]);
        $data = [
            'title' => 'User',
            'subTitle' => 'Admin',
            'admin' => $admins 
        ];
        return view('app.user.admin', $data);
    }                                                           


    public function adminStore(Request $request){
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
            $user->secretariat_id = $secretariat->id;
            $user->member_type_id = $data->category->id;
            $user->data = $request->input('json');
            $user->joined_at = $data->membership->joinedAt;
            $user->save();
        }

        $checkPermission = Admin::where('user_id', $user->id)->exists();
        if ($checkPermission) {
            return redirect()->route('admin.user.admin')->with('error', 'Admin already exists');
        }

        $permission = New Admin();
        $permission->user_id = $user->id;
        $permission->save();

        return redirect()->route('admin.user.admin')->with('success', 'Admin has been added successfully');
    }

    public function adminDestroy($id){
        $user = Admin::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user.admin')->with('success', 'Admin has been deleted successfully');
    }

     public function crew(Request $request){
        $search = $request->input('q');
        $admins = Crew::with('user')
            ->whereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $admins->appends(['q' => $search]);
        $data = [
            'title' => 'User',
            'subTitle' => 'Crew',
            'crew' => $admins,
            'activity' => Activity::all(),
        ];
        return view('app.user.crew', $data);
    }

     public function crewStore(Request $request){
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
            $user->secretariat_id = $secretariat->id;
            $user->member_type_id = $data->category->id;
            $user->data = $request->input('json');
            $user->joined_at = $data->membership->joinedAt;
            $user->save();
        }

        $checkPermission = Crew::where('user_id', $user->id)->exists();
        if ($checkPermission) {
            return redirect()->route('admin.user.crew')->with('error', 'Crew already exists');
        }

        $permission = New Crew();
        $permission->user_id = $user->id;
        $permission->save();

        if ($request->assignment) {
            foreach ($request->assignment as  $result) {
                CrewAssignment::updateOrInsert([
                    'crew_id' => $permission->id,
                    'activity_id' => $result
                ]);
            }
        }

        return redirect()->route('admin.user.crew')->with('success', 'Crew has been added successfully');
    }

    public function crewUpdate($id, Request $request){
        CrewAssignment::where('crew_id', $id)->delete();
        if ($request->assignment) {
            foreach ($request->assignment as  $result) {
                CrewAssignment::updateOrInsert([
                    'crew_id' => $id,
                    'activity_id' => $result
                ]);
            }
        }
        return redirect()->route('admin.user.crew')->with('success', 'Crew has been updated successfully');
    }

    public function crewDestroy($id){
        $user = Crew::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user.crew')->with('success', 'Crew has been deleted successfully');
    }
}
