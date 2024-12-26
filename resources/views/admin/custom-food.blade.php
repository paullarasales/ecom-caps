<x-admin-layout>

    <div class="absolute">
        <a href="{{route('newcustomizepackage')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Manage <span class="text-yellow-600">Food Items</span>
        </h3>

    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            <span class="text-yellow-600">Main</span>
        </h3>

    </div>

    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mt-10">
    
    
        {{-- <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-indigo-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-indigo-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-eye"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">View Foods</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('customfood.view')}}">
                        <button type="button" class="border border-indigo-500 text-indigo-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-teal-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-teal-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-add"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Add Food</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('customfoodadd')}}">
                        <button type="button" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div> --}}

        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-stone-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-stone-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-cow"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Beef</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('custombeef')}}">
                        <button type="button" class="border border-stone-500 text-stone-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-stone-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-orange-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-orange-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-bacon"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Pork</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('custompork')}}">
                        <button type="button" class="border border-orange-500 text-orange-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-orange-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-red-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-red-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-drumstick-bite"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Chicken</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('customchicken')}}">
                        <button type="button" class="border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-lime-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-lime-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-carrot"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Veggie</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('customveggie')}}">
                        <button type="button" class="border border-lime-500 text-lime-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-lime-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-indigo-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-indigo-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-fish"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Fish</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('customother')}}">
                        <button type="button" class="border border-indigo-500 text-indigo-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
    </div>

    <hr class="my-5 border border-yellow-100">

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            <span class="text-yellow-600">Dessert</span>
        </h3>

    </div>

    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mt-10">
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-pink-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-pink-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-cookie"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Dessert</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('customdessert')}}">
                        <button type="button" class="border border-pink-500 text-pink-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-pink-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>

    </div>
    
        
    
    
    </div>
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
    </x-admin-layout>
    
