<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
            <p class="text-sm text-gray-500 mt-1">Sign in to continue</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full rounded-xl" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" />
                    @if (Route::has('password.request'))
                        <a class="text-sm text-rose-600 hover:text-rose-700 font-medium"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot?') }}
                        </a>
                    @endif
                </div>

                <x-text-input id="password" class="mt-1 block w-full rounded-xl" type="password" name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember --}}
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember"
                    class="rounded border-gray-300 text-rose-600 shadow-sm focus:ring-rose-500">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            <button class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl
                       bg-gray-900 text-white font-medium hover:bg-black
                       focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition">
                {{ __('Sign in') }}
            </button>

            <p class="text-center text-sm text-gray-600">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-rose-600 hover:text-rose-700 font-medium">Sign up</a>
            </p>
        </form>
    </div>
</x-guest-layout>