<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding database...');
        // Step 1: Seed roles & permissions
        $this->call(RolePermissionSeeder::class);

        // Step 2: Seed default site settings
        $this->call(DefaultSettingSeeder::class);

        // Step 2.5: Seed professional PPID official letter templates
        $this->call(LetterTemplateSeeder::class);

        // Step 2.6: Seed content
        $this->call(ContentSeeder::class);

        // Step 3: Create Super Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => "superadmin@smkn2sumedang.sch.id"],
            [
                'name'     => 'Super Administrator',
                'password' => bcrypt('password'),
                'jabatan'  => 'Administrator',
            ]
        );
        $superAdmin->assignRole('super_admin');

        $this->command->info('✓ Super Admin: superadmin@smkn2sumedang.sch.id | password: password');
    }
}
