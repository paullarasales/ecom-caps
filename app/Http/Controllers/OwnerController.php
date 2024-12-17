<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Faqs;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Package;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use App\Models\Log;


class OwnerController extends Controller
{
    public function ownerdashboard()
    {
        // Count the appointment statuses
        $appointmentStatusCounts = Appointment::select('status')
            ->get()
            ->groupBy('status')
            ->map->count();

        // Count the total number of users, packages, posts, and FAQs
        $userCount = User::where('usertype', 'user')->has('appointment')->count();
        $packageCount = Package::where('packagetype', 'Normal')->count() + 1;
        $postCount = Post::count();
        $faqCount = Faqs::count();
        

        // Fetch the latest edate from appointments
        $latestEdate = Appointment::max('edate');

        // If there are no appointments, set latestEdate to current date
        if (!$latestEdate) {
            $latestEdate = Carbon::now()->toDateString();
        }

        // Create a Carbon instance from the latest edate
        $latestDate = Carbon::parse($latestEdate)->startOfMonth();

        // Define the time range: past 2 years (24 months)
        $monthsToShow = 24;

        // Initialize the months array in chronological order
        $months = [];
        $current = $latestDate->copy()->subMonths($monthsToShow - 1); // Start from 23 months ago

        for ($i = 0; $i < $monthsToShow; $i++) {
            $key = $current->format('Y-n'); // e.g., "2022-9"
            $months[$key] = $current->format('F Y'); // e.g., "September 2022"
            $current->addMonth();
        }

        // Initialize counts arrays with zero for each month and status
        $counts = [
            'pending' => array_fill(0, count($months), 0),
            'booked' => array_fill(0, count($months), 0),
            'done' => array_fill(0, count($months), 0),
            'cancelled' => array_fill(0, count($months), 0)
        ];

        // Get appointments within the past 2 years, grouped by year, month, and status
        $appointments = Appointment::selectRaw('YEAR(edate) as year, MONTH(edate) as month, status, COUNT(*) as count')
            ->whereBetween('edate', [
                $latestDate->copy()->subMonths($monthsToShow - 1)->startOfMonth()->toDateString(),
                $latestDate->copy()->endOfMonth()->toDateString()
            ])
            ->groupBy('year', 'month', 'status')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Map each appointment count to the correct month and status
        foreach ($appointments as $appointment) {
            $key = "{$appointment->year}-{$appointment->month}";
            if (array_key_exists($key, $months)) {
                // Find the index of the month in the months array
                $index = array_search($key, array_keys($months));
                if ($index !== false) {
                    // Assign the count to the appropriate status and month
                    // Ensure that the status exists in the counts array
                    if (array_key_exists($appointment->status, $counts)) {
                        $counts[$appointment->status][$index] += $appointment->count;
                    }
                }
            }
        }

        // Extract the month labels in the correct order
        $monthLabels = array_values($months);

        // Limit to top 10 cities
        $topCities = 10;

        $usersByCity = User::select('city', DB::raw('count(*) as count'))
            ->where('usertype', 'user')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->take($topCities)
            ->get();

        // Calculate the count for "Others"
        $totalOther = User::whereNotIn('city', $usersByCity->pluck('city'))->count();

        if ($totalOther > 0) {
            $usersByCity->push((object)[
                'city' => 'Others',
                'count' => $totalOther
            ]);
        }

        $cityNames = $usersByCity->pluck('city')->toArray();
        $cityUserCounts = $usersByCity->pluck('count')->toArray();

        // Count appointments per package
        // Fetch appointments grouped by package_id with their counts
        $appointmentsByPackage = Appointment::select('package_id', DB::raw('count(*) as count'))
        ->whereIn('status', ['booked', 'done'])
        ->groupBy('package_id')
        ->with('package.custompackage') // Eager load package and custompackage relationships
        ->get();

        // Use an associative array to store unique package names and their counts
        $packageCountsMap = [];

        // First, iterate through appointments and store counts
        foreach ($appointmentsByPackage as $appointment) {
        $package = $appointment->package;

        if ($package) {
            // Get the correct package name based on the custompackage relationship
            $packageName = $package->custompackage
                ? $package->custompackage->target
                : $package->packagename;

            // Add to map or update count
            if (isset($packageCountsMap[$packageName])) {
                $packageCountsMap[$packageName] += $appointment->count;
            } else {
                $packageCountsMap[$packageName] = $appointment->count;
            }
        }
        }

        // Now, include all packages with a count of 0 if they are not already in the map
        $allPackages = Package::with('custompackage')->get();
        foreach ($allPackages as $package) {
        $packageName = $package->custompackage
            ? $package->custompackage->target
            : $package->packagename;

        // Only add packages that are not already counted
        if (!isset($packageCountsMap[$packageName])) {
            $packageCountsMap[$packageName] = 0;
        }
        }

        // Prepare package names and counts for display
        $packageNames = array_keys($packageCountsMap);
        $packageCounts = array_values($packageCountsMap);

        return view('owner.dashboard', [
            'appointmentStatusCounts' => $appointmentStatusCounts,
            'userCount' => $userCount,
            'packageCount' => $packageCount,
            'postCount' => $postCount,
            'faqCount' => $faqCount,
            'months' => $monthLabels,
            'counts' => $counts,
            'cityNames' => $cityNames,
            'cityUserCounts' => $cityUserCounts,
            'packageNames' => $packageNames,
            'packageCounts' => $packageCounts,
        ]);

        // return view('owner.dashboard');
    }
    public function ownercalendar()
    {
        return view('owner.calendar');
    }
    public function ownerdirect()
    {
        return view('owner.direct');
    }
    public function ownerevents()
    {
        return view('owner.appointments');
    }
    public function packages()
    {
        return view('owner.packages');
    }
    public function reviews()
    {
        return view('owner.reviews');
    }
    public function reports()
    {
        return view('owner.reports');
    }
    public function logs()
    {
        $logs = Log::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('owner.logs', compact('logs'));
    }
    public function ownerchat()
    {
        Message::where('receiver_id', Auth::id())
        ->where('isopened', 'unread')
        ->update(['isopened' => 'read']);

        return view('owner.chat');
    }

    public function notifications()
    {
        // Fetch unread appointments for each user
        $unreadAppointments = Appointment::where('ismanagerread', 'unread')
        ->with('user') // Assuming you have a relationship defined in the Appointment model
        ->where('status', 'pending')
        ->get();

        Appointment::where('isownerread', 'unread')
        ->update(['isownerread' => 'read']);

        return view('owner.notifications', compact('unreadAppointments'));
    }
}
