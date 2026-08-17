<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);


        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@lms.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        $manager = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@lms.com',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole($managerRole);

        $employee = User::factory()->create([
            'name' => 'Employee',
            'email' => 'employee@lms.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole($employeeRole);

        // Leave Types
        LeaveType::query()->firstOrCreate([
            'name' => 'Festival',
        ]);

        LeaveType::query()->firstOrCreate([
            'name' => 'Sick Leave',
        ]);

        LeaveType::query()->firstOrCreate([
            'name' => 'Paid Leave',
        ]);

        // Leaves
        Leave::factory(10)->create();
    }
}
