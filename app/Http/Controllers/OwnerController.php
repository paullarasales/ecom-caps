<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function ownerdashboard()
    {
        return view('owner.dashboard');
    }
    public function ownercalendar()
    {
        return view('owner.calendar');
    }
    public function ownerbooking()
    {
        return view('owner.booking');
    }
    public function ownerchat()
    {
        return view('owner.chat');
    }
}
