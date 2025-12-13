<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">Create your account</h1>
            <p class="text-sm text-gray-500 mt-1">Join Airclone and start booking or hosting.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Name --}}
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm password')" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl
                       bg-black text-white font-medium hover:bg-black
                       focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition">
                {{ __('Sign up') }}
            </button>

            <p class="text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-medium">Sign in</a>
            </p>
        </form>
    </div>
</x-guest-layout>