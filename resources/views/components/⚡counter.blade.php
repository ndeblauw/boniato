<?php

use Livewire\Component;

new class extends Component
{
    public int $counter;
};
?>

<div class="p-4 bg-black text-white text-center">
    <button wire:click="$set('counter', {{$counter-1}})" class="p-2 px-4 bg-purple-600 hover:bg-purple-700">-</button>
    <span class="mx-4 font-bold">{{$counter}}</span>
    <button wire:click="$set('counter', {{$counter+1}})" class="p-2 px-4 bg-purple-600 hover:bg-purple-700">+</button>
</div>
