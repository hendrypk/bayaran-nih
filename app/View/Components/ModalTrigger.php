<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalTrigger extends Component
{
    public string $title;
    public $modal;
    public string $size;
    public array $args;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        string $modal,
        string $size = '',
        array $args = []
    ) {
        $this->title = $title;
        $this->modal = $modal;
        $this->size = in_array($size, ['xs', 'sm', 'lg', 'xl', 'full']) ? $size : '';
        $this->args = $args;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-trigger');
    }
}