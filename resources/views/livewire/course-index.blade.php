<div class="max-w-7xl mx-auto py-20 px-4 sm:px-6 lg:px-8">
    <div class="mb-20 text-center relative">
        <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-40 h-40 bg-blue-500/5 blur-[100px] rounded-full"></div>
        
        <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 border-none">
            <span class="text-[10px] font-black text-blue-600 tracking-[0.2em] uppercase">{{ __('messages.explore_courses') }}</span>
        </div>

        <h1 class="text-6xl md:text-7xl font-black tracking-tighter text-gray-900 dark:text-white mb-6 leading-tight">
            {{ __('messages.expand_knowledge') }}
        </h1>
        <p class="max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400 font-medium leading-relaxed font-inter">
            {{ __('messages.hero_subtitle') }}
        </p>

        <div class="mt-12 flex flex-wrap justify-center gap-8 md:gap-16 border-t border-gray-100 dark:border-gray-800 pt-12">
            <div class="text-center">
                <div class="text-3xl font-black text-gray-900 dark:text-white mb-1">{{ $courses->count() }}</div>
                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('messages.courses') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-black text-gray-900 dark:text-white mb-1">10k+</div>
                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('messages.students') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-black text-gray-900 dark:text-white mb-1">24/7</div>
                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('messages.support') }}</div>
            </div>
        </div>
    </div>

    <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($courses as $course)
        <div class="card-modern group hover:scale-[1.02] transition-all duration-500">
            <a href="{{ route('courses.show', $course->slug) }}" class="block h-full flex flex-col">
                <div class="relative h-64 overflow-hidden shrink-0">
                    @if($course->image)
                        <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="{{ str_starts_with($course->image, 'http') ? $course->image : \Illuminate\Support\Facades\Storage::url($course->image) }}" alt="{{ $course->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center transition-transform duration-1000 group-hover:scale-110">
                            <span class="text-white/20 font-black text-[8rem] absolute -bottom-10 -right-10 select-none">{{ substr($course->title, 0, 1) }}</span>
                            <span class="text-white font-black text-4xl uppercase tracking-tighter relative z-10">{{ substr($course->title, 0, 2) }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute top-6 left-6 z-20">
                        <span class="glass px-4 py-1.5 rounded-2xl text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest shadow-xl border-none">
                            {{ __('messages.' . strtolower($course->level)) ?? $course->level }}
                        </span>
                    </div>

                    <div class="absolute bottom-6 left-6 right-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 z-20">
                        <span class="btn-primary text-[10px] py-4 px-6 w-full">{{ __('messages.explore_course') }}</span>
                    </div>
                </div>
                <div class="p-10 flex-grow flex flex-col">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex -space-x-2">
                            <div class="w-6 h-6 rounded-full bg-blue-500 border-2 border-white dark:border-gray-900 shadow-sm"></div>
                            <div class="w-6 h-6 rounded-full bg-purple-500 border-2 border-white dark:border-gray-900 shadow-sm"></div>
                            <div class="w-6 h-6 rounded-full bg-indigo-500 border-2 border-white dark:border-gray-900 shadow-sm"></div>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('messages.enrolled_students') }}</span>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4 leading-tight group-hover:text-blue-600 transition-colors uppercase tracking-tighter">{{ $course->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium line-clamp-3 leading-relaxed mb-8 flex-grow">
                        {{ $course->description }}
                    </p>
                    <div class="flex items-center justify-between pt-8 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center text-xs font-black text-gray-400 uppercase tracking-[0.1em]">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $course->lessons->count() }} {{ __('messages.lessons') }}
                        </div>
                        <div class="text-blue-600">
                             <svg class="w-5 h-5 transform group-hover:translate-x-2 rtl:group-hover:-translate-x-2 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
