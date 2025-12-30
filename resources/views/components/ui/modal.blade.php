<div {{ $attributes }} class="bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100 rounded-lg shadow-md overflow-hidden">
    <div x-show="ready" class="w-full h-[2px]">
        <div wire:loading.class.remove="hidden" class="hidden bg-blue-500 h-[2px] animate-pulse"></div>
    </div>

    <div class="p-4">
        {{ $slot }}
    </div>

    <div class="border-t border-slate-50 dark:border-slate-800/50 bg-slate-50/50 dark:bg-slate-900/50">
        @if(isset($footer_custom))
            {{-- Level 3: Kontrol Penuh --}}
            {{ $footer_custom }}
        @else
            {{-- Level 1 & 2: Struktur Standar --}}
            <div class="flex items-center justify-between px-6 py-4">
                {{-- Sisi Kiri --}}
                <div class="flex-shrink-0">
                    {{ $footer_left ?? '' }}
                </div>

                {{-- Sisi Kanan --}}
                <div class="flex items-center gap-3">
                    @if(isset($footer))
                        {{ $footer }}
                    @else
                        {{-- Default Buttons --}}
                        <x-action-button type="cancel" @click="onClose()">
                            @lang('general.label.cancel')
                        </x-action-button>

                        <x-action-button type="save" wire:click="save">
                            <span wire:loading.remove wire:target="save">@lang('general.label.save')</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                @lang('general.label.processing')
                            </span>
                        </x-action-button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

{{-- <div {{ $attributes }}>
    <div x-show="ready" class="w-100" style="height: 2px">
        <div wire:loading.class.remove="d-none" class="progress-line d-none"></div>
    </div>
    <div class="modal-body">
        {{ $slot }}
    </div>
    @if(isset($footer))
        <div class="d-flex modal-footer">
            {{ $footer }}
        </div>
    @elseif(isset($footer_custom))
        {{ $footer_custom }}
    @endif
</div> --}}