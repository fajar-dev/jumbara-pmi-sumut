<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function announcement(Request $request){
        $search = $request->input('q');
        $data = Announcement::where('title', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Announcement',
            'subTitle' => null,
            'page_id' => null,
            'announcement' => $data
        ];
        return view('app.announcement.announcement',  $data);
    }

    public function announcementAdd(){
        $data = [
            'title' => 'Announcement',
            'subTitle' => 'Add',
            'page_id' => null,
        ];
        return view('app.announcement.add-announcement',  $data);
    }

    public function announcementStore(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'nullable|sometimes|mimes:jpeg,bmp,png,jpg,svg,pdf,doc,docx,ppt,pptx,xls,xlsx',
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.announcement.add')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $announcement = New Announcement();
        $announcement->title = $request->input('title');
        if($request->has('file')){
            $announcement->file_path =  $request->file('file')->store('announcement', 'public');
        }
        $announcement->content = $request->input('content');
        $announcement->user_id = Auth::user()->id;
        $announcement->save();

        return redirect()->route('admin.announcement')->with('success', 'Announcement has been added successfully');
    }

    public function announcementEdit($id){
        $data = [
            'title' => 'Announcement',
            'subTitle' => 'Edit',
            'page_id' => null,
            'announcement' => Announcement::findOrFail($id),
        ];
        return view('app.announcement.edit-announcement',  $data);
    }

    public function announcementUpdate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'nullable|sometimes|mimes:jpeg,bmp,png,jpg,svg,pdf,doc,docx,ppt,pptx,xls,xlsx',
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.announcement.edit', $id)->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $announcement = Announcement::findOrFail($id);
        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');
        if($request->has('file')){
            $announcement->file_path =  $request->file('file')->store('announcement', 'public');
        }
        $announcement->save();

        return redirect()->route('admin.announcement')->with('success', 'Announcement has been updated successfully');
    }

    public function announcementDestroy($id){
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return redirect()->route('admin.announcement')->with('success', 'Announcement has been deleted successfully');
    }
}
