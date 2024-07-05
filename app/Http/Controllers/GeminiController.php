<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    public function queryGemini(Request $request)
    {
        $this->validate($request, [
            'query' => 'required|string|max:255',
        ]);

        $userQuery = $request->input('query');

        $geminiResponse = Gemini::geminiPro()->generateContent($userQuery);

        if ($geminiResponse->isSuccessful()) {
            $generatedText = $geminiResponse->text();

            return response()->json([
                'status' => 'success',
                'message' => $generatedText,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $geminiResponse->errorMessage(),
            ], $geminiResponse->statusCode());
        }
    }
}
