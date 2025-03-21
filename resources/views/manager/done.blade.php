<x-manager-layout>

    <div class="flex ml-3">
        <a href="{{route('managerappointments')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Completed <span class="text-yellow-600">Events</span>
        </h3>

    </div>

    <div class="lg:mx-10 lg:my-5">
        <form method="GET" action="{{ route('manager.done') }}">
            <div class="flex items-center justify-center mb-4">
                <input type="text" name="search" class="border-2 border-yellow-300 focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 rounded-lg py-2 px-4 w-full lg:w-1/3"
                    placeholder="Search by name/reference..." value="{{ $search }}">
                <button type="submit" class="ml-2 px-4 py-2 bg-yellow-700 text-white rounded-lg hover:bg-yellow-800">
                    Search
                </button>
            </div>
        </form>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg lg:mx-10 lg:my-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    
                    <th scope="col" class="px-6 py-3">Location</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $app)
                <tr class="bg-white border-b dark:bg-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 hover:text-gray-200">
                    <th scope="row" class="px-6 py-4 capitalize">{{ $app->user->firstname ?? 'N/A' }} {{ $app->user->lastname ?? '' }} </th>
                    
                    <td class="px-6 py-4">{{ $app->location }}</td>
                    <td class="px-6 py-4">{{\Carbon\Carbon::parse($app->edate)->format('F j, Y') ? : 'No Event Date Assigned'}}</td>
                    <td class="px-6 py-4">
                        {{-- <a href="" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Edit
                            <i class="fa-regular fa-pen-to-square ml-3"></i>
                        </a> --}}
                        <a href="{{route('manager.doneView', $app->appointment_id)}}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            View
                            <i class="fa-regular fa-eye ml-3"></i>
                        </a>
                        {{-- <a href="{{route('usertype-edit', $user->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">Edit</a>
                        <a href="{{ route('verify.edit', $user->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-10">Verify</a> --}}
                        {{-- <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Deactivate</a> --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        
        
    </div>

    <div class="py-4 px-4">
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-900 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                Showing <span class="font-semibold text-gray-900">{{ $appointments->firstItem() }}</span> to 
                <span class="font-semibold text-gray-900">{{ $appointments->lastItem() }}</span> of 
                <span class="font-semibold text-gray-900">{{ $appointments->total() }}</span> results
            </span>
    
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                {{-- First Page Link --}}
                @if ($appointments->onFirstPage())
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                            First
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $appointments->url(1) }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            First
                        </a>
                    </li>
                @endif
    
                {{-- Previous Page Link --}}
                @if ($appointments->onFirstPage())
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                            Previous
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $appointments->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            Previous
                        </a>
                    </li>
                @endif
    
                {{-- Sliding Window Logic --}}
                @php
                    $currentPage = $appointments->currentPage();
                    $lastPage = $appointments->lastPage();
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
    
                {{-- Pagination Elements --}}
                @for ($page = $startPage; $page <= $endPage; $page++)
                    @if ($page == $appointments->currentPage())
                        <li>
                            <span class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 dark:bg-gray-700 dark:text-white">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $appointments->url($page) }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endfor
    
                {{-- Next Page Link --}}
                @if ($appointments->hasMorePages())
                    <li>
                        <a href="{{ $appointments->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                @if ($appointments->hasMorePages())
                    <li>
                        <a href="{{ $appointments->url($lastPage) }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
</x-manager-layout>