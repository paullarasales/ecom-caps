<x-admin-layout>

    <div class="flex ml-3">
        <a href="{{route('done')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Done <span class="text-yellow-600">Event</span>
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
                            {{$appointment->edate ? : 'No Event Date Assigned'}}
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
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                            Package
                        </th>
                        <td class="px-6 py-4">
                            @if ($appointment->package)
                                <a href="javascript:void(0);" onclick="openModal('{{ asset($appointment->package->packagephoto) }}')">
                                    {{ $appointment->package->packagename }}
                                </a>
                            @else
                                No package assigned
                            @endif
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>


    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative max-w-lg max-h-[75vh] bg-white  rounded-lg shadow-lg">
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

    {{-- <h1>{{ $appointment->user->firstname }}</h1>
    <h1>{{ $appointment->location }}</h1> --}}

</x-admin-layout>