<x-manager-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Manager <span class="text-yellow-600">Dashboard</span>
        </h3>
    </div>

    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mt-10">
    
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-yellow-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-yellow-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-regular fa-credit-card"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Post</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('managerpost')}}">
                        <button type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-green-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-green-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-question"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Faqs</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('managerfaqs')}}">
                        <button type="button" class="border border-green-500 text-green-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        
    
    
    </div>
    

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 w-full min-w-0">
        <!-- Total Users -->
        <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
            <div class="flex flex-col items-center space-y-2">
                <div class="text-6xl font-bold tracking-tight leading-none text-gray-700">
                    {{ $userCount }}
                </div>
                <div class="text-sm sm:text-lg font-medium text-gray-700">Total Clients</div>
            </div>
        </div>
    
        <!-- Total Packages -->
        <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
            <div class="flex flex-col items-center space-y-2">
                <div class="text-6xl font-bold tracking-tight leading-none text-gray-700">
                    {{ $packageCount }}
                </div>
                <div class="text-sm sm:text-lg font-medium text-gray-700">Total Packages</div>
            </div>
        </div>
    
        <!-- Total FAQs -->
        <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
            <div class="flex flex-col items-center space-y-2">
                <div class="text-6xl font-bold tracking-tight leading-none text-gray-700">
                    {{ $faqCount }}
                </div>
                <div class="text-sm sm:text-lg font-medium text-gray-700">Total Faqs</div>
            </div>
        </div>
    
        <!-- Total Posts -->
        <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
            <div class="flex flex-col items-center space-y-2">
                <div class="text-6xl font-bold tracking-tight leading-none text-gray-700">
                    {{ $postCount }}
                </div>
                <div class="text-sm sm:text-lg font-medium text-gray-700">Total Posts</div>
            </div>
        </div>
    </div>
    
    
    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mx-10 mt-10">

        

        {{-- <div class="flex flex-wrap w-full mb-8">
            <div class="w-full mb-6 lg:mb-0">
            <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">Event Statistic</h1>
            <div class="h-1 w-20 bg-yellow-500 rounded"></div>
            </div>
        </div> --}}


        <h1 class="text-xl mt-10">Events Per Month</h1>

<!-- Container for the chart and buttons -->
<div class="w-full">
    <!-- Chart container -->
    <div class="overflow-x-auto w-full">
        <div class="min-w-[800px]">
            <canvas id="pendingAppointmentsChart" style="height: 400px;"></canvas>
        </div>
    </div>

    {{-- <!-- Buttons for toggling datasets -->
    <div class="flex justify-center space-x-4 mt-4">
        <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-3xl w-10 h-5" onclick="toggleDataset('Booked')"></button>
        <button class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-3xl w-10 h-5" onclick="toggleDataset('Done')"></button>
        <button class="bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-3xl w-10 h-5" onclick="toggleDataset('Cancelled')"></button>
    </div> --}}
</div>

<script>
    var ctx = document.getElementById('pendingAppointmentsChart').getContext('2d');
    var chart;

    // function toggleDataset(label) {
    //     var dataset = chart.data.datasets.find(ds => ds.label === label);
    //     dataset.hidden = !dataset.hidden;
    //     chart.update();
    // }

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Booked',
                    data: {!! json_encode($counts['booked']) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Teal color
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Done',
                    data: {!! json_encode($counts['done']) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue color
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Cancelled',
                    data: {!! json_encode($counts['cancelled']) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Red color
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return Number.isInteger(value) ? value : ''; // Only show integer values
                        }
                    },
                    grid: {
                        drawOnChartArea: false,
                        drawBorder: true
                    }
                }
            }
        }
    });
</script>


        
<h1 class="text-xl mt-10">Total Events</h1>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 w-full min-w-0">
    <!-- Booked -->
    <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-6xl font-bold tracking-tight leading-none text-green-500">
                {{ $appointmentStatusCounts['booked'] ?? 0 }}
            </div>
            <div class="text-lg font-medium text-green-500">Booked</div>
        </div>
        <div class="flex justify-center px-5 mb-2 text-sm">
            <a href="{{ route('manager.booked') }}">
                <button type="button" class="border border-green-500 text-green-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline">
                    Open
                </button>
            </a>
        </div>
    </div>

    <!-- Pending -->
    <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-6xl font-bold tracking-tight leading-none text-yellow-500">
                {{ $appointmentStatusCounts['pending'] ?? 0 }}
            </div>
            <div class="text-lg font-medium text-yellow-600">Pending</div>
        </div>
        <div class="flex justify-center px-5 mb-2 text-sm">
            <a href="{{ route('manager.pending') }}">
                <button type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                    Open
                </button>
            </a>
        </div>
    </div>

    <!-- Done -->
    <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-6xl font-bold tracking-tight leading-none text-blue-500">
                {{ $appointmentStatusCounts['done'] ?? 0 }}
            </div>
            <div class="text-lg font-medium text-blue-600">Done</div>
        </div>
        <div class="flex justify-center px-5 mb-2 text-sm">
            <a href="{{ route('manager.done') }}">
                <button type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                    Open
                </button>
            </a>
        </div>
    </div>

    <!-- Canceled -->
    <div class="flex flex-col px-6 py-2 bg-white shadow rounded-lg overflow-hidden">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-6xl font-bold tracking-tight leading-none text-red-500">
                {{ $appointmentStatusCounts['cancelled'] ?? 0 }}
            </div>
            <div class="text-lg font-medium text-red-500">Canceled</div>
        </div>
        <div class="flex justify-center px-5 mb-2 text-sm">
            <a href="{{ route('manager.cancelled') }}">
                <button type="button" class="border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">
                    Open
                </button>
            </a>
        </div>
    </div>
</div>


        <h1 class="text-xl mt-10">Clients by City</h1>
        <div class="overflow-x-auto w-full">
            <div class="min-w-[800px]">
                <canvas id="userCityChart" style="height: 400px;"></canvas>
            </div>
        </div>

        <!-- Display the top cities' information -->
        <div id="cityMessage" class="mt-6 p-4 bg-gray-100 border rounded-md text-sm">
            <!-- Message will be injected here -->
        </div>

        <script>
            var ctxCity = document.getElementById('userCityChart').getContext('2d');

            // City data from PHP (Laravel)
            var cityNames = {!! json_encode($cityNames) !!};
            var cityUserCounts = {!! json_encode($cityUserCounts) !!};

            // Create an array of city objects to easily determine the top cities
            var cities = cityNames.map((city, index) => {
                return {
                    name: city,
                    userCount: cityUserCounts[index]
                };
            });

            // Sort cities by userCount in descending order
            cities.sort((a, b) => b.userCount - a.userCount);

            // Determine top 3 cities
            var top3Cities = cities.slice(0, 5);

            // Determine cities to improve (4th place and beyond)
            var citiesToImprove = cities.slice(9);

            // Prepare the message
            var cityMessage = document.getElementById('cityMessage');

            // Display the message dynamically
            cityMessage.innerHTML = `
                <p>Top cities/municipalities: <strong>${top3Cities.map(city => city.name).join(', ')}</strong>.</p>
                <br>
                <p>Improve the service on cities/municipalities: <strong>${citiesToImprove.map(city => city.name).join(', ')}</strong>.</p>
            `;
        
            // Define an array of colors
            var backgroundColors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                // Add more colors if needed
            ];
        
            var borderColors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                // Add more colors if needed
            ];
        
            // Assign colors based on the number of cities
            var assignedBackgroundColors = [];
            var assignedBorderColors = [];
            for (var i = 0; i < {!! json_encode(count($cityNames)) !!}; i++) {
                assignedBackgroundColors.push(backgroundColors[i % backgroundColors.length]);
                assignedBorderColors.push(borderColors[i % borderColors.length]);
            }
        
            var userCityChart = new Chart(ctxCity, {
                type: 'bar', // Clustered bar chart
                data: {
                    labels: {!! json_encode($cityNames) !!}, // Array of city names
                    datasets: [{
                        label: 'User Count by City',
                        data: {!! json_encode($cityUserCounts) !!}, // Array of user counts per city
                        backgroundColor: assignedBackgroundColors,
                        borderColor: assignedBorderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Number of Clients per City',
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            display: false // Hide legend since there's only one dataset
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y; // Display raw count without decimals
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'City',
                                font: {
                                    size: 16
                                }
                            },
                            grid: {
                                display: false // Remove vertical grid lines
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Users',
                                font: {
                                    size: 16
                                }
                            },
                            ticks: {
                                // Remove decimal places from y-axis labels
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                    return null; // Hide non-integer labels
                                },
                                stepSize: 1 // Ensure y-axis increments by 1
                            },
                            grid: {
                                display: false, // Remove horizontal grid lines
                                drawBorder: true // Keep the axis border
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    // Optional: Adjust layout padding for better spacing
                    layout: {
                        padding: {
                            top: 20,
                            bottom: 20
                        }
                    }
                }
            });
        </script>

<canvas id="packageChart" class="w-32 h-32" style="max-height: 400px;"></canvas>

<!-- Suggestion Div -->
<div id="packageSuggestions" class="mt-4 p-4 bg-gray-100 rounded">
    <div id="mostPicked" class="mb-6 text-sm"></div>
    <div id="leastPicked" class="mb-2 text-sm"></div>
</div>

<script>
    var ctxPackage = document.getElementById('packageChart').getContext('2d');
    var packageNames = {!! json_encode($packageNames) !!};
    var packageCounts = {!! json_encode($packageCounts) !!};

    // Chart.js Configuration
    var packageChart = new Chart(ctxPackage, {
        type: 'pie',
        data: {
            labels: packageNames,
            datasets: [{
                label: 'Events for this Package',
                data: packageCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                ],
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Booked and Done Events per Package',
                    font: { size: 18 }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var data = tooltipItem.dataset.data;
                            var currentValue = data[tooltipItem.dataIndex];
                            var total = data.reduce((acc, value) => acc + value, 0);
                            var percentage = ((currentValue / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${currentValue} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Generate Suggestions
    function generateSuggestions() {
        // Combine names and counts into an array of objects
        let packages = packageNames.map((name, index) => ({
            name: name,
            count: packageCounts[index]
        }));

        // Sort packages based on counts
        packages.sort((a, b) => b.count - a.count);

        // Most picked package
        const mostPicked = packages[0];
        document.getElementById('mostPicked').innerHTML = `
            <strong>${mostPicked.name}</strong>: This is the most picked package, improve it more as it is what most clients prefer.
        `;

        // Least picked packages (top 3 with the least counts)
        const leastPicked = packages.slice(-3); // Get the last 3 elements
        const leastPickedNames = leastPicked.map(pkg => pkg.name).join(', '); // Join package names with commas

        document.getElementById('leastPicked').innerHTML = `
            <strong>${leastPickedNames}</strong>: Improve/Update these packages for clients to choose them more often.
        `;
    }

    // Call the function to display suggestions
    generateSuggestions();
</script>


        

    </div>
    
    </x-manager-layout>
    
