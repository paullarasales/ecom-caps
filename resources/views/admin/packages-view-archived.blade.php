<x-admin-layout>
    
    <div class="absolute">
        <a href="{{route('viewpackage')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Archived <span class="text-yellow-600">Packages</span>
        </h3>

    </div>

<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4">
    

@foreach ($package as $pk)

<div class="max-w-[12rem] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-200 dark:border-gray-700">

    <div class="p-3">
        {{-- <a href="#">
            <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-gray-700">{{ $pk->packagename }}</h5>
        </a> --}}

        @if ($pk->appointment->isNotEmpty())
                                    <div class="text-sm text-gray-600">
                                        <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-gray-700">{{ $pk->appointment->first()->user->firstname }} {{ $pk->appointment->first()->user->lastname }}</h5>
                                        <h5 class="mb-2 text-md uppercase tracking-tight text-gray-900 dark:text-gray-700">{{ \Carbon\Carbon::parse($pk->appointment->first()->edate)->format('F j, Y') }}</h5>
                                    </div>
                                @else
                                    <a href="#">
                                        <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-gray-700">{{ $pk->packagename }}</h5>
                                    </a>
                                @endif
        
        <a href="{{ route('showpackage', $pk->package_id) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
            Read more
            <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
        </a>
    </div>
</div>



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

@endforeach



</div>

{{-- <a href="">
    <div class="text-center">

        <h2 class="font-heading mb-4 bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-80 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                    See archived packages
                    <i class="fa-solid fa-arrow-right ml-3"></i>
        </h2>

    </div>
</a> --}}

<div class="py-4 px-4">
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-900 mb-4 md:mb-0 block w-full md:inline md:w-auto">
            Showing <span class="font-semibold text-gray-900 ">{{ $package->firstItem() }}</span> to 
            <span class="font-semibold text-gray-900 ">{{ $package->lastItem() }}</span> of 
            <span class="font-semibold text-gray-900 ">{{ $package->total() }}</span> results
        </span>

        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            {{-- First Page Link --}}
            @if ($package->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        First
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $package->url(1) }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        First
                    </a>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($package->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        Previous
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $package->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Previous
                    </a>
                </li>
            @endif

            {{-- Sliding Window Pagination --}}
            @php
                $currentPage = $package->currentPage();
                $lastPage = $package->lastPage();
                $startPage = max(1, $currentPage - 2);
                $endPage = min($lastPage, $currentPage + 2);

                if ($currentPage <= 3) {
                    $startPage = 1;
                    $endPage = min(5, $lastPage);
                }

                if ($currentPage > $lastPage - 3) {
                    $startPage = max(1, $lastPage - 4);
                    $endPage = $lastPage;
                }
            @endphp

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page == $currentPage)
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 dark:bg-gray-700 dark:text-white">
                            {{ $page }}
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $package->url($page) }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($package->hasMorePages())
                <li>
                    <a href="{{ $package->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Next
                    </a>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        Next
                    </span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($package->hasMorePages())
                <li>
                    <a href="{{ $package->url($package->lastPage()) }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Last
                    </a>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        Last
                    </span>
                </li>
            @endif
        </ul>
    </nav>
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

{{-- @if (session('success'))
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
    <style>
    .custom-button {
        background-color: #FFCF81 !important; /* Blue button background */
        color: white !important; /* White button text */
        border-radius: 5px;
    }
    .custom-button:hover {
        background-color: #E07B39 !important; /* Darker blue on hover */
    }
</style> --}}

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