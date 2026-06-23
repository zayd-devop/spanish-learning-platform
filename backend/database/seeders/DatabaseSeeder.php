<?php

namespace Database\Seeders;

use App\Models\Week;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tables to allow fresh seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Week::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $weeks = [
            [
                'week_number' => 1,
                'title' => 'Bloc 1 : Le Déblocage Actif',
                'focus' => 'L\'objectif ici est d\'habituer votre cerveau et les muscles de votre bouche à formuler des phrases en français sans passer par la traduction mentale.',
                'milestone' => 'Fluidité acquise : Savoir expliquer son code et lire à voix haute sans hésitation majeure.',
                'source_links' => [
                    'https://www.francaisauthentique.com/ (Français Authentique)',
                    'https://apprendre.tv5monde.com/fr (TV5Monde Apprendre)'
                ],
                'video_links' => [
                    'https://www.youtube.com/c/francaisauthentique (Français Authentique YouTube)',
                    'https://www.youtube.com/c/innerFrench (InnerFrench)'
                ],
                'books' => [
                    'Lisez des articles sur LeMonde.fr ou Developpez.com'
                ],
                'checklist' => [
                    [
                        'task' => 'Le "Rubber Ducking" en français : Utilisez cette technique de développement à voix haute. Expliquez le fonctionnement de votre code, l\'architecture d\'un projet, ou la logique d\'une base de données à un canard en plastique.', 
                        'weekly_goal_minutes' => 20,
                        'resource' => null
                    ],
                    [
                        'task' => 'Shadowing Technique : Écoutez des podcasts ou des vidéos YouTube de développeurs francophones. Écoutez une phrase courte, mettez sur pause, et répétez-la avec la même intonation et le même rythme.', 
                        'weekly_goal_minutes' => 20,
                        'resource' => null
                    ],
                    [
                        'task' => 'Lecture à voix haute : Lisez des articles sur le développement web ou l\'actualité tech en articulant exagérément. Cela améliore la prononciation et la fluidité.', 
                        'weekly_goal_minutes' => 20,
                        'resource' => null
                    ]
                ],
                'exam_links' => []
            ],
            [
                'week_number' => 2,
                'title' => 'Bloc 2 : Préparation aux Entretiens & Alternance',
                'focus' => 'Trouver une entreprise en France demande de savoir se vendre à l\'oral et de maîtriser le jargon professionnel.',
                'milestone' => 'Confiance acquise : Avoir un pitch de présentation rodé et savoir répondre aux questions classiques d\'entretien.',
                'source_links' => [
                    'https://www.welcometothejungle.com/fr/articles/ (Conseils Carrière Welcome to the Jungle)',
                    'https://www.apec.fr/ (APEC - Conseils pour l\'emploi)'
                ],
                'video_links' => [
                    'https://www.youtube.com/results?search_query=simulation+entretien+d%27embauche+d%C3%A9veloppeur (Exemples d\'entretiens Tech)'
                ],
                'books' => [],
                'checklist' => [
                    [
                        'task' => 'Le Pitch de Présentation : Rédigez, puis pratiquez à voix haute, une présentation de 2 minutes. Vous devez savoir expliquer clairement votre parcours, valoriser les compétences acquises lors de votre diplôme à l\'OFPPT, et justifier votre volonté d\'intégrer une L3 en alternance. Filmez-vous avec votre téléphone et analysez votre posture et vos hésitations.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ],
                    [
                        'task' => 'Simulation d\'Entretien : Préparez les réponses aux questions classiques en français : Quelles sont vos forces ? Pourquoi avez-vous choisi le développement Full Stack ? Quel a été votre projet le plus complexe à déployer ? Utilisez ChatGPT en mode vocal ou un partenaire linguistique pour simuler ces échanges.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ]
                ],
                'exam_links' => []
            ],
            [
                'week_number' => 3,
                'title' => 'Bloc 3 : Stratégie Test de Langue (TCF/DELF)',
                'focus' => 'Pour les études en France, vous passerez probablement le TCF TP (Test de Connaissance du Français) ou le DELF B2. Ces tests ont des formats très spécifiques qu\'il faut maîtriser.',
                'milestone' => 'Structure acquise : Savoir défendre une opinion pendant 5 minutes avec des connecteurs logiques.',
                'source_links' => [
                    'https://www.france-education-international.fr/tcf (Site officiel TCF)',
                    'https://www.partir-en-france.com/tcf-delf (Préparation DELF/TCF)'
                ],
                'video_links' => [
                    'https://www.youtube.com/results?search_query=expression+orale+tcf (Préparation Expression Orale TCF)'
                ],
                'books' => [
                    'Préparation au TCF (Livre d\'exercices)'
                ],
                'checklist' => [
                    [
                        'task' => 'L\'Argumentation : Les épreuves orales exigent souvent de défendre une opinion. Prenez un sujet d\'actualité au hasard (ex: Le télétravail devrait-il être obligatoire ? ou L\'impact de l\'IA sur les développeurs juniors). Donnez-vous 10 minutes pour structurer un plan (Introduction, Arguments, Conclusion) et 5 minutes pour exposer votre point de vue à voix haute.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ],
                    [
                        'task' => 'Les Connecteurs Logiques : La différence entre un niveau B1 et un niveau B2/C1 réside dans l\'articulation du discours. Entraînez-vous à construire des phrases complexes en utilisant des mots de liaison : Cependant, En revanche, Néanmoins, Par conséquent, Bien que.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ]
                ],
                'exam_links' => [
                    'https://savoirs.rfi.fr/fr/apprendre-enseigner/langue-francaise/tcf-test-de-connaissance-du-francais (Tests d\'entraînement RFI)'
                ]
            ]
        ];

        foreach ($weeks as $weekData) {
            Week::create($weekData);
        }

        $this->call([
            LicenceSeeder::class,
        ]);
    }
}
