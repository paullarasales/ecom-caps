<x-admin-layout>
    
    <div class="absolute">
        <a href="{{route('adminpackages')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Event <span class="text-yellow-600">Packages</span>
        </h3>

    </div>

<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4">
    

@foreach ($package as $pk)

<div class="max-w-[12rem] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <a href="#" class="block w-full relative pb-[100%] overflow-hidden rounded-t-lg">
        
        @if ($pk->packagephoto)
            <img class="absolute top-0 left-0 w-full h-full object-cover" src="{{ asset($pk->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($pk->packagephoto) }}')" />
        @endif
    </a>
    <div class="p-3">
        <a href="#">
            <h5 class="mb-2 text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-white">{{ $pk->packagename }}</h5>
        </a>
        
        <a href="{{route('showpackage', $pk->package_id)}}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
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


<div class="py-4 px-4">
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-900 mb-4 md:mb-0 block w-full md:inline md:w-auto">
            Showing <span class="font-semibold text-gray-900 ">{{ $package->firstItem() }}</span> to 
            <span class="font-semibold text-gray-900 ">{{ $package->lastItem() }}</span> of 
            <span class="font-semibold text-gray-900 ">{{ $package->total() }}</span> results
        </span>

        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            {{-- Previous Page Link --}}
            @if ($package->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        Previous
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $package->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($package->getUrlRange(1, $package->lastPage()) as $page => $url)
                @if ($page == $package->currentPage())
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
        </ul>
    </nav>
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