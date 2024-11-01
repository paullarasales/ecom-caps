<x-admin-layout>

    <div class="flex ml-3">
        <a href="{{route('cancelled')}}">
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
            <div class="flex justify-end gap-3 my-5">

                <form id="acceptForm" action="{{  route('appointment.rebook', $appointment->appointment_id) }}" method="POST">
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
        const acceptForm = document.getElementById('acceptForm');
        const cancelForm = document.getElementById('cancelForm');

        function showLoading() {
            loadingOverlay.classList.remove('hidden');
        }

        acceptForm.addEventListener('submit', showLoading);
        cancelForm.addEventListener('submit', showLoading);
    </script>


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