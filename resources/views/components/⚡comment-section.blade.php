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

<div class="border-l-4 border-[#26054D]/25 p-4 bg-black/20 mt-4">
    <h2 class="font-bold mb-2 text-lg text-[#26054D]">Comments</h2>
    @if($article->comments->isNotEmpty())
        <ul class="flex flex-col gap-4 ml-2">
            @foreach($article->comments as $comment)
                <li class="">
                    <div class="text-xs text-[#26054D]">{{$comment->created_at}}</div>
                    {{$comment->content}}

                    @if($comment->children->isNotEmpty())
                        <ul class="flex flex-col gap-4 mt-2 pl-2 border-l border-[#26054D]/25">
                            @foreach($comment->children as $comment)
                                <li class="">
                                    <div class="text-xs text-[#26054D]">{{$comment->created_at}}</div>
                                    {{$comment->content}}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </li>
            @endforeach
        </ul>
    @else
        No comments yet
    @endif

    @if($showForm)
        <form wire:submit="addComment()" class="ml-2 border-2 border-[#26054D] p-4 mt-4">
            <input type="hidden" name="article_id" value="{{$article->id}}">

            <textarea
                wire:model="content"
                placeholder="Let us know what YOU think.."
                class="w-full p-2 border border-gray-300 rounded" rows="4">
            </textarea>

            <button type="submit" class="p-2 bg-teal-700 text-teal-50">Post comment</button>
        </form>
    @else
        <button wire:click="showCommentForm()" class="mt-4 p-2 bg-teal-700 text-teal-50">Add a comment</button>
    @endif
</div>

