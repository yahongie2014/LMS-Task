<div class="max-w-7xl mx-auto py-20 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-16">
        <h1 class="text-6xl font-black tracking-tighter text-gray-900 dark:text-white mb-4">
            {{ __('messages.welcome_back') }} <span class="text-gradient">{{ auth()->user()->name }}</span>
        </h1>
        <p class="text-xl text-gray-500 dark:text-gray-400 font-medium font-inter leading-relaxed">
            {{ __('messages.dashboard_subtitle') }}
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
        <div class="card-modern p-10 relative overflow-hidden group border-none shadow-xl shadow-blue-500/5">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-4">{{ __('messages.enrolled_courses') }}</div>
                <div class="text-5xl font-black text-gray-900 dark:text-white mb-2">{{ $stats['enrolled_count'] }}</div>
                <div class="w-12 h-1 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="card-modern p-10 relative overflow-hidden group border-none shadow-xl shadow-indigo-500/5">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-[0.2em] mb-4">{{ __('messages.completed_lessons') }}</div>
                <div class="text-5xl font-black text-gray-900 dark:text-white mb-2">{{ $stats['completed_lessons'] }}</div>
                <div class="w-12 h-1 bg-indigo-500 rounded-full"></div>
            </div>
        </div>

        <div class="card-modern p-10 relative overflow-hidden group border-none shadow-xl shadow-purple-500/5">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="text-[10px] font-black text-purple-600 dark:text-purple-400 uppercase tracking-[0.2em] mb-4">{{ __('messages.certificates') }}</div>
                <div class="text-5xl font-black text-gray-900 dark:text-white mb-2">{{ $stats['certificates_count'] }}</div>
                <div class="w-12 h-1 bg-purple-500 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Active Courses Section -->
    <div class="mb-20">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter uppercase">{{ __('messages.my_courses') }}</h2>
            @if($enrolledCourses->count() > 3)
                <a href="{{ route('home') }}" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center">
                    {{ __('messages.view_all') }} <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            @endif
        </div>

        @if($enrolledCourses->isEmpty())
            <div class="card-modern p-20 text-center border-dashed border-2 border-gray-100 dark:border-gray-800">
                <div class="w-24 h-24 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4 leading-tight">{{ __('messages.no_enrollments') }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-10 font-medium max-w-sm mx-auto">{{ __('messages.continue_learning_desc') }}</p>
                <a href="{{ route('home') }}" class="btn-primary inline-flex">{{ __('messages.explore_courses') }}</a>
            </div>
        @else
            <div class="grid gap-10 lg:grid-cols-2">
                @foreach($enrolledCourses as $item)
                    <div class="card-modern group p-2 flex flex-col sm:flex-row gap-8 bg-white/50 dark:bg-gray-900/50 hover:bg-white dark:hover:bg-gray-900 transition-all border-none shadow-xl shadow-gray-200/20 dark:shadow-none">
                        <div class="w-full sm:w-48 h-48 rounded-[2rem] overflow-hidden shrink-0">
                            @if($item['image'])
                                <img src="{{ str_starts_with($item['image'], 'http') ? $item['image'] : \Illuminate\Support\Facades\Storage::url($item['image']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center group-hover:scale-110 transition-transform duration-700">
                                    <span class="text-white font-black text-2xl uppercase tracking-tighter">{{ substr($item['title'], 0, 2) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow p-6 sm:pl-0 flex flex-col">
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2 leading-tight group-hover:text-blue-600 transition-colors">{{ $item['title'] }}</h3>
                            <div class="text-xs font-black text-gray-400 uppercase tracking-widest mb-auto">
                                {{ __('messages.enrolled_date', ['date' => $item['enrolled_at']->diffForHumans()]) }}
                            </div>
                            
                            <div class="mt-8">
                                <div class="flex items-center justify-between mb-3 px-1">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $item['completed_lessons'] }}/{{ $item['total_lessons'] }} {{ __('messages.modules') }}</span>
                                    <span class="text-xs font-black text-blue-600">{{ $item['progress'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2.5 p-0.5 mb-6">
                                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-1000 shadow-sm" style="width: {{ $item['progress'] }}%"></div>
                                </div>
                                @if($item['progress'] == 100)
                                    <div class="flex gap-2 w-full">
                                        @if($item['certificate'])
                                            <a href="{{ route('certificates.show', $item['certificate']->id) }}" class="btn-primary flex-1 !px-4 py-3 text-xs !bg-indigo-600 hover:!shadow-indigo-500/40 text-center">{{ __('messages.view_certification') }}</a>
                                        @else
                                            <a href="{{ route('certificates.preview', $item['slug']) }}" class="btn-primary flex-1 !px-4 py-3 text-[10px] !bg-yellow-600 hover:!shadow-yellow-500/40 text-center">{{ __('messages.preview_certificate') }}</a>
                                        @endif
                                    </div>
                                @else
                                    <a href="{{ route('courses.show', $item['slug']) }}" class="btn-primary w-full py-3 text-xs">{{ __('messages.continue_learning') }}</a>
                                @endif                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Motivational Section -->
    <div class="card-modern p-14 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-800 text-white relative overflow-hidden !rounded-[3rem] shadow-2xl shadow-blue-500/20">
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full -mr-32 -mt-32 blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-indigo-500/10 rounded-full -ml-32 -mb-32 blur-[100px]"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="max-w-2xl text-center md:text-left">
                <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tighter leading-tight">{{ __('messages.ready_to_learn_title') }}</h2>
                <p class="text-blue-100 text-xl font-medium mb-10 leading-relaxed font-inter">{{ __('messages.ready_to_learn_subtitle') }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <a href="{{ route('home') }}" class="px-10 py-5 bg-white text-blue-600 rounded-[1.5rem] font-black text-sm uppercase tracking-widest hover:bg-blue-50 transition-all shadow-xl shadow-black/20">
                        {{ __('messages.explore_courses') }}
                    </a>
                    <a href="{{ route('profile') }}" class="px-10 py-5 glass border-white/20 bg-white/10 rounded-[1.5rem] font-black text-sm uppercase tracking-widest hover:bg-white/20 transition-all">
                        {{ __('messages.profile_settings') }}
                    </a>
                </div>
            </div>
            
            <div class="hidden lg:flex w-64 h-64 glass bg-white/10 border-white/20 rounded-[3rem] items-center justify-center p-8 text-center flex-col shrink-0 animate-float">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-blue-600 mb-6 shadow-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="text-sm font-black uppercase tracking-widest mb-1">{{ $stats['enrolled_count'] }} {{ __('messages.courses') }}</div>
                <div class="text-[10px] font-bold text-blue-100 uppercase tracking-widest opacity-60">{{ __('messages.learning_journey') }}</div>
            </div>
        </div>
    </div>
</div>
