<x-admin-layout>

    <div class="absolute">
        <a href="{{route('adminpost')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Add <span class="text-yellow-600">Posts</span>
        </h3>

    </div>



<form action="/post" method="POST" enctype="multipart/form-data">
    @csrf
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
<div class="p-6 flex items-center justify-center">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Posting</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-5">
                                <label for="firstname">Description</label>
                                <textarea type="text" name="description" id="description" class="resize-none h-20 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1"  value="" ></textarea>
                                {{-- <script>
                                    document.getElementById("description").addEventListener("input", function() {
                                        if (this.value.length > 220) {
                                            this.value = this.value.slice(0, 220);
                                        }
                                    });
                                
                                    document.getElementById("description").addEventListener("change", function() {
                                        if (this.value.length < 220) {
                                            let remainingSpace = 220 - this.value.length;
                                            this.value += ' '.repeat(remainingSpace);
                                        }
                                    });
                                    </script> --}}
                            </div>

                            <div class="md:col-span-5">
                                <label for="age">Images</label>
                                <input type="file" name="images[]" id="images" class="h-10 border py-2 mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" accept="image/*" multiple onchange="limitFiles(this, 4)"/>
                                <script>
                                    function limitFiles(input, maxFiles) {
                                        if (input.files.length > maxFiles) {
                                            alert("You can only select a maximum of " + maxFiles + " files.");
                                            input.value = ''; // Clear the selected files
                                        }
                                    }
                                    </script>
                            </div>

                            <div class="md:col-span-5 text-right">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

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

</x-admin-layout>
    
