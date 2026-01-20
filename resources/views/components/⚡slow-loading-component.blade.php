<?php

use Livewire\Attributes\Defer;
use Livewire\Component;

new #[Defer]
class extends Component {
    public function mount()
    {
        sleep(5); // Simulate a slow loading component
        $this->dispatch('slow-loader-loaded');
    }
};
?>

<div class="bg-black p-4 text-white">
    This is a slow loading component.
</div>
