<x-owner-layout>
    <div class="flex ml-3">
        <a href="{{route('ownerevents')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Direct <span class="text-yellow-600">Booking</span>
        </h3>

    </div>

<form id="directSaveForm" action="{{ route('ownerdirectsave') }}" method="POST">
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
                        <p class="font-medium text-lg">Personal Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>

                <div class="lg:col-span-2">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-3">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('firstname') }}" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('lastname') }}" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="age">Birthday</label>
                            <input type="date" name="birthday" id="birthday" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" min="18" value="{{ old('birthday') }}" />
                        </div>

                        <div class="md:col-span-3">
                            <label for="email">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('phone') }}" />
                        </div>

                        <div class="md:col-span-3">
                            <label for="address">Home Address / Street</label>
                            <input type="text" name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('address') }}" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="city">City</label>
                            {{-- <input type="text" name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                            <select name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option selected disabled>Select your city</option>
                                @foreach ([
                                    "Agno", "Aguilar", "Alaminos City", "Alcala", "Anda", "Asingan", 
                                    "Balungao", "Bani", "Basista", "Bautista", "Bayambang", "Binalonan", 
                                    "Binmaley", "Bolinao", "Bugallon", "Burgos", "Calasiao", "Dasol", 
                                    "Dagupan City", "Infanta", "Labrador", "Laoac", "Lingayen", 
                                    "Mabini", "Malasiqui", "Manaoag", "Mangaldan", "Mangatarem", 
                                    "Mapandan", "Natividad", "Pozorrubio", "Rosales", "San Carlos City", 
                                    "San Fabian", "San Jacinto", "San Manuel", "San Nicolas", 
                                    "San Quintin", "Santa Barbara", "Santa Maria", "Santo Tomas", 
                                    "Sison", "Sual", "Tayug", "Umingan", "Urdaneta City", 
                                    "Urbiztondo", "Villasis"
                                ] as $city)
                                    <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
                    </div>
                </div>
            </div>
            <br>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Event Details</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                            
                            <div class="md:col-span-5">
                                <label for="firstname">Event Locaton</label>
                                <input type="text" name="location" id="location" placeholder="N/A if still" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('location') }}" />
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
                                ar bookedDates = @json($bookedDates);
                            
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
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="email">Event Type</label>
                                <input type="text" name="type" id="type" placeholder="(Ex. 1st Birthday)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('type') }}" />
                            </div>

                            <div class="md:col-span-3">
                                <label for="theme">Event Theme</label>
                                <input type="text" name="theme" id="theme" placeholder="Enter Theme" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('type') }}" />
                            </div>

                            

                            <div class="md:col-span-5">
                                <label for="city">Package</label>
                                {{-- <input type="text" name="package" id="package" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                <select name="package_id" id="" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    
                                    <option disabled selected>See the packages below</option>
                            
                                    @foreach ($packages as $pk)
                                        <option value="{{$pk->package_id}}" 
                                            data-packagedesc="{{ $pk->discountedprice }}" 
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
                                        <div class="max-w-[12rem] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-200 dark:border-gray-700">
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
                                                
                                                <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Package Price: ₱{{ number_format($pk->discountedprice, 2) }}</p>
                                                <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Pax: {{$pk->customPackage->person ?? 'N/A'}}</p> <!-- Ensure this is not null -->
                            
                                                @if ($pk->customPackage && $pk->customPackage->items->isNotEmpty())
                                                <div class="relative overflow-x-auto mt-4 shadow-sm rounded-lg">
                                                    @if (isset($pk->customPackage->items) && count($pk->customPackage->items) > 0)
                                                        @php
                                                            // Group items by item_type
                                                            $groupedItems = collect($pk->customPackage->items)->groupBy(function ($item) {
                                                                // Consolidate item types into 'dishes'
                                                                // if ($item->item_type === 'service_fee') {
                                                                //         return 'transportation_fee'; // Replace 'service_fee' with 'transportation_fee'
                                                                //     }
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
                            
                            
                            {{-- <div class="md:col-span-5 text-right">
                                <hr class="my-5 border-yellow-100">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div> --}}

                            <div class="md:col-span-5 text-right">
                                <hr class="my-5 border-yellow-100">
                                <!-- Change the submit input to a button -->
                                <button 
                                    type="button" 
                                    class="bg-yellow-500 cursor-pointer hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                                    id="submitButton">
                                    Submit
                                </button>
                                <!-- Hidden deposit input -->
                                <input type="hidden" id="depositInput" name="deposit">
                            </div>
                            <script>
                                document.getElementById('submitButton').addEventListener('click', function () {
                                    // Get the selected package option
                                    const packageDropdown = document.querySelector('select[name="package_id"]');
                                    const selectedOption = packageDropdown.options[packageDropdown.selectedIndex];
                            
                                    // Ensure a package is selected
                                    if (!selectedOption || selectedOption.value === "") {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'No Package Selected',
                                            text: 'Please select a package before proceeding.',
                                        });
                                        return;
                                    }
                            
                                    // Get the package price and other details (e.g., packagedesc) using data attributes
                                    const packageDesc = parseFloat(selectedOption.getAttribute('data-packagedesc'));
                            
                                    // Calculate the minimum deposit (20% of package price)
                                    const minDeposit = (packageDesc * 0.20).toFixed(2);
                            
                                    // Format the package price and minimum deposit for display
                                    const formattedPackageDesc = new Intl.NumberFormat().format(packageDesc);
                                    const formattedMinDeposit = new Intl.NumberFormat().format(minDeposit);
                            
                                    // Create the modal
                                    Swal.fire({
                                        title: 'Enter Deposit Amount',
                                        html: `
                                            <p><strong>Package Price:</strong> ₱${formattedPackageDesc}</p>
                                            <p><strong>Minimum Deposit 20% :</strong> ₱${formattedMinDeposit}</p>
                                            <input type="text" id="deposit" class="swal2-input" placeholder="Enter deposit amount">
                                        `,
                                        showCancelButton: true,
                                        confirmButtonText: 'Submit',
                                        cancelButtonText: 'Close',
                                        customClass: {
                                            confirmButton: 'custom-button'
                                        },
                                        preConfirm: () => {
                                            // Validate input here
                                            const depositValue = document.getElementById('deposit').value;
                                            if (!depositValue) {
                                                Swal.showValidationMessage('You need to enter a deposit amount!');
                                                return false;
                                            } else if (!/^\d+(\.\d{1,2})?$/.test(depositValue)) {
                                                Swal.showValidationMessage('Please enter a valid number (up to 2 decimal places).');
                                                return false;
                                            } else if (parseFloat(depositValue) <= 0) {
                                                Swal.showValidationMessage('Deposit must be a positive number!');
                                                return false;
                                            }
                                            return depositValue;
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Set the deposit value in the hidden input field
                                            document.getElementById('depositInput').value = result.value;
                            
                                            // Submit the form
                                            document.getElementById('directSaveForm').submit();
                                        }
                                    });
                                });
                            </script>
                            
                            
                            <style>
                                .custom-button {
                                    background-color: #dabf25 !important; /* Orange button background */
                                    color: white !important; /* White button text */
                                    border-radius: 5px;
                                }
                                .custom-button:hover {
                                    background-color: #dea407 !important; /* Darker orange on hover */
                                }
                            </style>

                            {{-- @foreach ($packages as $pk)
                                <h1>{{$pk->packagename}}</h1>
                            @endforeach --}}

                        </div>
                    </div>
                </div>

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
                
                <!-- JavaScript to handle loading animation and form submission -->
                <script>
                    window.onload = function() {
                        @if (session('alert'))
                            // Show the loading overlay with the appropriate message
                            document.getElementById('loadingOverlay').classList.remove('hidden');
                            let alertType = "{{ session('alert') }}";
                            let alertMessage = "{{ session('message') }}";
                            
                            // Set the message based on success or error
                            if (alertType === 'success') {
                                document.getElementById('loadingText').textContent = alertMessage;
                                document.getElementById('loaderSpinner').classList.add('hidden');
                            } else if (alertType === 'error') {
                                document.getElementById('loadingText').textContent = alertMessage;
                                document.getElementById('loaderSpinner').classList.add('hidden');
                            }
                
                            // Hide the overlay after a few seconds
                            setTimeout(function() {
                                document.getElementById('loadingOverlay').classList.add('hidden');
                            }, 3000); // Adjust time as needed
                        @endif
                    };
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



</x-admin-layout>