<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Package;

class AppointmentsPagesController extends Controller
{
    public function calendarView()
    {
        return view('admin.calendar');
    }
    public function calendar()
    {
        $events = Appointment::with('package')
        ->whereIn('status', ['booked', 'pending', 'cancelled', 'done'])
        ->get()
        ->map(function ($event) {
        $color = '';

        // Assign colors based on status
        switch ($event->status) {
            case 'booked':
                $color = '#28a745'; // Green
                break;
            case 'pending':
                $color = '#ffc107'; // Yellow
                break;
            case 'cancelled':
                $color = '#dc3545'; // Red
                break;
            case 'done':
                $color = '#17a2b8'; // Blue
                break;
        }

        return [
            'id' => $event->appointment_id,
            'title' => $event->type . ' - ' . ($event->package ? $event->package->packagename : 'No Package'),
            'start' => $event->edate,
            'color' => $color,  // Include the color in the event data
        ];
    });

    return response()->json($events);
    }

    public function meetingCalendar() 
    {
        $events = Appointment::with(['user', 'package'])
        ->whereIn('status', [ 'pending',])
        ->get()
        ->map(function ($event) {
        $color = '';

        // Assign colors based on status
        switch ($event->status) {
            case 'booked':
                $color = '#28a745'; // Green
                break;
            case 'pending':
                $color = '#ffc107'; // Yellow
                break;
            case 'cancelled':
                $color = '#dc3545'; // Red
                break;
            case 'done':
                $color = '#48CFCB'; // Blue
                break;
        }

        return [
            'id' => $event->appointment_id,
            'title' => $event->type,
            'info' => $event->user->firstname . '  ' . $event->user->lastname ,
            'start' => $event->appointment_datetime,
            'color' => $color,  // Include the color in the event data
        ];
    });

    return response()->json($events);
    }
    public function meetingCalendarView() 
    {
        return view('admin.meetingCalendar');
    }




    public function booked()
    {
        $appointments = Appointment::with('user')
        ->where('status', 'booked')
        ->paginate(10);
        
        return view('admin.booked', compact('appointments'));
        // return view('admin.booked');
    }
    public function bookedView(string $app)
    {
        $appointment = Appointment::with(['user', 'package'])
        ->where('status', 'booked')
        ->where('appointment_id', $app)
        ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not pending.');
        }

        return view('admin.booked-view', compact('appointment'));

    }


    //PENDING
    public function pending()
    {
        
        $appointments = Appointment::with('user')
        ->where('status', 'pending')
        ->paginate(10);
        
        return view('admin.pending', compact('appointments'));

        // return view('admin.pending');
    }
    public function pendingView(string $app)
    {
        $appointment = Appointment::with(['user', 'package'])
        ->where('status', 'pending')
        ->where('appointment_id', $app)
        ->first();

    if (!$appointment) {
        return redirect()->route('adminappointments')->with('error', 'Appointment not found or not pending.');
    }

    return view('admin.pending-view', compact('appointment'));

        // return view('admin.pending-view');
    }



    public function approved()
    {
        $appointments = Appointment::with('user')
        ->where('status', 'approved')
        ->paginate(10);
        
        return view('admin.approved', compact('appointments'));
        // return view('admin.approved');
    }
    public function returned()
    {
        return view('admin.returned');
    }
    public function cancelled()
    {
        $appointments = Appointment::with('user')
        ->where('status', 'cancelled')
        ->paginate(10);
        
        return view('admin.cancelled', compact('appointments'));
        // return view('admin.cancelled');
    }
    public function done()
    {
        $appointments = Appointment::with('user')
        ->where('status', 'done')
        ->paginate(10);
        
        return view('admin.done', compact('appointments'));
        // return view('admin.done');
    }

    public function direct()
    {
        $packages = Package::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.direct', compact('packages'));
    }
}
