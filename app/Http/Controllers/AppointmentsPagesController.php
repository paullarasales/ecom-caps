<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Package;
use App\Models\Blockeddate;
use App\Models\Blockedapp;

class AppointmentsPagesController extends Controller
{
    public function calendarView()
    {
        return view('admin.calendar');
    }
    public function calendar()
    {
        $events = Appointment::with('package')
            ->whereIn('status', ['booked', 'pending', 'done'])
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
                'title' => $event->type . ' - ' .$event->status . ' - ' . ($event->package ? $event->package->packagename : 'No Package'),
                'start' => $event->edate,
                'color' => $color,  // Include the color in the event data
            ];
        });

        $blockedDates = BlockedDate::all()->map(function ($blocked) {
            return [
                'id' => $blocked->blocked_id,
                'title' => 'Blocked: ' . ($blocked->reason ? $blocked->reason : 'Unavailable'),
                'start' => $blocked->blocked_date,
                'display' => 'background',  // Set as a background event
                'backgroundColor' => '#1E201E', // Grey fill for blocked dates
                'borderColor' => '#6c757d',  // Optional: No border color (same as fill)
                'allDay' => true,  // Blocked dates are generally full-day events
                'classNames' => ['blocked-event'], 
            ];
        });
    
        // Merge both appointments and blocked dates into one collection
        $mergedEvents = $events->merge($blockedDates);

        return response()->json($mergedEvents);
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
            'title' => $event->user->firstname . '  ' . $event->user->lastname,
            'info' => $event->type,
            'start' => $event->appointment_datetime,
            'color' => $color,  // Include the color in the event data
        ];
    });

    $blockedDates = Blockedapp::all()->map(function ($blocked) {
        return [
            'id' => $blocked->blockedapp_id,
            'title' => 'Blocked: ' . ($blocked->appreason ? $blocked->appreason : 'Unavailable'),
            'start' => $blocked->blocked_app,
            'display' => 'background',  // Set as a background event
            'backgroundColor' => '#1E201E', // Grey fill for blocked dates
            'borderColor' => '#6c757d',  // Optional: No border color (same as fill)
            'allDay' => true,  // Blocked dates are generally full-day events
            'classNames' => ['blocked-event'], 
        ];
    });

    // Merge both appointments and blocked dates into one collection
    $mergedEvents = $events->merge($blockedDates);

    return response()->json($mergedEvents);
    }
    public function meetingCalendarView() 
    {
        return view('admin.meetingCalendar');
    }




    public function booked()
    {
        // $appointments = Appointment::with('user')
        // ->where('status', 'booked')
        // ->paginate(10);

        $search = request('search');

        $appointments = Appointment::with('user')
            ->where('status', 'booked')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%");
                });
            })
            ->paginate(10);
        
        return view('admin.booked', compact('appointments', 'search'));
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
        $search = request('search');

        $appointments = Appointment::with('user')
            ->where('status', 'pending')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%");
                });
            })
            ->paginate(10);
        
        return view('admin.pending', compact('appointments', 'search'));
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
    public function cancelledView(string $app)
    {
        $appointment = Appointment::with(['user', 'package'])
        ->where('status', 'cancelled')
        ->where('appointment_id', $app)
        ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not pending.');
        }

        return view('admin.cancelled-view', compact('appointment'));

            // return view('admin.pending-view');
    }
    public function done()
    {
        $appointments = Appointment::with('user')
        ->where('status', 'done')
        ->paginate(10);
        
        return view('admin.done', compact('appointments'));
        // return view('admin.done');
    }
    public function doneView(string $app)
    {
        $appointment = Appointment::with(['user', 'package'])
        ->where('status', 'done')
        ->where('appointment_id', $app)
        ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not pending.');
        }

        return view('admin.done-view', compact('appointment'));

            // return view('admin.pending-view');
    }

    public function direct()
    {
        // $packages = Package::orderBy('created_at', 'desc')->paginate(30);
        // return view('admin.direct', compact('packages'));

        $packages = Package::orderBy('created_at', 'desc')->paginate(50);
        $blockedDates = BlockedDate::pluck('blocked_date')->toArray(); // Fetch all blocked dates

        return view('admin.direct', compact('packages', 'blockedDates'));
    }
}
