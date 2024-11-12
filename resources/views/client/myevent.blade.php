<x-app-layout>
    <div class="text-center py-4 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            My <span class="text-yellow-600">Events</span>
        </h3>
    </div>

    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 lg:gap-5 mt-10">
    
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-yellow-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-yellow-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-regular fa-clock"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Requests</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('myrequest')}}">
                        <button type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-yellow-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-yellow-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-regular fa-bookmark"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Booked</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('mybooked')}}">
                        <button type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-yellow-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-yellow-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-check-double"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Done</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('mydone')}}">
                        <button type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        
    
    
    </div>
</x-app-layout>