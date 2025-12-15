<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Create your listing</h2>
                <p class="text-sm text-gray-500 mt-1">Step {{ $step }} of 5</p>
            </div>

            <a href="{{ route('host.listings.index') }}" class="px-4 py-2 rounded-xl border hover:bg-gray-50">
                Exit
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Progress bar --}}
            <div class="bg-white border rounded-2xl p-4">
                <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-2 bg-red-600" style="width: {{ ($step / 5) * 100 }}%"></div>
                </div>
            </div>

            <div class="bg-white border rounded-2xl p-6 shadow-sm">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>