@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white text-black px-3 py-2 focus:bg-purple-600 focus:text-white']) }}>
