<?php

use App\Services\AuthService;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $phone = '';
    public string $otp = '';
    public string $type = 'user'; // user or instructor
    public bool $otpSent = false;
    public ?string $generatedOtp = null; // Show only in debug mode

    /**
     * Send OTP to the provided phone number.
     */
    public function sendOtp(AuthRepositoryInterface $authRepository, AuthService $authService): void
    {
        $this->validate([
            'phone' => ['required', 'string', 'size:12'],
            'type' => ['required', 'in:user,instructor'],
        ]);

        $model = $authRepository->findByPhone($this->phone, $this->type);
        $isNew = false;

        if (!$model) {
            $isNew = true;
            // Register-on-the-fly
            $model = $authRepository->register([
                'name' => 'User ' . substr($this->phone, -4),
                'email' => $this->phone . '@phone.com',
                'phone' => $this->phone,
                'password' => 'password',
                'type' => $this->type,
            ]);
        }

        $otpCode = $authService->generateOtp($this->phone, $model, $isNew);
        
        if (config('app.debug')) {
            $this->generatedOtp = (string)$otpCode;
        }

        $this->otpSent = true;
        $this->dispatch('notify', message: __('messages.otp_sent_successfully'));
    }

    /**
     * Verify OTP and authenticate the user.
     */
    public function verifyOtp(AuthRepositoryInterface $authRepository, AuthService $authService): void
    {
        $this->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $otpRecord = $authService->verifyOtp($this->phone, $this->otp);

        if (!$otpRecord) {
            $this->addError('otp', __('messages.invalid_otp'));
            return;
        }

        $model = $authRepository->findByPhone($this->phone, $this->type);

        if (!$model) {
            $this->addError('phone', __('messages.user_not_found'));
            return;
        }

        Auth::guard($this->type === 'instructor' ? 'instructor_session' : 'web')->login($model);
        
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Reset the form to enter a different phone number.
     */
    public function resetForm(): void
    {
        $this->otpSent = false;
        $this->otp = '';
        $this->generatedOtp = null;
    }
}; ?>

<div class="w-full">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-2">
            {{ $otpSent ? __('messages.verify_otp') : __('messages.login_with_phone') }}
        </h2>
        <p class="text-gray-500 font-medium text-sm">
            {{ $otpSent ? __('messages.enter_otp_sent_to', ['phone' => $phone]) : __('messages.enter_phone_to_continue') }}
        </p>
    </div>

    @if (!$otpSent)
        <form wire:submit="sendOtp" class="space-y-6">
            <!-- Account Type -->
            <div>
                <x-input-label :value="__('messages.account_type')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-2" />
                <div class="grid grid-cols-2 gap-4">
                    <button type="button" 
                            wire:click="$set('type', 'user')"
                            class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 transition-all {{ $type === 'user' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-100 bg-gray-50 text-gray-500 hover:border-gray-200' }}">
                        <span class="text-sm font-black">{{ __('messages.student') }}</span>
                    </button>
                    <button type="button" 
                            wire:click="$set('type', 'instructor')"
                            class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 transition-all {{ $type === 'instructor' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-100 bg-gray-50 text-gray-500 hover:border-gray-200' }}">
                        <span class="text-sm font-black">{{ __('messages.instructor') }}</span>
                    </button>
                </div>
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone" :value="__('messages.phone')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-1" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 font-bold">
                        +
                    </div>
                    <x-text-input wire:model="phone" id="phone" class="block w-full pl-8" type="text" name="phone" required autofocus placeholder="9665XXXXXXXX" />
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                <p class="mt-2 text-xs text-gray-400">{{ __('messages.phone_hint') ?? 'Enter 12 digits (e.g. 966512345678)' }}</p>
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center text-base py-4 shadow-xl shadow-blue-500/20">
                    {{ __('messages.send_otp') }}
                </x-primary-button>
            </div>
        </form>
    @else
        <form wire:submit="verifyOtp" class="space-y-6">
            <!-- OTP -->
            <div>
                <x-input-label for="otp" :value="__('messages.otp')" class="text-xs uppercase tracking-widest font-black text-gray-400 mb-1" />
                <x-text-input wire:model="otp" id="otp" class="block w-full text-center text-2xl tracking-[1em] font-black" type="text" name="otp" required autofocus maxlength="6" placeholder="000000" />
                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                
                @if ($generatedOtp)
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-100 rounded-xl text-yellow-700 text-sm font-bold animate-pulse">
                        Debug OTP: {{ $generatedOtp }}
                    </div>
                @endif
            </div>

            <div class="pt-2 space-y-4">
                <x-primary-button class="w-full justify-center text-base py-4 shadow-xl shadow-blue-500/20">
                    {{ __('messages.verify_otp') }}
                </x-primary-button>

                <button type="button" wire:click="resetForm" class="w-full text-center text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
                    {{ __('messages.change_phone_number') }}
                </button>
            </div>
        </form>
    @endif

    <div class="mt-8 pt-8 border-t border-gray-100 text-center">
        <a class="text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors" href="{{ route('login') }}" wire:navigate>
            {{ __('messages.back_to_login') ?? 'Back to Email Login' }}
        </a>
    </div>
</div>
