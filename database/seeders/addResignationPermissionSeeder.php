<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class addResignationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'view resignation', 'group_name' => 'resignation', 'guard_name' => 'web'],
            ['name' => 'create resignation', 'group_name' => 'resignation', 'guard_name' => 'web'],
            ['name' => 'update resignation', 'group_name' => 'resignation', 'guard_name' => 'web'],
            ['name' => 'delete resignation', 'group_name' => 'resignation', 'guard_name' => 'web'],
        ]);
    }
}
