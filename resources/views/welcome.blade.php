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
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        

                    <!-- component -->
<div class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat" style="background-image: url('{{ asset('images/sibsfull.jpg') }}'); background-size: cover; background-position: center;">
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
            {{-- <div class="mt-8 flex justify-center text-lg text-black">
            <button type="submit" class="rounded-3xl bg-yellow-400 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-600">Login</button>
            </div> --}}
        </div>
        </div>
    </div>
</div>
                    


    </body>
</html>
