<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mb-10">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('eventsView')" :active="request()->routeIs('eventsView')">
                        {{ __('Events') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                        {{ __('About Us') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('faqs')" :active="request()->routeIs('faqs')">
                        {{ __('FAQS') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('reviews')" :active="request()->routeIs('reviews')">
                        {{ __('Reviews') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('myevent')" :active="request()->routeIs('myevent')">
                        {{ __('My Events') }}
                    </x-nav-link>
                </div>
            </div>
            

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="text-sm my-3 mx-4">
                    <a href="{{ route('book-form') }}" class="bg-yellow-200 rounded-3xl py-3 px-8 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t">Book Now</a>
                </div>
                <div class="text-sm my-3 mx-4">
                    <a href="{{ route('notifications') }}" class="bg-yellow-200 rounded-3xl py-3 px-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t relative">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute -top-1 -right-1 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold notification-badge {{ $unreadCount > 0 ? '' : 'hidden' }}">
                            {{ $unreadCount }}
                        </span>
                    </a>
                </div>                
                <div class="text-sm my-3 mx-4">
                    <a href="{{ route('chat') }}" class="bg-yellow-200 rounded-3xl py-3 px-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t relative">
                        <i class="fa-solid fa-message"></i>
                        <span class="absolute -top-1 -right-1 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold messagenotification-badge {{ $unreadChatCount > 0 ? '' : 'hidden' }}">
                            {{ $unreadChatCount }}
                        </span>
                    </a>
                </div>
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <div class="text-sm my-3 relative">
                    <a href="{{route('notifications')}}" class="bg-yellow-200 rounded-3xl py-3 px-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute -top-3 -right-1 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold notification-badge {{ $unreadCount > 0 ? '' : 'hidden' }}">
                            {{ $unreadCount }}
                        </span>
                    </a>
                </div>
                <div class="text-sm my-3 mx-4 relative">
                    <a href="{{ route('chat') }}" class="bg-yellow-200 rounded-3xl py-3 px-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t relative">
                        <i class="fa-solid fa-message"></i>
                        <span class="absolute -top-0 -right-1 inline-block w-5 h-5 text-center text-white bg-red-500 rounded-full text-xs font-bold messagenotification-badge {{ $unreadChatCount > 0 ? '' : 'hidden' }}">
                            {{ $unreadChatCount }}
                        </span>
                    </a>
                </div>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('eventsView')" :active="request()->routeIs('eventsView')">
                {{ __('Events') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                {{ __('About us') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('faqs')" :active="request()->routeIs('faqs')">
                {{ __('FAQS') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('reviews')" :active="request()->routeIs('reviews')">
                {{ __('Reviews') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('myevent')" :active="request()->routeIs('myevent')">
                {{ __('My Events') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Polling for unread appointment count
        setInterval(function() {
            fetch('{{ route('fetch.unread.count') }}')
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

    {{-- <script>
        // Polling for unread appointment count
        setInterval(function() {
            fetch('{{ route('fetch.unread.count') }}')
                .then(response => response.json())
                .then(data => {
                    const notificationBadge = document.querySelector('.resnotification-badge');
                    if (notificationBadge) {
                        notificationBadge.textContent = data.count > 0 ? data.count : '';
                        notificationBadge.classList.toggle('hidden', data.count === 0);
                    }
                })
                .catch(error => console.error('Error fetching unread count:', error));
        }, 5000); // Check every 5 seconds
    </script> --}}

    <script>
        // Polling for unread appointment count
        setInterval(function() {
            fetch('{{ route('fetch.user.unread.message.count') }}')
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

</nav>
