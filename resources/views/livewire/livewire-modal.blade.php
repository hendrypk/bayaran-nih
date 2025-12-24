<div >
    <div 
        class="bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100 rounded-lg shadow-xl max-w-2xl"
        :class="[size, centered ? 'mx-auto' : '', scrollable ? 'overflow-y-auto max-h-[90vh]' : '']"
    >
        <div class="flex items-center justify-between px-4 py-2 border-b border-slate-200 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-300" x-text="heading"></h2>
            <button @click="onClose()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        
        <div x-show="ready" wire:key="x-ilz-modal-zone-{{$activeModal}}">
            @if($activeModal)
                @livewire($activeModal, $args, key($activeModal))
            @endif
        </div>
    </div>
</div>