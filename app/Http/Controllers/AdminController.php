<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data['total_applications'] = User::count();
        return view('backend.dashboard',compact('data'));
    }

    public function resyncPermissions()
    {
        // -------------------------------
        // 1️⃣ Define Modules
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

        $singlePermissions = [
            'view dashboard',
        ];

        $allPermissions = [];

        // -------------------------------
        // 2️⃣ Create / Update Module Permissions
        // -------------------------------
        foreach ($modules as $module) {
            foreach (['view','create','edit','delete'] as $action) {
                $permissionName = "{$action} {$module}";
                Permission::updateOrCreate(
                    ['name' => $permissionName],
                    ['guard_name' => 'web']
                );
                $allPermissions[] = $permissionName;
            }
        }

        // -------------------------------
        // 3️⃣ Create / Update Single Permissions
        // -------------------------------
        foreach ($singlePermissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm],
                ['guard_name' => 'web']
            );
            $allPermissions[] = $perm;
        }

        // -------------------------------
        // 4️⃣ Remove old permissions safely
        // -------------------------------
        $permissionsToRemove = Permission::whereNotIn('name', $allPermissions)->get();

        foreach ($permissionsToRemove as $permission) {
            // Remove from all roles
            foreach ($permission->roles as $role) {
                $role->revokePermissionTo($permission);
            }
            // Delete the permission
            $permission->delete();
        }

        dd('Permissions fully synced successfully!');
    }

}
