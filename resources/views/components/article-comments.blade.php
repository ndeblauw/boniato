<div class="border-l-4 border-[#26054D]/25 p-4 bg-indigo-50 mt-4">
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

    <form action="/articles/add-comment" method="post" class="ml-2 border-2 border-[#26054D] p-4 mt-4">

        @csrf
        <input type="hidden" name="article_id" value="{{$article->id}}">
        <x-form-text-area name="content" label="What about your opinion?" placeholder="Let us know what YOU think.." />

        <button type="submit" class="p-2 bg-teal-700 text-teal-50">Post comment</button>

    </form>
</div>
