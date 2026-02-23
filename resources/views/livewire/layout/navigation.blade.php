<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="sticky top-0 z-40 glass border-none shadow-sm dark:bg-gray-900/80">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" wire:navigate class="transition-transform duration-300 hover:scale-105">
                        <x-application-logo class="block h-10 w-auto fill-current text-blue-600 dark:text-blue-400" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex rtl:space-x-reverse rtl:ms-0 rtl:me-10 items-center">
                    <a href="{{ route('home') }}" wire:navigate class="nav-link-modern {{ request()->routeIs('home') ? 'text-blue-600 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                        {{ __('messages.courses') }}
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate class="nav-link-modern {{ request()->routeIs('dashboard') ? 'text-blue-600 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ __('messages.dashboard') }}
                        </a>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 rtl:ms-0 rtl:me-6 gap-4">
                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown align="{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 glass rounded-2xl text-sm font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 transition duration-300 focus:outline-none">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate class="rounded-t-xl">
                                {{ __('messages.profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start rtl:text-right">
                                <x-dropdown-link class="rounded-b-xl text-red-600">
                                    {{ __('messages.logout') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-blue-600 px-4 py-2 transition-colors">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="btn-primary py-2 px-6 rounded-xl text-sm leading-none">
                        {{ __('messages.register') }}
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden rtl:me-0 rtl:-ms-2">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl glass text-gray-400 hover:text-blue-600 transition duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100 dark:border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                {{ __('messages.courses') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('messages.dashboard') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-100 dark:border-gray-800">
                <div class="px-4 rtl:text-right">
                    <div class="font-bold text-base text-gray-800 dark:text-gray-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('messages.profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start rtl:text-right">
                        <x-responsive-nav-link class="text-red-600">
                            {{ __('messages.logout') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-100 dark:border-gray-800 px-4 flex flex-col gap-2">
                <a href="{{ route('login') }}" class="block w-full text-center py-3 glass rounded-2xl font-bold text-gray-700 dark:text-gray-300">
                    {{ __('messages.login') }}
                </a>
                <a href="{{ route('register') }}" class="btn-primary w-full py-3">
                    {{ __('messages.register') }}
                </a>
            </div>
        @endauth
    </div>
</nav>

