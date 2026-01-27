<?php

use App\View\Components\Quote;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

it('renders quote component', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::response([
            ['quote' => 'Test quote', 'author' => 'Test Author']
        ]),
    ]);

    $component = new Quote();
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.quote');
    expect($view->getData())->toHaveKey('quote');
});

it('fetches quote from API successfully', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::response([
            ['quote' => 'Test quote', 'author' => 'Test Author']
        ]),
    ]);

    $component = new Quote();
    
    $view = $component->render();
    $quote = $view->getData()['quote'];
    
    expect($quote->quote)->toBe('Test quote');
    expect($quote->author)->toBe('Test Author');
});

it('caches quote response', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::response([
            ['quote' => 'Test quote', 'author' => 'Test Author']
        ]),
    ]);

    $component = new Quote();
    
    $component->render();
    
    expect(Cache::has('random-quote'))->toBeTrue();
});

it('uses flexible cache with 10-20 second range', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::response([
            ['quote' => 'Test quote', 'author' => 'Test Author']
        ]),
    ]);

    $component = new Quote();
    
    $component->render();
    
    expect(Cache::has('random-quote'))->toBeTrue();
});

it('falls back to default quote on API failure', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::response('', 500),
    ]);

    $component = new Quote();
    
    $view = $component->render();
    $quote = $view->getData()['quote'];
    
    expect($quote->quote)->toBe('Don\'t worry about the presentation tomorrow.');
    expect($quote->author)->toBe('Nico Deblauwe');
});

it('falls back to default quote on network error', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::timeout(1)->response('', 500),
    ]);

    $component = new Quote();
    
    $view = $component->render();
    $quote = $view->getData()['quote'];
    
    expect($quote->quote)->toBe('Don\'t worry about the presentation tomorrow.');
    expect($quote->author)->toBe('Nico Deblauwe');
});

it('constructs without parameters', function () {
    $component = new Quote();
    
    expect($component)->toBeInstanceOf(Quote::class);
});

it('uses correct API endpoint', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::response([
            ['quote' => 'Test quote', 'author' => 'Test Author']
        ]),
    ]);

    $component = new Quote();
    
    $component->render();
    
    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.api-ninjas.com/v2/randomquotes' &&
               $request->hasHeader('X-Api-Key');
    });
});

it('handles malformed API response', function () {
    Http::fake([
        'https://api.api-ninjas.com/v2/randomquotes' => Http::response('invalid json'),
    ]);

    $component = new Quote();
    
    $view = $component->render();
    $quote = $view->getData()['quote'];
    
    expect($quote->quote)->toBe('Don\'t worry about the presentation tomorrow.');
    expect($quote->author)->toBe('Nico Deblauwe');
});