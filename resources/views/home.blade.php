<x-app-layout>
    <div class="py-14">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border rounded-2xl p-10 shadow-sm">
                <h1 class="text-3xl font-bold text-gray-900">Find your next stay</h1>
                <p class="text-gray-600 mt-2">Browse places to stay or start hosting in minutes.</p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('listings.index') }}"
                        class="px-5 py-3 rounded-xl bg-rose-600 text-white hover:bg-rose-700">
                        Explore stays
                    </a>

                    @auth
                        <a href="{{ route('host.listings.index') }}" class="px-5 py-3 rounded-xl border hover:bg-gray-50">
                            Go to host dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl border hover:bg-gray-50">
                            Create account
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>