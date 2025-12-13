<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $listing->title }}</h1>
                <div class="text-sm text-gray-600 mt-1">
                    {{ $listing->city }}, {{ strtoupper($listing->country) }}
                    <span class="text-gray-300 mx-2">•</span>
                    Hosted by {{ $listing->host->name }}
                </div>
            </div>

            {{-- Photo grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($listing->photos as $photo)
                    <div class="bg-gray-100 rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-56 object-cover" alt="">
                    </div>
                @endforeach
            </div>
            <div x-data="gallery({{ $listing->photos->pluck('path')->values()->toJson() }})">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-white border rounded-xl p-6 space-y-4">
                    <div class="text-gray-700 whitespace-pre-line">{{ $listing->description }}</div>

                    <div class="text-sm text-gray-700">
                        <span class="font-medium">Capacity:</span>
                        {{ $listing->max_guests }} guests ·
                        {{ $listing->bedrooms }} bedrooms ·
                        {{ $listing->beds }} beds ·
                        {{ $listing->bathrooms }} bathrooms
                    </div>

                    <div>
                        <div class="font-medium text-gray-900 mb-2">Amenities</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($listing->amenities as $amenity)
                                <span class="text-xs px-2 py-1 rounded-full border bg-gray-50">
                                    {{ $amenity->name }}
                                </span>
                            @endforeach
                            @if($listing->amenities->isEmpty())
                                <span class="text-sm text-gray-500">No amenities listed.</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Price card (booking UI comes next) --}}
                <div class="bg-white border rounded-xl p-6 space-y-4 h-fit lg:sticky lg:top-6">
                    <div class="text-xl font-bold">
                        {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }}
                        <span class="text-sm font-normal text-gray-500">/ night</span>
                    </div>

                    @if (session('status'))
                        <div class="p-3 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store', $listing) }}" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium mb-1">Check-in</label>
                            <input id="check_in" type="date" name="check_in" value="{{ old('check_in') }}"
                                class="w-full rounded border-gray-300">
                            @error('check_in') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Check-out</label>
                            <input id="check_out" type="date" name="check_out" value="{{ old('check_out') }}"
                                class="w-full rounded border-gray-300">
                            @error('check_out') <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Guests</label>
                            <input id="guests" type="number" name="guests" min="1" max="{{ $listing->max_guests }}"
                                value="{{ old('guests', 1) }}" class="w-full rounded border-gray-300">
                            @error('guests') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div id="priceBox" class="hidden text-sm border-t pt-3 space-y-2">
                            <div class="flex justify-between">
                                <span>{{ $listing->currency }}
                                    {{ number_format($listing->price_per_night / 100, 2) }} × <span id="nights">0</span>
                                    nights</span>
                                <span id="subtotalText">—</span>
                            </div>
                            <div class="flex justify-between font-semibold">
                                <span>Total</span>
                                <span id="totalText">—</span>
                            </div>
                        </div>

                        <div id="availabilityBox" class="hidden text-sm rounded-lg border p-3"></div>
                        <button id="reserveBtn"
                            class="w-full px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            Reserve
                        </button>

                        <p class="text-xs text-gray-500 text-center">
                            You won’t be charged — payments later.
                        </p>
                    </form>
                </div>

                <a href="{{ route('listings.index') }}"
                    class="inline-flex justify-center w-full px-4 py-2 rounded-lg border hover:bg-gray-50">
                    Back to listings
                </a>
            </div>
        </div>
    </div>
    <script>
        (function () {
            const pricePerNightCents = {{ (int) $listing->price_per_night }};
            const currency = @json($listing->currency);

            const checkIn = document.getElementById('check_in');
            const checkOut = document.getElementById('check_out');

            const priceBox = document.getElementById('priceBox');
            const nightsEl = document.getElementById('nights');
            const subtotalText = document.getElementById('subtotalText');
            const totalText = document.getElementById('totalText');

            function fmt(cents) {
                return `${currency} ${(cents / 100).toFixed(2)}`;
            }

            // Convert "YYYY-MM-DD" -> UTC timestamp at midnight
            function toUtcMidnight(dateStr) {
                const [y, m, d] = dateStr.split('-').map(Number);
                return Date.UTC(y, m - 1, d);
            }

            function calc() {
                if (!checkIn.value || !checkOut.value) {
                    priceBox.classList.add('hidden');
                    return;
                }

                const inUtc = toUtcMidnight(checkIn.value);
                const outUtc = toUtcMidnight(checkOut.value);

                const nights = Math.round((outUtc - inUtc) / 86400000); // 1000*60*60*24

                if (!Number.isFinite(nights) || nights <= 0) {
                    priceBox.classList.add('hidden');
                    return;
                }

                const subtotal = nights * pricePerNightCents;

                nightsEl.textContent = nights;
                subtotalText.textContent = fmt(subtotal);
                totalText.textContent = fmt(subtotal);
                priceBox.classList.remove('hidden');
            }

            checkIn.addEventListener('input', calc);
            checkOut.addEventListener('input', calc);
            calc();
        })();
    </script>
    <script>
        (function () {
            const checkIn = document.getElementById('check_in');
            const checkOut = document.getElementById('check_out');
            const guests = document.getElementById('guests');

            const box = document.getElementById('availabilityBox');
            const btn = document.getElementById('reserveBtn');

            const urlBase = @json(route('listings.availability', $listing));

            let timer = null;

            function setBox(type, text) {
                box.classList.remove('hidden');
                box.className = 'text-sm rounded-lg border p-3';
                if (type === 'ok') box.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-800');
                if (type === 'bad') box.classList.add('bg-red-50', 'border-red-200', 'text-red-800');
                if (type === 'info') box.classList.add('bg-gray-50', 'border-gray-200', 'text-gray-700');
                box.textContent = text;
            }

            function disableReserve(disabled) {
                btn.disabled = !!disabled;
            }

            async function checkAvailability() {
                if (!checkIn.value || !checkOut.value) {
                    box.classList.add('hidden');
                    disableReserve(false);
                    return;
                }

                setBox('info', 'Checking availability…');
                disableReserve(true);

                const qs = new URLSearchParams({
                    check_in: checkIn.value,
                    check_out: checkOut.value,
                    guests: guests?.value || '1',
                });

                try {
                    const res = await fetch(urlBase + '?' + qs.toString(), {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!res.ok) {
                        setBox('bad', 'Not available for these dates.');
                        disableReserve(true);
                        return;
                    }

                    const data = await res.json();

                    if (data.available) {
                        setBox('ok', 'Available ✅');
                        disableReserve(false);
                    } else {
                        if (data.reason === 'too_many_guests') {
                            setBox('bad', 'Too many guests for this listing.');
                        } else {
                            setBox('bad', 'Not available for these dates.');
                        }
                        disableReserve(true);
                    }
                } catch (e) {
                    setBox('bad', 'Could not check availability. Try again.');
                    disableReserve(true);
                }
            }

            function scheduleCheck() {
                clearTimeout(timer);
                timer = setTimeout(checkAvailability, 300);
            }

            checkIn?.addEventListener('input', scheduleCheck);
            checkOut?.addEventListener('input', scheduleCheck);
            guests?.addEventListener('input', scheduleCheck);
        })();
    </script>
</x-app-layout>