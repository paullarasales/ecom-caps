<x-admin-layout>

    <div class="flex ml-3">
        <a href="{{route('pending')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Pending <span class="text-yellow-600">Request</span>
        </h3>

    </div>

    <div class="flex justify-center items-center  uppercase">
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
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl my-5">Event Type:</h2>
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
                    <div class="flex justify-end">
                        <form action="{{  route('appointment.accept', $appointment->appointment_id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" name="status" value="{{$appointment->status}}">
                            <input type="submit" name="submit" value="Accept" class="inline-flex items-center cursor-pointer px-2 py-2 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800"></input>
                        </form>
                        <a href="" class="inline-flex capitalize ml-4 items-center px-2 py-2 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Chat
                            <i class="fa-solid fa-message ml-3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    {{-- <h1>{{ $appointment->user->firstname }}</h1>
    <h1>{{ $appointment->location }}</h1> --}}

</x-admin-layout>