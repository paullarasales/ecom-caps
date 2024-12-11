<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Package;
use App\Models\Blockeddate;
use Illuminate\Support\Facades\DB;

class OwnerAppointmentsPagesController extends Controller
{
    public function calendarView()
    {
        return view('owner.calendar');
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
        $mergedEvents = array_merge($events, $blockedDates);

        return response()->json($mergedEvents);
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
        
        return view('owner.booked', compact('appointments', 'search'));
        // return view('admin.booked');
    }
    public function bookedView(string $app)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'booked')
            ->where('appointment_id', $app)
            ->first();

        if (!$appointment) {
            return redirect()->route('ownerevents')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;
        return view('owner.booked-view')->with([
            'appointment' => $appointment,
            'package' => $appointment->package,  // Directly access the package related to the appointment
            'customPackage' => $customPackage,  // Access the custom package related to the package
        ]);

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
            ->paginate(10);
        
        return view('owner.done', compact('appointments', 'search'));
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
            return redirect()->route('ownervents')->with('error', 'Appointment not found or not pending.');
        }

        // Pass the appointment and its related data (package, custom package with items) to the view

        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        return view('owner.done-view')->with([
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

        $packages = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Custom')
        ->whereDoesntHave('appointment')
        ->paginate(50);
        
        $blockedDates = BlockedDate::pluck('blocked_date')->toArray(); // Fetch all blocked dates
        $bookedDates = Appointment::select('edate')
        ->where('status', 'booked')
        ->groupBy('edate')
        ->having(DB::raw('COUNT(*)'), '=', 3)
        ->pluck('edate')
        ->toArray();

        return view('owner.direct', compact('packages', 'blockedDates', 'bookedDates'));
    }
}
