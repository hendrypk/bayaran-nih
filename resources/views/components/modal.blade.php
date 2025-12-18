<div id="x-ilz-modal" class="modal fade" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false">
    @livewire('livewire-modal')
</div>

@push('scripts')
    <script>
        function _livewireModal() {
            return {
                ready: !1, modal: "", size: "", centered: false, scrollable: false, heading: "Loading...", boot() {
                    function e() {
                        Livewire.dispatch("closeModal");
                        this.ready = !1
                    }

                    document.getElementById("x-ilz-modal").addEventListener("hidden.bs.modal", i => e())
                }, onOpen(e) {
                        this.heading = e.detail.title,
                        this.modal = e.detail.modal,
                        this.size = e.detail.size || null;
                        this.centered = e.detail.centered || false;
                        this.scrollable = e.detail.scrollable || false;
                        this.ready = false;

                        const modalDialog = document.querySelector('#x-ilz-modal .modal-dialog');
                        modalDialog.classList.remove('modal-sm','modal-lg','modal-xl','modal-xxl');

                        if(this.size) {
                            modalDialog.classList.add(`modal-${this.size}`);
                        }
                        if(this.centered) {
                            modalDialog.classList.add('modal-dialog-centered');
                        } else {
                            modalDialog.classList.remove('modal-dialog-centered');
                        }
                        if(this.scrollable) {
                            modalDialog.classList.add('modal-dialog-scrollable');
                        } else {
                            modalDialog.classList.remove('modal-dialog-scrollable');
                        }
                        new bootstrap.Modal(document.getElementById("x-ilz-modal")).show();

                        // this.size = Object.prototype.hasOwnProperty.call(e.detail, "size") ? e.detail.size : null,
                        // this.centered = Object.prototype.hasOwnProperty.call(e.detail, "centered") ? e.detail.centered : !1,
                        // this.scrollable = Object.prototype.hasOwnProperty.call(e.detail, "scrollable") ? e.detail.scrollable : !1,
                        // this.ready = !1, new bootstrap.Modal(document.getElementById("x-ilz-modal")).show();
                    Livewire.dispatch('initModal', {modal: e.detail.modal, args: e.detail.args});
                }
            }
        }

        function _openModal(title, modal, args, size = '', centered = false, scrollable = false) {
            window.dispatchEvent(new CustomEvent("open-x-ilz-modal", {
                detail: {
                    title: title,
                    modal: modal,
                    size: size,
                    centered: centered,
                    scrollable: scrollable,
                    args: args
                }
            }))
        }

        window.addEventListener('closeModal', event => {
            $('#x-ilz-modal').modal('hide');
        })
    </script>
@endpush