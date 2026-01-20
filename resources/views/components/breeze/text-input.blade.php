@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-gray-400 focus:border-purple-600 focus:ring-purple-600 shadow-xs px-2 py-1    ']) }}>
