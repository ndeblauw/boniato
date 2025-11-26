<x-site-layout title="Articles overview">

    <div class="flex flex-col gap-6">

        {{ $articles->links() }}

        @foreach($articles as $article)
            <div class="flex">
                <div class="w-32 shrink-0 mr-4">
                    <img class="w-full" src="{{$article->getImageUrl('preview')}}" alt="article main image">
                </div>
                <div>
                    <div class="flex items-center gap-x-6 mb-4 -mt-2">
                        <div class="">
                            @foreach($article->categories as $category)
                                <a href="/categories/{{$category->id}}" class="bg-[#FC6E7F] text-[#26054D] rounded-full px-2">{{$category->name}}</a>
                            @endforeach
                        </div>
                        |
                        <div class="text-gray-700">written by <span class="font-semibold">{{$article->author->name}}</span></div>
                    </div>
                    <a href="/articles/{{$article->slug}}" class="block mb-2 hover:gray-50">
                        <h2 class="font-bold text-xl">{{$article->title}}</h2>

                        <p>
                            {{$article->content}}
                        </p>
                    </a>

                </div>
            </div>
        @endforeach
    </div>

</x-site-layout>
