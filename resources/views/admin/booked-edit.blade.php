<x-admin-layout>

    <div class="flex ml-3">
        <a href="{{ route('bookedView', $appointment->appointment_id)}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Event Details</span>
        </h3>

    </div>

    <form id="acceptForm" action="{{  route('appointment.save', $appointment->appointment_id) }}" method="POST">
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
    <div class="h-90 p-6 flex items-center justify-center">
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
                                    <input type="text" name="location" id="location" placeholder="N/A if still" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{$appointment->location}}" />
                                </div>
    
                                <div class="md:col-span-3">
                                    <label for="date">Event Date</label>
                                    <input type="date" name="edate" id="edate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{$appointment->edate}}" />
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
                                    <label for="etime">Event Time</label>
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
                                        {{-- <option disabled selected></option> --}}
                                    </select>
                                </div>
    
    
                                <div class="md:col-span-2">
                                    <label for="email">Event Type</label>
                                    <input type="text" name="type" id="type" placeholder="(Ex. 1st Birthday)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{$appointment->type}}" />
                                </div>

                                <div class="md:col-span-3">
                                    <label for="theme">Event Theme</label>
                                    <input type="text" name="theme" id="theme" placeholder="Enter theme" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $appointment->theme }}" />
                                </div>
    
                                {{-- <div class="md:col-span-5">
                                    <label for="city">Package</label>

                                    <select name="package_id" id="" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        
                                        <option disabled selected>See the packages below</option>
                                
                                        @foreach ($packages as $pk)
                                            <option value="{{$pk->package_id}}" 
                                                @if (isset($appointment) && $appointment->package_id == $pk->package_id) selected @endif>
                                                {{$pk->customPackage->target}} - {{$pk->packagename}}
                                            </option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                
    
                                <div class="md:col-span-5">
                                    <label for="package" class="uppercase bg-yellow-100 my-10 rounded-xl py-1 px-2">Available Packages</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 mt-2 lg:grid-cols-4 gap-4">
                                        @foreach ($packages as $pk)
                                            <div class="max-w-[12rem] 
                                            @if($pk->appointment->isNotEmpty())
                                            bg-white border border-gray-200 rounded-lg shadow dark:bg-yellow-200 dark:border-gray-700
                                            @else
                                            bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-200 dark:border-gray-700
                                            @endif
                                            ">
                                                <div class="p-3">
                                                    <a href="#">
                                                        <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-gray-700">{{ $pk->custompackage->target }}</h5>
                                                        <h5 class="mb-2 text-md font-bold uppercase tracking-tight text-gray-900 dark:text-gray-700">{{ $pk->packagename }}</h5>
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
                                                        <h2 class="text-2xl font-semibold capitalize text-gray-800 dark:text-gray-900">{{ $pk->packagename }}</h2>
                                                        <button type="button" onclick="toggleModal({{ $pk->package_id }})" class="text-gray-600 hover:text-gray-900 font-bold text-xl">&times;</button>
                                                    </div>
                                                    
                                                    <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Package Price: ₱{{ number_format($pk->packagedesc, 2) }}</p>
                                                    <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Pax: {{$pk->customPackage->person ?? 'N/A'}}</p> <!-- Ensure this is not null -->
                                
                                                    @if ($pk->customPackage && $pk->customPackage->items->isNotEmpty())
                                                    <div class="relative overflow-x-auto mt-4 shadow-sm rounded-lg">
                                                        @if (isset($pk->customPackage->items) && count($pk->customPackage->items) > 0)
                                                            @php
                                                                
                                                                $groupedItems = collect($pk->customPackage->items)->groupBy(function ($item) {
                                                                    // Consolidate item types into 'dishes'
                                                                    if ($item->item_type === 'service_fee') {
                                                                        return 'transportation_fee'; // Replace 'service_fee' with 'transportation_fee'
                                                                    }
                                                                    return in_array($item->item_type, ['beef', 'pork', 'chicken', 'veggie', 'others']) ? 'dishes' : $item->item_type;
                                                                });
                                                            @endphp

                                                            @foreach ($groupedItems as $itemType => $items)
                                                                <h4 class="mt-2 text-md capitalize font-semibold text-gray-800">
                                                                    {{ str_replace('_', ' ', $itemType) }}
                                                                </h4>
                                                                <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                                                    @foreach ($items as $item)
                                                                        <li>
                                                                            {{ $item->item_name }}
                                                                            @if ($item->item_type === 'food_pack')
                                                                                ({{ $item->quantity ?? 'N/A' }})
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endforeach
                                                        @else
                                                            <p class="text-gray-700">No custom items available</p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="text-gray-200">
                                                        <p>No items available for this custom package.</p>
                                                    </div>
                                                @endif


                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <script>
                                    
                                    function toggleModal(packageId) {
                                        console.log("Toggling modal for package ID: " + packageId); 
                                
                                        
                                        const modal = document.getElementById('modal-' + packageId);
                                
                                        
                                        if (modal) {
                                            // Toggle the 'hidden' class to show/hide the modal
                                            modal.classList.toggle('hidden');
                                            console.log("Modal toggled: ", modal.classList.contains('hidden') ? "Hidden" : "Visible");
                                        } else {
                                            console.error("Modal not found for package ID: " + packageId);
                                        }
                                    }
                                
                                    
                                    document.querySelectorAll('button[type="button"]').forEach(button => {
                                        button.addEventListener('click', function(event) {
                                            event.preventDefault();
                                        });
                                    });
                                </script> --}}
                                

                                <div class="md:col-span-5 text-right">
                                    <input type="submit" name="submit" value="Submit" class="bg-yellow-500 cursor-pointer hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
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
                                
                                
    
                                {{-- @foreach ($packages as $pk)
                                    <h1>{{$pk->packagename}}</h1>
                                @endforeach --}}
    
                            </div>
                        </div>
                    </div>
    
                
                    
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
</x-admin-layout>