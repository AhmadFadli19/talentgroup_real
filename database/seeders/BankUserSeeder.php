<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BankUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if bank users already exist
        $bankUserExists = DB::table('users')->where('email', 'bank@example.com')->exists();
        
        if (!$bankUserExists) {
            DB::table('users')->insert([
                [
                    'name' => 'Bank Officer',
                    'email' => 'talentgroup.bank@gmail.com',
                    'password' => Hash::make('password'),
                    'role_id' => 3, // Bank role
                    'balance' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Bank Manager',
                    'email' => 'talentgroup.manager@gmail.com',
                    'password' => Hash::make('password'),
                    'role_id' => 3, // Bank role
                    'balance' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}