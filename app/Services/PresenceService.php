<?php

namespace App\Services;

use App\Models\WorkDay;

class PresenceService
{
    /**
     * Calculate late check-in and late arrival
     */
    public function calculateLate(
        $now,
        $check_in,
        $check_out,
        $arrival,
        $break_in,
        $break_out,
        $breakDuration,
        $isCountLate,
        $excludeBreak
    ) {
        if (!$now || !$check_in) {
            return [0, 0];
        }

        if ($isCountLate == 0) {
            return [0, 0];
        }

        $lateCheckIn = 0;
        $lateArrival = ($now && $arrival && $arrival->diffInMinutes($now, false) > 1) ? 1 : 0;

        if ($excludeBreak) {
            $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
        } elseif ($now->between($break_in, $break_out)) {
            $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
        } elseif ($now->between($check_in, $break_in)) {
            $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
        } elseif ($now->between($break_out, $check_out)) {
            $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)) - $breakDuration, 0);
        } 
        // else {
        //     return response()->json([
        //         'status'  => 'error',
        //         'message' => 'Tidak ada kondisi yang terpenuhi saat menghitung keterlambatan.',
        //     ], 500);
        // }

        return [$lateCheckIn, intval($lateArrival)];
    }

    /**
     * Calculate early check-out
     */
    public function calculateCheckOutEarly(
        $now,
        $break_in,
        $break_out,
        $isCountLate,
        $excludeBreak,
        $check_out,
        $check_in,
        $breakDuration
    ) {
        if (!$now || !$check_out) {
            return [
                'status'  => 'error',
                'message' => 'Waktu sekarang atau jadwal pulang tidak terdeteksi.',
            ];
        }

        $checkOutEarly = 0;

        if ($isCountLate == 0) {
            $checkOutEarly = 0;

        } elseif ($excludeBreak == 1) {
            $checkOutEarly = max(intval($now->diffInMinutes($check_out, false)), 0);

        } elseif ($now->lt($check_out) && $now->gt($break_out)) {
            $checkOutEarly = max(intval($now->diffInMinutes($check_out, false)), 0);

        } elseif ($now->gt($check_in) && $now->lt($break_in)) {
            $checkOutEarly = max(intval($now->diffInMinutes($check_out, false)) - $breakDuration, 0);

        } elseif ($now->between($break_in, $break_out)) {
            $checkOutEarly = max(intval($break_out->diffInMinutes($check_out, false)), 0);

        } 
        // else {
        //     return [
        //         'error'   => true,
        //         'message' => 'Tidak ada kondisi yang terpenuhi saat menghitung keterlambatan.',
        //         'lateCheckIn' => 0,
        //         'lateArrival' => 0,
        //     ];
        // }

        return $checkOutEarly;
    }

    /**
     * Hitung keterlambatan check-in dan arrival
     */
    public function late($now, $check_in, $arrival, $break_in, $break_out, $workDayData)
    {
        if (!$now || !$check_in || !$arrival || !$break_in || !$break_out) {
            $nullVars = array_filter([
                'Jam Masuk Tidak Terdeteksi'            => $now,
                'Jadwal jam masuk tidak ada'            => $check_in,
                'Jadwal jam hadir tidak ada'            => $arrival,
                'Jadwal jam istirahat masuk tidak ada'  => $break_in,
                'Jadwal jam istirahat keluar tidak ada' => $break_out,
            ], function ($v) {
                return is_null($v);
            });

            return [
                'error'   => true,
                'message' => implode(', ', array_keys($nullVars)),
                'lateCheckIn' => 0,
                'lateArrival' => 0,
            ];
        }

        $lateCheckIn = 0;
        $lateArrival = 0;

        switch (true) {
            case $workDayData->count_late == 0:
                break;

            case $workDayData->break == 1:
                $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
                $lateArrival = $arrival->diffInMinutes($now, false) > 1 ? 1 : 0;
                break;

            case $now->between($break_in, $break_out):
                $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
                $lateArrival = $arrival->diffInMinutes($now, false) > 1 ? 1 : 0;
                break;

            case $break_in->lt($now):
                $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);
                $lateCheckIn   = max(intval($check_in->diffInMinutes($now, false)) - $breakDuration, 0);
                $lateArrival   = $arrival->diffInMinutes($now, false) > 1 ? 1 : 0;
                break;

            case $now->lt($break_in):
                $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
                $lateArrival = $arrival->diffInMinutes($now, false) > 1 ? 1 : 0;
                break;

            default:
                return [
                    'error'   => true,
                    'message' => 'Tidak ada kondisi yang terpenuhi saat menghitung keterlambatan.',
                    'lateCheckIn' => 0,
                    'lateArrival' => 0,
                ];
        }

        return [
            'error'       => false,
            'lateCheckIn' => $lateCheckIn,
            'lateArrival' => $lateArrival,
        ];
    }

    /**
     * Hitung early check-out
     */
    public function CheckOutEarly($now, $check_out, $break_in, $break_out, $workDayData, $presence)
    {
        if (!$now || !$check_out) {
            return 0;
        }

        $lastWorkDay = WorkDay::find($presence->work_day_id)->where('day', $now->format('l'))->first();
        $forCheckOut = $lastWorkDay ? $lastWorkDay->check_out : $check_out;

        switch (true) {
            case $workDayData->count_late == 0:
                $checkOutEarly = 0;
                break;

            case $workDayData->break == 1:
                $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
                break;

            case $now->lt($lastWorkDay->check_in):
                $checkOutEarly = 0;
                break;

            case $now->lt($break_in):
                $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)) - 60, 0);
                break;

            case $now->between($break_in, $break_out):
                $checkOutEarly = max(intval($break_out->diffInMinutes($forCheckOut, false)), 4);
                break;

            default:
                $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
                break;
        }

        return $checkOutEarly;
    }
}
