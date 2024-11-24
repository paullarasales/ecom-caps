<x-app-layout>
    <div class="text-center py-4 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Make <span class="text-yellow-600">Review</span>
        </h3>
    </div>

    <form action="{{route('reviews.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="p-6 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
                <div>
                    <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Reviews And Rating</p>
                                <p>Please fill out all the fields.</p>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                                    <div class="md:col-span-5">
                                        <label for="content">Review</label>
                                        <textarea name="content" id="content" rows="4" class="resize-none h-20 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1"></textarea>
                                    </div>
                                    
                                    
                                    <div class="md:col-span-5">
                                        <label for="rating">Rating</label>
                                        <!-- Hidden select dropdown -->
                                        <select name="rating" id="rating" class="hidden" value="5">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5</option>
                                        </select>

                                        <!-- Custom star rating -->
                                        <div class="flex items-center">
                                            <!-- Star 1 -->
                                            <svg class="w-8 h-8 star cursor-pointer" data-value="1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <!-- Repeat for other stars -->
                                            <svg class="w-8 h-8 star cursor-pointer" data-value="2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <svg class="w-8 h-8 star cursor-pointer" data-value="3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <svg class="w-8 h-8 star cursor-pointer" data-value="4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <svg class="w-8 h-8 star cursor-pointer" data-value="5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label for="images">Images</label>
                                        <input type="file" name="images[]" id="images" class="h-10 border py-2 mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" accept="image/*" multiple onchange="limitFiles(this, 4)" />
                                    </div>

                                    <input type="hidden" name="appointment_id" value="{{ $appointment->appointment_id }}">

                                    <div class="md:col-span-5 text-right">
                                        <input type="submit" name="submit" value="Submit" onclick="showLoadingOverlay()" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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



    <!-- JavaScript for star rating -->
    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');
        
        // Function to highlight stars based on rating
        function highlightStars(rating) {
            stars.forEach((star, index) => {
                star.classList.toggle('text-yellow-500', index < rating);
                star.classList.toggle('text-gray-400', index >= rating);
            });
            ratingInput.value = rating; // Update the hidden rating input
        }

        // Pre-select 5 stars on load
        highlightStars(5);

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-value');
                highlightStars(rating); // Highlight stars based on clicked star
            });
        });
    </script>

        <!-- Alert messages -->
        @if(session('alert'))
        {{-- <div class="fixed top-0 right-0 mt-4 mr-4 px-4 py-2 bg-green-400 text-white rounded shadow-lg flex items-center space-x-2">
            <span>{{ session('alert') }}</span>
            <button onclick="this.parentElement.remove()" class="text-white bg-green-600 hover:bg-green-700 rounded-full p-1">
                <i class="fa-solid fa-times"></i>
            </button>
        </div> --}}
    @elseif(session('error'))
        <div class="fixed top-0 right-0 mt-4 mr-4 px-4 py-2 bg-red-400 text-white rounded shadow-lg flex items-center space-x-2">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-white bg-red-600 hover:bg-red-700 rounded-full p-1">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    @endif
</x-app-layout>
