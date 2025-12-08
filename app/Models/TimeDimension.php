<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeDimension extends Model
{
    protected $fillable = [];

    public static function monthNameToNumber($name)
    {
        return self::where('month_name', $name)->value('month') ?? 1;
    }

    public static function getDayNames()
    {
        return self::select('day', 'day_name')
            ->distinct()
            ->orderBy('day')
            ->get();
    }

    public static function getDays($year, $month)
    {
        return self::where('year', $year)
            ->where('month', $month)
            ->orderBy('day')
            ->get(['day', 'day_name', 'holiday_flag', 'weekend_flag']);
    }

    public static function getMonths()
    {
        return self::select('month', 'month_name')
            ->distinct()
            ->orderBy('month')
            ->get();
    }

    public static function getYears()
    {
        return self::select('year')
            ->distinct()
            ->orderBy('year')
            ->get();
    }
}
