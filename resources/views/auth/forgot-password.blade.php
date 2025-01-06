<x-guest-layout>
    {{-- <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form> --}}

    <div class="flex items-center justify-center min-h-screen">
        <div class="flex bg-white rounded-lg shadow-lg overflow-hidden w-full mx-auto max-w-sm lg:max-w-4xl">
            <!-- Left Image Section -->
            <div class="hidden lg:block lg:w-1/2 relative bg-yellow-50">
                <img src="{{ asset('images/a8.jpg') }}" 
                     class="absolute top-8 left-5 w-72 h-40 object-cover rounded-lg shadow-lg">
                <img src="{{ asset('images/a10.jpg') }}" 
                     class="absolute top-40 right-5 w-60 h-36 object-cover rounded-lg shadow-lg">
                <img src="{{ asset('images/a9.jpg') }}" 
                     class="absolute bottom-8 left-16 w-52 h-28 object-cover rounded-lg shadow-lg">
            </div>
    
            <!-- Right Form Section -->
            <div class="w-full px-8 lg:w-1/2">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/sibsrbg.png') }}" 
                         class="w-44 h-44 object-cover">
                </div>
                <p class="text-xl text-gray-600 text-center mb-4">Forgot Password</p>
    
                <div class="mb-4 text-sm text-gray-700">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
    
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
    
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
    
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="bg-gray-200 text-gray-700 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 border border-gray-300 rounded py-2 px-4 block w-full appearance-none" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
    
                    <div class="my-4">
                        <button type="submit" 
                                class="w-full bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-guest-layout>
