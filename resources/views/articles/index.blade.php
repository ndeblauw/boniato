<x-site-layout title="Articles overview">

    <div class="flex flex-col gap-6">
        @foreach($articles as $article)
            <div>
            <div class="">
                @foreach($article->categories as $category)
                    <a href="/categories/{{$category->id}}" class="bg-[#FC6E7F] text-[#26054D] rounded-full px-2">{{$category->name}}</a>
                @endforeach
            </div>
            <a href="/articles/{{$article->id}}" class="block mb-2 hover:gray-50">
                <h2 class="font-bold text-xl">{{$article->title}}</h2>

                <p>
                    {{$article->content}}
                </p>
            </a>
            </div>
        @endforeach
    </div>

</x-site-layout>
