<x-site-layout>

    <div class="bg-linear-to-br from-[#7B7075]/10 via-orange-300 to-[#7B7075]/10 p-2 mb-8 rounded">

        <div class="flex justify-between items-center gap-x-8">

            <img class="w-1/2" src="{{$article->getImageUrl('website')}}" alt="article main image">

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

                <h1 class="text-4xl font-bold mb-4">{{$article->title}}</h1>

                <div>
                    {{$article->content}}

                </div>

            </div>
        </div>


    </div>

    <div class="grid grid-cols-3 gap-12">
        @foreach($articles as $article)
            <div class="bg-linear-to-br from-[#7B7075]/5 via-orange-100 to-[#7B7075]/10 p-1 mb-8 rounded">
                <img class="w-full" src="{{$article->getImageUrl('website')}}" alt="article main image">

                <div class="p-4">

                    <div class="h-6">
                        @foreach($article->categories as $category)
                            <a href="/categories/{{$category->id}}" class="bg-[#FC6E7F] text-[#26054D] rounded-full px-2">{{$category->name}}</a>
                        @endforeach
                    </div>
                    <div class="text-gray-700">written by <span class="font-semibold">{{$article->author->name}}</span></div>

                    <h1 class="text-2xl font-bold mb-4 line-clamp-2">{{$article->title}}</h1>

                    <div class="line-clamp-5">
                        {{$article->content}}

                    </div>

                </div>

            </div>

            @endforeach
    </div>



</x-site-layout>
