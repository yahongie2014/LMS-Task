<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">
            {{ __('messages.update_password') }}
        </h2>

        <p class="mt-3 text-lg text-gray-500 dark:text-gray-400 font-medium font-inter">
            {{ __('messages.update_password_desc') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-10 space-y-8">
        <div>
            <x-input-label for="update_password_current_password" :value="__('messages.current_password')" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2 block" />
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('messages.new_password')" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2 block" />
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('messages.confirm_password')" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2 block" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-6 pt-4">
            <x-primary-button class="py-4 px-12">{{ __('messages.save') }}</x-primary-button>

            <x-action-message class="font-black text-xs text-green-600 uppercase tracking-widest" on="password-updated">
                {{ __('messages.saved') }}
            </x-action-message>
        </div>
    </form>
</section>
