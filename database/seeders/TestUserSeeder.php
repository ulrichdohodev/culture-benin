<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Langue;
use App\Models\Utilisateur;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rôles de base
        $roleAdmin = Role::firstOrCreate(['nom_role' => 'Administrateur']);
        $roleModerator = Role::firstOrCreate(['nom_role' => 'Modérateur']);
        $roleContributor = Role::firstOrCreate(['nom_role' => 'Contributeur']);
        $roleUser = Role::firstOrCreate(['nom_role' => 'Utilisateur']);

        // Langue par défaut
        $langue = Langue::firstOrCreate(
            ['nom_langue' => 'Français'],
            ['code_langue' => 'fr', 'description' => 'Langue par défaut']
        );

        // Utilisateurs de test
        $users = [
            [
                'prenom' => 'Admin',
                'nom' => 'Test',
                'email' => 'admin@example.com',
                'mot_de_passe' => 'password',
                'sexe' => 'M',
                'date_naissance' => '1985-01-01',
                'statut' => 'actif',
                'id_role' => $roleAdmin->id_role,
            ],
            [
                'prenom' => 'Mod',
                'nom' => 'Test',
                'email' => 'moderator@example.com',
                'mot_de_passe' => 'password',
                'sexe' => 'F',
                'date_naissance' => '1990-01-01',
                'statut' => 'actif',
                'id_role' => $roleModerator->id_role,
            ],
            [
                'prenom' => 'Contrib',
                'nom' => 'Test',
                'email' => 'contributor@example.com',
                'mot_de_passe' => 'password',
                'sexe' => 'M',
                'date_naissance' => '1995-01-01',
                'statut' => 'actif',
                'id_role' => $roleContributor->id_role,
            ],
        ];

        foreach ($users as $u) {
            // Eviter doublons
            $existing = Utilisateur::where('email', $u['email'])->first();
            if ($existing) {
                $this->command->info("Utilisateur {$u['email']} existe déjà. Ignoré.");
                continue;
            }

            $user = new Utilisateur();
            $user->prenom = $u['prenom'];
            $user->nom = $u['nom'];
            $user->email = $u['email'];
            $user->mot_de_passe = $u['mot_de_passe'];
            $user->sexe = $u['sexe'];
            $user->date_naissance = $u['date_naissance'];
            $user->statut = $u['statut'];
            $user->id_role = $u['id_role'];
            $user->id_langue = $langue->id_langue ?? null;
            $user->date_inscription = now();
            $user->save();

            $this->command->info("Utilisateur créé: {$u['email']} (mot de passe: password)");
        }
    }
}
