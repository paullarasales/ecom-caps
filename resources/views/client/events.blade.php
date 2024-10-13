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
.fc-event-title {
    color: white;
}

.fc-event.blocked-event {
    color: white;
}

    </style>


    <div class="text-center py-2 mt-20">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Event <span class="text-yellow-600">Calendar</span>
        </h3>

    </div>


    {{-- <script>
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
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route("events") }}',
                eventSourceSuccess: function(content) {
                const eventCounts = {}; // Object to store the count of events by date

                // Count booked events by date
                content.forEach(event => {
                    if (event.color === '#ffc107') { // Only count booked events
                        const eventDate = event.start.slice(0, 10); // Extract the date part (YYYY-MM-DD)
                        if (!eventCounts[eventDate]) {
                            eventCounts[eventDate] = 0;
                        }
                        eventCounts[eventDate]++;
                    }
                });

                // Modify the events based on the aggregation
                return content.map((event) => {
                    const eventDate = event.start.slice(0, 10); // Extract the date part (YYYY-MM-DD)
                    if (event.color === '#ffc107') {
                        if (eventCounts[eventDate] > 0) {
                            // Set the title as "Booked (n)" only for the first occurrence of a booked event
                            event.title = `Booked ${eventCounts[eventDate]} event(s)`;
                            // Hide this event by removing it after setting its title
                            eventCounts[eventDate] = 0; // Prevent counting again
                        } else {
                            // For subsequent events, return null to hide them
                            return null; // Hide subsequent booked events
                        }
                    }
                    return event; // Return modified event or null
                }).filter(event => event !== null); // Filter out null values
            },
                eventMouseEnter: function(info) {
                    // Create a tooltip element
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    if (info.event.classNames.includes('blocked-event')) {
                    tooltip.innerText = info.event.title; // Title of the blocked date
                    } else {
                        tooltip.innerText = 'We can cater up to 3 events per day';
                    } // Use the title of the event
                    
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
