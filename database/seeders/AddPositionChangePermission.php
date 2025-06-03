<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddPositionChangePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'view position change', 'group_name' => 'position change', 'guard_name' => 'web'],
            ['name' => 'create position change', 'group_name' => 'position change', 'guard_name' => 'web'],
            ['name' => 'delete position change', 'group_name' => 'position change', 'guard_name' => 'web'],
            ['name' => 'update position change', 'group_name' => 'position change', 'guard_name' => 'web'],
        ]);
    }
}
