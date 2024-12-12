<x-admin-layout>

    <div class="absolute">
        <a href="{{ url()->previous() }}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Custom Package</span>
        </h3>
    </div>

    <form action="{{route('admin.booked.custom.updatepackage', $package->package_id)}}" method="POST" enctype="multipart/form-data">
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
                                            <p class="mt-2 text-gray-700 dark:text-gray-700">
                                                <strong class="capitalize text-xl">{{ $food->packagename }}</strong>
                                            </p>
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

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Foods</p>
                            {{-- <p>Select the quantity for each item.</p> --}}
                        </div>
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-7 md:grid-cols-5">
                                <div class="md:col-span-7 col-span-7">
                                    <label for="person">Pax</label>
                                    <input type="number" name="person" id="person" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 quantity-input" min="0" value="{{ old('person', $customPackage->person) }}" />
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <select name="beefitem" id="beefItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option disabled selected>Select Beef</option> <!-- Enabled placeholder -->
                                    @foreach($beefs as $food)
                                        <option value="{{ $food->beefname }}" 
                                            data-price="{{ $food->beefprice }}"
                                            @if(isset($selectedBeef) && $selectedBeef->item_name === $food->beefname) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->beefname }} - ₱{{ number_format($food->beefprice, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="clearBeefSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            
                            <script>
                                function clearBeefSelection() {
                                    const selectElement = document.getElementById('beefItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    calculateTotal(); // Update total after clearing selection
                                }
                            </script>
                            

                            <div class="lg:col-span-2">
                                {{-- <label for="porkitem">Pork Items</label> --}}
                                <select name="porkitem" id="porkItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option disabled selected>Select Pork</option> <!-- Enabled placeholder -->
                                    @foreach($porks as $food)
                                        <option value="{{ $food->porkname }}"
                                            data-price="{{ $food->prokprice }}"
                                            @if(isset($selectedPork) && $selectedPork->item_name === $food->porkname) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->porkname }} - ₱{{ number_format($food->prokprice, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="clearPorkSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            <script>
                                function clearPorkSelection() {
                                    const selectElement = document.getElementById('porkItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    calculateTotal(); // Update total after clearing selection
                                }
                            </script>

                            <div class="lg:col-span-2">
                                {{-- <label for="chickenitem">Chicken Items</label> --}}
                                <select name="chickenitem" id="chickenItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option disabled selected>Select Chicken</option> <!-- Enabled placeholder -->
                                    @foreach($chickens as $food)
                                        <option value="{{ $food->chickenname }}" 
                                            data-price="{{ $food->chickenprice }}"
                                            @if(isset($selectedChicken) && $selectedChicken->item_name === $food->chickenname) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->chickenname }} - ₱{{ number_format($food->chickenprice, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="clearChickenSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            <script>
                                function clearChickenSelection() {
                                    const selectElement = document.getElementById('chickenItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    calculateTotal(); // Update total after clearing selection
                                }
                            </script>

                            <div class="lg:col-span-2">
                                {{-- <label for="veggieitem">Veggie Items</label> --}}
                                <select name="veggieitem" id="veggieItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option disabled selected>Select Veggie</option> <!-- Enabled placeholder -->
                                    @foreach($veggies as $food)
                                        <option value="{{ $food->veggiename }}" 
                                            data-price="{{ $food->veggieprice }}"
                                            @if(isset($selectedVeggie) && $selectedVeggie->item_name === $food->veggiename) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->veggiename }} - ₱{{ number_format($food->veggieprice, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="clearVeggieSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            <script>
                                function clearVeggieSelection() {
                                    const selectElement = document.getElementById('veggieItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    calculateTotal(); // Update total after clearing selection
                                }
                            </script>

                            <div class="lg:col-span-2">
                                {{-- <label for="veggieitem">Veggie Items</label> --}}
                                <select name="otheritem" id="otherItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option disabled selected>Select Fish</option> <!-- Enabled placeholder -->
                                    @foreach($others as $food)
                                        <option value="{{ $food->othername }}" 
                                            data-price="{{ $food->otherprice }}"
                                            @if(isset($selectedOther) && $selectedOther->item_name === $food->othername) 
                                                selected 
                                            @endif
                                        >
                                            {{ $food->othername }} - ₱{{ number_format($food->otherprice, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="clearOtherSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                            </div>
                            <script>
                                function clearOtherSelection() {
                                    const selectElement = document.getElementById('otherItem');
                                    selectElement.selectedIndex = 0; // Reset to the first option (placeholder)
                                    calculateTotal(); // Update total after clearing selection
                                }
                            </script>
                                
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
                                        <input type="text" name="display_foodpackitem[]" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none placeholder-gray-800" 
                                            placeholder="{{ $food->foodpackname }} - ₱{{ number_format($food->foodpackprice, 2) }}" 
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
                            <select name="lechonitem" id="lechonItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Lechon</option> <!-- Enabled placeholder -->
                                @foreach($lechon as $food)
                                    <option value="{{ $food->lechonname }}" 
                                        data-price="{{ $food->lechonprice }}"
                                        @if(isset($selectedLechon) && $selectedLechon->item_name === $food->lechonname) 
                                                selected 
                                            @endif
                                        >
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
                            {{-- <label for="cakeItem">Cake Items</label> --}}
                            <select name="cakeitem" id="cakeItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Cake</option>
                                @foreach($cake as $food)
                                    <option value="{{ $food->cakename }}" 
                                        data-price="{{ $food->cakeprice }}"
                                        @if(isset($selectedCake) && $selectedCake->item_name === $food->cakename) 
                                            selected 
                                        @endif
                                    >
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
                            {{-- <label for="cakeItem">Clown items</label> --}}
                            <select name="clownitem" id="clownItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Clown/Emcee</option>
                                @foreach($clown as $food)
                                    <option value="{{ $food->clownname }}" 
                                        data-price="{{ $food->clownprice }}"
                                        @if(isset($selectedClown) && $selectedClown->item_name === $food->clownname) 
                                            selected 
                                        @endif
                                    >
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
                            {{-- <label for="facepaintItem">Facepaint items</label> --}}
                            <select name="facepaintitem" id="facepaintItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Facepaint</option>
                                @foreach($facepaint as $food)
                                    <option value="{{ $food->facepaintname }}" 
                                        data-price="{{ $food->facepaintprice }}"
                                        @if(isset($selectedFacepaint) && $selectedFacepaint->item_name === $food->facepaintname) 
                                            selected 
                                        @endif
                                    >
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
                            {{-- <label for="setupItem">Setup items</label> --}}
                            <select name="setupitem" id="setupItem" class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option disabled selected>Select Setup</option>
                                @foreach($setup as $food)
                                    <option value="{{ $food->setupname }}" 
                                        data-price="{{ $food->setupprice }}"
                                        @if(isset($selectedSetup) && $selectedSetup->item_name === $food->setupname) 
                                            selected 
                                        @endif
                                    >
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

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Service fee</p>
                        </div>
                        <div class="lg:col-span-2">
                            <input type="text" name="fee" id="fee" 
                            class="h-10 border text-sm mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1"
                            oninput="validateFeeInput(this)" 
                            placeholder="Enter fee"
                            value="{{ old('fee', $fee->item_name ?? 0) }}">

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
                                    {{-- <div class="md:col-span-5">
                                        <input type="text" name="packagename" id="packagename" placeholder="Enter Package Name"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('packagename', $package->packagename ?? '') }}"  />
                                    </div> --}}
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
    
        // Trigger the calculation on page load to set the initial total
        window.addEventListener('load', calculateTotal);
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
