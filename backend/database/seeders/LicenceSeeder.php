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
            ],
            [
                'name' => 'L3 Informatique et Gestion', 'institute' => 'Université de Montpellier', 'location' => 'Montpellier, Occitanie',
                'description' => 'Double compétence en informatique et gestion, avec apprentissage en 3ème année.',
                'website' => 'https://www.umontpellier.fr/', 'latitude' => 43.6108, 'longitude' => 3.8767,
            ],
            [
                'name' => 'Licence Pro Développeur Web', 'institute' => 'Aix-Marseille Université', 'location' => 'Marseille, Provence-Alpes-Côte d\'Azur',
                'description' => 'Spécialisation dans les technologies Front-End et Back-End, 100% alternance.',
                'website' => 'https://www.univ-amu.fr/', 'latitude' => 43.2965, 'longitude' => 5.3698,
            ],
            [
                'name' => 'L3 MIAGE', 'institute' => 'Université de Nantes', 'location' => 'Nantes, Pays de la Loire',
                'description' => 'Formation reconnue pour devenir chef de projet technique ou développeur full-stack.',
                'website' => 'https://www.univ-nantes.fr/', 'latitude' => 47.2184, 'longitude' => -1.5536,
            ],
            [
                'name' => 'L3 Informatique', 'institute' => 'Université de Rennes 1', 'location' => 'Rennes, Bretagne',
                'description' => 'Parcours alternance possible avec des partenaires industriels régionaux forts.',
                'website' => 'https://www.univ-rennes1.fr/', 'latitude' => 48.1173, 'longitude' => -1.6778,
            ],
            [
                'name' => 'Licence Informatique Systèmes et Réseaux', 'institute' => 'Université de Strasbourg', 'location' => 'Strasbourg, Grand Est',
                'description' => 'Parcours système, réseau et cloud. Alternance très demandée.',
                'website' => 'https://www.unistra.fr/', 'latitude' => 48.5734, 'longitude' => 7.7521,
            ],
            [
                'name' => 'L3 MIAGE', 'institute' => 'Université de Lille', 'location' => 'Lille, Hauts-de-France',
                'description' => 'Célèbre programme lillois avec de nombreuses entreprises partenaires d\'Euratechnologies.',
                'website' => 'https://www.univ-lille.fr/', 'latitude' => 50.6292, 'longitude' => 3.0573,
            ],
            [
                'name' => 'L3 Informatique Cloud & IoT', 'institute' => 'Université Côte d\'Azur', 'location' => 'Nice, Provence-Alpes-Côte d\'Azur',
                'description' => 'Proche de Sophia Antipolis, cette licence ouvre les portes vers l\'IA et le Cloud.',
                'website' => 'https://univ-cotedazur.fr/', 'latitude' => 43.7102, 'longitude' => 7.2620,
            ],
            [
                'name' => 'Licence Pro Conception Logicielle', 'institute' => 'Université Grenoble Alpes', 'location' => 'Grenoble, Auvergne-Rhône-Alpes',
                'description' => 'Cœur de la Silicon Valley française, axé développement agile et Java/C#.',
                'website' => 'https://www.univ-grenoble-alpes.fr/', 'latitude' => 45.1885, 'longitude' => 5.7245,
            ],
            [
                'name' => 'L3 Développement Logiciel', 'institute' => 'Université de Rouen Normandie', 'location' => 'Rouen, Normandie',
                'description' => 'Licence générale informatique avec possibilité de contrat pro la dernière année.',
                'website' => 'https://www.univ-rouen.fr/', 'latitude' => 49.4431, 'longitude' => 1.0993,
            ],
            [
                'name' => 'L3 Informatique', 'institute' => 'Université Paris-Saclay', 'location' => 'Orsay, Île-de-France',
                'description' => 'Un des pôles d\'excellence mondiaux en mathématiques et informatique.',
                'website' => 'https://www.universite-paris-saclay.fr/', 'latitude' => 48.7093, 'longitude' => 2.1673,
            ],
            [
                'name' => 'L3 Informatique', 'institute' => 'Université Gustave Eiffel', 'location' => 'Marne-la-Vallée, Île-de-France',
                'description' => 'Anciennement UPEM, très forte culture de l\'alternance et réseau entreprise.',
                'website' => 'https://www.univ-gustave-eiffel.fr/', 'latitude' => 48.8398, 'longitude' => 2.5855,
            ],
            [
                'name' => 'Concepteur Développeur (Bac+3)', 'institute' => 'CNAM Paris', 'location' => 'Paris, Île-de-France',
                'description' => 'Titre RNCP niveau 6, spécialisé pour l\'apprentissage et l\'insertion pro.',
                'website' => 'https://www.cnam.fr/', 'latitude' => 48.8665, 'longitude' => 2.3547,
            ],
            [
                'name' => 'Licence Pro Web', 'institute' => 'Université de Tours', 'location' => 'Tours, Centre-Val de Loire',
                'description' => 'Développement d\'applications internet et intranet, framework JS/PHP.',
                'website' => 'https://www.univ-tours.fr/', 'latitude' => 47.3941, 'longitude' => 0.6848,
            ],
            [
                'name' => 'L3 MIAGE', 'institute' => 'Université d\'Orléans', 'location' => 'Orléans, Centre-Val de Loire',
                'description' => 'Formation reconnue, apprentissage d\'un an dans les systèmes d\'information.',
                'website' => 'https://www.univ-orleans.fr/', 'latitude' => 47.9029, 'longitude' => 1.9092,
            ],
            [
                'name' => 'L3 Informatique Appliquée', 'institute' => 'Université Clermont Auvergne', 'location' => 'Clermont-Ferrand, Auvergne-Rhône-Alpes',
                'description' => 'Forte dynamique avec le cluster d\'entreprises Michelin, Capgemini, CGI.',
                'website' => 'https://www.uca.fr/', 'latitude' => 45.7772, 'longitude' => 3.0870,
            ],
            [
                'name' => 'Licence Pro DWM', 'institute' => 'Université de Franche-Comté', 'location' => 'Besançon, Bourgogne-Franche-Comté',
                'description' => 'Développement Web et Mobile. Nombreux projets tutorés en agence digitale.',
                'website' => 'https://www.univ-fcomte.fr/', 'latitude' => 47.2378, 'longitude' => 6.0241,
            ],
            [
                'name' => 'L3 Informatique', 'institute' => 'Université de Picardie Jules Verne', 'location' => 'Amiens, Hauts-de-France',
                'description' => 'Spécialisation possible en développement back-end avec Symfony et Java.',
                'website' => 'https://www.u-picardie.fr/', 'latitude' => 49.8941, 'longitude' => 2.2957,
            ],
            [
                'name' => 'L3 MIAGE', 'institute' => 'Université de Reims Champagne-Ardenne', 'location' => 'Reims, Grand Est',
                'description' => 'Gestion de projets agiles, ERP, bases de données et développement logiciel.',
                'website' => 'https://www.univ-reims.fr/', 'latitude' => 49.2583, 'longitude' => 4.0317,
            ],
            [
                'name' => 'Licence Pro Développeur d\'Applications', 'institute' => 'Université de Caen Normandie', 'location' => 'Caen, Normandie',
                'description' => 'Formation professionnalisante orientée Java, C#, et frameworks modernes.',
                'website' => 'https://www.unicaen.fr/', 'latitude' => 49.1829, 'longitude' => -0.3707,
            ],
            [
                'name' => 'Licence CyberSécurité et Web', 'institute' => 'Université Bretagne Sud', 'location' => 'Vannes, Bretagne',
                'description' => 'Spécialisation dans la sécurité des applications web et mobile en apprentissage.',
                'website' => 'https://www.univ-ubs.fr/', 'latitude' => 47.6582, 'longitude' => -2.7599,
            ],
            [
                'name' => 'L3 Informatique', 'institute' => 'Université Savoie Mont Blanc', 'location' => 'Chambéry, Auvergne-Rhône-Alpes',
                'description' => 'Environnement exceptionnel. Apprentissage web et logiciel.',
                'website' => 'https://www.univ-smb.fr/', 'latitude' => 45.5646, 'longitude' => 5.9178,
            ],
            [
                'name' => 'L3 Informatique et Cybersécurité', 'institute' => 'Université d\'Angers', 'location' => 'Angers, Pays de la Loire',
                'description' => 'Sécurisation des architectures web et applications distribuées.',
                'website' => 'https://www.univ-angers.fr/', 'latitude' => 47.4722, 'longitude' => -0.5516,
            ],
            [
                'name' => 'Licence Pro DWM', 'institute' => 'Université de Poitiers', 'location' => 'Poitiers, Nouvelle-Aquitaine',
                'description' => 'Développement Web et Multimédia, parcours spécialisé Front-end / UX.',
                'website' => 'https://www.univ-poitiers.fr/', 'latitude' => 46.5802, 'longitude' => 0.3404,
            ]
        ];

        foreach ($licences as $licence) {
            Licence::create($licence);
        }
    }
}
