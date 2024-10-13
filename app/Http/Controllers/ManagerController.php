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

class ManagerController extends Controller
{
    public function managerdashboard()
    {
        // Count the appointment statuses
        $appointmentStatusCounts = Appointment::select('status')
            ->get()
            ->groupBy('status')
            ->map->count();

        // Count the total number of users, packages, posts, and FAQs
        $userCount = User::where('usertype', 'user')->count();
        $packageCount = Package::count();
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

        return view('manager.dashboard', [
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
        // return view('manager.dashboard');
    }
    public function managerappointments()
    {
        return view('manager.appointments');
    }
    public function managerreviews()
    {
        return view('manager.reviews');
    }
    public function managerpackages()
    {
        return view('manager.packages');
    }
    public function managerusers(Request $request)
    {
        $search = $request->input('search');

        // If a search query exists, filter users based on name or usertype
        $users = User::when($search, function ($query, $search) {
            return $query->where('firstname', 'like', "%{$search}%")
            ->orWhere('lastname', 'like', "%{$search}%")
            ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ["%{$search}%"]);
        })
        ->orderBy('created_at', 'desc')
        ->whereIn('usertype', ['user'])
        ->paginate(10);

        return view('manager.users', compact('users', 'search'));

        // return view('manager.users');
    }
    public function managerchat()
    {
        return view('manager.chat');
    }
}
