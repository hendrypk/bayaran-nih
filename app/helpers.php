<?php

use Carbon\Carbon;

if (! function_exists('formatDate')) {
    /**
     * Format tanggal dengan Carbon dan bahasa Indonesia
     *
     * @param string|null $date
     * @param string $format
     * @return string
     */
    function formatDate($date, $format = 'j M Y')
    {
        if (!$date) return '';

        return Carbon::parse($date)->translatedFormat($format);
    }
}

if (! function_exists('formatTanggalWaktu')) {
    /**
     * Format tanggal dan waktu dengan Carbon dan bahasa Indonesia
     *
     * @param string|null $date
     * @param string $format
     * @return string
     */
    function formatTanggalWaktu($date, $format = 'd F Y H:i')
    {
        if (!$date) return '';

        return Carbon::parse($date)->translatedFormat($format);
    }
}

if (! function_exists('formatNumber')) {
    function formatNumber($number)
    {
        return number_format($number, 0, ',', '.');
    }
}

if (! function_exists('formatDecimal')) {
    function formatDecimal($number)
    {
        return number_format($number, 2, ',', '.');
    }
}

if (! function_exists('formatRupiah')) {
    function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}


if (! function_exists('formatPercent')) {
    function formatPercent($number, $decimals = 2)
    {
        if ($number <= 1) {
            $number = $number * 100;
        }
        return number_format($number, $decimals, ',', '.') . '%';
    }
}

if (! function_exists('formatBulan')) {
    function formatBulan($date, $format = 'F')
    {
        if (!$date) return '';

        return Carbon::parse($date)->translatedFormat($format);
    }
}

if (! function_exists('formatHariTanggal')) {
    /**
     * Format: Minggu, 24 Desember 2025
     *
     * @param string|null $date
     * @return string
     */
    function formatHariTanggal($date)
    {
        if (!$date) return '';

        return Carbon::parse($date)->translatedFormat('l, j M Y');
    }
}

if (! function_exists('formatTimeHIS')) {
    /**
     * Format: 17:30:05
     *
     * @param string|null $time
     * @return string
     */
    function formatTimeHIS($time)
    {
        if (!$time) return '';

        return Carbon::parse($time)->format('H:i:s');
    }
}

if (! function_exists('formatTimeHI')) {
    /**
     * Format: 17:30 (Sering digunakan untuk input type="time")
     *
     * @param string|null $time
     * @return string
     */
    function formatTimeHI($time)
    {
        if (!$time) return '';

        return Carbon::parse($time)->format('H:i');
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($dateTime, $format = 'dddd, D MMM YYYY HH:mm'): string
    {
        if (!$dateTime) return '';

        try {
            $locale = app()->getLocale();
            
            return \Carbon\Carbon::parse($dateTime)
                ->locale($locale)
                ->isoFormat($format);

        } catch (\Exception $e) {
            return $dateTime; 
        }
    }
}
