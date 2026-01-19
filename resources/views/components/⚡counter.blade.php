<?php

use Livewire\Component;

new class extends Component
{
    public int $counter;

    public function increment()
    {
        $this->counter++;
    }

    public function decrement()
    {
        $this->counter--;
    }

};
?>

<div class="p-4 bg-red-100 text-red-800 rounded-lg text-center">
    <button wire:click="decrement()" class="p-2 bg-red-200">-</button>
    <span>{{$counter}}</span>
    <button wire:click="increment()" class="p-2 bg-red-200">+</button>
</div>
