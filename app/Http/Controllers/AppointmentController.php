<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Blockedapp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Package;
use App\Models\Blockeddate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

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
            'appointment_date' => [
            'required',
            'date',
            'before_or_equal:' . Carbon::parse($request->edate)->subDays(7)->toDateString(), // Ensure appointment_date is at least 7 days before edate
        ],
            'appointment_time' => 'required|date_format:H:i',
        ]);

        // Check if the selected date is blocked
        $blockedDateExists = BlockedDate::where('blocked_date', $request->edate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->route('book-form')->with('error', 'The selected date is blocked, please select another date.');
        }

        // Check if there are already 3 accepted event on the same date
        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'booked')
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
        $appointment->appointment_datetime = $dateTime;
        $appointment->package_id = $request->package_id;
        // Generate a unique reference
        $appointment->reference = strtoupper(uniqid('REF'));
        $appointment->save();

        // Email logic directly in the controller
        $user = Auth::user();

        $appointmentDate = \Carbon\Carbon::parse($appointment->edate)->format('F j, Y'); // e.g., September 21, 2024
        $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y h:i A'); // e.g., September 21, 2024 02:30 PM

        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>Your appointment request has been received!</h1>
                <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                <p>Thank you for your request. Your appointment details are as follows:</p>
                <div style='border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>
                    <p>
                        <strong>Location:</strong> <span style='color: #555;'>{$appointment->location}</span><br>
                        <strong>Date:</strong> <span style='color: #555;'>{$appointmentDate}</span><br>
                        <strong>Time:</strong> <span style='color: #555;'>{$appointment->etime}</span><br>
                        <strong>Package:</strong> <span style='color: #555;'>{$appointment->package->packagename}</span><br>
                        <strong>Reference Number:</strong> <span style='color: #555;'>{$appointment->reference}</span>
                    </p>
                </div>
                <p>
                    Kindly arrive on <strong style='color: #007bff;'>{$appointmentDateTime}</strong> 
                    to ensure all final details of your event are confirmed. We recommend arriving at least 15 minutes early to allow for any last-minute preparations.
                </p>
                <p style='color: #555;'>Thank you for choosing our service!</p>
            </div>
        ";


        // Send email using html method
        Mail::send([], [], function ($message) use ($user, $emailContent) {
            $message->to($user->email)
                    ->subject('Your Appointment Request Received')
                    ->html($emailContent); // Use html() method for setting HTML body
        });

        return redirect()->route('book-form')->with('alert', 'Request Submitted. Your reference number is ' . $appointment->reference);
    }


    public function meeting(Request $request)
    {
        $request->validate([
            'appointment_date' => [
            'required',
            'date',
             // Ensure appointment_date is at least 7 days before edate
        ],
            'appointment_time' => 'required|date_format:H:i',
        ]);

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
        $appointment->appointment_datetime = $dateTime;
        $appointment->reference = strtoupper(uniqid('REF'));
        $appointment->save();

        // Email logic directly in the controller
        $user = Auth::user();

        $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y h:i A'); 

        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>Your appointment request has been received!</h1>
                <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                <p>Thank you for your request. Your appointment details are as follows:</p>
                <div style='border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>
                    <p>
                        <strong>Reference Number:</strong> <span style='color: #555;'>{$appointment->reference}</span>
                    </p>
                </div>
                <p>
                    Kindly arrive on <strong style='color: #007bff;'>{$appointmentDateTime}</strong> 
                    to ensure all final details of your event are confirmed. We recommend arriving at least 15 minutes early to allow for any last-minute preparations.
                </p>
                <p style='color: #555;'>Thank you for choosing our service!</p>
            </div>
        ";


        // Send email using html method
        Mail::send([], [], function ($message) use ($user, $emailContent) {
            $message->to($user->email)
                    ->subject('Your Appointment Request Received')
                    ->html($emailContent); // Use html() method for setting HTML body
        });

        return redirect()->route('meetingform')->with('alert', 'Request Submitted. Your reference number is ' . $appointment->reference);

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
            return redirect()->route('direct')->with('error', 'The selected date is blocked, please select another date.');
        }

        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'accepted')
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->route('direct')->with('error', 'The selected date is fully booked, please select other date.');
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

        return redirect()->back()->with('alert', 'User and appointment created successfully.');
    }



    //STATUS
    public function accept(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Get the date of the appointment
        $appointmentDate = $appointment->edate; // Assuming 'edate' is a field in the appointments table

        $blockedDateExists = BlockedDate::where('blocked_date', $appointmentDate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->route('pending')->with('error', 'The selected date is blocked, please select another date.');
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
            Mail::send([], [], function ($message) use ($user, $emailContent) {
                $message->to($user->email)
                        ->subject('Your Event Has Been Booked!')
                        ->html($emailContent);
            });
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
        }

        // Redirect back or to a specific route
        session()->flash('alert', 'Event Successfully Booked');
        return redirect()->route('pending');
    }
    public function rebook(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);


        // Check if essential fields (edate, etime, location, type) are not null
        if (is_null($appointment->edate) || is_null($appointment->etime) || 
            is_null($appointment->location) || is_null($appointment->type)) {
            return redirect()->route('cancelled')->with('error', 'Appointment details are incomplete. Please make sure all fields are filled.');
        }
        
        // Get the date of the appointment
        $appointmentDate = $appointment->edate; // Assuming 'edate' is a field in the appointments table

        $blockedDateExists = BlockedDate::where('blocked_date', $appointmentDate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->route('cancelled')->with('error', 'The selected date is blocked, please select another date.');
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
            Mail::send([], [], function ($message) use ($user, $emailContent) {
                $message->to($user->email)
                        ->subject('Your Event Has Been Re-Booked!')
                        ->html($emailContent);
            });
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            return redirect()->route('cancelled')->with('error', 'Failed to send confirmation email.');
        }

        // Redirect back or to a specific route
        return redirect()->route('cancelled')->with('alert', 'Event Successfully Re-booked');
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
            $appointment->isread = "unread";
            $appointment->save();

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
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('Your Event Has Been Done!')
                            ->html($emailContent);
                });
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                return redirect()->route('booked')->with('error', 'Failed to send confirmation email.');
            }
    
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
            $appointment->isread = "unread";
            $appointment->save();

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
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('Your Event Has Been Cancelled')
                            ->html($emailContent);
                });
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                return redirect()->route('booked')->with('error', 'Failed to send confirmation email.');
            }

            // Redirect back or to a specific route
            return redirect("admin/booked")->with('alert', 'Event has been canceled');
        } else {
            // Redirect back or to a specific route with an error message
            return redirect("admin/booked")->with('error', 'The event is not eligible for cancellation.');
        }
    }

    public function cancelmeeting(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);



            // Update appointment status to "cancelled"
            $appointment->status = 'cancelled';
            $appointment->isread = "unread";
            $appointment->save();


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
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('Your Event Request Has Been Cancelled')
                            ->html($emailContent);
                });
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
            }

            // Redirect back or to a specific route
            return redirect("admin/pending")->with('alert', 'Event has been canceled');
    }

    //Details Edit
    public function detailsedit(string $appointment_id)
    {
        $packages = Package::orderBy('created_at', 'desc')->paginate(30);
        $appointment = Appointment::find($appointment_id);

        return view('admin.booked-edit', compact('packages', 'appointment'));
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

        // Redirect back or to a success page
        return redirect()->back()->with('alert', 'Event updated successfully!');
    }


    //BLOCK UNBLOCK
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

        // Optional: Return a response or redirect with a success message
        return redirect()->back()->with('alert', 'Date unblocked successfully!');
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


    public function fetchUnreadCount()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Count unread appointments
            $unreadAppointmentsCount = $user->appointment()
                ->where('isread', 'unread')
                ->count();

            // Check `verifyisread` and `submitisread` fields for the authenticated user
            $unreadVerifyCount = ($user->verifyisread === 'unread') ? 1 : 0;
            $unreadSubmitCount = ($user->submitisread === 'unread') ? 1 : 0;

            // Total unread count
            $unreadCount = $unreadAppointmentsCount + $unreadVerifyCount + $unreadSubmitCount;

            return response()->json(['count' => $unreadCount]);
        }

        return response()->json(['count' => 0]);
    }

    public function fetchAdminUnreadCount() 
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's type is 'admin'
            if ($user->usertype === 'admin') {

                $unreadAppointmentsCount = \App\Models\Appointment::where('isadminread', 'unread')->count();

                // Count rows in the users table where `submitisadminread` is "unread" and `verifystatus` is "unverified"
                $unreadAdminCount = User::where('submitisadminread', 'unread')
                    ->where('usertype', 'user')
                    ->where('verifystatus', 'unverified')
                    ->count();

                // Set unread count for admin
                $unreadCount = $unreadAppointmentsCount + $unreadAdminCount;

                return response()->json(['count' => $unreadCount]);
            }

            return response()->json(['count' => 0]);
        }
    }

    public function fetchManagerUnreadCount() 
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's type is 'admin'
            if ($user->usertype === 'manager') {

                // Count all appointments where `ismanagerread` is "unread"
                $unreadAppointmentsCount = \App\Models\Appointment::where('ismanagerread', 'unread')->count();

                // Count rows in the users table where `submitisadminread` is "unread" and `verifystatus` is "unverified"
                $unreadAdminCount = User::where('submitismanagerread', 'unread')
                    ->where('usertype', 'user')
                    ->where('verifystatus', 'unverified')
                    ->count();

                // Set unread count for admin
                $unreadCount = $unreadAppointmentsCount + $unreadAdminCount;

                return response()->json(['count' => $unreadCount]);
            }

            return response()->json(['count' => 0]);
        }
    }
    
    public function fetchOwnerUnreadCount() 
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's type is 'admin'
            if ($user->usertype === 'owner') {

                // Count all appointments where `ismanagerread` is "unread"
                $unreadAppointmentsCount = \App\Models\Appointment::where('isownerread', 'unread')->count();


                // Set unread count for admin
                $unreadCount = $unreadAppointmentsCount;

                return response()->json(['count' => $unreadCount]);
            }

            return response()->json(['count' => 0]);
        }
    }

    public function fetchUserUnreadMessageCount()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's type is "user"
            if ($user->usertype === 'user') {
                // Count unread messages where receiver_id is the authenticated user's ID and receiverisread is "unread"
                $unreadChatCount = \App\Models\Message::where('receiver_id', $user->id)
                    ->where('receiverisread', 'unread')
                    ->count();

                return response()->json(['count' => $unreadChatCount]);
            }
            return response()->json(['count' => 0]);
        }
        return response()->json(['count' => 0]);
    }

    public function fetchAdminUnopenedMessageCount()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's type is "user"
            if ($user->usertype === 'admin') {
                // Count unread messages where receiver_id is the authenticated user's ID and receiverisread is "unread"
                $unreadChatCount = \App\Models\Message::where('receiver_id', $user->id)
                    ->where('isopened', 'unread')
                    ->count();

                return response()->json(['count' => $unreadChatCount]);
            }
            return response()->json(['count' => 0]);
        }
        return response()->json(['count' => 0]);
    }

    public function fetchManagerUnopenedMessageCount()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's type is "user"
            if ($user->usertype === 'manager') {
                // Count unread messages where receiver_id is the authenticated user's ID and receiverisread is "unread"
                $unreadChatCount = \App\Models\Message::where('receiver_id', $user->id)
                    ->where('isopened', 'unread')
                    ->count();

                return response()->json(['count' => $unreadChatCount]);
            }
            return response()->json(['count' => 0]);
        }
        return response()->json(['count' => 0]);
    }

    public function fetchOwnerUnopenedMessageCount()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's type is "user"
            if ($user->usertype === 'owner') {
                // Count unread messages where receiver_id is the authenticated user's ID and receiverisread is "unread"
                $unreadChatCount = \App\Models\Message::where('receiver_id', $user->id)
                    ->where('isopened', 'unread')
                    ->count();

                return response()->json(['count' => $unreadChatCount]);
            }
            return response()->json(['count' => 0]);
        }
        return response()->json(['count' => 0]);
    }

}
