<x-admin-layout>

<form action="{{ route('directsave') }}" method="POST">
    @csrf
<div class="min-h-screen p-6 flex items-center justify-center">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                    <div class="text-gray-600">
                        <p class="font-medium text-lg">Personal Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>

                <div class="lg:col-span-2">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-3">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="age">Birthday</label>
                            <input type="date" name="birthday" id="birthday" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" min="18" value="" />
                        </div>

                        <div class="md:col-span-3">
                            <label for="email">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                        </div>

                        <div class="md:col-span-3">
                            <label for="address">Home Address / Street</label>
                            <input type="text" name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="city">City</label>
                            {{-- <input type="text" name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                            <select name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                <option selected disabled></option>
                                <option value="Agno" >Agno</option>
                                <option value="Aguilar" >Aguilar</option>
                                <option value="Alaminos City" >Alaminos City</option>
                                <option value="Alcala" >Alcala</option>
                                <option value="Anda" >Anda</option>
                                <option value="Asingan" >Asingan</option>
                                <option value="Balungao" >Balungao</option>
                                <option value="Bani" >Bani</option>
                                <option value="Basista" >Basista</option>
                                <option value="Bautista" >Bautista</option>
                                <option value="Bayambang" >Bayambang</option>
                                <option value="Binalonan" >Binalonan</option>
                                <option value="Binmaley" >Binmaley</option>
                                <option value="Bolinao" >Bolinao</option>
                                <option value="Bugallon" >Bugallon</option>
                                <option value="Burgos" >Burgos</option>
                                <option value="Calasiao" >Calasiao</option>
                                <option value="Dasol" >Dasol</option>
                                <option value="Dagupan City" >Dagupan City</option>
                                <option value="Infanta" >Infanta</option>
                                <option value="Labrador" >Labrador</option>
                                <option value="Laoac" >Laoac</option>
                                <option value="Lingayen" >Lingayen</option>
                                <option value="Mabini" >Mabini</option>
                                <option value="Malasiqui" >Malasiqui</option>
                                <option value="Manaoag" >Manaoag</option>
                                <option value="Mangaldan" >Mangaldan</option>
                                <option value="Mangatarem" >Mangatarem</option>
                                <option value="Mapandan" >Mapandan</option>
                                <option value="Natividad" >Natividad</option>
                                <option value="Pozorrubio" >Pozorrubio</option>
                                <option value="Rosales" >Rosales</option>
                                <option value="San Carlos City" >San Carlos City</option>
                                <option value="San Fabian" >San Fabian</option>
                                <option value="San Jacinto" >San Jacinto</option>
                                <option value="San Manuel" >San Manuel</option>
                                <option value="San Nicolas" >San Nicolas</option>
                                <option value="San Quintin" >San Quintin</option>
                                <option value="Santa Barbara" >Santa Barbara</option>
                                <option value="Santa Maria" >Santa Maria</option>
                                <option value="Santo Tomas" >Santo Tomas</option>
                                <option value="Sison" >Sison</option>
                                <option value="Sual" >Sual</option>
                                <option value="Tayug" >Tayug</option>
                                <option value="Umingan" >Umingan</option>
                                <option value="Urdaneta City" >Urdaneta City</option>
                                <option value="Urbiztondo" >Urbiztondo</option>
                                <option value="Villasis" >Villasis</option>
                            </select>                            
                        </div>
                    </div>
                </div>
            </div>
            <br>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Event Details</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                            
                            <div class="md:col-span-5">
                                <label for="firstname">Event Locaton</label>
                                <input type="text" name="location" id="location" placeholder="N/A if still" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                            </div>

                            <div class="md:col-span-3">
                                <label for="date">Event Date</label>
                                <input type="date" name="edate" id="edate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                            </div>
                            <script>
                                var today = new Date();
                                var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 9);
                                var minDateString = minDate.toISOString().split('T')[0];
                                document.getElementById("edate").setAttribute('min', minDateString);
                            </script>

                            <div class="md:col-span-2">
                                <label for="time">Event Time</label>
                                {{-- <input type="time" name="time" id="time" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                <select name="etime" id="etime" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option value="8:00 am">8:00 am</option>
                                    <option value="8:30 am">8:30 am</option>
                                    <option value="9:00 am">9:00 am</option>
                                    <option value="9:30 am">9:30 am</option>
                                    <option value="10:00 am">10:00 am</option>
                                    <option value="10:30 am">10:30 am</option>
                                    <option value="11:00 am">11:00 am</option>
                                    <option value="11:30 am">11:30 am</option>
                                    <option value="12:00 pm">12:00 pm</option>
                                    <option value="12:30 pm">12:30 pm</option>
                                    <option value="1:00 pm">1:00 pm</option>
                                    <option value="1:30 pm">1:30 pm</option>
                                    <option value="2:00 pm">2:00 pm</option>
                                    <option value="2:30 pm">2:30 pm</option>
                                    <option value="3:00 pm">3:00 pm</option>
                                    <option value="3:30 pm">3:30 pm</option>
                                    <option value="4:00 pm">4:00 pm</option>
                                    <option value="4:30 pm">4:30 pm</option>
                                    <option value="5:00 pm">5:00 pm</option>
                                    <option value="5:30 pm">5:30 pm</option>
                                    <option value="6:00 pm">6:00 pm</option>
                                    <option value="6:30 pm">6:30 pm</option>
                                    <option value="7:00 pm">7:00 pm</option>
                                    <option value="7:30 pm">7:30 pm</option>
                                    <option disabled selected></option>
                                </select>
                            </div>

                            <div class="md:col-span-5">
                                <label for="email">Event Type</label>
                                <input type="text" name="type" id="type" placeholder="(Ex. 1st Birthday)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="city">Package</label>
                                {{-- <input type="text" name="package" id="package" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" /> --}}
                                <select name="package_id" id="" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    
                                    @foreach ($packages as $pk)
                                    <option value="{{$pk->package_id}}">{{$pk->packagename}}</option>
                                    
                                    @endforeach
                                    <option disabled selected>See the packages below</option>
                                    
                                </select>
                                
                                
                                
                            </div>

                            <div class="md:col-span-5">
                                <label for="package" class="uppercase bg-yellow-100 my-10 rounded-xl py-1 px-2">Available Packages</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4"> <!-- Grid layout for images -->
                                    @foreach ($packages as $pk)
                                        <a href="#" class="block relative w-[115px] h-[180px] overflow-hidden rounded-lg mx-auto transition-transform duration-300 transform  hover:scale-105">
                                            @if ($pk->packagephoto)
                                            <p class="uppercase">{{$pk->packagename}}</p>
                                                <img class="w-full h-full object-cover" src="{{ asset($pk->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($pk->packagephoto) }}')" />
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            
                            
                            <div class="md:col-span-5 text-right">
                                <hr class="my-5 border-yellow-100">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div>

                            {{-- @foreach ($packages as $pk)
                                <h1>{{$pk->packagename}}</h1>
                            @endforeach --}}

                        </div>
                    </div>
                </div>

                {{-- <hr class="my-5 border-yellow-100">

                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                    <div class="text-gray-600">
                        <p class="font-medium text-lg">Meeting Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                            <div class="md:col-span-3">
                                <label for="date">Meeting Date</label>
                                <input type="date" name="adate" id="adate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="" />
                            </div>
                            <script>
                                var today = new Date();
                                var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 4);
                                var minDateString = minDate.toISOString().split('T')[0];
                                document.getElementById("adate").setAttribute('min', minDateString);
                            </script>

                            <div class="md:col-span-2">
                                <label for="time">Meeting Time</label>
                                <select name="atime" id="atime" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">
                                    <option value="10:00 am">10:00 am</option>
                                    <option value="10:30 am">10:30 am</option>
                                    <option value="11:00 am">11:00 am</option>
                                    <option value="11:30 am">11:30 am</option>
                                    <option value="12:00 pm">12:00 pm</option>
                                    <option value="12:30 pm">12:30 pm</option>
                                    <option value="1:00 pm">1:00 pm</option>
                                    <option value="1:30 pm">1:30 pm</option>
                                    <option value="2:00 pm">2:00 pm</option>
                                    <option value="2:30 pm">2:30 pm</option>
                                    <option value="3:00 pm">3:00 pm</option>
                                    <option value="3:30 pm">3:30 pm</option>
                                    <option value="4:00 pm">4:00 pm</option>
                                    <option value="4:30 pm">4:30 pm</option>
                                    <option value="5:00 pm">5:00 pm</option>
                                    <option value="5:30 pm">5:30 pm</option>
                                    <option value="6:00 pm">6:00 pm</option>
                                    <option disabled selected></option>
                                </select>
                            </div>

                            <div class="md:col-span-5 text-right">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div>

                        </div>
                    </div>
                </div> --}}

                
            </div>
        </div>
    </div>
</div>
</form>

<div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="relative max-w-sm max-h-[75vh] bg-white  rounded-lg shadow-lg">
            <button class="absolute top-0 right-0 m-4 text-white" onclick="closeModal()">
                <i class="fa-solid text-black fa-xmark text-3xl"></i>
            </button>
            <div id="modal-content" class="border rounded-lg border-gray-700"></div>
        </div>
    </div>
</div>


</div>
<script>
    function openModal(imageSrc) {
        var modal = document.getElementById('modal');
        var modalContent = document.getElementById('modal-content');
        modalContent.innerHTML = '<img src="' + imageSrc + '" class="max-w-full max-h-full rounded-lg">';
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Close modal when clicked anywhere outside of the modal content
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    function closeModal() {
        var modal = document.getElementById('modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
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

</x-admin-layout>