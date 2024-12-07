<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissions for Web Guard
        $webPermissions = [
            'view role',
            'create role',
            'update role',
            'delete role',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'view user',
            'create user',
            'update user',
            'delete user',
        ];

        foreach ($webPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Permissions for API Guard
        $apiPermissions = [
            'view role',
            'create role',
            'update role',
            'delete role',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'view user',
            'create user',
            'update user',
            'delete user',
        ];

        foreach ($apiPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        // Create Roles for Web Guard
        $webSuperAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $webAdminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $webStaffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $webUserRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Create Roles for API Guard
        $apiSuperAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'api']);
        $apiAdminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $apiStaffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'api']);
        $apiUserRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);

        // Assign Permissions to Roles
        $allWebPermissionNames = Permission::where('guard_name', 'web')->pluck('name')->toArray();
        $webSuperAdminRole->syncPermissions($allWebPermissionNames);

        $allApiPermissionNames = Permission::where('guard_name', 'api')->pluck('name')->toArray();
        $apiSuperAdminRole->syncPermissions($allApiPermissionNames);

        // Assign limited permissions to admin role
        $webAdminPermissions = ['create role', 'view role', 'update role', 'create permission', 'view permission', 'create user', 'view user', 'update user'];
        $webAdminRole->syncPermissions($webAdminPermissions);

        $apiAdminPermissions = ['create role', 'view role', 'update role', 'create permission', 'view permission', 'create user', 'view user', 'update user'];
        $apiAdminRole->syncPermissions($apiAdminPermissions);

        // Create Web Users and Assign Roles
        $superAdminUser = User::firstOrCreate([
            'email' => 'superadmin@gmail.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('12345678'),
        ]);
        $superAdminUser->assignRole([$webSuperAdminRole, $apiSuperAdminRole]);

        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
        ]);
        $adminUser->assignRole([$webAdminRole, $apiAdminRole]);

        $staffUser = User::firstOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'name' => 'Staff Web',
            'password' => Hash::make('12345678'),
        ]);
        $staffUser->assignRole([$webStaffRole, $apiStaffRole]);
    }
}
