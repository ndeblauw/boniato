<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public string $endpoint;
    public string $lang;
    public string $key;
    public ?string $city = null;

    public function __construct(public IpServiceInterface $ipInfo)
    {
        $this->endpoint = 'https://api.weatherapi.com/v1/current.json';
        $this->lang = 'English';
        $this->key = config('services.weather_api.key');
    }

    public function forIp(string $ip): self
    {
        $this->city = $this->ipInfo->getCountry($ip);

        return $this;
    }

    public function forCity(?string $city = null): self
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

            if ($response->successful()) {
                $weather = json_decode($response->body());

                return [
                    'temperature' => $weather->current->temp_c ?? null,
                    'text' => $weather->current->condition->text ?? null,
                ];
            }

            return [
                'temperature' => null,
                'text' => 'Error in fetching weather data',
            ];
        } catch (\Exception $e) {
            // Log the exception if Ray or logger is not available in production.
            if (function_exists('ray')) {
                ray($e)->red();
            } else {
                logger()->error('WeatherService:getWeather exception', ['exception' => $e]);
            }

            return [
                'temperature' => null,
                'text' => 'Error fetching weather data',
            ];
        }
    }
}
