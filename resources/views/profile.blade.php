<x-app-layout>
    <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
        <div class="mb-20">
            <h1 class="text-6xl font-black tracking-tighter text-gray-900 dark:text-white mb-6 uppercase">
                {{ __('messages.profile_settings') }}
            </h1>
            <p class="text-xl text-gray-500 dark:text-gray-400 font-medium font-inter leading-relaxed max-w-2xl">
                {{ __('messages.profile_subtitle') }}
            </p>
        </div>

        <div class="space-y-12">
            <div class="card-high-contrast overflow-hidden">
                <div class="p-10 md:p-16">
                    <div class="max-w-3xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>
            </div>

            <div class="card-high-contrast overflow-hidden">
                <div class="p-10 md:p-16">
                    <div class="max-w-3xl">
                        <livewire:profile.update-password-form />
                    </div>
                </div>
            </div>

            <div class="rounded-[2.5rem] border-2 border-red-100 dark:border-red-900/30 bg-red-50/50 dark:bg-red-950/10 overflow-hidden">
                <div class="p-10 md:p-16">
                    <div class="max-w-3xl text-left rtl:text-right">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
