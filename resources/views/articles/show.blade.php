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

    <img class="w-1/3 mb-6" src="{{$article->getImageUrl('website')}}" alt="article main image">

    {!! $article->content !!}

    <livewire:comment-section :article="$article" />

</x-site-layout>
