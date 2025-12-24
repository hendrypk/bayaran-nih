{{-- resources/views/components/ui/select2.blade.php --}}
@props([
    'label' => null,
    'name' => null,
    'model' => null, // default wire:model
    'placeholder' => null,
    'options' => [], // array [value => text]
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
            {{ $label }}
        </label>
    @endif

    <select id="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'select2 w-full rounded-md border-slate-300 shadow-sm px-3 py-2
                            focus:border-tosca-500 focus:ring focus:ring-tosca-200
                            dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100'
            ]) }}
            @if($model) wire:model="{{ $model }}" @endif>
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>
</div>

@push('scripts')
<script>
    document.addEventListener("livewire:navigated", () => {
        $('.select2').select2();

        // sync dengan Livewire
        $('.select2').on('change', function (e) {
            let data = $(this).val();
            @this.set($(this).attr('wire:model'), data);
        });
    });
</script>
@endpush
