<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ __('messages.login') }}</h2>
        <p class="text-gray-500 font-medium text-sm">{{ __('messages.welcome_message') }}</p>
    </div>

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('messages.email')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-1" />
            <x-text-input wire:model="form.email" id="email" class="block w-full" type="email" name="email" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('messages.password')" class="text-xs uppercase tracking-widest font-black text-gray-400" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('messages.forgot_password') }}
                    </a>
                @endif
            </div>

            <x-text-input wire:model="form.password" id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-lg border-gray-200 text-blue-600 shadow-sm focus:ring-4 focus:ring-blue-500/10 w-5 h-5 transition-all" name="remember">
                <span class="ms-3 text-sm font-bold text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('messages.remember_me') }}</span>
            </label>
        </div>

        <div class="pt-2 space-y-4">
            <x-primary-button class="w-full justify-center text-base py-4 shadow-xl shadow-blue-500/20">
                {{ __('messages.login') }}
            </x-primary-button>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-white px-2 text-gray-400 font-bold tracking-widest">{{ __('messages.or_continue_with') ?? 'Or' }}</span>
                </div>
            </div>

            <a href="{{ route('login.phone') }}" wire:navigate class="w-full inline-flex justify-center items-center px-4 py-4 bg-gray-50 border-2 border-transparent rounded-2xl font-black text-sm text-gray-600 uppercase tracking-widest hover:bg-gray-100 hover:text-blue-600 active:bg-gray-200 transition-all duration-200">
                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                {{ __('messages.login_with_phone') }}
            </a>
        </div>
    </form>
</div>
