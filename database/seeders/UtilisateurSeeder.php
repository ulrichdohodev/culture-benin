<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run()
    {
        $utilisateurs = [
            [
                'nom' => 'Admin',
                'prenom' => 'System',
                'email' => 'admin@culture-benin.bj',
                'mot_de_passe' => Hash::make('password123'),
                'sexe' => 'M',
                'date_naissance' => '1980-01-01',
                'statut' => 'actif',
                'id_role' => 1,
                'id_langue' => 1,
                'email_verified_at' => now(),
            ],
            [
                'nom' => 'Doe',
                'prenom' => 'John',
                'email' => 'moderateur@culture-benin.bj',
                'mot_de_passe' => Hash::make('password123'),
                'sexe' => 'M',
                'date_naissance' => '1985-05-15',
                'statut' => 'actif',
                'id_role' => 2,
                'id_langue' => 1,
                'email_verified_at' => now(),
            ],
            [
                'nom' => 'Sagbo',
                'prenom' => 'Marie',
                'email' => 'marie.sagbo@culture-benin.bj',
                'mot_de_passe' => Hash::make('password123'),
                'sexe' => 'F',
                'date_naissance' => '1990-08-20',
                'statut' => 'actif',
                'id_role' => 3,
                'id_langue' => 2,
                'email_verified_at' => now(),
            ],
            [
                'nom' => 'Kouassi',
                'prenom' => 'Jean',
                'email' => 'jean.kouassi@example.bj',
                'mot_de_passe' => Hash::make('password123'),
                'sexe' => 'M',
                'date_naissance' => '1992-03-10',
                'statut' => 'actif',
                'id_role' => 4,
                'id_langue' => 1,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($utilisateurs as $utilisateur) {
            Utilisateur::create($utilisateur);
        }
    }
}