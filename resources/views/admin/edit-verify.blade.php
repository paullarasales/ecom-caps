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
            <form action="{{ route('verify.update', $user->id) }}" method="post">
                @csrf
                @method("PUT")

                <label class="text-gray-300 mt-2" for="">ID Verification</label>

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