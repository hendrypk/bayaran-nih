<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AbsenceDateFilter extends Component
{

    public $action;
    public $startDate;
    public $endDate;

    /**
     * Create a new component instance.
     */
    public function __construct($startDate = null, $endDate = null      )
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.absence-date-filter');
    }
}
