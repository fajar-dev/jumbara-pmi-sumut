<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\General;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function faq(Request $request){
        $search = $request->input('q');
        $data = Faq::where('title', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Setting',
            'subTitle' => 'FAQ',
            'page_id' => null,
            'faq' => $data
        ];
        return view('app.setting.faq',  $data);
    }

    public function faqStore(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.setting.faq')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $faq = New Faq();
        $faq->title = $request->input('title');
        $faq->content = $request->input('content');
        $faq->save();

        return redirect()->route('admin.setting.faq')->with('success', 'FAQ has been added successfully');
    }

    public function faqUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.setting.faq')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $faq = Faq::findOrFail($id);
        $faq->title = $request->input('title');
        $faq->content = $request->input('content');
        $faq->save();

        return redirect()->route('admin.setting.faq')->with('success', 'FAQ has been updated successfully');
    }

    public function faqDestroy($id){
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('admin.setting.faq')->with('success', 'FAQ has been deleted successfully');
    }

    
    public function sponsor(Request $request){
        $search = $request->input('q');
        $data = Sponsor::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Setting',
            'subTitle' => 'Sponsor',
            'page_id' => null,
            'sponsor' => $data
        ];
        return view('app.setting.sponsor',  $data);
    }

    public function sponsorStore(Request $request){
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,bmp,png,jpg,svg|max:2000',
            'name' => 'required',
            'url' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.setting.sponsor')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $sponsor = New Sponsor();
        $sponsor->name = $request->input('name');
        $sponsor->logo =  $request->file('logo')->store('setting', 'public');
        $sponsor->url = $request->input('url');
        $sponsor->save();

        return redirect()->route('admin.setting.sponsor')->with('success', 'Sponsor has been added successfully');
    }

    public function sponsorUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'logo' => 'nullable|sometimes|image|mimes:jpeg,bmp,png,jpg,svg|max:2000',
            'name' => 'required',
            'url' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.setting.sponsor')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $sponsor = Sponsor::findOrFail($id);
        $sponsor->name = $request->input('name');
        if($request->has('logo')){
            $sponsor->logo = $request->file('logo')->store('setting', 'public');
        }
        $sponsor->url = $request->input('url');
        $sponsor->save();

        return redirect()->route('admin.setting.sponsor')->with('success', 'Sponsor has been updated successfully');
    }

    public function sponsorDestroy($id){
        $sponsor = Sponsor::findOrFail($id);
        $sponsor->delete();
        return redirect()->route('admin.setting.sponsor')->with('success', 'Sponsor has been deleted successfully');
    }

    public function general(){
        $data = [
            'title' => 'Setting',
            'subTitle' => 'General',
            'page_id' => null,
            'general' => General::findOrFail(1)
        ];
        return view('app.setting.general',  $data);
    }

        public function generalUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'logo' => 'nullable|sometimes|image|mimes:jpeg,bmp,png,jpg,svg|max:2000',
            'guidebook' => 'nullable|sometimes|file|mimes:pdf|max:2000',
            'title' => 'required',
            'subtitle' => 'required',
            'location' => 'required',
            'eventStart' => 'required',
            'eventEnd' =>'required',
            'lastRegistration' =>'required',
            'email' => 'required|email',
            'phone' => 'required',
            'instagram' => 'required',
            'facebook' => 'required',
            'youtube' => 'required',
            'tiktok' => 'required',
            'website' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.setting.general')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $general = General::findOrFail(1);
        $general->title = $request->input('title');
        $general->subtitle = $request->input('subtitle');
        if($request->has('logo')){
            $general->logo = $request->file('logo')->store('setting', 'public');
        }
        if($request->has('guidebook')){
            $general->guidebook = $request->file('guidebook')->store('setting', 'public');
        }
        $general->location = $request->input('location');
        $general->event_start = $request->input('eventStart');
        $general->event_end = $request->input('eventEnd');
        $general->last_registration = $request->input('lastRegistration');
        $general->email = $request->input('email');
        $general->phone = $request->input('phone');
        $general->instagram = $request->input('facebook');
        $general->youtube = $request->input('youtube');
        $general->tiktok = $request->input('tiktok');
        $general->website = $request->input('website');
        $general->save();

        return redirect()->route('admin.setting.general')->with('success', 'General setting has been updated successfully');
    }
}
