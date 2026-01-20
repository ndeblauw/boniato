<?php

use Livewire\Component;

new class extends Component
{
    public int $counter;
};
?>

<div class="p-4 bg-white border-2 border-black text-black text-center">
    <button wire:click="$set('counter', {{$counter-1}})" class="p-2 bg-black text-white">-</button>
    <span>{{$counter}}</span>
    <button wire:click="$set('counter', {{$counter+1}})" class="p-2 bg-black text-white">+</button>
</div>
