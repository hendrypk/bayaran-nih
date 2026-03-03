<div {{ $attributes }}>
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
</div>