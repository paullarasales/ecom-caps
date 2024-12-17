<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function booked(Request $request, string $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Get the user who made the appointment
        $user = $appointment->user; // Assuming you have a relation between Appointment and User models

        // Format the appointment date and time
        $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

        $daysUntilAppointment = (int) Carbon::now()->startOfDay()->diffInDays(Carbon::parse($appointment->edate)->startOfDay());


        // Create the email content
        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>Your event date is approaching!</h1>
                <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                <p>Thank you for choosing us. Your event details are as follows:</p>
                <div style='border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>
                    <p>
                        <strong>Location:</strong> <span style='color: #555;'>{$appointment->location}</span><br>
                        <strong>Date:</strong> <span style='color: #555;'>{$appointmentDateFormatted}</span><br>
                        <strong>Time:</strong> <span style='color: #555;'>{$appointment->etime}</span><br>
                        <strong>Type:</strong> <span style='color: #555;'>{$appointment->type}</span><br>
                        <strong>Package:</strong> <span style='color: #555;'>{$appointment->package->custompackage->target}</span><br>
                        <strong>Reference Number:</strong> <span style='color: #555;'>{$appointment->reference}</span>
                    </p>
                </div>
                <p>
                    Your event is confirmed and booked for:
                    <strong style='color: #007bff;'>{$appointmentDateFormatted}</strong>.
                    There are <strong>{$daysUntilAppointment}</strong> days left until your event!
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
                            ->subject('Your event date is approaching!')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            // return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'Failed to send reminder.'
            ]);
        }
        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'Reminder sent.'
        ]);
    }
}
