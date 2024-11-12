<x-app-layout>
    
    {{-- <div class="text-center py-4 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Pending <span class="text-yellow-600">Request</span>
        </h3>
    </div> --}}

    @if ($doneAppointments->isEmpty()) 

    <div class="text-center py-4 px-6">
        <h2 class="font-heading bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-64 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
            You have no done events
        </h2>
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
                Done Events
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
                                Package
                            </th>
                            <td class="px-6 py-4" >
                                <a href="javascript:void(0);" onclick="openModal('{{ asset($appointment->package->packagephoto) }}')">{{ $appointment->package->packagename }}</a>
                            </td>
                        </tr>
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
            <div class="mt-6 text-center lg:text-left">
                <a href="{{ route('book-form') }}" class="bg-yellow-200 rounded-3xl py-3 px-8 font-medium inline-block mr-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t">Book Again</a>
            </div>
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
</x-app-layout>
