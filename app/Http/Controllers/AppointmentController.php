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
use App\Models\Log as ModelsLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Customitem;
use App\Models\Custompackage;

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
            'theme' => 'required',
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
            return redirect()->route('book-form')->with([
                'alert' => 'error',
                'message' => 'You still have pending appointment'
            ]);
        }

        // Combine appointment date and time
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time);

        // Check if there is an existing appointment at the same date and time with a pending status
        $conflictingAppointment = Appointment::where('appointment_datetime', $dateTime)
                                            ->where('status', 'pending') // Only check for pending status
                                            ->first();

        if ($conflictingAppointment) {
            // Redirect back with an error message
            return redirect()->route('book-form')->with([
                'alert' => 'error',
                'message' => 'There is already a pending appointment scheduled at this date and time.'
            ]);
        }

        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time);
        $appointment = new Appointment($request->all());
        $appointment->user_id = Auth::id();
        $appointment->appointment_datetime = $dateTime;
        $appointment->package_id = $request->package_id;
        $appointment->theme = $request->theme;
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


        try {
            // Send email using html method
            Mail::send([], [], function ($message) use ($user, $emailContent) {
                $message->to($user->email)
                        ->subject('Your Appointment Request Received')
                        ->html($emailContent); // Use html() method for setting HTML body
            });
        } catch (\Exception $e) {
            // Log the error for later review
            Log::error('Email failed to send for appointment reference: ' . $appointment->reference, [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->appointment_id,
                'user_id' => $user->id,
            ]);
            
            // You can also notify the user that email sending failed
            return redirect()->route('book-form')->with([
                'alert' => 'success',
                'message' => 'Request Submitted. Your reference number is ' . $appointment->reference . '. However, we could not send a confirmation email at the moment.'
            ]);
        }

        return redirect()->route('book-form')->with([
            'alert' => 'success',
            'message' => 'Request Submitted. Your reference number is ' . $appointment->reference
        ]);
    }

    public function saveClient(Request $request, string $appointment_id)
    {
        $request->validate([
            'location' => 'required',
            'theme' => 'required',
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
            return redirect()->route('meetingform')->with('error', 'The selected date is blocked, please select another date.');
        }

        // Check if there are already 3 accepted event on the same date
        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'booked')
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'The selected event date is fully booked, please select other date.');
        }


        // Combine appointment date and time
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time);

        // Check if there is an existing appointment at the same date and time with a pending status
        $conflictingAppointment = Appointment::where('appointment_datetime', $dateTime)
                                            ->where('status', 'pending') // Only check for pending status
                                            ->where('appointment_id', '!=', $appointment_id)
                                            ->first();

        if ($conflictingAppointment) {
            // Redirect back with an error message
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'There is already a pending appointment scheduled at this date and time.'
            ]);
        }

        $appointment = Appointment::findOrFail($appointment_id);
        
        // Update appointment details
        $appointment->location = $request->input('location');
        $appointment->edate = $request->input('edate');
        $appointment->etime = $request->input('etime');
        $appointment->type = $request->input('type');
        $appointment->theme = $request->input('theme');
        $appointment->package_id = $request->input('package_id');
        $appointment->appointment_datetime = $dateTime;

        // Save the updated appointment
        $appointment->save();

            // Email logic directly in the controller
        $user = Auth::user();

        $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y h:i A'); 

        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>Your Appointment Request Has Been Edited And Received!</h1>
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

        try {
            // Send email using html method
            Mail::send([], [], function ($message) use ($user, $emailContent) {
                $message->to($user->email)
                        ->subject('Your Appointment Request Has Been Edited And Received')
                        ->html($emailContent); // Use html() method for setting HTML body
            });
        } catch (\Exception $e) {
            // Log the error for later review
            Log::error('Email failed to send for appointment reference: ' . $appointment->reference, [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->appointment_id,
                'user_id' => $user->id,
            ]);
            
            // You can also notify the user that email sending failed
            return redirect()->back()->with([
                'alert' => 'success',
                'message' => 'Appointment Request Has Been Edited And Received. Your reference number is ' . $appointment->reference . '. However, we could not send a confirmation email at the moment.'
            ]);
        }

        // Redirect back or to a success page
        return redirect()->back()->with('alert', 'Event updated successfully!');
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
        $pendingAppointmentsCount = Appointment::where('user_id', Auth::id())
                                                ->where('status', 'pending')
                                                ->count();
    
        if ($pendingAppointmentsCount >= 1) {
            // Redirect back with an error message
            return redirect()->route('meetingform')->with([
                'alert' => 'error',
                'message' => 'You still have pending appointment'
            ]);
        }

        // Combine appointment date and time
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time);

        // Check if there is an existing appointment at the same date and time with a pending status
        $conflictingAppointment = Appointment::where('appointment_datetime', $dateTime)
                                            ->where('status', 'pending') // Only check for pending status
                                            ->first();

        if ($conflictingAppointment) {
            // Redirect back with an error message
            return redirect()->route('meetingform')->with([
                'alert' => 'error',
                'message' => 'There is already a pending appointment scheduled at this date and time.'
            ]);
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


        try {
            // Send email using html method
            Mail::send([], [], function ($message) use ($user, $emailContent) {
                $message->to($user->email)
                        ->subject('Your Appointment Request Has Been Edited And Received')
                        ->html($emailContent); // Use html() method for setting HTML body
            });
        } catch (\Exception $e) {
            // Log the error for later review
            Log::error('Email failed to send for appointment reference: ' . $appointment->reference, [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->appointment_id,
                'user_id' => $user->id,
            ]);
            
            // You can also notify the user that email sending failed
            return redirect()->route('meetingform')->with([
                'alert' => 'success',
                'message' => 'Appointment Request Has Been Edited And Received. Your reference number is ' . $appointment->reference . '. However, we could not send a confirmation email at the moment.'
            ]);
        }

        return redirect()->route('meetingform')->with([
            'alert' => 'success',
            'message' => 'Request Submitted. Your reference number is ' . $appointment->reference
        ]);

    }


    public function saveClientMeeting(Request $request, string $appointment_id)
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
                                            ->where('appointment_id', '!=', $appointment_id)
                                            ->first();

        if ($conflictingAppointment) {
            // Redirect back with an error message
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'There is already a pending appointment scheduled at this date and time.'
            ]);
        }

        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time);

        $appointment = Appointment::findOrFail($appointment_id);
        $appointment->appointment_datetime = $dateTime;
        $appointment->save();

        // Email logic directly in the controller
        $user = Auth::user();

        $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y h:i A'); 

        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>Your Appointment Request Has Been Edited And Received!</h1>
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


        try {
            // Send email using html method
            Mail::send([], [], function ($message) use ($user, $emailContent) {
                $message->to($user->email)
                        ->subject('Your Appointment Request Has Been Edited And Received')
                        ->html($emailContent); // Use html() method for setting HTML body
            });
        } catch (\Exception $e) {
            // Log the error for later review
            Log::error('Email failed to send for appointment reference: ' . $appointment->reference, [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->appointment_id,
                'user_id' => $user->id,
            ]);
            
            // You can also notify the user that email sending failed
            return redirect()->back()->with([
                'alert' => 'success',
                'message' => 'Appointment Request Has Been Edited And Received. Your reference number is ' . $appointment->reference . '. However, we could not send a confirmation email at the moment.'
            ]);
        }

        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'Appointment Request Has Been Edited And Received. Your reference number is ' . $appointment->reference
        ]);

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
            'theme' => 'required',
            'edate' => 'required|date|after_or_equal:today',
            'etime' => 'required',
            'type' => 'required',
            'package_id' => 'required|exists:packages,package_id',
            'deposit' => 'required|numeric|min:0',
        ]);


        // Retrieve the associated package
        $package = Package::find($request->input('package_id')); 

        if (!$package) {
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The package for this appointment could not be found.'
            ]);
        }

        // Ensure deposit is within valid range
        $minDeposit = $package->discountedprice * 0.20; // Minimum 20% of the package price
        $maxDeposit = $package->discountedprice; // Maximum is the full package price

        $deposit = $request->input('deposit');
        $balance = $maxDeposit - $request->input('deposit');

        if ($deposit < $minDeposit) {
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The deposit must be at least 20% of the package price.'
            ]);
        }

        if ($deposit > $maxDeposit) {
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The deposit cannot exceed the package price.'
            ]);
        }

        

        // Check if the selected date is blocked
        $blockedDateExists = BlockedDate::where('blocked_date', $request->edate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->route('direct')->with([
                'alert' => 'error',
                'message' => 'The selecrted date is unavailable, please choose other date.'
            ]);
        }

        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'booked')
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->route('direct')->with([
                'alert' => 'error',
                'message' => 'The selected event date is fully booked, please choose other date.'
            ]);
        }

        // Create and save new user
        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->birthday = $request->input('birthday');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->submitisadminread = "read";
        $user->save();

        // Create and save new appointment
        $appointment = new Appointment();
        $appointment->user_id = $user->id; // Set the foreign key
        $appointment->location = $request->input('location');
        $appointment->edate = $request->input('edate');
        $appointment->etime = $request->input('etime');
        $appointment->type = $request->input('type');
        $appointment->theme = $request->input('theme');
        $appointment->package_id = $request->input('package_id');
        $appointment->reference = strtoupper(uniqid('REF'));
        $appointment->status = 'booked'; // Consider using null instead of 'null' if you want it to be a database NULL
        $appointment->isadminread = "read";
        $appointment->deposit = $deposit;
        $appointment->balance = $balance;
        $appointment->save();

        $DateFormatted = Carbon::parse($request->edate)->format('F j, Y');
        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Direct Booked';
            $log->description = $use->firstname . " " . $use->lastname . " directly booked an event on " . $DateFormatted;
            $log->logdate = now();
            $log->save();

        // return redirect()->back()->with([
        //     'alert' => 'success',
        //     'message' => 'Event booked! reference number is ' . $appointment->reference
        // ]);
        return redirect()->route('contract', ['appointment_id' => $appointment->appointment_id])->with([
            'alert' => 'success',
            'message' => 'Event Successfully Booked. Proceeding to contract.'
        ]);
    }



    //STATUS
    public function accept(Request $request, string $appointment_id)
    {
        $request->validate([
            'deposit' => 'required|numeric|min:0',
        ]);

        $appointment = Appointment::findOrFail($appointment_id);
        
        // Check if package_id is null
        if (is_null($appointment->package_id)) {
            // return redirect()->route('pending')->with('error', 'The appointment does not have a package assigned.');
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'The appointment does not have a package assigned.'
            ]);
        }

        // Retrieve the associated package
        $package = $appointment->package; // Assuming you have the relationship set up

        if (!$package) {
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The package for this appointment could not be found.'
            ]);
        }

        // Ensure deposit is within valid range
        $minDeposit = $package->discountedprice * 0.20; // Minimum 20% of the package price
        $maxDeposit = $package->discountedprice; // Maximum is the full package price

        $deposit = $request->input('deposit');

        if ($deposit < $minDeposit) {
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The deposit must be at least 20% of the package price.'
            ]);
        }

        if ($deposit > $maxDeposit) {
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The deposit cannot exceed the package price.'
            ]);
        }

        // Check if the package's packagetype is 'normal'
        $package = $appointment->package; // Assuming relationship is set correctly
        if ($package && $package->packagetype === 'Normal') {
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'The appointment cannot proceed because the package is invalid.'
            ]);
        }

        // Get the date of the appointment
        $appointmentDate = $appointment->edate; // Assuming 'edate' is a field in the appointments table

        // Check if the appointment date is in the past
        if (Carbon::parse($appointmentDate)->isPast()) {
            // return redirect()->route('pending')->with('error', 'The selected date is in the past. Please select a valid future date.');
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'The selected event date is in the past. Please select a valid future date.'
            ]);
        }

        $blockedDateExists = BlockedDate::where('blocked_date', $appointmentDate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            // return redirect()->route('pending')->with('error', 'The selected date is blocked, please select another date.');
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'The selected event date is blocked, please select another date.'
            ]);
        }

        // Count the number of accepted appointments on the same date
        $acceptedAppointmentsCount = Appointment::where('edate', $appointmentDate)
                                                    ->where('status', 'booked')
                                                    ->count();

        // Check if the count is less than 3
        if ($acceptedAppointmentsCount >= 3) {
            // Redirect back with an error message
            // return redirect("admin/pending")->with('error', 'Date is Fully booked');
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'Event date is Fully booked'
            ]);
        }

        // Update appointment status to "accepted"
        $appointment->status = 'booked';
        $appointment->isread = "unread";
        $appointment->isadminread = "read";
        $appointment->deposit = $request->input('deposit');

        $package = $appointment->package;
        if ($package) {
            $appointment->balance = $package->discountedprice - $appointment->deposit;
        } else {
            return response()->json(['error' => 'Package not found'], 404);
        }

        $appointment->save();

        $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Booked';
            $log->logdate = now();
            $log->description = $use->firstname . " " . $use->lastname . " accepted an event on " . $DateFormatted;
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
            // return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
            return redirect()->route('contract', ['appointment_id' => $appointment_id])->with([
                'alert' => 'success',
                'message' => 'Event Successfully Booked. Proceeding to contract.'
            ]);
        }

        // Redirect back or to a specific route
        // session()->flash('alert', 'Event Successfully Booked');
        // return redirect()->route('pending')->with('alert', 'Event Successfully Booked');
        return redirect()->route('contract', ['appointment_id' => $appointment_id])->with([
            'alert' => 'success',
            'message' => 'Event Successfully Booked. Proceeding to contract.'
        ]);
    }



    public function rebook(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Check if package_id is null
        if (is_null($appointment->package_id)) {
            // return redirect()->route('canceclled')->with('error', 'The appointment does not have a package assigned.');
            return redirect()->route('cancelled')->with([
                'alert' => 'error',
                'message' => 'The event does not have a package assigned.'
            ]);
        }


        // Check if essential fields (edate, etime, location, type) are not null
        if (is_null($appointment->edate) || is_null($appointment->etime) || 
            is_null($appointment->location) || is_null($appointment->type)) {
            // return redirect()->route('cancelled')->with('error', 'Appointment details are incomplete. Please make sure all fields are filled.');
            return redirect()->route('cancelled')->with([
                'alert' => 'error',
                'message' => 'Event details are incomplete. Please make sure all fields are filled.'
            ]);
        }
        
        // Get the date of the appointment
        $appointmentDate = $appointment->edate; // Assuming 'edate' is a field in the appointments table

        // Check if the appointment date is in the past
        if (Carbon::parse($appointmentDate)->isPast()) {
            // return redirect()->route('cancelled')->with('error', 'The selected date is in the past. Please select a valid future date.');
            return redirect()->route('cancelled')->with([
                'alert' => 'error',
                'message' => 'The selected date is in the past. Please select a valid future date.'
            ]);
        }

        $blockedDateExists = BlockedDate::where('blocked_date', $appointmentDate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            // return redirect()->route('cancelled')->with('error', 'The selected date is blocked, please select another date.');
            return redirect()->route('cancelled')->with([
                'alert' => 'error',
                'message' => 'The selected event date is blocked, please select another date.'
            ]);
        }

        // Count the number of accepted appointments on the same date
        $acceptedAppointmentsCount = Appointment::where('edate', $appointmentDate)
                                                    ->where('status', 'booked')
                                                    ->count();

        // Check if the count is less than 3
        if ($acceptedAppointmentsCount >= 3) {
            // Redirect back with an error message
            // return redirect("admin/booked")->with('error', 'Date is Fully booked');
            return redirect()->route('cancelled')->with([
                'alert' => 'error',
                'message' => 'Event date is Fully booked.'
            ]);
        }

        $package = Package::find($appointment->package_id); // Fetch package by package_id

        if ($package) {
            // Update the package status to "archived"
            $package->packagestatus = 'active';
            $package->save();
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
            // return redirect()->route('cancelled')->with('error', 'Failed to send confirmation email.');
            return redirect()->route('cancelled')->with([
                'alert' => 'success',
                'message' => 'Event Successfully Re-booked. However, could not send a confirmation email at the moment.'
            ]);
        }

        // Redirect back or to a specific route
        // return redirect()->route('cancelled')->with('alert', 'Event Successfully Re-booked');
        return redirect()->route('cancelled')->with([
            'alert' => 'success',
            'message' => 'Event Successfully Re-booked.'
        ]);
    }
    public function done(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        $package = Package::find($appointment->package_id); // Fetch package by package_id

        if ($package) {
            // Update the package status to "archived"
            $package->packagestatus = 'archived';
            $package->save();
        }

        // Check if the deposit is already fully paid
        $currentBalance = $appointment->balance;
        $deposit = $request->input('deposit');

        // If deposit is fully paid, set the deposit to 0
        if ($deposit == 0 && $appointment->deposit == $appointment->package->packagedesc) {
            $deposit = 0; // Deposit is fully paid, no further deposit is required
        }

        // Validate deposit, only if it's not already fully paid
        $request->validate([
            'deposit' => ['required', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($currentBalance) {
                if ($value != $currentBalance) {
                    $fail('The deposit must be exactly equal to the remaining balance to fulfill the payment.');
                }
            }],
        ]);


        // Check if the edate is at least one day in the future
        // Check if the edate is today
        $edate = Carbon::parse($appointment->edate);

        // Check if the edate is today
        if ($edate->isToday() || $edate->isPast()) {
            // Update appointment status to "done"
            $appointment->status = 'done';
            $appointment->isread = "unread";
            $appointment->deposit += $deposit;
            $appointment->balance -= $deposit;
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
                // return redirect()->route('booked')->with('error', 'Failed to send confirmation email.');
                return redirect()->route('booked')->with([
                    'alert' => 'success',
                    'message' => 'Event moved to Completed. However, could not send a confirmation email at the moment.'
                ]);
            }
    
            // Redirect back or to a specific route
            // return redirect("admin/booked")->with('alert', 'Event moved to done');
            return redirect()->route('booked')->with([
                'alert' => 'success',
                'message' => 'Event moved to Completed.'
            ]);
        } else {
            // Redirect back or to a specific route with an error message
            // return redirect("admin/booked")->with('error', 'The event is not yet finished');
            return redirect()->route('booked')->with([
                'alert' => 'error',
                'message' => 'The event is not yet finished.'
            ]);
        }
    }
    public function cancel(Request $request, string $appointment_id)
    {
        $request->validate([
            'reason' => 'required',
            'deposit' => 'required|numeric|min:0'
        ]);

        $appointment = Appointment::findOrFail($appointment_id);

        // Get the package price and deposit for calculations
        $packageDesc = $appointment->package->packagedesc; // Package price
        $deposit = $appointment->deposit; // Current deposit
        $balance = $appointment->balance; // Current balance

        // Calculate minimum returnable (20% of package price)
        $minDeposit = $packageDesc * 0.20;
        // Calculate the excess returnable (deposit - minimum returnable)
        $excessReturnable = $deposit - $minDeposit;

        // Ensure the excess returnable is not negative
        if ($excessReturnable < 0) {
            $excessReturnable = 0;
        }

        // Get the requested deposit return value from the form
        $requestedDeposit = $request->input('deposit');

        // Check if the requested deposit to return is within the excess returnable
        if ($requestedDeposit > $excessReturnable) {
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The deposit to return cannot exceed the excess returnable amount of ₱' . number_format($excessReturnable, 2),
            ]);
        }

        $package = Package::find($appointment->package_id); // Fetch package by package_id

        if ($package) {
            // Update the package status to "archived"
            $package->packagestatus = 'archived';
            $package->save();
        }

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
            $appointment->reason = $request->input('reason');
            $appointment->deposit = $deposit - $requestedDeposit;
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
                // return redirect()->route('booked')->with('error', 'Failed to send confirmation email.');
                return redirect()->route('booked')->with([
                    'alert' => 'success',
                    'message' => 'Event canceled . However, could not send a confirmation email at the moment.'
                ]);
            }

            // Redirect back or to a specific route
            // return redirect("admin/booked")->with('alert', 'Event has been canceled');
            return redirect()->route('booked')->with([
                'alert' => 'success',
                'message' => 'Event has been canceled.'
            ]);
        } else {
            // Redirect back or to a specific route with an error message
            // return redirect("admin/booked")->with('error', 'The event is not eligible for cancellation.');
            return redirect()->route('booked')->with([
                'alert' => 'error',
                'message' => 'The event is not eligible for cancellation.'
            ]);
        }
    }

    public function cancelmeeting(Request $request, string $appointment_id)
    {
        $request->validate([
            'reason' => 'required',
        ]);
        
        $appointment = Appointment::findOrFail($appointment_id);

        $package = Package::find($appointment->package_id); // Fetch package by package_id

        if ($package) {
            // Update the package status to "archived"
            $package->packagestatus = 'archived';
            $package->save();
        }

            // Update appointment status to "cancelled"
            $appointment->status = 'mcancelled';
            $appointment->isread = "unread";
            $appointment->reason = $request->input('reason');
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
                    <h1 style='color: #333;'>Your meeting on {$appointmentDateFormatted} for the event {$appointment->type} has been cancelled</h1>
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
                                ->subject('Your meeting has been canceled')
                                ->html($emailContent);
                    });
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                // return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
                return redirect()->route('pending')->with([
                    'alert' => 'error',
                    'message' => 'Meeting cancelled!'
                ]);
            }

            // Redirect back or to a specific route
            // return redirect("admin/pending")->with('alert', 'Event has been canceled');
            return redirect()->route('pending')->with([
                'alert' => 'success',
                'message' => 'Meeting cancelled!'
            ]);
    }

    public function clientcancelmeeting(Request $request, string $appointment_id)
    {
        $request->validate([
            'reason' => 'required',
        ]);

        $appointment = Appointment::findOrFail($appointment_id);

        // $package = Package::find($appointment->package_id); // Fetch package by package_id

        // if ($package) {
        //     // Update the package status to "archived"
        //     if($package->packagetype === 'Normal'){
        //         $package->packagestatus = 'archived';
        //         $package->save();
        //     }
        // }



            // Update appointment status to "cancelled"
            $appointment->status = 'mcancelled';
            $appointment->isread = "unread";
            $appointment->isadminread = "unread";
            $appointment->reason = $request->input('reason');
            $appointment->save();


            // Get the user who made the appointment
            $user = $appointment->user; // Assuming you have a relation between Appointment and User models

            // Format the appointment date and time
            $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

            // Create the email content
            $emailContent = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>You canceled the meeting on {$appointmentDateFormatted} for the event {$appointment->type}</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p>We look forward on making your next event wonderful.</p>
                    <p style='color: #555;'>Message us on our Facebook page or on our Website for more details</p>
                </div>
            ";

            try {
                // Send the email
                if (!empty($user->email)) {
                    Mail::send([], [], function ($message) use ($user, $emailContent) {
                        $message->to($user->email)
                                ->subject('Your meeting has been canceled')
                                ->html($emailContent);
                    });
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());
                
                // Redirect back with an error message
                return redirect()->route('myrequest')->with('error', 'Failed to send confirmation email.');
            }

            // Redirect back or to a specific route
            return redirect()->route('myrequest')->with('alert', 'Event has been canceled');
    }

    //Details Edit
    public function detailsedit(string $appointment_id)
    {
        $packages = Package::with(['customPackage.items']) // Load the related items
        ->orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Custom')
        ->where(function ($query) use ($appointment_id) {
            $query->whereDoesntHave('appointment') // No appointments linked to this package
                  ->orWhereHas('appointment', function ($query) use ($appointment_id) {
                      $query->where('appointments.appointment_id', $appointment_id); // Only linked to the current appointment
                  });
        })
        ->paginate(30);

        $appointment = Appointment::find($appointment_id);

        // Fetch the custom package for the specific appointment
        $customPackage = Custompackage::with('items')
            ->where('package_id', $appointment->package_id)
            ->first();

        $blockedDates = BlockedDate::pluck('blocked_date')->toArray();

        $bookedDates = Appointment::select('edate')
            ->where('status', 'booked')
            ->where('appointment_id', '!=', $appointment_id)
            ->groupBy('edate')
            ->having(DB::raw('COUNT(*)'), '=', 3)
            ->pluck('edate')
            ->toArray();

        return view('admin.booked-edit', compact('packages', 'appointment', 'blockedDates', 'bookedDates', 'customPackage'));
    }
    public function detailspendingedit(string $appointment_id)
    {
        $packages = Package::with(['customPackage.items']) // Load the related items
        ->orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Custom')
        ->where(function ($query) use ($appointment_id) {
            $query->whereDoesntHave('appointment') // No appointments linked to this package
                  ->orWhereHas('appointment', function ($query) use ($appointment_id) {
                      $query->where('appointments.appointment_id', $appointment_id); // Only linked to the current appointment
                  });
        })
        ->paginate(30);

        $appointment = Appointment::find($appointment_id);

        // Fetch the custom package for the specific appointment
        $customPackage = Custompackage::with('items')
            ->where('package_id', $appointment->package_id)
            ->first();

        $blockedDates = BlockedDate::pluck('blocked_date')->toArray();

        $bookedDates = Appointment::select('edate')
            ->where('status', 'booked')
            ->where('appointment_id', '!=', $appointment_id)
            ->groupBy('edate')
            ->having(DB::raw('COUNT(*)'), '=', 3)
            ->pluck('edate')
            ->toArray();
        

        return view('admin.pending-edit', compact('packages', 'appointment', 'blockedDates', 'bookedDates', 'customPackage'));
    }
    public function detailscancellededit(string $appointment_id)
    {
        $packages = Package::with(['customPackage.items']) // Load the related items
        ->orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Custom')
        ->where(function ($query) use ($appointment_id) {
            $query->whereDoesntHave('appointment') // No appointments linked to this package
                  ->orWhereHas('appointment', function ($query) use ($appointment_id) {
                      $query->where('appointments.appointment_id', $appointment_id); // Only linked to the current appointment
                  });
        })
        ->paginate(30);

        $appointment = Appointment::find($appointment_id);

        // Fetch the custom package for the specific appointment
        $customPackage = Custompackage::with('items')
            ->where('package_id', $appointment->package_id)
            ->first();

        $blockedDates = BlockedDate::pluck('blocked_date')->toArray();

        $bookedDates = Appointment::select('edate')
            ->where('status', 'booked')
            ->where('appointment_id', '!=', $appointment_id)
            ->groupBy('edate')
            ->having(DB::raw('COUNT(*)'), '=', 3)
            ->pluck('edate')
            ->toArray();

        return view('admin.cancelled-edit', compact('packages', 'appointment', 'blockedDates', 'bookedDates', 'customPackage'));
    }

    public function save(Request $request, string $appointment_id)
    {
        $request->validate([
            'location' => 'required',
            'theme' => 'required',
            'edate' => 'required|date|after_or_equal:today',
            'etime' => 'required',
            'type' => 'required',
            // 'package_id' => 'required|exists:packages,package_id',
        ]);

        $appointment = Appointment::findOrFail($appointment_id);

        // $package = Package::findOrFail($request->input('package_id'));

        // // Check if package price is lower than the appointment deposit
        // if ($package->packagedesc < $appointment->deposit) {
        //     return redirect()->back()->with('error', 'Package price is lower than the deposit amount of ₱' . $appointment->deposit .' Cannot proceed.');
        // }

        // Check if the selected date is blocked
        $blockedDateExists = BlockedDate::where('blocked_date', $request->edate)->exists();

        if ($blockedDateExists) {
            return redirect()->back()->with('error', 'The selected date is blocked, please select another date.');
        }

        // Check if there are already 3 accepted event on the same date
        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'booked')
                                            ->where('appointment_id', '!=', $appointment_id)
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'The selected event date is fully booked, please select other date.');
        }

        
        
        // Update appointment details
        $appointment->location = $request->input('location');
        $appointment->edate = $request->input('edate');
        $appointment->etime = $request->input('etime');
        $appointment->type = $request->input('type');
        $appointment->theme = $request->input('theme');
        // $appointment->package_id = $request->input('package_id');

        // $package = $appointment->package;
        // if ($package) {
        //     $appointment->balance = $package->packagedesc - $appointment->deposit;
        // } else {
        //     return response()->json(['error' => 'Package not found'], 404);
        // }

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

        // Get the user who made the appointment
        $user = $appointment->user; // Assuming you have a relation between Appointment and User models

        // Format the appointment date and time
        $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

        // Create the email content
        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>The details of your event: {$appointment->type} on {$appointmentDateFormatted} have been updated</h1>
                <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                <p>We look forward on making your next event wonderful.</p>
                <p style='color: #555;'>Message us on our Facebook page or on our Website for more details</p>
            </div>
        ";

        try {
            // Send the email
            if (!empty($user->email)) {
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('Event details changes')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to send confirmation email.');
        }

        // Redirect back or to a success page
        // return redirect()->back()->with('success', 'Event updated successfully!');
        if ($appointment->status === 'booked') {
            return redirect()->route('bookedView', $appointment_id)->with('success', 'Event updated details successfully!');
        } elseif ($appointment->status === 'pending') {
            return redirect()->route('pendingView', $appointment_id)->with('success', 'Event updated details successfully!');
        } elseif ($appointment->status === 'cancelled') {
            return redirect()->route('cancelledView', $appointment_id)->with('success', 'Event updated details successfully!');
        }

    }

    public function contract(Request $request, string $appointment_id)
    {
        $request->validate([
            'contract' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($file = $request->file('contract')) {
            $appointment = Appointment::findOrFail($appointment_id);

            // Delete the existing contract file if it exists
            if ($appointment->contract && file_exists(public_path($appointment->contract))) {
                unlink(public_path($appointment->contract)); // Delete the previous file
            }

            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension; // Ensure unique filename
        
            $path = "uploads/contract/";
            $file->move(public_path($path), $filename); // Move the file to the public directory
        
            $appointment = Appointment::findOrFail($appointment_id);
            $appointment->contract = $path . $filename;
            $appointment->save();

            return redirect()->back()->with('success', 'Contract attached successfully!');
        }
        return redirect()->back()->with('error', 'Contract attatchment error');
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

        $unblockedDateFormatted = Carbon::parse($request->blocked_date)->format('F j, Y');

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Event Date Blocked';
            $log->description = $unblockedDateFormatted . " Has been blocked by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            

        return redirect()->back()->with('success', 'Date blocked successfully!');
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
        return redirect()->back()->with('success', 'Date unblocked successfully!');
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

        return redirect()->back()->with('success', 'Date blocked successfully!');
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
        return redirect()->back()->with('success', 'Date unblocked successfully!');
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
            // return redirect()->route('pending')->with('error', 'Completed appointments cannot be deleted.');
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'Completed appointments cannot be deleted.'
            ]);
        }
        
        // Check if the appointment date and time is in the past
        if ($appointment->appointment_datetime > now()) {
            // return redirect()->route('pending')->with('error', 'Future appointments cannot be deleted.');
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'Future appointments cannot be deleted.'
            ]);
        }

        // Delete the appointment
        $appointment->delete();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Deleted';
            $log->description = $use->firstname . " " . $use->lastname . " Has deleted a meeting that either couldn't be completed or where the client did not attend. " ;
            $log->logdate = now();
            $log->save();

        // Redirect back or to another route with a success message
        // return redirect()->route('pending')->with('success', 'Appointment deleted successfully.');
        return redirect()->route('pending')->with([
            'alert' => 'success',
            'message' => 'Appointment deleted successfully.'
        ]);
    }

    public function destroyMeeting(string $appointment_id)
    {
         // Find the appointment by its ID
        $appointment = Appointment::findOrFail($appointment_id);

        // Optionally check if the status is something other than 'done' if necessary
        if ($appointment->status === 'done') {
            // You can redirect back or return an error message if deletion is not allowed
            // return redirect()->route('cancelledMeeting')->with('error', 'Completed appointments cannot be deleted.');
            return redirect()->route('cancelledMeeting')->with([
                'alert' => 'error',
                'message' => 'Completed event cannot be deleted.'
            ]);
        }

        // Delete the appointment
        $appointment->delete();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Deleted';
            $log->description = $use->firstname . " " . $use->lastname . " Has deleted a meeting that either couldn't be completed or where the client did not attend. " ;
            $log->logdate = now();
            $log->save();

        // Redirect back or to another route with a success message
        // return redirect()->route('cancelledMeeting')->with('success', 'Appointment deleted successfully.');
        return redirect()->route('cancelledMeeting')->with([
            'alert' => 'success',
            'message' => 'Appointment deleted successfully.'
        ]);
    }

    public function archive(string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        if ($appointment->status === 'done') {
            return redirect()->route('cancelledMeeting')->with([
                'alert' => 'error',
                'message' => 'Completed event cannot be archived.'
            ]);
        }

        $appointment->status = "archived";
        $appointment->save();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Archived';
            $log->description = $use->firstname . " " . $use->lastname . " Has archived an appointment. " ;
            $log->logdate = now();
            $log->save();

        // Redirect back or to another route with a success message
        // return redirect()->route('cancelledMeeting')->with('success', 'Appointment deleted successfully.');
        return redirect()->route('cancelledMeeting')->with([
            'alert' => 'success',
            'message' => 'Appointment archived successfully.'
        ]);
    }
    public function archivePending(string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        if ($appointment->status === 'done') {
            return redirect()->route('pending')->with([
                'alert' => 'error',
                'message' => 'Completed event cannot be archived.'
            ]);
        }

        $appointment->status = "archived";
        $appointment->save();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Archived';
            $log->description = $use->firstname . " " . $use->lastname . " Has archived an appointment. " ;
            $log->logdate = now();
            $log->save();

        // Redirect back or to another route with a success message
        // return redirect()->route('cancelledMeeting')->with('success', 'Appointment deleted successfully.');
        return redirect()->route('pending')->with([
            'alert' => 'success',
            'message' => 'Appointment archived successfully.'
        ]);
    }
    public function unarchive(string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        $appointment->status = "mcancelled";
        $appointment->save();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Archived';
            $log->description = $use->firstname . " " . $use->lastname . " Has unarchived an appointment. " ;
            $log->logdate = now();
            $log->save();

        // Redirect back or to another route with a success message
        // return redirect()->route('cancelledMeeting')->with('success', 'Appointment deleted successfully.');
        return redirect()->route('archived')->with([
            'alert' => 'success',
            'message' => 'Appointment unarchived successfully.'
        ]);
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

            
            if ($user->usertype === 'owner') {
                
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
