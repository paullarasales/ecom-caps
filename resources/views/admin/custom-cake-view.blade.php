<x-admin-layout>
    <div class="absolute">
        <a href="{{route('customcake')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Custom <span class="text-yellow-600">Cake Items</span>
        </h3>

    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2 p-4">
    

        @foreach ($foods as $food)
        
        <div class="max-w-[12rem] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#" class="block w-full relative pb-[100%] overflow-hidden rounded-t-lg">
                <img class="absolute top-0 left-0 w-full h-full object-cover" src="{{ asset('images/custom.jpg') }}"  />
            </a>
            <div class="p-3">
                <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-white">{{ $food->cakename }}</h5>
                <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-white">₱ {{ $food->cakeprice }}</h5>

                <div class="flex justify-start gap-2">
                    <a href="{{route('customcake.edit', $food->cake_id)}}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Edit
                        {{-- <i class="fa-solid fa-arrow-right ml-3"></i> --}}
                    </a>
                    <a href="{{route('customcake.destroy', $food->cake_id)}}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
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