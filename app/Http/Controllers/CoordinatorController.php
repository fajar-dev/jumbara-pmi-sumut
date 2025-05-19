<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Coordinator;
use App\Models\Participant;
use App\Models\Secretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CoordinatorController extends Controller
{
    public function participant(Request $request){
        $search = $request->input('q');
        $participant = Participant::with('user')
            ->whereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $participant->appends(['q' => $search]);
        $data = [
            'title' => 'Participant',
            'subTitle' => null,
            'participant' => $participant,
            'coordinator' => Coordinator::where('user_id', Auth::user()->id)->first()
        ];
        return view('app.coordinator.participant.participant', $data);
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
        if ($user && Participant::where('user_id', $user->id)->exists()) {
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

    public function participantStore($contingentId, Request $request){
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
            $user->blood_type_id = $data->bloodType->id;
            $user->phone_number = $data->phone;
            $user->birth_place = $data->birthPlace;
            $user->birth_date = $data->birthDate;
            $user->password = Hash::make($data->memberId);
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
            $user->address -> $data->domicile->address;
            $user->data = $request->input('json');
            $user->joined_at = $data->membership->joinedAt;
            $user->save();
        }

        $participant = New Participant();
        $participant->user_id = $user->id;
        $participant->contingent_id = $contingentId;
        $participant->save();
    }

}
