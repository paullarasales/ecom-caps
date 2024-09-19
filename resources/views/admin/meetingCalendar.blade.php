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

    </style>

    <div class="flex ml-3">
        <a href="{{route('adminappointments')}}">
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
            // Update modal content with event information
            document.getElementById('eventTitle').textContent = 'Meeting for: ' + info.event.title;
            document.getElementById('modalContent').textContent = 'Client : ' + info.event.extendedProps.info;

            // Show the modal
            document.getElementById('eventModal').classList.remove('hidden');

            // Prevent browser navigation
            info.jsEvent.preventDefault();
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


    <!-- Modal Background -->
    <div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden flex items-center justify-center">
        <!-- Modal Container -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold mr-4" id="eventTitle">Event Details</h3>
                <button id="closeButton" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>

            </div>
            <div id="modalContent" class="text-gray-700 font-bold">
                <!-- Event details will be inserted here -->
            </div>
            <div class="flex justify-end mt-4">
                {{-- <button id="closeButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Close</button> --}}
            </div>
        </div>
    </div>



</x-admin-layout>