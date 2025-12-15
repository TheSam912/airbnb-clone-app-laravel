<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- LEFT: Brand --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold">
                        A
                    </div>
                    <span class="text-lg font-semibold text-gray-900 hidden sm:inline">
                        Airclone
                    </span>
                </a>
            </div>

            {{-- CENTER: Main navigation (desktop) --}}

            {{-- CENTER: Search pill --}}
            <div class="hidden md:flex flex-2 justify-center">
                <a href="{{ route('listings.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full border shadow-sm hover:shadow-md transition">
                    <span class="text-sm font-medium text-gray-800">Anywhere</span>
                    <span class="text-gray-300">•</span>
                    <span class="text-sm font-medium text-gray-800">Any week</span>
                    <span class="text-gray-300">•</span>
                    <span class="text-sm text-gray-500">Add guests</span>
                    <span class="ml-2 w-8 h-8 rounded-full text-white flex items-center justify-center">
                        🔍
                    </span>
                </a>
            </div>

            {{-- RIGHT: Auth --}}
            <div class="hidden md:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100">
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium bg-red-600 text-white hover:bg-red-700">
                        Sign up
                    </a>
                @else
                    @auth
                        <a href="{{ route('host.onboarding.listings.create') }}"
                            class="hidden md:inline-flex px-4 py-2 rounded-full border font-medium hover:bg-gray-50">
                            Airbnb your home
                        </a>
                    @endauth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-full border hover:shadow-sm">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ Auth::user()->name }}
                                </span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                        <x-slot name="content">

                            <div class="px-4 py-2 text-xs text-gray-500 uppercase">Hosting</div>

                            <x-dropdown-link :href="route('host.listings.index')">
                                Manage listings
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('host.bookings.index')">
                                Host bookings
                            </x-dropdown-link>

                            <div class="border-t my-2"></div>

                            <div class="px-4 py-2 text-xs text-gray-500 uppercase">Travel</div>

                            <x-dropdown-link :href="route('trips.index')">
                                My trips
                            </x-dropdown-link>

                            <div class="border-t my-2"></div>
                            <x-dropdown-link :href="route('wishlist.index')">
                                Wishlist
                            </x-dropdown-link>
                            <div class="border-t my-2"></div>

                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endguest
            </div>

            {{-- MOBILE hamburger --}}
            <div class="md:hidden">
                <button @click="open = !open" class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE menu --}}
    <div x-show="open" x-transition @click.outside="open = false" class="md:hidden border-t bg-white">
        <div class="px-4 py-4 space-y-3">
            <a href="{{ route('listings.index') }}" class="block font-medium">Stays</a>

            @auth
                <a href="{{ route('host.listings.index') }}" class="block font-medium">Host</a>
                <a href="{{ route('host.bookings.index') }}" class="block font-medium">Bookings</a>
                <a href="{{ route('trips.index') }}" class="block font-medium">Trips</a>
                <a href="{{ route('wishlist.index') }}" class="block font-medium">Wishlist</a>

                <hr>

                <a href="{{ route('profile.edit') }}" class="block text-sm text-gray-600">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block text-sm text-red-600">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block font-medium">Log in</a>
                <a href="{{ route('register') }}" class="block font-medium text-red-600">Sign up</a>
            @endauth
        </div>
    </div>
</nav>