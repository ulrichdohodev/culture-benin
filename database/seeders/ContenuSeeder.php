<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contenu;

class ContenuSeeder extends Seeder
{
    public function run()
    {
        $contenus = [
            [
                'titre' => 'La riche histoire du Royaume du Dahomey',
                'texte' => 'Le Royaume du Dahomey fut un État africain précolonial puissant qui a existé du XVIIe au XIXe siècle. Connu pour son organisation militaire, son administration centralisée et ses Amazones, le royaume a laissé un héritage culturel important au Bénin moderne.',
                'statut' => 'valide',
                'date_validation' => now(),
                'id_region' => 3, // Ouémé
                'id_langue' => 1, // Français
                'id_type_contenu' => 3, // Histoire
                'id_auteur' => 3, // Marie Sagbo
                'id_moderateur' => 2, // John Doe
            ],
            [
                'titre' => 'La cuisine béninoise : saveurs et traditions',
                'texte' => 'La cuisine béninoise est variée et savoureuse, avec des plats emblématiques comme le riz au gras, l\'akassa, le amiwô, et la sauce feuille. Chaque région apporte sa touche particulière à ces plats traditionnels.',
                'statut' => 'valide',
                'date_validation' => now(),
                'id_region' => 1, // Atlantique
                'id_langue' => 1, // Français
                'id_type_contenu' => 5, // Cuisine
                'id_auteur' => 3, // Marie Sagbo
                'id_moderateur' => 2, // John Doe
            ],
            [
                'titre' => 'Les danses traditionnelles du Bénin',
                'texte' => 'Le Bénin possède une grande variété de danses traditionnelles comme le Zinli, le Têkê, le Gota et l\'Agbadja. Chaque danse raconte une histoire et est exécutée lors de cérémonies spécifiques.',
                'statut' => 'valide',
                'date_validation' => now(),
                'id_region' => 4, // Borgou
                'id_langue' => 1, // Français
                'id_type_contenu' => 7, // Danse
                'id_auteur' => 3, // Marie Sagbo
                'id_moderateur' => 2, // John Doe
            ],
            [
                'titre' => 'Festival des cultures vodoun à Ouidah',
                'texte' => 'Le festival annuel des cultures vodoun à Ouidah attire des milliers de visiteurs venus découvrir les richesses spirituelles et culturelles du vodoun, religion traditionnelle du Bénin.',
                'statut' => 'valide',
                'date_validation' => now(),
                'id_region' => 1, // Atlantique
                'id_langue' => 1, // Français
                'id_type_contenu' => 4, // Tradition
                'id_auteur' => 3, // Marie Sagbo
                'id_moderateur' => 2, // John Doe
            ],
        ];

        foreach ($contenus as $contenu) {
            Contenu::create($contenu);
        }
    }
}