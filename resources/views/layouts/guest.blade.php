<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'LMS') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased overflow-x-hidden">
        <div class="fixed top-6 right-6 z-50">
            <livewire:language-switcher />
        </div>

        <!-- Decorative Background Elements -->
        <div class="fixed -top-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="fixed bottom-0 -right-24 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-12 sm:pt-0 bg-[#fefefe] dark:bg-[#0b0f1a] px-4 selection:bg-blue-100 selection:text-blue-900">
            <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-blue-600 dark:text-blue-400" />
                </a>
            </div>

            <div class="w-full sm:max-w-md card-modern overflow-hidden p-8 md:p-12 mb-12">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
