<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create member user
        $member = User::create([
            'name' => 'Test Member',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // Create sample projects
        $project1 = Project::create([
            'name' => 'Website Redesign',
            'description' => 'Complete redesign of the company website with modern UI/UX.',
            'created_by' => $admin->id,
        ]);

        $project2 = Project::create([
            'name' => 'Mobile App Development',
            'description' => 'Build a cross-platform mobile app for customer engagement.',
            'created_by' => $admin->id,
        ]);

        // Create sample tasks
        Task::create([
            'title' => 'Design Homepage Mockup',
            'description' => 'Create wireframes and mockups for the new homepage.',
            'status' => 'TODO',
            'priority' => 'HIGH',
            'due_date' => Carbon::now()->addDays(7),
            'project_id' => $project1->id,
            'assigned_to' => $member->id,
            'created_by' => $admin->id,
        ]);

        Task::create([
            'title' => 'Set up CI/CD Pipeline',
            'description' => 'Configure automated testing and deployment pipeline.',
            'status' => 'IN_PROGRESS',
            'priority' => 'MEDIUM',
            'due_date' => Carbon::now()->addDays(3),
            'project_id' => $project1->id,
            'assigned_to' => $member->id,
            'created_by' => $admin->id,
        ]);

        Task::create([
            'title' => 'Write API Documentation',
            'description' => 'Document all REST API endpoints.',
            'status' => 'TODO',
            'priority' => 'LOW',
            'due_date' => Carbon::now()->subDays(2), // Past due — for testing overdue
            'project_id' => $project2->id,
            'assigned_to' => $member->id,
            'created_by' => $admin->id,
        ]);

        Task::create([
            'title' => 'Implement User Authentication',
            'description' => 'Set up login/register flow in the mobile app.',
            'status' => 'DONE',
            'priority' => 'HIGH',
            'due_date' => Carbon::now()->subDays(1),
            'project_id' => $project2->id,
            'assigned_to' => $member->id,
            'created_by' => $admin->id,
        ]);
    }
}
