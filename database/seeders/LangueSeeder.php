<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Langue;

class LangueSeeder extends Seeder
{
    public function run()
    {
        $langues = [
            ['nom_langue' => 'Français', 'code_langue' => 'fr', 'description' => 'Langue officielle du Bénin'],
            ['nom_langue' => 'Fon', 'code_langue' => 'fon', 'description' => 'Langue la plus parlée au Bénin'],
            ['nom_langue' => 'Yoruba', 'code_langue' => 'yor', 'description' => 'Langue du sud-est du Bénin'],
            ['nom_langue' => 'Bariba', 'code_langue' => 'bba', 'description' => 'Langue du nord du Bénin'],
            ['nom_langue' => 'Dendi', 'code_langue' => 'ddn', 'description' => 'Langue du nord-ouest du Bénin'],
            ['nom_langue' => 'Goun', 'code_langue' => 'gun', 'description' => 'Langue du sud-ouest du Bénin'],
            ['nom_langue' => 'Adja', 'code_langue' => 'adj', 'description' => 'Langue du sud-ouest du Bénin'],
            ['nom_langue' => 'Mina', 'code_langue' => 'min', 'description' => 'Langue du sud (région côtière)'],
            ['nom_langue' => 'Nagot', 'code_langue' => 'ngo', 'description' => 'Variété yoruba dans le sud'],
            ['nom_langue' => 'Peul (Fulfuldé)', 'code_langue' => 'fuf', 'description' => 'Parlée par les Peuls du nord'],
            ['nom_langue' => 'Ditamari', 'code_langue' => 'naa', 'description' => 'Langue de la région de Natitingou'],
            ['nom_langue' => 'Wémè', 'code_langue' => 'wem', 'description' => 'Langue de la vallée de l’Ouémé'],
            ['nom_langue' => 'Tammari', 'code_langue' => 'tbz', 'description' => 'Langue des Somba (Kota)'],
            ['nom_langue' => 'Yom', 'code_langue' => 'pil', 'description' => 'Langue de la région de Djougou'],
            ['nom_langue' => 'Kabiyè', 'code_langue' => 'kbp', 'description' => 'Langue partagée avec le Togo'],
            ['nom_langue' => 'Kotafon', 'code_langue' => 'kaf', 'description' => 'Variété de l’Adja'],
            ['nom_langue' => 'Idaasha', 'code_langue' => 'idd', 'description' => 'Langue du plateau d’Abomey'],
            ['nom_langue' => 'Anii', 'code_langue' => 'blo', 'description' => 'Langue de la zone Atacora/Donga'],
            ['nom_langue' => 'Sahouè', 'code_langue' => 'sax', 'description' => 'Langue du sud-ouest, proche de Adja'],
            ['nom_langue' => 'Taneka', 'code_langue' => 'tnk', 'description' => 'Langue des Tanéka du nord'],
        ];

        foreach ($langues as $langue) {
            Langue::create($langue);
        }
    }
}
