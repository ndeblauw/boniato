<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public string $endpoint;
    public string $lang;
    public string $key;

    public function __construct()
    {
        $this->endpoint = 'https://api.weatherapi.com/v1/current.json';
        $this->lang = 'English';
        $this->key = config('services.weather_api.key');
    }

    public function getWeather(string $city): array
    {
        try {
            $response = Http::get($this->endpoint, [
                'q' => $city,
                'lang' => $this->lang,
                'key' => $this->key,
            ]);

            if($response->successful()) {
                $weather = json_decode($response->body());
                return [
                    'temperature' => $weather->current->temp_c,
                    'text' => $weather->current->condition->text,
                ];
            } else {
                return [
                    'temperature' => null,
                    'text' => 'Error in fetching weather data',
                ];
            }

        } catch (\Exception $e) {
            return [
                'temperature' => null,
                'text' => 'Error in fetching weather data',
            ];
        }

    }


}
