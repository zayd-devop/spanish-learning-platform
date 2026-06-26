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
        $interviewQuestions = ['Parlez-moi de vous.', 'Quels sont vos plus grands défauts ?', 'Pourquoi notre école ?', 'Quel est votre projet le plus complexe ?', 'Comment gérez-vous la pression ?', 'Où vous voyez-vous dans 5 ans ?', 'Pourquoi le dev Full Stack ?', 'Comment travaillez-vous en équipe ?', 'Racontez un conflit et sa résolution.', 'Pourquoi vous et pas un autre ?', 'Parlez d\'une erreur que vous avez commise.', 'Qu\'est-ce qui vous motive dans l\'informatique ?', 'Qu\'attendez-vous de notre formation ?', 'Quel est votre framework préféré et pourquoi ?', 'Comment faites-vous votre veille technologique ?', 'Expliquez-moi un concept technique complexe.', 'Que faites-vous si vous êtes bloqué sur un bug ?', 'Quelle est votre plus grande réussite ?', 'Comment organisez-vous votre code ?', 'Qu\'est-ce qu\'un code de qualité pour vous ?', 'Comment recevez-vous la critique (code review) ?', 'Avez-vous des questions pour nous ?', 'Pourquoi avoir choisi l\'OFPPT ?', 'Que pensez-vous des tests automatisés ?', 'Votre expérience avec la méthode Agile/Scrum ?', 'Comment priorisez-vous vos tâches ?', 'Une technologie que vous aimeriez apprendre ?', 'Comment documentez-vous votre travail ?', 'Quel est votre avis sur le pair programming ?', 'Décrivez votre environnement de développement idéal.'];
        $argTopics = ['L\'IA va-t-elle remplacer les développeurs ?', 'Le télétravail à 100% : pour ou contre ?', 'Diplôme vs Compétences réelles', 'La semaine de 4 jours', 'L\'impact écologique du numérique', 'Logiciel libre vs propriétaire', 'L\'ubérisation de l\'emploi', 'La protection des données personnelles', 'L\'anonymat sur internet', 'La fracture numérique', 'Faut-il réguler les réseaux sociaux ?', 'L\'addiction aux écrans', 'La voiture autonome', 'Le vote électronique', 'La reconnaissance faciale', 'Les smartphones à l\'école', 'L\'obsolescence programmée', 'Le revenu universel', 'L\'exploration spatiale privée', 'La neutralité du net', 'L\'impact des jeux vidéo sur la jeunesse', 'Le piratage informatique (hacktivisme)', 'La publicité hyper-ciblée', 'Le transhumanisme', 'La vidéosurveillance', 'Les monnaies virtuelles', 'La gratuité des transports publics', 'L\'évaluation par les notes', 'La place de la femme dans la tech', 'L\'importance de l\'orthographe aujourd\'hui'];
        $connecteurs = ['Cependant / Néanmoins', 'En effet / Par conséquent', 'D\'une part / D\'autre part', 'Bien que / Quoique', 'En outre / De plus', 'C\'est pourquoi / Ainsi', 'En revanche / Au contraire', 'Afin que / Pour que', 'Étant donné que / Puisque', 'Malgré / En dépit de', 'D\'ailleurs / Par ailleurs', 'C\'est-à-dire / En d\'autres termes', 'Tandis que / Alors que', 'Bref / En résumé', 'Pour conclure / Finalement'];
        $b2c1Exams = ['Compréhension Orale (TCF)', 'Production Écrite : Essai argumentatif', 'Compréhension des écrits (DELF B2)', 'Production Orale : Exposé sur un thème', 'Compréhension Orale (Émission radio)', 'Production Écrite : Lettre formelle', 'Compréhension des écrits (Article de presse)', 'Production Orale : Débat et interaction', 'Compréhension Orale (Interview)', 'Production Écrite : Synthèse de documents (DALF C1)'];

        for ($i = 1; $i <= 30; $i++) {
            $idx = $i - 1;
            $connIdx = $idx % count($connecteurs);

            $dynamicChecklist = [
                // Bloc 1
                [
                    'task' => '[Bloc 1] Rubber Ducking : Expliquez à voix haute et en français le concept suivant : ' . $techTopics[$idx] . '.', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Exercices Pratiques : ' . $techTopics[$idx], 'url' => 'https://www.google.com/search?q=' . urlencode('exercices quiz ' . $techTopics[$idx])],
                    'youtube_resource' => ['title' => 'Leçon : ' . $techTopics[$idx], 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('cours lecon ' . $techTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 1] Shadowing Technique : Cherchez un podcast/vidéo sur "' . $podcastTopics[$idx] . '". Écoutez et répétez les phrases.', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Exercices de Vocabulaire : ' . $podcastTopics[$idx], 'url' => 'https://www.google.com/search?q=' . urlencode('exercices qcm vocabulaire ' . $podcastTopics[$idx])],
                    'youtube_resource' => ['title' => 'Leçon : ' . $podcastTopics[$idx], 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('documentaire explication ' . $podcastTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 1] Lecture à voix haute : Lisez un article d\'actualité tech en articulant chaque mot.', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Exercices de Compréhension Écrite', 'url' => 'https://www.lepointdufle.net/p/comprehensionecrite.htm'],
                    'youtube_resource' => ['title' => 'Leçon : Phonétique et Lecture', 'url' => 'https://www.youtube.com/results?search_query=lecon+phonetique+francais+lecture']
                ],
                // Bloc 2
                [
                    'task' => '[Bloc 2] Le Pitch (Ajustement) : Répétez votre présentation de 2 minutes en mettant en avant un aspect lié à ' . $techTopics[$idx] . '.', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Exercices : Structurer un Pitch', 'url' => 'https://www.google.com/search?q=exercices+pratiques+pitch+presentation'],
                    'youtube_resource' => ['title' => 'Leçon : Comment faire un bon Pitch', 'url' => 'https://www.youtube.com/results?search_query=lecon+comment+faire+un+pitch']
                ],
                [
                    'task' => '[Bloc 2] Simulation d\'Entretien : Préparez une réponse orale détaillée à la question : "' . $interviewQuestions[$idx] . '"', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Exercices de simulation d\'entretien', 'url' => 'https://www.google.com/search?q=exercices+simulation+entretien+embauche'],
                    'youtube_resource' => ['title' => 'Leçon : Réussir son entretien', 'url' => 'https://www.youtube.com/results?search_query=lecon+reussir+entretien+embauche']
                ],
                // Bloc 3
                [
                    'task' => '[Bloc 3] L\'Argumentation : Préparez un plan de 10 min puis parlez 5 min sur le sujet : "' . $argTopics[$idx] . '"', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Exercices d\'Argumentation', 'url' => 'https://www.lepointdufle.net/p/productionecrite.htm'],
                    'youtube_resource' => ['title' => 'Leçon : Comment Argumenter', 'url' => 'https://www.youtube.com/results?search_query=lecon+comment+argumenter+francais']
                ],
                [
                    'task' => '[Bloc 3] Connecteurs Logiques : Entraînez-vous à faire des phrases complexes à l\'oral en intégrant obligatoirement : "' . $connecteurs[$connIdx] . '".', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Exercices : Connecteurs Logiques', 'url' => 'https://www.bonjourdefrance.com/exercices/contenu/les-connecteurs-logiques.html'],
                    'youtube_resource' => ['title' => 'Leçon : Les mots de liaison', 'url' => 'https://www.youtube.com/results?search_query=lecon+mots+de+liaison+francais']
                ],
                // Bloc 4 : Préparation B2/C1
                [
                    'task' => '[Bloc 4] Examen B2/C1 : Entraînement ciblé sur l\'épreuve "' . $b2c1Exams[$idx % count($b2c1Exams)] . '".', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Exercices d\'Examen B2/C1', 'url' => 'https://apprendre.tv5monde.com/fr/tcf'],
                    'youtube_resource' => ['title' => 'Leçon : Préparation B2/C1', 'url' => 'https://www.youtube.com/results?search_query=lecon+preparation+delf+b2+dalf+c1']
                ],
                [
                    'task' => '[Bloc 4] Examen B2/C1 : Correction et analyse de vos erreurs (Grammaire avancée, Subjonctif, Concordance des temps).', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Exercices de Grammaire B2/C1', 'url' => 'https://www.lepointdufle.net/p/grammaire.htm'],
                    'youtube_resource' => ['title' => 'Leçon : Grammaire Avancée', 'url' => 'https://www.youtube.com/results?search_query=lecon+grammaire+avancee+francais']
                ]
            ];

            Week::create([
                'week_number' => $i,
                'path' => 'standard',
                'title' => 'Jour ' . $i . ' : ' . $dayTitles[$idx],
                'focus' => 'Réalisez vos 4 blocs (Déblocage Actif, Entretiens Écoles, Stratégie, et B2/C1) pour assurer votre admission en école française.',
                'milestone' => 'Compléter les 5 heures d\'entraînement (300 minutes) pour réussir les entretiens des écoles privées et valider un score TCF B2/C1.',
                'source_links' => [
                    ['title' => 'Tests Admission Écoles d\'Ingénieurs', 'url' => 'https://www.concours-puissance-alpha.fr/'],
                    ['title' => 'Réussir l\'Entretien Campus France', 'url' => 'https://maroc.campusfrance.org/lentretien-campus-france-0'],
                    ['title' => 'Préparation TCF TV5Monde', 'url' => 'https://apprendre.tv5monde.com/fr/tcf']
                ],
                'video_links' => [
                    ['title' => 'Entretien Motivation École d\'Ingénieur', 'url' => 'https://www.youtube.com/results?search_query=entretien+ecole+ingenieur+informatique'],
                    ['title' => 'Stratégie Production Écrite B2/C1', 'url' => 'https://www.youtube.com/results?search_query=production+ecrite+delf+b2+dalf+c1']
                ],
                'books' => [
                    ['title' => 'Réussir le DELF B2', 'author' => 'Didier FLE', 'url' => 'https://editionsdidier.com/fr/collection/le-delf-100-reussite'],
                    ['title' => 'Tests de Logique et Mathématiques (Écoles)', 'author' => 'Dunod', 'url' => 'https://www.dunod.com/']
                ],
                'checklist' => $dynamicChecklist,
                'exam_links' => [
                    ['title' => 'Sujets Blancs TCF (CIEP)', 'url' => 'https://www.france-education-international.fr/tcf/exemples-de-sujets'],
                    ['title' => 'Test Logique / Informatique Type Epitech', 'url' => 'https://www.google.com/search?q=test+logique+admission+ecole+informatique']
                ]
            ]);
        }

        // "From Zero to Hero" 8-Week Sprint with 56 Unique Daily Topics
        $heroWeeks = [
            [
                'title' => 'Semaine 1 : The Past Tense Fixation',
                'focus' => 'Focus: Passé Composé vs. Imparfait. Your biggest hurdle right now is telling stories. Spend this week mastering when to use the passé composé (completed actions) versus the imparfait (ongoing states, habits, background details).',
                'milestone' => 'Speak into your phone\'s voice memo app for 3 solid minutes about what you did last weekend, detailing the events and how you felt, without stopping to look up a verb conjugation.',
                'daily_topics' => [
                    "Le Passé Composé (Verbes réguliers avec Avoir)",
                    "Le Passé Composé (Verbes irréguliers et avec Être)",
                    "L'Imparfait (Descriptions et habitudes)",
                    "Passé Composé vs Imparfait (La grande différence)",
                    "Raconter un événement historique",
                    "Le Plus-que-parfait (Introduction)",
                    "Bilan : Raconter une anecdote personnelle"
                ]
            ],
            [
                'title' => 'Semaine 2 : Navigating the Future & Pronouns',
                'focus' => 'Focus: Futur Proche/Simple and \'y\' & \'en\'. Stop repeating the same nouns. Master direct/indirect object pronouns and the spatial/quantity pronouns. Pair this with mastering how to talk about the future.',
                'milestone' => 'Explain your 5-year career or life plan to a language partner, successfully substituting nouns with y or en at least 5 times.',
                'daily_topics' => [
                    "Le Futur Proche",
                    "Le Futur Simple (Verbes réguliers et irréguliers)",
                    "Les Pronoms COD (le, la, les)",
                    "Les Pronoms COI (lui, leur)",
                    "Le Pronom Y (Lieu et Chose)",
                    "Le Pronom EN (Quantité et De)",
                    "Bilan : Mes projets d'avenir"
                ]
            ],
            [
                'title' => 'Semaine 3 : The Ear Training Gauntlet',
                'focus' => 'Focus: Transitioning to Native Audio. Shift your input from learner-focused audio to native-speed podcasts. French natives drop the \'ne\' in negative sentences and mash words together.',
                'milestone' => 'Watch a 20-minute French YouTube vlog intended for natives with subtitles turned completely off. Write a half-page summary of the video.',
                'daily_topics' => [
                    "Les contractions à l'oral (t'es, y'a)",
                    "La négation orale (suppression du NE)",
                    "Les liaisons obligatoires et interdites",
                    "Comprendre le rythme et l'accentuation",
                    "L'accent québécois vs français",
                    "L'accent du sud de la France",
                    "Bilan : Écoute d'un vlog natif sans sous-titres"
                ]
            ],
            [
                'title' => 'Semaine 4 : The Subjunctive & Opinions',
                'focus' => 'Focus: Emotion, Doubt, and Necessity. The subjunctive mood terrifies learners, but you only need to know it for specific triggers (Il faut que, Je veux que, Bien que).',
                'milestone' => 'Record a 5-minute unscripted debate taking a stance on a controversial topic. You must correctly trigger and use the subjunctive mood at least three times.',
                'daily_topics' => [
                    "Introduction au Subjonctif (Il faut que, Je veux que)",
                    "Le Subjonctif (Émotions et doutes)",
                    "Les verbes irréguliers au subjonctif",
                    "Exprimer son opinion (Indicatif vs Subjonctif)",
                    "Exprimer l'accord et le désaccord",
                    "L'expression de la condition (Bien que, Pour que)",
                    "Bilan : Débat sur un sujet polémique"
                ]
            ],
            [
                'title' => 'Semaine 5 : Conversational Connectors',
                'focus' => 'Focus: Flow and Natural Fillers. You know the grammar; now you need to sound human. Focus entirely on conversational connectors: En fait, Du coup, Par contre, D\'ailleurs, and Bref.',
                'milestone' => 'Hold a 30-minute continuous, unscripted conversation with a native speaker using at least 5 different natural connectors without reverting to English.',
                'daily_topics' => [
                    "Connecteurs d'addition (De plus, En outre)",
                    "Connecteurs d'opposition (Cependant, En revanche)",
                    "Connecteurs de cause (Parce que, Puisque)",
                    "Connecteurs de conséquence (Donc, Par conséquent)",
                    "Les tics de langage (Du coup, Bref, En fait)",
                    "Structurer un long discours (D'abord, Ensuite, Enfin)",
                    "Bilan : Monologue argumentatif de 5 minutes"
                ]
            ],
            [
                'title' => 'Semaine 6 : Slang and Informal French',
                'focus' => 'Focus: Verlan and Street French. Textbook French is not how everyday people speak. Spend this week learning essential Verlan and colloquial vocabulary.',
                'milestone' => 'Watch a full episode of a modern French TV show (like Lupin) with ONLY French subtitles. Successfully define 10 slang terms used by the characters.',
                'daily_topics' => [
                    "Le vocabulaire familier du quotidien",
                    "Les expressions idiomatiques (Avoir le cafard, etc.)",
                    "Le vocabulaire de l'entreprise (Informel)",
                    "L'argot de rue et des jeunes",
                    "Le Verlan (ouf, meuf, relou)",
                    "Raccourcis et abréviations (À plus, d'ac, a+)",
                    "Bilan : Regarder une série française (Lupin ou Dix pour cent)"
                ]
            ],
            [
                'title' => 'Semaine 7 : The Professional Pivot',
                'focus' => 'Focus: Formal Language and The Conditional. Pivot to high-level input. Read news articles, listen to political podcasts, and master the Conditional tense for politeness and hypotheticals.',
                'milestone' => 'Read a full editorial article from Le Monde or Le Figaro. Immediately afterward, summarize the author\'s argument out loud for 3 minutes.',
                'daily_topics' => [
                    "Le vocabulaire du recrutement et du CV",
                    "Rédiger un email ou une lettre formelle",
                    "Le Conditionnel (Politesse et Souhaits)",
                    "Le Conditionnel (Hypothèses avec Si)",
                    "Présenter son parcours professionnel",
                    "Négocier et argumenter en réunion",
                    "Bilan : Simulation d'entretien d'embauche"
                ]
            ],
            [
                'title' => 'Semaine 8 : Total Immersion & Shadowing',
                'focus' => 'Focus: Accent Refinement and Fluidity. No new grammar. This week is purely about speed, accent reduction, and output. Do "shadowing" exercises to match native intonation.',
                'milestone' => 'Record a 10-minute uninterrupted monologue on a complex topic. Listen to it back-to-back with your Week 1 recording to hear the proof of your new competency.',
                'daily_topics' => [
                    "Shadowing : Journal télévisé (Rythme soutenu)",
                    "Shadowing : Interview politique (Débat)",
                    "Shadowing : Podcast humoristique (Intonation)",
                    "Shadowing : Documentaire scientifique (Précision)",
                    "Exercices de prononciation (Les voyelles nasales)",
                    "Exercices de prononciation (Le R français et les liaisons)",
                    "Bilan Final : Monologue de 10 minutes (L'impact de la technologie)"
                ]
            ]
        ];

        $heroWeekNumber = 1;
        foreach ($heroWeeks as $index => $week) {
            $semaineNum = $index + 1;
            
            for ($day = 1; $day <= 7; $day++) {
                $dailyTopic = $week['daily_topics'][$day - 1];
                
                $checklist = [
                    [
                        'task' => "Bloc 1 (45 min): Active Study (Morning) - Anki flashcards and targeted grammar exercises ($dailyTopic).",
                        'weekly_goal_minutes' => 45,
                        'resource' => ['title' => "Exercices : $dailyTopic", 'url' => 'https://www.google.com/search?q=' . urlencode("exercices francais " . $dailyTopic)],
                        'youtube_resource' => ['title' => "Leçon : $dailyTopic", 'url' => 'https://www.youtube.com/results?search_query=' . urlencode("lecon francais " . $dailyTopic)]
                    ],
                    [
                        'task' => "Bloc 2 (60 min): Comprehensible Input - Listening and reading to content just slightly above your level ($dailyTopic).",
                        'weekly_goal_minutes' => 60,
                        'resource' => ['title' => "Texte & Audio : $dailyTopic", 'url' => 'https://www.google.com/search?q=' . urlencode("texte avec audio francais " . $dailyTopic)],
                        'youtube_resource' => ['title' => "Podcast / Vidéo : $dailyTopic", 'url' => 'https://www.youtube.com/results?search_query=' . urlencode("podcast francais " . $dailyTopic)]
                    ],
                    [
                        'task' => "Bloc 3 (45 min): Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud ($dailyTopic).",
                        'weekly_goal_minutes' => 45,
                        'resource' => ['title' => "Sujets de discussion : $dailyTopic", 'url' => 'https://www.google.com/search?q=' . urlencode("sujets de conversation francais " . $dailyTopic)],
                        'youtube_resource' => ['title' => "Exemple d'oral : $dailyTopic", 'url' => 'https://www.youtube.com/results?search_query=' . urlencode("production orale francais " . $dailyTopic)]
                    ],
                    [
                        'task' => "Bloc 4 (30 min): Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.",
                        'weekly_goal_minutes' => 30,
                        'resource' => ['title' => 'Culture et Divertissement', 'url' => 'https://www.lepointdufle.net/p/civilisation.htm'],
                        'youtube_resource' => ['title' => 'Médias natifs', 'url' => 'https://www.youtube.com/results?search_query=documentaire+francais']
                    ]
                ];

                Week::create([
                    'week_number' => $heroWeekNumber++,
                    'path' => 'zero_to_hero',
                    'title' => "Semaine {$semaineNum} - Jour {$day} : {$dailyTopic}",
                    'focus' => $week['focus'],
                    'milestone' => $week['milestone'],
                    'checklist' => $checklist,
                    'source_links' => [],
                    'video_links' => [],
                    'books' => [],
                    'exam_links' => []
                ]);
            }
        }

        $this->call([
            LicenceSeeder::class,
        ]);
    }
}
