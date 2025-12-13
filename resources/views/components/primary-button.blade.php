<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-gray-900 text-white font-medium hover:bg-black focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition']) }}>
    {{ $slot }}
</button>