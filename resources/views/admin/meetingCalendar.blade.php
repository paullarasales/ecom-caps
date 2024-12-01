<x-admin-layout>
    <style>
        /* Example CSS to adjust the font size in the calendar */
        #calendar .fc-event-title {
            font-size: 14px; /* Adjust this value as needed */
        }
        #calendar .fc-daygrid-day-number {
            font-size: 12px; /* Adjust this value as needed */
        }
        #calendar .fc-daygrid-day-top {
            font-size: 16px; /* Adjust this value as needed */
        }
        #calendar .fc-toolbar-title {
    font-size: 30px; /* Default size for larger screens */
}

/* Adjust font size for smaller screens */
@media (max-width: 768px) { /* Adjust the max-width value as needed */
    #calendar .fc-toolbar-title {
        font-size: 16px; /* Adjust this value for tablets and smaller screens */
    }
}

@media (max-width: 480px) { /* For very small screens like phones */
    #calendar .fc-toolbar-title {
        font-size: 18px; /* Adjust this value for phones */
    }
}

.fc-event-title {
    color: gray;
}

.fc-event.blocked-event {
    color: white;
}



    </style>

    <div class="flex ml-3">
        <a href="{{ route('adminappointments') }}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Meeting <span class="text-yellow-600">Calendar</span>
        </h3>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route("meetingCalendar") }}',  // Use the correct route name
                eventClick: function(info) {
                    // Update modal content
                    document.getElementById('eventTitle').textContent = 'Meeting: ' + info.event.title;
    
                    if (info.event.classNames.includes('blocked-event')) {
                        document.getElementById('modalText').textContent = 'This date is blocked: ' + info.event.title;
                        document.getElementById('blockDateForm').classList.add('hidden'); // Hide the blocking form
                        document.getElementById('unblockDateForm').classList.remove('hidden'); // Show unblock form
                        document.getElementById('unblocked_date').value = info.event.startStr; // Set the hidden input for unblocking
                    } else {
                        // Normal event behavior
                        document.getElementById('modalText').textContent = 'Details: ' + info.event.title;

                        // Hide the block form if the event is scheduled
                        document.getElementById('blockDateForm').classList.add('hidden'); // Hide the form for blocking
                        document.getElementById('unblockDateForm').classList.add('hidden'); // Ensure unblock form is hidden as well
                    }
    
                    // Show the modal
                    document.getElementById('eventModal').classList.remove('hidden');
                    
                    // Prevent browser navigation
                    info.jsEvent.preventDefault();
                },
                dateClick: function(info) {
                    // Format the clicked date for display
                    const formattedDate = new Intl.DateTimeFormat('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }).format(new Date(info.dateStr));

                    // Get all events on the clicked date
                    const eventsOnDate = calendar.getEvents().filter(event => {
                        // We need to compare only the date part, not the time
                        const eventDate = event.startStr.split('T')[0];  // Extract just the date portion
                        return eventDate === info.dateStr;  // Compare with clicked date
                    });

                    // Check if the date has any events
                    if (eventsOnDate.length > 0) {
                        // If there are events, check if the date is blocked
                        const isBlockedDate = eventsOnDate.some(event => event.classNames.includes('blocked-event'));

                        if (isBlockedDate) {
                            // Date is blocked, show the option to unblock
                            document.getElementById('eventTitle').textContent = 'Blocked Date: ' + formattedDate;
                            document.getElementById('modalText').textContent = 'This date is blocked. You can unblock it.';
                            document.getElementById('blockDateForm').classList.add('hidden'); // Hide the blocking form
                            document.getElementById('unblockDateForm').classList.remove('hidden'); // Show unblock form
                            document.getElementById('unblocked_date').value = info.dateStr; // Set the hidden input for unblocking
                        } else {
                            // Date has events but is not blocked, show the number of events
                            document.getElementById('eventTitle').textContent = 'Events on ' + formattedDate;
                            document.getElementById('modalText').textContent = 'There are ' + eventsOnDate.length + ' meeting(s) on this date. You cannot block this date.';
                            document.getElementById('blockDateForm').classList.add('hidden'); // Hide the block form
                            document.getElementById('unblockDateForm').classList.add('hidden'); // Also hide the unblock form
                        }
                    } else {
                        // No events on this date, allow the user to block it
                        document.getElementById('eventTitle').textContent = 'Vacant Date: ' + formattedDate;
                        document.getElementById('modalText').textContent = 'This date is vacant. You can block it.';
                        document.getElementById('blocked_date').value = info.dateStr; // Set the hidden input for blocking
                        document.getElementById('blockDateForm').classList.remove('hidden'); // Show the block form
                        document.getElementById('unblockDateForm').classList.add('hidden'); // Hide the unblock form
                    }

                    // Show the modal for the clicked date
                    document.getElementById('eventModal').classList.remove('hidden');
                }

            });
    
            calendar.render();

            // Close the modal
            document.getElementById('closeButton').addEventListener('click', function() {
                document.getElementById('eventModal').classList.add('hidden');
            });
        });
    </script>
    
    <div class="row jsutify-content-center">
        <div class="col-md-8">
            <div class="card lg:mx-5 lg:my-5">
                <div class="card-header">
                    <div class="card-body">
                        <div id="calendar">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden flex items-center justify-center">
        <!-- Modal Container -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold" id="eventTitle">Event Details</h3>
                <button id="closeButton" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>
            </div>
            
            <!-- Modal Content -->
            <div id="modalContent" class="text-gray-700">
                <p id="modalText">Details will appear here.</p>
    
                <!-- Form for blocking a date -->
                <form id="blockDateForm" action="{{ route('admin.appblock') }}" method="POST" class="hidden mt-4">
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
                    <input type="hidden" name="blocked_app" id="blocked_date" value="">
                    
                    <label for="reason" class="block text-gray-700">Reason for blocking:</label>
                    <input type="text" name="appreason" id="reason" class="border rounded p-2 w-full" required>
                    
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-2">Block Date</button>
                </form>
    
                <!-- Form for unblocking a date -->
                <form id="unblockDateForm" action="{{ route('admin.appunblock') }}" method="POST" class="hidden mt-4">
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
                    <input type="hidden" name="unblocked_app" id="unblocked_date" value="">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-2">Unblock Date</button>
                </form>
            </div>
        </div>
    </div>


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
</x-admin-layout>