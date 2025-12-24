<div {{ $attributes }} class="bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100  rounded-lg shadow-md">
    <!-- Progress line -->
    <div x-show="ready" class="w-full h-[2px]">
        <div 
            wire:loading.class.remove="hidden" 
            class="hidden bg-blue-500 h-[2px] animate-pulse"
        ></div>
    </div>

    <!-- Body -->
    <div class="p-4">
        {{ $slot }}
    </div>

    <!-- Footer -->
    @if(isset($footer))
        <div class="flex justify-end items-center gap-4 border-t border-slate-50 dark:border-slate-800/50 px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50">
            {{ $footer }}
        </div>
    @elseif(isset($footer_custom))
        <div class="border-t border-slate-50 dark:border-slate-800/50">
            {{ $footer_custom }}
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