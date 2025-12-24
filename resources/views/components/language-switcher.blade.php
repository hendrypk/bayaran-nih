
@php
    $currentLang = app()->getLocale();
    $availableLocales = config('app.available_locales') ?? [];
    $currentLangFlag = $availableLocales[$currentLang] ?? 'id';
@endphp

<div x-data="{ open: false }" class="relative">
    <!-- Trigger -->
    <button @click="open = !open"
            class="flex items-center px-3 py-2 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition">
        <iconify-icon class="text-lg mr-2"
                      icon="emojione:flag-for-{{ $currentLangFlag }}"></iconify-icon>
        <span>{{ strtoupper($currentLang) }}</span>
        <svg class="ml-2 h-4 w-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false"
         class="absolute right-0 mt-2 w-28 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md shadow-lg overflow-hidden z-50">
        <ul class="py-1 text-sm">
            @foreach($availableLocales as $locale => $flag)
                <li>
                    <a href="{{ route('setlocale',['locale' => $locale]) }}"
                       class="flex items-center px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 transition
                       {{ $currentLang == $locale ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">
                        <iconify-icon class="text-lg mr-2"
                                      icon="emojione:flag-for-{{ $flag }}"></iconify-icon>
                        <span>{{ strtoupper($locale) }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
