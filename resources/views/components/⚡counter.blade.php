<?php

use Livewire\Component;

new class extends Component
{
    public int $counter;
};
?>

<div class="p-4 bg-red-100 text-red-800 rounded-lg text-center">
    <button wire:click="$set('counter', {{$counter-1}})" class="p-2 bg-red-200">-</button>
    <span>{{$counter}}</span>
    <button wire:click="$set('counter', {{$counter+1}})" class="p-2 bg-red-200">+</button>
</div>
