document.addEventListener('livewire:init', () => {
    const swalConfig = {
        success: {
            defaultTitle: '🎉 Yeay!',
            defaultText: 'Data berhasil disimpan!',
            iconColor: '#22d3ee',
            timer: 1500,
            showConfirmButton: false,
        },
        error: {
            defaultTitle: '😢 Oops!',
            defaultText: 'Terjadi kesalahan!',
            iconColor: '#dc2626',
            showConfirmButton: true,
        },
        warning: {
            defaultTitle: '⚠️ Perhatian!',
            defaultText: 'Ada sesuatu yang perlu dicek!',
            iconColor: '#f59e0b',
            showConfirmButton: true,
        }
    };

    const showSwal = ({ type = 'success', title, message, reload = false }) => {
        const cfg = swalConfig[type] ?? swalConfig.success;

        Swal.fire({
            title: title ?? cfg.defaultTitle,
            text: message ?? cfg.defaultText,
            icon: type,
            iconColor: cfg.iconColor,
            timer: cfg.timer,
            showConfirmButton: cfg.showConfirmButton,
            allowOutsideClick: false,
            allowEscapeKey: false,
            stopKeydownPropagation: false,
            customClass: {
                popup: 'bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800',
                title: 'text-xl font-bold text-slate-800 dark:text-white',
                htmlContainer: 'text-sm text-slate-600 dark:text-slate-400',
                actions: 'gap-3',
                confirmButton: 'inline-flex items-center px-5 py-2.5 bg-cyan-400 text-white hover:bg-cyan-600 dark:bg-cyan-400 dark:hover:bg-cyan-600 rounded-xl font-semibold transition-all shadow-sm active:scale-95',
                cancelButton: 'inline-flex items-center px-5 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 rounded-xl font-semibold transition-all active:scale-95'
            },
            buttonsStyling: false
        }).then(() => {
            if (reload && type === 'success') window.location.reload();
        });
    };

    
    
    Livewire.on('swal:success', (data = {}) => showSwal({ ...data, type: 'success', reload: true }));
    Livewire.on('swal:error', (data = {}) => showSwal({ ...data, type: 'error' }));
    Livewire.on('swal:warning', (data = {}) => showSwal({ ...data, type: 'warning' }));
});
