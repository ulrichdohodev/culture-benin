<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeMedia;

class TypeMediaSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['nom_type_media' => 'Image', 'description' => 'Fichier image'],
            ['nom_type_media' => 'Vidéo', 'description' => 'Fichier vidéo'],
            ['nom_type_media' => 'Audio', 'description' => 'Fichier audio'],
            ['nom_type_media' => 'Document', 'description' => 'Fichier document'],
        ];

        foreach ($types as $type) {
            TypeMedia::updateOrCreate(
                ['nom_type_media' => $type['nom_type_media']],
                $type
            );
        }
    }
}
