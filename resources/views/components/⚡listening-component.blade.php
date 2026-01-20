<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public string $message = "Waiting for the slow loading component to load...";

    #[On('slow-loader-loaded')]
    public function updateSlowGuyLoaded()
    {
        $this->message = "The slow loading component has loaded!";
    }
};
?>

<div class="bg-blue-100 p-4 text-blue-800 rounded">
    {{ $message }}
</div>
