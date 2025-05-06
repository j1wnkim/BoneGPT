<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Http; // Laravel HTTP Client

class ChatbotController extends Controller
{
    public function index()
    {
        // Return the chatbot page (view)
        return view('chatbot');
    }

    public function storeInput(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'message' => 'required|string',
        ]);

        // Get the user's message from the request
        $userMessage = $request->input('message');

        // Log the incoming user message (as in the first controller)
        Log::channel('user_inputs')->info('User input: ' . $userMessage);
        Log::info('User input: ' . $userMessage);

        // Call the Node.js API with the user's message
        try {
            $response = Http::post('http://localhost:3000/processMessage', [
                'message' => $userMessage, // Send the user input
            ]);

            // Check if the API request was successful
            if ($response->successful()) {
                $botReply = $response->json()['reply']; // Get the 'reply' from the Node.js API response
            } else {
                $botReply = 'Sorry, there was an error processing your message. Please try again later.';
            }
        } catch (\Exception $e) {
            // Handle exceptions, e.g. Node.js server is down
            Log::error('Node.js API request failed: ' . $e->getMessage());
            $botReply = 'Sorry, there was an error connecting to the chatbot API.';
        }

        // Respond with the chatbot's reply
        return response()->json(['reply' => $botReply]);
    }
    private function callLLMApi($llm, $message)
    {
        $apiUrl = '';
        $payload = ['message' => $message];

        // Determine the API URL based on the selected LLM
        switch ($llm) {
            case 'ChatGPT':
                $apiUrl = 'http://localhost:3000/chatgpt';
                break;
            case 'GPT-4':
                $apiUrl = 'http://localhost:3000/gpt4';
                break;
            case 'Claude':
                $apiUrl = 'http://localhost:3000/claude';
                break;
            default:
                throw new \Exception('Invalid LLM selected.');
        }

        // Make the API request
        $response = Http::post($apiUrl, $payload);

        // Check if the API request was successful
        if ($response->successful()) {
            return $response->json()['reply']; // Get the 'reply' from the API response
        } else {
            throw new \Exception('API request failed with status: ' . $response->status());
        }
    }
}
