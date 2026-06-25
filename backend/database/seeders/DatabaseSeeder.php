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
                    'resource' => ['title' => 'Article sur ' . $techTopics[$idx], 'url' => 'https://www.google.com/search?q=' . urlencode('développement web ' . $techTopics[$idx])],
                    'youtube_resource' => ['title' => 'Tuto YouTube', 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('tutoriel français ' . $techTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 1] Shadowing Technique : Cherchez un podcast/vidéo sur "' . $podcastTopics[$idx] . '". Écoutez et répétez les phrases.', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Podcast : ' . $podcastTopics[$idx], 'url' => 'https://www.google.com/search?q=' . urlencode('podcast developpeur français ' . $podcastTopics[$idx])],
                    'youtube_resource' => ['title' => 'Vidéo YouTube', 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('tech francais ' . $podcastTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 1] Lecture à voix haute : Lisez un article d\'actualité tech en articulant chaque mot.', 
                    'weekly_goal_minutes' => 30,
                    'resource' => ['title' => 'Actualité Developpez.com', 'url' => 'https://www.developpez.com/'],
                    'youtube_resource' => ['title' => 'News Tech YouTube', 'url' => 'https://www.youtube.com/results?search_query=actualite+tech+francais']
                ],
                // Bloc 2
                [
                    'task' => '[Bloc 2] Le Pitch (Ajustement) : Répétez votre présentation de 2 minutes en mettant en avant un aspect lié à ' . $techTopics[$idx] . '.', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Conseils Pitch', 'url' => 'https://www.welcometothejungle.com/fr/articles/entretien-embauche-comment-reussir-pitch-presentation'],
                    'youtube_resource' => ['title' => 'Exemple Pitch YouTube', 'url' => 'https://www.youtube.com/results?search_query=pitch+presentation+entretien+embauche']
                ],
                [
                    'task' => '[Bloc 2] Simulation d\'Entretien : Préparez une réponse orale détaillée à la question : "' . $interviewQuestions[$idx] . '"', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Questions d\'entretien', 'url' => 'https://www.apec.fr/tous-nos-conseils/entretien-dembauche.html'],
                    'youtube_resource' => ['title' => 'Coaching Entretien', 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('repondre entretien ' . $interviewQuestions[$idx])]
                ],
                // Bloc 3
                [
                    'task' => '[Bloc 3] L\'Argumentation : Préparez un plan de 10 min puis parlez 5 min sur le sujet : "' . $argTopics[$idx] . '"', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Inspiration sur le sujet', 'url' => 'https://www.google.com/search?q=' . urlencode('débat ' . $argTopics[$idx])],
                    'youtube_resource' => ['title' => 'Débat YouTube', 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('debat ' . $argTopics[$idx])]
                ],
                [
                    'task' => '[Bloc 3] Connecteurs Logiques : Entraînez-vous à faire des phrases complexes à l\'oral en intégrant obligatoirement : "' . $connecteurs[$connIdx] . '".', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Liste des connecteurs', 'url' => 'https://www.bonjourdefrance.com/exercices/contenu/les-connecteurs-logiques.html'],
                    'youtube_resource' => ['title' => 'Cours YouTube', 'url' => 'https://www.youtube.com/results?search_query=connecteurs+logiques+francais+b2']
                ],
                // Bloc 4 : Préparation B2/C1
                [
                    'task' => '[Bloc 4] Examen B2/C1 : Entraînement ciblé sur l\'épreuve "' . $b2c1Exams[$idx % count($b2c1Exams)] . '".', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Sujets d\'examen TV5Monde', 'url' => 'https://apprendre.tv5monde.com/fr/tcf'],
                    'youtube_resource' => ['title' => 'Entraînement YouTube', 'url' => 'https://www.youtube.com/results?search_query=' . urlencode('entrainement ' . $b2c1Exams[$idx % count($b2c1Exams)])]
                ],
                [
                    'task' => '[Bloc 4] Examen B2/C1 : Correction et analyse de vos erreurs (Grammaire avancée, Subjonctif, Concordance des temps).', 
                    'weekly_goal_minutes' => 35,
                    'resource' => ['title' => 'Grammaire avancée B2/C1', 'url' => 'https://www.lepointdufle.net/p/grammaire.htm'],
                    'youtube_resource' => ['title' => 'Règle Grammaire', 'url' => 'https://www.youtube.com/results?search_query=grammaire+avancee+francais+c1']
                ]
            ];

            Week::create([
                'week_number' => $i,
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

        // "From Zero to Hero" 8-Week Sprint
        $heroWeeks = [
            [
                'title' => 'Semaine 1 : The Past Tense Fixation',
                'focus' => 'Focus: Passé Composé vs. Imparfait. Your biggest hurdle right now is telling stories. Spend this week mastering when to use the passé composé (completed actions) versus the imparfait (ongoing states, habits, background details). Drill the irregular past participles and the verbs that use être instead of avoir.',
                'milestone' => 'Speak into your phone\'s voice memo app for 3 solid minutes about what you did last weekend, detailing the events and how you felt, without stopping to look up a verb conjugation.',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Exercices: Passé vs Imparfait', 'url' => 'https://www.lepointdufle.net/p/passecompose_imparfait.htm'], 'youtube_resource' => ['title' => 'Leçon Passé vs Imparfait', 'url' => 'https://www.youtube.com/results?search_query=passe+compose+vs+imparfait']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'InnerFrench Podcast', 'url' => 'https://innerfrench.com/podcast/'], 'youtube_resource' => ['title' => 'InnerFrench YouTube', 'url' => 'https://www.youtube.com/c/innerFrench']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'iTalki - French Tutors', 'url' => 'https://www.italki.com/teachers/french'], 'youtube_resource' => ['title' => 'Shadowing Practice', 'url' => 'https://www.youtube.com/results?search_query=french+shadowing+practice']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Netflix in French', 'url' => 'https://www.netflix.com/browse/genre/100378'], 'youtube_resource' => ['title' => 'Cyprien (Native YouTuber)', 'url' => 'https://www.youtube.com/user/MonsieurDream']],
                ]
            ],
            [
                'title' => 'Semaine 2 : Navigating the Future & Pronouns',
                'focus' => 'Focus: Futur Proche/Simple and \'y\' & \'en\'. Stop repeating the same nouns. Master direct/indirect object pronouns (le, la, les, lui, leur) and the spatial/quantity pronouns (y and en). This is what makes French sound "fluid." Pair this with mastering how to talk about the future.',
                'milestone' => 'Explain your 5-year career or life plan to a language partner (or camera), successfully substituting nouns with y or en at least 5 times (e.g., "J\'y vais" instead of "Je vais à Paris").',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Pronoms Y et EN', 'url' => 'https://www.lepointdufle.net/p/pronoms-y-en.htm'], 'youtube_resource' => ['title' => 'Maîtriser Y et EN', 'url' => 'https://www.youtube.com/results?search_query=pronoms+y+et+en+francais']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'Journal en français facile', 'url' => 'https://savoirs.rfi.fr/fr/apprendre-enseigner/langue-francaise/journal-en-francais-facile'], 'youtube_resource' => ['title' => 'French Comprehensible Input', 'url' => 'https://www.youtube.com/c/FrenchComprehensibleInput']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'HelloTalk Exchange', 'url' => 'https://www.hellotalk.com/'], 'youtube_resource' => ['title' => 'Future Tense Speaking', 'url' => 'https://www.youtube.com/results?search_query=parler+au+futur+francais']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Lupin on Netflix', 'url' => 'https://www.netflix.com/title/80990668'], 'youtube_resource' => ['title' => 'Norman (Native YouTuber)', 'url' => 'https://www.youtube.com/user/NormanFaitDesVideos']],
                ]
            ],
            [
                'title' => 'Semaine 3 : The Ear Training Gauntlet',
                'focus' => 'Focus: Transitioning to Native Audio. Around Week 3, the "brain fog" will hit. Push through. Shift your input from learner-focused audio to native-speed podcasts and YouTube videos. French natives drop the ne in negative sentences (Je sais pas instead of Je ne sais pas) and mash words together (T\'es instead of Tu es).',
                'milestone' => 'Watch a 20-minute French YouTube vlog intended for natives with subtitles turned completely off. Write a half-page summary of the video in French.',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Le français parlé (omissions)', 'url' => 'https://www.frenchpod101.com/french-pronunciation/'], 'youtube_resource' => ['title' => 'Spoken French Rules', 'url' => 'https://www.youtube.com/results?search_query=spoken+french+vs+written+french']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'Transfert Podcast', 'url' => 'https://slate.fr/audio/transfert/'], 'youtube_resource' => ['title' => 'Easy French (Street Interviews)', 'url' => 'https://www.youtube.com/c/EasyFrench']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Tandem Language Exchange', 'url' => 'https://www.tandem.net/'], 'youtube_resource' => ['title' => 'Improve French Listening', 'url' => 'https://www.youtube.com/results?search_query=ameliorer+comprehension+orale+francais']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Arte Documentaries', 'url' => 'https://www.arte.tv/fr/'], 'youtube_resource' => ['title' => 'Squeezie (Native YouTuber)', 'url' => 'https://www.youtube.com/user/aMOODIEsqueezie']],
                ]
            ],
            [
                'title' => 'Semaine 4 : The Subjunctive & Opinions',
                'focus' => 'Focus: Emotion, Doubt, and Necessity. The subjunctive mood terrifies learners, but you only need to know it for specific triggers (Il faut que, Je veux que, Bien que). Focus only on the most common irregular subjunctive verbs (faire, être, avoir, aller, pouvoir, savoir).',
                'milestone' => 'Record a 5-minute unscripted debate taking a stance on a controversial topic. You must correctly trigger and use the subjunctive mood at least three times to express doubt or necessity.',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Le Subjonctif', 'url' => 'https://www.lepointdufle.net/p/subjonctif.htm'], 'youtube_resource' => ['title' => 'Maîtriser le Subjonctif', 'url' => 'https://www.youtube.com/results?search_query=apprendre+le+subjonctif+francais']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'Français avec Pierre', 'url' => 'https://www.francaisavecpierre.com/'], 'youtube_resource' => ['title' => 'Subjonctif dans la vraie vie', 'url' => 'https://www.youtube.com/results?search_query=subjonctif+francais+avec+pierre']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'iTalki Tutors', 'url' => 'https://www.italki.com/teachers/french'], 'youtube_resource' => ['title' => 'Exprimer son opinion', 'url' => 'https://www.youtube.com/results?search_query=exprimer+son+opinion+en+francais']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Dix Pour Cent (Call My Agent)', 'url' => 'https://www.netflix.com/title/80133335'], 'youtube_resource' => ['title' => 'HugoDécrypte (News)', 'url' => 'https://www.youtube.com/c/HugoD%C3%A9crypte']],
                ]
            ],
            [
                'title' => 'Semaine 5 : Conversational Connectors',
                'focus' => 'Focus: Flow and Natural Fillers. You know the grammar; now you need to sound human. Focus entirely on conversational connectors: En fait (in fact), Du coup (so/therefore), Par contre (on the other hand), D\'ailleurs (by the way), and Bref (anyway).',
                'milestone' => 'Hold a 30-minute continuous, unscripted conversation with a native speaker (via iTalki or language exchange) using at least 5 different natural connectors without ever reverting to English to fill a silence.',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Connecteurs Logiques', 'url' => 'https://www.bonjourdefrance.com/exercices/contenu/les-connecteurs-logiques.html'], 'youtube_resource' => ['title' => 'Mots de liaison', 'url' => 'https://www.youtube.com/results?search_query=mots+de+liaison+francais+oral']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'L\'heure du Monde (Podcast)', 'url' => 'https://www.lemonde.fr/podcasts/'], 'youtube_resource' => ['title' => 'Fillers in French (Du coup, etc)', 'url' => 'https://www.youtube.com/results?search_query=french+filler+words+du+coup+bref']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'HelloTalk Exchange', 'url' => 'https://www.hellotalk.com/'], 'youtube_resource' => ['title' => 'Speaking smoothly', 'url' => 'https://www.youtube.com/results?search_query=parler+francais+naturellement']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Le Bureau des Légendes', 'url' => 'https://www.canalplus.com/series/le-bureau-des-legendes/'], 'youtube_resource' => ['title' => 'Natoo (Native YouTuber)', 'url' => 'https://www.youtube.com/user/PtiteNatoo']],
                ]
            ],
            [
                'title' => 'Semaine 6 : Slang and Informal French',
                'focus' => 'Focus: Verlan and Street French. Textbook French is not how everyday people speak in Paris, Montreal, or Dakar. Spend this week learning essential Verlan (inverted words like ouf for fou, meuf for femme) and colloquial vocabulary (un mec, kiffer, chiant).',
                'milestone' => 'Watch a full episode of a modern French TV show (like Lupin or Dix pour cent) with ONLY French subtitles. You must be able to pause and successfully define 10 slang terms or colloquialisms used by the characters.',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Dictionnaire de l\'Argot', 'url' => 'https://www.dictionnairedelazone.fr/'], 'youtube_resource' => ['title' => 'French Slang & Verlan', 'url' => 'https://www.youtube.com/results?search_query=french+slang+verlan']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'Kiffe Kiffe Demain (Book)', 'url' => 'https://fr.wikipedia.org/wiki/Kiffe_kiffe_demain'], 'youtube_resource' => ['title' => 'Street French Interviews', 'url' => 'https://www.youtube.com/results?search_query=street+french+interviews']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Tandem Language Exchange', 'url' => 'https://www.tandem.net/'], 'youtube_resource' => ['title' => 'Sound like a Parisian', 'url' => 'https://www.youtube.com/results?search_query=how+to+sound+parisian']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Family Business on Netflix', 'url' => 'https://www.netflix.com/title/81011118'], 'youtube_resource' => ['title' => 'Mister V (Native YouTuber)', 'url' => 'https://www.youtube.com/user/mistervonline']],
                ]
            ],
            [
                'title' => 'Semaine 7 : The Professional Pivot',
                'focus' => 'Focus: Formal Language and The Conditional. Pivot to high-level input. Read news articles, listen to political podcasts, and master the Conditional tense for politeness and hypotheticals (Je voudrais, Si j\'avais le temps, je le ferais).',
                'milestone' => 'Read a full editorial article from Le Monde or Le Figaro. Immediately afterward, summarize the author\'s argument out loud for 3 minutes, analyzing their stance using formal vocabulary.',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Le Conditionnel', 'url' => 'https://www.lepointdufle.net/p/conditionnel.htm'], 'youtube_resource' => ['title' => 'Leçon de Conditionnel', 'url' => 'https://www.youtube.com/results?search_query=conditionnel+francais']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'Le Monde', 'url' => 'https://www.lemonde.fr/'], 'youtube_resource' => ['title' => 'France 24 News', 'url' => 'https://www.youtube.com/user/france24']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'iTalki Business French', 'url' => 'https://www.italki.com/teachers/french?tags=business'], 'youtube_resource' => ['title' => 'French Job Interview', 'url' => 'https://www.youtube.com/results?search_query=entretien+embauche+francais']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Le Figaro', 'url' => 'https://www.lefigaro.fr/'], 'youtube_resource' => ['title' => 'TEDx en Français', 'url' => 'https://www.youtube.com/results?search_query=tedx+francais']],
                ]
            ],
            [
                'title' => 'Semaine 8 : Total Immersion & Shadowing',
                'focus' => 'Focus: Accent Refinement and Fluidity. No new grammar. This week is purely about speed, accent reduction, and output. Do "shadowing" exercises—listen to a native speaker and repeat exactly what they say a fraction of a second later, matching their intonation, rhythm, and mouth shapes.',
                'milestone' => 'Record a 10-minute uninterrupted monologue on a complex topic (e.g., the impact of technology on society). Listen to it back-to-back with your Week 1 recording to hear the definitive proof of your new competency.',
                'checklist' => [
                    ['task' => 'Hour 1: Active Study (Morning) - Anki flashcards and targeted grammar exercises.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Phonétique Française', 'url' => 'https://www.lepointdufle.net/p/phonetique.htm'], 'youtube_resource' => ['title' => 'French Pronunciation Guide', 'url' => 'https://www.youtube.com/results?search_query=french+pronunciation+guide']],
                    ['task' => 'Hours 2 & 3: Comprehensible Input - Listening and reading to content just slightly above your level.', 'weekly_goal_minutes' => 120, 'resource' => ['title' => 'France Inter', 'url' => 'https://www.franceinter.fr/'], 'youtube_resource' => ['title' => 'Documentaires Français', 'url' => 'https://www.youtube.com/results?search_query=documentaire+arte']],
                    ['task' => 'Hour 4: Output & Speaking - 1-on-1 tutoring, language exchange, or speaking out loud.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'Conversation Exchange', 'url' => 'https://www.conversationexchange.com/'], 'youtube_resource' => ['title' => 'Advanced French Shadowing', 'url' => 'https://www.youtube.com/results?search_query=advanced+french+shadowing']],
                    ['task' => 'Hour 5: Passive/Native Media (Evening) - Watching French YouTubers, Netflix, or reading a French book.', 'weekly_goal_minutes' => 60, 'resource' => ['title' => 'L\'Étranger (Albert Camus)', 'url' => 'https://fr.wikipedia.org/wiki/L%27%C3%89tranger'], 'youtube_resource' => ['title' => 'Mcfly et Carlito', 'url' => 'https://www.youtube.com/channel/UC-yEAJzDD7N5sXzX2p6a3bw']],
                ]
            ]
        ];

        $heroWeekNumber = 1;
        foreach ($heroWeeks as $index => $week) {
            $semaineNum = $index + 1;
            
            $parts = explode(':', $week['title'], 2);
            $themeTitle = isset($parts[1]) ? trim($parts[1]) : $week['title'];

            for ($day = 1; $day <= 7; $day++) {
                Week::create([
                    'week_number' => $heroWeekNumber++,
                    'path' => 'zero_to_hero',
                    'title' => "Semaine {$semaineNum} - Jour {$day} : {$themeTitle}",
                    'focus' => $week['focus'],
                    'milestone' => $week['milestone'],
                    'checklist' => $week['checklist'],
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
