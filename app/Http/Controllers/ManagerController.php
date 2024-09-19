<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function managerdashboard()
    {
        return view('manager.dashboard');
    }
    public function managerappointments()
    {
        return view('manager.appointments');
    }
    public function managerreviews()
    {
        return view('manager.reviews');
    }
    public function managerpackages()
    {
        return view('manager.packages');
    }
    public function managerusers()
    {
        return view('manager.users');
    }
    public function managerchat()
    {
        return view('manager.chat');
    }
}
