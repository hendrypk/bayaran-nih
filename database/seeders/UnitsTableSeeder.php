<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            // Panjang
            ['name' => 'Milimeter', 'symbol' => 'mm'],
            ['name' => 'Sentimeter', 'symbol' => 'cm'],
            ['name' => 'Meter', 'symbol' => 'm'],
            ['name' => 'Kilometer', 'symbol' => 'km'],
            ['name' => 'Inci', 'symbol' => 'in'],
            ['name' => 'Kaki', 'symbol' => 'ft'],
            ['name' => 'Yard', 'symbol' => 'yd'],
            ['name' => 'Mil', 'symbol' => 'mi'],

            // Berat / Massa
            ['name' => 'Miligram', 'symbol' => 'mg'],
            ['name' => 'Gram', 'symbol' => 'g'],
            ['name' => 'Kilogram', 'symbol' => 'kg'],
            ['name' => 'Ton', 'symbol' => 't'],
            ['name' => 'Pound', 'symbol' => 'lb'],
            ['name' => 'Ons', 'symbol' => 'oz'],

            // Volume / Cairan
            ['name' => 'Mililiter', 'symbol' => 'ml'],
            ['name' => 'Sentiliter', 'symbol' => 'cl'],
            ['name' => 'Desiliter', 'symbol' => 'dl'],
            ['name' => 'Liter', 'symbol' => 'l'],
            ['name' => 'Meter Kubik', 'symbol' => 'm³'],
            ['name' => 'Galon', 'symbol' => 'gal'],
            ['name' => 'Quart', 'symbol' => 'qt'],

            // Waktu
            ['name' => 'Detik', 'symbol' => 's'],
            ['name' => 'Menit', 'symbol' => 'min'],
            ['name' => 'Jam', 'symbol' => 'h'],
            ['name' => 'Hari', 'symbol' => 'day'],
            ['name' => 'Minggu', 'symbol' => 'wk'],
            ['name' => 'Bulan', 'symbol' => 'mo'],
            ['name' => 'Tahun', 'symbol' => 'yr'],

            // Persen / Rasio
            ['name' => 'Persen', 'symbol' => '%'],

            // Mata Uang
            ['name' => 'Rupiah', 'symbol' => 'IDR'],
            ['name' => 'Dollar AS', 'symbol' => 'USD'],
            ['name' => 'Euro', 'symbol' => 'EUR'],
            ['name' => 'Pound Sterling', 'symbol' => 'GBP'],
            ['name' => 'Yen', 'symbol' => 'JPY'],

            // Unit / Kuantitas
            ['name' => 'Unit', 'symbol' => 'unit'],
            ['name' => 'Buah', 'symbol' => 'pcs'],
            ['name' => 'Set', 'symbol' => 'set'],
            ['name' => 'Pack', 'symbol' => 'pack'],
            ['name' => 'Item', 'symbol' => 'item'],
            ['name' => 'Lembar', 'symbol' => 'sheet'],
            ['name' => 'Roll', 'symbol' => 'roll'],
            ['name' => 'Paket', 'symbol' => 'paket'],

            // Suhu
            ['name' => 'Celsius', 'symbol' => '°C'],
            ['name' => 'Fahrenheit', 'symbol' => '°F'],
            ['name' => 'Kelvin', 'symbol' => 'K'],

            // Kecepatan
            ['name' => 'Meter per Detik', 'symbol' => 'm/s'],
            ['name' => 'Kilometer per Jam', 'symbol' => 'km/h'],
            ['name' => 'Mil per Jam', 'symbol' => 'mph'],

            // Energi / Daya
            ['name' => 'Joule', 'symbol' => 'J'],
            ['name' => 'Kilojoule', 'symbol' => 'kJ'],
            ['name' => 'Kalori', 'symbol' => 'cal'],
            ['name' => 'Kilokalori', 'symbol' => 'kcal'],
            ['name' => 'Watt', 'symbol' => 'W'],
            ['name' => 'Kilowatt', 'symbol' => 'kW'],

            // Tekanan / Gas
            ['name' => 'Pascal', 'symbol' => 'Pa'],
            ['name' => 'Kilopascal', 'symbol' => 'kPa'],
            ['name' => 'Bar', 'symbol' => 'bar'],
            ['name' => 'Atmosfer', 'symbol' => 'atm'],
            ['name' => 'Psi', 'symbol' => 'psi'],
        ];

        // Tambahkan timestamps
        $units = array_map(function($unit) {
            $unit['created_at'] = now();
            $unit['updated_at'] = now();
            return $unit;
        }, $units);

        \DB::table('units')->insert($units);
    }
}
