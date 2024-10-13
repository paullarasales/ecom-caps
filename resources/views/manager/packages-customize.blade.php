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
                                <div class="md:col-span-3">
                                    <label for="veggie">Veggie</label>
                                    <input type="number" name="veggie" id="veggie" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-3">
                                    <label for="chicken">Chicken/Fish</label>
                                    <input type="number" name="chicken" id="chicken" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-3">
                                    <label for="pork">Pork</label>
                                    <input type="number" name="pork" id="pork" value="0" min="0" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" />
                                </div>
                                <div class="md:col-span-3">
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
    
        // Food Cart discount
        const foodCartDiscount = 1000;
    
        // Get references to input fields
        const veggieInput = document.getElementById('veggie');
        const beefInput = document.getElementById('beef');
        const porkInput = document.getElementById('pork');
        const chickenInput = document.getElementById('chicken');
        const personsInput = document.getElementById('persons');
        const setupInput = document.getElementById('Setup');
    
        const IceCreamInput = document.getElementById('IceCream');
        const MixedBallsInput = document.getElementById('MixedBalls');
        const FrenchFriesInput = document.getElementById('FrenchFries');
        const HotdogsInput = document.getElementById('Hotdogs');
    
        const CakeInput = document.getElementById('Cake');
        const LootbagsInput = document.getElementById('Lootbags');
    
        const totalPriceDisplay = document.getElementById('totalPrice');
    
        // Function to calculate total price
        function calculateTotal() {
            const veggieQuantity = parseInt(veggieInput.value) || 0;
            const beefQuantity = parseInt(beefInput.value) || 0;
            const porkQuantity = parseInt(porkInput.value) || 0;
            const chickenQuantity = parseInt(chickenInput.value) || 0;
    
            // Food Cart add-ons (check if checked or get the value)
            const IceCreamChecked = IceCreamInput.checked;
            const MixedBallsChecked = MixedBallsInput.checked;
            const FrenchFriesChecked = FrenchFriesInput.checked;
            const HotdogsChecked = HotdogsInput.checked;
    
            const IceCreamTotal = IceCreamChecked ? IceCreamPrice : 0;
            const MixedBallsTotal = MixedBallsChecked ? MixedBallsPrice : 0;
            const FrenchFriesTotal = FrenchFriesChecked ? FrenchFriesPrice : 0;
            const HotdogsTotal = HotdogsChecked ? HotdogsPrice : 0;
    
            // Count the number of checked food cart items
            const checkedFoodCartItems = [IceCreamChecked, MixedBallsChecked, FrenchFriesChecked, HotdogsChecked].filter(checked => checked).length;
    
            // Apply discount if three or more items are selected
            let foodCartTotal = IceCreamTotal + MixedBallsTotal + FrenchFriesTotal + HotdogsTotal;
            if (checkedFoodCartItems >= 3) {
                foodCartTotal -= foodCartDiscount;
            }
    
            // Get the quantity for Add Ons
            const CakeChecked = CakeInput.checked;
            const CakeTotal = CakeChecked ? CakePrice : 0;
    
            const LootbagsQuantity = parseInt(LootbagsInput.value) || 0;
            const LootbagsTotal = LootbagsQuantity * LootbagsPrice;
    
            // Get number of persons (default 100)
            const numberOfPersons = parseInt(personsInput.value) || 100;
    
            // Determine prices based on quantity
            const veggiePrice = veggieQuantity > 1 ? discountedVeggiePrice : baseVeggiePrice;
            const beefPrice = beefQuantity > 1 ? discountedBeefPrice : baseBeefPrice;
            const porkPrice = porkQuantity > 1 ? discountedPorkPrice : basePorkPrice;
            const chickenPrice = chickenQuantity > 1 ? discountedChickenPrice : baseChickenPrice;
    
            // Calculate total for each dish
            const veggieTotal = veggieQuantity * veggiePrice;
            const beefTotal = beefQuantity * beefPrice;
            const porkTotal = porkQuantity * porkPrice;
            const chickenTotal = chickenQuantity * chickenPrice;
    
            // Calculate main food total for the selected number of persons
            const mainFoodTotal = (veggieTotal + beefTotal + porkTotal + chickenTotal) * (numberOfPersons / 100);
    
            // Determine setup cost
            const setupTotal = setupInput.value === "Yes" ? SetupPrice : 0;
    
            // Calculate final total by adding the food cart add-ons (with discount if applicable), Add Ons, and setup fee to the main food total
            const totalPrice = mainFoodTotal + foodCartTotal + CakeTotal + LootbagsTotal + setupTotal;
    
            // Update the total price display
            totalPriceDisplay.textContent = `₱ ${totalPrice.toFixed(2)}`;
        }
    
        // Add event listeners to inputs
        veggieInput.addEventListener('input', calculateTotal);
        beefInput.addEventListener('input', calculateTotal);
        porkInput.addEventListener('input', calculateTotal);
        chickenInput.addEventListener('input', calculateTotal);
        personsInput.addEventListener('input', calculateTotal);
        setupInput.addEventListener('change', calculateTotal);
        IceCreamInput.addEventListener('change', calculateTotal);
        MixedBallsInput.addEventListener('change', calculateTotal);
        FrenchFriesInput.addEventListener('change', calculateTotal);
        HotdogsInput.addEventListener('change', calculateTotal);
        CakeInput.addEventListener('change', calculateTotal);
        LootbagsInput.addEventListener('input', calculateTotal);
    
        // Perform initial calculation on page load
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