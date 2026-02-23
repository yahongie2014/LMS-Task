<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Forbidden') }} - {{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white">
        <!-- Decorative Background Elements -->
        <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
            <div class="fixed -top-24 -left-24 w-[32rem] h-[32rem] bg-red-500/10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="fixed top-1/2 -right-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative min-h-screen flex flex-col items-center justify-center px-4 z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-8 animate-float">
                <span class="flex h-2 w-2 rounded-full bg-red-600"></span>
                <span class="text-xs font-black text-red-600 tracking-widest uppercase">{{ __('messages.security_alert') }}</span>
            </div>

            <h1 class="text-[10rem] md:text-[15rem] font-black tracking-tighter text-gray-900 dark:text-white leading-none opacity-10 select-none">
                403
            </h1>

            <div class="max-w-xl -mt-20 md:-mt-32">
                <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">
                    <span class="text-gradient">{{ __('messages.access_forbidden') }}</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 font-medium mb-12 leading-relaxed">
                    {{ $exception->getMessage() ?: "Sorry, but you don't have permission to access this page. Please contact your instructor if you believe this is an error." }}
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ url()->previous() }}" class="btn-primary px-10 py-4 shadow-xl shadow-blue-500/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        {{ __('messages.go_back') }}
                    </a>
                    <a href="{{ route('home') }}" class="glass px-10 py-4 rounded-2xl font-black hover:bg-white dark:hover:bg-gray-800 transition-all">
                        {{ __('messages.back_to_home') }}
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
