<div class="glass p-1.5 rounded-full flex items-center shadow-2xl border-white/40 dark:border-gray-700/50">
    <button wire:click="switchLanguage('en')" 
        class="px-4 py-1.5 rounded-full text-xs font-black transition-all duration-300 {{ app()->getLocale() == 'en' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white' }}">
        EN
    </button>
    <button wire:click="switchLanguage('ar')" 
        class="px-4 py-1.5 rounded-full text-xs font-black transition-all duration-300 {{ app()->getLocale() == 'ar' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white' }}">
        AR
    </button>
</div>

