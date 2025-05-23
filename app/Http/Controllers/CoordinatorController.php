<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\User;
use App\Models\Gender;
use App\Models\General;
use App\Models\Religion;
use App\Models\BloodType;
use App\Models\MemberType;
use App\Models\Coordinator;
use App\Models\Participant;
use App\Models\Secretariat;
use Illuminate\Http\Request;
use App\Models\ParticipantType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CoordinatorController extends Controller
{
    public function participant(Request $request)
    {
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();

        $search = $request->input('q');
        $gender = $request->input('gender');
        $memberType = $request->input('memberType');
        $participantType = $request->input('participantType');

        $participant = Participant::with('user')
            ->where('contingent_id', $coordinator->contingent->id)
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
        return view('app.coordinator.participant.participant', [
            'title' => 'Participant',
            'subTitle' => null,
            'participant' => $participant,
            'coordinator' => $coordinator,
            'gender' => Gender::all(),
            'memberType' => MemberType::all(),
            'participantTypeList' => $participantTypeList,
            'setting' => General::find(1)
        ]);
    }

    public function participantAdd(){
        $data = [
            'title' => 'Participant',
            'subTitle' => 'add',
            'coordinator' => Coordinator::where('user_id', Auth::user()->id)->first()
        ];
        return view('app.coordinator.participant.add-participant', $data);
    }
    
    public function participantCheck($provinceId, $cityId, Request $request){
        $validator = Validator::make($request->all(), [
            'memberId' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('coordinator.participant.add')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        // Cek apakah user sudah terdaftar
        $user = User::where('member_id', $request->input('memberId'))->first();
        if ($user && Participant::where('user_id', $user->id)->where('is_draft', false)->exists()) {
            return redirect()->route('coordinator.participant.add')->with('error', 'Participant already registered')->withInput();
        }

        // Mengirimkan permintaan API
        $targetUrl = 'https://siamo.pmi.or.id/apimis/control/get_mis.php';
        $response = Http::get($targetUrl, [
            'memberId' => $request->input('memberId'),
            'p' => $provinceId,
            'c' => $cityId
        ]);

        // Menangani respons dari API
        if ($response->successful()) {
            $member = $response->json();
            if (isset($member['data'])) {
                return redirect()->route('coordinator.participant.add')->with('found', json_encode($member['data']))->withInput();
            } else {
                return redirect()->route('coordinator.participant.add')->with('error', 'Data not available')->withInput();
            }
        } else {
            switch ($response->status()) {
                case 404:
                    return redirect()->route('coordinator.participant.add')->with('error', 'Member not found')->withInput();
                case 500:
                    return redirect()->route('coordinator.participant.add')->with('error', 'Server error')->withInput();
                default:
                    return redirect()->route('coordinator.participant.add')->with('error', 'An error occurred')->withInput();
            }
        }
    }

    public function participantRegister(){
        $setting = General::find(1);
        if($setting->last_registration < Date::now()){
            return redirect()->route('coordinator.participant')->with('error', 'Participant registration will be close')->withInput();
        }
        $data = [
            'title' => 'Participant',
            'subTitle' => 'Register',
            'coordinator' => Coordinator::where('user_id', Auth::user()->id)->first(),
            'gender' => Gender::all(),
            'religion' => Religion::all(),
            'bloodType' => BloodType::all(),
            'memberType' => MemberType::all()
        ];
        return view('app.coordinator.participant.register', $data);
    }

    public function participantRegisterStore(Request $request){
        
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,bmp,png,jpg,svg|max:2000',
            'name' => 'required',
            'memberType' => 'required',
            'participantType' => 'required',
            'birthPlace' => 'required',
            'birthDate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'bloodType' => 'required',
            'address' => 'required',
            'health' => 'required|mimes:pdf|max:2000',
            'assignment' => 'required|mimes:pdf|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('coordinator.participant.register')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        $areaCode = str_replace('.', '', $coordinator->contingent->administrative_area_level_2);
        $randomDigits = str_pad(rand(0, 99999999999), 9, '0', STR_PAD_LEFT);
        $memberId = $areaCode . $randomDigits;

        $user = New User();
        $user->member_id = $memberId;
        $user->photo_path = $request->file('photo')->store('user', 'public');
        $user->name = $request->input('name');
        $user->member_type_id = $request->input('memberType');
        $user->birth_place = $request->input('birthPlace');
        $user->birth_date = $request->input('birthDate');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone');
        $user->gender_id = $request->input('gender');
        $user->religion_id = $request->input('religion');
        $user->blood_type_id = $request->input('bloodType');
        $user->address = $request->input('address');
        $user->password = Hash::make($memberId);
        $user->save();

        $participant = New Participant();
        $participant->user_id = $user->id;
        $participant->participant_type_id = $request->input('participantType');
        $participant->contingent_id = $coordinator->contingent->id;
        $participant->health_certificate = $request->file('health')->store('health-certificate', 'public');
        $participant->assignment_letter = $request->file('assignment')->store('assignmment-letter', 'public');
        $participant->is_draft = false;
        $participant->save();

        return redirect()->route('coordinator.participant')->with('success', 'Participant has been added successfully');

    }

    public function participantDestroy($id){
        $setting = General::find(1);
        if($setting->last_registration < Date::now()){
            return redirect()->route('coordinator.participant')->with('error', 'Participant registration will be close')->withInput();
        }
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        $participant = Participant::where('id', $id)->where('contingent_id', $coordinator->contingent->id);
        $participant->delete();
        return redirect()->route('coordinator.participant')->with('success', 'Participant has been deleted successfully');
    }

    public function participantStore(Request $request){
        $setting = General::find(1);
        if($setting->last_registration < Date::now()){
            return redirect()->route('coordinator.participant')->with('error', 'Participant registration will be close')->withInput();
        }
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
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

        $user = User::where('member_id', $data->memberId)->first();
        if (!$user) {
            $user = New User();
            $user->member_id = $data->memberId;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->gender_id = $data->gender->id;
            $user->religion_id = $data->religion->id;
            $user->blood_type_id = $data->bloodType->id ?? 7;
            $user->phone_number = $data->phone;
            $user->birth_place = $data->birthPlace;
            $user->birth_date = $data->birthDate;
            $user->password = Hash::make($data->memberId);
            $user->secretariat_id = $secretariat->id;
            $user->member_type_id = $data->category->id;
            $user->address -> $data->domicile->address ?? null;
            $user->data = $request->input('json');
            $user->joined_at = $data->membership->joinedAt;
            $user->save();
        }

        $participant = Participant::where('user_id', $user->id)->first();
        if(!$participant){
            $participant = New Participant();
            $participant->user_id = $user->id;
            $participant->contingent_id = $coordinator->contingent->id;
            $participant->save();
        }
        return redirect()->route('coordinator.participant.completed', $data->memberId);
    }

    public function participantCompleted($memberId){
        $setting = General::find(1);
        if($setting->last_registration < Date::now()){
            return redirect()->route('coordinator.participant')->with('error', 'Participant registration will be close')->withInput();
        }
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        $user = User::where('member_id', $memberId)
        ->whereHas('participant', function ($query) use ($coordinator) {
            $query->where('contingent_id', $coordinator->contingent->id)->where('is_draft', true);
        })
        ->first();
        if(!$user){
            return redirect()->route('coordinator.participant')->with('error', 'Forbidden')->withInput();
        }
        $data = [
            'title' => 'Participant',
            'subTitle' => 'Completed',
            'coordinator' => Coordinator::where('user_id', Auth::user()->id)->first(),
            'gender' => Gender::all(),
            'religion' => Religion::all(),
            'bloodType' => BloodType::all(),
            'memberType' => MemberType::all(),
            'user' => $user
        ];
        return view('app.coordinator.participant.completed', $data);
    }

    public function participantCompletedStore($memberId, Request $request){
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,bmp,png,jpg,svg|max:2000',
            'participantType' => 'required',
            'bloodType' => 'required',
            'address' => 'required',
            'health' => 'required|mimes:pdf|max:2000',
            'assignment' => 'required|mimes:pdf|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $user = User::where('member_id', $memberId)->first();
        $user->photo_path = $request->file('photo')->store('user', 'public');
        $user->blood_type_id = $request->input('bloodType');
        $user->address = $request->input('address');
        $user->save();

        $participant = Participant::where('user_id', $user->id)->first();
        $participant->participant_type_id = $request->input('participantType');
        $participant->health_certificate = $request->file('health')->store('health-certificate', 'public');
        $participant->assignment_letter = $request->file('assignment')->store('assignmment-letter', 'public');
        $participant->is_draft = false;
        $participant->save();

        return redirect()->route('coordinator.participant')->with('success', 'Participant has been added successfully');
    }

    public function activity(){
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        $activity = ActivityType::with([
            'activities' => function($q) use ($coordinator) {
                $q->orderBy('start')
                ->with([
                    'participantAssignment' => function($q2) use ($coordinator) {
                        $q2->orderBy('created_at')
                            ->with([
                                'participant' => function($q3) use ($coordinator) {
                                    $q3->where('contingent_id', $coordinator->contingent->id)->limit(5);
                                }
                            ]);
                    }
                ]);
            }
        ])->get();

        $data = [
            'title' => 'Activity',
            'subTitle' => null,
            'coordinator' => $coordinator,
            'activities' => $activity
        ];

        // $activity = ActivityType::with('activities')->get();
        // dd($activity);
        return view('app.coordinator.activity.activity', $data);
    }

}
