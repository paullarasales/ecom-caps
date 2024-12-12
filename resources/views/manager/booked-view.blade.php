<x-manager-layout>

    <div class="flex ml-3">
        <a href="{{route('manager.booked')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Booked <span class="text-yellow-600">Event</span>
        </h3>

    </div>


    <div class="bg-gray-100 lg:mx-40 lg:my-5 rounded-xl lg:p-4">
        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg ">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">
                <thead class="text-xs text-gray-400 uppercase bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Details
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Reference
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->reference}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Name
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->user->firstname. ' '. $appointment->user->lastname}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Phone
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->user->phone}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Address
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->user->address}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            City
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->user->city}}
                        </td>
                    </tr>
                    {{-- <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Meeting Date
                        </th>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y') }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Meeting Time
                        </th>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('g:i A') }}
                        </td>
                    </tr> --}}
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Event Date
                        </th>
                        <td class="px-6 py-4">
                            {{\Carbon\Carbon::parse($appointment->edate)->format('F j, Y') ? : 'No Event Date Assigned'}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Event Time
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->etime ? : 'No Event Time Assigned'}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Location
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->location ? : 'No Event Location Assigned'}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Type
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->type ? : 'No Event Type Assigned'}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Type
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->theme ? : 'No Event Theme Assigned'}}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                            Package
                        </th>
                        <td class="px-6 py-4">
                            @if ($appointment->package)
                            <button type="button" onclick="toggleModal({{ json_encode($appointment->package->package_id) }})"
                                    class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700">
                                    @if($appointment->package && $appointment->package->packagetype == 'Custom')
                                    {{ $appointment->package->customPackage->target }} 
                                    @elseif($appointment->package && $appointment->package->packagetype == 'Normal')
                                    {{ $appointment->package->packagename }} 
                                    @endif
                                (₱{{ number_format($appointment->package->packagedesc, 2) }})
                            </button>
                            @else
                                No package assigned
                            @endif
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Deposit
                        </th>
                        <td class="px-6 py-4">
                            ₱{{ number_format($appointment->deposit, 2) }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                            Balance
                        </th>
                        <td class="px-6 py-4">
                            ₱{{ number_format($appointment->balance, 2) }}
                        </td>
                    </tr>
                    <div id="modal-{{ $appointment->package->package_id ?? 'default' }}" 
                        class="hidden fixed inset-0 z-50 flex justify-center items-center bg-gray-800 bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-y-auto">
                            <div class="flex justify-between items-center">
                                <h2 class="text-2xl font-semibold capitalize text-gray-800 dark:text-gray-900">
                                    {{ $appointment->package->customPackage->target ?? 'Package Details' }}
                                </h2>
                                <!-- Close Button -->
                                <button type="button" 
                                        onclick="toggleModal('{{ $appointment->package->package_id ?? 'default' }}')" 
                                        class="text-gray-600 hover:text-gray-900 font-bold text-xl">&times;</button>
                            </div>
                            <p class="mt-2 text-gray-700 dark:text-gray-700">
                                @if($appointment->package && $appointment->package->packagetype == 'Custom')
                                    <strong class="capitalize">{{$appointment->package->packagename}}</strong>
                                    <br>
                                    <strong>Package Price:</strong> ₱{{ number_format($appointment->package->packagedesc ?? 0, 2) }}
                                    @elseif($appointment->package && $appointment->package->packagetype == 'Normal')
                                    <strong>Estimated Price:</strong> ₱{{ number_format($appointment->package->packagedesc ?? 0, 2) }}
                                    @endif
                            </p>
                            @if($appointment->package && $appointment->package->packagetype == 'Custom')
                            <p class="mt-2 text-gray-700 dark:text-gray-700">
                                <strong>Pax:</strong> 
                                {{ $customPackage->person ?? 'Not specified' }}
                            </p>
                            @endif
                            <div class="mt-4">
                                <h3 class="text-lg font-bold text-gray-700">Inclusions</h3>
                                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                                    @if($appointment->package && $appointment->package->packagetype == 'Normal')
                                        <!-- Normal Package Inclusions -->
                                        @if (isset($appointment->package->packageinclusion))
                                            @foreach (json_decode($appointment->package->packageinclusion) as $inclusion)
                                                <li>{{ $inclusion }}</li>
                                            @endforeach
                                        @else
                                            <li>No inclusions available</li>
                                        @endif
                                    @elseif($appointment->package && $appointment->package->packagetype == 'Custom')
                                        <!-- Custom Package Items -->
                                        @if (isset($appointment->package->customPackage->items) && count($appointment->package->customPackage->items) > 0)
                                                @php
                                                    // Group items by item_type
                                                    $groupedItems = collect($appointment->package->customPackage->items)->groupBy(function ($item) {
                                                        // Check if the item type is 'service_fee' and replace it with 'transportation_fee'
                                                        $itemType = $item->item_type;
                                                        // if ($itemType === 'service_fee') {
                                                        //     $itemType = 'transportation_fee';  // Replace here
                                                        // }

                                                        // Consolidate item types into 'dishes'
                                                        return in_array($itemType, ['beef', 'pork', 'chicken', 'veggie', 'others']) ? 'dishes' : $itemType;
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
                                                <div class="flex justify-end">
                                                    <a href="{{ route('manager.custom.editpackage.booked', $appointment->package->package_id) }}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                                        Edit
                                                        <i class="fa-solid fa-pen-to-square ml-3"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <p class="text-gray-700">No custom items available</p>
                                            @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        function toggleModal(packageId) {
                            const modal = document.getElementById('modal-' + packageId);
                            if (modal) {
                                modal.classList.toggle('hidden'); // Show or hide the modal
                            } else {
                                console.error('Modal not found for package ID:', packageId);
                            }
                        }
                    </script>
                    
                </tbody>
            </table>
            <div class="flex justify-end gap-3 my-5">

                <button 
                    type="button" 
                    class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800"
                    id="acceptButton">
                    Completed
                    <i class="fa-solid fa-check ml-3"></i>
                </button>

                <form id="acceptForm" action="{{ route('manager.appointment.done', $appointment->appointment_id) }}" method="POST" style="display: none;">
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
                    @method("PUT")
                    <input type="hidden" name="status" value="{{ $appointment->status }}">
                    <input type="hidden" id="depositInput" name="deposit">
                </form>
                <script>
                    document.getElementById('acceptButton').addEventListener('click', function () {
                        var packageDesc = parseFloat("{{ $appointment->package->packagedesc }}");
                        var deposit = parseFloat("{{ $appointment->deposit }}");
                        var balance = parseFloat("{{ $appointment->balance }}");

                        var minDeposit = (packageDesc * 0.20).toFixed(2);

                        var formattedPackageDesc = new Intl.NumberFormat().format(packageDesc);
                        var formattedDeposit = new Intl.NumberFormat().format(deposit);
                        var formattedBalance = new Intl.NumberFormat().format(balance);
                        var formattedMinDeposit = new Intl.NumberFormat().format(minDeposit);

                        // Create the modal
                        Swal.fire({
                            title: 'Enter Deposit Amount',
                            html: `
                                <p><strong>Package Price:</strong> ₱${formattedPackageDesc}</p>
                                <p><strong>Current Deposit :</strong> ₱${formattedDeposit}</p>
                                <p><strong>Balance :</strong> ₱${formattedBalance}</p>
                                ${deposit === packageDesc ? 
                                    '<p><strong>Status:</strong> Fully Paid</p>' : 
                                    `<input type="text" id="deposit" class="swal2-input" placeholder="Enter deposit amount">`
                                }
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            cancelButtonText: 'Close',
                            customClass: {
                                confirmButton: 'custom-button'
                            },
                            preConfirm: () => {
                                // If fully paid, set deposit to 0
                                if (deposit === packageDesc) {
                                    return 0; // Submit 0 if fully paid
                                }

                                var depositValue = document.getElementById('deposit').value;
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
                                // If fully paid, submit 0
                                document.getElementById('depositInput').value = result.value;

                                // Submit the form
                                document.getElementById('acceptForm').submit();
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

                <a href="{{ route('manager.details.edit', $appointment->appointment_id) }}" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    Edit
                    <i class="fa-regular fa-pen-to-square ml-3"></i>
                </a>

                <button 
                    type="button" 
                    class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800"
                    id="cancelButton">
                    Cancel
                    <i class="fa-solid fa-ban ml-3"></i>
                </button>

                <form id="cancelForm" action="{{ route('manager.appointment.cancel', $appointment->appointment_id) }}" method="POST" style="display: none;">
                    @csrf
                    @method("PUT")
                </form>

                <script>
                document.getElementById('cancelButton').addEventListener('click', function () {
                    // Fetch the package details and current deposit
                    var packageDesc = parseFloat("{{ $appointment->package->packagedesc }}");
                    var deposit = parseFloat("{{ $appointment->deposit }}");
                    var balance = parseFloat("{{ $appointment->balance }}");

                    // Calculate minimum deposit (20% of the package price)
                    var minDeposit = (packageDesc * 0.20).toFixed(2);
                    var excessReturnable = (deposit - minDeposit).toFixed(2);

                    // Ensure excessReturnable is not negative
                    if (excessReturnable < 0) {
                        excessReturnable = 0;
                    }

                    // Format values for display
                    var formattedPackageDesc = new Intl.NumberFormat().format(packageDesc);
                    var formattedDeposit = new Intl.NumberFormat().format(deposit);
                    var formattedBalance = new Intl.NumberFormat().format(balance);
                    var formattedMinDeposit = new Intl.NumberFormat().format(minDeposit);
                    var formattedExcessReturnable = new Intl.NumberFormat().format(excessReturnable);

                    // Create the cancellation modal
                    Swal.fire({
                        title: 'Event Cancellation',
                        html: `
                            <p><strong>Package Price:</strong> ₱${formattedPackageDesc}</p>
                            <p><strong>Balance :</strong> ₱${formattedBalance}</p>
                            <p><strong>Current Deposit :</strong> ₱${formattedDeposit}</p>
                            <p><strong>Minimum Deposit :</strong> ₱${formattedMinDeposit}</p>
                            <p><strong>Maximum Return :</strong> ₱${formattedExcessReturnable}</p>
                            <select id="reason" class="swal2-select border-yellow-200 focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" style="width: 70%;">
                                <option value="" disabled selected>Select a reason</option>
                                <option value="Payment issue">Payment issue</option>
                                <option value="Client request">Client request</option>
                                <option value="Other">Other</option>
                            </select>
                            <br><br>
                            <input id="deposit" type="number" placeholder="Return deposit (optional)" style="width: 70%;" min="0" step="any" />
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        cancelButtonText: 'Close',
                        customClass: {
                            confirmButton: 'custom-button'
                        },
                        preConfirm: () => {
                            var reasonValue = document.getElementById('reason').value.trim();
                            if (!reasonValue) {
                                Swal.showValidationMessage('You need to enter a reason for cancellation!');
                                return false;
                            }

                            // Validate the deposit input (it should not exceed the maximum returnable amount)
                            var depositInput = parseFloat(document.getElementById('deposit').value.trim());

                            if (isNaN(depositInput)) {
                                depositInput = 0;  // If not entered, set to 0 by default
                            }

                            if (depositInput > parseFloat(excessReturnable)) {
                                Swal.showValidationMessage(`The returnable deposit cannot exceed ₱${formattedExcessReturnable}.00`);
                                return false;
                            }

                            // Directly add the reason and deposit to the form and submit it
                            var cancelForm = document.getElementById('cancelForm');
                            var reasonInput = document.createElement('input');
                            reasonInput.type = 'hidden';
                            reasonInput.name = 'reason';
                            reasonInput.value = reasonValue;
                            cancelForm.appendChild(reasonInput);

                            var depositInputElement = document.createElement('input');
                            depositInputElement.type = 'hidden';
                            depositInputElement.name = 'deposit';
                            depositInputElement.value = depositInput;
                            cancelForm.appendChild(depositInputElement);

                            return true;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form with the added values
                            document.getElementById('cancelForm').submit();
                        }
                    });
                });
                </script>


                <style>
                    .custom-button {
                        background-color: #dabf25 !important; /* Red button background */
                        color: white !important; /* White button text */
                        border-radius: 5px;
                    }
                    .custom-button:hover {
                        background-color: #dea407 !important; /* Darker red on hover */
                    }
                </style>
            </div>
        </div>
    </div>


    <!-- Loading animation overlay -->
<div id="loadingOverlay" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-50">
    <div class="flex flex-col items-center">
        <div id="loaderSpinner" class="loader border-t-4 border-yellow-500 rounded-full w-16 h-16 animate-spin"></div>
        <p class="text-white mt-4 font-semibold" id="loadingText">Your request is being processed</p>
    </div>
</div>

<!-- Styling for loading animation -->
<style>
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
    // Show the loading overlay when a form is submitted
    const loadingOverlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');
    const acceptForm = document.getElementById('acceptForm');
    const cancelForm = document.getElementById('cancelForm');
    const deleteForm = document.getElementById('deleteForm');

    function showLoading(event) {
        loadingOverlay.classList.remove('hidden');
        // Update text based on the form being submitted
        if (event.target === acceptForm) {
            loadingText.textContent = 'Moving the event to done';
        } else if (event.target === cancelForm) {
            loadingText.textContent = 'Canceling the event';
        } else if (event.target === deleteForm) {
            loadingText.textContent = 'Deleting the request';
        }
    }

    // Attach event listeners to the forms
    if (acceptForm) acceptForm.addEventListener('submit', showLoading);
    if (cancelForm) cancelForm.addEventListener('submit', showLoading);
    if (deleteForm) deleteForm.addEventListener('submit', showLoading);

    // Display overlay based on session messages
    window.onload = function () {
        @if (session('alert'))
            const alertType = "{{ session('alert') }}"; // e.g., success, error
            const alertMessage = "{{ session('message') }}";

            // Make the overlay visible and update the message
            loadingOverlay.classList.remove('hidden');
            loadingText.textContent = alertMessage;

            // Hide the spinner for success or error alerts
            const loaderSpinner = document.getElementById('loaderSpinner');
            if (alertType === 'success' || alertType === 'error') {
                loaderSpinner.classList.add('hidden');
            }

            // Hide the overlay after 3 seconds
            setTimeout(() => {
                loadingOverlay.classList.add('hidden');
            }, 3000);
        @endif
    };
</script>


<!-- Modal Structure -->
<div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div id="modal-container" class="relative max-w-lg max-h-[75vh] bg-gray-100 rounded-xl shadow-lg overflow-auto p-4">
            <!-- Close Button -->
            <button class="absolute top-2 right-4 text-gray-600 hover:text-gray-800 z-50" onclick="closeModal()">
                <i class="fa-solid fa-xmark text-3xl"></i>
            </button>
            <!-- Modal Content -->
            <div id="modal-content" class="mt-6"></div>
        </div>
    </div>
</div>
<style>
    /* Additional styling for wider modal */
    .wider-modal {
        max-width: 90%; /* Adjust the width as desired */
    }
</style>
<script>
    function openModal(content, isCustom = false) {
        const modal = document.getElementById('modal');
        const modalContainer = document.getElementById('modal-container');
        const modalContent = document.getElementById('modal-content');

        // Toggle the wider modal class based on content type
        if (isCustom) {
            modalContainer.classList.add('wider-modal');  // Add wider class for custom packages
            modalContent.innerHTML = generateCustomPackageTable(content);
        } else {
            modalContainer.classList.remove('wider-modal');  // Remove wider class for normal packages
            modalContent.innerHTML = `<img src="${content}" class="max-w-full max-h-full rounded-lg">`;
        }

        // Show modal
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Add event listener to close modal on click outside content
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    function closeModal() {
        const modal = document.getElementById('modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function generateCustomPackageTable(customPackage) {
        let foodAndPackItems = customPackage.items.filter(item => ['food', 'food_pack'].includes(item.item_type));
        let otherItems = customPackage.items.filter(item => !['food', 'food_pack'].includes(item.item_type));

        let tableHtml = '<div class="flex flex-col md:flex-row gap-4 mb-4">';

        // Food and Foodpack Items Table
        if (foodAndPackItems.length) {
            tableHtml += '<div class="flex-1"><div class="relative overflow-x-auto shadow-sm sm:rounded-lg "><table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">';
            tableHtml += '<thead class="text-xs text-gray-400 uppercase bg-gray-700 dark:text-gray-400"><tr><th scope="col" class="px-6 py-3 capitalize">Item Name</th><th scope="col" class="px-6 py-3 capitalize">Quantity</th></tr></thead>';
            tableHtml += '<tbody>';
            foodAndPackItems.forEach(item => {
                tableHtml += `<tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 "><th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">${item.item_name}</th><td class="px-6 py-4 capitalize">${item.quantity}</td></tr>`;
            });
            tableHtml += '</tbody></table></div></div>';
        } else {
            tableHtml += '<div class="text-gray-600 flex-1"><p>No food or foodpack items available for this custom package.</p></div>';
        }

        // Other Items Table
        if (otherItems.length) {
            tableHtml += '<div class="flex-1"><div class="relative overflow-x-auto shadow-sm sm:rounded-lg "><table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">';
            tableHtml += '<thead class="text-xs text-gray-400 uppercase bg-gray-700 dark:text-gray-400"><tr><th scope="col" class="px-6 py-3 capitalize">Item Type</th><th scope="col" class="px-6 py-3 capitalize">Item Name</th></tr></thead>';
            tableHtml += '<tbody>';
            otherItems.forEach(item => {
                tableHtml += `<tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 "><th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">${item.item_type.replace(/_/g, ' ')}</th><td class="px-6 py-4 capitalize">${item.item_name}</td></tr>`;
            });
            tableHtml += '</tbody></table></div></div>';
        } else {
            tableHtml += '<div class="text-gray-600 flex-1"><p>No other items available for this custom package.</p></div>';
        }

        tableHtml += '</div>';
        return tableHtml;
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


    {{-- <h1>{{ $appointment->user->firstname }}</h1>
    <h1>{{ $appointment->location }}</h1> --}}

</x-admin-layout>