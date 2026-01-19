<?php

namespace App\View\Components;

use App\Services\IpInfoService;
use App\Services\WeatherService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeatherInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public WeatherService $weatherService)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $ip = request()->ip();

        if($ip = '127.0.0.1') {
            $ip = '91.126.71.186';
            //$ip = '46.224.4.88';
        }

        //$country = $this->ipInfo->getCountry($ip);
        //$weather = (new WeatherService())->forCity($country)->getWeather();

        $weather = $this->weatherService->forIp($ip)->getWeather();

        $country = 'dummy';

        return view('components.weather-info', compact('ip', 'country', 'weather'));
    }
}
