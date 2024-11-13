<x-app-layout>
    
    {{-- <div class="text-center py-4 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Pending <span class="text-yellow-600">Request</span>
        </h3>
    </div> --}}

    @if ($pendingAppointments->isEmpty()) 

    <div class="text-center py-4 px-6">
        <h2 class="font-heading bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-64 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
            You have no pending request
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
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                                Package
                            </th>
                            <td class="px-6 py-4">
                                @if ($appointment->package)
                                    <a href="javascript:void(0);" onclick="openModal('{{ asset($appointment->package->packagephoto) }}')">
                                        {{ $appointment->package->packagename }} (₱ {{ number_format($appointment->package->packagedesc, 2) }})
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
            <form id="cancelForm" action="{{ route('client.appointment.cancel.meeting', $appointment->appointment_id) }}" method="POST">
                @csrf
                @method("PUT")
                <input type="hidden" name="status" value="{{ $appointment->status }}">
                <button type="submit" name="submit" class="bg-yellow-500 text-center hover:bg-yellow-700 text-white font-bold px-4 py-2 text-xs w-44 rounded-lg">
                    Cancel
                    <i class="fa-solid fa-ban ml-3"></i>
                </button>                          
            </form>
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
