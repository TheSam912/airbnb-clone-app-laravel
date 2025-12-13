<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Listing</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('host.listings.store') }}" class="space-y-6">
                    @csrf
                    @include('host.listings.form', ['listing' => null, 'amenities' => $amenities])

                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded bg-gray-900 text-white">Create</button>
                        <a class="px-4 py-2 rounded border" href="{{ route('host.listings.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>