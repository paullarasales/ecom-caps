<x-owner-layout>

    <div class="absolute">
        <a href="{{route('owner.custompork.view')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Pork Item</span>
        </h3>

    </div>

    
    <form action="{{route('owner.custompork.update', $food->pork_id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <script>
            // Check if there are validation errors
            var errors = @json($errors->any()); // Check if there are any errors
            var errorMessages = @json($errors->all()); // Get the array of error messages
        
            // Show SweetAlert with validation errors if there are any
            if (errors) {
                Swal.fire({
                    title: 'Validation Errors',
                    icon: 'error',
                    html: `
                        <ul style="text-align: center; color: #E07B39;">
                            ${errorMessages.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    `,
                    confirmButtonText: 'Close',
                    customClass: {
                        popup: 'custom-popup-error',
                        title: 'custom-title-error',
                        confirmButton: 'custom-button-error'
                    }
                });
            }
        </script>
        
        <style>
            /* SweetAlert Error Popup Customization */
            .custom-popup-error {
                background-color: #FDEDEC; /* Light red background */
                border: 2px solid #E07B39; /* Red border */
            }
            .custom-title-error {
                color: #E07B39; /* Red title text */
                font-weight: bold;
            }
            .custom-button-error {
                background-color: #E07B39 !important; /* Red button background */
                color: white !important; /* White button text */
                border-radius: 5px;
            }
            .custom-button-error:hover {
                background-color: #C0392B !important; /* Darker red on hover */
            }
        </style>
    <div class="my-10 p-2 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <div>
                <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Edit Pork Item</p>
                                <p>Please fill out all the fields.</p>
                            </div>
    
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                                <div class="md:col-span-2">
                                    <label for="porkname">Pork Name</label>
                                    <input type="text" name="porkname" id="porkname" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{$food->porkname}}" />
                                </div>
    
                                <div class="md:col-span-2">
                                    <label for="porkprice">Price</label>
                                    <input type="text" name="prokprice" id="porkprice" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" value="{{$food->prokprice}}" />
                                </div>

                                <div class="md:col-span-5 text-right">
                                    <input type="submit" name="submit" value="Submit" class="cursor-pointer bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
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


    @if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
            popup: 'custom-popup',
            title: 'custom-title',
            confirmButton: 'custom-button'
        }
        });
    </script>
    @endif
    
    @if (session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'custom-popup-error',
                title: 'custom-title-error',
                confirmButton: 'custom-button-error'
            }
        });
    </script>
    @endif
    
    <style>
    /* Success Alert Button */
    .custom-button {
            background-color: #FFCF81 !important; /* Orange button background */
            color: white !important; /* White button text */
            border-radius: 5px;
        }
        .custom-button:hover {
            background-color: #E07B39 !important; /* Darker orange on hover */
        }
    
        /* Error Alert Button */
        .custom-button-error {
            background-color: #E07B39 !important; /* Red button background */
            color: white !important; /* White button text */
            border-radius: 5px;
        }
        .custom-button-error:hover {
            background-color: #C0392B !important; /* Darker red on hover */
        }
    
        /* Customize Popup Background for Error */
        .custom-popup-error {
            background-color: #FDEDEC; /* Light red background */
            border: 2px solid #E07B39; /* Red border */
        }
    
        /* Customize Title for Error */
        .custom-title-error {
            color: #E07B39; /* Red text for title */
            font-weight: bold;
        }
    </style>
</x-owner-layout>