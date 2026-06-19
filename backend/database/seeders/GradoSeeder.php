<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grado;
use Illuminate\Support\Facades\DB;

class GradoSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate the table before seeding to prevent duplicates
        DB::table('grados')->truncate();

        $grados = [
            // Madrid
            [
                'name' => 'DAM / DAW', 'institute' => 'U-tad', 'location' => 'Las Rozas, Madrid',
                'description' => 'A premier private university and vocational training center specializing in digital arts and technology.',
                'website' => 'https://u-tad.com/', 'latitude' => 40.5367, 'longitude' => -3.8967,
            ],
            [
                'name' => 'DAW', 'institute' => 'IES Clara del Rey', 'location' => 'Madrid, Community of Madrid',
                'description' => 'Highly reputable public institute offering robust web development programs.',
                'website' => 'https://site.educa.madrid.org/ies.claradelrey.madrid/', 'latitude' => 40.4285, 'longitude' => -3.6700,
            ],
            [
                'name' => 'DAM', 'institute' => 'ILERNA Madrid', 'location' => 'Madrid, Community of Madrid',
                'description' => 'A major national private FP center with top-tier technology labs.',
                'website' => 'https://www.ilerna.es/', 'latitude' => 40.4168, 'longitude' => -3.7038,
            ],
            [
                'name' => 'DAW', 'institute' => 'IES San Juan de la Cruz', 'location' => 'Pozuelo de Alarcón, Madrid',
                'description' => 'Public institute known for high job placement rates in the local tech hub.',
                'website' => 'https://site.educa.madrid.org/ies.sanjuandelacruz.pozuelo/', 'latitude' => 40.4346, 'longitude' => -3.8158,
            ],
            [
                'name' => 'DAM', 'institute' => 'IES Juan de la Cierva', 'location' => 'Madrid, Community of Madrid',
                'description' => 'A massive public institute specializing in engineering and computer science.',
                'website' => 'https://iesjuandelacierva.es/', 'latitude' => 40.3956, 'longitude' => -3.7153,
            ],
            [
                'name' => 'DAW / DAM', 'institute' => 'CEAC FP Madrid', 'location' => 'Madrid, Community of Madrid',
                'description' => 'Modern private institute focused on immediate job market insertion.',
                'website' => 'https://www.ceac.es/', 'latitude' => 40.4501, 'longitude' => -3.6912,
            ],

            // Catalonia
            [
                'name' => 'DAW / DAM', 'institute' => 'Institut TIC de Barcelona', 'location' => 'Barcelona, Catalonia',
                'description' => 'The leading public center in Barcelona dedicated exclusively to IT and emerging technologies.',
                'website' => 'https://institut-tic.barcelona/', 'latitude' => 41.4036, 'longitude' => 2.1904,
            ],
            [
                'name' => 'DAM', 'institute' => 'ILERNA Barcelona', 'location' => 'Barcelona, Catalonia',
                'description' => 'A highly modernized campus focused on multiplatform app development.',
                'website' => 'https://www.ilerna.es/', 'latitude' => 41.3851, 'longitude' => 2.1734,
            ],
            [
                'name' => 'DAW', 'institute' => 'Institut Poblenou', 'location' => 'Barcelona, Catalonia',
                'description' => 'Situated in the 22@ tech district, offering incredible networking opportunities.',
                'website' => 'https://iespoblenou.org/', 'latitude' => 41.4010, 'longitude' => 2.1990,
            ],
            [
                'name' => 'DAM', 'institute' => 'Institut Pedralbes', 'location' => 'Barcelona, Catalonia',
                'description' => 'Historic institute offering high-quality programming courses.',
                'website' => 'https://agora.xtec.cat/iespedralbes/', 'latitude' => 41.3895, 'longitude' => 2.1157,
            ],
            [
                'name' => 'DAW / DAM', 'institute' => 'Institut FP San Cugat', 'location' => 'Sant Cugat del Vallès, Catalonia',
                'description' => 'Excellent public center near Barcelona with strong tech enterprise connections.',
                'website' => 'https://www.insfp.cat/', 'latitude' => 41.4705, 'longitude' => 2.0833,
            ],

            // Andalusia
            [
                'name' => 'DAW / DAM', 'institute' => 'IES Campanillas', 'location' => 'Málaga, Andalusia',
                'description' => 'Located directly inside the Málaga TechPark (PTA), one of the best IT institutes in southern Spain.',
                'website' => 'https://www.iescampanillas.com/', 'latitude' => 36.7360, 'longitude' => -4.5540,
            ],
            [
                'name' => 'DAW', 'institute' => 'IES Triana', 'location' => 'Seville, Andalusia',
                'description' => 'A central public institute offering robust web development training.',
                'website' => 'https://www.iestriana.es/', 'latitude' => 37.3828, 'longitude' => -6.0025,
            ],
            [
                'name' => 'DAM', 'institute' => 'IES Gran Capitán', 'location' => 'Córdoba, Andalusia',
                'description' => 'Strong focus on software engineering fundamentals and multiplatform integration.',
                'website' => 'https://iesgrancapitan.org/', 'latitude' => 37.8916, 'longitude' => -4.7728,
            ],
            [
                'name' => 'DAW / DAM', 'institute' => 'IES Francisco de los Ríos', 'location' => 'Fernán Núñez, Córdoba',
                'description' => 'Innovative public center known for excellent software project development.',
                'website' => 'https://iesfranciscodelosrios.es/', 'latitude' => 37.6715, 'longitude' => -4.7231,
            ],
            [
                'name' => 'DAM', 'institute' => 'MEDAC Málaga', 'location' => 'Málaga, Andalusia',
                'description' => 'Well-known private institute focusing heavily on practical multiplatform programming.',
                'website' => 'https://medac.es/', 'latitude' => 36.7213, 'longitude' => -4.4214,
            ],

            // Valencia & Murcia
            [
                'name' => 'DAW', 'institute' => 'IES Abastos', 'location' => 'Valencia, Valencian Community',
                'description' => 'One of the largest public institutes in Valencia offering highly competitive IT degrees.',
                'website' => 'https://iesabastos.org/', 'latitude' => 39.4670, 'longitude' => -0.3880,
            ],
            [
                'name' => 'DAM', 'institute' => 'CEAC FP Valencia', 'location' => 'Valencia, Valencian Community',
                'description' => 'Private center offering excellent facilities and strong connections with local businesses.',
                'website' => 'https://www.ceac.es/', 'latitude' => 39.4699, 'longitude' => -0.3763,
            ],
            [
                'name' => 'DAW / DAM', 'institute' => 'IES San Vicente', 'location' => 'San Vicente del Raspeig, Alicante',
                'description' => 'Renowned public institute with a vibrant tech student community next to the university.',
                'website' => 'https://iessanvicente.com/', 'latitude' => 38.3965, 'longitude' => -0.5255,
            ],
            [
                'name' => 'DAM', 'institute' => 'IES Ingeniero de la Cierva', 'location' => 'Murcia, Region of Murcia',
                'description' => 'The definitive public tech institute in the Murcia region.',
                'website' => 'https://www.iescierva.net/', 'latitude' => 37.9902, 'longitude' => -1.1306,
            ],

            // Galicia
            [
                'name' => 'DAW / DAM', 'institute' => 'IES San Clemente', 'location' => 'Santiago de Compostela, Galicia',
                'description' => 'The definitive public institute for distance and on-site IT training in Galicia.',
                'website' => 'https://www.iessanclemente.net/', 'latitude' => 42.8805, 'longitude' => -8.5456,
            ],
            [
                'name' => 'DAW', 'institute' => 'IES Fernando Wirtz Suárez', 'location' => 'A Coruña, Galicia',
                'description' => 'A cornerstone of vocational training in northern Galicia.',
                'website' => 'http://www.edu.xunta.gal/centros/iesfernandowirtz/', 'latitude' => 43.3600, 'longitude' => -8.4110,
            ],
            [
                'name' => 'DAM', 'institute' => 'IES Teis', 'location' => 'Vigo, Galicia',
                'description' => 'Specialized center providing intensive software development tracks.',
                'website' => 'http://www.edu.xunta.gal/centros/iesteis/', 'latitude' => 42.2530, 'longitude' => -8.6960,
            ],
            [
                'name' => 'DAW', 'institute' => 'IES As Fontiñas', 'location' => 'Santiago de Compostela, Galicia',
                'description' => 'Modern facility with excellent computing labs.',
                'website' => 'http://www.edu.xunta.gal/centros/iesfontinas/', 'latitude' => 42.8833, 'longitude' => -8.5283,
            ],

            // Basque Country
            [
                'name' => 'DAW / DAM', 'institute' => 'CIFP Txurdinaga LHII', 'location' => 'Bilbao, Basque Country',
                'description' => 'Highly innovative vocational training center integrating advanced European tech standards.',
                'website' => 'https://www.fpbilbao.com/', 'latitude' => 43.2569, 'longitude' => -2.9056,
            ],
            [
                'name' => 'DAW', 'institute' => 'CIFP Ciudad de la Innovación', 'location' => 'Vitoria-Gasteiz, Basque Country',
                'description' => 'State-of-the-art facilities focusing on next-generation web technologies.',
                'website' => 'https://fpciudaddelainnovacion.com/', 'latitude' => 42.8590, 'longitude' => -2.6818,
            ],
            [
                'name' => 'DAM', 'institute' => 'CIFP Don Bosco', 'location' => 'Errenteria, Gipuzkoa',
                'description' => 'Iconic public center with deep ties to the Basque industrial and software sector.',
                'website' => 'https://donbosco.hezkuntza.net/', 'latitude' => 43.3134, 'longitude' => -1.9022,
            ],

            // Canary Islands
            [
                'name' => 'DAW / DAM', 'institute' => 'IES El Rincón', 'location' => 'Las Palmas, Canary Islands',
                'description' => 'The technological flagship public institute in Gran Canaria.',
                'website' => 'http://www.ieselrincon.es/', 'latitude' => 28.1235, 'longitude' => -15.4363,
            ],
            [
                'name' => 'DAW', 'institute' => 'IES César Manrique', 'location' => 'Santa Cruz de Tenerife, Canary Islands',
                'description' => 'Top destination for IT students in Tenerife.',
                'website' => 'https://www.iescesarmanrique.com/', 'latitude' => 28.4550, 'longitude' => -16.2625,
            ],
            
            // Aragon, Castile, & Others
            [
                'name' => 'DAW / DAM', 'institute' => 'CPIFP Los Enlaces', 'location' => 'Zaragoza, Aragon',
                'description' => 'Renowned hub for communications and computer science degrees.',
                'website' => 'https://www.cpifplosenlaces.com/', 'latitude' => 41.6496, 'longitude' => -0.9238,
            ],
            [
                'name' => 'DAM', 'institute' => 'IES Ribera de Castilla', 'location' => 'Valladolid, Castile and León',
                'description' => 'Key regional center for software developers in central Spain.',
                'website' => 'http://iesriberadecastilla.centros.educa.jcyl.es/', 'latitude' => 41.6667, 'longitude' => -4.7214,
            ],
            [
                'name' => 'DAW / DAM', 'institute' => 'IES Augustóbriga', 'location' => 'Navalmoral de la Mata, Extremadura',
                'description' => 'Strong IT programs pushing rural digital transformation.',
                'website' => 'https://iesaugustobriga.educarex.es/', 'latitude' => 39.8911, 'longitude' => -5.5414,
            ],
            [
                'name' => 'DAW', 'institute' => 'IES Valle del Jerte', 'location' => 'Plasencia, Extremadura',
                'description' => 'Advanced public center offering full stack web development.',
                'website' => 'https://iesvalledeljerteplasencia.educarex.es/', 'latitude' => 40.0305, 'longitude' => -6.0886,
            ],
            [
                'name' => 'DAM', 'institute' => 'CIFP Avilés', 'location' => 'Avilés, Asturias',
                'description' => 'The central hub for vocational computing in Asturias.',
                'website' => 'http://www.cifpaviles.net/', 'latitude' => 43.5540, 'longitude' => -5.9248,
            ],
            [
                'name' => 'DAW / DAM', 'institute' => 'IES Marqués de Comares', 'location' => 'Lucena, Andalusia',
                'description' => 'Highly respected institute outside major capitals providing intense developer courses.',
                'website' => 'https://blogsaverroes.juntadeandalucia.es/iesmarquesdecomares/', 'latitude' => 37.4093, 'longitude' => -4.4842,
            ]
        ];

        foreach ($grados as $grado) {
            Grado::create($grado);
        }
    }
}
