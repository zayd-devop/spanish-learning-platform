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

        $dayTitles = [
            "Fondations de la Fluidité", "Maîtriser le Code à l'Oral", "L'Art du Pitch", "Construire la Confiance", "Simuler l'Entretien Idéal",
            "Bâtir des Phrases Complexes", "Bilan : Semaine 1", "Plongée dans le Vocabulaire Tech", "Structurer son Argumentation", "La Posture en Entretien",
            "Raconter ses Projets", "Les Connecteurs en Action", "Débattre d'un Sujet Tech", "Bilan : Semaine 2", "Parler de ses Erreurs",
            "Défendre son Choix Technologique", "Comprendre l'Architecture", "Présenter une Base de Données", "L'Alternance : Vos Motivations", "Gérer l'Imprévu à l'Oral",
            "Bilan : Semaine 3", "Exprimer ses Ambitions", "Poser les Bonnes Questions", "Le Vocabulaire Agile", "Convaincre un Recruteur",
            "L'Avenir de l'IA (Argumentation)", "Négocier son Alternance", "Bilan : Semaine 4", "Dernières Révisions", "Prêt pour l'Entreprise"
        ];

        $techTopics = ['une boucle for', 'une API REST', 'une base de données SQL', 'l\'architecture MVC', 'les Hooks React', 'le déploiement Docker', 'la Programmation Orientée Objet', 'le fonctionnement de Git', 'l\'intégration continue (CI/CD)', 'les promesses en JavaScript', 'une architecture microservices', 'le protocole HTTP', 'le pattern Singleton', 'le DOM', 'l\'injection de dépendances', 'le Cloud Computing', 'le responsive design', 'les websockets', 'le TDD (Test Driven Development)', 'le pattern Observer', 'l\'authentification JWT', 'le caching', 'les index SQL', 'le virtual DOM', 'le serverless', 'l\'accessibilité web (a11y)', 'les Web Workers', 'le SEO technique', 'les failles XSS', 'l\'architecture Hexagonale'];
        $podcastTopics = ['l\'intelligence artificielle', 'la cybersécurité', 'le freelancing tech', 'l\'histoire d\'internet', 'les frameworks JS', 'les startups françaises', 'le Green IT', 'l\'Open Source', 'le RGPD', 'le No-Code', 'la réalité virtuelle', 'le Web3', 'l\'informatique quantique', 'l\'UX design', 'le management tech', 'le DevOps', 'le cloud souverain', 'la e-santé', 'le développement de jeux vidéo', 'la blockchain', 'le machine learning', 'le big data', 'l\'edge computing', 'la 5G', 'la robotique', 'le métavers', 'les cryptomonnaies', 'l\'éthique dans la tech', 'le télétravail', 'l\'inclusion dans la tech'];
        $interviewQuestions = ['Parlez-moi de vous.', 'Quels sont vos plus grands défauts ?', 'Pourquoi notre entreprise ?', 'Quel est votre projet le plus complexe ?', 'Comment gérez-vous la pression ?', 'Où vous voyez-vous dans 5 ans ?', 'Pourquoi le dev Full Stack ?', 'Comment travaillez-vous en équipe ?', 'Racontez un conflit et sa résolution.', 'Pourquoi vous et pas un autre ?', 'Parlez d\'une erreur que vous avez commise.', 'Quelles sont vos prétentions salariales ?', 'Qu\'attendez-vous de cette alternance ?', 'Quel est votre framework préféré et pourquoi ?', 'Comment faites-vous votre veille technologique ?', 'Expliquez-moi un concept technique complexe.', 'Que faites-vous si vous êtes bloqué sur un bug ?', 'Quelle est votre plus grande réussite ?', 'Comment organisez-vous votre code ?', 'Qu\'est-ce qu\'un code de qualité pour vous ?', 'Comment recevez-vous la critique (code review) ?', 'Avez-vous des questions pour nous ?', 'Pourquoi avoir choisi l\'OFPPT ?', 'Que pensez-vous des tests automatisés ?', 'Votre expérience avec la méthode Agile/Scrum ?', 'Comment priorisez-vous vos tâches ?', 'Une technologie que vous aimeriez apprendre ?', 'Comment documentez-vous votre travail ?', 'Quel est votre avis sur le pair programming ?', 'Décrivez votre environnement de développement idéal.'];
        $argTopics = ['L\'IA va-t-elle remplacer les développeurs ?', 'Le télétravail à 100% : pour ou contre ?', 'Diplôme vs Compétences réelles', 'La semaine de 4 jours', 'L\'impact écologique du numérique', 'Logiciel libre vs propriétaire', 'L\'ubérisation de l\'emploi', 'La protection des données personnelles', 'L\'anonymat sur internet', 'La fracture numérique', 'Faut-il réguler les réseaux sociaux ?', 'L\'addiction aux écrans', 'La voiture autonome', 'Le vote électronique', 'La reconnaissance faciale', 'Les smartphones à l\'école', 'L\'obsolescence programmée', 'Le revenu universel', 'L\'exploration spatiale privée', 'La neutralité du net', 'L\'impact des jeux vidéo sur la jeunesse', 'Le piratage informatique (hacktivisme)', 'La publicité hyper-ciblée', 'Le transhumanisme', 'La vidéosurveillance', 'Les monnaies virtuelles', 'La gratuité des transports publics', 'L\'évaluation par les notes', 'La place de la femme dans la tech', 'L\'importance de l\'orthographe aujourd\'hui'];
        $connecteurs = ['Cependant / Néanmoins', 'En effet / Par conséquent', 'D\'une part / D\'autre part', 'Bien que / Quoique', 'En outre / De plus', 'C\'est pourquoi / Ainsi', 'En revanche / Au contraire', 'Afin que / Pour que', 'Étant donné que / Puisque', 'Malgré / En dépit de', 'D\'ailleurs / Par ailleurs', 'C\'est-à-dire / En d\'autres termes', 'Tandis que / Alors que', 'Bref / En résumé', 'Pour conclure / Finalement'];

        for ($i = 1; $i <= 30; $i++) {
            $idx = $i - 1;
            $connIdx = $idx % count($connecteurs);

            $dynamicChecklist = [
                // Bloc 1
                [
                    'task' => '[Bloc 1] Rubber Ducking : Expliquez à voix haute et en français le concept suivant : ' . $techTopics[$idx] . '.', 
                    'weekly_goal_minutes' => 20,
                    'resource' => ['title' => 'Article sur ' . $techTopics[$idx], 'url' => 'https://www.google.com/search?q=' . urlencode('développement web ' . $techTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 1] Shadowing Technique : Cherchez un podcast/vidéo sur "' . $podcastTopics[$idx] . '". Écoutez et répétez les phrases.', 
                    'weekly_goal_minutes' => 20,
                    'resource' => ['title' => 'Podcast/Vidéo : ' . $podcastTopics[$idx], 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('podcast developpeur français ' . $podcastTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 1] Lecture à voix haute : Lisez un article d\'actualité tech en articulant chaque mot.', 
                    'weekly_goal_minutes' => 20,
                    'resource' => ['title' => 'Actualité Developpez.com', 'url' => 'https://www.developpez.com/']
                ],
                // Bloc 2
                [
                    'task' => '[Bloc 2] Le Pitch (Ajustement) : Répétez votre présentation de 2 minutes en mettant en avant un aspect lié à ' . $techTopics[$idx] . '.', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Conseils Pitch', 'url' => 'https://www.welcometothejungle.com/fr/articles/entretien-embauche-comment-reussir-pitch-presentation']
                ],
                [
                    'task' => '[Bloc 2] Simulation d\'Entretien : Préparez une réponse orale détaillée à la question : "' . $interviewQuestions[$idx] . '"', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Questions d\'entretien', 'url' => 'https://www.apec.fr/tous-nos-conseils/entretien-dembauche.html']
                ],
                // Bloc 3
                [
                    'task' => '[Bloc 3] L\'Argumentation : Préparez un plan de 10 min puis parlez 5 min sur le sujet : "' . $argTopics[$idx] . '"', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Inspiration sur le sujet', 'url' => 'https://www.google.com/search?q=' . urlencode('débat ' . $argTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 3] Connecteurs Logiques : Entraînez-vous à faire des phrases complexes à l\'oral en intégrant obligatoirement : "' . $connecteurs[$connIdx] . '".', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Liste des connecteurs', 'url' => 'https://www.bonjourdefrance.com/exercices/contenu/les-connecteurs-logiques.html']
                ]
            ];

            Week::create([
                'week_number' => $i,
                'title' => 'Jour ' . $i . ' : ' . $dayTitles[$idx],
                'focus' => 'Réalisez vos 3 blocs quotidiens (Déblocage Actif, Entretiens, Stratégie Test) avec des thèmes uniques pour diversifier votre vocabulaire technique et général.',
                'milestone' => 'Compléter les 3 heures d\'entraînement sur les nouveaux sujets du jour.',
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
                'checklist' => $dynamicChecklist,
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
