<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter admin name', 'Admin');
        $email = $this->ask('Enter admin email', 'admin@restaurant.com');
        $password = $this->secret('Enter admin password');

        try {
            \App\Models\Admin\Admin::create([
                'name' => $name,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
            ]);

            $this->info('Admin user created successfully!');
            $this->info('Email: ' . $email);
            $this->info('You can now login at: http://127.0.0.1:8000/admin/login');
        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
        }
    }
}
