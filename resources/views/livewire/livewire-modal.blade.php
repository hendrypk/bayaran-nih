<div x-data="_livewireModal()" x-on:open-x-ilz-modal.window="onOpen($event)"
     x-on:modal-ready.window="ready = true"
     x-init="boot()"
     class="modal-dialog" :class="[size ? `modal-${size}` : '', centered ? 'modal-dialog-centered' : '', scrollable ? 'modal-dialog-scrollable' : '']" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <div class="d-flex align-items-center">
                <h5 class="modal-title" x-text="heading"></h5>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div x-show="!ready">
            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="d-flex modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

        <div x-show="ready" wire:key="x-ilz-modal-zone-{{$activeModal}}">
            @if($activeModal)
                @livewire($activeModal, $args, key($activeModal))
            @endif
        </div>
    </div>
</div>