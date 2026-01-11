<x-site-layout>

    <div class="bg-linear-to-br from-[#7B7075]/10 via-orange-300 to-[#7B7075]/10 p-2 mb-8 rounded">

        <div class="flex flex-col lg:flex-row justify-between items-center gap-x-8 gap-y-4">

            <img class="w-full lg:w-1/2 h-auto" src="{{$article->getImageUrl('website')}}" alt="article main image">

            <div class="w-full lg:w-1/2">

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-x-6 gap-y-2 mb-4 -mt-2">
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->categories as $category)
                            <a href="/categories/{{$category->id}}" class="bg-[#FC6E7F] text-[#26054D] rounded-full px-2 text-sm">{{$category->name}}</a>
                        @endforeach
                    </div>
                    <div class="text-gray-700 text-sm">written by <span class="font-semibold">{{$article->author->name}}</span></div>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4">{{$article->title}}</h1>

                <a href="/articles/{{$article->slug}}" class="line-clamp-5">
                    {{$article->content}}
                </a>

            </div>
        </div>


    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-12">
        @foreach($articles as $article)
            <div class="bg-linear-to-br from-[#7B7075]/5 via-orange-100 to-[#7B7075]/10 p-1 mb-8 rounded">

                <img class="w-full h-auto" src="{{$article->getImageUrl('website')}}" alt="article main image">

                <div class="p-4">

                    <div class="min-h-6 mb-2">
                        <div class="flex flex-wrap gap-2">
                            @foreach($article->categories as $category)
                                <a href="/categories/{{$category->id}}" class="bg-[#FC6E7F] text-[#26054D] rounded-full px-2 text-sm">{{$category->name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-gray-700 text-sm mb-2">written by <span class="font-semibold">{{$article->author->name}}</span></div>

                    <h1 class="text-xl lg:text-2xl font-bold mb-4 line-clamp-2">{{$article->title}}</h1>

                    <a href="/articles/{{$article->slug}}" class="line-clamp-5">
                        {{$article->content}}
                    </a>

                </div>

            </div>

            @endforeach
    </div>



</x-site-layout>
