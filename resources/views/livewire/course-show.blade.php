<div class="max-w-7xl mx-auto py-20 px-4 sm:px-6 lg:px-8">
    <!-- Course Header Card -->
    <div class="card-modern mb-16 relative overflow-hidden p-[1px] bg-gradient-to-br from-blue-500/20 via-transparent to-purple-500/20 shadow-none">
        <div class="bg-white/40 dark:bg-gray-900/40 backdrop-blur-3xl rounded-[2.8rem] overflow-hidden relative">
            <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-blue-500/10 rounded-full -mr-40 -mt-40 blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/10 rounded-full -ml-40 -mb-40 blur-[100px]"></div>
            
            <div class="relative p-12 md:p-20">
                <div class="flex flex-wrap items-center gap-6 mb-10">
                    <span class="glass px-6 py-2 rounded-2xl text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-[0.2em] shadow-xl border-none">
                        {{ __('messages.' . strtolower($course->level)) ?? $course->level }}
                    </span>
                    <span class="flex items-center text-xs font-black text-gray-400 uppercase tracking-widest gap-2">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $course->lessons->count() }} {{ __('messages.lessons') }}
                    </span>
                </div>

                <h1 class="text-6xl md:text-8xl font-black text-gray-900 dark:text-white mb-10 tracking-tighter leading-[0.85] uppercase">
                    {{ $course->title }}
                </h1>
                
                @if(session()->has('message'))
                    <div class="glass border-green-500/30 bg-green-50/50 dark:bg-green-900/20 mb-12 p-6 rounded-[2rem] flex items-center gap-4 text-green-700 dark:text-green-300 animate-float">
                        <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white shadow-lg shadow-green-500/20">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="font-bold text-lg">{{ session('message') }}</span>
                    </div>
                @endif

                <p class="text-xl md:text-2xl text-gray-500 dark:text-gray-400 mb-14 max-w-4xl leading-relaxed font-inter font-medium">
                    {{ $course->description }}
                </p>

                <div class="flex flex-col md:flex-row items-start md:items-center gap-8">
                    @if(!$isEnrolled)
                        <button wire:click="enroll" class="btn-primary text-xl px-14 py-6 shadow-2xl shadow-blue-500/40 group relative overflow-hidden">
                            <span class="relative z-10">
                                {{ __('messages.enroll_now') }} - {{ $course->price }} {{ \App\Models\Setting::getValue('currency', '$') }}
                            </span>
                            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </button>
                    @else
                        <div class="inline-flex items-center px-12 py-6 glass border-green-500/30 rounded-3xl text-green-600 dark:text-green-400 font-black text-xl shadow-2xl shadow-green-500/10 gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            {{ __('messages.enrolled') }}
                        </div>
                    @endif
                    
                    <div class="flex items-center gap-6 md:ml-auto glass px-8 py-4 rounded-3xl border-none">
                         <div class="flex -space-x-3">
                            <img class="w-12 h-12 rounded-full border-4 border-white dark:border-gray-900 object-cover" src="https://i.pravatar.cc/150?u=1" alt="">
                            <img class="w-12 h-12 rounded-full border-4 border-white dark:border-gray-900 object-cover" src="https://i.pravatar.cc/150?u=2" alt="">
                            <img class="w-12 h-12 rounded-full border-4 border-white dark:border-gray-900 object-cover" src="https://i.pravatar.cc/150?u=3" alt="">
                         </div>
                         <div class="text-xs font-black text-gray-800 dark:text-gray-200 uppercase tracking-[0.2em]">+ 1,240 {{ __('messages.students') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content Accordion -->
    <div class="grid lg:grid-cols-3 gap-12" x-data="{ expandedIndex: 0 }">
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter uppercase">
                    {{ __('messages.course_content') }}
                </h2>
            </div>
            
            <div class="space-y-6">
                @forelse($course->lessons as $index => $lesson)
                    <div class="card-modern !rounded-[2.5rem] border-none shadow-xl shadow-gray-200/10 dark:shadow-none bg-white/60 dark:bg-gray-900/60">
                        <button @click="expandedIndex = expandedIndex === {{ $index }} ? null : {{ $index }}" 
                            class="w-full flex items-center justify-between p-10 hover:bg-white dark:hover:bg-gray-800 transition-all focus:outline-none group">
                            <div class="flex items-center gap-10">
                                <div class="w-16 h-16 rounded-[1.5rem] glass flex items-center justify-center font-black text-2xl text-blue-600 dark:text-blue-400 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 shadow-xl border-none">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="text-left rtl:text-right">
                                    @if($lesson->is_preview)
                                        <span class="inline-block px-3 py-1 text-[10px] font-black bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded-lg mb-3 uppercase tracking-widest">{{ __('messages.free_preview') }}</span>
                                    @endif
                                    <h3 class="text-2xl font-black text-gray-900 dark:text-white leading-tight group-hover:text-blue-600 transition-colors uppercase tracking-tight">{{ $lesson->title }}</h3>
                                </div>
                            </div>
                            <div class="w-14 h-14 rounded-full glass flex items-center justify-center transition-all duration-500 border-none shrink-0" :class="{ 'bg-blue-600 !shadow-blue-500/50 shadow-2xl': expandedIndex === {{ $index }} }">
                                <svg class="h-6 w-6 transition-all duration-500" :class="{ 'rotate-180 text-white': expandedIndex === {{ $index }}, 'text-gray-300': expandedIndex !== {{ $index }} }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="expandedIndex === {{ $index }}" x-collapse x-cloak>
                            <div class="px-10 pb-12 pt-4 max-w-4xl">
                                <div class="h-[3px] w-16 bg-blue-600 mb-10 rounded-full"></div>
                                <p class="text-xl text-gray-500 dark:text-gray-400 mb-12 font-medium leading-relaxed font-inter">{{ $lesson->description }}</p>
                                <div class="flex">
                                    @if($isEnrolled || $lesson->is_preview)
                                        <a href="{{ route('lessons.show', [$course->slug, $lesson->id]) }}" class="btn-primary py-4 px-12 text-sm">
                                            {{ __('messages.go_to_lesson') }}
                                            <svg class="w-5 h-5 ml-3 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    @else
                                        <div class="flex items-center gap-5 px-10 py-5 glass rounded-[2rem] text-gray-400 border-none shadow-inner bg-gray-50/50 dark:bg-gray-800/20">
                                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            <span class="font-black text-xs uppercase tracking-[0.2em]">{{ __('messages.unlock_lesson') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-32 glass rounded-[3rem] border-none shadow-2xl">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-8">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <p class="text-2xl font-black text-gray-400 uppercase tracking-widest">{{ __('messages.no_lessons') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-10">
             <div class="card-modern p-12 bg-blue-600 !rounded-[3rem] shadow-2xl shadow-blue-600/40 relative overflow-hidden group border-none">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -mr-16 -mt-16 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <h3 class="text-3xl font-black text-white mb-8 leading-tight relative z-10 tracking-tight">{{ __('messages.master_with_experts') }}</h3>
                <p class="text-blue-100 text-lg mb-12 font-medium relative z-10 leading-relaxed font-inter">{{ __('messages.certification_desc') }}</p>
                <div class="relative z-10">
                    <button class="w-full py-5 glass bg-white/20 border-white/30 rounded-2xl text-[10px] font-black text-white uppercase tracking-[0.2em] hover:bg-white/30 transition-all">{{ __('messages.view_certification') }}</button>
                </div>
            </div>

            <div class="card-modern p-12 !rounded-[3rem] bg-white dark:bg-gray-900 border-none shadow-xl shadow-gray-200/20 dark:shadow-none">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-10 border-b border-gray-100 dark:border-gray-800 pb-8 uppercase tracking-tighter">{{ __('messages.course_features') }}</h3>
                <div class="space-y-8">
                    <div class="flex items-center gap-6 group">
                        <div class="w-12 h-12 rounded-2xl bg-green-500/10 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-lg font-black text-gray-700 dark:text-gray-300 tracking-tight">{{ __('messages.lifetime_access') }}</span>
                    </div>
                    <div class="flex items-center gap-6 group">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-all duration-500">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-lg font-black text-gray-700 dark:text-gray-300 tracking-tight">{{ __('messages.self_paced') }}</span>
                    </div>
                    <div class="flex items-center gap-6 group">
                        <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-all duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-lg font-black text-gray-700 dark:text-gray-300 tracking-tight">{{ __('messages.verified_certificate') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
