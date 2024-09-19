<x-admin-layout>

    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mt-10">
    
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-yellow-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-yellow-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-regular fa-credit-card"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Post</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('adminpost')}}">
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
                        <i class="fa-solid fa-question"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Faqs</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <a href="{{route('adminfaqs')}}">
                        <button type="button" class="border border-green-500 text-green-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline">
                            Open
                        </button>
                    </a>
                </div>
            </div>
        </div>
    
        
    
    
    </div>
    

    {{-- <label for="appointment_date">Select a Date:</label>
    <input type="date" id="appointment_date" name="appointment_date" required>

    <!-- Time Input (using 30-minute intervals from 9 AM to 6 PM) -->
    <label for="appointment_time">Select a Time:</label>
    <select id="appointment_time" name="appointment_time" required>
        @for ($hour = 9; $hour <= 17; $hour++)
            @for ($minute = 0; $minute <= 30; $minute += 30)
                @php
                    $time = sprintf('%02d:%02d', $hour, $minute);
                    $formatted_time = \Carbon\Carbon::createFromFormat('H:i', $time)->format('h:i A');
                @endphp
                <option value="{{ $time }}">{{ $formatted_time }}</option>
            @endfor
        @endfor
        <!-- Adding the 6:00 PM option -->
        <option value="18:00">06:00 PM</option>
    </select> --}}
    
    </x-admin-layout>
    
