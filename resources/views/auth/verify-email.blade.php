<x-guest-layout>
    {{-- <div class="mb-4 text-sm text-gray-100">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button class="bg-yellow-500 hover:bg-yellow-700 cursor-pointer text-white font-bold py-2 px-4 rounded">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-100 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div> --}}

    <div class="flex items-center justify-center min-h-screen">
        <div class="flex bg-white rounded-lg shadow-lg overflow-hidden w-full mx-auto max-w-sm lg:max-w-4xl">
            <!-- Left Image Section -->
            <div class="hidden lg:block lg:w-1/2 relative bg-yellow-50">
                <img src="{{ asset('images/a8.jpg') }}" 
                     class="absolute top-12 left-5 w-64 h-36 object-cover rounded-lg shadow-lg">
                <img src="{{ asset('images/a10.jpg') }}" 
                     class="absolute top-44 right-5 w-56 h-32 object-cover rounded-lg shadow-lg">
                <img src="{{ asset('images/a9.jpg') }}" 
                     class="absolute bottom-12 left-16 w-52 h-28 object-cover rounded-lg shadow-lg">
            </div>
    
            <!-- Right Form Section -->
            <div class="w-full px-8 lg:w-1/2">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/sibsrbg.png') }}" 
                         class="w-44 h-44 object-cover">
                </div>
                <p class="text-xl text-gray-600 text-center mb-4">Email Verification</p>
    
                <div class="mb-4 text-sm text-gray-700">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>
    
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif
    
                <div class="mt-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>
    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full my-5 underline text-sm text-gray-700 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</x-guest-layout>
