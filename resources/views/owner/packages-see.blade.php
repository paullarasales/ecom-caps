<x-owner-layout>

    <div class="absolute">
        <a href="{{ route('ownerviewpackage') }}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            View <span class="text-yellow-600">Package</span>
        </h3>
    </div>

    <div class="flex justify-center">
        <div class="flex flex-col items-center text-center w-full bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-200">
            
            @if($package->packagetype === 'Normal')
            <!-- Package Info -->
            <div class="p-6 w-full">
                <h2 class="text-2xl font-semibold text-gray-800 capitalize dark:text-gray-900">{{ $package->packagename }}</h2>
                <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Estimated Price: ₱{{ number_format($package->packagedesc, 2) }}</p>
                
                <!-- Package Inclusion Table -->
                <div class="mt-4 overflow-x-auto rounded-lg">
                    <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-900">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 w-1/5">#</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 w-4/5">Inclusion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach (json_decode($package->packageinclusion) as $index => $inclusion)
                            <tr>
                                <td class="px-4 py-2 w-1/5">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 w-4/5">{{ $inclusion }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            @else
            <!-- Package Info -->
            <div class="p-6 w-full">
                <h2 class="text-2xl font-semibold text-gray-800 capitalize dark:text-gray-900">{{ $customPackage->target }}</h2>
                <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Package Total Price: ₱{{ number_format($package->packagedesc, 2) }}</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-700 dark:text-gray-700 mt-2 border-4 mx-14 border-yellow-500">Final Price: ₱{{ number_format($package->discountedprice, 2) }}</p>
                <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Pax: {{$customPackage->person}}</p>

                {{-- Check if there are items to display --}}
                @if($customPackage->items->isNotEmpty())
                <div class="relative overflow-x-auto mt-4 shadow-sm rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 capitalize">
                                    Item Type
                                </th>
                                <th scope="col" class="px-6 py-3 capitalize">
                                    Item Name
                                </th>
                                <th scope="col" class="px-6 py-3 capitalize">
                                    Item Price
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @php
                                $menuItems = ['beef', 'pork', 'chicken', 'veggie', 'dessert', 'others'];
                            @endphp
            
                            {{-- Menu Items --}}
                            <tr>
                                <td colspan="3" class="px-6 py-2 text-lg font-semibold bg-gray-300 text-center text-gray-700">Menu</td>
                            </tr>
                            @foreach($customPackage->items->filter(fn($item) => in_array($item->item_type, $menuItems)) as $item)
                                <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700">
                                    <td class="px-6 py-3 font-medium capitalize text-gray-800 whitespace-nowrap">
                                        {{ $item->item_type === 'others' ? 'fish' : str_replace('_', ' ', $item->item_type) }}
                                    </td>
                                    <td class="px-6 py-3 capitalize">
                                        {{ $item->item_name }}
                                        @if ($item->item_type === 'food_pack')
                                            ({{ $item->quantity ?? 'N/A' }})
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 font-medium text-right capitalize text-gray-800 whitespace-nowrap">
                                        ₱{{ number_format($item->item_price, 2) }}
                                    </td>
                                </tr>
                            @endforeach
            
                            {{-- Other Items --}}
                            <tr>
                                <td colspan="3" class="px-6 py-2 text-lg font-semibold bg-gray-300 text-center text-gray-700">Others</td>
                            </tr>
                            @foreach($customPackage->items->filter(fn($item) => !in_array($item->item_type, $menuItems)) as $item)
                                <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700">
                                    <td class="px-6 py-3 font-medium capitalize text-gray-800 whitespace-nowrap">
                                        {{ str_replace('_', ' ', $item->item_type) }}
                                    </td>
                                    <td class="px-6 py-3 capitalize">
                                        {{ $item->item_name }}
                                    </td>
                                    <td class="px-6 py-3 font-medium text-right capitalize text-gray-800 whitespace-nowrap">
                                        ₱{{ number_format($item->item_price, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-5">
                    @if($appointmentCount != 0)
                        @if($appointments->status === 'booked')
                        <a href="{{route('owner.bookedView', $appointments->appointment_id)}}" class="inline-flex w-30 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Go to event
                            <i class="fa-solid fa-arrow-right ml-3"></i>
                        </a>
                        @elseif($appointments->status === 'done')
                        <a href="{{route('owner.doneView', $appointments->appointment_id)}}" class="inline-flex w-30 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Go to event
                            <i class="fa-solid fa-arrow-right ml-3"></i>
                        </a>
                        @endif
                    @endif
                </div>
                @else
                <div class="text-gray-200">
                    <p>No items available for this custom package.</p>
                </div>
                @endif


            </div>
            @endif
    
        </div>
    </div>

    <div class="flex justify-center items-center my-2">
        @if($package->packagetype === 'Custom')
            <div class="flex justify-start gap-2">
                @if($package->packagestatus === 'active')
                    
                        <a href="{{ route('owner.packages.archive', $package->package_id ) }}" class="inline-flex w-24 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Archive
                            <i class="fa-solid fa-eye-slash ml-3"></i>
                        </a>
                    
                    @if($appointmentCount === 0)
                        <a href="{{ route('owner.custom.editpackage', $package->package_id) }}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Edit
                                <i class="fa-solid fa-pen-to-square ml-3"></i>
                        </a>
                    @endif
                    @if($appointmentCount === 0)
                        <a href="{{route('owner.destroycustom', $package->package_id)}}" class="inline-flex w-24 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Delete
                            <i class="fa-solid fa-trash ml-3"></i>
                        </a>
                    @endif
                @elseif($package->packagestatus === 'archived')
                    <a href="{{route('owner.packages.unarchive', $package->package_id)}}" class="inline-flex w-28 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Unarchive
                        <i class="fa-solid fa-eye ml-3"></i>
                    </a>
                @endif
            </div>
        @else
            <div class="flex justify-start gap-2">
                @if($package->packagestatus === 'active')
                    <a href="{{ route('owner.packages.archive', $package->package_id ) }}" class="inline-flex w-24 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Archive
                        <i class="fa-solid fa-eye-slash ml-3"></i>
                    </a>

                    <a href="{{ route('editpackage', $package->package_id) }}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    Edit
                        <i class="fa-solid fa-pen-to-square ml-3"></i>
                    </a>
                    
                @elseif($package->packagestatus === 'archived')
                    <a href="{{route('owner.packages.unarchive', $package->package_id)}}" class="inline-flex w-28 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Unarchive
                        <i class="fa-solid fa-eye ml-3"></i>
                    </a>
                @endif
            </div>
        @endif
    </div>

    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative max-w-sm max-h-[75vh] bg-white rounded-lg shadow-lg">
                <button class="absolute top-0 right-0 m-4 text-white" onclick="closeModal()">
                    <i class="fa-solid text-black fa-xmark text-3xl"></i>
                </button>
                <div id="modal-content" class="border rounded-lg border-gray-700"></div>
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
</x-owner-layout>
