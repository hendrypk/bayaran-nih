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
