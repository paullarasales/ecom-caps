<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Package;
use App\Models\Blockeddate;

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
        return view('manager.meetingCalendar');
    }

    public function direct()
    {
        // $packages = Package::orderBy('created_at', 'desc')->paginate(30);
        // return view('admin.direct', compact('packages'));

        $packages = Package::orderBy('created_at', 'desc')->paginate(50);
        $blockedDates = BlockedDate::pluck('blocked_date')->toArray(); // Fetch all blocked dates

        return view('manager.direct', compact('packages', 'blockedDates'));
    }
}
