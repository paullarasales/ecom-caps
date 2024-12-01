<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Package;
use App\Models\Blockeddate;
use App\Models\Blockedapp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ManagerAppointmentsPagesController extends Controller
{
    public function calendarView()
    {
        return view('manager.calendar');
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
        })->toArray();

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
        })->toArray();
    
        // Merge both appointments and blocked dates into one collection
        // $mergedEvents = $events->merge($blockedDates);
        $mergedEvents = array_merge($events, $blockedDates);

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
    })->toArray();

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
    })->toArray();

    // Merge both appointments and blocked dates into one collection
    $mergedEvents = array_merge($events, $blockedDates);
    
    return response()->json($mergedEvents);
    }
    public function meetingCalendarView() 
    {
        return view('manager.meetingCalendar');
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
            ->orderBy('edate', 'asc')
            ->paginate(10);
        
        return view('manager.booked', compact('appointments', 'search'));
        // return view('admin.booked');
    }
    public function bookedView(string $app)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'booked')
            ->where('appointment_id', $app)
            ->first();

        if (!$appointment) {
            return redirect()->route('managerappointments')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;
        return view('manager.booked-view')->with([
            'appointment' => $appointment,
            'package' => $appointment->package,  // Directly access the package related to the appointment
            'customPackage' => $customPackage,  // Access the custom package related to the package
        ]);

    }


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
            ->orderBy('edate', 'asc')
            ->paginate(10);
        
        return view('manager.pending', compact('appointments', 'search'));
    }
    public function pendingView(string $app)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'pending')
            ->where('appointment_id', $app)
            ->first();

        if (!$appointment) {
            return redirect()->route('managerappointments')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;
        return view('manager.pending-view')->with([
            'appointment' => $appointment,
            'package' => $appointment->package,  // Directly access the package related to the appointment
            'customPackage' => $customPackage,  // Access the custom package related to the package
        ]);

        // return view('admin.pending-view');
    }


    public function cancelled()
    {
        $search = request('search');

        $appointments = Appointment::with('user')
            ->where('status', 'cancelled')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%");
                });
            })
            ->orderBy('edate', 'asc')
            ->paginate(10);
        
        return view('manager.cancelled', compact('appointments', 'search'));
        // return view('admin.cancelled');
    }
    public function cancelledView(string $app)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'cancelled')
            ->where('appointment_id', $app)
            ->first();

        if (!$appointment) {
            return redirect()->route('managerappointments')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;
        return view('manager.cancelled-view')->with([
            'appointment' => $appointment,
            'package' => $appointment->package,  // Directly access the package related to the appointment
            'customPackage' => $customPackage,  // Access the custom package related to the package
        ]);

            // return view('admin.pending-view');
    }


    public function cancelledMeeting()
    {
        $search = request('search');

        $appointments = Appointment::with('user')
            ->where('status', 'mcancelled')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%");
                });
            })
            ->orderBy('edate', 'asc')
            ->paginate(10);
        
        return view('manager.cancelled-meeting', compact('appointments', 'search'));
        // return view('admin.cancelled');
    }

    public function cancelledmeetingView(string $app)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'mcancelled')
            ->where('appointment_id', $app)
            ->first();

        if (!$appointment) {
            return redirect()->route('managerappointments')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view

        $customPackage = $appointment->package ? $appointment->package->custompackage : null;
        return view('manager.cancelled-meeting-view')->with([
            'appointment' => $appointment,
            'package' => $appointment->package,  // Directly access the package related to the appointment
            'customPackage' => $customPackage,  // Access the custom package related to the package
        ]);

            // return view('admin.pending-view');
    }


    public function done()
    {
        $search = request('search');

        $appointments = Appointment::with('user')
            ->where('status', 'done')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%");
                });
            })
            ->orderBy('edate', 'asc')
            ->paginate(10);
        
        return view('manager.done', compact('appointments', 'search'));
        // return view('admin.done');
    }
    public function doneView(string $app)
    {
        // $appointment = Appointment::with(['user', 'package'])
        // ->where('status', 'done')
        // ->where('appointment_id', $app)
        // ->first();

        // if (!$appointment) {
        //     return redirect()->route('managerappointments')->with('error', 'Appointment not found or not pending.');
        // }

        // return view('manager.done-view', compact('appointment'));

        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'done')
            ->where('appointment_id', $app)
            ->first();

        if (!$appointment) {
            return redirect()->route('managerappointments')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view

        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        return view('manager.done-view')->with([
            'appointment' => $appointment,
            'package' => $appointment->package,  // Directly access the package related to the appointment
            'customPackage' => $customPackage,  // Access the custom package related to the package
        ]);

            // return view('admin.pending-view');
    }


    public function archived()
    {
        $search = request('search');

        $appointments = Appointment::with('user')
            ->where('status', 'archived')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%");
                });
            })
            ->orderBy('edate', 'asc')
            ->paginate(10);
        
        return view('manager.archived', compact('appointments', 'search'));
        // return view('admin.done');
    }
    public function archivedView(string $app)
    {
        // $appointment = Appointment::with(['user', 'package'])
        // ->where('status', 'done')
        // ->where('appointment_id', $app)
        // ->first();

        // if (!$appointment) {
        //     return redirect()->route('adminappointments')->with('error', 'Appointment not found or not pending.');
        // }

        // return view('admin.done-view', compact('appointment'));

        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'archived')
            ->where('appointment_id', $app)
            ->first();

        if (!$appointment) {
            return redirect()->route('managerappointments')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view

        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        return view('manager.archived-view')->with([
            'appointment' => $appointment,
            'package' => $appointment->package,  // Directly access the package related to the appointment
            'customPackage' => $customPackage,  // Access the custom package related to the package
        ]);

            // return view('admin.pending-view');
    }

    

    public function direct()
    {
        // $packages = Package::orderBy('created_at', 'desc')->paginate(30);
        // return view('admin.direct', compact('packages'));

        $packages = Package::orderBy('created_at', 'desc')->paginate(50);
        $blockedDates = BlockedDate::pluck('blocked_date')->toArray(); // Fetch all blocked dates
        $bookedDates = Appointment::select('edate')
        ->where('status', 'booked')
        ->groupBy('edate')
        ->having(DB::raw('COUNT(*)'), '=', 3)
        ->pluck('edate')
        ->toArray();

        return view('manager.direct', compact('packages', 'blockedDates', 'bookedDates'));
    }
}
