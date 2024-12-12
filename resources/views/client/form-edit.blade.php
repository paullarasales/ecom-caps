<x-app-layout>

    <div class="text-center py-4 lg:my-10 my-5">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Details</span>
        </h3>
    </div>

<form action="{{route('client.appointment.save', $appointment->appointment_id)}}" method="POST" id="appointmentForm">
    @method("PUT")
    @csrf
    <script>
            // Check if there are validation errors
            var errors = @json($errors->any()); // Check if there are any errors
            var errorMessages = @json($errors->all()); // Get the array of error messages
        
            // Show SweetAlert with validation errors if there are any
            if (errors) {
                Swal.fire({
                    title: 'Validation Errors',
                    icon: 'error',
                    html: `
                        <ul style="text-align: center; color: #E07B39;">
                            ${errorMessages.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    `,
                    confirmButtonText: 'Close',
                    customClass: {
                        popup: 'custom-popup-error',
                        title: 'custom-title-error',
                        confirmButton: 'custom-button-error'
                    }
                });
            }
        </script>
        
        <style>
            /* SweetAlert Error Popup Customization */
            .custom-popup-error {
                background-color: #FDEDEC; /* Light red background */
                border: 2px solid #E07B39; /* Red border */
            }
            .custom-title-error {
                color: #E07B39; /* Red title text */
                font-weight: bold;
            }
            .custom-button-error {
                background-color: #E07B39 !important; /* Red button background */
                color: white !important; /* White button text */
                border-radius: 5px;
            }
            .custom-button-error:hover {
                background-color: #C0392B !important; /* Darker red on hover */
            }
        </style>
<div class="min-h-screen p-6 flex items-center justify-center">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Event Details</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                            
                            <div class="md:col-span-5">
                                <label for="firstname">Event Locaton</label>
                                <input type="text" name="location" id="location" placeholder="N/A if still" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $appointment->location }}" />
                            </div>

                            <div class="md:col-span-3">
                                <label for="date">Event Date</label>
                                <input type="date" name="edate" id="edate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $appointment->edate }}" />
                            </div>
                            
                            <!-- Modal Structure -->
                            <div id="datemodal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
                                    
                                    <div class="flex justify-between">
                                        <h2 class="text-lg font-bold mb-4">Date Blocked</h2>
                                        <button id="closeModal" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>
                                    </div>
                                    <p id="modalMessage">The selected date is blocked. Please choose another date.</p>
                                    
                                </div>
                            </div>
                            
                            <script>
                                var today = new Date();
                                var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 9);
                                var minDateString = minDate.toISOString().split('T')[0];
                                document.getElementById("edate").setAttribute('min', minDateString);
                            
                                // Blocked dates from the server
                                var blockedDates = @json($blockedDates); // Convert PHP array to JavaScript array
                                var bookedDates = @json($bookedDates);
                            
                                // Modal elements
                                var modal = document.getElementById('datemodal');
                                var closeModalButton = document.getElementById('closeModal');
                            
                                // Disable blocked dates in the input
                                var dateInput = document.getElementById('edate');
                            
                                dateInput.addEventListener('change', function () {
                                    var selectedDate = new Date(this.value);
                                    var formattedDate = selectedDate.toISOString().split('T')[0]; // Format the date as YYYY-MM-DD

                                    if (blockedDates.includes(formattedDate)) {
                                        showSweetAlert('The selected date is blocked due to scheduling restrictions. Please choose another date.');
                                        this.value = ''; // Clear the input
                                    } else if (bookedDates.includes(formattedDate)) {
                                        showSweetAlert('The selected date is fully booked. Please choose another date.');
                                        this.value = ''; // Clear the input
                                    }
                                });

                                // Function to show SweetAlert
                                function showSweetAlert(message) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid Date',
                                        text: message,
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            popup: 'custom-popup-error',
                                            title: 'custom-title-error',
                                            confirmButton: 'custom-button-error'
                                        }
                                    });
                                }
                            </script>
                            <style>
                                /* Error Alert Button */
                                .custom-button-error {
                                    background-color: #E07B39 !important; /* Red button background */
                                    color: white !important; /* White button text */
                                    border-radius: 5px;
                                }
                                .custom-button-error:hover {
                                    background-color: #C0392B !important; /* Darker red on hover */
                                }
                            
                                /* Customize Popup Background for Error */
                                .custom-popup-error {
                                    background-color: #FDEDEC; /* Light red background */
                                    border: 2px solid #E07B39; /* Red border */
                                }
                            
                                /* Customize Title for Error */
                                .custom-title-error {
                                    color: #E07B39; /* Red text for title */
                                    font-weight: bold;
                                }
                            </style>

                            <div class="md:col-span-2">
                                <label for="time">Event Time</label>
                                {{-- <input type="time" name="time" id="time" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                <select name="etime" id="etime" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option value="8:00 am" {{ $appointment->etime == '8:00 am' ? 'selected' : '' }}>8:00 am</option>
                                        <option value="8:30 am" {{ $appointment->etime == '8:30 am' ? 'selected' : '' }}>8:30 am</option>
                                        <option value="9:00 am" {{ $appointment->etime == '9:00 am' ? 'selected' : '' }}>9:00 am</option>
                                        <option value="9:30 am" {{ $appointment->etime == '9:30 am' ? 'selected' : '' }}>9:30 am</option>
                                        <option value="10:00 am" {{ $appointment->etime == '10:00 am' ? 'selected' : '' }}>10:00 am</option>
                                        <option value="10:30 am" {{ $appointment->etime == '10:30 am' ? 'selected' : '' }}>10:30 am</option>
                                        <option value="11:00 am" {{ $appointment->etime == '11:00 am' ? 'selected' : '' }}>11:00 am</option>
                                        <option value="11:30 am" {{ $appointment->etime == '11:30 am' ? 'selected' : '' }}>11:30 am</option>
                                        <option value="12:00 pm" {{ $appointment->etime == '12:00 pm' ? 'selected' : '' }}>12:00 pm</option>
                                        <option value="12:30 pm" {{ $appointment->etime == '12:30 pm' ? 'selected' : '' }}>12:30 pm</option>
                                        <option value="1:00 pm" {{ $appointment->etime == '1:00 pm' ? 'selected' : '' }}>1:00 pm</option>
                                        <option value="1:30 pm" {{ $appointment->etime == '1:30 pm' ? 'selected' : '' }}>1:30 pm</option>
                                        <option value="2:00 pm" {{ $appointment->etime == '2:00 pm' ? 'selected' : '' }}>2:00 pm</option>
                                        <option value="2:30 pm" {{ $appointment->etime == '2:30 pm' ? 'selected' : '' }}>2:30 pm</option>
                                        <option value="3:00 pm" {{ $appointment->etime == '3:00 pm' ? 'selected' : '' }}>3:00 pm</option>
                                        <option value="3:30 pm" {{ $appointment->etime == '3:30 pm' ? 'selected' : '' }}>3:30 pm</option>
                                        <option value="4:00 pm" {{ $appointment->etime == '4:00 pm' ? 'selected' : '' }}>4:00 pm</option>
                                        <option value="4:30 pm" {{ $appointment->etime == '4:30 pm' ? 'selected' : '' }}>4:30 pm</option>
                                        <option value="5:00 pm" {{ $appointment->etime == '5:00 pm' ? 'selected' : '' }}>5:00 pm</option>
                                        <option value="5:30 pm" {{ $appointment->etime == '5:30 pm' ? 'selected' : '' }}>5:30 pm</option>
                                        <option value="6:00 pm" {{ $appointment->etime == '6:00 pm' ? 'selected' : '' }}>6:00 pm</option>
                                        <option value="6:30 pm" {{ $appointment->etime == '6:30 pm' ? 'selected' : '' }}>6:30 pm</option>
                                        <option value="7:00 pm" {{ $appointment->etime == '7:00 pm' ? 'selected' : '' }}>7:00 pm</option>
                                        <option value="7:30 pm" {{ $appointment->etime == '7:30 pm' ? 'selected' : '' }}>7:30 pm</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="type">Event Type</label>
                                <input type="text" name="type" id="type" placeholder="(Ex. 1st Birthday)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $appointment->type }}" />
                            </div>

                            <div class="md:col-span-3">
                                <label for="theme">Event Theme</label>
                                <input type="text" name="theme" id="theme" placeholder="Enter theme" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $appointment->theme }}" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="city">Package</label>
                                {{-- <input type="text" name="package" id="package" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                <select name="package_id" id="" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    
                                    <option disabled>See the packages below</option>
                                
                                        @foreach ($packages as $pk)
                                            <option value="{{$pk->package_id}}" 
                                                @if (isset($appointment) && $appointment->package_id == $pk->package_id) selected @endif>
                                                {{$pk->packagename}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                                
                                
                                
                            </div>

                            <div class="md:col-span-5">
                                <label for="package" class="uppercase bg-yellow-100 my-10 rounded-xl py-1 px-2">Package Overview</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 mt-2 lg:grid-cols-4 gap-4">
                                    @foreach ($packages as $pk)
                                    <div class="max-w-[12rem] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-200 dark:border-gray-700">
                                        <div class="p-3">
                                            <a href="#">
                                                <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-gray-700">{{ $pk->packagename }}</h5>
                                            </a>
                                            <!-- Button to trigger showing the details -->
                                            <button type="button" onclick="toggleModal({{ $pk->package_id }})" 
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                                Read more
                                                <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                            
                                    <!-- Modal structure -->
                                    <div id="modal-{{ $pk->package_id }}" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-gray-800 bg-opacity-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-hidden flex flex-col">
                                            <div class="flex justify-between items-center">
                                                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-900">{{ $pk->packagename }}</h2>
                                                <button type="button" onclick="toggleModal({{ $pk->package_id }})" class="text-gray-600 hover:text-gray-900 font-bold text-xl">&times;</button>
                                            </div>
                                            
                                            <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Estimated Price: ₱{{ number_format($pk->packagedesc, 2) }}</p>
                            
                                            <!-- Scrollable Content Area -->
                                            <div class="mt-4 overflow-y-auto flex-grow">
                                                <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-900">
                                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                                        <tr>
                                                            <th class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 w-1/5">#</th>
                                                            <th class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 w-4/5">Inclusion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                                        @foreach (json_decode($pk->packageinclusion) as $index => $inclusion)
                                                        <tr>
                                                            <td class="px-4 py-2 w-1/5">{{ $index + 1 }}</td>
                                                            <td class="px-4 py-2 w-4/5">{{ $inclusion }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <script>
                                // Function to toggle visibility of the modal
                                function toggleModal(packageId) {
                                    console.log("Toggling modal for package ID: " + packageId); // Log for debugging
                            
                                    // Find the modal for the specific package
                                    const modal = document.getElementById('modal-' + packageId);
                            
                                    // Check if the modal container was found
                                    if (modal) {
                                        // Toggle the 'hidden' class to show/hide the modal
                                        modal.classList.toggle('hidden');
                                        console.log("Modal toggled: ", modal.classList.contains('hidden') ? "Hidden" : "Visible");
                                    } else {
                                        console.error("Modal not found for package ID: " + packageId);
                                    }
                                }
                            
                                // Prevent page reloads when closing modal and not submitting forms
                                document.querySelectorAll('button[type="button"]').forEach(button => {
                                    button.addEventListener('click', function(event) {
                                        event.preventDefault(); // Prevent form submission or page reload
                                    });
                                });
                            </script>
                            
                            
                            

                            {{-- @foreach ($packages as $pk)
                                <h1>{{$pk->packagename}}</h1>
                            @endforeach --}}

                        </div>
                    </div>
                </div>

                <hr class="my-5 border-yellow-100">

                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                    <div class="text-gray-600">
                        <p class="font-medium text-lg">Meeting Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>
                
                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                
                            <div class="md:col-span-3">
                                <label for="appointment_date">Meeting Date</label>
                                <input disabled type="date" name="appointment_date" id="appointment_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_datetime)->format('Y-m-d')) }}" />
                            </div>
                
                            <div class="md:col-span-2">
                                <label for="appointment_time">Meeting Time</label>
                                <select disabled name="appointment_time" id="appointment_time" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <!-- Options will be populated by JavaScript -->
                                    <option disabled selected value="">Select appointment time</option>
                                    <option 
                                        value="{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('H:i') }}" 
                                        selected>
                                        {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('h:i A') }}
                                    </option>
                                </select>
                            </div>
                
                            <div class="md:col-span-5 text-right">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 cursor-pointer text-white font-bold py-2 px-4 rounded" onclick="showLoadingOverlay()">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading animation overlay -->
                <div id="loadingOverlay" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                    <div class="flex flex-col items-center">
                        <div id="loaderSpinner" class="loader border-t-4 border-yellow-500 rounded-full w-16 h-16 animate-spin"></div>
                        <p class="text-white mt-4 font-semibold" id="loadingText">Your request is being processed</p>
                    </div>
                </div>


                <!-- Styling for loading animation -->
                <style>
                    /* Spinner animation */
                    .loader {
                        border: 4px solid rgba(255, 255, 255, 0.3);
                        border-top-color: #f59e0b; /* Yellow color */
                        border-radius: 50%;
                        width: 3rem;
                        height: 3rem;
                        animation: spin 1s linear infinite;
                    }

                    @keyframes spin {
                        0% {
                            transform: rotate(0deg);
                        }
                        100% {
                            transform: rotate(360deg);
                        }
                    }
                </style>

                <script>
                    // Show the loading overlay when the form is submitted
                    function showLoadingOverlay() {
                        document.getElementById('loadingOverlay').classList.remove('hidden');
                    }

                    window.onload = function() {
                        @if (session('alert'))
                            // Only show the overlay if there's an alert
                            const alertType = "{{ session('alert') }}";
                            const alertMessage = "{{ session('message') }}";

                            // Ensure the overlay is visible
                            document.getElementById('loadingOverlay').classList.remove('hidden');
                            const loadingTextElement = document.getElementById('loadingText');
                            const loaderSpinner = document.getElementById('loaderSpinner');

                            // Set the alert message text
                            loadingTextElement.textContent = alertMessage;

                            // Hide the spinner if alert is success or error
                            if (alertType === 'success' || alertType === 'error') {
                                loaderSpinner.classList.add('hidden');
                            }

                            // Hide the overlay after 3 seconds
                            setTimeout(function() {
                                document.getElementById('loadingOverlay').classList.add('hidden');
                            }, 3000); // Adjust the time as needed
                        @endif
                    };
                </script>


                <!-- Modal Structure -->
                <div id="datemodal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-bold mb-4">Date Blocked</h2>
                            <button id="closeModal" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>
                        </div>
                        <p id="modalMessage">The selected date is blocked. Please choose another date.</p>
                    </div>
                </div>
                
                
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var dateInput = document.getElementById('appointment_date');
                        var timeSelect = document.getElementById('appointment_time');
                        var eventDateInput = document.getElementById('edate'); // Reference to event date
                        var blockedApps = @json($blockedApps); // Convert PHP array to JavaScript array
                        var blockedDates = @json($blockedDates); // Convert PHP array to JavaScript array
                        var scheduledMeeting = @json($scheduledMeeting);
                        var modal = document.getElementById('datemodal');
                        var closeModalButton = document.getElementById('closeModal');
                
                        // Existing function to populate time options
                        function populateTimes() {
                            var startTime = new Date();
                            startTime.setHours(9, 0); // 9 AM
                            var endTime = new Date();
                            endTime.setHours(18, 0); // 6 PM
                
                            var options = '';
                            var oldTime = "{{ old('appointment_time') }}"; // Get the old value from the server
                            while (startTime <= endTime) {
                                var hours = startTime.getHours();
                                var minutes = startTime.getMinutes();
                                
                                // Format the time string for saving in 24-hour format (HH:mm)
                                var timeString = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
                                
                                // Convert to 12-hour format for display (hh:mm AM/PM)
                                var displayHours = hours % 12 || 12; // Convert to 12-hour format
                                var displayMinutes = minutes === 0 ? '00' : '30'; // Display minutes as '00' or '30'
                                var ampm = hours < 12 ? 'AM' : 'PM'; // AM/PM suffix
                                var displayTime = displayHours + ':' + displayMinutes + ' ' + ampm;

                                // Compare old time to highlight the selected option
                                var selected = (oldTime === timeString) ? 'selected' : '';
                                
                                // Append the option to the options string
                                options += `<option value="${timeString}" ${selected}>${displayTime}</option>`;
                                
                                // Increment the time by 30 minutes
                                startTime.setMinutes(startTime.getMinutes() + 30);
                            }

                            timeSelect.innerHTML += options;
                        }
                
                        function setAppointmentDateRange() {
                            var today = new Date();
                            var edate = new Date(eventDateInput.value); // Parse the edate value
                            var maxDate = new Date(edate);
                            maxDate.setDate(maxDate.getDate() - 7); // Set max date to one week before edate

                            // Format dates as 'YYYY-MM-DD'
                            var todayString = today.toISOString().slice(0, 10); // 'YYYY-MM-DD'
                            var maxDateString = maxDate.toISOString().slice(0, 10); // 'YYYY-MM-DD'

                            // Set min and max attributes for appointment_date
                            dateInput.setAttribute('min', todayString); // Today is the minimum selectable date
                            dateInput.setAttribute('max', maxDateString); // One week before edate is the maximum selectable date
                        }
                
                        // Function to update meeting date and time input states
                        function updateMeetingDetailsState() {
                            if (eventDateInput.value) {
                                dateInput.disabled = false; // Enable meeting date input
                                timeSelect.disabled = false; // Enable meeting time input
                                setAppointmentDateRange();
                            } else {
                                dateInput.disabled = true; // Disable meeting date input
                                timeSelect.disabled = true; // Disable meeting time input
                                dateInput.value = ''; // Clear the meeting date input
                                timeSelect.selectedIndex = 0; // Reset the time select
                            }
                        }

                        // Function to check if the selected date and time combination is already scheduled
                        function checkScheduledMeeting(selectedDate, selectedTime) {
                            // Format the selected date and time into 'YYYY-MM-DD HH:mm:ss' format
                            var formattedDate = selectedDate.toISOString().split('T')[0]; // Get date as 'YYYY-MM-DD'
                            var formattedTime = selectedTime.padStart(5, '0'); // Ensure time is in HH:mm format (e.g. 4:00 -> 04:00)
                            
                            var selectedDateTime = formattedDate + ' ' + formattedTime + ':00'; // Combine into full datetime (YYYY-MM-DD HH:mm:ss)

                            // Check if the selected date-time combination already exists in the scheduled meetings
                            if (scheduledMeeting.includes(selectedDateTime)) {
                                return true; // Conflict found
                            }
                            return false; // No conflict
                        }

                        // Add event listener for the date input field
                        dateInput.addEventListener('change', function () {
                            var selectedDate = new Date(this.value);
                            var selectedTime = timeSelect.value; // Get the selected time

                            // Only check if both date and time are selected
                            if (selectedDate && selectedTime) {
                                // Check for conflict
                                if (checkScheduledMeeting(selectedDate, selectedTime)) {
                                    // Alert the user about the conflict
                                    showSweetAlert('The selected appointment date and time is already scheduled by another client. Please choose another time.');

                                    // Reset the inputs if conflict is found
                                    this.value = ''; // Clear the date input
                                    timeSelect.selectedIndex = 0; // Reset the time select
                                }
                            }
                        });

                        // Add event listener for the time input field
                        timeSelect.addEventListener('change', function () {
                            var selectedDate = new Date(dateInput.value); // Get the selected date
                            var selectedTime = this.value; // Get the selected time

                            // Only check if both date and time are selected
                            if (selectedDate && selectedTime) {
                                // Check for conflict
                                if (checkScheduledMeeting(selectedDate, selectedTime)) {
                                    // Alert the user about the conflict
                                    showSweetAlert('The selected appointment date and time is already scheduled by another client. Please choose another time.');

                                    // Reset the time select input if conflict is found
                                    this.selectedIndex = 0; // Reset the time select
                                }
                            }
                        });

                        // Function to show the SweetAlert
                        function showSweetAlert(message) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid Appointment',
                                text: message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'custom-popup-error',
                                    title: 'custom-title-error',
                                    confirmButton: 'custom-button-error'
                                }
                            });
                        }
                
                        // Check if the selected date is blocked and show modal if it is
                        dateInput.addEventListener('change', function () {
                            var selectedDate = new Date(this.value);
                            var formattedDate = selectedDate.toISOString().split('T')[0];
                
                            if (blockedDates.includes(formattedDate) || blockedApps.includes(formattedDate)) {
                                showSweetAlert('The selected meeting date is blocked. Please choose another date.');
                                this.value = ''; // Clear the input
                            }
                        });
                
                        function showSweetAlert(message) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid Date',
                                        text: message,
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            popup: 'custom-popup-error',
                                            title: 'custom-title-error',
                                            confirmButton: 'custom-button-error'
                                        }
                                    });
                                }
                
                        // Event listener for event date input change
                        eventDateInput.addEventListener('change', updateMeetingDetailsState);
                        
                        // Initial call to set the correct state based on current value
                        updateMeetingDetailsState();
                
                        populateTimes();
                        setMinDate();
                    });
                </script>
                <style>
                    /* Error Alert Button */
                    .custom-button-error {
                        background-color: #E07B39 !important; /* Red button background */
                        color: white !important; /* White button text */
                        border-radius: 5px;
                    }
                    .custom-button-error:hover {
                        background-color: #C0392B !important; /* Darker red on hover */
                    }
                
                    /* Customize Popup Background for Error */
                    .custom-popup-error {
                        background-color: #FDEDEC; /* Light red background */
                        border: 2px solid #E07B39; /* Red border */
                    }
                
                    /* Customize Title for Error */
                    .custom-title-error {
                        color: #E07B39; /* Red text for title */
                        font-weight: bold;
                    }
                </style>
                

<script>
    document.getElementById('edate').addEventListener('change', function() {
        const edate = new Date(this.value);
        // Set maximum date for appointment_date to 7 days before edate
        const maxDate = new Date(edate);
        maxDate.setDate(maxDate.getDate() - 7);
        
        const today = new Date();
        const appointmentDateInput = document.getElementById('appointment_date');

        // Set the min and max attributes for appointment_date
        appointmentDateInput.setAttribute('min', today.toISOString().split('T')[0]); // Set min to today
        appointmentDateInput.setAttribute('max', maxDate.toISOString().split('T')[0]); // Set max to 7 days before edate
    });
</script>
                
                
                

                
            </div>
        </div>
    </div>
</div>
</form>

<div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="relative max-w-sm max-h-[75vh] bg-white  rounded-lg shadow-lg">
            <button class="absolute top-0 right-0 m-4 text-white" onclick="closeModal()">
                <i class="fa-solid text-black fa-xmark text-3xl"></i>
            </button>
            <div id="modal-content" class="border rounded-lg border-gray-700"></div>
        </div>
    </div>
</div>


</div>
<script>
    function openModal(imageSrc) {
        var modal = document.getElementById('modal');
        var modalContent = document.getElementById('modal-content');
        modalContent.innerHTML = '<img src="' + imageSrc + '" class="max-w-full max-h-full rounded-lg">';
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Close modal when clicked anywhere outside of the modal content
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    function closeModal() {
        var modal = document.getElementById('modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>

</x-app-layout>

