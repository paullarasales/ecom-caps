<x-app-layout>


    <div class="text-center py-4 lg:my-20 my-10">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Details</span>
        </h3>
    </div>

    <form action="{{route('client.appointment.meeting.save', $appointment->appointment_id)}}" method="POST" enctype="multipart/form-data" id="appointmentForm">
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
    <div class="p-6 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <div>
                <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Meeting Details</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                                <div class="md:col-span-3">
                                    <label for="appointment_date">Meeting Date</label>
                                    <input type="date" name="appointment_date" id="appointment_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_datetime)->format('Y-m-d')) }}" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="appointment_time">Meeting Time</label>
                                    <select name="appointment_time" id="appointment_time" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option disabled selected value="">Select appointment time</option>
                                        <!-- Options will be populated by JavaScript -->
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
                            var blockedApps = @json($blockedApps); // Convert PHP array to JavaScript array
                            // var blockedDates = @json($blockedDates); // Convert PHP array to JavaScript array
                            var scheduledMeeting = @json($scheduledMeeting);
                            var modal = document.getElementById('datemodal');
                            var closeModalButton = document.getElementById('closeModal');

                            // Populate time options
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

                                if ( blockedApps.includes(formattedDate)) {
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

                            // Initial setup
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

                </div>
            </div>
        </div>
    </div>
</form>

    <!-- Alert messages -->
    {{-- @if(session('alert'))
        <div class="fixed top-0 right-0 mt-4 mr-4 px-4 py-2 bg-green-400 text-white rounded shadow-lg flex items-center space-x-2">
            <span>{{ session('alert') }}</span>
            <button onclick="this.parentElement.remove()" class="text-white bg-green-600 hover:bg-green-700 rounded-full p-1">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    @elseif(session('error'))
        <div class="fixed top-0 right-0 mt-4 mr-4 px-4 py-2 bg-red-400 text-white rounded shadow-lg flex items-center space-x-2">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-white bg-red-600 hover:bg-red-700 rounded-full p-1">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    @endif --}}




</x-app-layout>