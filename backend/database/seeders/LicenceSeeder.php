<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Licence;
use Illuminate\Support\Facades\DB;

class LicenceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('licences')->truncate();

        $licences = [
            [
                'name' => 'L3 Informatique (Alternance)', 'institute' => 'Université Paris Cité', 'location' => 'Paris, Île-de-France',
                'description' => 'Licence 3 orientée développement web et logiciel avec contrat d\'apprentissage.',
                'website' => 'https://u-paris.fr/', 'latitude' => 48.8566, 'longitude' => 2.3522,
            ],
            [
                'name' => 'L3 Informatique Appliquée', 'institute' => 'Sorbonne Université', 'location' => 'Paris, Île-de-France',
                'description' => 'Formation d\'excellence en informatique avec de fortes opportunités d\'alternance.',
                'website' => 'https://www.sorbonne-universite.fr/', 'latitude' => 48.8491, 'longitude' => 2.3429,
            ],
            [
                'name' => 'Licence Pro Métiers de l\'Informatique', 'institute' => 'Université de Lyon', 'location' => 'Lyon, Auvergne-Rhône-Alpes',
                'description' => 'Idéal pour le développement d\'applications web et mobiles. 100% alternance.',
                'website' => 'https://www.universite-lyon.fr/', 'latitude' => 45.7640, 'longitude' => 4.8357,
            ],
            [
                'name' => 'L3 MIAGE (Alternance)', 'institute' => 'Université Toulouse Capitole', 'location' => 'Toulouse, Occitanie',
                'description' => 'Méthodes Informatiques Appliquées à la Gestion des Entreprises. Fort taux d\'insertion.',
                'website' => 'https://www.ut-capitole.fr/', 'latitude' => 43.6047, 'longitude' => 1.4442,
            ],
            [
                'name' => 'Licence Informatique', 'institute' => 'Université de Bordeaux', 'location' => 'Bordeaux, Nouvelle-Aquitaine',
                'description' => 'Programme complet en développement logiciel, bases de données et réseaux.',
                'website' => 'https://www.u-bordeaux.fr/', 'latitude' => 44.8378, 'longitude' => -0.5792,
            ]
        ];

        foreach ($licences as $licence) {
            Licence::create($licence);
        }
    }
}
