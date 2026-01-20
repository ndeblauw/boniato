<div class="bg-yellow-200 p-4 rounded">
    Your IP address is {{$ip}}, you are in {{$weather['city']}}<br/>
    <br/>
    @if($weather['temperature'])
        The temperature is {{$weather['temperature']}} °C, it is {{$weather['text']}}
    @else
        <span class="text-red-500">{{$weather['text']}}</span>
    @endif
</div>
