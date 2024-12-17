<x-owner-layout>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Manage <span class="text-yellow-600">Packages</span>
        </h3>

    </div>

    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mt-10">
    
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-yellow-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-yellow-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-cube"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">View Packages</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('ownerviewpackage')}}">
                        <button type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-green-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-green-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-plus"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Add Package Type</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('owneraddpackage')}}">
                        <button type="button" class="border border-green-500 text-green-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline">
                            Continue
                        </button>
                    </a>
                </div>
            </div>
        </div>

        {{-- <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-teal-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-teal-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-wrench"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Customize</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('customizepackage')}}">
                        <button type="button" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div> --}}

        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-orange-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-orange-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-wrench"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Customize</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('owner.newcustomizepackage')}}">
                        <button type="button" class="border border-orange-500 text-orange-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-orange-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        
    
    
    </div>
    
    </x-owner-layout>
    

