<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@isset($title) {{ $title }} | @endisset {{ config('app.name', 'Precision Learning') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white">
        <div class="fixed top-6 right-6 z-50">
            <livewire:language-switcher />
        </div>

        <livewire:intro-popup />

        <!-- Decorative Background Elements -->
        <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
            <div class="fixed -top-24 -left-24 w-[32rem] h-[32rem] bg-blue-500/10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="fixed top-1/2 -right-24 w-96 h-96 bg-purple-500/10 rounded-full blur-[120px]"></div>
            <div class="fixed -bottom-24 left-1/2 w-[30rem] h-[30rem] bg-indigo-500/10 rounded-full blur-[120px] -translate-x-1/2"></div>
        </div>

        <div class="min-h-screen relative z-10 flex flex-col">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="glass sticky top-20 z-30 mx-4 mt-4 rounded-3xl border-none">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <footer class="py-12 text-center text-xs font-black text-gray-400 uppercase tracking-widest border-t border-gray-100 dark:border-gray-800 bg-white/30 backdrop-blur-sm">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.all_rights_reserved') }} -  <a href="https://github.com/yahongie2014/LMS-Task" target="_blank">Github</a>
            </footer>
        </div>
    </body>
</html>
