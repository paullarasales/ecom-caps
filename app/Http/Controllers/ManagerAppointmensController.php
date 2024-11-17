<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Package;
use App\Models\Blockeddate;
use App\Models\Blockedapp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Models\Log as ModelsLog;

class ManagerAppointmensController extends Controller
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
        //
    }
    public function directsave(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'birthday' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'location' => 'required',
            'edate' => 'required|date|after_or_equal:today',
            'etime' => 'required',
            'type' => 'required',
            'package_id' => 'required|exists:packages,package_id',
        ]);

        // Check if the selected date is blocked
        $blockedDateExists = BlockedDate::where('blocked_date', $request->edate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->route('managerdirect')->with('error', 'The selected date is blocked, please select another date.');
        }

        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'accepted')
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->route('managerdirect')->with('error', 'The selected date is fully booked, please select other date.');
        }

        // Create and save new user
        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->birthday = $request->input('birthday');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->save();

        // Create and save new appointment
        $appointment = new Appointment();
        $appointment->user_id = $user->id; // Set the foreign key
        $appointment->location = $request->input('location');
        $appointment->edate = $request->input('edate');
        $appointment->etime = $request->input('etime');
        $appointment->type = $request->input('type');
        $appointment->package_id = $request->input('package_id');
        $appointment->reference = strtoupper(uniqid('REF'));
        $appointment->status = 'booked'; // Consider using null instead of 'null' if you want it to be a database NULL
        $appointment->save();

        $DateFormatted = Carbon::parse($request->edate)->format('F j, Y');
        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Direct Booked';
            $log->description = $use->firstname . " " . $use->lastname . " directly booked an event on " . $DateFormatted;
            $log->logdate = now();
            $log->save();

        return redirect()->back()->with('alert', 'User and appointment created successfully.');
    }


    public function accept(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Check if package_id is null
        if (is_null($appointment->package_id)) {
            return redirect()->route('manager.pending')->with('error', 'The appointment does not have a package assigned.');
        }

        // Get the date of the appointment
        $appointmentDate = $appointment->edate; // Assuming 'edate' is a field in the appointments table

        // Check if the appointment date is in the past
        if (Carbon::parse($appointmentDate)->isPast()) {
            return redirect()->route('manager.pending')->with('error', 'The selected date is in the past. Please select a valid future date.');
        }

        $blockedDateExists = BlockedDate::where('blocked_date', $appointmentDate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->route('manager.pending')->with('error', 'The selected date is blocked, please select another date.');
        }

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
        $appointment->isread = "unread";
        $appointment->save();

        $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Accepted';
            $log->description = $use->firstname . " " . $use->lastname . " accepted an event on " . $DateFormatted;
            $log->logdate = now();
            $log->save();


        // Get the user who made the appointment
        $user = $appointment->user; // Assuming you have a relation between Appointment and User models

        // Format the appointment date and time
        $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

        // Create the email content
        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>Your event has been booked</h1>
                <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                <p>Thank you for choosing us. Your event details are as follows:</p>
                <div style='border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>
                    <p>
                        <strong>Location:</strong> <span style='color: #555;'>{$appointment->location}</span><br>
                        <strong>Date:</strong> <span style='color: #555;'>{$appointmentDateFormatted}</span><br>
                        <strong>Time:</strong> <span style='color: #555;'>{$appointment->etime}</span><br>
                        <strong>Type:</strong> <span style='color: #555;'>{$appointment->type}</span><br>
                        <strong>Package:</strong> <span style='color: #555;'>{$appointment->package->packagename}</span><br>
                        <strong>Reference Number:</strong> <span style='color: #555;'>{$appointment->reference}</span>
                    </p>
                </div>
                <p>
                    Your event is confirmed and booked for:
                    <strong style='color: #007bff;'>{$appointmentDateFormatted}</strong>.
                    We look forward to making your event special!
                </p>
                <p style='color: #555;'>Thank you for choosing our service!</p>
            </div>
        ";

        try {
            // Send the email
            if (!empty($user->email)) {
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('Your Event Has Been Booked!')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            return redirect()->route('manager.pending')->with('error', 'Failed to send confirmation email.');
        }

        // Redirect back or to a specific route
        // session()->flash('alert', 'Event Successfully Booked');
        return redirect()->route('manager.pending')->with('alert', 'Event Successfully Booked');
    }


    public function rebook(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Check if package_id is null
        if (is_null($appointment->package_id)) {
            return redirect()->route('manager.cancelled')->with('error', 'The appointment does not have a package assigned.');
        }


        // Check if essential fields (edate, etime, location, type) are not null
        if (is_null($appointment->edate) || is_null($appointment->etime) || 
            is_null($appointment->location) || is_null($appointment->type)) {
            return redirect()->route('manager.cancelled')->with('error', 'Appointment details are incomplete. Please make sure all fields are filled.');
        }
        
        // Get the date of the appointment
        $appointmentDate = $appointment->edate; // Assuming 'edate' is a field in the appointments table

        // Check if the appointment date is in the past
        if (Carbon::parse($appointmentDate)->isPast()) {
            return redirect()->route('manager.cancelled')->with('error', 'The selected date is in the past. Please select a valid future date.');
        }

        $blockedDateExists = BlockedDate::where('blocked_date', $appointmentDate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->route('manager.cancelled')->with('error', 'The selected date is blocked, please select another date.');
        }

        // Count the number of accepted appointments on the same date
        $acceptedAppointmentsCount = Appointment::where('edate', $appointmentDate)
                                                    ->where('status', 'booked')
                                                    ->count();

        // Check if the count is less than 3
        if ($acceptedAppointmentsCount >= 3) {
            // Redirect back with an error message
            return redirect("manager/booked")->with('error', 'Date is Fully booked');
        }

        // Update appointment status to "accepted"
        $appointment->status = 'booked';
        $appointment->isread = "unread";
        $appointment->save();

        $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Rebooked';
            $log->description = $use->firstname . " " . $use->lastname . " rebooked an event on " . $DateFormatted;
            $log->logdate = now();
            $log->save();


        // Get the user who made the appointment
        $user = $appointment->user; // Assuming you have a relation between Appointment and User models

        // Format the appointment date and time
        $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

        // Create the email content
        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>Your event has been booked</h1>
                <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                <p>Thank you for choosing us. Your event details are as follows:</p>
                <div style='border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>
                    <p>
                        <strong>Location:</strong> <span style='color: #555;'>{$appointment->location}</span><br>
                        <strong>Date:</strong> <span style='color: #555;'>{$appointmentDateFormatted}</span><br>
                        <strong>Time:</strong> <span style='color: #555;'>{$appointment->etime}</span><br>
                        <strong>Type:</strong> <span style='color: #555;'>{$appointment->type}</span><br>
                        <strong>Package:</strong> <span style='color: #555;'>{$appointment->package->packagename}</span><br>
                        <strong>Reference Number:</strong> <span style='color: #555;'>{$appointment->reference}</span>
                    </p>
                </div>
                <p>
                    Your event is confirmed and booked for:
                    <strong style='color: #007bff;'>{$appointmentDateFormatted}</strong>.
                    We look forward to making your event special!
                </p>
                <p style='color: #555;'>Thank you for choosing our service!</p>
            </div>
        ";

        try {
            // Send the email
            if (!empty($user->email)) {
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('Your Event Has Been Re-Booked!')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            return redirect()->route('manager.cancelled')->with('error', 'Failed to send confirmation email.');
        }

        // Redirect back or to a specific route
        return redirect()->route('manager.cancelled')->with('alert', 'Event Successfully Re-booked');
    }


    public function done(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Check if the edate is at least one day in the future
        // Check if the edate is today
        $edate = Carbon::parse($appointment->edate);

        // Check if the edate is today
        if ($edate->isToday() || $edate->isPast()) {
            // Update appointment status to "done"
            $appointment->status = 'done';
            $appointment->isread = "unread";
            $appointment->save();

            $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
            $use = Auth::user();

                $log = new ModelsLog();
                $log->user_id = Auth::id();
                $log->action = 'Done';
                $log->description = $use->firstname . " " . $use->lastname . " markeed an event on " . $DateFormatted . " as done";
                $log->logdate = now();
                $log->save();

            // Get the user who made the appointment
            $user = $appointment->user; // Assuming you have a relation between Appointment and User models

            // Format the appointment date and time
            $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

            // Create the email content
            $emailContent = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>Your event has been done</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p>Thank you for choosing The Siblings Catering Services. We look forward on making your next event wonderful.</p>
                    <p>You can now make reviews.</p>
                    <p style='color: #555;'>Thank you for choosing our service!</p>
                </div>
            ";

            try {
                // Send the email
                if (!empty($user->email)) {
                    Mail::send([], [], function ($message) use ($user, $emailContent) {
                        $message->to($user->email)
                                ->subject('Your Event Has Been Done!')
                                ->html($emailContent);
                    });
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                return redirect()->route('manager.booked')->with('error', 'Failed to send confirmation email.');
            }
    
            // Redirect back or to a specific route
            return redirect("manager/booked")->with('alert', 'Event moved to done');
        } else {
            // Redirect back or to a specific route with an error message
            return redirect("manager/booked")->with('error', 'The event is not yet finished');
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
            $appointment->isread = "unread";
            $appointment->save();

            $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
            $use = Auth::user();

                $log = new ModelsLog();
                $log->user_id = Auth::id();
                $log->action = 'Cancelled';
                $log->description = $use->firstname . " " . $use->lastname . " cancelled an event on " . $DateFormatted;
                $log->logdate = now();
                $log->save();

            // Get the user who made the appointment
            $user = $appointment->user; // Assuming you have a relation between Appointment and User models

            // Format the appointment date and time
            $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

            // Create the email content
            $emailContent = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>Your event has been cancelled</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p>Your event on {$appointmentDateFormatted}.</p>
                    <p>We look forward on making your next event wonderful.</p>
                    <p style='color: #555;'>Message us on our Facebook page or on our Website if you want your event to be re-booked</p>
                </div>
            ";

            try {
                // Send the email
                if (!empty($user->email)) {
                    Mail::send([], [], function ($message) use ($user, $emailContent) {
                        $message->to($user->email)
                                ->subject('Your Event Has Been Cancelled')
                                ->html($emailContent);
                    });
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                return redirect()->route('manager.booked')->with('error', 'Failed to send confirmation email.');
            }

            // Redirect back or to a specific route
            return redirect("manager/booked")->with('alert', 'Event has been canceled');
        } else {
            // Redirect back or to a specific route with an error message
            return redirect("manager/booked")->with('error', 'The event is not eligible for cancellation.');
        }
    }



    public function cancelmeeting(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);



            // Update appointment status to "cancelled"
            $appointment->status = 'cancelled';
            $appointment->isread = "unread";
            $appointment->save();

            $DateFormatted = Carbon::parse($appointment->appointment_datetime)->format('F j, Y g:i A');
            $use = Auth::user();

                $log = new ModelsLog();
                $log->user_id = Auth::id();
                $log->action = 'Cancelled';
                $log->description = $use->firstname . " " . $use->lastname . " cancelled a meeting on " . $DateFormatted;
                $log->logdate = now();
                $log->save();


            // Get the user who made the appointment
            $user = $appointment->user; // Assuming you have a relation between Appointment and User models

            // Format the appointment date and time
            $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

            // Create the email content
            $emailContent = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>Your event request has been cancelled</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p>We look forward on making your next event wonderful.</p>
                    <p style='color: #555;'>Message us on our Facebook page or on our Website if you want your event to be re-booked</p>
                </div>
            ";

            try {
                // Send the email
                if (!empty($user->email)) {
                    Mail::send([], [], function ($message) use ($user, $emailContent) {
                        $message->to($user->email)
                                ->subject('Your Event Request Has Been Cancelled')
                                ->html($emailContent);
                    });
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                return redirect()->route('manager.pending')->with('error', 'Failed to send confirmation email.');
            }

            // Redirect back or to a specific route
            return redirect("manager/pending")->with('alert', 'Event has been canceled');
    }



    public function detailsedit(string $appointment_id)
    {
        $packages = Package::orderBy('created_at', 'desc')->paginate(30);
        $appointment = Appointment::find($appointment_id);

        return view('manager.booked-edit', compact('packages', 'appointment'));
    }
    public function save(Request $request, string $appointment_id)
    {
        $request->validate([
            'location' => 'required',
            'edate' => 'required|date|after_or_equal:today',
            'etime' => 'required',
            'type' => 'required',
            'package_id' => 'required|exists:packages,package_id',
        ]);

        $appointment = Appointment::findOrFail($appointment_id);
        
        // Update appointment details
        $appointment->location = $request->input('location');
        $appointment->edate = $request->input('edate');
        $appointment->etime = $request->input('etime');
        $appointment->type = $request->input('type');
        $appointment->package_id = $request->input('package_id');

        // Save the updated appointment
        $appointment->save();

        $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
            $use = Auth::user();

                $log = new ModelsLog();
                $log->user_id = Auth::id();
                $log->action = 'Edited';
                $log->description = $use->firstname . " " . $use->lastname . " edited an event on " . $DateFormatted;
                $log->logdate = now();
                $log->save();


        // Redirect back or to a success page
        return redirect()->back()->with('alert', 'Event updated successfully!');
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
    public function destroy(string $appointment_id)
    {
        // Find the appointment by its ID
        $appointment = Appointment::findOrFail($appointment_id);

        // Optionally check if the status is something other than 'done' if necessary
        if ($appointment->status === 'done') {
            // You can redirect back or return an error message if deletion is not allowed
            return redirect()->route('manager.pending')->with('error', 'Completed appointments cannot be deleted.');
        }

        // Delete the appointment
        $appointment->delete();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Meeting Date Unblocked';
            $log->description = $use->firstname . " " . $use->lastname . " Has deleted a meeting that either couldn't be completed or where the client did not attend. " ;
            $log->logdate = now();
            $log->save();

        // Redirect back or to another route with a success message
        return redirect()->route('manager.pending')->with('success', 'Appointment deleted successfully.');
    }

    public function destroyMeeting(string $appointment_id)
    {
         // Find the appointment by its ID
        $appointment = Appointment::findOrFail($appointment_id);

        // Optionally check if the status is something other than 'done' if necessary
        if ($appointment->status === 'done') {
            // You can redirect back or return an error message if deletion is not allowed
            return redirect()->route('manager.cancelledMeeting')->with('error', 'Completed appointments cannot be deleted.');
        }

        // Delete the appointment
        $appointment->delete();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Meeting Date Unblocked';
            $log->description = $use->firstname . " " . $use->lastname . " Has deleted a meeting that either couldn't be completed or where the client did not attend. " ;
            $log->logdate = now();
            $log->save();

        // Redirect back or to another route with a success message
        return redirect()->route('manager.cancelledMeeting')->with('success', 'Appointment deleted successfully.');
    }

    public function block(Request $request)
    {
        $request->validate([
            'blocked_date' => 'required|date|unique:blockeddates,blocked_date',
            'reason' => 'nullable|string|max:255',
        ]);

        // Save the blocked date and reason to the database
        BlockedDate::create([
            'blocked_date' => $request->blocked_date,
            'reason' => $request->reason,
        ]);


        $unblockedDateFormatted = Carbon::parse($request->blocked_date)->format('F j, Y');

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Event Date Blocked';
            $log->description = $unblockedDateFormatted . " Has been blocked by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->back()->with('alert', 'Date blocked successfully!');
    }
    public function unblock(Request $request)
    {
        $request->validate([
            'unblocked_date' => 'required|date',
        ]);

        // Get the date to unblock
        $unblockedDate = $request->input('unblocked_date');

        // Logic to unblock the date (assuming you have a model for appointments)
        // For example, if you have a `BlockedDate` model that tracks blocked dates:
        BlockedDate::where('blocked_date', $unblockedDate)->delete();

        $unblockedDateFormatted = Carbon::parse($unblockedDate)->format('F j, Y');

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Event Date Unblocked';
            $log->description = $unblockedDateFormatted . " Has been unblocked by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

        // Optional: Return a response or redirect with a success message
        return redirect()->back()->with('alert', 'Date unblocked successfully!');
    }

    public function appblock(Request $request)
    {
        $request->validate([
            'blocked_app' => 'required|date|unique:blockedapps,blocked_app',
            'appreason' => 'nullable|string|max:255',
        ]);

        // Save the blocked date and reason to the database
        Blockedapp::create([
            'blocked_app' => $request->blocked_app,
            'appreason' => $request->appreason,
        ]);

        $unblockedDateFormatted = Carbon::parse($request->blocked_date)->format('F j, Y');

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Meeting Date Blocked';
            $log->description = $unblockedDateFormatted . " Has been blocked by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->back()->with('alert', 'Date blocked successfully!');
    }
    public function appunblock(Request $request)
    {
        $request->validate([
            'unblocked_app' => 'required|date',
        ]);

        // Get the date to unblock
        $unblockedDate = $request->input('unblocked_app');

        // Logic to unblock the date (assuming you have a model for appointments)
        // For example, if you have a `BlockedDate` model that tracks blocked dates:
        Blockedapp::where('blocked_app', $unblockedDate)->delete();


        $unblockedDateFormatted = Carbon::parse($unblockedDate)->format('F j, Y');

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Meeting Date Unblocked';
            $log->description = $unblockedDateFormatted . " Has been unblocked by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

        // Optional: Return a response or redirect with a success message
        return redirect()->back()->with('alert', 'Date unblocked successfully!');
    }
}
