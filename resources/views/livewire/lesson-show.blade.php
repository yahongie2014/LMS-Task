@push('styles')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <style>
        .plyr--full-ui input[type=range] { color: #3b82f6; }
        .plyr__control--overlaid { background: rgba(59, 130, 246, 0.8); }
        .plyr--video .plyr__control.plyr__tab-focus, .plyr--video .plyr__control:hover, .plyr--video .plyr__control[aria-expanded=true] { background: #3b82f6; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('lessonPlayer', () => ({
                player: null,
                showModal: false,

                init() {
                    this.player = new Plyr(this.$refs.videoElement, {
                        tooltips: { controls: true, seek: true }
                    });
                    this.player.on('ended', event => {
                        if (!this.$wire.isCompleted) {
                            this.showModal = true;
                        }
                    });
                },

                markCompleted() {
                    this.$wire.markAsCompleted().then(() => {
                        this.showModal = false;
                    });
                }
            }));
        });
    </script>
@endpush

<div class="max-w-[1600px] mx-auto py-12 px-4 sm:px-6 lg:px-12 flex flex-col lg:grid lg:grid-cols-12 gap-12" x-data="lessonPlayer" x-cloak>
    
    <!-- Main Content (Video & Description) -->
    <div class="lg:col-span-8 space-y-10">
        
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-2xl bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-2xl bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Video Player Section -->
        <div class="card-modern bg-black aspect-video group relative shadow-[0_32px_64px_-16px_rgba(0,0,0,0.3)] !rounded-[2.5rem] border-none overflow-hidden">
            @if($isLocked)
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 bg-gradient-to-br from-gray-900 to-black z-10">
                    <div class="w-24 h-24 rounded-full bg-white/5 backdrop-blur-3xl flex items-center justify-center mb-8 border border-white/10 shadow-2xl animate-pulse">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-white mb-4 uppercase tracking-tighter">{{ __('messages.lesson_locked') }}</h2>
                    <p class="text-gray-400 text-lg mb-10 max-w-md font-medium font-inter">
                        {{ __('messages.enroll_to_unlock') }}
                    </p>
                    <a href="{{ route('courses.show', $course->slug) }}" class="btn-primary px-12 py-5 shadow-2xl shadow-blue-500/40">
                        {{ __('messages.enroll_now') }}
                    </a>
                </div>
            @endif

            @if(!$isLocked)
                @if($lesson->video_type === 'youtube')
                    @php
                        $url = $lesson->video_url;
                        $videoId = $url;
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                            $videoId = $match[1];
                        }
                    @endphp
                    <div class="plyr__video-embed w-full h-full" x-ref="videoElement">
                        <iframe
                            src="https://www.youtube.com/embed/{{ $videoId }}?origin={{ url('/') }}&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                            allowfullscreen
                            allowtransparency
                            allow="autoplay; encrypted-media"
                            class="w-full h-full border-none"
                        ></iframe>
                    </div>
                @elseif($lesson->video_type === 'plyr')
                    <div class="plyr__video-embed w-full h-full" x-ref="videoElement">
                        <iframe
                            src="https://player.vimeo.com/video/{{ $lesson->video_url }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                            allowfullscreen
                            allowtransparency
                            allow="autoplay"
                            class="w-full h-full border-none"
                        ></iframe>
                    </div>
                @else
                    <video x-ref="videoElement" controls crossorigin playsinline class="w-full h-full">
                        @if($lesson->video_url)
                            <source src="{{ str_starts_with($lesson->video_url, 'http') ? $lesson->video_url : \Illuminate\Support\Facades\Storage::url($lesson->video_url) }}" type="video/mp4" />
                        @else
                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4" />
                        @endif
                    </video>
                @endif
            @endif
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-3 tracking-tighter leading-tight uppercase">{{ $lesson->title }}</h1>
                <div class="flex items-center gap-4">
                    <span class="glass px-4 py-1 rounded-2xl text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest border-none">
                        {{ __('messages.module') }} {{ $course->lessons->where('order_column', '<=', $lesson->order_column)->count() }}
                    </span>
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">{{ $course->title }}</span>
                </div>
            </div>

            <div class="shrink-0">
                <button 
                    x-show="!$wire.isCompleted"
                    @click="showModal = true"
                    class="btn-primary text-sm px-10 py-5 shadow-xl shadow-blue-500/30"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('messages.mark_completed') }}
                </button>
                
                <div 
                    x-show="$wire.isCompleted"
                    class="inline-flex items-center px-10 py-5 glass border-green-500/30 bg-green-500/5 rounded-3xl text-green-600 dark:text-green-400 font-black text-lg gap-4 shadow-xl shadow-green-500/5"
                >
                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    {{ __('messages.completed') }}
                </div>
            </div>
        </div>

        <!-- Lesson Description -->
        <div class="card-modern p-12 !rounded-[2.5rem] bg-white dark:bg-gray-900 border-none">
            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-8 uppercase tracking-tight border-b border-gray-100 dark:border-gray-800 pb-6">{{ __('messages.lesson_overview') }}</h3>
            <p class="text-xl text-gray-500 dark:text-gray-400 font-medium leading-relaxed font-inter">
                {{ $lesson->description ?? 'No description provided.' }}
            </p>
        </div>

        <!-- Meta Grid -->
        <div class="grid md:grid-cols-3 gap-8">
            <div class="card-modern p-10 bg-blue-500/5 border-none !rounded-[2.5rem]">
                <div class="w-14 h-14 rounded-2xl bg-blue-500 flex items-center justify-center text-white mb-8 shadow-xl shadow-blue-500/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="font-black text-gray-900 dark:text-white mb-4 uppercase tracking-tight text-lg">{{ __('messages.key_takeaways') }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium leading-relaxed">{{ __('messages.key_takeaways_desc') }}</p>
            </div>
            <div class="card-modern p-10 bg-purple-500/5 border-none !rounded-[2.5rem]">
                <div class="w-14 h-14 rounded-2xl bg-purple-500 flex items-center justify-center text-white mb-8 shadow-xl shadow-purple-500/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h4 class="font-black text-gray-900 dark:text-white mb-4 uppercase tracking-tight text-lg">{{ __('messages.resources') }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium leading-relaxed">{{ __('messages.resources_desc') }}</p>
            </div>
            <div class="card-modern p-10 bg-pink-500/5 border-none !rounded-[2.5rem]">
                <div class="w-14 h-14 rounded-2xl bg-pink-500 flex items-center justify-center text-white mb-8 shadow-xl shadow-pink-500/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 012 2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                </div>
                <h4 class="font-black text-gray-900 dark:text-white mb-4 uppercase tracking-tight text-lg">{{ __('messages.community') }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium leading-relaxed">{{ __('messages.community_desc') }}</p>
            </div>
        </div>
    </div>

    <!-- Sidebar (Lesson Navigation) -->
    <div class="lg:col-span-4 lg:sticky lg:top-32 lg:h-fit space-y-10">
        <div class="card-modern p-10 !rounded-[2.5rem] bg-white dark:bg-gray-900 border-none">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter uppercase">{{ __('messages.course_modules') }}</h3>
                <span class="text-[10px] font-black text-blue-600 bg-blue-50 dark:bg-blue-900/40 px-3 py-1 rounded-lg uppercase tracking-widest">
                    {{ $course->lessons->count() }} {{ __('messages.modules') }}
                </span>
            </div>

            <div class="space-y-4">
                @foreach($course->lessons as $index => $item)
                    <a href="{{ route('lessons.show', [$course->slug, $item->id]) }}" 
                       class="flex items-center gap-5 p-5 rounded-[1.5rem] transition-all duration-500 {{ $item->id == $lesson->id ? 'bg-blue-600 text-white shadow-2xl shadow-blue-500/40 translate-x-3 rtl:-translate-x-3' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-lg {{ $item->id == $lesson->id ? 'bg-white/20' : 'bg-gray-100 dark:bg-gray-900' }}">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="flex-grow">
                            <h4 class="font-bold text-sm line-clamp-1 leading-tight uppercase tracking-tight">{{ $item->title }}</h4>
                        </div>
                        @if($item->id == $lesson->id)
                            <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                        @elseif(!$item->is_preview && !Auth::user()?->can('view', $item) && !Auth::guard('instructor')->user()?->can('view', $item))
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        @endif
                    </a>
                @endforeach
            </div>

            <!-- Progress in Sidebar -->
            <div class="mt-10 pt-10 border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center justify-between mb-4 px-1">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('messages.overall_progress') }}</span>
                    <span class="text-xs font-black text-blue-600 dark:text-blue-400 font-inter" x-text="`${$wire.progress}%`"></span>
                </div>
                <div class="w-full bg-gray-100 dark:bg-gray-900 rounded-full h-3 p-1">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-1000 shadow-sm" :style="`width: ${$wire.progress}%`"></div>
                </div>
            </div>
        </div>

        <div class="card-modern p-12 bg-gradient-to-br from-indigo-600 to-blue-700 !rounded-[2.5rem] text-white relative overflow-hidden group border-none shadow-2xl shadow-indigo-500/20">
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <h4 class="text-2xl font-black mb-6 relative z-10 leading-tight tracking-tight">{{ __('messages.need_help') }}</h4>
            <p class="text-blue-100 text-lg mb-10 font-medium relative z-10 leading-relaxed font-inter">{{ __('messages.discord_desc') }}</p>
            <button class="w-full py-5 glass bg-white/10 border-white/20 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] relative z-10 hover:bg-white/20 transition-all">{{ __('messages.join_community') }}</button>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-900/95 backdrop-blur-xl transition-opacity" @click="showModal = false"></div>
            
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-24 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-24 scale-95"
                 class="inline-block align-bottom glass dark:bg-gray-900 rounded-[3rem] shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full overflow-hidden border-none bg-white">
                
                <div class="relative p-14 text-center">
                    <div class="w-32 h-32 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-10 animate-float shadow-inner">
                        <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <h3 class="text-4xl font-black text-gray-900 dark:text-white mb-6 tracking-tighter leading-none">
                        {{ __('messages.confirm_module_finished') }}
                    </h3>
                    <p class="text-xl text-gray-500 dark:text-gray-400 font-medium mb-14 leading-relaxed font-inter px-4">
                        {{ __('messages.confirm_message') }}
                    </p>
                    
                    <div class="flex flex-col gap-5">
                        <button @click="markCompleted()" class="btn-primary w-full text-lg py-6 shadow-2xl shadow-blue-500/40">
                            {{ __('messages.confirm') }}
                        </button>
                        <button @click="showModal = false" type="button" class="w-full py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-gray-600 transition-all">
                            {{ __('messages.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
