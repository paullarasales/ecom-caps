<x-app-layout>
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


    <div class="text-center py-2 mt-20">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Event <span class="text-yellow-600">Calendar</span>
        </h3>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route("events") }}', 
                eventDataTransform: function(eventData) {
                // Override the event title with "Reserved"
                eventData.title = 'Booked';
                return eventData;
                }, // Use the correct route name
                eventMouseEnter: function(info) {
                // Create a tooltip element
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.innerText = 'We can cater up to 3 events per day';
                
                // Style the tooltip
                tooltip.style.position = 'absolute';
                tooltip.style.background = '#EEEDEB';
                tooltip.style.color = '#021526';
                tooltip.style.padding = '5px 10px';
                tooltip.style.borderRadius = '4px';
                tooltip.style.fontSize = '15px';
                tooltip.style.pointerEvents = 'none';
                
                document.body.appendChild(tooltip);

                // Position the tooltip near the event
                tooltip.style.left = (info.jsEvent.pageX + 10) + 'px';
                tooltip.style.top = (info.jsEvent.pageY + 10) + 'px';

                // Store the tooltip reference in the event element
                info.el.tooltip = tooltip;
            },
            eventMouseLeave: function(info) {
                // Remove the tooltip when the mouse leaves the event
                if (info.el.tooltip) {
                    info.el.tooltip.remove();
                    info.el.tooltip = null;
                }
            }
            });
            calendar.render();
        });
    </script>
    
    <div class="row jsutify-content-center">
        <div class="col-md-8">
            <div class="card lg:mx-40 lg:mb-10">
                <div class="card-header">
                    <div class="card-body">
                        <div id="calendar">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center my-5">
        <h1>
            <i class="fa-solid fa-thumbtack mr-2 text-yellow-700"></i>
            We can cater up to 3 events per day
        </h1>
        <a href="{{ route('book-form') }}" class="bg-yellow-200 rounded-3xl py-3 px-8 font-medium hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 border border-t mt-4">
            Book Event
        </a>
    </div>
</x-app-layout>
