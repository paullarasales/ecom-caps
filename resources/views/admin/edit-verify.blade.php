<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="flex justify-center">
        <div class="w-full max-w-md mt-20 dark:bg-gray-700 p-5 rounded-2xl outline">
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


</x-admin-layout>