<?php

namespace Database\Seeders;

use Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Modules\Workspace\Actions\CreateWorkspaceAction;
use Modules\Workspace\Data\CreateWorkspaceData;
use Modules\Folder\Actions\CreateFolderAction;
use Modules\Folder\Data\CreateFolderData;
use Modules\Metadata\Models\Metadata;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        $testUser1 = User::create([
            'name' => 'Admin User',
            'email' => 'adminuser@example.com', // Change this to a valid gmail
            'password' => '12345678',
            'office_position' => 'Admin Staff',
            'workflow_role' => 'reviewer',
            'system_role' => 'admin',
        ]);

        $testUser2 = User::create([
            'name' => 'Director User',
            'email' => 'directoruser@example.com', // Change this to a valid gmail
            'password' => '12345678',
            'office_position' => 'Director',
            'workflow_role' => 'approver',
            'system_role' => 'viewer',
        ]);

        $testUser4 = User::create([
            'name' => 'Coordinator User',
            'email' => 'coordinatoruser@example.com', // Change this to a valid gmail
            'password' => '12345678',
            'office_position' => 'Coordinator',
            'workflow_role' => 'reviewer',
            'system_role' => 'none',
        ]);

        $testUser1->assignRole('admin');
        $testUser2->assignRole('viewer');
        $testUser4->assignRole('none');

        // Create System Metadata
        Metadata::create([
            'name' => 'Document Number',
            'type' => 'Text',
            'status' => 'system',
        ]);

        Metadata::create([
            'name' => 'Due In',
            'type' => 'Date',
            'status' => 'system',
        ]);

        Metadata::create([
            'name' => 'Review Status',
            'type' => 'Text',
            'status' => 'system',
        ]);

        Metadata::create([
            'name' => 'Approval Status',
            'type' => 'Text',
            'status' => 'system',
        ]);

        // Create Custom Metadata
        Metadata::create([
            'name' => 'Country',
            'type' => 'Text',
            'status' => 'custom',
        ]);

        Metadata::create([
            'name' => 'Published Year',
            'type' => 'Number',
            'status' => 'custom',
        ]);

        Metadata::create([
            'name' => 'Subject',
            'type' => 'Text',
            'status' => 'custom',
        ]);

        Metadata::create([
            'name' => 'For',
            'type' => 'Text',
            'status' => 'custom',
        ]);

        Metadata::create([
            'name' => 'Thru',
            'type' => 'Text',
            'status' => 'custom',
        ]);

        // Create Workspace through folder
        $createWorkspaceAction = app(CreateWorkspaceAction::class);
        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Administrative',
            owned_by: $testUser1->id
        ));

        $workspace2 = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Applications',
            owned_by: $testUser1->id
        ));

        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Services',
            owned_by: $testUser1->id
        ));

        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Partnerships',
            owned_by: $testUser1->id
        ));

        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Memorandums',
            owned_by: $testUser1->id
        ));

        // Create Folder
        $createFolderAction = app(CreateFolderAction::class);
        $folder1 = $createFolderAction->execute(new CreateFolderData(
            parent_id: $workspace2->item_id,
            name: 'Student Inbound',
            owned_by: $testUser1->id
        ));

        $folder2 = $createFolderAction->execute(new CreateFolderData(
            parent_id: $workspace2->item_id,
            name: 'Student Outbound',
            owned_by: $testUser1->id
        ));

        $folder3 = $createFolderAction->execute(new CreateFolderData(
            parent_id: $folder2->item_id,
            name: 'Belgium 2024',
            owned_by: $testUser1->id
        ));

        $folder4 = $createFolderAction->execute(new CreateFolderData(
            parent_id: $folder3->item_id,
            name: 'John Doe',
            owned_by: $testUser1->id
        ));

        $folder5 = $createFolderAction->execute(new CreateFolderData(
            parent_id: $folder3->item_id,
            name: 'Mary Jane',
            owned_by: $testUser1->id
        ));
    }
}
