@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-700 bg-gray-900 text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm']) !!}>{{ $slot }}</textarea>