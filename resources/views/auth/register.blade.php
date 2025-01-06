<x-guest-layout>
    {{-- <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Username')" class="text-gray-900"/>
            <x-text-input id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-900"/>
            <x-text-input id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-900"/>

            <x-text-input id="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-900" />

            <x-text-input id="password_confirmation" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 gap-2">
            <a class="underline text-sm text-gray-900 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('welcome') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}

    <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex bg-white rounded-lg shadow-lg overflow-hidden w-full mx-auto max-w-sm lg:max-w-4xl">
            <!-- Left Image Section -->
            <div class="hidden lg:block lg:w-1/2 relative bg-yellow-50">
                <img src="{{ asset('images/a8.jpg') }}" 
                     class="absolute top-32 left-5 w-80 h-44 object-cover rounded-lg shadow-lg">
                <img src="{{ asset('images/a10.jpg') }}" 
                     class="absolute top-72 right-5 w-72 h-40 object-cover rounded-lg shadow-lg">
                <img src="{{ asset('images/a9.jpg') }}" 
                     class="absolute bottom-28 left-16 w-60 h-32 object-cover rounded-lg shadow-lg">
            </div>

            <!-- Right Form Section -->
            <div class="w-full px-8 lg:w-1/2">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/sibsrbg.png') }}" 
                         class="w-44 h-44 object-cover">
                </div>
                <p class="text-xl text-gray-600 text-center">Create your account!</p>

                <!-- Username -->
                <div class="mt-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input id="name" 
                           class="bg-gray-200 text-gray-700 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 border border-gray-300 rounded py-2 px-4 block w-full appearance-none" 
                           type="text" 
                           name="name" 
                           :value="old('name')" 
                           required 
                           autofocus 
                           autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input id="email" 
                           class="bg-gray-200 text-gray-700 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 border border-gray-300 rounded py-2 px-4 block w-full appearance-none" 
                           type="email" 
                           name="email" 
                           :value="old('email')" 
                           required 
                           autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input id="password" 
                           class="bg-gray-200 text-gray-700 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 border border-gray-300 rounded py-2 px-4 block w-full appearance-none" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input id="password_confirmation" 
                           class="bg-gray-200 text-gray-700 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 border border-gray-300 rounded py-2 px-4 block w-full appearance-none" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="text-white font-bold py-2 px-4 w-full rounded bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700">
                        {{ __('Register') }}
                    </button>
                </div>

                <!-- Already Registered -->
                <div class="my-4 flex items-center justify-between">
                    <span class="border-b w-1/5 md:w-1/4"></span>
                    <a href="{{ route('welcome') }}" class="text-xs text-gray-500 uppercase">Already registered?</a>
                    <span class="border-b w-1/5 md:w-1/4"></span>
                </div>
            </div>
        </div>
    </div>
</form>

</x-guest-layout>
