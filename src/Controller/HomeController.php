<?php

namespace App\Controller;

use OpenAI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index( ? string $question, ? string $response): Response
    {
        return $this->render('home/index.html.twig', [
            'question' => $question,
            'response' => $response
        ]);
    }



    #[Route('/chat', name: 'send_chat', methods: "POST")]
    public function chat(Request $request): Response
    {
        $question = $request->request->get('text');
    
        if (!$this->isAgricultureQuestion($question)) {
            // Return the error message as the response
            return $this->forward('App\Controller\HomeController::index', [
                'question' => $question,
                'response' => 'Désolé, je e ne peut pas répondre à des questions qui ne concernent pas l\'agriculture.'
            ]);
        }

        // Ajouter des mots-clés spécifiques à l'agriculture
        $prompt="" . $question;
    
        // Implémentation du chat GPT
        $myApiKey = $_ENV['OPENAI_KEY'];
        $client = OpenAI::client($myApiKey);
    
        $result = $client->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 2048
        ]);
    
        $response = $result->choices[0]->text;
    
        
    
        return $this->forward('App\Controller\HomeController::index', [
            'question' => $question,
            'response' => $response
        ]);
    }
    private function isAgricultureQuestion(string $question): bool
{
    // Add your logic to determine if the question is related to agriculture
    // For example, you can check for specific keywords or patterns in the question
    $keywords = ['agriculture', 'ferme', 'cultiver', 'plante', 'moutant', 'vache', 'arbre', 'terre', 'poule', 'bonjour', 'pluit', 'hello', 'صباح الخير'];
    
    foreach ($keywords as $keyword) {
        if (stripos($question, $keyword) !== false) {
            return true;
        }
    }

    return false;
}

   


}
