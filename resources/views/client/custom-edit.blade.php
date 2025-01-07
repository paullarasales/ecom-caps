<x-app-layout>
    <div class="text-center py-2 my-20">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Package Inclusion</span>
        </h3>

    </div>
{{-- <h1>{{$package->package_id}}</h1> --}}
    
    <form action="{{route('client.package.update', $package->package_id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
            <div>
                <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Note: This is not the final package</p>
                                <p>Please fill out all the fields. To provide the management an idea of what you needed</p>
                                <br>
                            </div>
    
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                {{-- <div class="md:col-span-5">
                                    <label for="firstname">Package Type Name</label>
                                    <input type="text" name="packagename" id="packagename" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{ old('packagename') }}" />
                                </div> --}}

                                <div class="md:col-span-5">
                                    <label for="pax">Pax For Foods</label>
                                    <br>
                                    <label for="firstname"><strong>Note: </strong>Foods: 4 Dishes (1 Beef, 1 Pork, 1 Chicken/Fish, 1 Veggie, Free dessert)</label>
                                    <select name="pax" id="pax" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option disabled selected>Select How Many Pax</option>
                                        @foreach(['30 pax', '40 pax', '50 pax', '60 pax', '70 pax', '80 pax', '90 pax', '100 pax', '110 pax', '120 pax', '130 pax', '140 pax', '150 pax', '160 pax', '170 pax', '180 pax', '190 pax', '200 pax', '250 pax', '300 pax', '350 pax', '400 pax'] as $paxOption)
                                            <option value="{{ $paxOption }}" 
                                                {{ in_array($paxOption, $inclusions) ? 'selected' : '' }}>
                                                {{ $paxOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="clearPaxSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                                </div>
                                
                                <script>
                                    function clearPaxSelection() {
                                        // Get the select element
                                        var paxSelect = document.getElementById('pax');
                                        
                                        // Reset the selection to the first option (Select How Many Pax)
                                        paxSelect.selectedIndex = 0;
                                
                                        // Manually trigger the 'change' event to update the total
                                        paxSelect.dispatchEvent(new Event('change'));
                                    }
                                </script>
                                

                                {{-- {{dd($inclusions);}} --}}
                                

                                <div class="md:col-span-2">
                                    <label for="pack">Foodpack</label>
                                    <select name="pack" id="pack" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option disabled selected>Select How Many Foodpack</option>
                                        @foreach(['10 Foodpack', '15 Foodpack', '20 Foodpack', '25 Foodpack', '30 Foodpack', '35 Foodpack', '40 Foodpack', '45 Foodpack', '50 Foodpack'] as $packOption)
                                            <option value="{{ $packOption }}" 
                                                {{ in_array($packOption, $inclusions) ? 'selected' : '' }}>
                                                {{ $packOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="clearPackSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                                </div>
                                
                                <script>
                                    function clearPackSelection() {
                                        // Get the select element
                                        var packSelect = document.getElementById('pack');
                                        
                                        // Reset the selection to the first option (Select How Many Foodpack)
                                        packSelect.selectedIndex = 0;
                                
                                        // Manually trigger the 'change' event to update the total
                                        packSelect.dispatchEvent(new Event('change'));
                                    }
                                </script>
                                

                                <div class="md:col-span-2">
                                    <label for="cart">Foodcart</label>
                                    <select name="cart" id="cart" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option disabled selected>Select How Many Foodcart</option>
                                        @foreach(['1 Foodcart', '2 Foodcart', '3 Foodcart', '4 Foodcart'] as $cartOption)
                                            <option value="{{ $cartOption }}" 
                                                {{ in_array($cartOption, $inclusions) ? 'selected' : '' }}>
                                                {{ $cartOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="clearCartSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                                </div>
                                
                                <script>
                                    function clearCartSelection() {
                                        // Get the select element
                                        var cartSelect = document.getElementById('cart');
                                        
                                        // Reset the selection to the first option (Select How Many Foodcart)
                                        cartSelect.selectedIndex = 0;
                                
                                        // Manually trigger the 'change' event to update the total
                                        cartSelect.dispatchEvent(new Event('change'));
                                    }
                                </script>
                                

                                <div class="md:col-span-1">
                                    <label for="cake">Cake</label>
                                    <input type="checkbox" name="cake" id="cake" value="1" class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 checkbox-input"
                                    {{ in_array('Cake', $inclusions) ? 'checked' : '' }} />
                                </div>

                                <div class="md:col-span-3">
                                    <label for="clown">Clown/Emcee</label>
                                    <select name="clown" id="clown" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option disabled selected>Select Clown/Emcee</option>
                                        @foreach(['Clown', 'Emcee', 'Clown/Emcee'] as $clownOption)
                                            <option value="{{ $clownOption }}" 
                                                {{ in_array($clownOption, $inclusions) ? 'selected' : '' }}>
                                                {{ $clownOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="clearClownSelection()" class="mt-2 text-yellow-600">Clear Selection</button>
                                </div>
                                
                                <script>
                                    function clearClownSelection() {
                                        // Get the select element
                                        var clownSelect = document.getElementById('clown');
                                        
                                        // Reset the selection to the first option (Select Clown/Emcee)
                                        clownSelect.selectedIndex = 0;
                                
                                        // Manually trigger the 'change' event to update the total
                                        clownSelect.dispatchEvent(new Event('change'));
                                    }
                                </script>
                                
                                
                                <div class="md:col-span-1">
                                    <label for="paint">Facepaint</label>
                                    <input type="checkbox" name="paint" value="1" id="paint" class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 checkbox-input"
                                    {{ in_array('Facepaint', $inclusions) ? 'checked' : '' }} />
                                </div>

                                <div class="md:col-span-1">
                                    <label for="setup">Setup</label>
                                    <input type="checkbox" name="setup" value="1" id="setup" class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 checkbox-input"
                                    {{ in_array('Setup', $inclusions) ? 'checked' : '' }} />
                                </div>

                                <div class="md:col-span-5 text-right mt-4">
                                    <hr class="my-5 border border-yellow-100">
                                <!-- Total calculation -->
                                    <div class="col-span-2">
                                        <div class="bg-gray-100 rounded-md p-4 text-center">
                                            <h4 class="text-xl font-semibold">Total</h4>
                                            <p id="total" class="text-3xl font-bold text-yellow-600">₱ {{ old('total_amount', '0.00') }} </p>
                                            <input type="hidden" name="total_amount" id="totalAmount" value="{{ old('total_amount', '0.00') }}">
                                            <br>
                                            <label for="setup">Note: This is just an <strong class="capitalize">estimated price</strong>, expect additional fee based on location</label>
                                        </div>
                                    </div>
                                </div>
                                


                                <div class="md:col-span-5 text-right">
                                    <input type="submit" name="submit" value="Submit" class="cursor-pointer bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <!-- Show Summary Button -->
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

    const formatter = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
        });

    openModalBtn.addEventListener('click', () => {
        formulaModal.classList.remove('hidden');  // Show the modal
        openModalBtn.classList.add('hidden');     // Hide the 'Show Summary' button
    });

    closeModalBtn.addEventListener('click', () => {
        formulaModal.classList.add('hidden');    // Hide the modal
        openModalBtn.classList.remove('hidden'); // Show the 'Show Summary' button again
    });

    document.addEventListener("DOMContentLoaded", function () {
        // Define base prices
        const basePrices = {
            pax: 300,     // Base price per pax
            pack: 105,     // Base price per pack
            cart: 3000,   // Base price per cart
            extras: {
                cake: 1500,
                paint: 1500,
                setup: 10000,
            },
            clown: {
                "Clown": 2000,
                "Emcee": 2500,
                "Clown/Emcee": 3000,
            },
        };

        // Dynamically calculate prices for pax, pack, and cart
        const prices = {
            pax: [30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200, 250, 300, 350, 400]
                .reduce((acc, val) => ({ ...acc, [`${val} pax`]: val * basePrices.pax }), {}),
            pack: [10, 15, 20, 25, 30, 35, 40, 45, 50]
                .reduce((acc, val) => ({ ...acc, [`${val} Foodpack`]: val * basePrices.pack }), {}),
            cart: [1, 2, 3, 4]
                .reduce((acc, val) => ({ ...acc, [`${val} Foodcart`]: val * basePrices.cart }), {}),
            extras: basePrices.extras,
            clown: basePrices.clown,
        };

        // Get elements
        const paxSelect = document.getElementById("pax");
        const packSelect = document.getElementById("pack");
        const cartSelect = document.getElementById("cart");
        const clownSelect = document.getElementById("clown");
        const cakeCheckbox = document.getElementById("cake");
        const paintCheckbox = document.getElementById("paint");
        const setupCheckbox = document.getElementById("setup");
        const totalDisplay = document.getElementById("total");
        const totalAmountInput = document.getElementById("totalAmount");
        const selectedItemsDisplay = document.getElementById('selectedItemsDisplay');

        // Function to calculate total and update modal
        function calculateTotal() {
            let total = 0;
            let summaryHtml = '';

            // Add pax price
            if (paxSelect.value in prices.pax) {
                total += prices.pax[paxSelect.value];
                summaryHtml += `
                    <p class="flex justify-between">
                        <span>${paxSelect.value}</span>
                        <span>${formatter.format(prices.pax[paxSelect.value])}</span>
                    </p>
                    `;
            }

            // Add pack price
            if (packSelect.value in prices.pack) {
                total += prices.pack[packSelect.value];
                // summaryHtml += `<p>${packSelect.value} - ₱ ${prices.pack[packSelect.value]}</p>`;
                summaryHtml += `
                    <p class="flex justify-between">
                        <span>${packSelect.value}</span>
                        <span>${formatter.format(prices.pack[packSelect.value])}</span>
                    </p>
                    `;
            }

            // Add cart price
            if (cartSelect.value in prices.cart) {
                total += prices.cart[cartSelect.value];
                // summaryHtml += `<p>${cartSelect.value} - ₱ ${prices.cart[cartSelect.value]}</p>`;
                summaryHtml += `
                    <p class="flex justify-between">
                        <span>${cartSelect.value}</span>
                        <span>${formatter.format(prices.cart[cartSelect.value])}</span>
                    </p>
                    `;
            }

            // Add clown/emcee price
            if (clownSelect.value in prices.clown) {
                total += prices.clown[clownSelect.value];
                // summaryHtml += `<p>${clownSelect.value} - ₱ ${prices.clown[clownSelect.value]}</p>`;
                summaryHtml += `
                    <p class="flex justify-between">
                        <span>${clownSelect.value}</span>
                        <span>${formatter.format(prices.clown[clownSelect.value])}</span>
                    </p>
                    `;
            }

            // Add extras price
            if (cakeCheckbox.checked) {
                total += prices.extras.cake;
                summaryHtml += `
                    <p class="flex justify-between">
                        <span>Cake</span>
                        <span>${formatter.format(prices.extras.cake)}</span>
                    </p>
                    `;
            }

            if (paintCheckbox.checked) {
                total += prices.extras.paint;
                // summaryHtml += `<p>Paint - ₱ ${prices.extras.paint}</p>`;
                summaryHtml += `
                    <p class="flex justify-between">
                        <span>Facepaint</span>
                        <span>${formatter.format(prices.extras.paint)}</span>
                    </p>
                    `;
            }
            if (setupCheckbox.checked) {
                total += prices.extras.setup;
                // summaryHtml += `<p>Setup - ₱ ${prices.extras.setup}</p>`;
                summaryHtml += `
                    <p class="flex justify-between">
                        <span>Setup</span>
                        <span>${formatter.format(prices.extras.setup)}</span>
                    </p>
                    `;
            }

            summaryHtml += `
                    <p class="flex justify-between text-xl font-semibold">
                        <span>Total</span>
                        <span>${formatter.format(total)}</span>
                    </p>
                    `;

            // Update modal content
            selectedItemsDisplay.innerHTML = summaryHtml;

            // Update total display and hidden input
            totalDisplay.textContent = `₱ ${total.toFixed(2)}`;
            totalAmountInput.value = total.toFixed(2);
        }

        // Event listeners
        paxSelect.addEventListener("change", calculateTotal);
        packSelect.addEventListener("change", calculateTotal);
        cartSelect.addEventListener("change", calculateTotal);
        clownSelect.addEventListener("change", calculateTotal);
        cakeCheckbox.addEventListener("change", calculateTotal);
        paintCheckbox.addEventListener("change", calculateTotal);
        setupCheckbox.addEventListener("change", calculateTotal);

        // Initial total calculation on page load (if any default selections exist)
        calculateTotal();
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

</x-app-layout>
