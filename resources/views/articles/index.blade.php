<x-site-layout title="Articles overview">


    @foreach($articles as $article)
        <div class="mb-2 border-t border-gray-500">
            <h2 class="font-bold text-xl">{{$article->title}}</h2>
            <p>
                {{$article->content}}
            </p>
        </div>
    @endforeach

</x-site-layout>
