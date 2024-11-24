<x-admin-layout>
    <div class="flex ml-3">
        <a href="{{route('adminusers')}}">
            <div class="text-xl">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </div>
    
    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            User <span class="text-yellow-600">Verification</span>
        </h3>

    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-md  dark:bg-gray-700 p-5 rounded-2xl outline">
            <form action="{{ route('verify.update', $user->id) }}" method="post" onsubmit="showLoadingOverlay()">
                @csrf
                @method("PUT")

                <label class="text-gray-300 mt-2" for="">ID Verification</label>

                <h1 class="text-gray-300 my-2 text-xl capitalize">{{ $user->firstname ?? 'N/A' }} {{$user->lastname}}</h1>

                <select name="verifystatus" id="verifystatus" class="text-gray-300 rounded-md h-12 w-full mb-1 dark:bg-gray-800 focus:border-yellow-500 focus:ring-yellow-500">
                    <option value="unverified" {{ $user->verifystatus === 'unverified' ? 'selected' : '' }}>Unverified</option>
                    <option value="verified" {{ $user->verifystatus === 'verified' ? 'selected' : '' }}>Verified</option>
                </select>

                <div class="flex justify-center">
                    <input class="w-4/5 h-12 mt-4 bg-yellow-300 hover:bg-yellow-300 rounded-xl cursor-pointer" type="submit" name="submit" value="Update">
                </div>
            </form>
        </div>
    </div>

                    <!-- Loading animation overlay -->
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
</x-admin-layout>