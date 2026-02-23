@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-2xl shadow-sm transition-all duration-300 py-3.5 px-5 text-gray-900 dark:text-white font-medium']) }}>
