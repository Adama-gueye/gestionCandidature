<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Créer un utilisateur administrateur
        User::create([
            'nom' => 'Gueye',
            'prenom' => 'Adama',
            'age' => '24',
            'tel' => '775003108',
            'email' => 'adamagu99@gmail.com',
            'password' => Hash::make('Ada20865'),
            'role' => 'admin',
        ]);
    }
}
