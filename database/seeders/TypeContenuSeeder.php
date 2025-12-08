<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeContenu;

class TypeContenuSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['nom_contenu' => 'Article'],
            ['nom_contenu' => 'Actualité'],
            ['nom_contenu' => 'Histoire'],
            ['nom_contenu' => 'Tradition'],
            ['nom_contenu' => 'Cuisine'],
            ['nom_contenu' => 'Musique'],
            ['nom_contenu' => 'Danse'],
            ['nom_contenu' => 'Artisanat'],
        ];

        foreach ($types as $type) {
            TypeContenu::create($type);
        }
    }
}