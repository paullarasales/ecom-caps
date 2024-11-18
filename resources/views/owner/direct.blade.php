<x-owner-layout>
    <div class="flex ml-3">
        <a href="{{route('ownerevents')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Direct <span class="text-yellow-600">Booking</span>
        </h3>

    </div>

<form action="{{ route('ownerdirectsave') }}" method="POST">
    @csrf
    <!-- Display validation errors -->
    <div id="errorModal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
            <div class="flex justify-between">
                <h2 class="text-lg font-bold mb-4">Validation Errors</h2>
                <button id="closeErrorModal" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>
            </div>
            <ul id="errorMessageList" class="text-gray-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        // Check if there are validation errors
        var errors = @json($errors->any()); // Get the boolean status of errors
        var errorModal = document.getElementById('errorModal');
        var closeErrorModalButton = document.getElementById('closeErrorModal');

        // Show the error modal if there are errors
        if (errors) {
            errorModal.classList.remove('hidden'); // Show the modal
        }

        // Close error modal event
        closeErrorModalButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent any default action (if needed)
            errorModal.classList.add('hidden'); // Hide the modal
        });

        // Optional: Close the modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === errorModal) {
                errorModal.classList.add('hidden'); // Hide the modal
            }
        });
    </script>

<div class="min-h-screen p-6 flex items-center justify-center">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                    <div class="text-gray-600">
                        <p class="font-medium text-lg">Personal Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>

                <div class="lg:col-span-2">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-3">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('firstname') }}" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('lastname') }}" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="age">Birthday</label>
                            <input type="date" name="birthday" id="birthday" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" min="18" value="{{ old('birthday') }}" />
                        </div>

                        <div class="md:col-span-3">
                            <label for="email">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('phone') }}" />
                        </div>

                        <div class="md:col-span-3">
                            <label for="address">Home Address / Street</label>
                            <input type="text" name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('address') }}" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="city">City</label>
                            {{-- <input type="text" name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                            <select name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option selected disabled>Select your city</option>
                                @foreach ([
                                    "Agno", "Aguilar", "Alaminos City", "Alcala", "Anda", "Asingan", 
                                    "Balungao", "Bani", "Basista", "Bautista", "Bayambang", "Binalonan", 
                                    "Binmaley", "Bolinao", "Bugallon", "Burgos", "Calasiao", "Dasol", 
                                    "Dagupan City", "Infanta", "Labrador", "Laoac", "Lingayen", 
                                    "Mabini", "Malasiqui", "Manaoag", "Mangaldan", "Mangatarem", 
                                    "Mapandan", "Natividad", "Pozorrubio", "Rosales", "San Carlos City", 
                                    "San Fabian", "San Jacinto", "San Manuel", "San Nicolas", 
                                    "San Quintin", "Santa Barbara", "Santa Maria", "Santo Tomas", 
                                    "Sison", "Sual", "Tayug", "Umingan", "Urdaneta City", 
                                    "Urbiztondo", "Villasis"
                                ] as $city)
                                    <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
                    </div>
                </div>
            </div>
            <br>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Event Details</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                            
                            <div class="md:col-span-5">
                                <label for="firstname">Event Locaton</label>
                                <input type="text" name="location" id="location" placeholder="N/A if still" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('location') }}" />
                            </div>

                            <div class="md:col-span-3">
                                <label for="date">Event Date</label>
                                <input type="date" name="edate" id="edate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('edate') }}" />
                            </div>
                            
                            <!-- Modal Structure -->
                            <div id="datemodal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
                                    
                                    <div class="flex justify-between">
                                        <h2 class="text-lg font-bold mb-4">Date Blocked</h2>
                                        <button id="closeModal" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>
                                    </div>
                                    <p id="modalMessage">The selected date is blocked. Please choose another date.</p>
                                    
                                </div>
                            </div>
                            
                            <script>
                                var today = new Date();
                                var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 9);
                                var minDateString = minDate.toISOString().split('T')[0];
                                document.getElementById("edate").setAttribute('min', minDateString);
                            
                                // Blocked dates from the server
                                var blockedDates = @json($blockedDates); // Convert PHP array to JavaScript array
                            
                                // Modal elements
                                var modal = document.getElementById('datemodal');
                                var closeModalButton = document.getElementById('closeModal');
                            
                                // Disable blocked dates in the input
                                var dateInput = document.getElementById('edate');
                            
                                dateInput.addEventListener('change', function() {
                                    var selectedDate = new Date(this.value);
                                    var formattedDate = selectedDate.toISOString().split('T')[0];
                            
                                    if (blockedDates.includes(formattedDate)) {
                                        showModal('The selected date is blocked. Please choose another date.');
                                        this.value = ''; // Clear the input
                                    }
                                });
                            
                                // Function to show the modal
                                function showModal(message) {
                                    document.getElementById('modalMessage').innerText = message;
                                    modal.classList.remove('hidden'); // Show the modal
                                }
                            
                                // Close modal event
                                closeModalButton.addEventListener('click', function() {
                                    event.preventDefault();
                                    modal.classList.add('hidden'); // Hide the modal
                                });
                            </script>
                            
                            

                            <div class="md:col-span-2">
                                <label for="time">Event Time</label>
                                {{-- <input type="time" name="time" id="time" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                <select name="etime" id="etime" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option disabled selected>Select your time</option>
                                    @foreach ([
                                        "8:00 am", "8:30 am", "9:00 am", "9:30 am", "10:00 am", "10:30 am",
                                        "11:00 am", "11:30 am", "12:00 pm", "12:30 pm", "1:00 pm", "1:30 pm",
                                        "2:00 pm", "2:30 pm", "3:00 pm", "3:30 pm", "4:00 pm", "4:30 pm",
                                        "5:00 pm", "5:30 pm", "6:00 pm", "6:30 pm", "7:00 pm", "7:30 pm"
                                    ] as $time)
                                        <option value="{{ $time }}" {{ old('etime') == $time ? 'selected' : '' }}>
                                            {{ $time }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-5">
                                <label for="email">Event Type</label>
                                <input type="text" name="type" id="type" placeholder="(Ex. 1st Birthday)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('type') }}" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="city">Package</label>
                                {{-- <input type="text" name="package" id="package" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                <select name="package_id" id="" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    
                                    @foreach ($packages as $pk)
                                    <option value="{{$pk->package_id}}">{{$pk->packagename}}</option>
                                    
                                    @endforeach
                                    <option disabled selected>See the packages below</option>
                                    
                                </select>
                                
                                
                                
                            </div>

                            <div class="md:col-span-5">
                                <label for="package" class="uppercase bg-yellow-100 my-14 rounded-xl py- px-2">Available Packages</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4"> <!-- Grid layout for images -->
                                    @foreach ($packages as $pk)
                                        <a href="#" class="block relative w-[115px] h-[180px] overflow-hidden rounded-lg mx-auto transition-transform duration-300 transform  hover:scale-105">
                                            @if ($pk->packagephoto)
                                            <p class="uppercase">{{$pk->packagename}}</p>
                                            <p class="uppercase">₱{{ $pk->packagedesc }}.00</p>
                                                <img class="w-full h-full object-cover" src="{{ asset($pk->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($pk->packagephoto) }}')" />
                                            
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            
                            
                            <div class="md:col-span-5 text-right">
                                <hr class="my-5 border-yellow-100">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div>

                            {{-- @foreach ($packages as $pk)
                                <h1>{{$pk->packagename}}</h1>
                            @endforeach --}}

                        </div>
                    </div>
                </div>

                {{-- <hr class="my-5 border-yellow-100">

                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                    <div class="text-gray-600">
                        <p class="font-medium text-lg">Meeting Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                            <div class="md:col-span-3">
                                <label for="date">Meeting Date</label>
                                <input type="date" name="adate" id="adate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                            </div>
                            <script>
                                var today = new Date();
                                var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 4);
                                var minDateString = minDate.toISOString().split('T')[0];
                                document.getElementById("adate").setAttribute('min', minDateString);
                            </script>

                            <div class="md:col-span-2">
                                <label for="time">Meeting Time</label>
                                <select name="atime" id="atime" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option value="10:00 am">10:00 am</option>
                                    <option value="10:30 am">10:30 am</option>
                                    <option value="11:00 am">11:00 am</option>
                                    <option value="11:30 am">11:30 am</option>
                                    <option value="12:00 pm">12:00 pm</option>
                                    <option value="12:30 pm">12:30 pm</option>
                                    <option value="1:00 pm">1:00 pm</option>
                                    <option value="1:30 pm">1:30 pm</option>
                                    <option value="2:00 pm">2:00 pm</option>
                                    <option value="2:30 pm">2:30 pm</option>
                                    <option value="3:00 pm">3:00 pm</option>
                                    <option value="3:30 pm">3:30 pm</option>
                                    <option value="4:00 pm">4:00 pm</option>
                                    <option value="4:30 pm">4:30 pm</option>
                                    <option value="5:00 pm">5:00 pm</option>
                                    <option value="5:30 pm">5:30 pm</option>
                                    <option value="6:00 pm">6:00 pm</option>
                                    <option disabled selected></option>
                                </select>
                            </div>

                            <div class="md:col-span-5 text-right">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div>

                        </div>
                    </div>
                </div> --}}

                
            </div>
        </div>
    </div>
</div>
</form>

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

</x-admin-layout>