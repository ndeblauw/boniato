<x-app-layout title="ADMIN FOR {{$article->title}}">


    <div>written by {{$article->author->name}}</div>

    <div class="mb-4">
        @foreach($article->categories as $category)
            <span class="bg-yellow-400 rounded-full px-2">{{$category->name}}</span>
        @endforeach
    </div>

    {{$article->content}}



</x-app-layout>
