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
        $endpoint="https://api.api-ninjas.com/v2/randomquotes";
        $key = config('services.api_ninjas.key');

        $response = Http::withHeaders([
            'X-Api-Key' => $key,
        ])->get($endpoint);

        if($response->failed()) {
            $quote = (object) [
                'quote' => 'Don\'t worry about the presentation tomorrow.',
                'author' => 'Nico Deblauwe',
            ];
        } else {
            $quote = json_decode($response->body())[0];

        }


        return view('components.quote', compact('quote'));
    }
}
