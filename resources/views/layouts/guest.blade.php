<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>The Siblings Catering Services</title>
        <link rel="shortcut icon" type="x-icon" href="{{ asset('images/siblings.jpg')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center justify-center items-center pt-6 sm:pt-0 bg-gray-100" style="background-image: url('{{ asset('images/sibsfull.jpg') }}'); background-size: cover; background-position: center;">
            {{-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> --}}

            <div class="rounded-xl bg-gray-600 bg-opacity-50 px-16 w-4/5 lg:w-2/5 py-10 shadow-lg backdrop-blur-sm max-sm:px-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
