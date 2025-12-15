<footer class="border-t bg-white mt-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <div class="font-semibold text-gray-900">AirClone</div>
                <p class="text-sm text-gray-600 mt-2">
                    A clean Airbnb-style clone built with Laravel.
                </p>
            </div>

            <div>
                <div class="text-sm font-semibold text-gray-900">Explore</div>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    <li><a class="hover:text-gray-900" href="{{ route('listings.index') }}">Stays</a></li>
                    @auth
                        <li><a class="hover:text-gray-900" href="{{ route('trips.index') }}">Trips</a></li>
                        <li><a class="hover:text-gray-900" href="{{ route('wishlist.index') }}">Wishlist</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <div class="text-sm font-semibold text-gray-900">Hosting</div>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    @auth
                        <li><a class="hover:text-gray-900" href="{{ route('host.listings.index') }}">Host dashboard</a></li>
                        <li><a class="hover:text-gray-900" href="{{ route('host.bookings.index') }}">Host bookings</a></li>
                        <li><a class="hover:text-gray-900" href="{{ route('host.onboarding.listings.create') }}">Create
                                listing</a></li>
                    @else
                        <li><a class="hover:text-gray-900" href="{{ route('login') }}">Log in to host</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <div class="text-sm font-semibold text-gray-900">Account</div>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    @auth
                        <li><a class="hover:text-gray-900" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="hover:text-red-600">Log out</button>
                            </form>
                        </li>
                    @else
                        <li><a class="hover:text-gray-900" href="{{ route('login') }}">Log in</a></li>
                        <li><a class="hover:text-gray-900" href="{{ route('register') }}">Sign up</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="text-sm text-gray-600">
                © {{ now()->year }} AirClone. All rights reserved.
            </div>

            <div class="flex items-center gap-4 text-sm text-gray-600">
                <span class="inline-flex items-center gap-2">
                    Built with ❤️ By Sam Nolan
                </span>
            </div>
        </div>
    </div>
</footer>