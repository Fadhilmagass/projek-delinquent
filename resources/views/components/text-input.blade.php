@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'bg-gray-900/50 border-gray-700 text-gray-300 placeholder-gray-500 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full transition duration-150',
]) !!}>
