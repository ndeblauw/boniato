<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component {
    public $articles = [];
    public string $search = '';

    public function updatedSearch()
    {
        $this->articles = Article::where('title', 'like', '%' . $this->search . '%')
            ->orderBy('title')
            ->take(10)
            ->get();
    }

};
?>

<div class="border border-black p-4">

    <input wire:model.live="search" type="text" placeholder="Search articles..." class="border p-2 w-full"/>

    <div class="text-sky-600">
        {{$search}}

    </div>

    @foreach($articles as $article)
        <div class="mt-2">
            {{ $article->title }}
        </div>
    @endforeach

</div>
