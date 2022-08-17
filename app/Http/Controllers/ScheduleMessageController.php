<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleMessageController extends Controller
{
    public function index(){
        return view('pages.scheduleMessage');
    }
}
