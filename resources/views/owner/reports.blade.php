<x-owner-layout>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Event <span class="text-yellow-600">Reports</span>
        </h3>

    </div>


    <div class="flex flex-col items-center md:flex-row justify-center flex-wrap gap-3 mt-10">
    
        <div class="w-64 h-44">
            <div class="bg-white shadow-lg mx-auto border-b-4 border-green-500 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer">
                <div class="bg-green-500 flex h-20 items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-regular fa-floppy-disk"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Booked</p>
                </div>
                
                <div class="flex justify-center px-5 mb-2 text-sm">
                    <button type="button" onclick="openFormModal()" class="border border-green-500 text-green-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Open Form
                    </button>
                </div>
            </div>
        </div>
        
        <script>
            function openFormModal() {
                Swal.fire({
                    title: 'Select Month',
                    html: `
                        <h1>Booked events per month</h1>
                        <form id="bookedForm" action="{{ route('reports.booked.month') }}" method="POST">
                            @csrf
                            <input type="month" id="month" name="month" required class="swal2-input">
                            <button type="submit" class="swal2-confirm swal2-styled bg-yellow-400">Download Report</button>
                        </form>
                    `,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    cancelButtonColor: '#d33'
                });
            }
        </script>
        
    
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
                    <button type="button" onclick="openFormPendingModal()" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                        Open Form
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openFormPendingModal() {
                Swal.fire({
                    title: 'Select Month',
                    html: `
                        <h1>Pending appointments per month</h1>
                        <form id="bookedForm" action="{{ route('reports.pending.month') }}" method="POST">
                            @csrf
                            <input type="month" id="month" name="month" required class="swal2-input">
                            <button type="submit" class="swal2-confirm swal2-styled bg-yellow-400">Download Report</button>
                        </form>
                    `,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    cancelButtonColor: '#d33'
                });
            }
        </script>
    
        <div class="w-64 h-44">
            <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-teal-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
                <div class="bg-teal-500  flex h-20  items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-check"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Completed</p>
                </div>
                    
                                        <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <button type="button" onclick="openFormDoneModal()" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                        Open Form
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openFormDoneModal() {
                Swal.fire({
                    title: 'Select Month',
                    html: `
                        <h1>Completed events per month</h1>
                        <form id="bookedForm" action="{{ route('reports.done.month') }}" method="POST">
                            @csrf
                            <input type="month" id="month" name="month" required class="swal2-input">
                            <button type="submit" class="swal2-confirm swal2-styled bg-yellow-400">Download Report</button>
                        </form>
                    `,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    cancelButtonColor: '#d33'
                });
            }
        </script>
    
        
    
        <div class="w-64 h-44">
            <div class="bg-white max-w-xs shadow-lg   mx-auto border-b-4 border-red-500 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover:scale-105 cursor-pointer" >
                <div class="bg-red-500  flex h-20  items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full">
                        <i class="fa-solid fa-ban"></i>
                    </h1>
                    <p class="ml-4 text-white uppercase font-semibold">Cancelled</p>
                </div>
                    
                                        <!-- <hr > -->
                <div class="flex justify-center px-5 mb-2 text-sm ">
                    <button type="button" onclick="openFormCancelledModal()" class="border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">
                        Open Form
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openFormCancelledModal() {
                Swal.fire({
                    title: 'Select Month',
                    html: `
                        <h1>Cancelled events per month</h1>
                        <form id="bookedForm" action="{{ route('reports.cancelled.month') }}" method="POST">
                            @csrf
                            <input type="month" id="month" name="month" required class="swal2-input">
                            <button type="submit" class="swal2-confirm swal2-styled bg-yellow-400">Download Report</button>
                        </form>
                    `,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    cancelButtonColor: '#d33'
                });
            }
        </script>
    
    
        
    
    
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
    