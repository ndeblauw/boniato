<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component {
    public $articles = [];
    public string $search = '';
    public ?int $category_id = null;

    public function updatedSearch()
    {
        $this->articles = Article::where('title', 'like', '%' . $this->search . '%')
            ->when($this->category_id, function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->where('id', $this->category_id);
                });
            })
            ->orderBy('title')
            ->take(10)
            ->get();
    }

};
?>

<div class="border border-black p-4">

    <input wire:model.live="search" type="text" placeholder="Search articles..." class="border p-2 w-full"/>

    <select wire:model.live="category_id" label="Category">
        <option value="">-- All Categories --</option>
        @foreach(App\Models\Category::orderBy('name')->pluck('name','id') as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>


    <div class="text-sky-600">
        {{$search}}
    </div>


    @foreach($articles as $article)
        <div class="mt-2">
            {{ $article->title }}
        </div>
    @endforeach

</div>
