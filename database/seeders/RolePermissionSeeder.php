<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Model-based permissions format (Action:Model)
        $models = [
            'Complaint', 'Document', 'Letter', 'User', 'Setting', 
            'Report', 'Banner', 'Post', 'Category', 'Agenda', 'Announcement', 'LetterTemplate', 'Role'
        ];

        $actions = [
            'ViewAny', 'View', 'Create', 'Update', 'Delete', 'DeleteAny',
            'Restore', 'RestoreAny', 'ForceDelete', 'ForceDeleteAny', 'Replicate', 'Reorder'
        ];

        // Create standard CRUD permissions for all models
        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}:{$model}", 'guard_name' => 'web']);
            }
        }
        
        // Custom specific permissions
        $customPermissions = [
            'UpdateStatus:Complaint',
            'Publish:Document',
            'Sign:Letter',
            'Assign:Role',
            'Export:Report',
        ];
        foreach ($customPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super Admin - full access
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Administrator - content & user management
        $administrator = Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        $administrator->givePermissionTo([
            'ViewAny:Document', 'View:Document', 'Create:Document', 'Update:Document', 'Publish:Document',
            'ViewAny:Complaint', 'View:Complaint',
            'ViewAny:User', 'View:User', 'Create:User', 'Update:User',
            'ViewAny:Setting', 'View:Setting', 'Update:Setting',
            'ViewAny:Banner', 'View:Banner', 'Create:Banner', 'Update:Banner', 'Delete:Banner',
            'ViewAny:Post', 'View:Post', 'Create:Post', 'Update:Post', 'Delete:Post',
            'ViewAny:Category', 'View:Category', 'Create:Category', 'Update:Category', 'Delete:Category',
        ]);

        // Verifikator - complaint reviewer
        $verifikator = Role::firstOrCreate(['name' => 'verifikator', 'guard_name' => 'web']);
        $verifikator->givePermissionTo([
            'ViewAny:Complaint', 'View:Complaint', 'UpdateStatus:Complaint', 'Update:Complaint'
        ]);

        // Atasan / Pimpinan - approver & signer
        $atasan = Role::firstOrCreate(['name' => 'atasan', 'guard_name' => 'web']);
        $atasan->givePermissionTo([
            'ViewAny:Complaint', 'View:Complaint',
            'ViewAny:Letter', 'View:Letter', 'Create:Letter', 'Update:Letter', 'Sign:Letter',
            'ViewAny:Report', 'View:Report', 'Export:Report',
        ]);

        // Editor - content creator
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $editor->givePermissionTo([
            'ViewAny:Document', 'View:Document', 'Create:Document', 'Update:Document',
            'ViewAny:Post', 'View:Post', 'Create:Post', 'Update:Post',
            'ViewAny:Banner', 'View:Banner', 'Create:Banner', 'Update:Banner',
        ]);

        $this->command->info('Roles & Permissions seeded successfully!');
    }
}
