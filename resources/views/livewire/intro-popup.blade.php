<div>
    @if($show)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-data="{ }" x-on:keydown.escape.window="$wire.close()">
            <div class="relative w-full max-w-4xl glass rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-300">
                <!-- Close Button -->
                <button wire:click="close" class="absolute top-4 right-4 z-10 p-2 glass rounded-full text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="p-2">
                    @if($type === 'image')
                        <img src="{{ $media }}" alt="Intro" class="w-full h-auto rounded-2xl">
                    @elseif($type === 'youtube')
                        <div class="aspect-video rounded-2xl overflow-hidden">
                            @php
                                $videoId = '';
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $media, $match)) {
                                    $videoId = $match[1];
                                }
                            @endphp
                            @if($videoId)
                                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                    <p class="text-gray-500">Invalid YouTube Link</p>
                                </div>
                            @endif
                        </div>
                    @elseif($type === 'video')
                        <div class="aspect-video rounded-2xl overflow-hidden">
                            <video controls autoplay class="w-full h-full">
                                <source src="{{ $media }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
