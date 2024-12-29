<x-admin-layout>

    <div class="absolute">
        <a href="{{ route('showpackage', $package->package_id)}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Custom Package</span>
        </h3>
    </div>

    <form action="{{route('admin.custom.updatepackage', $package->package_id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("POST")
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
                            <p class="font-medium text-lg">Package to customize</p>
                        </div>
                        <div class="lg:col-span-2">
                            {{-- <label for="lechonItem">Lechon Items</label> --}}
                            <select name="packageitem" id="packageItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="toggleViewButton()">
                                <option disabled selected>Select package to customize</option> <!-- Enabled placeholder -->
                                @foreach($packages as $food)
                                    <option value="{{ $food->packagename }}" 
                                        @if($food->packagename == $customPackage->target) selected @endif>
                                        {{ $food->packagename }}
                                    </option>
                                @endforeach
                                <option value="Custom" 
                                    @if('Custom' == $customPackage->target) selected @endif>
                                    Custom
                                </option>
                            </select>
                            
                            <div class="flex justify-between mt-2">
                                <button type="button" onclick="clearPackageSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                                <button type="button" id="viewButton" onclick="viewSelectedPackage()" class="mt-2 text-yellow-600 hidden">View</button>
                            </div>
                            
                            <script>
                                // Function to toggle the visibility of the "View" button based on the selection
                                function toggleViewButton() {
                                    const selectedValue = document.getElementById('packageItem').value;
                                    const viewButton = document.getElementById('viewButton');
                                    
                                    // If 'Custom' is selected or no package is selected, hide the 'View' button
                                    if (selectedValue === 'Custom' || selectedValue === "") {
                                        viewButton.classList.add('hidden');
                                    } else {
                                        // Otherwise, show the 'View' button
                                        viewButton.classList.remove('hidden');
                                    }
                                }
                            
                                function viewSelectedPackage() {
                                    const selectedValue = document.getElementById('packageItem').value;
                            
                                    // If Custom is selected, no modal will open
                                    if (selectedValue === 'Custom') {
                                        alert('No details available for custom package.');
                                        return;
                                    }
                            
                                    // Show the corresponding modal for the selected package
                                    const modal = document.getElementById('modal-' + selectedValue);
                                    if (modal) {
                                        modal.classList.remove('hidden'); // Show the modal
                                    } else {
                                        console.error('Modal not found for package name:', selectedValue);
                                    }
                                }
                            
                                function toggleModal(packageName) {
                                    const modal = document.getElementById('modal-' + packageName);
                                    if (modal) {
                                        modal.classList.toggle('hidden'); // Show or hide the modal
                                    } else {
                                        console.error('Modal not found for package name:', packageName);
                                    }
                                }
                            
                                // Run the function on page load to set the correct initial visibility of the "View" button
                                document.addEventListener('DOMContentLoaded', toggleViewButton);
                            </script>
                            
                            @foreach($packages as $food)
                                <div id="modal-{{ $food->packagename }}" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-gray-800 bg-opacity-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-y-auto">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="mt-2 text-gray-700 dark:text-gray-700">
                                                    <strong class="capitalize text-xl">{{ $food->packagename }}</strong>
                                                </p>
                                                <p class="mt-2 text-gray-700 dark:text-gray-700">
                                                    <strong class="capitalize text-md">Estimated Price: ₱{{ number_format($food->packagedesc ?? 0, 2) }}</strong>
                                                </p>
                                                </div>
                                            <button type="button" onclick="toggleModal('{{ $food->packagename }}')" class="text-gray-600 hover:text-gray-900 font-bold text-xl">&times;</button>
                                        </div>
                            
                                        @if($food->packagetype == 'Custom')
                                            <p class="mt-2 text-gray-700 dark:text-gray-700">
                                                <strong>Pax:</strong> {{ $customPackage->person ?? 'Not specified' }}
                                            </p>
                                        @endif
                                        <div class="mt-4">
                                            <h3 class="text-lg font-bold text-gray-700">Inclusions</h3>
                                            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                                                @if($food->packagetype == 'Normal')
                                                    <!-- Normal Package Inclusions -->
                                                    @if (isset($food->packageinclusion))
                                                        @foreach (json_decode($food->packageinclusion) as $inclusion)
                                                            <li>{{ $inclusion }}</li>
                                                        @endforeach
                                                    @else
                                                        <li>No inclusions available</li>
                                                    @endif
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>  
                    <script>
                        function clearPackageSelection() {
                            const selectElement = document.getElementById('packageItem');
                            selectElement.selectedIndex = 0; 
                        }
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Foods</p>
                            {{-- <p>Select the quantity for each item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            <label for="package" class="uppercase bg-yellow-100 my-10 rounded-xl py-1 px-2">Main</label>
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                <div class="md:col-span-7 col-span-7">
                                    <label for="person">Pax</label>
                                    <input type="number" name="person" id="person" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 quantity-input" min="0" value="{{ old('person', $customPackage->person) }}" />
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <select name="beefitem" id="beefItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateBeefPrice()">
                                    <option disabled selected>Select Beef</option> <!-- Enabled placeholder -->
                                    @foreach($beefs as $food)
                                        <option value="{{ $food->beefname }}" 
                                            data-price="{{ $food->beefprice }}"
                                            @if(isset($selectedBeef) && $selectedBeef->item_name === $food->beefname) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->beefname }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <input type="hidden" name="beefprice" id="beefPrice" value="{{ isset($selectedBeef) ? $selectedBeef->price : '' }}">
                            
                                <button type="button" onclick="clearBeefSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            
                            <script>
                                // Update the hidden price field when a beef item is selected
                                function updateBeefPrice() {
                                    const selectElement = document.getElementById('beefItem');
                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                    const price = selectedOption.getAttribute('data-price');
                                    const priceInput = document.getElementById('beefPrice');
                                    priceInput.value = price; // Set the price in the hidden field
                                }
                            
                                // Clear the beef selection and reset price
                                function clearBeefSelection() {
                                    const selectElement = document.getElementById('beefItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    const priceInput = document.getElementById('beefPrice');
                                    priceInput.value = ''; // Reset price value
                                    calculateTotal(); // Update total after clearing selection
                                }
                            
                                // Automatically update price when page loads (in case of pre-selected option)
                                document.addEventListener('DOMContentLoaded', function() {
                                    updateBeefPrice();
                                });
                            </script>
                            

                            
                            <div class="lg:col-span-2">
                                {{-- <label for="porkitem">Pork Items</label> --}}
                                <select name="porkitem" id="porkItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updatePorkPrice()">
                                    <option disabled selected>Select Pork</option> <!-- Enabled placeholder -->
                                    @foreach($porks as $food)
                                        <option value="{{ $food->porkname }}"
                                            data-price="{{ $food->prokprice }}"
                                            @if(isset($selectedPork) && $selectedPork->item_name === $food->porkname) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->porkname }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <input type="hidden" name="porkprice" id="porkPrice" value="{{ isset($selectedPork) ? $selectedPork->price : '' }}">
                            
                                <button type="button" onclick="clearPorkSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            
                            <script>
                                // Update the hidden price field when a pork item is selected
                                function updatePorkPrice() {
                                    const selectElement = document.getElementById('porkItem');
                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                    const price = selectedOption.getAttribute('data-price');
                                    const priceInput = document.getElementById('porkPrice');
                                    priceInput.value = price; // Set the price in the hidden field
                                }
                            
                                // Clear the pork selection and reset price
                                function clearPorkSelection() {
                                    const selectElement = document.getElementById('porkItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    const priceInput = document.getElementById('porkPrice');
                                    priceInput.value = ''; // Reset price value
                                    calculateTotal(); // Update total after clearing selection
                                }
                            
                                // Automatically update price when page loads (in case of pre-selected option)
                                document.addEventListener('DOMContentLoaded', function() {
                                    updatePorkPrice();
                                });
                            </script>

                            <div class="lg:col-span-2">
                                {{-- <label for="chickenitem">Chicken Items</label> --}}
                                <select name="chickenitem" id="chickenItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateChickenPrice()">
                                    <option disabled selected>Select Chicken</option> <!-- Enabled placeholder -->
                                    @foreach($chickens as $food)
                                        <option value="{{ $food->chickenname }}" 
                                            data-price="{{ $food->chickenprice }}"
                                            @if(isset($selectedChicken) && $selectedChicken->item_name === $food->chickenname) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->chickenname }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <input type="hidden" name="chickenprice" id="chickenPrice" value="{{ isset($selectedChicken) ? $selectedChicken->price : '' }}">
                            
                                <button type="button" onclick="clearChickenSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            
                            <script>
                                // Update the hidden price field when a chicken item is selected
                                function updateChickenPrice() {
                                    const selectElement = document.getElementById('chickenItem');
                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                    const price = selectedOption.getAttribute('data-price');
                                    const priceInput = document.getElementById('chickenPrice');
                                    priceInput.value = price; // Set the price in the hidden field
                                }
                            
                                // Clear the chicken selection and reset price
                                function clearChickenSelection() {
                                    const selectElement = document.getElementById('chickenItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    const priceInput = document.getElementById('chickenPrice');
                                    priceInput.value = ''; // Reset price value
                                    calculateTotal(); // Update total after clearing selection
                                }
                            
                                // Automatically update price when page loads (in case of pre-selected option)
                                document.addEventListener('DOMContentLoaded', function() {
                                    updateChickenPrice();
                                });
                            </script>

                            <div class="lg:col-span-2">
                                {{-- <label for="veggieitem">Veggie Items</label> --}}
                                <select name="veggieitem" id="veggieItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateVeggiePrice()">
                                    <option disabled selected>Select Veggie</option> <!-- Enabled placeholder -->
                                    @foreach($veggies as $food)
                                        <option value="{{ $food->veggiename }}" 
                                            data-price="{{ $food->veggieprice }}"
                                            @if(isset($selectedVeggie) && $selectedVeggie->item_name === $food->veggiename) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->veggiename }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <input type="hidden" name="veggieprice" id="veggiePrice" value="{{ isset($selectedVeggie) ? $selectedVeggie->price : '' }}">
                            
                                <button type="button" onclick="clearVeggieSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            
                            <script>
                                // Update the hidden price field when a veggie item is selected
                                function updateVeggiePrice() {
                                    const selectElement = document.getElementById('veggieItem');
                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                    const price = selectedOption.getAttribute('data-price');
                                    const priceInput = document.getElementById('veggiePrice');
                                    priceInput.value = price; // Set the price in the hidden field
                                }
                            
                                // Clear the veggie selection and reset price
                                function clearVeggieSelection() {
                                    const selectElement = document.getElementById('veggieItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    const priceInput = document.getElementById('veggiePrice');
                                    priceInput.value = ''; // Reset price value
                                    calculateTotal(); // Update total after clearing selection
                                }
                            
                                // Automatically update price when page loads (in case of pre-selected option)
                                document.addEventListener('DOMContentLoaded', function() {
                                    updateVeggiePrice();
                                });
                            </script>

                            <div class="lg:col-span-2">
                                {{-- <label for="otheritem">Other Items</label> --}}
                                <select name="otheritem" id="otherItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateOtherPrice()">
                                    <option disabled selected>Select Fish</option> <!-- Enabled placeholder -->
                                    @foreach($others as $food)
                                        <option value="{{ $food->othername }}" 
                                            data-price="{{ $food->otherprice }}"
                                            @if(isset($selectedOther) && $selectedOther->item_name === $food->othername) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->othername }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <input type="hidden" name="otherprice" id="otherPrice" value="{{ isset($selectedOther) ? $selectedOther->price : '' }}">
                            
                                <button type="button" onclick="clearOtherSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            
                            <script>
                                // Update the hidden price field when an other item is selected
                                function updateOtherPrice() {
                                    const selectElement = document.getElementById('otherItem');
                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                    const price = selectedOption.getAttribute('data-price');
                                    const priceInput = document.getElementById('otherPrice');
                                    priceInput.value = price; // Set the price in the hidden field
                                }
                            
                                // Clear the other selection and reset price
                                function clearOtherSelection() {
                                    const selectElement = document.getElementById('otherItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    const priceInput = document.getElementById('otherPrice');
                                    priceInput.value = ''; // Reset price value
                                    calculateTotal(); // Update total after clearing selection
                                }
                            
                                // Automatically update price when page loads (in case of pre-selected option)
                                document.addEventListener('DOMContentLoaded', function() {
                                    updateOtherPrice();
                                });
                            </script>
                            
                            <br>
                            
                            <label for="package" class="uppercase bg-yellow-100 my-10 rounded-xl py-1 px-2">Dessert</label>
                            <div class="lg:col-span-2">
                                {{-- <label for="dessertitem">Dessert Items</label> --}}
                                <select name="dessertitem" id="dessertItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateDessertPrice()">
                                    <option disabled selected>Select Dessert</option> <!-- Enabled placeholder -->
                                    @foreach($desserts as $food)
                                        <option value="{{ $food->dessertname }}" 
                                            data-price="{{ $food->dessertprice }}"
                                            @if(isset($selectedDessert) && $selectedDessert->item_name === $food->dessertname) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->dessertname }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <input type="hidden" name="dessertprice" id="dessertPrice" value="{{ isset($selectedDessert) ? $selectedDessert->price : '' }}">
                            
                                <button type="button" onclick="clearDessertSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            
                            <script>
                                // Update the hidden price field when a dessert item is selected
                                function updateDessertPrice() {
                                    const selectElement = document.getElementById('dessertItem');
                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                    const price = selectedOption.getAttribute('data-price');
                                    const priceInput = document.getElementById('dessertPrice');
                                    priceInput.value = price; // Set the price in the hidden field
                                }
                            
                                // Clear the dessert selection and reset price
                                function clearDessertSelection() {
                                    const selectElement = document.getElementById('dessertItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    const priceInput = document.getElementById('dessertPrice');
                                    priceInput.value = ''; // Reset price value
                                    calculateTotal(); // Update total after clearing selection
                                }
                            
                                // Automatically update price when page loads (in case of pre-selected option)
                                document.addEventListener('DOMContentLoaded', function() {
                                    updateDessertPrice();
                                });
                            </script>

                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const personInput = document.getElementById('person');
                            const beefItem = document.getElementById('beefItem');
                            const porkItem = document.getElementById('porkItem');
                            const chickenItem = document.getElementById('chickenItem');
                            const veggieItem = document.getElementById('veggieItem');
                            const otherItem = document.getElementById('otherItem');
                            const dessertItem = document.getElementById('dessertItem');

                            // Function to check if person value is 0, none, or empty and disable/enable dropdowns
                            function toggleDropdowns() {
                                const personValue = personInput.value.trim();
                                const isDisabled = personValue === '' || parseInt(personValue) <= 0;

                                beefItem.disabled = isDisabled;
                                porkItem.disabled = isDisabled;
                                chickenItem.disabled = isDisabled;
                                veggieItem.disabled = isDisabled;
                                otherItem.disabled = isDisabled;
                                
                                // Count how many items are selected
                                const selectedItems = [beefItem, porkItem, chickenItem, veggieItem, otherItem].filter(item => item.selectedIndex > 0).length;

                                // Enable dessertItem if 4 or more items are selected
                                dessertItem.disabled = selectedItems < 4;
                            }

                            // Initial check when the page loads
                            toggleDropdowns();

                            // Listen for changes in the item selections to update dropdowns dynamically
                            [beefItem, porkItem, chickenItem, veggieItem, otherItem].forEach(item => {
                                item.addEventListener('change', toggleDropdowns);
                            });

                            // Listen for changes in the person input to update dropdowns dynamically
                            personInput.addEventListener('input', toggleDropdowns);
                        });

                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Foodpacks</p>
                            {{-- <p>Select the quantity for each item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            @foreach($foodpacks as $food)
                                @php
                                    $previousQuantity = 0;
                                    foreach ($customItems as $item) {
                                        if ($item->item_name == $food->foodpackname && $item->item_type == 'food_pack') {
                                            $previousQuantity = $item->quantity; // Retrieve the quantity from the custom item.
                                        }
                                    }
                                @endphp
                    
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                    <div class="md:col-span-4 col-span-5">
                                        <input type="hidden" name="foodpackitem[]" value="{{ $food->foodpackname }}" />
                                        <input type="hidden" name="foodpackprice[]" value="{{ $food->foodpackprice }}" /> <!-- Hidden input for price -->
                                        <input type="text" name="display_foodpackitem[]" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none placeholder-gray-800" 
                                            placeholder="{{ $food->foodpackname }}" 
                                            readonly data-price="{{ $food->foodpackprice }}" />
                                    </div>
                    
                                    <div class="md:col-span-1 col-span-2">
                                        <input type="number" name="foodpackquantity[]" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 quantity-input" 
                                            min="0" value="{{ $previousQuantity }}" />
                                    </div>
                                </div>
                            @endforeach
                    
                        </div>
                    </div>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Foodcarts</p>
                        </div>
                        <div class="lg:col-span-2">
                            @foreach($foodcarts as $food)
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                    <div class="md:col-span-4 col-span-5">
                                        <input type="hidden" name="foodcartprice[]" value="{{ $food->foodcartprice }}" /> <!-- Hidden input for price -->
                                        <input type="text" name="foodcartitem[]" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none pointer-events-none" 
                                            value="{{ $food->foodcartname }}" readonly data-price="{{ $food->foodcartprice }}" />
                                    </div>
                    
                                    <div class="md:col-span-1 col-span-2">
                                        <input type="checkbox" name="foodcartselected[]" 
                                            value="{{ $food->foodcart_id }}" 
                                            class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 checkbox-input"
                                            data-price="{{ $food->foodcartprice }}"
                                            @if(in_array($food->foodcartname, $selectedFoodcarts)) checked @endif />
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
                            {{-- <label for="lechonItem">Lechon Items</label> --}}
                            <select name="lechonitem" id="lechonItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateLechonPrice()">
                                <option disabled selected>Select Lechon</option> <!-- Enabled placeholder -->
                                @foreach($lechon as $food)
                                    <option value="{{ $food->lechonname }}" 
                                        data-price="{{ $food->lechonprice }}"
                                        @if(isset($selectedLechon) && $selectedLechon->item_name === $food->lechonname) 
                                            selected 
                                        @endif
                                    >
                                        {{ $food->lechonname }}
                                    </option>
                                @endforeach
                            </select>
                    
                            <input type="hidden" name="lechonprice" id="lechonPrice" value="{{ isset($selectedLechon) ? $selectedLechon->price : '' }}">
                    
                            <button type="button" onclick="clearLechonSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>
                    
                    <script>
                        // Update the hidden price field when a lechon item is selected
                        function updateLechonPrice() {
                            const selectElement = document.getElementById('lechonItem');
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            const price = selectedOption.getAttribute('data-price');
                            const priceInput = document.getElementById('lechonPrice');
                            priceInput.value = price; // Set the price in the hidden field
                        }
                    
                        // Clear the lechon selection and reset price
                        function clearLechonSelection() {
                            const selectElement = document.getElementById('lechonItem');
                            selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                            const priceInput = document.getElementById('lechonPrice');
                            priceInput.value = ''; // Reset price value
                            calculateTotal(); // Update total after clearing selection
                        }
                    
                        // Automatically update price when page loads (in case of pre-selected option)
                        document.addEventListener('DOMContentLoaded', function() {
                            updateLechonPrice();
                        });
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Cake</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            {{-- <label for="cakeItem">Cake Items</label> --}}
                            <select name="cakeitem" id="cakeItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateCakePrice()">
                                <option disabled selected>Select Cake</option>
                                @foreach($cake as $food)
                                    <option value="{{ $food->cakename }}" 
                                        data-price="{{ $food->cakeprice }}"
                                        @if(isset($selectedCake) && $selectedCake->item_name === $food->cakename) 
                                            selected 
                                        @endif
                                    >
                                        {{ $food->cakename }}
                                    </option>
                                @endforeach
                            </select>
                    
                            <input type="hidden" name="cakeprice" id="cakePrice" value="{{ isset($selectedCake) ? $selectedCake->price : '' }}">
                    
                            <button type="button" onclick="clearSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>
                    
                    <script>
                        // Update the hidden price field when a cake item is selected
                        function updateCakePrice() {
                            const selectElement = document.getElementById('cakeItem');
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            const price = selectedOption.getAttribute('data-price');
                            const priceInput = document.getElementById('cakePrice');
                            priceInput.value = price; // Set the price in the hidden field
                        }
                    
                        // Clear the cake selection and reset price
                        function clearSelection() {
                            const selectElement = document.getElementById('cakeItem');
                            selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                            const priceInput = document.getElementById('cakePrice');
                            priceInput.value = ''; // Reset price value
                            calculateTotal(); // Update total after clearing selection
                        }
                    
                        // Automatically update price when page loads (in case of pre-selected option)
                        document.addEventListener('DOMContentLoaded', function() {
                            updateCakePrice();
                        });
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Clown/Emcee</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            {{-- <label for="clownItem">Clown Items</label> --}}
                            <select name="clownitem" id="clownItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateClownPrice()">
                                <option disabled selected>Select Clown/Emcee</option>
                                @foreach($clown as $food)
                                    <option value="{{ $food->clownname }}" 
                                        data-price="{{ $food->clownprice }}"
                                        @if(isset($selectedClown) && $selectedClown->item_name === $food->clownname) 
                                            selected 
                                        @endif
                                    >
                                        {{ $food->clownname }}
                                    </option>
                                @endforeach
                            </select>
                    
                            <input type="hidden" name="clownprice" id="clownPrice" value="{{ isset($selectedClown) ? $selectedClown->price : '' }}">
                    
                            <button type="button" onclick="clearClownSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>
                    
                    <script>
                        // Update the hidden price field when a clown/emcee item is selected
                        function updateClownPrice() {
                            const selectElement = document.getElementById('clownItem');
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            const price = selectedOption.getAttribute('data-price');
                            const priceInput = document.getElementById('clownPrice');
                            priceInput.value = price; // Set the price in the hidden field
                        }
                    
                        // Clear the clown selection and reset price
                        function clearClownSelection() {
                            const selectElement = document.getElementById('clownItem');
                            selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                            const priceInput = document.getElementById('clownPrice');
                            priceInput.value = ''; // Reset price value
                            calculateTotal(); // Update total after clearing selection
                        }
                    
                        // Automatically update price when page loads (in case of pre-selected option)
                        document.addEventListener('DOMContentLoaded', function() {
                            updateClownPrice();
                        });
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Facepainting</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            {{-- <label for="facepaintItem">Facepaint Items</label> --}}
                            <select name="facepaintitem" id="facepaintItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateFacepaintPrice()">
                                <option disabled selected>Select Facepaint</option>
                                @foreach($facepaint as $food)
                                    <option value="{{ $food->facepaintname }}" 
                                        data-price="{{ $food->facepaintprice }}"
                                        @if(isset($selectedFacepaint) && $selectedFacepaint->item_name === $food->facepaintname) 
                                            selected 
                                        @endif
                                    >
                                        {{ $food->facepaintname }}
                                    </option>
                                @endforeach
                            </select>
                    
                            <input type="hidden" name="facepaintprice" id="facepaintPrice" value="{{ isset($selectedFacepaint) ? $selectedFacepaint->price : '' }}">
                    
                            <button type="button" onclick="clearFacepaintSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>
                    
                    <script>
                        // Update the hidden price field when a facepaint item is selected
                        function updateFacepaintPrice() {
                            const selectElement = document.getElementById('facepaintItem');
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            const price = selectedOption.getAttribute('data-price');
                            const priceInput = document.getElementById('facepaintPrice');
                            priceInput.value = price; // Set the price in the hidden field
                        }
                    
                        // Clear the facepaint selection and reset price
                        function clearFacepaintSelection() {
                            const selectElement = document.getElementById('facepaintItem');
                            selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                            const priceInput = document.getElementById('facepaintPrice');
                            priceInput.value = ''; // Reset price value
                            calculateTotal(); // Update total after clearing selection
                        }
                    
                        // Automatically update price when page loads (in case of pre-selected option)
                        document.addEventListener('DOMContentLoaded', function() {
                            updateFacepaintPrice();
                        });
                    </script>

                    <br>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Setup</p>
                            {{-- <p>Select an item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            {{-- <label for="setupItem">Setup Items</label> --}}
                            <select name="setupitem" id="setupItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" onchange="updateSetupPrice()">
                                <option disabled selected>Select Setup</option>
                                @foreach($setup as $food)
                                    <option value="{{ $food->setupname }}" 
                                        data-price="{{ $food->setupprice }}"
                                        @if(isset($selectedSetup) && $selectedSetup->item_name === $food->setupname) 
                                            selected 
                                        @endif
                                    >
                                        {{ $food->setupname }}
                                    </option>
                                @endforeach
                            </select>
                    
                            <input type="hidden" name="setupprice" id="setupPrice" value="{{ isset($selectedSetup) ? $selectedSetup->price : '' }}">
                    
                            <button type="button" onclick="clearSetupSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>
                    
                    <script>
                        // Update the hidden price field when a setup item is selected
                        function updateSetupPrice() {
                            const selectElement = document.getElementById('setupItem');
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            const price = selectedOption.getAttribute('data-price');
                            const priceInput = document.getElementById('setupPrice');
                            priceInput.value = price; // Set the price in the hidden field
                        }
                    
                        // Clear the setup selection and reset price
                        function clearSetupSelection() {
                            const selectElement = document.getElementById('setupItem');
                            selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                            const priceInput = document.getElementById('setupPrice');
                            priceInput.value = ''; // Reset price value
                            calculateTotal(); // Update total after clearing selection
                        }
                    
                        // Automatically update price when page loads (in case of pre-selected option)
                        document.addEventListener('DOMContentLoaded', function() {
                            updateSetupPrice();
                        });
                    </script>

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Service fee</p>
                        </div>
                        <div class="lg:col-span-2">
                            <input type="text" name="fee" id="fee" 
                            class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1"
                            oninput="validateFeeInput(this)" 
                            placeholder="Enter fee"
                            value="{{ old('fee', $fee->item_name ?? '') }}">

                            <button type="button" onclick="clearFeeSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                        </div>
                    </div>

                    <script>
                        function validateFeeInput() {
                            const input = document.getElementById('fee');
                            // Allow only numbers
                            input.value = input.value.replace(/[^0-9]/g, '');
                            calculateTotal();
                        }

                        function clearFeeSelection() {
                            const input = document.getElementById('fee');
                            input.value = ''; // Clear the value
                            calculateTotal(); // Call a custom function to recalculate if needed
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
                                        <input type="text" name="final" id="final" placeholder="Enter Final Price"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('final') }}"  />
                                    </div>
                                    <div class="md:col-span-5">
                                        {{-- <label for="final">Enter Final Price</label> --}}
                                        <input type="text" name="packagename" id="packagename" placeholder="Enter Package Name"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('packagename', $package->packagename ?? '') }}"  />
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
    <button id="openModalBtn" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50">
        Show Summary
    </button>
    
    <!-- Modal Structure -->
    <div id="formulaModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg sm:w-1/2 w-5/6 max-h-[90vh] overflow-y-auto">
            <h2 class="text-xl font-semibold mb-4 text-center">Selected Items Summary</h2>
            <div id="selectedItemsDisplay" class="space-y-4"></div>
    
            <div class="flex justify-end mt-6">
                <button id="closeModalBtn" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Close</button>
            </div>
        </div>
    </div>
    <script>

            // Modal open and close functionality
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const formulaModal = document.getElementById('formulaModal');

    openModalBtn.addEventListener('click', () => {
        formulaModal.classList.remove('hidden');
        openModalBtn.classList.add('hidden');  // Hide the 'Show Summary' button
    });

    closeModalBtn.addEventListener('click', () => {
        formulaModal.classList.add('hidden');
        openModalBtn.classList.remove('hidden');  // Show the 'Show Summary' button again
    });

    // Function to display selected items (updated with space and alignment)
    function displaySelectedItems() {
        const selectedItemsDisplay = document.getElementById('selectedItemsDisplay');
        selectedItemsDisplay.innerHTML = ''; // Clear previous content

        const persons = parseFloat(document.getElementById('person').value) || 0;
        const formatter = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
        });

        const foodItems = [
            { id: 'beefItem', label: 'Beef', multiplyByPersons: true },
            { id: 'porkItem', label: 'Pork', multiplyByPersons: true },
            { id: 'chickenItem', label: 'Chicken', multiplyByPersons: true },
            { id: 'veggieItem', label: 'Veggie', multiplyByPersons: true },
            { id: 'otherItem', label: 'Other', multiplyByPersons: true },
            { id: 'lechonItem', label: 'Lechon', multiplyByPersons: false },
            { id: 'cakeItem', label: 'Cake', multiplyByPersons: false },
            { id: 'clownItem', label: 'Clown', multiplyByPersons: false },
            { id: 'facepaintItem', label: 'Face Paint', multiplyByPersons: false },
            { id: 'setupItem', label: 'Setup', multiplyByPersons: false }
        ];

        // Separate items into menu and others
        const menuItems = foodItems.filter(item => item.multiplyByPersons);
        const otherItems = foodItems.filter(item => !item.multiplyByPersons);

        let total = 0; // Initialize total price

        // Helper function to create section with space
        function createSection(title, items, showQuantity) {
            const sectionTitle = document.createElement('h3');
            sectionTitle.textContent = title;
            sectionTitle.classList.add('text-lg', 'font-medium', 'mb-2');
            selectedItemsDisplay.appendChild(sectionTitle);

            items.forEach(item => {
                const selectElement = document.getElementById(item.id);
                const selectedOption = selectElement.options[selectElement.selectedIndex];

                if (selectedOption && selectedOption.dataset.price) {
                    const price = parseFloat(selectedOption.dataset.price);
                    const quantity = item.multiplyByPersons ? (persons || 1) : 1; // Multiply by persons if applicable
                    const totalPrice = price * quantity; // Calculate total price

                    // Get the name of the selected item (Beef, Pork, etc.)
                    const itemName = selectedOption.textContent.split(" - ")[0];

                    // For "Others" items, we don't show the price on the left, only on the right
                    const itemDisplay = showQuantity
                        ? `${itemName}: ₱${price.toFixed(2)} x ${quantity}pax = ₱${totalPrice.toFixed(2)}`
                        : `${itemName}`; // Just the item name for others

                    // Create a new div for each selected item
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('flex', 'justify-between', 'mb-2', 'text-sm'); // Flexbox for alignment

                    const itemDescription = document.createElement('span');
                    itemDescription.textContent = itemDisplay.split(' =')[0]; // Everything before the equal sign (item name)
                    itemDiv.appendChild(itemDescription);

                    // For "Others" section, we just add the price on the right
                    const itemTotalPrice = document.createElement('span');
                    itemTotalPrice.classList.add('font-semibold');
                    itemTotalPrice.textContent = formatter.format(totalPrice); // Total price part
                    itemDiv.appendChild(itemTotalPrice);

                    selectedItemsDisplay.appendChild(itemDiv);

                    // Add to total
                    total += totalPrice;
                }
            });
        }

        // Create menu section with space
        createSection('Menu:', menuItems, true);

        // Display selected dessert
        const dessertSelect = document.getElementById('dessertItem');
        const selectedDessertOption = dessertSelect.options[dessertSelect.selectedIndex];
        if (selectedDessertOption && selectedDessertOption.dataset.price) {
            const dessertPrice = parseFloat(selectedDessertOption.dataset.price);
            const dessertName = selectedDessertOption.textContent.split(" - ")[0]; // Extract the dessert name

            const dessertDiv = document.createElement('div');
            dessertDiv.classList.add('flex', 'justify-between', 'mb-2', 'text-sm'); // Flexbox for alignment

            const dessertDescription = document.createElement('span');
            dessertDescription.textContent = `${dessertName}: ₱${dessertPrice.toFixed(2)}`; // Display the dessert and its price
            dessertDiv.appendChild(dessertDescription);

            const dessertTotalPrice = document.createElement('span');
            dessertTotalPrice.classList.add('font-semibold');
            dessertTotalPrice.textContent = formatter.format(dessertPrice); // Display the dessert price
            dessertDiv.appendChild(dessertTotalPrice);

            selectedItemsDisplay.appendChild(dessertDiv);

            // Add dessert price to total
            total += dessertPrice;
        }

        // Create others section with space
        createSection('Others:', otherItems, false);

        // Display total price for food packs
        const foodPackTotal = Array.from(document.querySelectorAll('input[name="foodpackquantity[]"]')).reduce((acc, input, index) => {
            const quantity = parseFloat(input.value) || 0;
            const price = parseFloat(input.closest('.grid').querySelector('input[type="text"]').dataset.price) || 0;
            const totalFoodPackPrice = quantity * price;
            acc += totalFoodPackPrice;

            if (quantity > 0) {
                const foodpackName = input.closest('.grid').querySelector('input[name="display_foodpackitem[]"]').placeholder.split(" - ")[0];
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('flex', 'justify-between', 'mb-2', 'text-sm'); // Flexbox for alignment
                const itemDescription = document.createElement('span');
                itemDescription.textContent = `Food Pack (${foodpackName}): ₱${price.toFixed(2)} x ${quantity}`;
                itemDiv.appendChild(itemDescription);
                const itemTotalPrice = document.createElement('span');
                itemTotalPrice.classList.add('font-semibold');
                itemTotalPrice.textContent = formatter.format(totalFoodPackPrice);
                itemDiv.appendChild(itemTotalPrice);
                selectedItemsDisplay.appendChild(itemDiv);
            }

            return acc;
        }, 0);

        // Add food pack total to overall total
        total += foodPackTotal;

        // Display food cart total with space
        const foodCartTotal = Array.from(document.querySelectorAll('input[name="foodcartselected[]"]:checked')).reduce((acc, checkbox) => {
            const price = parseFloat(checkbox.closest('.grid').querySelector('input[type="text"]').dataset.price) || 0;
            const foodCartName = checkbox.closest('.grid').querySelector('input[name="foodcartitem[]"]').value.split(" - ")[0];
            acc += price;

            const itemDiv = document.createElement('div');
            itemDiv.classList.add('flex', 'justify-between', 'mb-2', 'text-sm'); // Flexbox to align items
            const itemDescription = document.createElement('span');
            itemDescription.textContent = `Food Cart (${foodCartName})`;
            itemDiv.appendChild(itemDescription);
            const itemPrice = document.createElement('span');
            itemPrice.classList.add('font-semibold');
            itemPrice.textContent = formatter.format(price);
            itemDiv.appendChild(itemPrice);
            selectedItemsDisplay.appendChild(itemDiv);


            return acc;
        }, 0);

        // Add food cart total to overall total
        total += foodCartTotal;

        // Display service fee
        const feeInput = document.getElementById('fee');
        const fee = parseFloat(feeInput.value) || 0; // Default to 0 if empty
        total += fee; // Add the service fee to the total

        const feeDiv = document.createElement('div');
        feeDiv.classList.add('flex', 'justify-between', 'mb-2', 'text-sm'); // Flexbox to align items
        const feeDescription = document.createElement('span');
        feeDescription.textContent = 'Service Fee:';
        feeDiv.appendChild(feeDescription);
        const feePrice = document.createElement('span');
        feePrice.classList.add('font-semibold');
        feePrice.textContent = formatter.format(fee);
        feeDiv.appendChild(feePrice);
        selectedItemsDisplay.appendChild(feeDiv);


        // Display the overall total with space
        const totalDiv = document.createElement('div');
        totalDiv.textContent = 'Total: ' + formatter.format(total);
        totalDiv.classList.add('mt-4', 'font-bold', 'text-right', 'text-md');
        selectedItemsDisplay.appendChild(totalDiv);
    }



        // Function to calculate the total price
        function calculateTotal() {
            let total = 0;
    
            // Get the number of persons
            const persons = parseFloat(document.getElementById('person').value) || 0; // Default to 0 if empty
    
            // Calculate total from beef dropdown selection
            const beefSelect = document.getElementById('beefItem');
            const selectedBeefOption = beefSelect.options[beefSelect.selectedIndex];
            if (selectedBeefOption && selectedBeefOption.dataset.price) {
                const beefPrice = parseFloat(selectedBeefOption.dataset.price);
                total += beefPrice * persons; // Multiply the price by the number of persons
            }
    
            const porkSelect = document.getElementById('porkItem');
            const selectedPorkOption = porkSelect.options[porkSelect.selectedIndex];
            if (selectedPorkOption && selectedPorkOption.dataset.price) {
                const porkPrice = parseFloat(selectedPorkOption.dataset.price);
                total += porkPrice * persons; // Multiply the price by the number of persons
            }
    
            const chickenSelect = document.getElementById('chickenItem');
            const selectedChickenOption = chickenSelect.options[chickenSelect.selectedIndex];
            if (selectedChickenOption && selectedChickenOption.dataset.price) {
                const chickenPrice = parseFloat(selectedChickenOption.dataset.price);
                total += chickenPrice * persons; // Multiply the price by the number of persons
            }
    
            const veggieSelect = document.getElementById('veggieItem');
            const selectedVeggieOption = veggieSelect.options[veggieSelect.selectedIndex];
            if (selectedVeggieOption && selectedVeggieOption.dataset.price) {
                const veggiePrice = parseFloat(selectedVeggieOption.dataset.price);
                total += veggiePrice * persons; // Multiply the price by the number of persons
            }
    
            const otherSelect = document.getElementById('otherItem');
            const selectedOtherOption = otherSelect.options[otherSelect.selectedIndex];
            if (selectedOtherOption && selectedOtherOption.dataset.price) {
                const otherPrice = parseFloat(selectedOtherOption.dataset.price);
                total += otherPrice * persons; // Multiply the price by the number of persons
            }
    
            // Calculate total from foodpacks
            document.querySelectorAll('input[name="foodpackquantity[]"]').forEach(function(input) {
                const quantity = parseFloat(input.value) || 0;
                const price = parseFloat(input.closest('.grid').querySelector('input[type="text"]').dataset.price) || 0;
                total += quantity * price;
            });
    
            // Calculate total from foodcarts
            const checkedFoodCarts = document.querySelectorAll('input[name="foodcartselected[]"]:checked');
            checkedFoodCarts.forEach(function(checkbox) {
                const price = parseFloat(checkbox.closest('.grid').querySelector('input[type="text"]').dataset.price) || 0;
                total += price;
            });

            const dessertSelect = document.getElementById('dessertItem');
            const selectedDessertOption = dessertSelect.options[dessertSelect.selectedIndex];
            if (selectedDessertOption && selectedDessertOption.dataset.price) {
                const dessertPrice = parseFloat(selectedDessertOption.dataset.price);
                total += dessertPrice;
            }
    
            // Calculate total from lechon dropdown selection
            const lechonSelect = document.getElementById('lechonItem');
            const selectedLechonOption = lechonSelect.options[lechonSelect.selectedIndex];
            if (selectedLechonOption && selectedLechonOption.dataset.price) {
                const lechonPrice = parseFloat(selectedLechonOption.dataset.price);
                total += lechonPrice;
            }
    
            // Calculate total from cake dropdown selection
            const cakeSelect = document.getElementById('cakeItem');
            const selectedCakeOption = cakeSelect.options[cakeSelect.selectedIndex];
            if (selectedCakeOption && selectedCakeOption.dataset.price) {
                const cakePrice = parseFloat(selectedCakeOption.dataset.price);
                total += cakePrice;
            }
    
            // Calculate total from clown dropdown selection
            const clownSelect = document.getElementById('clownItem');
            const selectedClownOption = clownSelect.options[clownSelect.selectedIndex];
            if (selectedClownOption && selectedClownOption.dataset.price) {
                const clownPrice = parseFloat(selectedClownOption.dataset.price);
                total += clownPrice;
            }
    
            // Calculate total from facepaint dropdown selection
            const facepaintSelect = document.getElementById('facepaintItem');
            const selectedFacepaintOption = facepaintSelect.options[facepaintSelect.selectedIndex];
            if (selectedFacepaintOption && selectedFacepaintOption.dataset.price) {
                const facepaintPrice = parseFloat(selectedFacepaintOption.dataset.price);
                total += facepaintPrice;
            }
    
            // Calculate total from setup dropdown selection
            const setupSelect = document.getElementById('setupItem');
            const selectedSetupOption = setupSelect.options[setupSelect.selectedIndex];
            if (selectedSetupOption && selectedSetupOption.dataset.price) {
                const setupPrice = parseFloat(selectedSetupOption.dataset.price);
                total += setupPrice;
            }

            const feeInput = document.getElementById('fee');
            const fee = parseFloat(feeInput.value) || 0; // Default to 0 if empty
            total += fee; // Add the service fee to the total
    
            // Update the total display
            document.getElementById('total').textContent = `₱${total.toFixed(2)}`;
            displaySelectedItems();
        }
    
        // Attach event listeners to quantity inputs and checkboxes
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            input.addEventListener('input', calculateTotal);
        });
    
        document.querySelectorAll('.checkbox-input').forEach(function(checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        });
    
        // Attach event listeners for all dropdowns
        document.getElementById('lechonItem').addEventListener('change', calculateTotal);
        document.getElementById('cakeItem').addEventListener('change', calculateTotal);
        document.getElementById('clownItem').addEventListener('change', calculateTotal);
        document.getElementById('facepaintItem').addEventListener('change', calculateTotal);
        document.getElementById('setupItem').addEventListener('change', calculateTotal);
        document.getElementById('beefItem').addEventListener('change', calculateTotal);
        document.getElementById('porkItem').addEventListener('change', calculateTotal);
        document.getElementById('chickenItem').addEventListener('change', calculateTotal);
        document.getElementById('veggieItem').addEventListener('change', calculateTotal);
        document.getElementById('otherItem').addEventListener('change', calculateTotal);
        document.getElementById('dessertItem').addEventListener('change', calculateTotal);
    
        // Trigger the calculation on page load to set the initial total
        window.addEventListener('load', calculateTotal);

                    // Attach event listeners
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('input', calculateTotal);
    });

    document.querySelectorAll('.checkbox-input').forEach(function(checkbox) {
        checkbox.addEventListener('change', calculateTotal);
    });

    const dropdowns = [
        'lechonItem', 'cakeItem', 'clownItem', 'facepaintItem', 'setupItem',
        'beefItem', 'porkItem', 'chickenItem', 'veggieItem', 'otherItem', 'fee'
    ];

    dropdowns.forEach(id => {
        document.getElementById(id).addEventListener('change', calculateTotal);
    });
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

</x-admin-layout>
