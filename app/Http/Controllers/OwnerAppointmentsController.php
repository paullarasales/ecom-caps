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
use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\DB;

class OwnerAppointmentsController extends Controller
{

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
        $minDeposit = $package->packagedesc * 0.20; // Minimum 20% of the package price
        $maxDeposit = $package->packagedesc; // Maximum is the full package price

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
            return redirect()->route('ownerdirect')->with('error', 'The selected date is blocked, please select another date.');
        }

        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'booked')
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->route('ownerdirect')->with('error', 'The selected date is fully booked, please select other date.');
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
        $appointment->theme = $request->input('theme');
        $appointment->package_id = $request->input('package_id');
        $appointment->reference = strtoupper(uniqid('REF'));
        $appointment->status = 'booked';
        $appointment->isownerread = "read";
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

        return redirect()->back()->with('success', 'Event booked successfully.');
    }

    public function detailsedit(string $appointment_id)
    {
        $packages = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->paginate(30);
        $blockedDates = BlockedDate::pluck('blocked_date')->toArray();
        $appointment = Appointment::find($appointment_id);
        $bookedDates = Appointment::select('edate')
        ->where('status', 'booked')
        ->where('appointment_id', '!=', $appointment_id)
        ->groupBy('edate')
        ->having(DB::raw('COUNT(*)'), '=', 3)
        ->pluck('edate')
        ->toArray();

        return view('owner.booked-edit', compact('packages', 'appointment', 'blockedDates', 'bookedDates'));
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

        // Check if the selected date is blocked
        $blockedDateExists = BlockedDate::where('blocked_date', $request->edate)->exists();

        if ($blockedDateExists) {
            // Redirect back with an error message if the date is blocked
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The selected event date is blocked, please select another date.'
            ]);
        }

        // Check if there are already 3 accepted event on the same date
        $existingAppointments = Appointment::where('edate', $request->edate)
                                            ->where('status', 'booked')
                                            ->where('appointment_id', '!=', $appointment_id)
                                            ->count();
    
        if ($existingAppointments >= 3) {
            // Redirect back with an error message
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'The selected event date is fully booked, please select other date.'
            ]);
        }

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
        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'Event updated successfully!'
        ]);
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
}
