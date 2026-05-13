<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // -------------------------------
        // 1️⃣ Reset Roles & Permissions (keep users)
        // php artisan db:seed --class=RolePermissionSeeder
        // -------------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // -------------------------------
        // 2️⃣ Define Modules
        // -------------------------------
        $modules = [
            'products',
            'categories',
            'brands',
            'units',
            'tags',
            'attributes',
            'warranties',
            'orders',
            'sale requisition',
            'sale approve',
            'customers',
            'stores',
            'employees',
            'users',
            'roles',
            'properties',
            'managed jobs',
            'team logs',
            'daily finances',
            'todo appointments',
            'expired products',
            'low stocks',
            'label print',
            'stock manage',
            'stock adjustment',
            'stock transfer',
            'home slides',
            'promotion banners',
            'pages',
            'seo',
            'blogs',
            'developer api',
            'settings',
        ];

        // -------------------------------
        // 3️⃣ Create Permissions
        // -------------------------------
        $permissions = [];
        foreach ($modules as $module) {
            foreach (['view', 'create', 'edit', 'delete'] as $action) {
                $permissionName = "{$action} {$module}";
                Permission::firstOrCreate(['name' => $permissionName]);
                $permissions[] = $permissionName;
            }
        }

        // 🟢 Add extra single permission's
        $extraPermissions = [
            'view dashboard',
        ];
        foreach ($extraPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
        $permissions = array_merge($permissions, $extraPermissions);

        // -------------------------------
        // 4️⃣ Create Roles
        // -------------------------------
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // -------------------------------
        // 5️⃣ Assign Permissions
        // -------------------------------
        $superAdminRole->syncPermissions($permissions); // Super Admin: all permissions
        $adminRole->syncPermissions($permissions);      // Admin: all permissions

        // Customer: only view developer api & dashboard
        $employeePermissions = array_filter($permissions, function($p) {
            return str_starts_with($p, 'view') && (str_contains($p, 'view sale requisition') || str_contains($p, 'view dashboard'));
        });
        $employeeRole->syncPermissions($employeePermissions);

        // -------------------------------
        // 6️⃣ Assign Roles to Default Users
        // -------------------------------
        $superAdmin = User::firstOrCreate(
            ['email' => 'super@gmail.com'],
            ['name' => 'Super Admin', 'password' => 'super12345']
        );
        $superAdmin->syncRoles([$superAdminRole]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin User', 'password' => 'admin12345']
        );
        $admin->syncRoles([$adminRole]);

        $employee = User::firstOrCreate(
            ['email' => 'employee@gmail.com'],
            ['name' => 'Employee User', 'password' => 'employee12345']
        );
        $employee->syncRoles([$employeeRole]);

        $this->command->info('✅ Roles & Permissions refreshed successfully!');
    }
}
