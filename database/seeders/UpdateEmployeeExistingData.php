<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UpdateEmployeeExistingData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Education
        DB::table('employees')
            ->where('education', 'unknown')
            ->update(['education' => 'senior_school']);

        DB::table('employees')
            ->where('education', 'Junior School')
            ->update(['education' => 'junior_school']);

        DB::table('employees')
            ->where('education', 'Senior School')
            ->update(['education' => 'senior_school']);

        DB::table('employees')
            ->where('education', 'High School')
            ->update(['education' => 'high_school']);

        DB::table('employees')
            ->where('education', 'Diploma')
            ->update(['education' => 'diploma']);

        DB::table('employees')
            ->where('education', 'Bachelor\'s Degree')
            ->update(['education' => 'bachelor']);

        DB::table('employees')
            ->where('education', 'Master\'s Degree')
            ->update(['education' => 'master']);

        DB::table('employees')
            ->where('education', 'Doctorate')
            ->update(['education' => 'doctorate']);

        // Religion
        DB::table('employees')
            ->where('religion', 'Islam')
            ->update(['religion' => 'islam']);

        DB::table('employees')
            ->where('religion', 'Christian')
            ->update(['religion' => 'christian']);

        DB::table('employees')
            ->where('religion', 'Catholic')
            ->update(['religion' => 'catholic']);

        DB::table('employees')
            ->where('religion', 'Hindu')
            ->update(['religion' => 'hindu']);

        DB::table('employees')
            ->where('religion', 'Buddha')
            ->update(['religion' => 'buddha']);

        DB::table('employees')
            ->where('religion', 'Confucianism')
            ->update(['religion' => 'konghuchu']);

        DB::table('employees')
            ->where('religion', 'Others')
            ->update(['religion' => 'islam']); 

        //Marrital
        DB::table('employees')
        ->where('marriage', 'unkown')
        ->update(['marriage' => 'single']);

        DB::table('employees')
            ->where('marriage', 'Single')
            ->update(['marriage' => 'single']);

        DB::table('employees')
            ->where('marriage', 'Married')
            ->update(['marriage' => 'married']);

        DB::table('employees')
            ->where('marriage', 'Widowed')
            ->update(['marriage' => 'widowed']);

        // Jika status 'Divorced' ada, ubah menjadi 'single'
        DB::table('employees')
            ->where('marriage', 'Divorced')
            ->update(['marriage' => 'single']);
    }
}
