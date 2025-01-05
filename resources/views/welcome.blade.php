<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>The Siblings Catering Services</title>
        <link rel="shortcut icon" type="x-icon" href="{{ asset('images/siblings.jpg')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        
    </head>
    <body class="font-sans antialiased dark:bg-gray-50 dark:text-white/50">
        

                    <!-- component -->
{{-- <div class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat" style="background-image: url('{{ asset('images/sibsfull.jpg') }}'); background-size: cover; background-position: center;">
    <div class="rounded-xl bg-gray-600 bg-opacity-50 px-16 w-2/3 lg:w-2/5 py-10 shadow-lg backdrop-blur-sm max-sm:px-8">
        <div class="text-white">
        <div class="mb-8 flex flex-col items-center">
            <img src="images/circle.png" width="150" alt="" srcset="" />
            <h1 class="mb-2 text-2xl text-center">The Siblings Catering Services</h1>
            <span class="text-gray-200">Welcome!</span>
        </div>
        <div>
            @if (Route::has('login'))
                @auth
                <div class="mt-8 flex justify-center text-lg text-black">
                    <a href="{{ url('/dashboard') }}"  class="rounded-3xl bg-yellow-400 bg-opacity-50 px-16 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-600">Dashboard</a>
                </div>
                @else
                <div class="mt-8 flex justify-center text-lg text-black">
                    <a href="{{ route('login') }}"  class="rounded-3xl bg-yellow-400 bg-opacity-50 px-16 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-600">Login</a>
                </div>
                    @if (Route::has('register'))
                    <div class="mt-8 flex justify-center text-lg text-black">
                        <a href="{{ route('register') }}"  class="rounded-3xl bg-yellow-400 bg-opacity-50 px-16 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-600">Register</a>
                    </div>
                    @endif
                @endauth
            @endif

        </div>
        </div>
    </div>
</div> --}}

<x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="flex items-center justify-center min-h-screen">
            <div class="flex bg-white rounded-lg shadow-lg overflow-hidden w-full mx-auto max-w-sm lg:max-w-4xl" >
                <!-- Left Image Section -->
                <div class="hidden lg:block lg:w-1/2 relative bg-yellow-50">
                    
                    <img src="{{ asset('images/a8.jpg') }}" 
                    class="absolute top-16 left-5 w-80 h-44 object-cover rounded-lg shadow-lg">
                    
                    <img src="{{ asset('images/a10.jpg') }}" 
                    class="absolute top-56 right-5 w-72 h-40 object-cover rounded-lg shadow-lg">
                    
                    {{-- <img src="{{ asset('images/a6.jpg') }}" 
                    class="absolute top-52 left-10 w-36 h-24 object-cover rounded-lg shadow-lg"> --}}
                    
                    {{-- <img src="{{ asset('images/a5.jpg') }}" 
                    class="absolute top-28 right-8 w-32 h-24 object-cover rounded-lg shadow-lg"> --}}

                    <img src="{{ asset('images/a9.jpg') }}" 
                    class="absolute bottom-16 left-16 w-60 h-32 object-cover rounded-lg shadow-lg">
                    
                    {{-- <img src="{{ asset('images/a2.jpg') }}" 
                    class="absolute bottom-16 right-10 w-44 h-24 object-cover rounded-lg shadow-lg"> --}}

                </div>
                

                <!-- Right Form Section -->
                <div class="w-full px-8 lg:w-1/2">
                    {{-- <h2 class="text-2xl font-semibold text-gray-700 text-center">The Siblings Catering Services</h2> --}}
                    

                    <div class=" flex items-center justify-center">
                        <img src="{{ asset('images/sibsrbg.png') }}" 
                        class="w-44 h-44 object-cover ">
                    </div>
                    <p class="text-xl text-gray-600 text-center">Welcome back!</p>


                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input id="email" 
                               class="bg-gray-200 text-gray-700 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1 border border-gray-300 rounded py-2 px-4 block w-full appearance-none" 
                               type="email" 
                               name="email" 
                               :value="old('email')" 
                               required 
                               autofocus 
                               autocomplete="username" />
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
                               autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            <div class="flex justify-end mt-2">
                                
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-gray-500">Forget Password?</a>
                                @endif
                            </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500" name="remember">
                            <span class="ml-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit" class=" text-white font-bold py-2 px-4 w-full rounded bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <!-- Sign Up -->
                    <div class="my-4 flex items-center justify-between">
                        <span class="border-b w-1/5 md:w-1/4"></span>
                        <a href="{{ route('register') }}" class="text-xs text-gray-500 uppercase">or sign up</a>
                        <span class="border-b w-1/5 md:w-1/4"></span>
                    </div>
                </div>
            </div>
        </div>
    </form>

    </body>
</html>
