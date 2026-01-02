<x-ui.modal id="coming-soon-modal" title="" size="max-w-md" :showFooter="false">
    <div class="py-10 px-6 text-center">
        {{-- Ikon Animasi Biar Keren --}}
        <div class="relative inline-flex mb-6">
            <div class="absolute inset-0 rounded-full bg-tosca-400 opacity-20 animate-ping"></div>
            <div class="relative bg-tosca-50 dark:bg-tosca-900/30 p-5 rounded-full border-4 border-white dark:border-slate-800 shadow-sm">
                <iconify-icon icon="lucide:rocket" class="text-tosca-600 dark:text-tosca-400" width="48"></iconify-icon>
            </div>
        </div>

        {{-- Pesan --}}
        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">
            Sabar Ya, Lagi Dimasak! 👨‍🍳
        </h3>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 leading-relaxed mb-10 px-4">
            Dikit lagi siap nih! Kita lagi pastiin semuanya sempurna buat kamu. Catch you very soon! ✌️
        </p>

        {{-- Tombol Tutup / Santai Dulu --}}
        <button 
            @click="show = false" 
            class="w-36 p-3 bg-slate-900 dark:bg-slate-50 text-white dark:text-slate-900 text-xs font-black uppercase tracking-[0.25em] rounded-2xl active:scale-95 transition-all shadow-lg shadow-slate-200 dark:shadow-none">
            Oke, Siap!
        </button>
    </div>
</x-ui.modal>