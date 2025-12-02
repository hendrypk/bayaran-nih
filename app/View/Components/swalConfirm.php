<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class swalConfirm extends Component
{
    public $title;
    public $text;
    public $callback;
    public $id;

    /**
     * @param string $title - Judul Swal
     * @param string $text - Pesan Swal
     * @param string $callback - Nama Livewire method yang dipanggil
     */

    /**
     * Create a new component instance.
     */

    public function __construct($title = 'Are you sure?', $text = 'You cannot undo this action!', $callback = '', $id = null)
    {
        $this->title = $title;
        $this->text = $text;
        $this->callback = $callback;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.swal-confirm');
    }
}
