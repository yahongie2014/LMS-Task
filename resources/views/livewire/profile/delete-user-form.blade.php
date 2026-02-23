<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-10">
    <header class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">
            {{ __('messages.delete_account') }}
        </h2>

        <p class="mt-3 text-lg text-gray-500 dark:text-gray-400 font-medium font-inter">
            {{ __('messages.delete_account_desc') }}
        </p>
    </header>

    <x-danger-button
        class="py-4 px-10"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('messages.delete_account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-10 bg-white dark:bg-gray-900 !rounded-[2.5rem]">

            <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-4 tracking-tighter leading-none">
                {{ __('messages.delete_confirm') }}
            </h2>

            <p class="mt-4 text-gray-500 dark:text-gray-400 font-medium leading-relaxed font-inter mb-10">
                {{ __('messages.delete_confirm_desc') }}
            </p>

            <div class="mt-10">
                <x-input-label for="password" value="{{ __('messages.password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('messages.password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-12 flex justify-end gap-6">
                <button type="button" class="px-8 py-3 text-sm font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-all" x-on:click="$dispatch('close')">
                    {{ __('messages.cancel') }}
                </button>

                <x-danger-button class="py-4 px-10">
                    {{ __('messages.delete_account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
