<x-admin-layout>
    
    <div class="absolute">
        <a href="{{route('adminpackages')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Package <span class="text-yellow-600">Customization</span>
        </h3>
    </div>

    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-1 gap-6 rounded shadow-lg shadow-yellow-100 p-4 px-4">
            <!-- List of customizable items -->
            <div class="flex justify-between">
                <div class="grid grid-cols-1 gap-4">
                    <h1 class="text-2xl">Food</h1>
                    <div>
                        <label for="veggie" class="block font-semibold">Veggie</label>
                        <input type="number" id="veggie" name="veggie" value="0" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="chicken" class="block font-semibold">Chicken/Fish</label>
                        <input type="number" id="chicken" name="chicken" value="0" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="pork" class="block font-semibold">Pork</label>
                        <input type="number" id="pork" name="pork" value="0" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="beef" class="block font-semibold">Beef</label>
                        <input type="number" id="beef" name="beef" value="0" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                </div>
    
                <div class="grid grid-cols-1 gap-4">
                    <h1 class="text-2xl">Food Cart</h1>
                    <div>
                        <label for="IceCream" class="block font-semibold">Ice Cream</label>
                        <input type="checkbox" id="IceCream" name="IceCream" class="form-checkbox h-5 w-5 text-yellow-500 focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="FrenchFries" class="block font-semibold">French Fries</label>
                        <input type="checkbox" id="FrenchFries" name="FrenchFries" class="form-checkbox h-5 w-5 text-yellow-500 focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="MixedBalls" class="block font-semibold">Mixed Balls</label>
                        <input type="checkbox" id="MixedBalls" name="MixedBalls" class="form-checkbox h-5 w-5 text-yellow-500 focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="Hotdogs" class="block font-semibold">Hotdogs</label>
                        <input type="checkbox" id="Hotdogs" name="Hotdogs" class="form-checkbox h-5 w-5 text-yellow-500 focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <h1 class="text-2xl">Add Ons</h1>
                    <div>
                        <label for="IceCream" class="block font-semibold">Cake</label>
                        <input type="checkbox" id="Cake" name="Cake" class="form-checkbox h-5 w-5 text-yellow-500 focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="beef" class="block font-semibold">Lootbags</label>
                        <input type="number" id="Lootbags" name="Lootbags" value="0" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
    
            <!-- Number of persons selection -->
            <div class="col-span-2">
                <div>
                    <label for="setup" class="block font-semibold">With Styling?</label>
                    <select type="number" id="Setup" name="Setup" value="100" min="1" class="w-full my-2 border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option disabled selected></option>
                </div>
                <div>
                    <label for="persons" class="block font-semibold">Number of Persons</label>
                    <input type="number" id="persons" name="persons" value="100" min="1" class="w-full my-2 border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                </div>
            </div>
    
            <!-- Total calculation -->
            <div class="col-span-2">
                <div class="bg-gray-100 rounded-md p-4 text-center">
                    <h4 class="text-xl font-semibold">Total</h4>
                    <p id="totalPrice" class="text-3xl font-bold text-yellow-600">₱ 0.00</p>
                </div>
            </div>
        </div>
    </div>
    
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
    
    
    
    
    





</x-admin-layout>