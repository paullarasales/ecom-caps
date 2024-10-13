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
        @endforeach


        {{-- @foreach ($doneAppointments as $appointment)
        <div class="text-center py-4 px-6">
            <h2 class="font-heading bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-64 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                Done Events
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
        @endforeach --}}


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
    
</x-app-layout>
