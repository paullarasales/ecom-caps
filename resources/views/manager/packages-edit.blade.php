<x-manager-layout>

    <div class="absolute">
        <a href="{{route('managershowpackage', $package->package_id)}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Package</span>
        </h3>

    </div>

    
    <form action="{{ route('managerupdatepackage', $package->package_id) }}" method="POST" enctype="multipart/form-data">
        @method("PUT")
        @csrf
    <div class="my-10 p-2 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <div>
                <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Edit Package</p>
                                <p>Please fill out all the fields.</p>
                            </div>
    
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5">
                                    <label for="firstname">Package Name</label>
                                    <input type="text" name="packagename" id="packagename" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{$package->packagename}}" />
                                </div>
    
                                <div class="md:col-span-5">
                                    <label for="lastname">Package Description</label>
                                    <input type="text" name="packagedesc" id="packagedesc" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{$package->packagedesc}}" />
                                </div>
    
                                <div class="md:col-span-5">
                                    <label for="address">Package Photo</label>
                                    <input id="packagephoto" name="packagephoto" type="file" accept=".png, .jpg, .jpeg" class="mt-1 block w-full items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" value="{{$package->packagephoto}}" />
                                </div>

                                {{-- <br>
                                <div class="flex items-center md:col-span-5">
                                    <input id="link-checkbox" required type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="link-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">I agree with the <a href="#" class="text-gray-800 dark:text-blue-500 hover:underline" id="terms-link">terms and conditions</a>.</label>
                                </div> --}}

                                <div class="md:col-span-5 text-right">
                                    <input type="submit" name="submit" value="Update" class="cursor-pointer bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div id="terms-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Terms and Conditions
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <!-- Add your terms and conditions content here -->
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="close-modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("terms-modal");

        // Get the button that opens the modal
        var btn = document.getElementById("terms-link");

        // Get the element that closes the modal
        var closeModal = document.getElementById("close-modal");

        // When the user clicks the button, open the modal 
        btn.onclick = function(event) {
            event.preventDefault();
            modal.classList.remove("hidden");
        }

        // When the user clicks on <span> (x), close the modal
        closeModal.onclick = function() {
            modal.classList.add("hidden");
        }
    </script>

<script type="text/javascript">
    var msg='{{Session::get('alert')}}';
    var exist='{{Session::has('alert')}}';

    if(exist)
    {
        alert(msg);
    }
</script>
</x-manager-layout>