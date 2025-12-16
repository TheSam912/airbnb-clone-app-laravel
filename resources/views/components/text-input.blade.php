@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'w-full dark:bg-gray-100 rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500'
]) !!}>