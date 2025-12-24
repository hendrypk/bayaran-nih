<div 
    id="x-ilz-modal"
    x-data="_livewireModal()"
    x-on:open-x-ilz-modal.window="onOpen($event)"
    x-on:closeModal.window="onClose()"
    x-show="ready"
    {{-- x-transition.opacity --}}
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>

    @livewire('livewire-modal')
</div>


@push('scripts')
<script>
    function _livewireModal() {
        return {
            ready: false,
            modal: "",
            size: "",
            centered: false,
            scrollable: false,
            heading: "Loading...",

            boot() {
                // tidak perlu listener bootstrap lagi
            },

            onOpen(e) {
                this.heading   = e.detail.title;
                this.modal     = e.detail.modal;
                this.size      = e.detail.size || '';
                this.centered  = e.detail.centered || false;
                this.scrollable= e.detail.scrollable || false;
                this.ready     = true;
                Livewire.dispatch('initModal', {modal: e.detail.modal, args: e.detail.args});
            },

            onClose() {
                this.ready = false;
                Livewire.dispatch("closeModal");
            }
        }
    }

    function _openModal(title, modal, args, size = '', centered = false, scrollable = false) {
        window.dispatchEvent(new CustomEvent("open-x-ilz-modal", {
            detail: { title, modal, size, centered, scrollable, args }
        }));
    }
</script>
@endpush
