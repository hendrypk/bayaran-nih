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