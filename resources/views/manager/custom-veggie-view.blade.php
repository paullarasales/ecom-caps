<x-manager-layout>
    <div class="absolute">
        <a href="{{route('manager.customveggie')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Custom <span class="text-yellow-600">Veggie Items</span>
        </h3>

    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2 p-4">
    

        @foreach ($foods as $food)
        
        <div class="max-w-[12rem] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#" class="block w-full relative pb-[100%] overflow-hidden rounded-t-lg">
                <img class="absolute top-0 left-0 w-full h-full object-cover" src="{{ asset('images/custom.jpg') }}"  />
            </a>
            <div class="p-3">
                <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-white">{{ $food->veggiename }}</h5>
                <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-white">₱ {{ $food->veggieprice }}</h5>

                <div class="flex justify-start gap-2">
                    <a href="{{route('manager.customveggie.edit', $food->veggie_id)}}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Edit
                        {{-- <i class="fa-solid fa-arrow-right ml-3"></i> --}}
                    </a>
                    <a href="{{route('manager.customveggie.destroy', $food->veggie_id)}}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Delete
                        {{-- <i class="fa-solid fa-arrow-right ml-3"></i> --}}
                    </a>
                </div>
            </div>
        </div>
        
        
        @endforeach
        
        </div>

        <div class="py-4 px-4">
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-900 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                    Showing <span class="font-semibold text-gray-900 ">{{ $foods->firstItem() }}</span> to 
                    <span class="font-semibold text-gray-900 ">{{ $foods->lastItem() }}</span> of 
                    <span class="font-semibold text-gray-900 ">{{ $foods->total() }}</span> results
                </span>
        
                <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                    {{-- Previous Page Link --}}
                    @if ($foods->onFirstPage())
                        <li>
                            <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                                Previous
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $foods->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                Previous
                            </a>
                        </li>
                    @endif
        
                    {{-- Pagination Elements --}}
                    @foreach ($foods->getUrlRange(1, $foods->lastPage()) as $page => $url)
                        @if ($page == $foods->currentPage())
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 dark:bg-gray-700 dark:text-white">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
        
                    {{-- Next Page Link --}}
                    @if ($foods->hasMorePages())
                        <li>
                            <a href="{{ $foods->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                </ul>
            </nav>
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
</x-manager-layout>