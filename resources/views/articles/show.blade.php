<x-site-layout title="{{$article->title}}">

    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-x-6 mb-4 -mt-2">
            <div class="">
                @foreach($article->categories as $category)
                    <a href="/categories/{{$category->id}}" class="bg-purple-600 text-white px-2">{{$category->name}}</a>
                @endforeach
            </div>
            |
            <div class="text-gray-700">written by <span class="font-semibold">{{$article->author->name}}</span></div>
        </div>
        <div>
            @if($article->canBeManagedBy(auth()->user()))
                <a href="/admin/articles/{{$article->id}}/edit" class="bg-white p-1 border-2 border-black">EDIT</a>
            @endif
        </div>
    </div>

    <img class="w-1/3" src="{{$article->getImageUrl('website')}}" alt="article main image">

    {!! $article->content !!}

    <livewire:comment-section :article="$article" />

</x-site-layout>
