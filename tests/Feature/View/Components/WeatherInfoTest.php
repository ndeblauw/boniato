<?php

use App\View\Components\WeatherInfo;
use App\Services\WeatherService;
use Illuminate\View\View;

it('renders weather info component', function () {
    $weatherService = mock(WeatherService::class);
    $weatherService->shouldReceive('forIp')
        ->with('127.0.0.1')
        ->andReturnSelf();
    $weatherService->shouldReceive('getWeather')
        ->andReturn(['temperature' => 20, 'description' => 'Clear']);

    $component = new WeatherInfo($weatherService);
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.weather-info');
    expect($view->getData())->toHaveKey('ip');
    expect($view->getData())->toHaveKey('weather');
});

it('uses localhost ip override for development', function () {
    $weatherService = mock(WeatherService::class);
    $weatherService->shouldReceive('forIp')
        ->with('91.126.71.186')
        ->andReturnSelf();
    $weatherService->shouldReceive('getWeather')
        ->andReturn(['temperature' => 25, 'description' => 'Sunny']);

    request()->server->set('REMOTE_ADDR', '127.0.0.1');

    $component = new WeatherInfo($weatherService);
    
    $component->render();
    
    expect($component->weatherService)->toBe($weatherService);
});

it('uses real ip when not localhost', function () {
    $weatherService = mock(WeatherService::class);
    $weatherService->shouldReceive('forIp')
        ->with('8.8.8.8')
        ->andReturnSelf();
    $weatherService->shouldReceive('getWeather')
        ->andReturn(['temperature' => 15, 'description' => 'Cloudy']);

    request()->server->set('REMOTE_ADDR', '8.8.8.8');

    $component = new WeatherInfo($weatherService);
    
    $component->render();
    
    expect($component->weatherService)->toBe($weatherService);
});

it('constructs with weather service dependency', function () {
    $weatherService = mock(WeatherService::class);

    $component = new WeatherInfo($weatherService);
    
    expect($component->weatherService)->toBe($weatherService);
});