<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">
            {{ __('messages.profile_info') }}
        </h2>

        <p class="mt-3 text-lg text-gray-500 dark:text-gray-400 font-medium font-inter">
            {{ __('messages.profile_info_desc') }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-10 space-y-8">
        <div>
            <x-input-label for="name" :value="__('messages.name')" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2 block" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('messages.email')" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2 block" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-4 p-4 glass bg-orange-50/50 dark:bg-orange-900/10 border-orange-200 dark:border-orange-800 rounded-2xl">
                    <p class="text-sm text-gray-800 dark:text-gray-200 font-bold">
                        {{ __('messages.unverified_email') }}

                        <button wire:click.prevent="sendVerification" class="underline text-orange-600 hover:text-orange-700 font-black ml-2 uppercase tracking-tight">
                            {{ __('messages.resend_verification') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-black text-xs text-green-600 uppercase tracking-widest">
                            {{ __('messages.verification_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-4">
            <x-primary-button class="py-4 px-12">{{ __('messages.save') }}</x-primary-button>

            <x-action-message class="font-black text-xs text-green-600 uppercase tracking-widest" on="profile-updated">
                {{ __('messages.saved') }}
            </x-action-message>
        </div>
    </form>
</section>
