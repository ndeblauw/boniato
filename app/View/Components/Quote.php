<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;

class Quote extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $quote = cache()->flexible('random-quote', [10, 20], function() {
            return $this->fetchQuote();
        });

        return view('components.quote', compact('quote'));
    }

    private function fetchQuote()
    {
        $endpoint="https://api.api-ninjas.com/v2/randomquotes";
        $key = config('services.api_ninjas.key');

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $key,
            ])->get($endpoint);

            if($response->successful()) {
                $quote = json_decode($response->body())[0];
            } else {
                throw new \Exception('API request failed');
            }
        } Catch (\Exception $e) {
            $quote = (object) [
                'quote' => 'Don\'t worry about the presentation tomorrow.',
                'author' => 'Nico Deblauwe',
            ];
        }

        return $quote;
    }
}
