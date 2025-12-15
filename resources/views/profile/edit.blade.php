<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Account</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your profile and security settings.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Left sidebar --}}
                <aside class="lg:col-span-4">
                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Member since</span>
                                <span
                                    class="font-medium text-gray-900">{{ Auth::user()->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Email verified</span>
                                <span
                                    class="font-medium {{ Auth::user()->hasVerifiedEmail() ? 'text-emerald-700' : 'text-amber-700' }}">
                                    {{ Auth::user()->hasVerifiedEmail() ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('wishlist.index') }}"
                            class="mt-6 inline-flex w-full items-center justify-center px-4 py-2.5 rounded-xl border hover:bg-gray-50">
                            View wishlist
                        </a>
                    </div>
                </aside>

                {{-- Right content --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Profile info --}}
                    <div class="bg-white border rounded-2xl shadow-sm">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-900">Profile</h3>
                            <p class="text-sm text-gray-500 mt-1">Update your name and email address.</p>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="bg-white border rounded-2xl shadow-sm">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-900">Password</h3>
                            <p class="text-sm text-gray-500 mt-1">Use a strong password to keep your account secure.</p>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    {{-- Danger zone --}}
                    <div class="bg-white border border-red-200 rounded-2xl shadow-sm">
                        <div class="p-6 border-b border-red-200">
                            <h3 class="text-lg font-semibold text-red-700">Danger zone</h3>
                            <p class="text-sm text-red-700/80 mt-1">Deleting your account is permanent.</p>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>