@props([
    'showFooter' => true, {{-- Defaultnya muncul --}}
])

<div {{ $attributes }} class="bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100 rounded-lg shadow-md overflow-hidden">
    <div x-show="ready" class="w-full h-[2px]">
        <div wire:loading.class.remove="hidden" class="hidden bg-blue-500 h-[2px] animate-pulse"></div>
    </div>

    <div class="p-4 max-h-[70vh] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-700">
        {{ $slot }}
    </div>

    @if ($showFooter)        
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
                            @lang('general.label.save')
                        </x-action-button>
                    @endif
                </div>
            </div>
        @endif
    </div>
    @endif

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