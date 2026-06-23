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
                'milestone' => 'Terminer le Bloc 1 quotidiennement.',
                'source_links' => [],
                'video_links' => [],
                'books' => [],
                'checklist' => [
                    [
                        'task' => 'Le "Rubber Ducking" en français : Expliquez le fonctionnement de votre code ou l\'architecture d\'un projet à voix haute en français.', 
                        'weekly_goal_minutes' => 20,
                        'resource' => null
                    ],
                    [
                        'task' => 'Shadowing Technique : Écoutez des podcasts ou vidéos YouTube de développeurs francophones. Écoutez, mettez sur pause, et répétez avec la même intonation.', 
                        'weekly_goal_minutes' => 20,
                        'resource' => null
                    ],
                    [
                        'task' => 'Lecture à voix haute : Lisez des articles sur le développement web ou l\'actualité tech en articulant exagérément.', 
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
                'milestone' => 'Terminer le Bloc 2 quotidiennement.',
                'source_links' => [],
                'video_links' => [],
                'books' => [],
                'checklist' => [
                    [
                        'task' => 'Le Pitch de Présentation : Rédigez et pratiquez à voix haute une présentation de 2 minutes sur votre parcours et votre diplôme à l\'OFPPT.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ],
                    [
                        'task' => 'Simulation d\'Entretien : Préparez les réponses aux questions classiques en français. Utilisez ChatGPT en mode vocal.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ]
                ],
                'exam_links' => []
            ],
            [
                'week_number' => 3,
                'title' => 'Bloc 3 : Stratégie Test de Langue (TCF/DELF)',
                'focus' => 'Pour les études en France, vous passerez probablement le TCF TP ou le DELF B2. Ces tests ont des formats spécifiques.',
                'milestone' => 'Terminer le Bloc 3 quotidiennement.',
                'source_links' => [],
                'video_links' => [],
                'books' => [],
                'checklist' => [
                    [
                        'task' => 'L\'Argumentation : Prenez un sujet d\'actualité. Donnez-vous 10 min pour structurer un plan et 5 min pour l\'exposer à voix haute.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ],
                    [
                        'task' => 'Les Connecteurs Logiques : Entraînez-vous à construire des phrases complexes en utilisant des mots de liaison (Cependant, En revanche, etc.).', 
                        'weekly_goal_minutes' => 30,
                        'resource' => null
                    ]
                ],
                'exam_links' => []
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
