<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Package;
use App\Models\Custompackage;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function bookedMonth(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = Carbon::createFromFormat('Y-m', $request->month);

        $appointments = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'booked')
            ->whereYear('edate', $month->year)
            ->whereMonth('edate', $month->month)
            ->orderBy('edate', 'asc')
            ->get();

        
        $appointments->each(function ($appointment) {
            $appointment->edate = Carbon::parse($appointment->edate);
        });

        if ($appointments->isEmpty()) {
            return redirect()->back()->with('error', 'No Booked events found for the selected month.');
        }

        $data = [
            'appointments' => $appointments,
            'month' => $month->format('F Y'),
        ];

        $pdf = Pdf::loadView('report.booked-month', $data);

        $filename = $month->format('F Y') . ' Booked Events Report.pdf';

        return $pdf->stream($filename);
    }

    public function doneMonth(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = Carbon::createFromFormat('Y-m', $request->month);

        $appointments = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'done')
            ->whereYear('edate', $month->year)
            ->whereMonth('edate', $month->month)
            ->orderBy('edate', 'asc')
            ->get();

        
        $appointments->each(function ($appointment) {
            $appointment->edate = Carbon::parse($appointment->edate);
        });

        if ($appointments->isEmpty()) {
            return redirect()->back()->with('error', 'No Completed events found for the selected month.');
        }

        $data = [
            'appointments' => $appointments,
            'month' => $month->format('F Y'),
        ];

        $pdf = Pdf::loadView('report.done-month', $data);

        $filename = $month->format('F Y') . ' Completed Events Report.pdf';

        return $pdf->stream($filename);
    }

    public function pendingMonth(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = Carbon::createFromFormat('Y-m', $request->month);

        $appointments = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'pending')
            ->whereYear('appointment_datetime', $month->year)
            ->whereMonth('appointment_datetime', $month->month)
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        
        $appointments->each(function ($appointment) {
            $appointment->appointment_datetime = Carbon::parse($appointment->appointment_datetime);
        });

        if ($appointments->isEmpty()) {
            return redirect()->back()->with('error', 'No Pending Appointments found for the selected month.');
        }

        $data = [
            'appointments' => $appointments,
            'month' => $month->format('F Y'),
        ];

        $pdf = Pdf::loadView('report.pending-month', $data);

        $filename = $month->format('F Y') . ' Pending Appointments Report.pdf';

        return $pdf->stream($filename);
    }

    public function cancelledMonth(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = Carbon::createFromFormat('Y-m', $request->month);

        $appointments = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'cancelled')
            ->whereYear('edate', $month->year)
            ->whereMonth('edate', $month->month)
            ->orderBy('edate', 'asc')
            ->get();

        
        $appointments->each(function ($appointment) {
            $appointment->edate = Carbon::parse($appointment->edate);
        });

        if ($appointments->isEmpty()) {
            return redirect()->back()->with('error', 'No Cancelled events found for the selected month.');
        }

        $data = [
            'appointments' => $appointments,
            'month' => $month->format('F Y'),
        ];

        $pdf = Pdf::loadView('report.cancelled-month', $data);

        $filename = $month->format('F Y') . ' Cancelled Events Report.pdf';

        return $pdf->stream($filename);
    }

    public function bookedDetails(string $appointment_id)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'booked')
            ->where('appointment_id', $appointment_id)
            ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not booked.');
        }

        // Fetch the custom package if it exists
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        // Prepare data for the PDF
        $data = [
            'appointment' => $appointment,
            'package' => $appointment->package,
            'customPackage' => $customPackage,
        ];

        /// Generate a filename using edate and etime
        $filename = $appointment->edate . '_' . str_replace(':', '-', $appointment->etime) . '_booked-details.pdf';

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('report.booked-details', $data);

        // Return the generated PDF for download
        return $pdf->stream($filename);
    }

    public function pendingDetails(string $appointment_id)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'pending')
            ->where('appointment_id', $appointment_id)
            ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not booked.');
        }

        // Fetch the custom package if it exists
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        // Prepare data for the PDF
        $data = [
            'appointment' => $appointment,
            'package' => $appointment->package,
            'customPackage' => $customPackage,
        ];

        /// Generate a filename using edate and etime
        $filename = $appointment->edate . '_' . str_replace(':', '-', $appointment->etime) . 'pending-details.pdf';

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('report.pending-details', $data);

        // Return the generated PDF for download
        return $pdf->stream($filename);
    }

    public function cancelledDetails(string $appointment_id)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'cancelled')
            ->where('appointment_id', $appointment_id)
            ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not booked.');
        }

        // Fetch the custom package if it exists
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        // Prepare data for the PDF
        $data = [
            'appointment' => $appointment,
            'package' => $appointment->package,
            'customPackage' => $customPackage,
        ];

        /// Generate a filename using edate and etime
        $filename = $appointment->edate . '_' . str_replace(':', '-', $appointment->etime) . 'cancelled-details.pdf';

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('report.cancelled-details', $data);

        // Return the generated PDF for download
        return $pdf->stream($filename);
    }

    public function doneDetails(string $appointment_id)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'done')
            ->where('appointment_id', $appointment_id)
            ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not booked.');
        }

        // Fetch the custom package if it exists
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        // Prepare data for the PDF
        $data = [
            'appointment' => $appointment,
            'package' => $appointment->package,
            'customPackage' => $customPackage,
        ];

        /// Generate a filename using edate and etime
        $filename = $appointment->edate . '_' . str_replace(':', '-', $appointment->etime) . 'completed-details.pdf';

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('report.done-details', $data);

        // Return the generated PDF for download
        return $pdf->stream($filename);
    }


    public function contract(string $appointment_id)
    {
        $appointment = Appointment::with(['user', 'package.custompackage.items'])
            ->where('status', 'booked')
            ->where('appointment_id', $appointment_id)
            ->first();

        if (!$appointment) {
            return redirect()->route('adminappointments')->with('error', 'Appointment not found or not booked.');
        }

        // Fetch the custom package if it exists
        $customPackage = $appointment->package ? $appointment->package->custompackage : null;

        // Prepare data for the PDF
        $data = [
            'appointment' => $appointment,
            'package' => $appointment->package,
            'customPackage' => $customPackage,
        ];

        /// Generate a filename using edate and etime
        $filename = $appointment->edate . '_' . str_replace(':', '-', $appointment->etime) . ' contract.pdf';

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('report.contract', $data);

        // Return the generated PDF for download
        return $pdf->stream($filename);
    }
}
