<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MonthYearPicker extends Component
{
    /**
     * Create a new component instance.
     */
    public $action;
    public $selectedMonth;
    public $selectedYear;

    public function __construct($selectedMonth = null, $selectedYear = null)
    {
        $this->selectedMonth = $selectedMonth ?? date('F');
        $this->selectedYear = $selectedYear ?? date('Y');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.month-year-picker');
    }
}
