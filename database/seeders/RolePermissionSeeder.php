<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperAdmin = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'dashboard',
        ]);

        $roleSuperAdmin = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'superadmin',
        ]);
        $roleAdmin = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'admin',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'documentation',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'bodyselection',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'aptitude',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'basicfitness',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'outdoorleaderless',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'medicals',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'vetting',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'interview',
        ]);

        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-documentation',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-bodyselection',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-aptitude',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-basicfitness',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-outdoorleaderless',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-medical',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-vetting',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user-interview',
        ]);
        // Permission List as array
        $permissions = [
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ],
            ],
            [
                'group_name' => 'superadmin',
                'permissions' => [
                    // superadmin Permissions
                    'superadmin.create',
                    'superadmin.view',
                    'superadmin.edit',
                    'superadmin.delete',
                    'superadmin.approve',
                ],
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.approve',
                ],
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ],
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    // role Permissions
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                    'user.approve',
                ],
            ],
            [
                'group_name' => 'documentation',
                'permissions' => [
                    'documentation.view',
                    'documentation.edit',
                ],
            ],
            [
                'group_name' => 'bodyselection',
                'permissions' => [
                    'bodyselection.view',
                    'bodyselection.edit',
                ],
            ],
            [
                'group_name' => 'aptitude',
                'permissions' => [
                    'aptitude.view',
                    'aptitude.edit',
                ],
            ],
            [
                'group_name' => 'basicfitness',
                'permissions' => [
                    'basicfitness.view',
                    'basicfitness.edit',
                ],
            ],
            [
                'group_name' => 'outdoorleaderless',
                'permissions' => [
                    'outdoorleaderless.view',
                    'outdoorleaderless.edit',
                ],
            ],
            [
                'group_name' => 'medicals',
                'permissions' => [
                    'medicals.view',
                    'medicals.edit',
                ],
            ],
            [
                'group_name' => 'vetting',
                'permissions' => [
                    'vetting.view',
                    'vetting.edit',
                ],
            ],
            [
                'group_name' => 'interview',
                'permissions' => [
                    'interview.view',
                    'interview.edit',
                ],
            ],
            [
                'group_name' => 'user-documentation',
                'permissions' => [
                    'view.documentation',
                ],
            ],
            [
                'group_name' => 'user-bodyselection',
                'permissions' => [
                    'view.bodyselection',
                ],
            ],
            [
                'group_name' => 'user-aptitude',
                'permissions' => [
                    'view.aptitude',
                ],
            ],
            [
                'group_name' => 'user-basicfitness',
                'permissions' => [
                    'view.basicfitness',
                ],
            ],
            [
                'group_name' => 'user-outdoorleaderless',
                'permissions' => [
                    'view.outdoorleaderless',
                ],
            ],
            [
                'group_name' => 'user-medical',
                'permissions' => [
                    'view.medical',
                ],
            ],
            [
                'group_name' => 'user-vetting',
                'permissions' => [
                    'view.vetting',
                ],
            ],
            [
                'group_name' => 'user-interview',
                'permissions' => [
                    'view.interview',
                ],
            ],
        ];

        foreach ($permissions as $permissionGroup) {
            $groupName = $permissionGroup['group_name'];
            foreach ($permissionGroup['permissions'] as $permissionName) {
                $permission = Permission::create([
                    'uuid' => Str::uuid(),
                    'name' => $permissionName,
                    'group_name' => $groupName,
                ]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }
    }
}
