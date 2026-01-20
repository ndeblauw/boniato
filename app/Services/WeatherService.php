<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public string $endpoint;
    public string $lang;
    public string $key;
    public string $city;

    public function __construct(public IpServiceInterface $ipService)
    {
        $this->endpoint = 'https://api.weatherapi.com/v1/current.json';
        $this->lang = 'English';
        $this->key = config('services.weather_api.key');
    }

    public function forIp(string $ip): self
    {
        $this->city = $this->ipService->getCountry($ip);

        return $this;
    }

    public function forCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getWeather(): array
    {
        try {
            $response = Http::get($this->endpoint, [
                'q' => $this->city,
                'lang' => $this->lang,
                'key' => $this->key,
            ]);

            if($response->successful()) {
                $weather = json_decode($response->body());
                return [
                    'city' => $this->city,
                    'temperature' => $weather->current->temp_c,
                    'text' => $weather->current->condition->text,
                ];
            } else {
                return [
                    'city' => $this->city,
                    'temperature' => null,
                    'text' => 'Error in fetching weather data',
                ];
            }

        } catch (\Exception $e) {
            ray($e)->red();
        }

    }


}
