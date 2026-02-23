<div class="flex flex-col items-center justify-center p-4">
    @if($isImage)
        <img src="{{ $url }}" class="max-w-full max-h-[70vh] rounded-lg shadow-lg" alt="Preview">
    @elseif($isPDF)
        <iframe src="{{ $url }}" class="w-full h-[70vh] rounded-lg" frameborder="0"></iframe>
    @elseif($isVideo)
        <video controls class="max-w-full max-h-[70vh] rounded-lg shadow-lg">
            <source src="{{ $url }}" type="video/{{ $extension }}">
            Your browser does not support the video tag.
        </video>
    @else
        <div class="flex flex-col items-center gap-4 py-12">
            <x-filament::icon
                icon="heroicon-o-document"
                class="w-24 h-24 text-gray-300 dark:text-gray-600"
            />
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Preview not available for this file type.
            </p>
            <x-filament::button
                tag="a"
                href="{{ $url }}"
                target="_blank"
                icon="heroicon-m-arrow-down-tray"
                color="gray"
            >
                Download File
            </x-filament::button>
        </div>
    @endif
</div>
