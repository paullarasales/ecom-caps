<x-app-layout>

    
    
    <form action="{{ route('update-personal', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                                    <input type="text" name="firstname" id="firstname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $user->firstname }}" />
                                </div>
    
                                <div class="md:col-span-2">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $user->lastname }}" />
                                </div>
    
                                <div class="md:col-span-2">
                                    <label for="age">Birthday</label>
                                    <input type="date" name="birthday" id="birthday" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" min="18" value="{{ $user->birthday }}" />
                                </div>
    
                                <div class="md:col-span-3">
                                    <label for="email">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $user->phone }}" />
                                </div>
    
                                <div class="md:col-span-3">
                                    <label for="address">Home Address / Street</label>
                                    <input type="text" name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ $user->address }}" />
                                </div>
    
                                <div class="md:col-span-2">
                                    <label for="city">City</label>
                                    {{-- <input type="text" name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                    <select name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option selected disabled></option>
                                        <option value="Agno" {{ $user->city === 'Agno' ? 'selected' : '' }}>Agno</option>
                                        <option value="Aguilar" {{ $user->city === 'Aguilar' ? 'selected' : '' }}>Aguilar</option>
                                        <option value="Alaminos City" {{ $user->city === 'Alaminos City' ? 'selected' : '' }}>Alaminos City</option>
                                        <option value="Alcala" {{ $user->city === 'Alcala' ? 'selected' : '' }}>Alcala</option>
                                        <option value="Anda" {{ $user->city === 'Anda' ? 'selected' : '' }}>Anda</option>
                                        <option value="Asingan" {{ $user->city === 'Asingan' ? 'selected' : '' }}>Asingan</option>
                                        <option value="Balungao" {{ $user->city === 'Balungao' ? 'selected' : '' }}>Balungao</option>
                                        <option value="Bani" {{ $user->city === 'Bani' ? 'selected' : '' }}>Bani</option>
                                        <option value="Basista" {{ $user->city === 'Basista' ? 'selected' : '' }}>Basista</option>
                                        <option value="Bautista" {{ $user->city === 'Bautista' ? 'selected' : '' }}>Bautista</option>
                                        <option value="Bayambang" {{ $user->city === 'Bayambang' ? 'selected' : '' }}>Bayambang</option>
                                        <option value="Binalonan" {{ $user->city === 'Binalonan' ? 'selected' : '' }}>Binalonan</option>
                                        <option value="Binmaley" {{ $user->city === 'Binmaley' ? 'selected' : '' }}>Binmaley</option>
                                        <option value="Bolinao" {{ $user->city === 'Bolinao' ? 'selected' : '' }}>Bolinao</option>
                                        <option value="Bugallon" {{ $user->city === 'Bugallon' ? 'selected' : '' }}>Bugallon</option>
                                        <option value="Burgos" {{ $user->city === 'Burgos' ? 'selected' : '' }}>Burgos</option>
                                        <option value="Calasiao" {{ $user->city === 'Calasiao' ? 'selected' : '' }}>Calasiao</option>
                                        <option value="Dasol" {{ $user->city === 'Dasol' ? 'selected' : '' }}>Dasol</option>
                                        <option value="Dagupan City" {{ $user->city === 'Dagupan City' ? 'selected' : '' }}>Dagupan City</option>
                                        <option value="Infanta" {{ $user->city === 'Infanta' ? 'selected' : '' }}>Infanta</option>
                                        <option value="Labrador" {{ $user->city === 'Labrador' ? 'selected' : '' }}>Labrador</option>
                                        <option value="Laoac" {{ $user->city === 'Laoac' ? 'selected' : '' }}>Laoac</option>
                                        <option value="Lingayen" {{ $user->city === 'Lingayen' ? 'selected' : '' }}>Lingayen</option>
                                        <option value="Mabini" {{ $user->city === 'Mabini' ? 'selected' : '' }}>Mabini</option>
                                        <option value="Malasiqui" {{ $user->city === 'Malasiqui' ? 'selected' : '' }}>Malasiqui</option>
                                        <option value="Manaoag" {{ $user->city === 'Manaoag' ? 'selected' : '' }}>Manaoag</option>
                                        <option value="Mangaldan" {{ $user->city === 'Mangaldan' ? 'selected' : '' }}>Mangaldan</option>
                                        <option value="Mangatarem" {{ $user->city === 'Mangatarem' ? 'selected' : '' }}>Mangatarem</option>
                                        <option value="Mapandan" {{ $user->city === 'Mapandan' ? 'selected' : '' }}>Mapandan</option>
                                        <option value="Natividad" {{ $user->city === 'Natividad' ? 'selected' : '' }}>Natividad</option>
                                        <option value="Pozorrubio" {{ $user->city === 'Pozorrubio' ? 'selected' : '' }}>Pozorrubio</option>
                                        <option value="Rosales" {{ $user->city === 'Rosales' ? 'selected' : '' }}>Rosales</option>
                                        <option value="San Carlos City" {{ $user->city === 'San Carlos City' ? 'selected' : '' }}>San Carlos City</option>
                                        <option value="San Fabian" {{ $user->city === 'San Fabian' ? 'selected' : '' }}>San Fabian</option>
                                        <option value="San Jacinto" {{ $user->city === 'San Jacinto' ? 'selected' : '' }}>San Jacinto</option>
                                        <option value="San Manuel" {{ $user->city === 'San Manuel' ? 'selected' : '' }}>San Manuel</option>
                                        <option value="San Nicolas" {{ $user->city === 'San Nicolas' ? 'selected' : '' }}>San Nicolas</option>
                                        <option value="San Quintin" {{ $user->city === 'San Quintin' ? 'selected' : '' }}>San Quintin</option>
                                        <option value="Santa Barbara" {{ $user->city === 'Santa Barbara' ? 'selected' : '' }}>Santa Barbara</option>
                                        <option value="Santa Maria" {{ $user->city === 'Santa Maria' ? 'selected' : '' }}>Santa Maria</option>
                                        <option value="Santo Tomas" {{ $user->city === 'Santo Tomas' ? 'selected' : '' }}>Santo Tomas</option>
                                        <option value="Sison" {{ $user->city === 'Sison' ? 'selected' : '' }}>Sison</option>
                                        <option value="Sual" {{ $user->city === 'Sual' ? 'selected' : '' }}>Sual</option>
                                        <option value="Tayug" {{ $user->city === 'Tayug' ? 'selected' : '' }}>Tayug</option>
                                        <option value="Umingan" {{ $user->city === 'Umingan' ? 'selected' : '' }}>Umingan</option>
                                        <option value="Urdaneta City" {{ $user->city === 'Urdaneta City' ? 'selected' : '' }}>Urdaneta City</option>
                                        <option value="Urbiztondo" {{ $user->city === 'Urbiztondo' ? 'selected' : '' }}>Urbiztondo</option>
                                        <option value="Villasis" {{ $user->city === 'Villasis' ? 'selected' : '' }}>Villasis</option>
                                    </select>
                                    
                                </div>
    
                                <div class="md:col-span-5">
                                    <label for="address">Any Valid ID</label>
                                    <input id="picture" name="photo" required type="file" accept=".png, .jpg, .jpeg" class="mt-1 block w-full items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" value="" />
                                </div>

                                <br>
                                <div class="flex items-center md:col-span-5">
                                    <input id="link-checkbox" required type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="link-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">I agree with the <a href="#" class="text-gray-800 dark:text-blue-500 hover:underline" id="terms-link">terms and conditions</a>.</label>
                                </div>

                                
    
                                <div class="md:col-span-5 text-right">
                                    <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div id="terms-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Terms and Conditions
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <!-- Add your terms and conditions content here -->
                                    By submitting your personal data through this platform/application/website, you agree to the following terms and conditions:                                </p>
                                <hr class="mb-2">
                                <ul class="mb-2">
                                    <li class="text-sm text-gray-500 mb-2"><span class="font-semibold text-gray-600">Consent:</span> You consent to the collection, processing, and storage of your personal data as described in our Privacy Policy.</li>
                                    <li class="text-sm text-gray-500 mb-2"><span class="font-semibold text-gray-600">Accuracy:</span> You certify that all information provided is accurate, complete, and up-to-date to the best of your knowledge.</li>
                                    <li class="text-sm text-gray-500 mb-2"><span class="font-semibold text-gray-600">Purpose:</span> Your personal data will be used for the specific purposes outlined at the time of collection, unless otherwise agreed upon.</li>
                                    <li class="text-sm text-gray-500 mb-2"><span class="font-semibold text-gray-600">Security:</span> We implement reasonable security measures to protect your personal data from unauthorized access, alteration, disclosure, or destruction.</li>
                                    <li class="text-sm text-gray-500 mb-2"><span class="font-semibold text-gray-600">Access and Correction:</span> You have the right to access, correct, or delete your personal data as provided by applicable law. You may do so by contacting us through the contact information provided.</li>
                                    <li class="text-sm text-gray-500 mb-2"><span class="font-semibold text-gray-600">Changes:</span> We reserve the right to update or modify these terms and conditions at any time without prior notice. Your continued use of our platform/application/website after any such changes constitutes your acceptance of the new terms and conditions.</li>
                                    <li class="text-sm text-gray-500 mb-2"><span class="font-semibold text-gray-600">Contact:</span> For questions or concerns regarding these terms and conditions or our handling of your personal data, please contact us at thesiblingscateringservices@gmail.com.</li>
                                </ul>
                                <hr>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="close-modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("terms-modal");

        // Get the button that opens the modal
        var btn = document.getElementById("terms-link");

        // Get the element that closes the modal
        var closeModal = document.getElementById("close-modal");

        // When the user clicks the button, open the modal 
        btn.onclick = function(event) {
            event.preventDefault();
            modal.classList.remove("hidden");
        }

        // When the user clicks on <span> (x), close the modal
        closeModal.onclick = function() {
            modal.classList.add("hidden");
        }
    </script>
</x-app-layout>