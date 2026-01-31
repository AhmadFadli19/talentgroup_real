<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'System administrator with full access to manage courses, users, and content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Regular user who can purchase and take courses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'developer',
                'display_name' => 'Bank Officer',
                'description' => 'Manages financial transactions and user balances',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($roles as $role) {
            // Check if role already exists
            $exists = DB::table('roles')->where('name', $role['name'])->exists();
            
            if (!$exists) {
                DB::table('roles')->insert($role);
            }
        }
    }
}