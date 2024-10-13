<form action="/appointment" method="POST">
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
                                    <option disabled selected></option>
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
                                <label for="package" class="uppercase bg-yellow-100 my-10 rounded-xl py-1 px-2">Available Packages</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4"> <!-- Grid layout for images -->
                                    @foreach ($packages as $pk)
                                        <a href="#" class="block relative w-[155px] h-[200px] overflow-hidden rounded-lg mx-auto transition-transform duration-300 transform  hover:scale-105">
                                            @if ($pk->packagephoto)
                                            <p class="uppercase">{{$pk->packagename}}</p>
                                            <p class="uppercase">₱{{ $pk->packagedesc }}.00</p>
                                                <img class="w-full h-full object-cover" src="{{ asset($pk->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($pk->packagephoto) }}')" />
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            
                            
                            

                            {{-- @foreach ($packages as $pk)
                                <h1>{{$pk->packagename}}</h1>
                            @endforeach --}}

                        </div>
                    </div>
                </div>

                <hr class="my-5 border-yellow-100">

                {{-- <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
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

                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                    <div class="text-gray-600">
                        <p class="font-medium text-lg">Meeting Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>
                
                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                
                            <div class="md:col-span-3">
                                <label for="appointment_date">Meeting Date</label>
                                <input type="date" name="appointment_date" id="appointment_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('appointment_date') }}" />
                            </div>
                
                            <div class="md:col-span-2">
                                <label for="appointment_time">Meeting Time</label>
                                <select name="appointment_time" id="appointment_time" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <!-- Options will be populated by JavaScript -->
                                    <option disabled selected value="">Select appointment time</option>
                                </select>
                            </div>
                
                            <div class="md:col-span-5 text-right">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var dateInput = document.getElementById('appointment_date');
                        var timeSelect = document.getElementById('appointment_time');
                
                        // Populate time options for 30-minute intervals between 9 AM and 6 PM
                        function populateTimes() {
                            var startTime = new Date();
                            startTime.setHours(9, 0); // 9 AM
                            var endTime = new Date();
                            endTime.setHours(18, 0); // 6 PM
                
                            var options = '';
                            var oldTime = "{{ old('appointment_time') }}"; // Get the old value from the server
                            while (startTime <= endTime) {
                                var hours = startTime.getHours();
                                var minutes = startTime.getMinutes();
                                var timeString = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
                                var displayTime = hours + ':' + (minutes === 0 ? '00' : '30') + (hours < 12 ? ' AM' : ' PM');
                
                                // Set the selected attribute if the old value matches
                                var selected = (oldTime === timeString) ? 'selected' : '';
                                options += `<option value="${timeString}" ${selected}>${displayTime}</option>`;
                                startTime.setMinutes(startTime.getMinutes() + 30);
                            }
                            timeSelect.innerHTML += options;
                        }
                
                        // Ensure that the date input only allows future dates
                        function setMinDate() {
                            var today = new Date();
                            var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1); // Tomorrow
                            var minDateString = minDate.toISOString().slice(0, 10); // Format as 'YYYY-MM-DD'
                            dateInput.setAttribute('min', minDateString);
                        }
                
                        populateTimes();
                        setMinDate();
                    });
                </script>

<script>
    document.getElementById('edate').addEventListener('change', function() {
        const edate = new Date(this.value);
        // Set maximum date for appointment_date to 7 days before edate
        const maxDate = new Date(edate);
        maxDate.setDate(maxDate.getDate() - 7);
        
        const today = new Date();
        const appointmentDateInput = document.getElementById('appointment_date');

        // Set the min and max attributes for appointment_date
        appointmentDateInput.setAttribute('min', today.toISOString().split('T')[0]); // Set min to today
        appointmentDateInput.setAttribute('max', maxDate.toISOString().split('T')[0]); // Set max to 7 days before edate
    });
</script>
                
                
                

                
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


