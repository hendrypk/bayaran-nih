<nav id="navbar" class="fixed top-0 left-64 right-0 h-16 bg-white dark:bg-slate-900 shadow flex items-center justify-between transition-all duration-300  px-6 z-40">

    <!-- Brand -->
  
    <button id="navbarToggle"
        class="navbar-toggle px-2 py-2 rounded bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition"
        aria-expanded="true"
        aria-controls="sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="currentColor" d="M14 16.94v-4H5.08l-.03-2.01H14V6.94l5 5Z"/>
        </svg>

    </button>
    <!-- Actions -->
    <div class="flex items-center space-x-4">
        <x-dark-light-toggle />
        <x-nav-lang-dropdown />
        <x-nav-user-dropdown />
    </div>
</nav>
