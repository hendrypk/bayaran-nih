<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

            //User
            Permission::create(['name' => 'create user', 'group_name' => 'user']);
            Permission::create(['name' => 'update user', 'group_name' => 'user']);
            Permission::create(['name' => 'delete user', 'group_name' => 'user']);
            Permission::create(['name' => 'view user', 'group_name' => 'user']);

            //Role
            Permission::create(['name' => 'create role', 'group_name' => 'role']);
            Permission::create(['name' => 'update role', 'group_name' => 'role']);
            Permission::create(['name' => 'delete role', 'group_name' => 'role']);
            Permission::create(['name' => 'view role', 'group_name' => 'role']);

            // //Employee
            // Permission::create(['name' => 'create employee']);
            // Permission::create(['name' => 'update employee']);
            // Permission::create(['name' => 'delete employee']);
            // Permission::create(['name' => 'view employee']);
            //Presence
            // Permission::create(['name' => 'create presence']);
            // Permission::create(['name' => 'update presence']);
            // Permission::create(['name' => 'delete presence']);
            // Permission::create(['name' => 'view presence']);
            // Permission::create(['name' => 'view presence summary']);
            // Permission::create(['name' => 'export presence']);
            // Permission::create(['name' => 'export presence summary']);
            // //Performance
            // Permission::create(['name' => 'create kpi']);
            // Permission::create(['name' => 'update kpi']);
            // Permission::create(['name' => 'delete kpi']);
            // Permission::create(['name' => 'view kpi']);
            // Permission::create(['name' => 'create pa']);
            // Permission::create(['name' => 'update pa']);
            // Permission::create(['name' => 'delete pa']);
            // Permission::create(['name' => 'view pa']);
            // Permission::create(['name' => 'view pm']);
            // Permission::create(['name' => 'export kpi']);
            // Permission::create(['name' => 'export pa']);
            // Permission::create(['name' => 'export pm']);
            // //Performance Options
            // Permission::create(['name' => 'create pm']);
            // Permission::create(['name' => 'update pm']);
            // Permission::create(['name' => 'delete pm']);
            // Permission::create(['name' => 'view pm options']);
            // //sales
            // Permission::create(['name' => 'create sales']);
            // Permission::create(['name' => 'update sales']);
            // Permission::create(['name' => 'delete sales']);
            // Permission::create(['name' => 'view sales']);
            // //Opions
            // Permission::create(['name' => 'create options']);
            // Permission::create(['name' => 'update options']);
            // Permission::create(['name' => 'delete options']);
            // Permission::create(['name' => 'view options']);
            // //Workk Pattern
            // Permission::create(['name' => 'create work pattern']);
            // Permission::create(['name' => 'update work pattern']);
            // Permission::create(['name' => 'delete work pattern']);
            // Permission::create(['name' => 'view work pattern']);

            //Overtime
        //     Permission::create(['name' => 'view-overtime']);
        //     Permission::create(['name' => 'delete-overtime']);
        //     Permission::create(['name' => 'add-overtime']);
        //     Permission::create(['name' => 'update-overtime']);

        // // create roles and assign existing permissions
        // $role1 = Role::create(['name' => 'kadiv']);
        // $role1->givePermissionTo('view-overtime');

        // $role2 = Role::create(['name' => 'staff hr']);
        // $role2->givePermissionTo('view-overtime');
        // $role2->givePermissionTo('delete-overtime');
        // $role2->givePermissionTo('add-overtime');
        // $role2->givePermissionTo('update-overtime');

        // $role3 = Role::create(['name' => 'Super-Admin']);
        // // gets all permissions via Gate::before rule; see AuthServiceProvider

        // // create demo users
        // $user = \App\Models\User::factory()->create([
        //     'name' => 'hrga',
        //     'email' => 'harga@maketees.com',
        // ]);
        // $user->assignRole($role2);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'kadiv',
        //     'email' => 'kadiv@maketees.com',
        // ]);
        // $user->assignRole($role1);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'superadmin',
        //     'email' => 'superadmin@example.com',
        // ]);
        // $user->assignRole($role3);
    }
}
