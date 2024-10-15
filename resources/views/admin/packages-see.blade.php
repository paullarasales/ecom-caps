<x-admin-layout>
    
    <div class="absolute">
        <a href="{{route('viewpackage')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            View <span class="text-yellow-600">Package</span>
        </h3>

    </div>
    

<div class="flex justify-center">
    <div class="flex flex-col items-center w-full bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-4xl  dark:border-gray-700 dark:bg-gray-800 ">
        @if ($package->packagephoto)
            
        <img class="object-cover w-full cursor-pointer max-w-sm h-48 md:w-48 md:h-48 rounded-t-lg md:rounded-none md:rounded-s-lg" src="{{ asset($package->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($package->packagephoto) }}')">
        
        @endif<div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl uppercase font-bold tracking-tight text-gray-900 dark:text-white">{{$package->packagename}}</h5>
            <p class="mb-3 text-xl font-normal uppercase dark:text-gray-100">₱ {{ number_format($package->packagedesc, 2) }}</p>

            
            @if($package->packagename === 'Custom' && $custom)
            <div class="flex justify-center gap-3">
                <p class="mb-3 text-xl font-normal capitalize dark:text-gray-100"> {{$custom->persons}} Pax</p>
                @if($custom->setup === 'Yes')
                    <p class="mb-3 text-xl font-normal capitalize dark:text-gray-100">With Setup</p>
                @else
                    <p class="mb-3 text-xl font-normal capitalize dark:text-gray-100">Without Setup</p>
                @endif
            </div>

            <div class="flex flex-col lg:flex-row lg:space-x-4 space-y-4 lg:space-y-0">
                <!-- First Table -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full lg:w-1/2 gap-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                    Food
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Veggie
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->veggie}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Chicken
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->chicken}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Fish
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->fish}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Pork
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->pork}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Beef
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->beef}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            
                <!-- Second Table -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full lg:w-1/2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                    Food Cart
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Ice Cream
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->icecream}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    French Fries
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->frenchfries}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Mixed Balls
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->mixedballs}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Hotdogs
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->hotdogs}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            
                <!-- Third Table -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full lg:w-1/2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                    Add Ons
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{$custom->packname}}
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->foodpack}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    lechon {{$custom->lechonname}}
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->lechon}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Cake
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->cake}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <th scope="row" class="px-1 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Lootbags
                                </th>
                                <td class="px-1 py-4">
                                    {{$custom->lootbags}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>
            
            @endif
            <div>
                <a href="{{route('editpackage', $package->package_id)}}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    Edit
                    <i class="fa-solid fa-arrow-right ml-3"></i>
                </a>
                <a href="{{route('destroypackage', $package->package_id)}}" class="inline-flex w-20 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    Delete
                    <i class="fa-solid fa-trash ml-3"></i>
                </a>
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

</x-admin-layout>