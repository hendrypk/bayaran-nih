<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class Select2 extends Component
{
    public array $options = [];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $ajax = '',
        Collection|array $options = [], // Terima Collection atau array
        public bool $searchable = true,
        public string $placeholder = '',
        public bool $clearable = false,
        public bool $multiple = false,
        public $selected = [],
        public string $parent = '',
        public bool $empty = false,
        public string $reinitialize = '',
        public int $maxSelections = 0,
    ) {
        // Konversi Collection ke array jika perlu
        $this->options = $options instanceof Collection
            ? $options->toArray()
            : $options;

        $this->reinitialize = preg_replace('/[^A-Za-z0-9\-]/', '_', $this->reinitialize);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.select2');
    }
}