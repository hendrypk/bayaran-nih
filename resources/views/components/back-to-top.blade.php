<div x-data="{ show: false }"
     @scroll.window="show = window.pageYOffset > 500"
     x-cloak>
    <a href="#"
       x-show="show"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 translate-y-4"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 translate-y-4"
       class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-12 h-12 rounded-full bg-cyan-400 text-white shadow-xl hover:bg-cyan-600 hover:scale-110 active:scale-95 transition-all duration-300">
        <i class="mdi mdi-chevron-up text-2xl"></i>
    </a>
</div>