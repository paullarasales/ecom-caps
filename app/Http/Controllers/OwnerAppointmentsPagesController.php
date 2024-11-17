<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Package;
use App\Models\Blockeddate;

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
}
