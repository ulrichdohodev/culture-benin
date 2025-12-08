<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parler;

class ParlerSeeder extends Seeder
{
    public function run()
    {
        $parlers = [
            ['id_region' => 1, 'id_langue' => 1], // Atlantique - Français
            ['id_region' => 1, 'id_langue' => 2], // Atlantique - Fon
            ['id_region' => 2, 'id_langue' => 1], // Littoral - Français
            ['id_region' => 2, 'id_langue' => 2], // Littoral - Fon
            ['id_region' => 3, 'id_langue' => 1], // Ouémé - Français
            ['id_region' => 3, 'id_langue' => 2], // Ouémé - Fon
            ['id_region' => 4, 'id_langue' => 1], // Borgou - Français
            ['id_region' => 4, 'id_langue' => 3], // Borgou - Yoruba
            ['id_region' => 5, 'id_langue' => 1], // Donga - Français
            ['id_region' => 5, 'id_langue' => 4], // Donga - Bariba
            ['id_region' => 6, 'id_langue' => 1], // Alibori - Français
            ['id_region' => 6, 'id_langue' => 5], // Alibori - Dendi
        ];

        foreach ($parlers as $parler) {
            Parler::create($parler);
        }
    }
}