<x-owner-layout>

    <div class="flex ml-3">
        <a href="{{route('owner.cancelled')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Cancelled <span class="text-yellow-600">Event</span>
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
                            Reason
                        </th>
                        <td class="px-6 py-4">
                            {{$appointment->reason}}
                        </td>
                    </tr>
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
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
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
                    </tr>
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
                            Theme
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
                                (₱{{ number_format($appointment->package->discountedprice, 2) }})
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
                    <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                            Contract
                        </th>
                        <td class="px-6 py-4">
                            @if($appointment->contract)
                                <a 
                                    href="{{ asset($appointment->contract) }}" 
                                    target="_blank" 
                                    class="underline"
                                    id="view-contract-btn"
                                >
                                    View Attached Contract
                                </a>
                            @else
                                <button 
                                    
                                    class="underline"
                                >
                                    Attach Contract
                                </button>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Modal to display the image -->
                    <div id="contractModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-50 hidden flex items-center justify-center">
                        <div class="relative w-full h-full flex flex-col justify-center pb-12">
                            <!-- Close button -->
                            <button id="closeModal" class="absolute top-4 right-4 text-white text-3xl">&times;</button>
                            
                            <!-- Contract Image -->
                            <img id="contractImage" class="object-contain max-h-screen max-w-screen" />
                            
                            <!-- Edit Button -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2">
                                <button id="editContractBtn" class="bg-yellow-500 hover:bg-yellow-700 text-white px-6 py-2 rounded-full">
                                    Replace
                                </button>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById('view-contract-btn').addEventListener('click', function(e) {
                            e.preventDefault();  // Prevent the default behavior of opening the link in a new tab
                            var contractUrl = e.target.href;
                            
                            // Set the source of the image in the modal
                            document.getElementById('contractImage').src = contractUrl;
                            
                            // Show the modal
                            document.getElementById('contractModal').classList.remove('hidden');
                        });

                        // Close the modal when the close button is clicked
                        document.getElementById('closeModal').addEventListener('click', function() {
                            document.getElementById('contractModal').classList.add('hidden');
                        });

                        // Close the modal when clicking outside the image
                        document.getElementById('contractModal').addEventListener('click', function(e) {
                            if (e.target === this) {
                                document.getElementById('contractModal').classList.add('hidden');
                            }
                        });

                        document.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('editContractBtn')?.addEventListener('click', () => {
                                Swal.fire({
                                    title: 'Attach Contract',
                                    html: `
                                        <div class="flex justify-center items-center">
                                            <label for="swal-contract-input" class="block w-full text-center">
                                                <input 
                                                    type="file" 
                                                    id="swal-contract-input" 
                                                    accept="image/*" 
                                                    class="swal2-input w-60 text-center file:mx-auto file:bg-yellow-100 file:text-gray-500 file:py-2  file:rounded file:border file:border-gray-200"
                                                >
                                            </label>
                                        </div>

                                    `,
                                    showCancelButton: true,
                                    confirmButtonText: 'Submit',
                                    cancelButtonText: 'Cancel',
                                    customClass: {
                                        confirmButton: 'custom-button'
                                    },
                                    didOpen: () => {
                                        // Focus the file input when the modal opens
                                        document.getElementById('swal-contract-input').focus();
                                    },
                                    preConfirm: () => {
                                        const fileInput = document.getElementById('swal-contract-input');
                                        if (!fileInput.files.length) {
                                            Swal.showValidationMessage('Please select a file to upload');
                                            return false;
                                        }
                                        return fileInput.files[0];
                                    },
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const file = result.value;
                    
                                        // Populate the hidden form with the selected file
                                        const hiddenForm = document.getElementById('contractform');
                                        const hiddenInput = document.getElementById('hidden-contract-input');
                    
                                        const dataTransfer = new DataTransfer();
                                        dataTransfer.items.add(file);
                                        hiddenInput.files = dataTransfer.files;
                    
                                        // Submit the hidden form
                                        hiddenForm.submit();
                                    }
                                });
                            });
                        });
                    </script>
                    
                    <div id="modal-{{ $appointment->package->package_id ?? 'default' }}" 
                        class="hidden fixed inset-0 z-50 flex justify-center items-center bg-gray-800 bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-full lg:w-1/2 max-h-[90vh] overflow-y-auto">
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
                                    {{-- <strong class="capitalize">{{$appointment->package->packagename}}</strong> --}}
                                    <br>
                                    <strong>Package Total Price:</strong> ₱{{ number_format($appointment->package->packagedesc ?? 0, 2) }}
                                    <br>
                                    <div class="underline my-2">
                                        <strong class="text-xl">Final Price: ₱{{ number_format($appointment->package->discountedprice ?? 0, 2) }}</strong>
                                    </div>
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
                                                    <ul class="list-disc pl-5 space-y-1 text-sm text-gray-700">
                                                        @foreach ($items as $item)
                                                            <li class="flex justify-between">
                                                                <span>{{ $item->item_name }}
                                                                @if ($item->item_type === 'food_pack')
                                                                    ({{ $item->quantity ?? 'N/A' }})
                                                                @elseif (in_array($item->item_type, ['beef', 'pork', 'chicken', 'veggie', 'others']))
                                                                    (₱{{ $item->item_price ?? 'N/A' }} x {{ $customPackage->person ?? 'Not specified' }}pax)
                                                                @endif
                                                                </span>
                                                                <span class="text-gray-900 italic">
                                                                    ₱{{ number_format(
                                                                        $item->item_type === 'food_pack' 
                                                                            ? ($item->item_price * ($item->quantity ?? 1)) 
                                                                            : (in_array($item->item_type, ['beef', 'pork', 'chicken', 'veggie', 'others']) 
                                                                                ? ($item->item_price * ($customPackage->person ?? 1)) 
                                                                                : $item->item_price), 
                                                                        2
                                                                    ) }}
                                                                </span>
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
            <div class="flex justify-center my-5">
                <form action="{{route('reports.cancelled.details', $appointment->appointment_id)}}" method="POST">
                    @csrf
                    <button type="submit" name="submit" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Print Details
                        <i class="fa-solid fa-download ml-3"></i>
                    </button>  
                </form>
            </div>
            <div class="flex justify-end gap-3 my-5">

                {{-- <form id="acceptForm" action="{{  route('appointment.rebook', $appointment->appointment_id) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="status" value="{{$appointment->status}}">
                    <button type="submit" name="submit" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Re-book
                        <i class="fa-solid fa-check ml-3"></i>
                    </button>                        
                </form>
                <a href="{{ route('cancelled.details.edit', $appointment->appointment_id) }}" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    Edit
                    <i class="fa-regular fa-pen-to-square ml-3"></i>
                </a> --}}
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
            loadingText.textContent = 'Re-booking the event';
        } else if (event.target === cancelForm) {
            loadingText.textContent = 'Canceling the meeting';
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



    {{-- <div class="flex justify-center items-center uppercase">
        <div class="bg-gray-700 text-gray-100 flex flex-col lg:flex-row lg:w-5/6 md:w-full sm:w-full justify-between px-10 py-10 lg:py-10 rounded-2xl">
            
            <div class="bg-gray-200 text-gray-700 py-5 px-5 lg:flex-1 rounded-lg">
                <h2 class="text-xl sm:text-3xl md:text-4xl lg:text-4xl uppercase my-5 font-bold">
                    {{$appointment->user->firstname. ' '. $appointment->user->lastname}}
                </h2>
                <hr class="border-gray-700">
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">Age: </span>
                    {{ \Carbon\Carbon::parse($appointment->user->birthday)->age }}
                </h4>
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">Phone Number: </span>{{$appointment->user->phone}}
                </h4>
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">Street/Barangay: </span>{{$appointment->user->address}}
                </h4>
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">City: </span>{{$appointment->user->city}}
                </h4>
            </div>
            
            <div class="py-5 px-5 lg:flex-1 flex justify-between">
                <div>
                    <h2 class="text-xl sm:text-3xl md:text-4xl lg:text-4xl uppercase">Date:</h2>
                    <br>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Time:</h2>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Location:</h2>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Event:</h2>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Package:</h2>
                </div>
                <div class="text-right">
                    <h2 class="text-xl sm:text-3xl md:text-4xl lg:text-4xl uppercase">{{$appointment->edate}}</h2>
                    <br>
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{$appointment->etime}}</h4>
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{$appointment->location}}</h4>
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{$appointment->type}}</h4>
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{ $appointment->package->packagename }}</h4>
                    <div class="flex justify-end gap-3 capitalize">
                        <form action="{{  route('appointment.rebook', $appointment->appointment_id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" name="status" value="{{$appointment->status}}">
                            <button type="submit" name="submit" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Re-book
                                <i class="fa-solid fa-check ml-3"></i>
                            </button>                        
                        </form>
                        <a href="{{ route('details.edit', $appointment->appointment_id) }}" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Edit
                            <i class="fa-regular fa-pen-to-square ml-3"></i>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    
    
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

    {{-- <h1>{{ $appointment->user->firstname }}</h1>
    <h1>{{ $appointment->location }}</h1> --}}

</x-owner-layout>