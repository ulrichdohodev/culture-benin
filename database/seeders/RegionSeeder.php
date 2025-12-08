<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            [
                'nom_region' => 'Atlantique',
                'description' => 'Région côtière avec Abomey-Calavi comme ville principale',
                'population' => 1495000,
                'superficie' => 3233,
                'localisation' => 'Sud du Bénin'
            ],
            [
                'nom_region' => 'Littoral',
                'description' => 'Région économique avec Cotonou comme capitale',
                'population' => 820000,
                'superficie' => 79,
                'localisation' => 'Côte Atlantique'
            ],
            [
                'nom_region' => 'Ouémé',
                'description' => 'Département historique avec Porto-Novo comme capitale du pays',
                'population' => 1200000,
                'superficie' => 1281,
                'localisation' => 'Sud-est du Bénin'
            ],
            [
                'nom_region' => 'Plateau',
                'description' => 'Région vallonnée et agricole',
                'population' => 750000,
                'superficie' => 3264,
                'localisation' => 'Centre-sud du Bénin'
            ],
            [
                'nom_region' => 'Mono',
                'description' => 'Région côtière avec pêche et tourisme',
                'population' => 500000,
                'superficie' => 1605,
                'localisation' => 'Sud-ouest du Bénin'
            ],
            [
                'nom_region' => 'Couffo',
                'description' => 'Région agricole et culturelle',
                'population' => 750000,
                'superficie' => 2404,
                'localisation' => 'Sud-ouest du Bénin'
            ],
            [
                'nom_region' => 'Zou',
                'description' => 'Région historique avec Abomey comme principale ville',
                'population' => 1050000,
                'superficie' => 5263,
                'localisation' => 'Centre du Bénin'
            ],
            [
                'nom_region' => 'Collines',
                'description' => 'Région agricole avec Savalou et Dassa',
                'population' => 800000,
                'superficie' => 13423,
                'localisation' => 'Centre du Bénin'
            ],
            [
                'nom_region' => 'Borgou',
                'description' => 'Région du nord avec Parakou comme ville principale',
                'population' => 1300000,
                'superficie' => 25856,
                'localisation' => 'Nord-est du Bénin'
            ],
            [
                'nom_region' => 'Alibori',
                'description' => 'Plus vaste département du Bénin',
                'population' => 900000,
                'superficie' => 26242,
                'localisation' => 'Extrême nord du Bénin'
            ],
            [
                'nom_region' => 'Atacora',
                'description' => 'Région montagneuse avec Natitingou',
                'population' => 850000,
                'superficie' => 20174,
                'localisation' => 'Nord-ouest du Bénin'
            ],
            [
                'nom_region' => 'Donga',
                'description' => 'Région forestière avec Djougou',
                'population' => 700000,
                'superficie' => 11126,
                'localisation' => 'Nord-ouest du Bénin'
            ],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
