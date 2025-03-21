<div class="text-center lg:mt-20 mt-10">
    <a href="{{ route('meetingform') }}" class="bg-yellow-200 text-gray-700 rounded-3xl py-3 px-8 font-medium inline-block mr-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t">
        Schedule A Meeting Only
        <i class="fa-solid fa-arrow-right ml-3"></i>
    </a>
</div>

<form action="/appointment" method="POST" id="appointmentForm">
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
                                <input type="text" name="location" id="location" placeholder="Enter Location" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('location') }}" />
                            </div>

                            <div class="md:col-span-3">
                                <label for="date">Event Date</label>
                                <input type="date" name="edate" id="edate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('edate') }}" />
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
                                        showSweetAlert('The selected date is unavailable due to scheduling restrictions. Please choose another date.');
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
                                        title: 'Unavailable Date',
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
                                    <option disabled selected>Select your time</option>
                                    @foreach ([
                                        "8:00 am", "8:30 am", "9:00 am", "9:30 am", "10:00 am", "10:30 am",
                                        "11:00 am", "11:30 am", "12:00 pm", "12:30 pm", "1:00 pm", "1:30 pm",
                                        "2:00 pm", "2:30 pm", "3:00 pm", "3:30 pm", "4:00 pm", "4:30 pm",
                                        "5:00 pm", "5:30 pm", "6:00 pm", "6:30 pm", "7:00 pm", "7:30 pm"
                                    ] as $time)
                                        <option value="{{ $time }}" {{ old('etime') == $time ? 'selected' : '' }}>
                                            {{ $time }}
                                        </option>
                                    @endforeach
                                    <option disabled selected></option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="type">Event Type</label>
                                <input type="text" name="type" id="type" placeholder="(Ex. 1st Birthday)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('type') }}" />
                            </div>

                            <div class="md:col-span-3">
                                <label for="theme">Event Theme</label>
                                <input type="text" name="theme" id="theme" placeholder="Enter theme" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('type') }}" />
                            </div>

                            <!-- Hidden input to store the selected package -->
                            <input type="hidden" id="selected-package" name="package_id" value="">
                            <div class="md:col-span-5">
                                <label for="package" class="uppercase bg-yellow-100 my-10 rounded-xl py-1 px-2">Preferred Package</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 mt-2 lg:grid-cols-4 gap-4">
                                    @foreach ($packages as $pk)
                                    <div id="package-card-{{ $pk->package_id }}" 
                                        class="max-w-[12rem] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-200 dark:border-gray-700">
                                        <div class="p-3">
                                            <a href="#">
                                                <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-gray-700">
                                                    {{ $pk->packagename }}
                                                </h5>
                                            </a>
                                            <!-- Button to trigger showing the details -->
                                            <button type="button" onclick="toggleModal({{ $pk->package_id }})" 
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                                See Details
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
                            
                                            <!-- Confirm Selection Button -->
                                            <div class="mt-4 flex justify-end">
                                                <button type="button" onclick="confirmSelection({{ $pk->package_id }}, '{{ $pk->packagename }}')" 
                                                        class="px-4 py-2 text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300">
                                                    Confirm Selection
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <script>
                                // Function to toggle visibility of the modal
                                function toggleModal(packageId) {
                                    const modal = document.getElementById('modal-' + packageId);
                                    if (modal) {
                                        modal.classList.toggle('hidden');
                                    }
                                }
                            
                                // Function to confirm package selection
                                function confirmSelection(packageId, packageName) {
                                    // Close the modal
                                    toggleModal(packageId);

                                    // Set the selected package in a hidden input field
                                    const selectedPackageInput = document.getElementById('selected-package');
                                    if (selectedPackageInput) {
                                        selectedPackageInput.value = packageId;
                                    }

                                    // Remove the 'selected' class from all package cards
                                    document.querySelectorAll('[id^="package-card-"]').forEach(card => {
                                        card.classList.remove('selected');
                                    });

                                    // Add the 'selected' class to the currently selected package card
                                    const selectedCard = document.getElementById('package-card-' + packageId);
                                    if (selectedCard) {
                                        selectedCard.classList.add('selected');
                                    }
                                }

                            </script>
                            <style>
                                .selected {
                                    background-color: #fef08a; /* Light yellow */
                                    border-color: #2b2920; /* Yellow border */
                                }
                            </style>
                            
                            
                            
                            
                            
                            
                            
                            

                            {{-- @foreach ($packages as $pk)
                                <h1>{{$pk->packagename}}</h1>
                            @endforeach --}}

                        </div>
                        <div class="flex justify-center mt-5">
                            <a href="{{route('custom.client.inclusion')}}" class="bg-yellow-500 text-center hover:bg-yellow-700 text-white font-bold px-4 py-2 text-xs w-32 rounded-lg">
                                Customize
                                <i class="fa-solid fa-pencil ml-5"></i>
                            </a>
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
                                <input disabled type="date" name="appointment_date" id="appointment_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('appointment_date') }}" />
                            </div>
                
                            <div class="md:col-span-2">
                                <label for="appointment_time">Meeting Time</label>
                                <select disabled name="appointment_time" id="appointment_time" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <!-- Options will be populated by JavaScript -->
                                    <option disabled selected value="">Select appointment time</option>
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


                {{-- <!-- Modal Structure -->
                <div id="datemodal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-bold mb-4">Date Blocked</h2>
                            <button id="closeModal" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>
                        </div>
                        <p id="modalMessage">The selected date is blocked. Please choose another date.</p>
                    </div>
                </div> --}}
                
                
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
                
                        // Ensure that the date input only allows future dates
                        function setMinDate() {
                            var today = new Date();
                            var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1); // Tomorrow
                            var minDateString = minDate.toISOString().slice(0, 10); // Format as 'YYYY-MM-DD'
                            dateInput.setAttribute('min', minDateString);
                        }
                
                        // Function to update meeting date and time input states
                        function updateMeetingDetailsState() {
                            if (eventDateInput.value) {
                                dateInput.disabled = false; // Enable meeting date input
                                timeSelect.disabled = false; // Enable meeting time input
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
                                title: 'Unavailable',
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
                
                            if (blockedApps.includes(formattedDate)) {
                                showSweetAlert('The selected meeting date is unavailable. Please choose another date.');
                                this.value = ''; // Clear the input
                            }
                        });
                
                        // Function to show SweetAlert
                        function showSweetAlert(message) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Unavailable Date',
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

@if (session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK',
        customClass: {
        popup: 'custom-popup',
        title: 'custom-title',
        confirmButton: 'custom-button'
    }
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'custom-popup-error',
            title: 'custom-title-error',
            confirmButton: 'custom-button-error'
        }
    });
</script>
@endif

<style>
/* Success Alert Button */
.custom-button {
        background-color: #FFCF81 !important; /* Orange button background */
        color: white !important; /* White button text */
        border-radius: 5px;
    }
    .custom-button:hover {
        background-color: #E07B39 !important; /* Darker orange on hover */
    }

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


