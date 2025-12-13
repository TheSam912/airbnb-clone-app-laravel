<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">Reset your password</h1>
            <p class="text-sm text-gray-500 mt-1">
                Enter your email and we’ll send you a reset link.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl
                       bg-black text-white font-medium hover:bg-black
                       focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition">
                {{ __('Send reset link') }}
            </button>

            <p class="text-center text-sm text-gray-600">
                Remembered your password?
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-medium">Back to login</a>
            </p>
        </form>
    </div>
</x-guest-layout>