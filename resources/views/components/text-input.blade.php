@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#1a1a1a] border-gray-700 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm placeholder-gray-500']) }}>
