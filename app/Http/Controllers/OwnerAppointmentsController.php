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

class OwnerAppointmentsController extends Controller
{
    
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
}
