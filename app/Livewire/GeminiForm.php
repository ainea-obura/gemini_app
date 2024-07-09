<?php

namespace App\Livewire;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class GeminiForm extends Component
{
    public $query;
    public $response;
    public $parsedQuestions = [];
    public $error;

    protected $rules = [
        'query' => 'required|string|max:255',
    ];

    public function submit()
    {
        $this->validate();

        try {
            $cacheKey = 'gemini_query_'.md5($this->query);

            $this->response = Cache::remember($cacheKey, 3600, function () {
                $geminiResponse = Gemini::geminiPro()->generateContent($this->query);

                return $geminiResponse->text();
            });

            $this->error = null;

            // Parse response into questions array
            $this->parsedQuestions = explode("\n", trim($this->response));

            Log::info('Gemini API Response Cached:', [
                'query' => $this->query,
                'response' => $this->parsedQuestions,
            ]);
        } catch (\Exception $e) {
            Log::error('Gemini API Exception: '.$e->getMessage(), [
                'query' => $this->query,
                'exception' => $e,
            ]);

            $this->error = 'An unexpected error occurred: '.$e->getMessage();
            $this->response = null;
        }
    }

    public function render()
    {
        return view('livewire.gemini-form');
    }
}
