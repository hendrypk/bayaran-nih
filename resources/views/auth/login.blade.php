<x-layouts.guest>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="absolute top-4 right-6 flex items-center gap-3">
            <x-dark-light-toggle />
            <x-nav-lang-dropdown />
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="flex justify-center mb-6">
                <div class="logo-wrapper flex flex-col items-center space-y-4">
                    <img src="{{ asset('assets/img/bayaran-text.png') }}"
                        class="h-8 w-auto object-contain block" alt="Logo Full">
                </div>
            </div>
        </div>

        <div class="card-puffy max-w-md mx-auto w-full">
            <div class="card-header-puffy">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-cyan-500 rounded-full shadow-[0_0_10px_rgba(6,182,212,0.4)]"></div>
                    <h3 class="font-black uppercase tracking-widest text-slate-800 dark:text-white text-sm">
                        Login System
                    </h3>
                </div>
                <iconify-icon icon="mdi:shield-lock-outline" class="text-2xl text-slate-400"></iconify-icon>
            </div>

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="card-body-puffy space-y-6">
                    <div class="group">
                        <label for="yourUsername" class="form-label-puffy">
                            Username
                        </label>
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <iconify-icon icon="mdi:account-box-outline" class="text-xl text-slate-400 group-focus-within:text-cyan-500 transition-colors"></iconify-icon>
                            </div>
                            <input id="yourUsername" name="name" type="text" value="{{ Session::get('name') }}" required 
                                class="form-input-puffy !pl-12">
                        </div>
                    </div>

                    <div class="group">
                        <label for="password" class="form-label-puffy">
                            Password
                        </label>
                        <div class="mt-2 relative" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <iconify-icon icon="mdi:lock-outline" class="text-xl text-slate-400 group-focus-within:text-cyan-500 transition-colors"></iconify-icon>
                            </div>
                            
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer z-10" @click="show = !show">
                                <iconify-icon :icon="show ? 'mdi:eye-off-outline' : 'mdi:eye-outline'" 
                                    class="text-xl text-slate-400 hover:text-cyan-500 transition">
                                </iconify-icon>
                            </div>

                            <input id="password" name="password" :type="show ? 'text' : 'password'" required 
                                class="form-input-puffy !pl-12 !pr-12">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="relative flex items-center cursor-pointer group/check">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div class="w-5 h-5 border-2 border-slate-200 dark:border-slate-800 rounded-md transition-all 
                                peer-checked:bg-cyan-500 peer-checked:border-cyan-500 flex items-center justify-center">
                                <iconify-icon icon="mdi:check" class="text-white text-xs scale-0 peer-checked:scale-100 transition-transform"></iconify-icon>
                            </div>
                            <span class="ml-3 text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover/check:text-slate-800 dark:group-hover/check:text-slate-400 transition-colors">
                                Ingat Saya
                            </span>
                        </label>
                    </div>
                </div>

                <div class="card-footer-puffy">
                    <button type="button" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-rose-500 transition-colors">
                        Lupa Password?
                    </button>
                    <button type="submit" class="px-8 py-3 bg-cyan-500 text-white hover:bg-cyan-600  shadow-cyan-500/30 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg active:scale-95 transition-all">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.guest>