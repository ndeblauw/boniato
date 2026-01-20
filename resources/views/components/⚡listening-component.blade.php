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

<div class="bg-purple-600 text-white p-4">
    {{ $message }}
</div>
