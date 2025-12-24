<div>
    <x-ui.modal>
        <div class="space-y-4 bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100 p-4 rounded-lg">

            <div>
                <x-ui.label label="{{ __('general.label.name') }}" name="name" />
                <x-ui.input id="pa-name" type="text" wire:model="name" placeholder="Input your appraisal name" />
            </div>

            <h6 class="text-base font-semibold text-slate-700 dark:text-slate-300">
                @lang('performance.label.appraisal')
            </h6>

            @foreach($appraisals as $index => $item)
                <div class="flex items-center gap-2 mb-3">
                    <x-ui.input id="pa-aspect" type="text" wire:model="appraisals.{{ $index }}.aspect" placeholder="input aspect here"/>
                    <x-ui.input id="pa-descripotion" type="text" wire:model="appraisals.{{ $index }}.description" placeholder="description area" />
                    <button class="inline-flex items-center p-2 bg-rose-100 text-rose-600 
                                    hover:bg-rose-600 hover:text-white 
                                    dark:bg-rose-900/30 dark:text-rose-400 
                                    dark:hover:bg-rose-600 dark:hover:text-white 
                                    rounded-lg transition-all"
                            wire:click="removeAppraisal({{ $index }})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                                viewBox="0 0 24 24"><path fill="none" stroke="currentColor" 
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/></svg>
                    </button>
                </div>
            @endforeach


            <div class="flex mt-2 justify-end items-center">
                <button class="px-2 py-1 text-white bg-tosca-600 rounded hover:bg-tosca-700"
                    wire:click="addAppraisal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/></svg>

                </button>
            </div>

            <hr class="my-4 border-slate-200 dark:border-slate-700">

                <div class="mt-3 flex justify-between items-center">
                    @if($isEditing)
                        <x-swal-confirm 
                            title="Hapus PA?" 
                            text="Apakah Anda yakin ingin menghapus PA {{ $name }}?"
                            callback="delete"
                            :id="$editingId"
                            class="inline-flex items-center p-2 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white 
                                   dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                            viewBox="0 0 24 24"><path fill="none" stroke="currentColor" 
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/></svg>
                        </x-swal-confirm>
                    @else
                        <div></div>
                    @endif

                    <div class="flex gap-2">
                        <x-action-button type="cancel" @click="onClose()">
                            @lang('general.label.cancel')
                        </x-action-button>

                        <x-action-button type="save" wire:click="save">
                            @lang('general.label.save')
                        </x-action-button>
                    </div>
                </div>

        </div>
    </x-ui.modal>
</div>
