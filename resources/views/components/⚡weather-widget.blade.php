<?php

use App\Services\WeatherService;
use Livewire\Attributes\Defer;
use Livewire\Component;

new #[Defer] class extends Component {
    public array $weather = [];
    public string $ip = '';

    private WeatherService $weatherService;

    public function mount(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;

        $this->ip = request()->ip();

        if ($this->ip = '127.0.0.1') {
            $this->ip = '91.126.71.186';
            // $this->ip = '46.224.4.88';
        }

        $this->weather = $this->weatherService->forIp($this->ip)->getWeather();
    }

    //
};
?>

<div class="bg-yellow-100 p-6 rounded">
    Your IP address is {{$ip}}, you are in {{$weather['city']}}<br/>
    <br/>
    @if($weather['temperature'])
        The temperature is {{$weather['temperature']}} °C, it is {{$weather['text']}}
    @else
        <span class="text-red-500">{{$weather['text']}}</span>
    @endif
</div>
