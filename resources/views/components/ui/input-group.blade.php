{{-- resources/views/components/ui/input-group.blade.php --}}
@props([
    'type' => 'text',
    'label' => null,
    'name' => null,
    'model' => null,
    'placeholder' => null,
    'prefix' => null,   // teks di depan input
    'suffix' => null,   // teks di belakang input
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
            {{ $label }}
        </label>
    @endif

    <div class="flex rounded-md shadow-sm">
        @if($prefix)
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm">
                {{ $prefix }}
            </span>
        @endif

        <input type="{{ $type }}"
               id="{{ $name }}"
               {{ $attributes->merge([
                   'class' => 'flex-1 block w-full rounded-none border-slate-300 px-3 py-2
                               focus:border-tosca-500 focus:ring focus:ring-tosca-200
                               dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100'
               ]) }}
               @if($model) wire:model="{{ $model }}" @endif
               placeholder="{{ $placeholder }}">

        @if($suffix)
            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-slate-300 bg-slate-50 text-slate-500 text-sm">
                {{ $suffix }}
            </span>
        @endif
    </div>
</div>
