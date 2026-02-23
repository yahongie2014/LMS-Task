<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight uppercase tracking-widest">
            @if ($is_preview)
                {{ __('messages.preview_certificate') }}
            @else
                {{ __('messages.certificate_of_completion') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass dark:bg-gray-900 border-none rounded-[2.5rem] overflow-hidden shadow-2xl p-10 flex flex-col items-center">
                
        @if ($is_preview)
            <div class="mb-8 w-full max-w-4xl p-6 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 dark:border-yellow-600 rounded-2xl flex justify-between items-center print-hidden">
                <div class="flex items-center gap-4 text-yellow-800 dark:text-yellow-200 font-medium">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ __('messages.certificate_disclaimer') }}</span>
                </div>
                <form action="{{ route('certificates.generate', $course->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary text-xs py-3 px-6 shadow-xl shadow-blue-500/20">
                        {{ __('messages.generate_certificate') }}
                    </button>
                </form>
            </div>
        @else
            <div class="mb-8 w-full max-w-4xl flex justify-end gap-4 print-hidden">
                <button onclick="window.print()" class="btn-primary text-xs py-3 px-6 shadow-xl shadow-blue-500/20">
                    {{ __('messages.print_certificate') }}
                </button>
            </div>
        @endif

        <style>
            @media print {
                body { visibility: hidden; }
                .print-hidden { display: none !important; }
                header, nav, footer { display: none !important; }
                #certificate { visibility: visible; position: absolute; left: 0; top: 0; width: 100%; height: 100vh; overflow: hidden; margin: 0; padding: 2rem; border-width: 8px !important; }
                @page { size: landscape; margin: 0cm; }
            }
        </style>

                <!-- Certificate Template -->
                <div id="certificate" class="w-full max-w-4xl bg-white border-[12px] border-double border-gray-200 dark:border-gray-800 p-12 lg:p-20 text-center relative overflow-hidden text-gray-900 shadow-xl dark:shadow-none" style="aspect-ratio: 1.414 / 1;">
                    <!-- Decorations -->
                    <div class="absolute top-0 left-0 w-32 h-32 bg-blue-600/10 rounded-full blur-[50px]"></div>
                    <div class="absolute bottom-0 right-0 w-48 h-48 bg-indigo-600/10 rounded-full blur-[70px]"></div>

                    <div class="relative z-10 w-full h-full border border-gray-100 flex flex-col justify-center items-center py-10 px-6">
                        <div class="mb-8 text-blue-600">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        </div>
                        
                        <h1 class="text-4xl lg:text-5xl font-black uppercase tracking-widest text-gray-900 mb-6 font-serif">
                            {{ __('messages.certificate_of_completion') }}
                        </h1>
                        
                        <p class="text-lg lg:text-xl font-medium text-gray-500 mb-8 italic font-serif">
                            {{ __('messages.this_is_to_certify_that') }}
                        </p>
                        
                        <div class="text-5xl lg:text-6xl font-black text-gray-900 mb-8 pb-2 border-b-4 border-blue-600 inline-block px-10">
                            {{ $user->name }}
                        </div>
                        
                        <p class="text-lg lg:text-xl font-medium text-gray-600 mb-6 flex items-center justify-center gap-2">
                            {{ __('messages.has_successfully_completed') }}
                        </p>
                        
                        <h2 class="text-3xl lg:text-4xl font-black text-blue-600 uppercase tracking-tight mb-16">
                            "{{ $course->title }}"
                        </h2>
                        
                        <div class="flex w-full justify-between items-end mt-auto px-10">
                            <div class="text-center">
                                <div class="text-xl font-bold text-gray-800 mb-2">{{ $date->format('F d, Y') }}</div>
                                <div class="text-sm uppercase tracking-widest text-gray-400 border-t border-gray-300 pt-2 w-40">{{ __('messages.date') }}</div>
                            </div>
                            
                            <!-- A placeholder logo/seal -->
                            <div class="w-32 h-32 rounded-full border-4 border-blue-600 flex items-center justify-center relative rotate-12 opacity-80">
                                <div class="w-full h-full border-2 border-dashed border-blue-600 rounded-full flex items-center justify-center p-2">
                                    <div class="text-[10px] font-black uppercase text-blue-600 tracking-widest text-center leading-none transform -rotate-12">
                                        {{ config('app.name') }}<br>Verified
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <div class="font-signature text-3xl text-gray-800 mb-2">Director Name</div>
                                <div class="text-sm uppercase tracking-widest text-gray-400 border-t border-gray-300 pt-2 w-40">{{ __('messages.signature') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(! $is_preview && isset($certificate))
                    <div class="mt-8 text-sm font-medium text-gray-500 uppercase tracking-widest text-center">
                        {{ __('messages.certificate_id') }}: <span class="text-gray-900 dark:text-white font-black">{{ $certificate->id }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
