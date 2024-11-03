<x-manager-layout>

    <div class="absolute">
        <a href="{{route('manager.newcustomizepackage')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Add <span class="text-yellow-600">Custom Package</span>
        </h3>
    </div>

    <form action="{{route('manager.newcustom.package.store')}}" method="POST" enctype="multipart/form-data">
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
        <div class="my-10 p-2 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
                <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Foods</p>
                            {{-- <p>Select the quantity for each item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                <div class="md:col-span-7 col-span-7">
                                    <label for="person">Pax</label>
                                    <input type="number" name="person" id="person" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 quantity-input" min="0" value="0" />
                                </div>
                            </div>
                            @foreach($foods as $food)
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                    <div class="md:col-span-4 col-span-5">
                                        <label>Food Item</label>
                                        <!-- Hidden input to store the actual value for submission -->
                                        <input type="hidden" name="fooditem[]" value="{{ $food->foodname }}" />

                                        <!-- Read-only input to display the formatted value -->
                                        <input type="text" name="display_fooditem[]" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none pointer-events-none placeholder-gray-800"
                                            placeholder="{{ $food->foodname }} - ₱{{ number_format($food->foodprice, 2) }}" 
                                            readonly data-price="{{ $food->foodprice }}" />
                                    </div>

                                    <div class="md:col-span-1 col-span-2">
                                        <label for="foodquantity">Quantity</label>
                                        <input type="number" name="foodquantity[]" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 quantity-input" min="0" value="0" />
                                    </div>
                                </div>
                            @endforeach
                                
                        </div>
                    </div>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Foodpacks</p>
                            {{-- <p>Select the quantity for each item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            @foreach($foodpacks as $food)
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                    <div class="md:col-span-4 col-span-5">
                                        <label>Food Item</label>
                                        <!-- Hidden input to store the actual value for submission -->
                                        <input type="hidden" name="foodpackitem[]" value="{{ $food->foodpackname }}" />
                                        
                                        <!-- Read-only input with placeholder displaying the formatted value -->
                                        <input type="text" name="display_foodpackitem[]" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none placeholder-gray-800" 
                                            placeholder="{{ $food->foodpackname }} - ₱{{ number_format($food->foodpackprice, 2) }}" 
                                            readonly data-price="{{ $food->foodpackprice }}" />
                                    </div>
                                    

                                    <div class="md:col-span-1 col-span-2">
                                        <label for="foodpackquantity">Quantity</label>
                                        <input type="number" name="foodpackquantity[]" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 quantity-input" min="0" value="0" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Foodcarts</p>
                            {{-- <p>Select the items.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            @foreach($foodcarts as $food)
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                    <div class="md:col-span-4 col-span-5">
                                        <label>Food Item</label>
                                        <input type="text" name="foodcartitem[]" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none pointer-events-none" 
                                            value="{{ $food->foodcartname }} - ₱{{ number_format($food->foodcartprice, 2) }}" readonly data-price="{{ $food->foodcartprice }}" />
                                    </div>

                                    <div class="md:col-span-1 col-span-2">
                                        <label for="foodcartquantity">Select</label>
                                        <input type="checkbox" name="foodcartselected[]" 
                                            value="{{ $food->foodcart_id }}" 
                                            class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 checkbox-input" data-price="{{ $food->foodcartprice }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Lechon</p>
                        </div>
                        <div class="lg:col-span-2">
                            <label for="lechonItem">Lechon Items</label>
                            <select name="lechonitem" id="lechonItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Lechon</option> <!-- Enabled placeholder -->
                                @foreach($lechon as $food)
                                    <option value="{{ $food->lechonname }} - ₱{{ number_format($food->lechonprice, 2) }}" data-price="{{ $food->lechonprice }}">
                                        {{ $food->lechonname }} - ₱{{ number_format($food->lechonprice, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="clearLechonSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>  
                    <script>
                        function clearLechonSelection() {
                            const selectElement = document.getElementById('lechonItem');
                            selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                            calculateTotal(); // Update total after clearing selection
                        }
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Cake</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            <label for="cakeItem">Cake Items</label>
                            <select name="cakeitem" id="cakeItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Cake</option>
                                @foreach($cake as $food)
                                    <option value="{{ $food->cakename }} - ₱{{ number_format($food->cakeprice, 2) }}" data-price="{{ $food->cakeprice }}">
                                        {{ $food->cakename }} - ₱{{ number_format($food->cakeprice, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="clearSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>
                    
                    <script>
                        function clearSelection() {
                            const selectElement = document.getElementById('cakeItem');
                            selectElement.selectedIndex = 0; // Reset to the first option
                            calculateTotal();
                        }
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Clown/Emcee</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            <label for="cakeItem">Clown items</label>
                            <select name="clownitem" id="clownItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Clown/Emcee</option>
                                @foreach($clown as $food)
                                    <option value="{{ $food->clownname }} - ₱{{ number_format($food->clownprice, 2) }}" data-price="{{ $food->clownprice }}">
                                        {{ $food->clownname }} - ₱{{ number_format($food->clownprice, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="clearClownSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>

                    <script>
                        function clearClownSelection() {
                            const selectElement = document.getElementById('clownItem');
                            selectElement.selectedIndex = 0; // Reset to the first option
                            calculateTotal();
                        }
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Facepainting</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            <label for="facepaintItem">Facepaint items</label>
                            <select name="facepaintitem" id="facepaintItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Facepaint</option>
                                @foreach($facepaint as $food)
                                    <option value="{{ $food->facepaintname }} - ₱{{ number_format($food->facepaintprice, 2) }}" data-price="{{ $food->facepaintprice }}">
                                        {{ $food->facepaintname }} - ₱{{ number_format($food->facepaintprice, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="clearFacepaintSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>

                    <script>
                        function clearFacepaintSelection() {
                            const selectElement = document.getElementById('facepaintItem');
                            selectElement.selectedIndex = 0; // Reset to the first option
                            calculateTotal();
                        }
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Setup</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            <label for="setupItem">Setup items</label>
                            <select name="setupitem" id="setupItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Setup</option>
                                @foreach($setup as $food)
                                    <option value="{{ $food->setupname }} - ₱{{ number_format($food->setupprice, 2) }}" data-price="{{ $food->setupprice }}">
                                        {{ $food->setupname }} - ₱{{ number_format($food->setupprice, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="clearSetupSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>

                    <script>
                        function clearSetupSelection() {
                            const selectElement = document.getElementById('setupItem');
                            selectElement.selectedIndex = 0; // Reset to the first option
                            calculateTotal();
                        }
                    </script>
                    
                    

                    <div class="md:col-span-5 text-right mt-4">
                        <hr class="my-5 border border-yellow-100">
                    <!-- Total calculation -->
                        <div class="col-span-2">
                            <div class="bg-gray-100 rounded-md p-4 text-center">
                                <h4 class="text-xl font-semibold">Total</h4>
                                <p id="total" class="text-3xl font-bold text-yellow-600">₱ 0.00</p>
                            </div>
                        </div>
                        <hr class="my-5 border border-yellow-100">

                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                {{-- <p class="font-medium text-lg">Number of Person</p> --}}
                            </div>
                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-5">
                                        {{-- <label for="final">Enter Final Price</label> --}}
                                        <input type="text" name="final" id="final" placeholder="Enter Final Price"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
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

    <script>
        // Function to calculate the total price
        function calculateTotal() {
            let total = 0;

            // Get the number of persons
            const persons = parseFloat(document.getElementById('person').value) || 0; // Default to 0 if empty

            // Calculate total from foods only if persons is greater than 0
            if (persons > 0) {
                document.querySelectorAll('input[name="foodquantity[]"]').forEach(function(input) {
                    const quantity = parseFloat(input.value) || 0;
                    const price = parseFloat(input.closest('.grid').querySelector('input[type="text"]').dataset.price) || 0;

                    // Calculate based on the proportion of persons
                    total += (quantity * price / 100) * persons; // Adjust for number of persons
                });
            }

            // Calculate total from foodpacks
            document.querySelectorAll('input[name="foodpackquantity[]"]').forEach(function(input) {
                const quantity = parseFloat(input.value) || 0;
                const price = parseFloat(input.closest('.grid').querySelector('input[type="text"]').dataset.price) || 0;
                total += quantity * price;
            });

            // Calculate total from foodcarts
            // Calculate total from food carts
        const checkedFoodCarts = document.querySelectorAll('input[name="foodcartselected[]"]:checked');
        checkedFoodCarts.forEach(function(checkbox) {
            const price = parseFloat(checkbox.closest('.grid').querySelector('input[type="text"]').dataset.price) || 0;
            total += price;
        });

        // Deduct ₱500 if three food carts are selected
        if (checkedFoodCarts.length === 3) {
            total -= 500; // Apply the discount
        }

            // Calculate total from lechon dropdown selection
            const lechonSelect = document.getElementById('lechonItem');
            const selectedOption = lechonSelect.options[lechonSelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.price) {
                const lechonPrice = parseFloat(selectedOption.dataset.price);
                total += lechonPrice;
            }

            // Calculate total from cake dropdown selection
            const cakeSelect = document.getElementById('cakeItem');
            const selectedCakeOption = cakeSelect.options[cakeSelect.selectedIndex];
            if (selectedCakeOption && selectedCakeOption.dataset.price) {
                const cakePrice = parseFloat(selectedCakeOption.dataset.price);
                total += cakePrice;
            }

            // Calculate total from cake dropdown selection
            const clownSelect = document.getElementById('clownItem');
            const selectedClownOption = clownSelect.options[clownSelect.selectedIndex];
            if (selectedClownOption && selectedClownOption.dataset.price) {
                const clownPrice = parseFloat(selectedClownOption.dataset.price);
                total += clownPrice;
            }

            // Calculate total from cake dropdown selection
            const facepaintSelect = document.getElementById('facepaintItem');
            const selectedFacepaintOption = facepaintSelect.options[facepaintSelect.selectedIndex];
            if (selectedFacepaintOption && selectedFacepaintOption.dataset.price) {
                const facepaintPrice = parseFloat(selectedFacepaintOption.dataset.price);
                total += facepaintPrice;
            }

            // Calculate total from cake dropdown selection
            const setupSelect = document.getElementById('setupItem');
            const selectedSetupOption = setupSelect.options[setupSelect.selectedIndex];
            if (selectedSetupOption && selectedSetupOption.dataset.price) {
                const setupPrice = parseFloat(selectedSetupOption.dataset.price);
                total += setupPrice;
            }

            // Update the total display
            document.getElementById('total').textContent = total.toFixed(2);
        }

        // Attach event listeners to quantity inputs and checkboxes
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            input.addEventListener('input', calculateTotal);
        });

        document.querySelectorAll('.checkbox-input').forEach(function(checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        });

        document.getElementById('lechonItem').addEventListener('change', calculateTotal);
        document.getElementById('cakeItem').addEventListener('change', calculateTotal);
        document.getElementById('clownItem').addEventListener('change', calculateTotal);
        document.getElementById('facepaintItem').addEventListener('change', calculateTotal);
        document.getElementById('setupItem').addEventListener('change', calculateTotal);
        // document.getElementById('person').addEventListener('input', calculateTotal);
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

</x-manager-layout>
