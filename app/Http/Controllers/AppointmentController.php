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
        $appointment->theme ='undefined';
        $appointment->appointment_datetime = $dateTime;
        $appointment->package_id = $request->package_id;
        // Generate a unique reference
        $appointment->reference = strtoupper(uniqid('APP'));
        $appointment->adate = now();
        $appointment->atime = 'null';
        $appointment->save();

        return redirect()->route('dashboard')->with('alert', 'Request Submitted. Your reference number is ' . $appointment->reference);
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
        $appointment->reference = strtoupper(uniqid('APP'));
        $appointment->adate = now();
        $appointment->atime = 'null';
        $appointment->theme ='undefined';
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

        // Redirect back or to a specific route
        return redirect("admin/pending")->with('alert', 'Request Successfully Accepted');
    }
    public function rebook(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        
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

        // Redirect back or to a specific route
        return redirect("admin/cancelled")->with('alert', 'Event Successfully Re-booked');
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
        return redirect()->route('booked')->with('alert', 'Event updated successfully!');
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
