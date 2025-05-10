<?php

namespace App\Http\Controllers;

use App\Models\Contingent;
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
        // dd($data);
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
}
