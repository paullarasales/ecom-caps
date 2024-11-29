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
        <script>
            // Check if there are validation errors
            var errors = @json($errors->any()); // Check if there are any errors
            var errorMessages = @json($errors->all()); // Get the array of error messages
        
            // Show SweetAlert with validation errors if there are any
            if (errors) {
                Swal.fire({
                    title: 'Validation Errors',
                    icon: 'error',
                    html: `
                        <ul style="text-align: center; color: #E07B39;">
                            ${errorMessages.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    `,
                    confirmButtonText: 'Close',
                    customClass: {
                        popup: 'custom-popup-error',
                        title: 'custom-title-error',
                        confirmButton: 'custom-button-error'
                    }
                });
            }
        </script>
        
        <style>
            /* SweetAlert Error Popup Customization */
            .custom-popup-error {
                background-color: #FDEDEC; /* Light red background */
                border: 2px solid #E07B39; /* Red border */
            }
            .custom-title-error {
                color: #E07B39; /* Red title text */
                font-weight: bold;
            }
            .custom-button-error {
                background-color: #E07B39 !important; /* Red button background */
                color: white !important; /* White button text */
                border-radius: 5px;
            }
            .custom-button-error:hover {
                background-color: #C0392B !important; /* Darker red on hover */
            }
        </style>
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
                                        <input type="text" name="final" id="final" placeholder="Enter Final Price"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('final') }}" />
                                    </div>
                                    <div class="md:col-span-5">
                                        {{-- <label for="final">Enter Final Price</label> --}}
                                        <input type="text" name="packagename" id="packagename" placeholder="Enter Package Name"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('packagename') }}" />
                                    </div>
                                    <div class="md:col-span-5 text-right">
                                        <input type="submit" name="submit" value="Submit" class="bg-yellow-500 cursor-pointer hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
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

        // // Deduct ₱500 if three food carts are selected
        // if (checkedFoodCarts.length === 3) {
        //     total -= 500; // Apply the discount
        // }

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

@if (session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK',
        customClass: {
        popup: 'custom-popup',
        title: 'custom-title',
        confirmButton: 'custom-button'
    }
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'custom-popup-error',
            title: 'custom-title-error',
            confirmButton: 'custom-button-error'
        }
    });
</script>
@endif

<style>
/* Success Alert Button */
.custom-button {
        background-color: #FFCF81 !important; /* Orange button background */
        color: white !important; /* White button text */
        border-radius: 5px;
    }
    .custom-button:hover {
        background-color: #E07B39 !important; /* Darker orange on hover */
    }

    /* Error Alert Button */
    .custom-button-error {
        background-color: #E07B39 !important; /* Red button background */
        color: white !important; /* White button text */
        border-radius: 5px;
    }
    .custom-button-error:hover {
        background-color: #C0392B !important; /* Darker red on hover */
    }

    /* Customize Popup Background for Error */
    .custom-popup-error {
        background-color: #FDEDEC; /* Light red background */
        border: 2px solid #E07B39; /* Red border */
    }

    /* Customize Title for Error */
    .custom-title-error {
        color: #E07B39; /* Red text for title */
        font-weight: bold;
    }
</style>

</x-manager-layout>
