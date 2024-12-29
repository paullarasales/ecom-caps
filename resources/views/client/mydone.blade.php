<x-app-layout>
    
    {{-- <div class="text-center py-4 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Pending <span class="text-yellow-600">Request</span>
        </h3>
    </div> --}}

    @if ($doneAppointments->isEmpty()) 

    <div class="h-[50vh] flex items-center justify-center">
        <div class="text-center py-4 px-6">
            <h2 class="font-heading bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-64 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                You have no done events
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
        

        <div class="text-center mt-5 lg:mt-20 py-4 px-6">
            <h2 class="font-heading bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-64 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                Completed Events
            </h2>
        </div>

        @foreach ($doneAppointments as $appointment)
        
        <div class="bg-gray-100 lg:mx-56 lg:mt-8 mt-5 mb-2 rounded-xl lg:p-4">
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
                        {{-- <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
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
                        </tr> --}}
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Event Date
                            </th>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($appointment->edate)->format('F j, Y') }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Event Time
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->etime }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Location
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->location }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                Type
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->type }}
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
                                        <strong>Package Price:</strong> ₱{{ number_format($appointment->package->packagedesc ?? 0, 2) }}
                                        @elseif($appointment->package && $appointment->package->packagetype == 'Normal')
                                        <strong>Estimated Price:</strong> ₱{{ number_format($appointment->package->packagedesc ?? 0, 2) }}
                                        @endif
                                </p>
                                @if($appointment->package && $appointment->package->packagetype == 'Custom')
                                <p class="mt-2 text-gray-700 dark:text-gray-700">
                                    <strong>Pax:</strong> 
                                    {{ $appointment->package->customPackage->person ?? 'Not specified' }}
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
                                                                        (₱{{ $item->item_price ?? 'N/A' }} x {{ $appointment->package->customPackage->person ?? 'Not specified' }}pax)
                                                                    @endif
                                                                    </span>
                                                                    <span class="text-gray-900 italic">
                                                                        ₱{{ number_format(
                                                                            $item->item_type === 'food_pack' 
                                                                                ? ($item->item_price * ($item->quantity ?? 1)) 
                                                                                : (in_array($item->item_type, ['beef', 'pork', 'chicken', 'veggie', 'others']) 
                                                                                    ? ($item->item_price * ($appointment->package->customPackage->person ?? 1)) 
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
            </div>
        </div>
        <div class="flex justify-end lg:mx-56">
            @if ($appointment->review)
                <h1 class="font-heading text-center bg-yellow-200 text-orange-800 px-4 py-2 rounded-lg w-32 sm:w-44 text-xs font-semibold uppercase">done review</h1>
            @else
                <a href="{{ route('makereviews', $appointment->appointment_id) }}" class="bg-yellow-500 text-center hover:bg-yellow-700 text-white font-bold px-4 py-2 text-xs w-44 rounded-lg">
                    Make a Review
                    <i class="fa-solid fa-arrow-right ml-5"></i>
                </a>
            @endif
        </div>           
        @endforeach
        <div class="flex justify-center">
            <div class="mt-6 mb-20 text-center lg:text-left">
                <a href="{{ route('book-form') }}" class="bg-yellow-200 rounded-3xl py-3 px-8 font-medium inline-block mr-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t">Book Again</a>
            </div>
        </div>


    @endif

    <!-- Modal Structure -->
<div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div id="modal-container" class="relative max-w-lg max-h-[75vh] bg-gray-100 rounded-xl shadow-lg overflow-auto p-4">
            <!-- Close Button -->
            <button class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 z-50" onclick="closeModal()">
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
            tableHtml += '<thead class="text-xs text-gray-700 uppercase bg-yellow-200 dark:text-gray-500"><tr><th scope="col" class="px-6 py-3 capitalize">Item Name</th><th scope="col" class="px-6 py-3 capitalize">Quantity</th></tr></thead>';
            tableHtml += '<tbody>';
            foodAndPackItems.forEach(item => {
                tableHtml += `<tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 "><th scope="row" class="px-6 py-4 capitalize font-medium text-gray-800 whitespace-nowrap ">${item.item_name}</th><td class="px-6 py-4 capitalize">${item.quantity}</td></tr>`;
            });
            tableHtml += '</tbody></table></div></div>';
        } else {
            tableHtml += '<div class="text-gray-600 flex-1"><p>No food or foodpack items available for this custom package.</p></div>';
        }

        // Other Items Table
        if (otherItems.length) {
            tableHtml += '<div class="flex-1"><div class="relative overflow-x-auto shadow-sm sm:rounded-lg "><table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">';
            tableHtml += '<thead class="text-xs text-gray-700 uppercase bg-yellow-200 dark:text-gray-500"><tr><th scope="col" class="px-6 py-3 capitalize">Item Type</th><th scope="col" class="px-6 py-3 capitalize">Item Name</th></tr></thead>';
            tableHtml += '<tbody>';
            otherItems.forEach(item => {
                tableHtml += `<tr class="bg-white border-b dark:bg-yellow-50 border-yellow-900 text-gray-700 "><th scope="row" class="px-6 py-4 capitalize font-medium text-gray-800 whitespace-nowrap ">${item.item_type.replace(/_/g, ' ')}</th><td class="px-6 py-4 capitalize">${item.item_name}</td></tr>`;
            });
            tableHtml += '</tbody></table></div></div>';
        } else {
            tableHtml += '<div class="text-gray-600 flex-1"><p>No other items available for this custom package.</p></div>';
        }

        tableHtml += '</div>';
        return tableHtml;
    }
</script>
    
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
</x-app-layout>
