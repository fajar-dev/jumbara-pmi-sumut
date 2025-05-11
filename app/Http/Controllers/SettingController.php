<?php

namespace App\Http\Controllers;

use App\Models\Faq;
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
}
