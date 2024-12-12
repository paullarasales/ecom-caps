<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Faqs;
use App\Models\Appointment;
use App\Models\Package;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use App\Models\Message;
use App\Models\Log;

class AdminController extends Controller
{
    public function chat()
    {
        Message::where('receiver_id', Auth::id())
        ->where('isopened', 'unread')
        ->update(['isopened' => 'read']);

        $users = User::all();
        return view('admin.chat', compact('users'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
    public function others()
    {
        return view('admin.others');
    }
    public function admindashboard()
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
        $appointmentsByPackage = Appointment::select('package_id', DB::raw('count(*) as count'))
            ->whereIn('status', ['booked', 'done'])
            ->groupBy('package_id')
            ->with('package') // Eager load the package relationship
            ->get();

            // Prepare the package names and counts
            $packageNames = [];
            $packageCounts = [];

            foreach ($appointmentsByPackage as $appointment) {
                // Assuming you have a relationship defined in the Appointment model
                $package = Package::find($appointment->package_id);

                if ($package) {
                    $packageNames[] = $package->packagename; // Get the package name
                    $packageCounts[] = $appointment->count; // Get the appointment count
                }
            }

            // In case you want to display a count for packages with no appointments
            $allPackages = Package::all();
            foreach ($allPackages as $package) {
                if (!in_array($package->packagename, $packageNames)) {
                    $packageNames[] = $package->packagename; // Add package name if it doesn't exist
                    $packageCounts[] = 0; // Set count to 0
                }
            }

        return view('admin.dashboard', [
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
    }




    public function appointments()
    {
        return view('admin.appointments');
    }
    public function packages()
    {
        return view('admin.packages');
    }
    public function adminreviews()
    {
        return view('admin.reviews');
    }
    public function reports()
    {
        return view('admin.reports');
    }
    public function users()
    {
        return view('admin.users');
    }
    public function logs()
    {
        $logs = Log::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.logs', compact('logs'));
    }

    public function notifications()
    {
        

        $users = User::where('usertype', 'user')
        ->where('verifystatus', 'unverified')
        ->whereNotNull('firstname')
        ->whereNotNull('lastname')
        ->whereNotNull('birthday')
        ->whereNotNull('phone')
        ->whereNotNull('address')
        ->whereNotNull('city')
        ->whereNotNull('photo')
        ->where('firstname', '!=', '') // Check for non-empty string
        ->where('lastname', '!=', '') // Check for non-empty string
        ->where('birthday', '!=', '') // Check for non-empty string
        ->where('phone', '!=', '') // Check for non-empty string
        ->where('address', '!=', '') // Check for non-empty string
        ->where('city', '!=', '') // Check for non-empty string
        ->where('photo', '!=', '') // Check for non-empty string
        ->get();

        // Fetch unread appointments for each user
        $unreadAppointments = Appointment::
        with('user') // Assuming you have a relationship defined in the Appointment model
        ->whereIn('status', ['pending' , 'mcancelled', 'cancelled'])
        ->orderBy('created_at', 'desc')
        ->get();

        User::where('usertype', 'user')
            ->where('verifystatus', 'unverified')
            ->where('submitisadminread', 'unread')
            ->update(['submitisadminread' => 'read']);

        Appointment::where('isadminread', 'unread')
        ->update(['isadminread' => 'read']);
        
        return view('admin.notifications', compact('users', 'unreadAppointments'));
    }
}
