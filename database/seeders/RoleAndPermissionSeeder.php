<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();

        $permissionList = [
            [
                "name"      => "manage_categories",
                "module_id" => 1,
            ],
        ];

        foreach ($permissionList as $permission) {
            Permission::create([
                'name'       => $permission['name'],
                'module_id'  => $permission['module_id'],
                'guard_name' => 'web',
            ]);
        }

        Role::insert([
            ['name' => "Super Admin", 'label' => "Full Access", 'guard_name' => 'web'],
            ['name' => "Lead/Supervisor", 'label' => "Connect with members for leave approval purpose; leave application access with related members", 'guard_name' => 'web'],
            ['name' => "Standard Employee", 'label' => "Only can access for own profile; Connect with leader for leave approval purpose", 'guard_name' => 'web'],
        ]);

        $role = Role::where('name', 'Super Admin')->first();
        $role->givePermissionTo(Permission::all());

        $admin = User::create([
            'name'              => 'VORP Admin',
            'email'             => 'vorp@visibleone.com',
            'enable'            => 1,
            'email_verified_at' => now(),
            'password'          => Hash::make('VOadmin123!@#'),
            'remember_token'    => Str::random(10),
        ]);

        // $admin = User::find(1);

        $roles = Role::whereIn('name', ['Super Admin'])->get();
        $admin->assignRole($roles);
        $admin->givePermissionTo(Permission::all());
    }
}
