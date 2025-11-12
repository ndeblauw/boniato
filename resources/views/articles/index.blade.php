<x-site-layout title="Articles overview">


    @foreach($articles as $article)
        <a href="/articles/{{$article->id}}" class="mb-2 border-t border-gray-500">
            <h2 class="font-bold text-xl">{{$article->title}}</h2>
            <p>
                {{$article->content}}
            </p>
        </a>
    @endforeach

</x-site-layout>
