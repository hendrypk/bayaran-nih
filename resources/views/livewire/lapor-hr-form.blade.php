<div>
    <x-ui.modal title="{{ $isEditing ? 'Edit Laporan HR' : 'Tambah Laporan HR' }}" size="max-w-4xl">
        <form wire:submit.prevent="save" class="space-y-6 p-1">
            
            {{-- Bagian Laporan --}}
            <div class="bg-slate-50/50 dark:bg-slate-800/30 rounded-3xl border border-slate-100 dark:border-slate-800/50 p-6 space-y-6">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Detail Laporan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group" wire:ignore>
                        <x-ui.label>Karyawan</x-ui.label>
                        <x-ui.select2 
                            name="employeeId"
                            wire:model.live="employeeId"
                            :options="collect($employees)->pluck('name', 'id')"
                            placeholder="Pilih Karyawan"
                        />
                        @error('employeeId') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div wire:ignore>
                        <x-ui.label>Kategori Laporan</x-ui.label>
                         <x-ui.select2 
                            name="categoryId"
                            wire:model.live="categoryId"
                            :options="collect($categories)->pluck('name', 'id')"
                            placeholder="Pilih Kategori"
                        />
                        @error('categoryId') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-ui.label>Tanggal Lapor</x-ui.label>
                        <x-ui.datepicker name="reportDate" wire:model.live="reportDate" />
                        @error('reportDate') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                     <div>
                        <x-ui.label>Status</x-ui.label>
                        <select wire:model.live="status" class="w-full px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-900 border-none focus:ring-2 focus:ring-cyan-500">
                            <option value="open">Open</option>
                            <option value="on progress">On Progress</option>
                            <option value="close">Close</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        @error('status') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <x-ui.label>Deskripsi Laporan</x-ui.label>
                    <textarea wire:model="reportDescription" rows="3" class="w-full px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-900 border-none focus:ring-2 focus:ring-cyan-500"></textarea>
                    @error('reportDescription') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>

                {{-- Report Attachments --}}
                <div class="space-y-2">
                    <x-ui.label>Lampiran Laporan</x-ui.label>
                    <input type="file" wire:model="reportAttachments" multiple class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 dark:file:bg-slate-700 dark:file:text-slate-200">
                    <div wire:loading wire:target="reportAttachments" class="text-xs text-cyan-600 font-bold">Uploading...</div>
                    
                    {{-- New Uploads Preview --}}
                    @if ($reportAttachments)
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($reportAttachments as $file)
                                <div class="relative group">
                                    @if(in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ $file->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg border border-slate-200">
                                    @else
                                        <div class="w-20 h-20 flex items-center justify-center bg-slate-100 rounded-lg border border-slate-200">
                                            <span class="text-xs font-bold text-slate-500">{{ $file->extension() }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                     {{-- Existing Attachments --}}
                    @if (!empty($existingReportAttachments))
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($existingReportAttachments as $att)
                                <div class="relative group">
                                     @php $ext = pathinfo($att->file_path, PATHINFO_EXTENSION); @endphp
                                     @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ Storage::url($att->file_path) }}" class="w-20 h-20 object-cover rounded-lg border border-slate-200">
                                     @else
                                        <div class="w-20 h-20 flex items-center justify-center bg-slate-100 rounded-lg border border-slate-200">
                                            <span class="text-xs font-bold text-slate-500">{{ $ext }}</span>
                                        </div>
                                     @endif
                                    <button type="button" wire:click="deleteAttachment({{ $att->id }})" class="absolute -top-2 -right-2 bg-rose-500 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bagian Solusi --}}
            <div class="bg-slate-50/50 dark:bg-slate-800/30 rounded-3xl border border-slate-100 dark:border-slate-800/50 p-6 space-y-6">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Solusi / Penyelesaian (Opsional)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-ui.label>Tanggal Selesai</x-ui.label>
                        <x-ui.datepicker name="solveDate" wire:model.live="solveDate" />
                    </div>
                </div>

                <div>
                    <x-ui.label>Deskripsi Solusi</x-ui.label>
                    <textarea wire:model="solveDescription" rows="3" class="w-full px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-900 border-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                 {{-- Solve Attachments --}}
                 <div class="space-y-2">
                    <x-ui.label>Lampiran Solusi</x-ui.label>
                    <input type="file" wire:model="solveAttachments" multiple class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 dark:file:bg-slate-700 dark:file:text-slate-200">
                    <div wire:loading wire:target="solveAttachments" class="text-xs text-emerald-600 font-bold">Uploading...</div>

                    {{-- New Uploads Preview --}}
                    @if ($solveAttachments)
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($solveAttachments as $file)
                                <div class="relative group">
                                     @if(in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ $file->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg border border-slate-200">
                                    @else
                                        <div class="w-20 h-20 flex items-center justify-center bg-slate-100 rounded-lg border border-slate-200">
                                            <span class="text-xs font-bold text-slate-500">{{ $file->extension() }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Existing Attachments --}}
                    @if (!empty($existingSolveAttachments))
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($existingSolveAttachments as $att)
                                <div class="relative group">
                                    @php $ext = pathinfo($att->file_path, PATHINFO_EXTENSION); @endphp
                                     @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ Storage::url($att->file_path) }}" class="w-20 h-20 object-cover rounded-lg border border-slate-200">
                                     @else
                                        <div class="w-20 h-20 flex items-center justify-center bg-slate-100 rounded-lg border border-slate-200">
                                            <span class="text-xs font-bold text-slate-500">{{ $ext }}</span>
                                        </div>
                                     @endif
                                    <button type="button" wire:click="deleteAttachment({{ $att->id }})" class="absolute -top-2 -right-2 bg-rose-500 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end pt-4">
                 <x-action-button type="save">Simpan Laporan</x-action-button>
            </div>
        </form>

        @if($isEditing)
             <x-slot:footer_left>
                <x-swal-confirm 
                    title="Hapus Laporan?" 
                    text="Tindakan ini permanen."
                    callback="delete"
                    class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all"
                    :id="$laporHrId" 
                />
            </x-slot:footer_left>
        @endif
    </x-ui.modal>
</div>
