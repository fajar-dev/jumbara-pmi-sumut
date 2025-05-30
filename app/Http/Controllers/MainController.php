<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\News;
use App\Models\Activity;
use App\Models\Contingent;
use App\Models\Participant;

class MainController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Home',
            'subTitle' => null,
            'page_id' => null,
            'news' => News::orderby('created_at', 'desc')->limit(5)->get(),
            'activity' => Activity::orderby('activity_type_id', 'asc')->get(),
            'faq' => Faq::orderby('created_at', 'desc')->get(),
            'participantCount' => Participant::where('is_draft', false)->count(),
            'contingentCount' => Contingent::count(),
            'activityCount' => Activity::count(),
        ];

        return view('main.index',  $data);
    }
}
