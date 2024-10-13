<x-admin-layout>

    <div class="flex ml-3">
        <a href="{{route('cancelled')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Cancelled <span class="text-yellow-600">Event</span>
        </h3>

    </div>


    <div class="flex justify-center items-center uppercase">
        <div class="bg-gray-700 text-gray-100 flex flex-col lg:flex-row lg:w-5/6 md:w-full sm:w-full justify-between px-10 py-10 lg:py-10 rounded-2xl">
            {{-- personal --}}
            <div class="bg-gray-200 text-gray-700 py-5 px-5 lg:flex-1 rounded-lg">
                <h2 class="text-xl sm:text-3xl md:text-4xl lg:text-4xl uppercase my-5 font-bold">
                    {{$appointment->user->firstname. ' '. $appointment->user->lastname}}
                </h2>
                <hr class="border-gray-700">
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">Age: </span>
                    {{ \Carbon\Carbon::parse($appointment->user->birthday)->age }}
                </h4>
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">Phone Number: </span>{{$appointment->user->phone}}
                </h4>
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">Street/Barangay: </span>{{$appointment->user->address}}
                </h4>
                <h4 class="text-lg sm:text-xl md:text-2xl lg:text-2xl my-5 font-extrabold">
                    <span class="font-normal mr-2">City: </span>{{$appointment->user->city}}
                </h4>
            </div>
            {{-- event --}}
            <div class="py-5 px-5 lg:flex-1 flex justify-between">
                <div>
                    <h2 class="text-xl sm:text-3xl md:text-4xl lg:text-4xl uppercase">Date:</h2>
                    <br>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Time:</h2>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Location:</h2>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Event:</h2>
                    {{-- <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Event Theme:</h2> --}}
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Package:</h2>
                </div>
                <div class="text-right">
                    <h2 class="text-xl sm:text-3xl md:text-4xl lg:text-4xl uppercase">{{$appointment->edate}}</h2>
                    <br>
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{$appointment->etime}}</h4>
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{$appointment->location}}</h4>
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{$appointment->type}}</h4>
                    {{-- <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{$appointment->theme}}</h4> --}}
                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">{{ $appointment->package->packagename }}</h4>
                    <div class="flex justify-end gap-3 capitalize">
                        <form action="{{  route('appointment.rebook', $appointment->appointment_id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" name="status" value="{{$appointment->status}}">
                            <button type="submit" name="submit" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Re-book
                                <i class="fa-solid fa-check ml-3"></i>
                            </button>                        
                        </form>
                        <a href="{{ route('details.edit', $appointment->appointment_id) }}" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Edit
                            <i class="fa-regular fa-pen-to-square ml-3"></i>
                        </a>
                        {{-- <form action="{{  route('appointment.cancel', $appointment->appointment_id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" name="status" value="{{$appointment->status}}">
                            <button type="submit" name="submit" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                Cancel
                                <i class="fa-solid fa-ban ml-3"></i>
                            </button> 
                        </form> --}}
                        {{-- <a href="" class="inline-flex capitalize  items-center px-2 py-2 text-xs sm:text-sm md:text-base font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Chat
                            <i class="fa-solid fa-message ml-3"></i>
                        </a> --}}
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

    {{-- <h1>{{ $appointment->user->firstname }}</h1>
    <h1>{{ $appointment->location }}</h1> --}}

</x-admin-layout>