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
                'title' => 'The Foundation & Sounds',
                'focus' => 'Focus exclusively on the alphabet, pronunciation rules, and the 100 most common verbs in the present tense (regular only).',
                'milestone' => 'Confidently introduce yourself, state your profession as a full-stack developer, and explain your immediate goals entirely in Spanish.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Madrigal\'s Magic Key to Spanish', 'author' => 'Margarita Madrigal', 'url' => 'https://www.amazon.com/Madrigals-Magic-Key-Spanish-Creative/dp/0385410956']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Learn the fundamental rules of Spanish pronunciation and master the alphabet (focusing on RR and J sounds).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Alphabet Pronunciation', 'url' => 'https://www.youtube.com/results?search_query=spanish+alphabet+pronunciation']
                    ],
                    [
                        'task' => 'Step 2: Start building a mental model of grammar by listening to Language Transfer audio tracks.', 
                        'weekly_goal_minutes' => 210,
                        'resource' => ['title' => 'Language Transfer', 'url' => 'https://www.languagetransfer.org/spanish']
                    ],
                    [
                        'task' => 'Step 3: Memorize how to conjugate regular -AR, -ER, and -IR verbs in the present tense.', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'Regular Verbs Guide', 'url' => 'https://studyspanish.com/grammar']
                    ],
                    [
                        'task' => 'Step 4: Combine the sounds and verbs you learned to introduce yourself aloud in the mirror.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Self-Intro Examples', 'url' => 'https://www.youtube.com/results?search_query=how+to+introduce+yourself+in+spanish']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'Instituto Cervantes A1 Exam Portal', 'url' => 'https://examenes.cervantes.es/es/dele/preparar-prueba']
                ]
            ],
            [
                'week_number' => 2,
                'title' => 'The Core Vocabulary Sprint',
                'focus' => 'Begin memorizing the 1,000 most frequent words using spaced repetition software. Start building simple Subject-Verb-Object sentences.',
                'milestone' => 'Describe your daily coding and gym routine from morning to night without pausing to search for basic verbs.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Short Stories in Spanish for Beginners', 'author' => 'Olly Richards', 'url' => 'https://www.amazon.com/Short-Stories-Spanish-Beginners-Vocabulary/dp/1473683254']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Install Anki and download the "1000 Most Common Spanish Words" deck.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => ['title' => 'Anki Download', 'url' => 'https://apps.ankiweb.net/']
                    ],
                    [
                        'task' => 'Step 2: Begin reviewing 50 new Anki vocabulary cards every day.', 
                        'weekly_goal_minutes' => 315,
                        'resource' => ['title' => 'Top 1000 Words Deck', 'url' => 'https://ankiweb.net/shared/decks/spanish']
                    ],
                    [
                        'task' => 'Step 3: Study and memorize the "Big Four" irregular verbs (Ser, Estar, Ir, and Tener).', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'Ser vs Estar Video', 'url' => 'https://www.youtube.com/results?search_query=ser+vs+estar+spanish']
                    ],
                    [
                        'task' => 'Step 4: Use your new vocabulary and irregular verbs to write a paragraph describing your daily routine.', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Daily Routine Vocab', 'url' => 'https://www.youtube.com/results?search_query=my+daily+routine+in+spanish']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'A1 Reading Comprehension Portal', 'url' => 'https://aprenderespanol.org/lecturas/ejercicios-de-lectura-1.html']
                ]
            ],
            [
                'week_number' => 3,
                'title' => 'The Art of the Question',
                'focus' => 'Learn all interrogative words and how to ask for clarification, directions, and definitions.',
                'milestone' => 'Successfully navigate an entirely Spanish conversation with a language partner using only questions and short responses to keep them talking.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Practice Makes Perfect: Spanish Pronouns', 'author' => 'Dorothy Richmond', 'url' => 'https://www.amazon.com/Practice-Makes-Perfect-Pronouns-Prepositions/dp/1259586326']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Memorize all major interrogative words (Qué, Quién, Cómo, Cuándo, Dónde, Por qué).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Question Words Guide', 'url' => 'https://www.spanishdict.com/guide/spanish-question-words']
                    ],
                    [
                        'task' => 'Step 2: Learn critical survival phrases for when you get stuck ("¿Puedes repetir?", "¿Qué significa?").', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Survival Phrases Video', 'url' => 'https://www.youtube.com/results?search_query=spanish+survival+phrases+for+beginners']
                    ],
                    [
                        'task' => 'Step 3: Download a language exchange app to find a native conversation partner.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => ['title' => 'HelloTalk App', 'url' => 'https://www.hellotalk.com/']
                    ],
                    [
                        'task' => 'Step 4: Have your first basic text chat with a native speaker, focusing purely on asking them questions about themselves.', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'HelloTalk', 'url' => 'https://www.hellotalk.com/']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'A1 Question Words Quiz', 'url' => 'https://www.spanishdict.com/quizzes']
                ]
            ],
            [
                'week_number' => 4,
                'title' => 'Stepping into the Past (Preterite)',
                'focus' => 'Introduce the preterite tense to talk about completed actions in the past. Consume easy Spanish podcasts.',
                'milestone' => 'Recount a recent weekend trip or the exact steps you took to complete a past software project.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Spanish Verb Drills', 'author' => 'Vivienne Bey', 'url' => 'https://www.amazon.com/Spanish-Verb-Drills-Fifth-Vivienne/dp/1260121757']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Study the grammar rules and endings for the Preterite tense (completed actions).', 
                        'weekly_goal_minutes' => 175,
                        'resource' => ['title' => 'Preterite Tense Guide', 'url' => 'https://www.spanishdict.com/guide/spanish-preterite-tense-forms']
                    ],
                    [
                        'task' => 'Step 2: Listen to beginner-friendly Spanish podcasts to hear the past tense used naturally.', 
                        'weekly_goal_minutes' => 210,
                        'resource' => ['title' => 'Hoy Hablamos Spotify', 'url' => 'https://www.hoyhablamos.com/']
                    ],
                    [
                        'task' => 'Step 3: Write a short diary entry explaining exactly what you did yesterday from morning to night.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Journaling in Spanish', 'url' => 'https://www.youtube.com/results?search_query=how+to+journal+in+spanish']
                    ],
                    [
                        'task' => 'Step 4: Read your diary entry out loud to practice speaking in the past tense.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Self-Correction Audio', 'url' => 'https://vocaroo.com/']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'DELE A2 Simulation Portal', 'url' => 'https://examenes.cervantes.es/es/dele/preparar-prueba']
                ]
            ],
            [
                'week_number' => 5,
                'title' => 'The Storyteller (Imperfect vs. Preterite)',
                'focus' => 'Master the distinction between the two past tenses. Read short stories or graded readers in Spanish.',
                'milestone' => 'Tell a cohesive, continuous three-minute story about a childhood memory or a past life event using both past tenses correctly.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Spanish Short Stories for Beginners Volume 2', 'author' => 'Lingo Mastery', 'url' => 'https://www.amazon.com/Spanish-Short-Stories-Beginners-Vol/dp/1090333240']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Learn the grammar rules for the Imperfect tense (ongoing past actions & background descriptions).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Imperfect Tense Guide', 'url' => 'https://www.spanishdict.com/guide/spanish-imperfect-tense-forms']
                    ],
                    [
                        'task' => 'Step 2: Read short stories specifically written for A2 learners to see how Preterite and Imperfect are mixed.', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'A2 Short Stories', 'url' => 'https://www.amazon.com/Short-Stories-Spanish-Beginners-Vol/dp/1090333240']
                    ],
                    [
                        'task' => 'Step 3: Analyze the stories and identify why the author chose Imperfect vs Preterite for each sentence.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Preterite vs Imperfect Masterclass', 'url' => 'https://www.youtube.com/results?search_query=preterite+vs+imperfect+spanish']
                    ],
                    [
                        'task' => 'Step 4: Speak out loud for three minutes recounting a childhood memory using both tenses.', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Telling Stories', 'url' => 'https://www.youtube.com/results?search_query=how+to+tell+a+story+in+spanish']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'A2 Grammar Hub: Past Tenses', 'url' => 'https://aprenderespanol.org/verbos/preterito-imperfecto.html']
                ]
            ],
            [
                'week_number' => 6,
                'title' => 'The Future & The Conditional',
                'focus' => 'Learn how to express what will happen and what would happen. This is mechanically the easiest part of Spanish grammar.',
                'milestone' => 'Clearly explain your concrete plans for moving to Europe, studying, and working over the next five years.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Advanced Spanish Step-by-Step', 'author' => 'Barbara Bregstein', 'url' => 'https://www.amazon.com/Advanced-Spanish-Step-Step-Master/dp/0071768735']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Study the simple Future tense endings (keep the infinitive and add -é, -ás, -á).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Future Tense Guide', 'url' => 'https://www.spanishdict.com/guide/simple-future-regular-forms-and-tenses']
                    ],
                    [
                        'task' => 'Step 2: Study the Conditional tense endings for hypothetical scenarios (add -ía).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Conditional Tense Guide', 'url' => 'https://www.youtube.com/results?search_query=conditional+tense+spanish']
                    ],
                    [
                        'task' => 'Step 3: Write down your 5-year plan using the Future tense (I will live in Spain, I will work as a dev).', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Future Goals Example', 'url' => 'https://www.youtube.com/results?search_query=talking+about+the+future+spanish']
                    ],
                    [
                        'task' => 'Step 4: Speak out loud about what you WOULD do if you won the lottery tomorrow using the Conditional tense.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Lottery Conditional Phrases', 'url' => 'https://www.youtube.com/results?search_query=si+yo+ganara+la+loteria+espanol']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'A2 Future Tense Practice', 'url' => 'https://aprenderespanol.org/verbos/futuro.html']
                ]
            ],
            [
                'week_number' => 7,
                'title' => 'The Immersion Shift',
                'focus' => 'Change your phone, computer, and IDE language to Spanish. Learn industry-specific vocabulary related to web development.',
                'milestone' => 'Read a full technical article, framework documentation, or API reference in Spanish and implement a basic feature based on it.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Clean Code (Código Limpio - Spanish Edition)', 'author' => 'Robert C. Martin', 'url' => 'https://www.amazon.es/C%C3%B3digo-limpio-desarrollo-software-Programaci%C3%B3n/dp/8441532109']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Change your smartphone, OS, and IDE (VSCode/IntelliJ) system languages to Spanish.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => ['title' => 'Immersion Philosophy', 'url' => 'https://refold.la/roadmap/stage-1/a/immersion']
                    ],
                    [
                        'task' => 'Step 2: Research and create an Anki deck for technical vocabulary (e.g., base de datos, depurar, bucle).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Spanish Tech Vocab', 'url' => 'https://www.youtube.com/results?search_query=programming+vocabulary+in+spanish']
                    ],
                    [
                        'task' => 'Step 3: Read an entire technical programming tutorial or official documentation page (like React or MDN) in Spanish.', 
                        'weekly_goal_minutes' => 175,
                        'resource' => ['title' => 'MDN Web Docs (Spanish)', 'url' => 'https://developer.mozilla.org/es/']
                    ],
                    [
                        'task' => 'Step 4: Watch a Spanish tech YouTuber build a project and follow along to get used to spoken technical language.', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'Midudev (Tech YouTuber)', 'url' => 'https://www.youtube.com/@midudev']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'B1 SIELE Preparation', 'url' => 'https://siele.org/examen']
                ]
            ],
            [
                'week_number' => 8,
                'title' => 'The Subjunctive (Basics)',
                'focus' => 'Tackle the present subjunctive. View it as the mood used for WEIRDO (Wishes, Emotions, Impersonal expressions, Recommendations, Doubt, Ojalá).',
                'milestone' => 'Express doubts, desires, and strong recommendations regarding the architecture of a hypothetical software application.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Perfecting the Past in Spanish', 'author' => 'Gordon Smith-Duran', 'url' => 'https://www.amazon.com/Perfecting-Past-Spanish-Gordon-Smith-Duran/dp/1535492471']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Learn how to construct the Present Subjunctive (swap -AR endings with -ER/-IR endings).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Subjunctive Video Explained', 'url' => 'https://www.youtube.com/results?search_query=spanish+present+subjunctive+explained']
                    ],
                    [
                        'task' => 'Step 2: Study the WEIRDO acronym to understand exactly when a sentence requires the subjunctive mood.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'WEIRDO Guide', 'url' => 'https://www.spanishdict.com/guide/spanish-subjunctive']
                    ],
                    [
                        'task' => 'Step 3: Complete written exercises translating English sentences expressing doubt and desire into Spanish.', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Subjunctive Practice', 'url' => 'https://aprenderespanol.org/verbos/subjuntivo-presente.html']
                    ],
                    [
                        'task' => 'Step 4: Give advice to a junior developer out loud, strictly using the subjunctive (e.g. "Te recomiendo que uses React").', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Giving Advice in Spanish', 'url' => 'https://www.youtube.com/results?search_query=giving+advice+in+spanish+subjunctive']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'Subjunctive Grammar Hub', 'url' => 'https://www.spanishdict.com/quizzes']
                ]
            ],
            [
                'week_number' => 9,
                'title' => 'The Listening Sprint',
                'focus' => 'Increase your audio input drastically. Watch Spanish YouTubers or Twitch streamers.',
                'milestone' => 'Watch a 20-minute unscripted Spanish YouTube video on a technical or fitness topic without subtitles and write a summary.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'No BS Spanish', 'author' => 'Lukas V. Barbosa', 'url' => 'https://www.amazon.com/No-BS-Spanish-Language-Hackers/dp/B08X62V33G']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Find 3 Spanish YouTubers or Twitch streamers that align with your personal hobbies (gaming, tech, fitness).', 
                        'weekly_goal_minutes' => 30,
                        'resource' => ['title' => 'Spanish Twitch Directory', 'url' => 'https://www.twitch.tv/directory/all/tags/es']
                    ],
                    [
                        'task' => 'Step 2: Watch unscripted, native-speed video content for at least 45 minutes a day with NO subtitles.', 
                        'weekly_goal_minutes' => 315,
                        'resource' => ['title' => 'Midudev (Tech YouTuber)', 'url' => 'https://www.youtube.com/@midudev']
                    ],
                    [
                        'task' => 'Step 3: Pick a 30-second audio clip from a podcast and transcribe every single word you hear to test your ear.', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Radio Ambulante (NPR)', 'url' => 'https://radioambulante.org/']
                    ],
                    [
                        'task' => 'Step 4: Write a summary of one of the YouTube videos you watched completely from memory.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Dictation Exercises', 'url' => 'https://aprenderespanol.org/audiciones/dictados-1.html']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'B1 Listening Practice', 'url' => 'https://aprenderespanol.org/audiciones/audio-3.html']
                ]
            ],
            [
                'week_number' => 10,
                'title' => 'Conversational Agility',
                'focus' => 'Focus entirely on speaking fluidly. Learn conversational "fillers" to sound natural while your brain searches for the next word.',
                'milestone' => 'Hold a continuous 15-minute unscripted conversation with a native speaker from Spain without switching to another language.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Conversational Spanish Dialogues', 'author' => 'Lingo Mastery', 'url' => 'https://www.amazon.com/Conversational-Spanish-Dialogues-Speakers-Vocabulary/dp/1980963503']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Memorize and practice common conversational fillers (pues, entonces, o sea, bueno, a ver).', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Spanish Fillers Video', 'url' => 'https://www.youtube.com/results?search_query=spanish+conversational+fillers']
                    ],
                    [
                        'task' => 'Step 2: Practice "circumlocution"—the art of describing a word you forgot using simpler words you do know.', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Circumlocution Examples', 'url' => 'https://www.youtube.com/results?search_query=circumlocution+in+spanish']
                    ],
                    [
                        'task' => 'Step 3: Book a 30-minute session with a Spanish tutor on iTalki or Preply.', 
                        'weekly_goal_minutes' => 30,
                        'resource' => ['title' => 'iTalki Tutors', 'url' => 'https://www.italki.com/']
                    ],
                    [
                        'task' => 'Step 4: Complete your tutoring session, ensuring you use fillers to keep the conversation flowing instead of pausing in silence.', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'Conversation Practice', 'url' => 'https://www.italki.com/']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'B1 Oral Interview Mock Video', 'url' => 'https://www.youtube.com/results?search_query=dele+b1+oral+exam+example']
                ]
            ],
            [
                'week_number' => 11,
                'title' => 'Academic & Professional Integration',
                'focus' => 'Learn the formal vocabulary required for university admissions, government bureaucracy, and housing.',
                'milestone' => 'Read and fully comprehend the official admission requirements and syllabus for a Grado Superior IT program on a Spanish educational portal.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'The Ultimate Spanish Review and Practice', 'author' => 'Ronni Gordon', 'url' => 'https://www.amazon.com/Ultimate-Spanish-Review-Practice-Premium/dp/1260452397']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Learn housing and bureaucratic vocabulary (alquiler, fianza, padrón, empadronamiento, nómina).', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Idealista Housing App', 'url' => 'https://www.idealista.com/']
                    ],
                    [
                        'task' => 'Step 2: Browse Idealista.com and read 10 full apartment rental descriptions to test your comprehension.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Idealista', 'url' => 'https://www.idealista.com/']
                    ],
                    [
                        'task' => 'Step 3: Read a real, official syllabus PDF from a Spanish public institute for the DAW/DAM program.', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'TodoFP Portal', 'url' => 'https://www.todofp.es/']
                    ],
                    [
                        'task' => 'Step 4: Draft a formal email in Spanish inquiring about enrollment dates for a vocational degree.', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'Formal Email Guide', 'url' => 'https://www.spanishdict.com/guide/how-to-write-an-email-in-spanish']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'DELE B2 Overview', 'url' => 'https://examenes.cervantes.es/es/dele/preparar-prueba']
                ]
            ],
            [
                'week_number' => 12,
                'title' => 'The Fluency Bridge',
                'focus' => 'Review your weakest areas. The focus is purely on speed and reducing friction between thought and speech.',
                'milestone' => 'Conduct a 20-minute mock technical interview entirely in Spanish, explaining your tech stack.',
                'source_links' => [],
                'video_links' => [],
                'books' => [
                    ['title' => 'Cracking the Coding Interview (Spanish Concepts)', 'author' => 'Gayle Laakmann McDowell', 'url' => 'https://www.crackingthecodinginterview.com/']
                ],
                'checklist' => [
                    [
                        'task' => 'Step 1: Take a full practice grammar quiz covering B1/B2 material to identify your weak spots.', 
                        'weekly_goal_minutes' => 140,
                        'resource' => ['title' => 'Advanced Grammar Review', 'url' => 'https://studyspanish.com/grammar']
                    ],
                    [
                        'task' => 'Step 2: Spend targeted time reviewing the specific grammar rules you failed on the practice quiz.', 
                        'weekly_goal_minutes' => 175,
                        'resource' => ['title' => 'Instituto Cervantes Exams', 'url' => 'https://examenes.cervantes.es/']
                    ],
                    [
                        'task' => 'Step 3: Prepare an elevator pitch explaining your entire technical resume (experience, stack, goals) in Spanish.', 
                        'weekly_goal_minutes' => 70,
                        'resource' => ['title' => 'Resume Presentation', 'url' => 'https://www.youtube.com/results?search_query=entrevista+de+trabajo+programador']
                    ],
                    [
                        'task' => 'Step 4: Conduct a 20-minute mock technical interview using ChatGPT Voice.', 
                        'weekly_goal_minutes' => 105,
                        'resource' => ['title' => 'ChatGPT Voice', 'url' => 'https://chat.openai.com/']
                    ]
                ],
                'exam_links' => [
                    ['title' => 'SIELE Preparation Portal', 'url' => 'https://siele.org/examen']
                ]
            ],
        ];

        foreach ($weeks as $weekData) {
            Week::create($weekData);
        }

        $this->call([
            GradoSeeder::class,
        ]);
    }
}
