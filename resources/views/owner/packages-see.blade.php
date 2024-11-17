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
        <div class="flex flex-col items-center w-full bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-4xl dark:border-gray-700 dark:bg-gray-800 ">
            @if ($package->packagephoto)
                <img class="object-cover w-full cursor-pointer max-w-sm h-48 md:w-48 md:h-full rounded-t-lg md:rounded-none md:rounded-s-lg" src="{{ asset($package->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($package->packagephoto) }}')">
            @endif
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl uppercase font-bold tracking-tight text-gray-900 dark:text-white">{{ $package->packagename }}</h5>
                <p class="mb-3 text-xl font-normal uppercase dark:text-gray-100">₱ {{ number_format($package->packagedesc, 2) }}</p>

                @if ($package->packagetype === 'Normal')
                    @if ($samplePhotos && count($samplePhotos) > 0)
                        <!-- Display the sample photos if they exist -->
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 border p-2 border-yellow-50">
                            @foreach ($samplePhotos as $photo)
                                <div class="relative overflow-hidden w-32 h-32" >
                                    <img src="{{ asset($photo) }}" alt="Sample Photos" class="absolute inset-0 w-full h-full object-cover cursor-pointer" 
                                        onclick="openModal('{{ asset($photo) }}')"/>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <a href="{{ route('owner.editsample', $package->sample->sample_id) }}" class="inline-flex w-28 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Edit photos
                            <i class="fa-solid fa-pencil ml-3"></i>
                        </a>
                    @else
                            <!-- Display the Add sample photos button if no sample photos exist -->
                            <a href="{{ route('owner.addsample', $package->package_id) }}" class="inline-flex w-full items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Add sample photos
                                <i class="fa-solid fa-add ml-3"></i>
                            </a>
                    @endif
                
                @endif

                @if($package->packagetype === 'Custom' && $customPackage)
                    @if($customPackage->person > 0)
                        <div class="flex justify-start gap-3">
                            <p class="mb-3 text-xl font-normal capitalize dark:text-gray-100">
                                {{$customPackage->person}} Pax
                            </p>
                        </div>
                    @endif

                    {{-- Filter items by type --}}
                    @php
                        // Filter food and foodpack items
                        $foodAndPackItems = $customPackage->items->filter(function ($item) {
                            return in_array($item->item_type, ['food', 'food_pack']);
                        });
                        
                        // Filter other item types
                        $otherItems = $customPackage->items->filter(function ($item) {
                            return !in_array($item->item_type, ['food', 'food_pack']);
                        });
                    @endphp

                    {{-- Container for tables --}}
                    <div class="flex flex-col md:flex-row gap-4 mb-4 rounded-xl">

                        {{-- Food and Foodpack Items Table --}}
                        @if($foodAndPackItems->isNotEmpty())
                            <div class="flex-1">
                                <div class="relative overflow-x-auto shadow-sm sm:rounded-lg ">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">
                                        <thead class="text-xs text-gray-400 uppercase bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 capitalize">
                                                    Item Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 capitalize text-center">
                                                    Quantity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($foodAndPackItems as $item)
                                                <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                                        {{ $item->item_name }}
                                                    </th>
                                                    <td class="px-6 py-4 capitalize text-center">
                                                        {{ $item->quantity }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="text-gray-200 flex-1">
                                <p>No food or foodpack items available for this custom package.</p>
                            </div>
                        @endif

                        {{-- Other Items Table --}}
                        @if($otherItems->isNotEmpty())
                            <div class="flex-1">
                                <div class="relative overflow-x-auto shadow-sm sm:rounded-lg ">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="table-layout: fixed;">
                                        <thead class="text-xs text-gray-400 uppercase bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 capitalize">
                                                    Item Type
                                                </th>
                                                <th scope="col" class="px-6 py-3 capitalize">
                                                    Item Name
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($otherItems as $item)
                                                <tr class="bg-white border-b dark:bg-gray-200 border-yellow-900 text-gray-700 ">
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap ">
                                                        {{ str_replace('_', ' ', $item->item_type) }}
                                                    </th>
                                                    <td class="px-6 py-4 capitalize">
                                                        {{ $item->item_name }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="text-gray-200 flex-1">
                                <p>No other items available for this custom package.</p>
                            </div>
                        @endif

                    </div>
                @endif




                <br>

                <div>
                    @if($package->packagetype === 'Custom')
                        <div class="flex justify-start">
                            <a href="{{ route('destroycustom', $package->package_id) }}" class="inline-flex w-20 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Delete
                                <i class="fa-solid fa-trash ml-3"></i>
                            </a>
                        </div>
                    @else
                        <div class="flex justify-start gap-2">
                            <a href="{{ route('ownereditpackage', $package->package_id) }}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Edit
                                <i class="fa-solid fa-arrow-right ml-3"></i>
                            </a>
                            <a href="{{ route('ownerdestroypackage', $package->package_id) }}" class="inline-flex w-20 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Delete
                                <i class="fa-solid fa-trash ml-3"></i>
                            </a>
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
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
</x-owner-layout>
