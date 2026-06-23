<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Licence;

class AiController extends Controller
{
    private function callGithubModel($prompt)
    {
        $apiKey = env('GITHUB_PAT');
        
        if (!$apiKey) {
            return [
                'error' => true,
                'message' => 'GITHUB_PAT is not set in the .env file.',
            ];
        }

        $apiKey = trim($apiKey, " \t\n\r\0\x0B'\"");
        $apiKey = explode("'", $apiKey)[0];
        $apiKey = explode(" ", $apiKey)[0];
        $apiKey = trim($apiKey);
        
        $url = "https://models.inference.ai.azure.com/chat/completions";

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($url, [
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'model' => 'gpt-4o-mini',
                    'temperature' => 0.7,
                    'max_tokens' => 2000
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    return [
                        'error' => false,
                        'text' => $data['choices'][0]['message']['content']
                    ];
                }
            }

            return [
                'error' => true,
                'message' => 'Failed to get a response from GitHub API: ' . $response->body()
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Connection Error: ' . $e->getMessage()
            ];
        }
    }

    public function enhanceText(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'context' => 'nullable|string'
        ]);

        $prompt = "You are an expert resume writer. Please enhance the following text to sound more professional, concise, and impactful for a Software Developer resume. " . 
                  ($validated['context'] ? "Context: {$validated['context']}. " : "") . 
                  "Do not include any intro or outro, just return the enhanced text itself.\n\nText: " . $validated['text'];

        $result = $this->callGithubModel($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json(['enhanced_text' => trim($result['text'])]);
    }

    public function analyzeCv(Request $request)
    {
        $validated = $request->validate([
            'cv_text' => 'required|string'
        ]);

        $licences = Licence::all();
        $licencesList = $licences->map(function($l) {
            return "- ID: {$l->id}, Name: {$l->name}, Institute: {$l->institute}";
        })->join("\n");

        $prompt = "You are an expert academic advisor in France. Analyze the following developer CV and compare it to these L3 Licences avec Alternance. Assign a 'match score' (0-100) to each Licence.
        
Return ONLY a strictly valid JSON array of objects. Do not use markdown blocks like ```json.
The JSON must look EXACTLY like this structure:
[
  { \"licence_id\": 1, \"score\": 90, \"reason\": \"Strong web skills match Fullstack L3.\" },
  { \"licence_id\": 2, \"score\": 60, \"reason\": \"Lacks Java experience for this program.\" }
]

Licences:
{$licencesList}

CV:
{$validated['cv_text']}";

        $result = $this->callGithubModel($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        // Log the raw response for debugging!
        \Illuminate\Support\Facades\Log::info("RAW GITHUB CV RESPONSE: " . $result['text']);

        // Clean up markdown if the model accidentally included it
        $jsonStr = str_replace(['```json', '```'], '', trim($result['text']));
        
        $scores = json_decode($jsonStr, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to parse AI response as JSON: ' . $jsonStr], 500);
        }

        // Handle case where Gemini returns { "scores": [...] } instead of [...]
        if (isset($scores['scores']) && is_array($scores['scores'])) {
            $scores = $scores['scores'];
        }

        return response()->json(['scores' => $scores]);
    }

    private function extractTextFromPdf($file)
    {
        if (!class_exists(\Smalot\PdfParser\Parser::class)) {
            throw new \Exception('smalot/pdfparser is not installed. Please run composer require smalot/pdfparser');
        }

        $parser = new \Smalot\PdfParser\Parser();
        $pdf    = $parser->parseFile($file->getPathname());
        return $pdf->getText();
    }

    public function extractPdfText(Request $request)
    {
        $request->validate(['cv_pdf' => 'required|file|mimes:pdf']);

        try {
            $text = $this->extractTextFromPdf($request->file('cv_pdf'));
            return response()->json(['text' => $text]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function parseResumePdf(Request $request)
    {
        $request->validate(['cv_pdf' => 'required|file|mimes:pdf']);

        try {
            $text = $this->extractTextFromPdf($request->file('cv_pdf'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $prompt = "You are an expert CV parser. I will give you the raw text of a CV. I need you to extract the information and return ONLY a valid JSON object matching exactly this structure: 
{
  \"personalInfo\": { \"name\": \"\", \"email\": \"\", \"phone\": \"\", \"summary\": \"\" },
  \"experience\": [ { \"company\": \"\", \"role\": \"\", \"description\": \"\" } ],
  \"education\": [ { \"institution\": \"\", \"degree\": \"\", \"year\": \"\" } ],
  \"skills\": \"comma separated skills\"
}.
Return ONLY JSON, no markdown blocks.

CV Text:
" . $text;

        $result = $this->callGithubModel($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        $jsonStr = str_replace(['```json', '```'], '', trim($result['text']));
        $parsed = json_decode($jsonStr, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to parse AI response as JSON.'], 500);
        }

        return response()->json(['resume' => $parsed]);
    }

    public function chatPractice(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array'
        ]);

        $historyStr = "";
        if ($request->has('history') && is_array($request->history)) {
            foreach ($request->history as $msg) {
                $role = isset($msg['role']) && $msg['role'] === 'user' ? 'Student' : 'Tutor';
                $content = isset($msg['content']) ? $msg['content'] : '';
                $historyStr .= "{$role}: {$content}\n";
            }
        }

        $prompt = "You are 'Maestro', a friendly and encouraging native French language tutor. 
Your student is learning French and is currently around a B1 level.
Your rules:
1. ALWAYS reply entirely in French, keeping the vocabulary at a B1/B2 level.
2. If the student makes a grammatical error, politely correct them in French before continuing the conversation.
3. Ask a relevant follow-up question to keep the conversation flowing.
4. Keep your responses relatively short and conversational (2-4 sentences max).

Conversation History:
{$historyStr}

Student's latest message: {$request->message}

Tutor's reply:";

        $result = $this->callGithubModel($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json(['reply' => trim($result['text'])]);
    }

    public function mockInterview(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array'
        ]);

        $historyStr = "";
        if ($request->has('history') && is_array($request->history)) {
            foreach ($request->history as $msg) {
                $role = isset($msg['role']) && $msg['role'] === 'user' ? 'Student' : 'Interviewer';
                $content = isset($msg['content']) ? $msg['content'] : '';
                $historyStr .= "{$role}: {$content}\n";
            }
        }

        $prompt = "Tu es un conseiller pédagogique de Campus France, très strict mais professionnel.
Tu mènes un entretien de 20 minutes (simulation) avec un étudiant marocain de l'OFPPT qui postule pour une Licence 3 en France.
Tes règles :
1. Pose toujours UNE SEULE question à la fois.
2. Si les réponses de l'étudiant sont trop courtes ou vagues, demande-lui d'élaborer de façon ferme.
3. Alterne entre les questions sur ses motivations, son projet d'étude, son projet professionnel et ses choix d'universités.
4. Parle toujours en français très formel et professionnel.
5. Garde tes répliques courtes (1 à 3 phrases).
6. N'oublie pas que le but est de tester sa capacité à s'exprimer en français et à argumenter son projet.

Historique de l'entretien:
{$historyStr}

Dernier message de l'étudiant: {$request->message}

Réponse du conseiller Campus France:";

        $result = $this->callGithubModel($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json(['reply' => trim($result['text'])]);
    }

    public function generateCoverLetter(Request $request)
    {
        $request->validate([
            'formation' => 'required|string',
            'universite' => 'required|string',
            'parcours' => 'required|string',
            'projet_pro' => 'required|string'
        ]);

        $prompt = "Tu es un expert en rédaction de 'Projet d'Études' (lettre de motivation) pour Campus France.
Rédige une lettre de motivation professionnelle, convaincante et sans aucune faute de français pour un étudiant marocain diplômé de l'OFPPT.
La lettre doit suivre les standards universitaires français (ton formel, structure logique : Vous, Moi, Nous).

Informations sur l'étudiant et la candidature :
- Parcours actuel (OFPPT) : {$request->parcours}
- Formation visée en France : {$request->formation}
- Université visée : {$request->universite}
- Projet professionnel futur : {$request->projet_pro}

Rédige uniquement le corps de la lettre de motivation (sans les adresses en haut ni la date). Le ton doit être sérieux et montrer la détermination de l'étudiant.";

        $result = $this->callGithubModel($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json(['letter' => trim($result['text'])]);
    }
}
