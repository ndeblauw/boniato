<x-site-layout title="{{$article->title}}">

    <div class="flex justify-between items-center mb-6 bg-white p-4">
        <div class="flex items-center gap-x-4">
            <div class="flex gap-2">
                @foreach($article->categories as $category)
                    <a href="/categories/{{$category->id}}" class="bg-purple-600 text-white px-3 py-1">{{$category->name}}</a>
                @endforeach
            </div>
            <div class="text-sm">written by <span class="font-semibold">{{$article->author->name}}</span></div>
        </div>
        <div>
            @if($article->canBeManagedBy(auth()->user()))
                <a href="/admin/articles/{{$article->id}}/edit" class="bg-black text-white p-2 px-4">EDIT</a>
            @endif
        </div>
    </div>

    <div class="mb-6 flex gap-6">
        <img class="w-1/3 mb-6" src="{{$article->getImageUrl('website')}}" alt="article main image">

        <div>
            <div class="bg-pink-500 text-pink-50">
                <form action="{{route('articles.sponsor', ['article' => $article])}}" class="inline">

                    <input type="text" name="amount" value="5" class="w-16 rounded p-1 text-black" placeholder="Amount (euro)">

                    <button type="submit" class="bg-pink-700 px-3 py-1 rounded">Sponsor</button>

                </form>
            </div>

            @if(request()->has('sponsored') && request()->sponsored == 'true')
                <div class="mt-4 p-4 bg-yellow-100 border border-yellow-300">
                    Thank you for sponsoring this article! Your support helps us create more great content.
                </div>
            @endif
        </div>

    </div>

    {!! $article->content !!}

    <livewire:comment-section :article="$article" />

</x-site-layout>
