<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Precision Learning') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white">
        <div class="fixed top-6 inset-inline-end-6 z-50">
            <livewire:language-switcher />
        </div>
        
        <livewire:intro-popup />

        <!-- Decorative Background Elements -->
        <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
            <div class="fixed -top-24 -left-24 w-[40rem] h-[40rem] bg-blue-500/10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="fixed top-1/2 -right-24 w-[35rem] h-[35rem] bg-purple-500/10 rounded-full blur-[120px]"></div>
            <div class="fixed -bottom-24 left-1/4 w-[30rem] h-[30rem] bg-indigo-500/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative min-h-screen flex flex-col items-center justify-center px-4 z-10">
            <!-- Hero Content -->
            <div class="max-w-4xl text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-8 animate-float">
                    <span class="flex h-2 w-2 rounded-full bg-blue-600 animate-ping"></span>
                    <span class="text-xs font-black text-blue-600 tracking-widest uppercase">{{ __('messages.platform_live') }}</span>
                </div>

                <h1 class="text-6xl md:text-8xl font-black tracking-tighter text-gray-900 dark:text-white mb-8 leading-[0.9]">
                    {!! str_replace(__('messages.future_skills'), '<span class="text-gradient">'.__('messages.future_skills').'</span>', __('messages.hero_title')) !!}
                </h1>

                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 font-medium mb-12 max-w-2xl mx-auto leading-relaxed">
                    {{ __('messages.hero_subtitle') }}
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('home') }}" class="btn-primary text-xl px-12 py-5 shadow-2xl shadow-blue-500/40">
                        {{ __('messages.explore_courses') }}
                        <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="glass px-10 py-5 rounded-2xl font-black text-xl hover:bg-white dark:hover:bg-gray-800 transition-all border-none">
                                {{ __('messages.go_to_dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="glass px-10 py-5 rounded-2xl font-black text-xl hover:bg-white dark:hover:bg-gray-800 transition-all border-none">
                                {{ __('messages.login') }}
                            </a>
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-24 grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-16">
                <div class="text-center group">
                    <div class="text-4xl font-black text-gray-900 dark:text-white mb-1 group-hover:scale-110 transition-transform">10k+</div>
                    <div class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('messages.students') }}</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl font-black text-gray-900 dark:text-white mb-1 group-hover:scale-110 transition-transform">500+</div>
                    <div class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('messages.courses') }}</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl font-black text-gray-900 dark:text-white mb-1 group-hover:scale-110 transition-transform">99%</div>
                    <div class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('messages.success_rate') }}</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl font-black text-gray-900 dark:text-white mb-1 group-hover:scale-110 transition-transform">24/7</div>
                    <div class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('messages.support') }}</div>
                </div>
            </div>
        </div>

        <footer class="py-12 border-t border-gray-100 dark:border-gray-800 text-center">
            <p class="text-sm font-black text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.all_rights_reserved') }}
            </p>
        </footer>
    </body>
</html>

