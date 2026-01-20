<x-site-layout>

    <livewire:slow-loading-component />

    <livewire:listening-component />


    @if($article)
    <div class="bg-white border-4 border-black p-2 mb-8">

        <div class="flex flex-col lg:flex-row justify-between items-center gap-x-8 lg:gap-8">

            <img class="w-full lg:w-1/2" src="{{$article->getImageUrl('website')}}" alt="article main image">

            <div>

                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mb-4 -mt-2">
                    <div class="">
                        @foreach($article->categories as $category)
                            <a href="/categories/{{$category->id}}" class="bg-purple-600 text-white px-2">{{$category->name}}</a>
                        @endforeach
                    </div>
                    |
                    <div class="text-gray-700">written by <span class="font-semibold">{{$article->author->name}}</span></div>
                </div>

                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4">{{$article->title}}</h1>

                <a href="/articles/{{$article->slug}}" class="line-clamp-5">
                    {{$article->content}}
                </a>

            </div>
        </div>


    </div>
    @endif

    <div>
        <livewire:counter counter="5" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-12">
        @foreach($articles as $article)
            <div class="bg-white border-2 border-black p-1 mb-8 h-full flex flex-col">

                <img class="w-full" src="{{$article->getImageUrl('website')}}" alt="article main image">

                <div class="p-4 flex-1 flex flex-col">

                    <div class="h-6">
                        @foreach($article->categories as $category)
                            <a href="/categories/{{$category->id}}" class="bg-purple-600 text-white px-2">{{$category->name}}</a>
                        @endforeach
                    </div>
                    <div class="text-gray-700">written by <span class="font-semibold">{{$article->author->name}}</span></div>

                    <h1 class="text-xl md:text-2xl font-bold mb-4 line-clamp-2">{{$article->title}}</h1>

                    <a href="/articles/{{$article->slug}}" class="line-clamp-5 flex-1">
                        {{$article->content}}
                    </a>

                </div>

            </div>

            @endforeach
    </div>



</x-site-layout>
