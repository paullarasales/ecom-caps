<x-manager-layout>
    
    <div class="absolute">
        <a href="{{route('managerviewpackage')}}">
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
                <img class="object-cover w-full cursor-pointer max-w-sm h-48 md:w-48 md:h-48 rounded-t-lg md:rounded-none md:rounded-s-lg" src="{{ asset($package->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($package->packagephoto) }}')">
            @endif
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl uppercase font-bold tracking-tight text-gray-900 dark:text-white">{{ $package->packagename }}</h5>
                <p class="mb-3 text-xl font-normal uppercase dark:text-gray-100">₱ {{ number_format($package->packagedesc, 2) }}</p>

                @if($package->packagename === 'Custom' && $customPackage)
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
                    <div class="flex flex-col md:flex-row gap-4 mb-4">

                        {{-- Food and Foodpack Items Table --}}
                        @if($foodAndPackItems->isNotEmpty())
                            <div class="flex-1">
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 capitalize">
                                                    Item Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 capitalize">
                                                    Quantity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($foodAndPackItems as $item)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row" class="px-6 py-4 capitalize font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $item->item_name }}
                                                    </th>
                                                    <td class="px-6 py-4 capitalize">
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
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row" class="px-6 py-4 capitalize font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $item->item_type }}
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
                    @if($package->packagename === 'Custom')
                        <div>
                            <a href="{{ route('destroycustom', $package->package_id) }}" class="inline-flex w-20 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Delete
                                <i class="fa-solid fa-trash ml-3"></i>
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('managereditpackage', $package->package_id) }}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Edit
                                <i class="fa-solid fa-arrow-right ml-3"></i>
                            </a>
                            <a href="{{ route('managerdestroypackage', $package->package_id) }}" class="inline-flex w-20 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
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
        <div class="relative max-w-sm max-h-[75vh] bg-white  rounded-lg shadow-lg">
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

</x-manager-layout>