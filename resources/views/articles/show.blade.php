<x-site-layout title="{{$article->title}}">

    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-x-6 mb-4 -mt-2">
            <div class="">
                @foreach($article->categories as $category)
                    <a href="/categories/{{$category->id}}" class="bg-[#FC6E7F] text-[#26054D] rounded-full px-2">{{$category->name}}</a>
                @endforeach
            </div>
            |
            <div class="text-gray-700">written by <span class="font-semibold">{{$article->author->name}}</span></div>
        </div>
        <div>
            @if($article->canBeManagedBy(auth()->user()))
                <a href="/admin/articles/{{$article->id}}/edit" class="bg-indigo-50 p-1 rounded border border-indigo-700">EDIT</a>
            @endif
        </div>
    </div>

    <img class="w-1/3" src="{{$article->getImageUrl('website')}}" alt="article main image">

    {!! $article->content !!}

    <x-article-comments :article="$article" />

</x-site-layout>
