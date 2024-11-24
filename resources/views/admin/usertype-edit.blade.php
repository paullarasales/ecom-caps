<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mx-3">
        <div class="w-full max-w-md my-10 dark:bg-gray-200 p-5 rounded-2xl outline">
            <form action="{{ route('usertype-update', $user->id) }}" method="post">
                @csrf
                @method("PUT")
                    <!-- Display validation errors -->
    <div id="errorModal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
            <div class="flex justify-between">
                <h2 class="text-lg font-bold mb-4">Validation Errors</h2>
                <button id="closeErrorModal" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Close</button>
            </div>
            <ul id="errorMessageList" class="text-gray-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        // Check if there are validation errors
        var errors = @json($errors->any()); // Get the boolean status of errors
        var errorModal = document.getElementById('errorModal');
        var closeErrorModalButton = document.getElementById('closeErrorModal');

        // Show the error modal if there are errors
        if (errors) {
            errorModal.classList.remove('hidden'); // Show the modal
        }

        // Close error modal event
        closeErrorModalButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent any default action (if needed)
            errorModal.classList.add('hidden'); // Hide the modal
        });

        // Optional: Close the modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === errorModal) {
                errorModal.classList.add('hidden'); // Hide the modal
            }
        });
    </script>
                <label class="text-gray-900 mt-2" for="">Name</label>
                <input class="text-gray-900 rounded-md h-12 w-full mb-1 dark:bg-gray-400 focus:border-yellow-500 focus:ring-yellow-500" type="text" name="name" value="{{$user->name}}">

                <label class="text-gray-900 mt-2" for="">Email</label>
                <input class="text-gray-900 rounded-md h-12 w-full mb-1 dark:bg-gray-400 focus:border-yellow-500 focus:ring-yellow-500" type="text" name="email" value="{{$user->email}}">

                <label class="text-gray-900 mt-2" for="">First Name</label>
                <input class="text-gray-900 rounded-md h-12 w-full mb-1 dark:bg-gray-400 focus:border-yellow-500 focus:ring-yellow-500" type="text" name="firstname" value="{{$user->firstname}}">

                <label class="text-gray-900 mt-2" for="">Last Name</label>
                <input class="text-gray-900 rounded-md h-12 w-full mb-1 dark:bg-gray-400 focus:border-yellow-500 focus:ring-yellow-500" type="text" name="lastname" value="{{$user->lastname}}">

                <label class="text-gray-900 mt-2" for="">User Type</label>
                {{-- <input class="text-gray-300 rounded-md h-12 w-full mb-1 dark:bg-gray-800 focus:border-yellow-500 focus:ring-yellow-500" type="text" name="usertype" value="{{$user->usertype}}"> --}}
                <select name="usertype" id="usertype"  class="text-gray-900 rounded-md h-12 w-full mb-1 dark:bg-gray-400 focus:border-yellow-500 focus:ring-yellow-500">
                    <option value="manager" {{$user->usertype === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="owner" {{$user->usertype === 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="user" {{$user->usertype === 'user' ? 'selected' : '' }}>User</option>
                </select>

                <div class="flex justify-center">
                    <input class="w-4/5 h-12 mt-4 bg-yellow-500 hover:bg-yellow-300 rounded-xl cursor-pointer" type="submit" name="submit" value="Update">
                </div>
            </form>
        </div>
    </div>


</x-admin-layout>