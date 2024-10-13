<x-manager-layout>
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
    color: white;
}

.fc-event.blocked-event {
    color: white;
}

    </style>

    <div class="flex ml-3">
        <a href="{{route('managerappointments')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Event <span class="text-yellow-600">Calendar</span>
        </h3>

    </div>

    {{-- <div>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
        <div class=" p-6 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
                <div>
                    <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                                <div class="text-gray-600">
                                    <p class="font-medium text-lg">Personal Details</p>
                                    <p>Please fill out all the fields.</p>
                                </div>
        
                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-3">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" id="firstname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                                    </div>
        
                                    <div class="md:col-span-2">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname" id="lastname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                                    </div>
        
                                    
    
                                    
        
                                    <div class="md:col-span-5 text-right">
                                        <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    </div>
        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div> --}}
    


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route("managercalendar") }}',  // Use the correct route name
                eventClick: function(info) {
                    // Update modal content
                    document.getElementById('eventTitle').textContent = 'Event: ' + info.event.title;
    
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
                    // Format the date for display
                    const formattedDate = new Intl.DateTimeFormat('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }).format(new Date(info.dateStr));
    
                    // Check if there are events on the clicked date
                    const eventsOnDate = calendar.getEvents().filter(event => event.startStr === info.dateStr);
                    const isBlockedDate = eventsOnDate.some(event => event.classNames.includes('blocked-event'));
    
                    if (isBlockedDate) {
                        document.getElementById('eventTitle').textContent = 'Blocked Date: ' + formattedDate;
                        document.getElementById('modalText').textContent = 'This date is blocked. You can unblock it.';
                        document.getElementById('blockDateForm').classList.add('hidden'); // Hide the form for blocking
                        document.getElementById('unblockDateForm').classList.remove('hidden'); // Show unblock form
                        document.getElementById('unblocked_date').value = info.dateStr; // Set the hidden input for unblocking
                    } else if (eventsOnDate.length > 0) {
                        document.getElementById('eventTitle').textContent = 'Events on ' + formattedDate;
                        document.getElementById('modalText').textContent = 'There are ' + eventsOnDate.length + ' event(s) on this date.';
                        document.getElementById('blockDateForm').classList.add('hidden'); // Hide the form if events exist
                        document.getElementById('unblockDateForm').classList.add('hidden'); // Hide unblock form
                    } else {
                        document.getElementById('eventTitle').textContent = 'Vacant Date: ' + formattedDate;
                        document.getElementById('modalText').textContent = 'This date is vacant. You can block it.';
                        
                        // Show the form and set the hidden date field
                        document.getElementById('blocked_date').value = info.dateStr;
                        document.getElementById('blockDateForm').classList.remove('hidden'); // Show the form
                        document.getElementById('unblockDateForm').classList.add('hidden'); // Hide unblock form
                    }
    
                    // Show the modal
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
    
    
    <div class="row jsutify-content-center ">
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


    <!-- Modal Background -->
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
            <form id="blockDateForm" action="{{ route('manager.block') }}" method="POST" class="hidden mt-4">
                @csrf
                <input type="hidden" name="blocked_date" id="blocked_date" value="">
                
                <label for="reason" class="block text-gray-700">Reason for blocking:</label>
                <input type="text" name="reason" id="reason" class="border rounded p-2 w-full" required>
                
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-2">Block Date</button>
            </form>

            <!-- Form for unblocking a date -->
            <form id="unblockDateForm" action="{{ route('manager.unblock') }}" method="POST" class="hidden mt-4">
                @csrf
                <input type="hidden" name="unblocked_date" id="unblocked_date" value="">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-2">Unblock Date</button>
            </form>
        </div>
    </div>
</div>




@if(session('alert'))
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
@endif


</x-manager-layout>