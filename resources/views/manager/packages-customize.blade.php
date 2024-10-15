<x-manager-layout>
    
    <div class="absolute">
        <a href="{{route('managerpackages')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Package <span class="text-yellow-600">Customization</span>
        </h3>
    </div>

<form action="{{route('manageraddcustom')}}" method="POST" enctype="multipart/form-data">
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
    <div class=" p-6 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <div>
                <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Food</p>
                            </div>
                        
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-2">
                                    <label for="veggie">Veggie</label>
                                    <input type="number" name="veggie" id="veggie" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="chicken">Chicken</label>
                                    <input type="number" name="chicken" id="chicken" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="fish">Fish</label>
                                    <input type="number" name="fish" id="fish" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="pork">Pork</label>
                                    <input type="number" name="pork" id="pork" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="beef">Beef</label>
                                    <input type="number" name="beef" id="beef" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5 border border-yellow-100">

                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Food Cart</p>
                            </div>
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-2 md:grid-cols-4">
                                <div class="md:col-span-1">
                                    <label for="IceCream">Ice Cream</label>
                                    <input type="checkbox" name="IceCream" id="IceCream"  class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-1">
                                    <label for="FrenchFries">French Fries</label>
                                    <input type="checkbox" name="FrenchFries" id="FrenchFries"  class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-1">
                                    <label for="MixedBalls">Mixed Balls</label>
                                    <input type="checkbox" name="MixedBalls" id="MixedBalls"  class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-1">
                                    <label for="Hotdogs">Hotdogs</label>
                                    <input type="checkbox" name="Hotdogs" id="Hotdogs"  class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5 border border-yellow-100">
                    
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Add Ons</p>
                            </div>
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                                <div class="md:col-span-3">
                                    <label for="foodPack">Select Food Pack</label>
                                    <select name="packname" id="foodPack" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option value="" disabled selected></option>
                                        <option id="Pack1" value="FC R D">Fried Chicken & Rice & Drink - 95</option>
                                        <option id="Pack2" value="FC S D">Fried Chicken & Spagehtti & Drink - 105</option>
                                        <option id="Pack3" value="S D">Spaghetti & Drink - 70</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="foodPackQuantity">Quantity</label>
                                    <input type="number" name="foodpack" id="foodPackQuantity" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>

                                <div class="md:col-span-3">
                                    <label for="lechonkg">Lechon</label>
                                    <select name="lechonkg" id="lechonkg" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option value="" disabled selected></option>
                                        <option id="lechon1" value="25 kg">25 kg - 15000</option>
                                        <option id="lechon2" value="30 kg">30 kg - 18000</option>
                                        <option id="lechon3" value="45 kg">45 kg - 25000</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="lechonQuantity">Lechon</label>
                                    <input type="number" name="lechonQuantity" id="lechonQuantity" value="0" min="0"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                
                                <div class="md:col-span-1">
                                    <label for="Cake">Cake</label>
                                    <input type="checkbox" name="Cake" id="Cake"  class="form-checkbox h-10 text-yellow-200 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="Lootbags">Lootbags</label>
                                    <input type="number" name="Lootbags" id="Lootbags" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="Setup">Set Up</label>
                                    {{-- <input type="number" name="Lootbags" id="Lootbags" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" /> --}}
                                    <select name="Setup" id="Setup" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                        <option disabled selected></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-5 border border-yellow-100">
                    
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Number of Person</p>
                            </div>
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-6">
                                    <label for="persons">Pax</label>
                                    <input type="number" name="persons" id="persons" value="100" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5 border border-yellow-100">
                    <!-- Total calculation -->
                    <div class="col-span-2">
                        <div class="bg-gray-100 rounded-md p-4 text-center">
                            <h4 class="text-xl font-semibold">Total</h4>
                            <p id="totalPrice" class="text-3xl font-bold text-yellow-600">₱ 0.00</p>
                        </div>
                    </div>

                    <hr class="my-5 border border-yellow-100">
                    
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                {{-- <p class="font-medium text-lg">Number of Person</p> --}}
                            </div>
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-6">
                                    <label for="final">Enter Final Price</label>
                                    <input type="text" name="final" id="final"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
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



    {{--  --}}
    
    <script>
        // Base prices for a 100-person package (for 1 quantity)
        const baseVeggiePrice = 5000;
        const baseBeefPrice = 9000;
        const basePorkPrice = 8000;
        const baseChickenPrice = 8000;
        const baseFishPrice = 8000;
    
        // Food Cart prices (fixed)
        const IceCreamPrice = 3500;
        const MixedBallsPrice = 3000;
        const FrenchFriesPrice = 3000;
        const HotdogsPrice = 3000;
    
        // Add Ons prices (fixed)
        const CakePrice = 5000;
        const LootbagsPrice = 20;
    
        // Setup price
        const SetupPrice = 10000;
    
        // Discounted prices (if quantity is more than 1)
        const discountedVeggiePrice = 4750;
        const discountedBeefPrice = 8750;
        const discountedPorkPrice = 7750;
        const discountedChickenPrice = 7750;
        const discountedFishPrice = 7750;
    
        // Food Pack prices
        const foodPackPrices = {
            Pack1: 95, // Price for Food Pack 1
            Pack2: 105, // Price for Food Pack 2
            Pack3: 70, // Price for Food Pack 3
        };

        const lechonPrices = {
            lechon1: 15000, // Price for 25 kg Lechon
            lechon2: 18000, // Price for 30 kg Lechon
            lechon3: 25000, // Price for 45 kg Lechon
        };
    
        // Get references to input fields
        const veggieInput = document.getElementById('veggie');
        const beefInput = document.getElementById('beef');
        const porkInput = document.getElementById('pork');
        const chickenInput = document.getElementById('chicken');
        const fishInput = document.getElementById('fish');
        const iceCreamInput = document.getElementById('IceCream');
        const mixedBallsInput = document.getElementById('MixedBalls');
        const frenchFriesInput = document.getElementById('FrenchFries');
        const hotdogsInput = document.getElementById('Hotdogs');
        const cakeInput = document.getElementById('Cake');
        const lootbagsInput = document.getElementById('Lootbags');
        const setupInput = document.getElementById('Setup');
        const personsInput = document.getElementById('persons');
        const foodPackSelect = document.getElementById('foodPack');
        const foodPackQuantityInput = document.getElementById('foodPackQuantity');
        const lechonSelect = document.getElementById('lechonkg');
        const lechonQuantityInput = document.getElementById('lechonQuantity');
        const totalPriceElement = document.getElementById('totalPrice');
    
        // Function to calculate the total price
        function calculateTotal() {
            let total = 0;
    
            // Food prices based on input values
            const veggieCount = parseInt(veggieInput.value) || 0;
            total += veggieCount > 1 ? discountedVeggiePrice * veggieCount : baseVeggiePrice * veggieCount;
    
            const beefCount = parseInt(beefInput.value) || 0;
            total += beefCount > 1 ? discountedBeefPrice * beefCount : baseBeefPrice * beefCount;
    
            const porkCount = parseInt(porkInput.value) || 0;
            total += porkCount > 1 ? discountedPorkPrice * porkCount : basePorkPrice * porkCount;

            const fishCount = parseInt(fishInput.value) || 0;
            total += fishCount > 1 ? discountedFishPrice * fishCount : baseFishPrice * fishCount;
    
            const chickenCount = parseInt(chickenInput.value) || 0;
            total += chickenCount > 1 ? discountedChickenPrice * chickenCount : baseChickenPrice * chickenCount;
    
            // Food Pack calculation
            const selectedFoodPackId = foodPackSelect.selectedOptions[0].id; // Get the selected food pack ID
            const foodPackQuantity = parseInt(foodPackQuantityInput.value) || 0;
            if (foodPackPrices[selectedFoodPackId]) {
                total += foodPackPrices[selectedFoodPackId] * foodPackQuantity;
            }

            const selectedLechonId = lechonSelect.selectedOptions[0]?.id; // Get the selected Lechon ID
            const lechonQuantity = parseInt(lechonQuantityInput.value) || 0; // Get the quantity from input
            if (lechonQuantity > 0 && lechonPrices[selectedLechonId]) {
                total += lechonPrices[selectedLechonId] * lechonQuantity; // Add lechon price based on quantity
            }
    
            // Food Cart items calculation
            let foodCartTotal = 0;
            let foodCartCount = 0; // Count of selected food cart items
    
            if (iceCreamInput.checked) {
                foodCartTotal += IceCreamPrice;
                foodCartCount++;
            }
            if (mixedBallsInput.checked) {
                foodCartTotal += MixedBallsPrice;
                foodCartCount++;
            }
            if (frenchFriesInput.checked) {
                foodCartTotal += FrenchFriesPrice;
                foodCartCount++;
            }
            if (hotdogsInput.checked) {
                foodCartTotal += HotdogsPrice;
                foodCartCount++;
            }
    
            // Apply discount if three or more food cart items are selected
            if (foodCartCount >= 3) {
                foodCartTotal -= 1000; // Discount of 1000 for 3 or more items
            }
    
            total += foodCartTotal; // Add food cart total to the overall total
    
            // Add Ons
            if (cakeInput.checked) total += CakePrice;
            total += LootbagsPrice * (parseInt(lootbagsInput.value) || 0);
            if (setupInput.value === "Yes") total += SetupPrice;
    
            // Calculate total based on number of persons
            const persons = parseInt(personsInput.value) || 0;
            total *= (persons / 100); // Adjust total based on the number of persons
    
            // Display the total price
            totalPriceElement.textContent = `₱ ${total.toFixed(2)}`;
        }
    
        // Event listeners for input changes
        veggieInput.addEventListener('input', calculateTotal);
        beefInput.addEventListener('input', calculateTotal);
        porkInput.addEventListener('input', calculateTotal);
        chickenInput.addEventListener('input', calculateTotal);
        fishInput.addEventListener('input', calculateTotal);
        foodPackSelect.addEventListener('change', calculateTotal);
        foodPackQuantityInput.addEventListener('input', calculateTotal);
        lechonSelect.addEventListener('change', calculateTotal);
        lechonQuantityInput.addEventListener('input', calculateTotal);
        iceCreamInput.addEventListener('change', calculateTotal);
        mixedBallsInput.addEventListener('change', calculateTotal);
        frenchFriesInput.addEventListener('change', calculateTotal);
        hotdogsInput.addEventListener('change', calculateTotal);
        cakeInput.addEventListener('change', calculateTotal);
        lootbagsInput.addEventListener('input', calculateTotal);
        setupInput.addEventListener('change', calculateTotal);
        personsInput.addEventListener('input', calculateTotal);
    
        // Initial calculation on page load
        calculateTotal();
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