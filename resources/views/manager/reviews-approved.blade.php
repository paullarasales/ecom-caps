<x-manager-layout>

    {{-- <div class="flex ml-3">
        <a href="{{route('managerreviews')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div> --}}

    <div class="text-center py-4 my-2">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            <span class="text-yellow-600">Reviews</span> and <span class="text-yellow-600">Ratings</span>
        </h3>
    </div>

    @forelse ($reviews as $review)
        <div class="shadow-2xl rounded-xl m-2 lg:m-10 mb-10">
            <blockquote class="overflow-hidden h-full flex flex-col bg-white shadow rounded-xl">
                <header class="p-6 space-y-4 flex flex-col flex-1 text-justify">
                    <p class="text-sm lg:text-md">
                        <span class="text-yellow-600">Content: </span>
                        {{ $review->content }}
                    </p>
                    @if (is_array($review->reviewimage))
                        <div class="mt-5">
                            <div class="flex flex-wrap -mx-2">
                                @foreach ($review->reviewimage as $index => $image)
                                    <div class="w-1/2 md:w-1/3 lg:w-1/4 px-2 mb-4">
                                        <div class="relative overflow-hidden" style="padding-top: 100%;">
                                            <img src="{{ asset($image) }}" alt="Featured image" class="absolute inset-0 w-full h-full object-cover cursor-pointer"
                                                onclick="openModal('{{ asset($image) }}')">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </header>
        
                <footer class="flex items-center px-6 py-4 space-x-4 text-white bg-gray-700 justify-between">    
                    <div>
                        <p class="text-md font-bold">{{ $review->user->firstname . ' ' . $review->user->lastname }}</p>
                        <a href="" rel="noopener" class="text-sm text-gray-200">
                            {{ $review->created_at->format('F d, Y') }}
                        </a>
                    </div>

                    

                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-300' : 'text-blue-300 dark:text-white' }} ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                </footer>
                <div class="flex items-center px-6 py-4 space-x-4 text-white bg-gray-700 justify-between">
                    <p class="text-sm text-gray-200">
                        <span class="text-gray-200">Event: </span>
                        {{ \Carbon\Carbon::parse($review->appointment->edate)->format('F j, Y') . ' at ' . $review->appointment->location }}
                    </p>
                    {{-- <form action="{{ route('managerreviews.pending', $review->review_id) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="status" value="pending">
                        <button type="submit" name="submit" class="inline-flex items-center w-25 px-2 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Hide
                            <i class="fa-regular fa-eye-slash ml-3"></i>
                        </button>                          
                    </form> --}}
                </div>

                <div class="bg-gray-700">
                    <div class="bg-gray-100 lg:m-5 lg:p-5 m-2 p-2 rounded-md">
                        <h1 class="text-lg font-semibold mb-4">Response</h1>
                        <form action="{{route('manager.reviews.response', $review->review_id)}}" method="POST" class="grid grid-cols-1 gap-4">
                            @csrf
                            @method("PUT")
                            <div>
                                {{-- <label for="response" class="block text-sm font-medium text-gray-700">Write a response:</label> --}}
                                <textarea id="response" name="response" rows="4" class="text-sm lg:text-md resize-none text-justify h-32 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1">{{ $review->response }}</textarea>

                            </div>
                            <div class="flex justify-end">
                                <button type="submit" onclick="showLoadingOverlay()" class="px-4 py-2 text-sm font-medium text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:outline-none focus:ring-4 focus:ring-yellow-300">
                                    Submit Response
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </blockquote>
        </div>
    @empty
        <p class="text-center text-gray-600">No approved reviews at the moment.</p>
    @endforelse

    <!-- Loading animation overlay -->
    <div id="loadingOverlay" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="flex flex-col items-center">
            <div id="loaderSpinner" class="loader border-t-4 border-yellow-500 rounded-full w-16 h-16 animate-spin"></div>
            <p class="text-white mt-4 font-semibold" id="loadingText">Your request is being processed</p>
        </div>
    </div>


    <!-- Styling for loading animation -->
    <style>
        /* Spinner animation */
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top-color: #f59e0b; /* Yellow color */
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        // Show the loading overlay when the form is submitted
        function showLoadingOverlay() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }

        window.onload = function() {
            @if (session('alert'))
                // Only show the overlay if there's an alert
                const alertType = "{{ session('alert') }}";
                const alertMessage = "{{ session('message') }}";

                // Ensure the overlay is visible
                document.getElementById('loadingOverlay').classList.remove('hidden');
                const loadingTextElement = document.getElementById('loadingText');
                const loaderSpinner = document.getElementById('loaderSpinner');

                // Set the alert message text
                loadingTextElement.textContent = alertMessage;

                // Hide the spinner if alert is success or error
                if (alertType === 'success' || alertType === 'error') {
                    loaderSpinner.classList.add('hidden');
                }

                // Hide the overlay after 3 seconds
                setTimeout(function() {
                    document.getElementById('loadingOverlay').classList.add('hidden');
                }, 3000); // Adjust the time as needed
            @endif
        };
    </script>

    <!-- Modal -->
    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative max-w-xl max-h-[75vh] bg-white  rounded-xl shadow-lg">
                <button class="absolute top-0 right-0 m-4 text-white" onclick="closeModal()">
                    <i class="fa-solid text-black fa-xmark text-3xl"></i>
                </button>
                <div id="modal-content" class="border rounded-lg border-gray-700"></div>
            </div>
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
