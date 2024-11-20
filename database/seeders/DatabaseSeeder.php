<?php

namespace Database\Seeders;

// use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {      
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        DB::table('permissions')->insert([
            ['name' => 'view overtime', 'group_name' => 'overtime', 'guard_name' => 'web'],
            ['name' => 'create overtime', 'group_name' => 'overtime', 'guard_name' => 'web'],
            ['name' => 'update overtime', 'group_name' => 'overtime', 'guard_name' => 'web'],
            ['name' => 'create employee', 'group_name' => 'employee', 'guard_name' => 'web'],
            ['name' => 'update employee', 'group_name' => 'employee', 'guard_name' => 'web'],
            ['name' => 'delete employee', 'group_name' => 'employee', 'guard_name' => 'web'],
            ['name' => 'view employee', 'group_name' => 'employee', 'guard_name' => 'web'],
            ['name' => 'create presence', 'group_name' => 'presence', 'guard_name' => 'web'],
            ['name' => 'update presence', 'group_name' => 'presence', 'guard_name' => 'web'],
            ['name' => 'delete presence', 'group_name' => 'presence', 'guard_name' => 'web'],
            ['name' => 'view presence', 'group_name' => 'presence', 'guard_name' => 'web'],
            ['name' => 'view presence summary', 'group_name' => 'presence summary', 'guard_name' => 'web'],
            ['name' => 'presence export', 'group_name' => 'presence export', 'guard_name' => 'web'],
            ['name' => 'export presence summary', 'group_name' => 'presence summary', 'guard_name' => 'web'],
            ['name' => 'create kpi', 'group_name' => 'kpi', 'guard_name' => 'web'],
            ['name' => 'update kpi', 'group_name' => 'kpi', 'guard_name' => 'web'],
            ['name' => 'delete kpi', 'group_name' => 'kpi', 'guard_name' => 'web'],
            ['name' => 'view kpi', 'group_name' => 'kpi', 'guard_name' => 'web'],
            ['name' => 'create pa', 'group_name' => 'appraisal', 'guard_name' => 'web'],
            ['name' => 'update pa', 'group_name' => 'appraisal', 'guard_name' => 'web'],
            ['name' => 'delete pa', 'group_name' => 'appraisal', 'guard_name' => 'web'],
            ['name' => 'view pa', 'group_name' => 'appraisal', 'guard_name' => 'web'],
            ['name' => 'view pm', 'group_name' => 'performance options', 'guard_name' => 'web'],
            ['name' => 'export-kpi', 'group_name' => 'employee grade', 'guard_name' => 'web'],
            ['name' => 'export-pa', 'group_name' => 'employee grade', 'guard_name' => 'web'],
            ['name' => 'export-final-grade', 'group_name' => 'employee grade', 'guard_name' => 'web'],
            ['name' => 'create pm', 'group_name' => 'performance options', 'guard_name' => 'web'],
            ['name' => 'update pm', 'group_name' => 'performance options', 'guard_name' => 'web'],
            ['name' => 'delete pm', 'group_name' => 'performance options', 'guard_name' => 'web'],
            ['name' => 'view employee grade', 'group_name' => 'employee grade', 'guard_name' => 'web'],
            ['name' => 'create sales', 'group_name' => 'sales', 'guard_name' => 'web'],
            ['name' => 'update sales', 'group_name' => 'sales', 'guard_name' => 'web'],
            ['name' => 'delete sales', 'group_name' => 'sales', 'guard_name' => 'web'],
            ['name' => 'view sales', 'group_name' => 'sales', 'guard_name' => 'web'],
            ['name' => 'create options', 'group_name' => 'options', 'guard_name' => 'web'],
            ['name' => 'update options', 'group_name' => 'options', 'guard_name' => 'web'],
            ['name' => 'delete options', 'group_name' => 'options', 'guard_name' => 'web'],
            ['name' => 'view options', 'group_name' => 'options', 'guard_name' => 'web'],
            ['name' => 'create work pattern', 'group_name' => 'work pattern', 'guard_name' => 'web'],
            ['name' => 'update work pattern', 'group_name' => 'work pattern', 'guard_name' => 'web'],
            ['name' => 'delete work pattern', 'group_name' => 'work pattern', 'guard_name' => 'web'],
            ['name' => 'view work pattern', 'group_name' => 'work pattern', 'guard_name' => 'web'],
            ['name' => 'delete overtime', 'group_name' => 'overtime', 'guard_name' => 'web'],
            ['name' => 'create user', 'group_name' => 'user', 'guard_name' => 'web'],
            ['name' => 'update user', 'group_name' => 'user', 'guard_name' => 'web'],
            ['name' => 'delete user', 'group_name' => 'user', 'guard_name' => 'web'],
            ['name' => 'view user', 'group_name' => 'user', 'guard_name' => 'web'],
            ['name' => 'create role', 'group_name' => 'role', 'guard_name' => 'web'],
            ['name' => 'update role', 'group_name' => 'role', 'guard_name' => 'web'],
            ['name' => 'delete role', 'group_name' => 'role', 'guard_name' => 'web'],
            ['name' => 'view role', 'group_name' => 'role', 'guard_name' => 'web'],
            ['name' => 'overtime export', 'group_name' => 'presence export', 'guard_name' => 'web'],
            ['name' => 'view leave', 'group_name' => 'leave', 'guard_name' => 'web'],
            ['name' => 'create leave', 'group_name' => 'leave', 'guard_name' => 'web'],
            ['name' => 'update leave', 'group_name' => 'leave', 'guard_name' => 'web'],
            ['name' => 'delete leave', 'group_name' => 'leave', 'guard_name' => 'web']
        ]);
        
        // Create the role
        $role = Role::firstOrCreate([
            'name' => 'administrator',
            'guard_name' => 'web'
        ]);

        // Assign all permissions to the 'administrator' role
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        //Create user
        DB::table('users')->insert([
            'name'=>'Admin Super',
            'username' => 'administrator',
            'email'=>'admin@gajiplus.id',
            'password'=>Hash::make('administrator')
        ]);

        //Assign role to users
        $user = User::find(1);
        $user->assignRole($role);
        DB::table('positions')->insert([
            ['name' => 'Chief Executive Officer'],
            ['name' => 'Chief Business Officer'],
            ['name' => 'Corporate Secretary'],
            ['name' => 'General Manager'],
            ['name' => 'Manager of Finance & Accounting'],
            ['name' => 'Manager of Operations'],
            ['name' => 'Manager of Marketing'],
            ['name' => 'Manager of HRGA'],
            ['name' => 'Head of Finishing'],
            ['name' => 'Head of PPIC'],
            ['name' => 'Head of Embroidery'],
            ['name' => 'Head of Sewing'],
            ['name' => 'Head of Cutting'],
            ['name' => 'Head of Screenprinting'],
            ['name' => 'Leader of Embroidery Design'],
            ['name' => 'Leader of Embroidery'],
            ['name' => 'Content Creator'],
            ['name' => 'Embroidery Designer Staff'],
            ['name' => 'Customer Service'],
            ['name' => 'Manager of Sales'],
            ['name' => 'Customer Care'],
            ['name' => 'Sales Administration'],
            ['name' => 'Warehouse Staff'],
            ['name' => 'Purchasing & Runner Staff'],
            ['name' => 'Staff GM'],
            ['name' => 'Operations Administration Staff'],
            ['name' => 'Screenprinting Operator'],
            ['name' => 'Asisten Rumah Tangga'],
            ['name' => 'Office Boy'],
            ['name' => 'Finance & Accounting Staff'],
            ['name' => 'Embroidery Operator'],
            ['name' => 'Cutting Operator'],
            ['name' => 'Sewing Operator'],
            ['name' => 'Finishing Operator'],
            ['name' => 'Warehouse Admin'],
            ['name' => 'Staff Khusus'],
            ['name' => 'Afdruk Operator'],
            ['name' => 'Screenprinting Helper'],
            ['name' => 'Sewing Line Operator'],
            ['name' => 'Designer Staff'],
            ['name' => 'Sewing Helper'],
            ['name' => 'Advertiser'],
            ['name' => 'Screenprinting Designer'],
            ['name' => 'Sewing Staff'],
            ['name' => 'HRGA Staff'],
        ]);
        

        //Create Job Title
        DB::table('job_titles')->insert([
            ['name' => 'Chief Level', 'section' => '1'],
            ['name' => 'Departement Manager', 'section' => '2'],
            ['name' => 'Division Head', 'section' => '3'],
            ['name' => 'Team Leader', 'section' => '4'],
            ['name' => 'Staff', 'section' => '5'],
            ['name' => 'Operator', 'section' => '6'],
        ]);

        //Create division
        DB::table('divisions')->insert([
            ['name' => 'Finishing'],
            ['name' => 'PPIC'],
            ['name' => 'Embroidery'],
            ['name' => 'Sewing'],
            ['name' => 'Cutting'],
            ['name' => 'Screenprinting'],
            ['name' => 'Design'],
            ['name' => 'Hospitality & Administration'],
            ['name' => 'Sewing Line'],
        ]);
        

        //Create department
        DB::table('departments')->insert([
            ['name' => 'C-Level'],
            ['name' => 'General'],
            ['name' => 'Finance & Accounting'],
            ['name' => 'Operation'],
            ['name' => 'Marketing'],
            ['name' => 'HRGA'],
            ['name' => 'Sales'],
        ]);
        

        //create employee status
        DB::table('employee_status')->insert([
            ['name' => 'Kontrak'],
            ['name' => 'Tetap'],
            ['name' => 'Harian Lepas'],
        ]);
        
    }
}
