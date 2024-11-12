<x-admin-layout>


<div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mt-10">


    <div class="w-64 h-44">
        <div class="bg-white shadow-lg mx-auto border-b-4 border-blue-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
            <div class="bg-blue-500 flex h-20 items-center">
                <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                    <i class="fa-regular fa-calendar"></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Events Calendar</p>
            </div>
            
            <div class="flex justify-center px-5 mb-2 text-sm">
                <a href="{{ route('calendarView') }}">
                    <button type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                    Open
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div class="w-64 h-44">
        <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-indigo-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
            <div class="bg-indigo-500  flex h-20  items-center">
                <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                    <i class="fa-regular fa-calendar"></i></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Meeting Calendar</p>
            </div>
                
                                    <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <a href="{{route('meetingCalendarView')}}">
                        <button type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
            </div>
        </div>
    </div>

    <div class="w-64 h-44">
        <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-orange-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
            <div class="bg-orange-500  flex h-20  items-center">
                <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                    <i class="fa-regular fa-file"></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Direct</p>
            </div>
                
                                    <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <a href="{{route('direct')}}">
                        <button type="button" class="border border-orange-500 text-orange-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-orange-600 focus:outline-none focus:shadow-outline">
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
                    <i class="fa-regular fa-floppy-disk"></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Booked</p>
            </div>
            
            <div class="flex justify-center px-5 mb-2 text-sm">
                <a href="{{route('booked')}}">
                    <button type="button" class="border border-green-500 text-green-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Open
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div class="w-64 h-44">
        <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-yellow-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
            <div class="bg-yellow-500  flex h-20  items-center">
                <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                    <i class="fa-regular fa-clock"></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Pending</p>
            </div>
                
                                    <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <a href="{{route('pending')}}">
                        <button type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
            </div>
        </div>
    </div>

    

    

    <div class="w-64 h-44">
        <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-red-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
            <div class="bg-red-500  flex h-20  items-center">
                <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                    <i class="fa-solid fa-ban"></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Cancelled Event</p>
            </div>
                
                                    <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <a href="{{route('cancelled')}}">
                        <button type="button" class="border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
            </div>
        </div>
    </div>

    <div class="w-64 h-44">
        <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-rose-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
            <div class="bg-rose-500  flex h-20  items-center">
                <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                    <i class="fa-solid fa-ban"></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Cancelled Meeting</p>
            </div>
                
                                    <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <a href="{{route('cancelledMeeting')}}">
                        <button type="button" class="border border-rose-500 text-rose-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-rose-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
            </div>
        </div>
    </div>

    <div class="w-64 h-44">
        <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-teal-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
            <div class="bg-teal-500  flex h-20  items-center">
                <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                    <i class="fa-solid fa-check"></i>
                </h1>
                <p class="ml-4 text-white uppercase font-semibold">Done</p>
            </div>
                
                                    <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <a href="{{route('done')}}">
                        <button type="button" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
            </div>
        </div>
    </div>


</div>

</x-admin-layout>
