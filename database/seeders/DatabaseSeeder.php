<?php

namespace Database\Seeders;

use Acquire\Modules\Customer\Models\Customer;
use Acquire\Modules\User\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the command to create a personal access client
        Artisan::call('passport:client', [
            '--personal' => true,
            '--name' => 'Personal Access Client',
        ]);

        $this->command->info('Personal access client created successfully.');

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Customer::factory(15)->create();

        Artisan::call('l5-swagger:generate');

        Artisan::call('optimize');
    }
}
