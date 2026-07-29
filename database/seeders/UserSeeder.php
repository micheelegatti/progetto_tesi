<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creazione utente personale (admin)
        $admin = User::firstOrCreate(
            ['email' => 'admin@test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        //Creo un secondo utente di tipo EDITOR
        $editor = User::firstOrCreate(
            ['email' => 'editor@test'],
            [
                'name' => 'Editor',
                'password' => Hash::make('password123'),
            ]
        );
        $editor->assignRole('editor');

        //Creo un terzo utente di tipo ANALYST
        $editor = User::firstOrCreate(
            ['email' => 'analyst@test'],
            [
                'name' => 'Analyst',
                'password' => Hash::make('password123'),
            ]
        );
        $editor->assignRole('analyst');
    }
}
