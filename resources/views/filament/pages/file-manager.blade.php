<x-filament-panels::page>
    <div class="flex flex-col gap-8">
        {{-- Navigation Header --}}
        <x-filament::section>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <x-filament::icon-button
                        icon="heroicon-m-chevron-up"
                        wire:click="navigateUp"
                        :disabled="empty($currentPath)"
                        tooltip="{{ __('messages.go_up') }}"
                        color="primary"
                    />
                    
                    <div class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-300">
                        <x-filament::icon icon="heroicon-m-home" class="w-5 h-5 text-gray-400 block" />
                        <span>/</span>
                        @php $paths = array_filter(explode('/', $currentPath)); @endphp
                        @foreach($paths as $part)
                            <span>{{ $part }}</span>
                            @if(!$loop->last)
                                <span class="text-gray-400">/</span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{ $this->createFolderAction }}
                    {{ $this->uploadFileAction }}
                </div>
            </div>
        </x-filament::section>

        {{-- Folders --}}
        @if(count($folders) > 0)
            <div>
                <h3 class="text-sm font-bold text-gray-500 mb-4 flex items-center gap-2 uppercase tracking-tight">
                    <x-filament::icon icon="heroicon-m-folder" class="w-5 h-5 text-gray-400" />
                    {{ __('messages.directory_folders') }}
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
                    @foreach($folders as $folder)
                        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 hover:ring-primary-500 dark:hover:ring-primary-500 transition-all">
                            <div class="p-3 flex items-center justify-between">
                                <div class="flex items-center gap-3 flex-grow cursor-pointer" wire:click="navigateTo('{{ $folder['path'] }}')">
                                    <x-filament::icon icon="heroicon-s-folder" class="w-8 h-8 text-warning-400" />
                                    <span class="font-medium text-sm text-gray-700 dark:text-gray-200 truncate" style="max-width: 140px;" title="{{ $folder['name'] }}">
                                        {{ $folder['name'] }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-[2px]">
                                    {{ ($this->renameFolderAction)(['path' => $folder['path']]) }}
                                    <x-filament::icon-button
                                        icon="heroicon-m-trash"
                                        color="danger"
                                        wire:click="deleteFolder('{{ $folder['path'] }}')"
                                        wire:confirm="{{ __('messages.delete_confirm_folder') }}"
                                        size="sm"
                                        tooltip="{{ __('messages.delete') }}"
                                    />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Files --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 mb-4 flex items-center gap-2 uppercase tracking-tight">
                <x-filament::icon icon="heroicon-m-document" class="w-5 h-5 text-gray-400" />
                {{ __('messages.lessons') }}
            </h3>
            
            @if(count($files) > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1rem;">
                    @foreach($files as $file)
                        @php 
                            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                        @endphp
                        
                        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden flex transition-all hover:shadow-md">
                            {{-- Thumbnail --}}
                            <div class="w-24 h-24 flex-shrink-0 bg-gray-50 dark:bg-gray-800 flex items-center justify-center border-r border-gray-100 dark:border-gray-800">
                                @if($isImage)
                                    <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <x-filament::icon icon="heroicon-m-document-text" class="w-10 h-10 text-gray-300 dark:text-gray-600" />
                                @endif
                            </div>
                            
                            {{-- Content & Actions --}}
                            <div class="p-3 flex flex-col justify-center flex-grow min-w-0">
                                <a href="{{ $file['url'] }}" target="_blank" class="text-sm font-bold text-gray-700 dark:text-gray-200 hover:text-primary-600 truncate mb-1 block transition" title="{{ $file['name'] }}">
                                    {{ $file['name'] }}
                                </a>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase font-bold tracking-wider mb-2">
                                    {{ $extension }} <span class="mx-1">•</span> {{ $file['size'] }}
                                </p>
                                
                                <div class="flex items-center gap-[2px]">
                                    {{ ($this->viewFileAction)(['path' => $file['path']]) }}
                                    {{ ($this->renameFileAction)(['path' => $file['path']]) }}
                                    <x-filament::icon-button
                                        icon="heroicon-m-trash"
                                        color="danger"
                                        wire:click="deleteFile('{{ $file['path'] }}')"
                                        wire:confirm="{{ __('messages.delete_confirm_file') }}"
                                        size="sm"
                                        tooltip="{{ __('messages.delete') }}"
                                    />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-filament::section>
                    <div class="py-12 flex flex-col items-center justify-center text-center">
                        <x-filament::icon icon="heroicon-o-inbox" class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" />
                        <h4 class="text-gray-500 dark:text-gray-400 text-lg font-medium">{{ __('messages.no_files') }}</h4>
                        <p class="text-sm text-gray-400 mt-1">{{ __('messages.ready_uploads') }}</p>
                    </div>
                </x-filament::section>
            @endif
        </div>
    </div>
</x-filament-panels::page>
