<x-app-layout>
    
    {{-- <div class="text-center py-4 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Pending <span class="text-yellow-600">Request</span>
        </h3>
    </div> --}}

    @if ($pendingAppointments->isEmpty()) 

    <div class="h-[50vh] flex items-center justify-center">
        <div class="text-center py-4 px-6">
            <h2 class="font-heading bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-64 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                You have no pending request
            </h2>
        </div>
    </div>

    @else
        {{-- <div>
            <h1>Hello Client</h1>
            <ul>
                @foreach ($pendingAppointments as $appointment)
                    <li>{{ $appointment->location }}</li> <!-- Replace with actual fields you want to show -->
                @endforeach
            </ul>
        </div> --}}
        

        @foreach ($pendingAppointments as $appointment)
        <div class="text-center mt-5 lg:mt-20 py-4 px-6">
            <h2 class="font-heading bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-64 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                Pending Request
            </h2>
        </div>
        <div class="bg-gray-100 lg:mx-56 lg:my-5 rounded-xl lg:p-4">
            <div class="relative overflow-x-auto shadow-sm sm:rounded-lg ">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">
                    <thead class="text-xs text-gray-700 uppercase bg-yellow-200 dark:text-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Event
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Details
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Reference
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->reference }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Meeting Date
                            </th>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y') }} <!-- Display date -->
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Meeting Time
                            </th>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('g:i A') }} <!-- Display time -->
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Event Date
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->edate ? \Carbon\Carbon::parse($appointment->edate)->format('F j, Y') : 'No event date assigned' }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Event Time
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->etime ? : 'No Event time assigned' }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Location
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->location ? : 'No Event location assigned' }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Type
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->type ? : 'No Event type assigned' }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Theme
                            </th>
                            <td class="px-6 py-4">
                                {{$appointment->theme ? : 'No Event Theme Assigned'}}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                                Package
                            </th>
                            <td class="px-6 py-4">
                                @if ($appointment->package)
                                <button type="button" onclick="toggleModal({{ json_encode($appointment->package->package_id) }})"
                                        class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700">
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
                                                    {{-- <div class="flex justify-end">
                                                        <a href="{{ route('admin.custom.editpackage.booked', $appointment->package->package_id) }}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                                            Edit
                                                            <i class="fa-solid fa-pen-to-square ml-3"></i>
                                                        </a>
                                                    </div> --}}
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
            </div>
        </div>
        <div class="flex justify-center lg:mx-56 gap-2">
            @if($appointment->location)
                <a href="{{ route('form.edit', $appointment->appointment_id) }}" class="bg-yellow-500 text-center hover:bg-yellow-700 text-white font-bold px-4 py-2 text-xs w-44 rounded-lg">
                    Edit details
                    <i class="fa-solid fa-arrow-right ml-5"></i>
                </a>
            @else
                <a href="{{ route('form.meeting.edit', $appointment->appointment_id) }}" class="bg-yellow-500 text-center hover:bg-yellow-700 text-white font-bold px-4 py-2 text-xs w-44 rounded-lg">
                    Edit details
                    <i class="fa-solid fa-arrow-right ml-5"></i>
                </a>
            @endif
            {{-- <form id="cancelForm" action="{{ route('client.appointment.cancel.meeting', $appointment->appointment_id) }}" method="POST">
                @csrf
                @method("PUT")
                <input type="hidden" name="status" value="{{ $appointment->status }}">
                <button type="submit" name="submit" class="bg-yellow-500 text-center hover:bg-yellow-700 text-white font-bold px-4 py-2 text-xs w-44 rounded-lg">
                    Cancel
                    <i class="fa-solid fa-ban ml-3"></i>
                </button>                          
            </form> --}}
            <button 
                type="button" 
                class="bg-yellow-500 text-center hover:bg-yellow-700 text-white font-bold px-4 py-2 text-xs w-44 rounded-lg"
                id="cancelButton">
                Cancel
                <i class="fa-solid fa-ban ml-3"></i>
            </button>

            <form id="cancelForm" action="{{ route('client.appointment.cancel.meeting', $appointment->appointment_id) }}" method="POST" style="display: none;">
                @csrf
                @method("PUT")
                <input type="hidden" name="status" value="{{ $appointment->status }}">
                <input type="hidden" id="reasonInput" name="reason">
            </form>

            <script>
                document.getElementById('cancelButton').addEventListener('click', function () {
                    // Create the modal for inputting the cancellation reason
                    Swal.fire({
                        title: 'Enter Cancellation Reason',
                        html: `
                            
                            <input type="text" id="reason" placeholder="Enter reason" class="swal2-select border-yellow-200 focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" style="width: 70%;">
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        cancelButtonText: 'Close',
                        customClass: {
                            confirmButton: 'custom-button'
                        },
                        preConfirm: () => {
                            // Validate input here
                            var reasonValue = document.getElementById('reason').value.trim();
                            if (!reasonValue) {
                                Swal.showValidationMessage('You need to enter a reason for cancellation!');
                                return false;
                            }
                            return reasonValue;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Set the reason value in the hidden input field
                            document.getElementById('reasonInput').value = result.value;

                            // Submit the form
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
        @endforeach
        <div class="mb-10">
            
        </div>

        


    @endif

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

    <!-- Loading animation overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center hidden">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-yellow-500 h-12 w-12 mb-4"></div>
        <p class="text-white mt-4 font-semibold" id="loadingText">Your request is being processed</p>
    </div>

    <!-- CSS for loader animation -->
    <style>
        .loader {
            border-top-color: #3498db;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <!-- JavaScript to show loading overlay on form submission -->
    <script>
        const loadingOverlay = document.getElementById('loadingOverlay');
        const loadingText = document.getElementById('loadingText');
        const cancelForm = document.getElementById('cancelForm');

        function showLoading(event) {
            loadingOverlay.classList.remove('hidden');
            if (event.target === cancelForm) {
                loadingText.textContent = 'Canceling the meeting';
            }
        }

        cancelForm.addEventListener('submit', showLoading);
    </script>

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
    
</x-app-layout>
