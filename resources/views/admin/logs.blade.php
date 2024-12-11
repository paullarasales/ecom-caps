<x-admin-layout>
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Operation <span class="text-yellow-600">Logs</span>
        </h3>

    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg lg:mx-10 lg:my-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>

                    <th scope="col" class="px-6 py-3">Action</th>
                    
                    <th scope="col" class="px-6 py-3">Description</th>

                    <th scope="col" class="px-6 py-3">Timestamp</th>

                    <th scope="col" class="px-6 py-3">User</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr class="bg-white border-b dark:bg-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 hover:text-gray-200">
                    
                    <th scope="row" class="px-6 py-4 uppercase">{{$log->action}}</th>
                    
                    <td class="px-6 py-4">{{$log->description}}</td>

                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($log->created_at)->format('F j, Y g:i A') }}</td>

                    <td class="px-6 py-4">{{$log->user->firstname}} {{$log->user->lastname}}</td>

                </tr>
                @empty
                <tr>
                    <td colspan="3">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    
    
    
    </div>

    <div class="py-4">
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-900 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                Showing <span class="font-semibold text-gray-900 ">{{ $logs->firstItem() }}</span> to 
                <span class="font-semibold text-gray-900 ">{{ $logs->lastItem() }}</span> of 
                <span class="font-semibold text-gray-900 ">{{ $logs->total() }}</span> results
            </span>
    
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                {{-- First Page Link --}}
                @if ($logs->onFirstPage())
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                            First
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $logs->url(1) }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            First
                        </a>
                    </li>
                @endif
            
                {{-- Previous Page Link --}}
                @if ($logs->onFirstPage())
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                            Previous
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $logs->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            Previous
                        </a>
                    </li>
                @endif
            
                {{-- Calculate the range of pages to display --}}
                @php
                    $currentPage = $logs->currentPage();
                    $lastPage = $logs->lastPage();
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
                    @if ($page == $logs->currentPage())
                        <li>
                            <span class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 dark:bg-gray-700 dark:text-white">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $logs->url($page) }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endfor
            
                {{-- Next Page Link --}}
                @if ($logs->hasMorePages())
                    <li>
                        <a href="{{ $logs->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                @if ($logs->hasMorePages())
                    <li>
                        <a href="{{ $logs->url($logs->lastPage()) }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
</x-admin-layout>