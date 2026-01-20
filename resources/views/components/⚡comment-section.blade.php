<?php

use App\Models\Article;
use App\Models\Comment;
use Livewire\Component;

new class extends Component {
    public Article $article;
    public bool $showForm = false;
    public string $content = '';

    public function showCommentForm()
    {
        $this->showForm = true;
    }

    public function addComment()
    {
        $this->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'article_id' => $this->article->id,
            'content' => $this->content,
        ]);

        $this->content = '';
        $this->showForm = false;
    }
};
?>

<div class="bg-white p-6 mt-4">
    <h2 class="font-bold mb-4 text-lg bg-black text-white p-3">Comments</h2>
    @if($article->comments->isNotEmpty())
        <ul class="flex flex-col gap-0">
            @foreach($article->comments as $comment)
                <li class="p-4 bg-purple-600 text-white mb-0">
                    <div class="text-xs mb-2">{{$comment->created_at}}</div>
                    {{$comment->content}}

                    @if($comment->children->isNotEmpty())
                        <ul class="flex flex-col gap-0 mt-4 ml-4">
                            @foreach($comment->children as $comment)
                                <li class="p-4 bg-purple-700 text-white mb-0">
                                    <div class="text-xs mb-2">{{$comment->created_at}}</div>
                                    {{$comment->content}}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </li>
            @endforeach
        </ul>
    @else
        <p class="p-4">No comments yet</p>
    @endif

    @if($showForm)
        <form wire:submit="addComment()" class="bg-black text-white p-6 mt-4">
            <input type="hidden" name="article_id" value="{{$article->id}}">

            <textarea
                wire:model="content"
                placeholder="Let us know what YOU think.."
                class="w-full p-3 bg-white text-black" rows="4">
            </textarea>

            <button type="submit" class="p-3 px-6 bg-purple-600 text-white hover:bg-purple-700 mt-4">Post comment</button>
        </form>
    @else
        <button wire:click="showCommentForm()" class="mt-4 p-3 px-6 bg-purple-600 text-white hover:bg-purple-700">Add a comment</button>
    @endif
</div>

