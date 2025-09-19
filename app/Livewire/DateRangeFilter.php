<?php

namespace App\Livewire;

use Livewire\Component;

class DateRangeFilter extends Component
{
    /**
     * @var array|int[] $ranges - 1:today, 2:yesterday, 3:last 7 days, 4:last 30 days, 5:this week, 6:last week, 7:this month, 8:last month, 9:this year, 10:last year, 11:all time
     * @var int $defaultRange - choose one of $ranges for default range
     * @var string $startDate - start date in Y-m-d format
     * @var string $endDate - end date in Y-m-d format
     * @var string $minDate - min date in Y-m-d format
     * @var string $maxDate - max date in Y-m-d format or 'week'|'month'|'year'
     * @var int $maxDay - max day after today. Will be ignored if maxDate is set
     * @var int $dateLimit - limit date range in day
     * @var string $allTimeYearStart - year start for all time range
     * @var string $parentEl - parent element selector
     * @var bool $listenKeydown - listen keydown event (arrow left and right) to change next or prev date range period
     */
    public array $ranges = [1,2,3,4,5,6,7,8,9,10,11];
    public int $defaultRange = 1;
    public string $startDate = ''; // in date Y-m-d
    public string $endDate = ''; // in date Y-m-d
    public string $minDate = ''; // in date Y-m-d
    public string $maxDate = ''; // in date Y-m-d or 'week'|'month'|'year'
    public int $maxDay = 0; // in day (day after today). Will be ignored if maxDate is set
    public int $dateLimit = 30; // in day (limit date range)
    public string $allTimeYearStart = '2020'; // year start for all time range
    public string $parentEl = '';
    public bool $listenKeydown = false;
    public bool $updateUrl = false;
    public string $class = 'text-center';

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.date-range-filter');
    }
    public function onDateRangeChanged($start, $end)
    {
        $this->startDate = $start ?? '';
        $this->endDate = $end ?? '';
        $this->dispatch('dateRangeChanged', $start, $end);
    }
}
