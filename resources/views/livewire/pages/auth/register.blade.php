<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ __('messages.create_account') }}</h2>
        <p class="text-gray-500 font-medium text-sm">{{ __('messages.join_community_desc') ?? 'Start your learning journey today.' }}</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('messages.full_name')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-1" />
            <x-text-input wire:model="name" id="name" class="block w-full" type="text" name="name" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('messages.email')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-1" />
            <x-text-input wire:model="email" id="email" class="block w-full" type="email" name="email" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('messages.password')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-1" />
            <x-text-input wire:model="password" id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('messages.confirm_password')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-1" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4 pt-2">
            <x-primary-button class="w-full justify-center text-base py-4 shadow-xl shadow-blue-500/20">
                {{ __('messages.register') }}
            </x-primary-button>

            <div class="relative py-2">
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

            <div class="text-center">
                <a class="text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors" href="{{ route('login') }}" wire:navigate>
                    {{ __('messages.already_registered') }}
                </a>
            </div>
        </div>
    </form>
</div>
