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

        $baseChecklist = [
            // Bloc 1
            [
                'task' => '[Bloc 1] Le "Rubber Ducking" en français : Expliquez le fonctionnement de votre code, l\'architecture d\'un projet, ou la logique d\'une base de données à un canard en plastique à voix haute.', 
                'weekly_goal_minutes' => 20,
                'resource' => ['title' => 'Qu\'est-ce que le Rubber Ducking ?', 'url' => 'https://fr.wikipedia.org/wiki/M%C3%A9thode_du_canard_en_plastique']
            ],
            [
                'task' => '[Bloc 1] Shadowing Technique : Écoutez des vidéos ou podcasts de développeurs francophones. Mettez sur pause et répétez avec la même intonation.', 
                'weekly_goal_minutes' => 20,
                'resource' => ['title' => 'Exemple de Podcast Tech', 'url' => 'https://www.artisan-developpeur.fr/podcast/']
            ],
            [
                'task' => '[Bloc 1] Lecture à voix haute : Lisez des articles sur le développement web ou l\'actualité tech en articulant exagérément.', 
                'weekly_goal_minutes' => 20,
                'resource' => ['title' => 'Articles Developpez.com', 'url' => 'https://www.developpez.com/']
            ],
            // Bloc 2
            [
                'task' => '[Bloc 2] Le Pitch de Présentation : Rédigez et pratiquez une présentation de 2 min sur votre parcours et votre motivation pour l\'alternance. Filmez-vous.', 
                'weekly_goal_minutes' => 30,
                'resource' => ['title' => 'Comment réussir son pitch', 'url' => 'https://www.welcometothejungle.com/fr/articles/entretien-embauche-comment-reussir-pitch-presentation']
            ],
            [
                'task' => '[Bloc 2] Simulation d\'Entretien : Préparez les réponses aux questions classiques : Forces ? Pourquoi Full Stack ? Projet complexe ? Utilisez ChatGPT.', 
                'weekly_goal_minutes' => 30,
                'resource' => ['title' => 'Questions fréquentes en entretien', 'url' => 'https://www.apec.fr/tous-nos-conseils/entretien-dembauche/preparer-l-entretien-d-embauche/rubrique/les-questions-incontournables-en-entretien-d-embauche.html']
            ],
            // Bloc 3
            [
                'task' => '[Bloc 3] L\'Argumentation : Prenez un sujet d\'actualité. 10 min pour structurer un plan, et 5 min pour exposer votre point de vue à voix haute.', 
                'weekly_goal_minutes' => 30,
                'resource' => ['title' => 'Sujets d\'actualité Tech', 'url' => 'https://www.numerama.com/']
            ],
            [
                'task' => '[Bloc 3] Les Connecteurs Logiques : Entraînez-vous à construire des phrases complexes en utilisant des mots de liaison : Cependant, En revanche, etc.', 
                'weekly_goal_minutes' => 30,
                'resource' => ['title' => 'Liste des connecteurs logiques', 'url' => 'https://www.bonjourdefrance.com/exercices/contenu/les-connecteurs-logiques.html']
            ]
        ];

        for ($i = 1; $i <= 30; $i++) {
            Week::create([
                'week_number' => $i,
                'title' => 'Jour ' . $i . ' : Entraînement 3 Heures',
                'focus' => 'Réalisez vos 3 blocs quotidiens (Déblocage Actif, Entretiens, Stratégie Test) pour un total de 3 heures de pratique intensive en français.',
                'milestone' => 'Compléter les 3 heures d\'entraînement sans sauter d\'étapes.',
                'source_links' => [
                    ['title' => 'Français Authentique', 'url' => 'https://www.francaisauthentique.com/'],
                    ['title' => 'Welcome to the Jungle', 'url' => 'https://www.welcometothejungle.com/fr/articles/'],
                    ['title' => 'Site officiel TCF', 'url' => 'https://www.france-education-international.fr/tcf']
                ],
                'video_links' => [
                    ['title' => 'InnerFrench', 'url' => 'https://www.youtube.com/c/innerFrench'],
                    ['title' => 'Simulation d\'entretien', 'url' => 'https://www.youtube.com/results?search_query=simulation+entretien+d%27embauche+d%C3%A9veloppeur']
                ],
                'books' => [
                    ['title' => 'Le Monde', 'author' => 'Actualités', 'url' => 'https://www.lemonde.fr/'],
                    ['title' => 'Préparation au TCF', 'author' => 'Editions CLE', 'url' => 'https://www.cle-international.com/recherche/tcf']
                ],
                'checklist' => $baseChecklist,
                'exam_links' => [
                    ['title' => 'Tests d\'entraînement RFI', 'url' => 'https://savoirs.rfi.fr/fr/apprendre-enseigner/langue-francaise/tcf-test-de-connaissance-du-francais']
                ]
            ]);
        }

        $this->call([
            LicenceSeeder::class,
        ]);
    }
}
