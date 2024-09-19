<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required',
            'edate' => 'required|date|after_or_equal:today',
            'etime' => 'required',
            'type' => 'required',
            'package_id' => 'required|exists:packages,package_id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        // Check if there are already 3 accepted event on the same date
        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'accepted')
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->route('book-form')->with('alert', 'The selected date is fully booked, please select other date.');
        }

        // Check if the user already has 1 pending requests
        $pendingAppointmentsCount = Appointment::where('user_id', Auth::id())
                                                ->where('status', 'pending')
                                                ->count();
    
        if ($pendingAppointmentsCount >= 1) {
            // Redirect back with an error message
            return redirect()->route('book-form')->with('alert', 'You can have only 1 pending request.');
        }

        // Combine appointment date and time
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time);

        // Check if there is an existing appointment at the same date and time with a pending status
        $conflictingAppointment = Appointment::where('appointment_datetime', $dateTime)
                                            ->where('status', 'pending') // Only check for pending status
                                            ->first();

        if ($conflictingAppointment) {
            // Redirect back with an error message
            return redirect()->route('book-form')->with('alert', 'There is already a pending appointment scheduled at this date and time.');
        }

        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time);
        $appointment = new Appointment($request->all());
        $appointment->user_id = Auth::id();
        $appointment->theme ='undefined';
        $appointment->appointment_datetime = $dateTime;
        $appointment->package_id = $request->package_id;
        // Generate a unique reference
        $appointment->reference = strtoupper(uniqid('APP'));
        $appointment->adate = now();
        $appointment->atime = 'null';
        $appointment->save();

        return redirect()->route('dashboard')->with('alert', 'Request Submitted');
    }
    


    //STATUS
    public function accept(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Get the date of the appointment
        $appointmentDate = $appointment->edate; // Assuming 'edate' is a field in the appointments table

        // Count the number of accepted appointments on the same date
        $acceptedAppointmentsCount = Appointment::where('edate', $appointmentDate)
                                                    ->where('status', 'booked')
                                                    ->count();

        // Check if the count is less than 3
        if ($acceptedAppointmentsCount >= 3) {
            // Redirect back with an error message
            return redirect("admin/pending")->with('error', 'Date is Fully booked');
        }

        // Update appointment status to "accepted"
        $appointment->status = 'booked';
        $appointment->save();

        // Redirect back or to a specific route
        return redirect("admin/pending")->with('alert', 'Request Successfully Accepted');
    }
    public function done(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Check if the edate is at least one day in the future
        // Check if the edate is today
        $edate = Carbon::parse($appointment->edate);

        // Check if the edate is today
        if ($edate->isToday()) {
            // Update appointment status to "done"
            $appointment->status = 'done';
            $appointment->save();
    
            // Redirect back or to a specific route
            return redirect("admin/booked")->with('alert', 'Event moved to done');
        } else {
            // Redirect back or to a specific route with an error message
            return redirect("admin/booked")->with('error', 'The event is not yet finished');
        }
    }
    public function cancel(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

            // Parse the edate
        $edate = Carbon::parse($appointment->edate);

        // Get today's date
        $today = Carbon::today();

        // Calculate the date 3 days before the edate
        $threeDaysBeforeEdate = $edate->copy()->subDays(3);

        // Check if the edate is at least 3 days in the future compared to today
        if ($edate->greaterThanOrEqualTo($today->addDays(3))) {
            // Update appointment status to "cancelled"
            $appointment->status = 'cancelled';
            $appointment->save();

            // Redirect back or to a specific route
            return redirect("admin/booked")->with('alert', 'Event has been canceled');
        } else {
            // Redirect back or to a specific route with an error message
            return redirect("admin/booked")->with('error', 'The event is not eligible for cancellation.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
