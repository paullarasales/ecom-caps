<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ordering System') }}</title>

    <link rel="shortcut icon" href="{{ asset('logo/no-bg.png') }}">

    <!-- Fonts -->
    <link rel="shortcut icon" type="x-icon" href="{{ asset('images/siblings.jpg')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&family=Rubik+Broken+Fax&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-poppins antialiased">
    <div class="flex flex-col min-h-screen sm:flex-row">
        <!-- Sidebar -->
        <aside class="bg-white text-black w-full sm:w-64 p-4 flex-shrink-0 sm:h-screen" x-data="{ open: false }">
            <!-- Logo and Sidebar content -->
            <div class="flex items-center justify-between sm:justify-center">
                <div class="flex flex-col items-start sm:items-center w-full">
                    <header>
                        <!-- Logo -->
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('images/sibsrbg.png')}}" alt="Logo" class="w-20">
                        </div>
                    </header>
                </div>
                
                <!-- Sidebar toggle button for small screens -->
                <button type="button" @click="open = !open" class="sm:hidden inline-flex p-2 items-center justify-center rounded-md text-black hover:bg-yellow-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        
            <nav :class="{ 'block': open, 'hidden': !open }" class="flex flex-col mt-10 gap-3 sm:block transition duration-300 ease-in-out">
                <!-- Sidebar links with responsive adjustments -->
                <div class="{{ request()->routeIs('ownerdashboard') ? 'bg-gray-200' : '' }} flex items-center gap-2 rounded-sm h-12">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ request()->routeIs('ownerdashboard') ? '#FFB200' : '#000000'}}" class="ml-4 sm:ml-10 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>

                    <x-side-nav-link href="{{ route('ownerdashboard') }}" :active="request()->routeIs('ownerdashboard')" class="text-xl text-black font-medium mt-1 flex items-center w-full">
                        {{ __('Dashboard') }}
                    </x-side-nav-link>
                </div>
                <div class="{{ request()->routeIs('ownerchat') ? 'bg-gray-200' : '' }} flex items-center gap-2 rounded-sm h-12 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ request()->routeIs('ownerchat') ? '#FFB200' : '#000000'}}" class="ml-4 sm:ml-10 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                    </svg>
                    <span class="absolute top-4 right-3 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold messagenotification-badge {{ $unreadChatCount > 0 ? '' : 'hidden' }}">
                        {{ $unreadChatCount }}
                    </span>

                    <x-side-nav-link href="{{ route('ownerchat') }}" :active="request()->routeIs('ownerchat')" class="text-xl text-black font-medium mt-1 flex items-center w-full">
                        {{ __('Chat') }}
                    </x-side-nav-link>
                </div>
                <div class="{{ request()->routeIs('ownercalendarView') ? 'bg-gray-200' : '' }} flex items-center gap-2 rounded-sm h-12">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ request()->routeIs('ownercalendarView') ? '#FFB200' : '#000000'}}" class="ml-4 sm:ml-10 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>

                    <x-side-nav-link href="{{ route('ownercalendarView') }}" :active="request()->routeIs('ownercalendarView')" class="text-xl text-black font-medium mt-1 flex items-center w-full">
                        {{ __('Calendar') }}
                    </x-side-nav-link>
                </div>
                <div class="{{ request()->routeIs('ownerbooking') ? 'bg-gray-200' : '' }} flex items-center gap-2 rounded-sm h-12">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ request()->routeIs('ownerbooking') ? '#FFB200' : '#000000'}}" class="ml-4 sm:ml-10 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>

                    <x-side-nav-link href="{{ route('ownerbooking') }}" :active="request()->routeIs('ownerbooking')" class="text-xl text-black font-medium mt-1 flex items-center w-full">
                        {{ __('Booking') }}
                    </x-side-nav-link>
                </div>
                <!-- Repeat similar blocks for other sidebar links like 'Chat', 'Calendar', etc. -->
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-100 p-4">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="mx-auto px-2 sm:px-6 lg:px-8">
                    <div class="relative flex items-center justify-between h-16">
                        <div>
                            <h1 class="text-2xl font-medium">Owner</h1>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <div class="text-sm my-3 mx-4">
                                <a href="{{route('owner.notifications')}}" class="bg-yellow-200 rounded-3xl py-3 px-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t relative">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="absolute -top-1 -right-1 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold notification-badge {{ $unreadCount > 0 ? '' : 'hidden' }}">
                                        {{ $unreadCount }}
                                    </span>
                                </a>
                            </div> 
                            <div x-data="{ open: false }" class="relative">
                                <!-- Profile Dropdown Button -->
                                <button @click="open = !open" class="relative inline-flex items-center px-3 py-2 border border-transparent text-md leading-4 font-lg rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" aria-haspopup="true" aria-expanded="open" style="z-index: 10;">
                                    <div class="flex items-center">
                                        @if(Auth::user()->photo)
                                            <img class="w-9 h-9 rounded-full ml-2 border-solid border-2 border-sky-500" src="{{ asset(Auth::user()->photo) }}" alt="Profile Image">
                                        @endif
                                        <svg class="fill-current h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 transition ease-in-out duration-150" role="menu" style="z-index: 20;">
                                    <div class="py-1" role="none">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Edit Profile') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}" role="none">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <script>
                // Polling for unread appointment count
                setInterval(function() {
                    fetch('{{ route('fetch.owner.unread.count') }}')
                        .then(response => response.json())
                        .then(data => {
                            const notificationBadge = document.querySelector('.notification-badge');
                            if (notificationBadge) {
                                notificationBadge.textContent = data.count > 0 ? data.count : '';
                                notificationBadge.classList.toggle('hidden', data.count === 0);
                            }
                        })
                        .catch(error => console.error('Error fetching unread count:', error));
                }, 5000); // Check every 5 seconds
            </script>

            <script>
                // Polling for unread appointment count
                setInterval(function() {
                    fetch('{{ route('fetch.owner.unopened.message.count') }}')
                        .then(response => response.json())
                        .then(data => {
                            const notificationBadge = document.querySelector('.messagenotification-badge');
                            if (notificationBadge) {
                                notificationBadge.textContent = data.count > 0 ? data.count : '';
                                notificationBadge.classList.toggle('hidden', data.count === 0);
                            }
                        })
                        .catch(error => console.error('Error fetching unread count:', error));
                }, 5000); // Check every 5 seconds
            </script>

            <!-- Main Content Area -->
            <div class="flex-1 p-4">
                <div class="relative py-4 bg-white overflow-hidden shadow sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js"></script>
</body>

</html>
