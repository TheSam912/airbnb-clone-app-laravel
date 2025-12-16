<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Airclone') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-rose-200 via-white to-slate-50 text-gray-900">
    <div class="min-h-screen grid lg:grid-cols-2">
        {{-- Left / brand panel --}}
        <div class="hidden lg:flex relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-600 to-rose-400"></div>
            <div
                class="absolute inset-0 opacity-15 bg-[radial-gradient(circle_at_20%_20%,white_0%,transparent_45%),radial-gradient(circle_at_80%_30%,white_0%,transparent_40%),radial-gradient(circle_at_40%_80%,white_0%,transparent_45%)]">
            </div>

            <div class="relative w-full p-12 flex flex-col justify-between text-white">
                <div class="flex items-center gap-3">
                    <div
                        class="w-11 h-11 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center font-bold">
                        A
                    </div>
                    <div>
                        <div class="text-xl font-semibold">Airclone</div>
                        <div class="text-white/80 text-sm">Book stays. Host homes.</div>
                    </div>
                </div>

                <div class="max-w-md">
                    <h1 class="text-3xl font-bold leading-tight">Welcome back</h1>
                    <p class="mt-3 text-white/85">
                        Sign in to manage your trips, listings, and bookings.
                    </p>

                    <div class="mt-6 flex gap-2 text-sm">
                        <span class="px-3 py-1 rounded-full bg-white/15">Laravel</span>
                        <span class="px-3 py-1 rounded-full bg-white/15">Tailwind</span>
                        <span class="px-3 py-1 rounded-full bg-white/15">Bookings</span>
                    </div>
                </div>

                <div class="text-xs text-white/70">
                    © {{ date('Y') }} Airclone. Cloned From Airbnb Website <br />
                    <p class="text-xs text-white/70">
                        Developed By Sam Nolan
                    </p>
                </div>
            </div>
        </div>

        {{-- Right / auth card --}}
        <div class="flex items-center justify-center p-6 sm:p-10">
            <div class="w-full max-w-lg">
                <div class="lg:hidden flex items-center justify-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-2xl bg-rose-600 text-white flex items-center justify-center font-bold">
                            A</div>
                        <div class="font-semibold text-lg">Airclone</div>
                    </a>
                </div>

                <div class="bg-white/80 backdrop-blur border border-gray-200 shadow-sm rounded-2xl p-6 sm:p-10">
                    {{ $slot }}
                </div>

                <div class="mt-6 text-center text-xs text-gray-500">
                    Demo project — no real payments.
                </div>
            </div>
        </div>
    </div>
</body>

</html>