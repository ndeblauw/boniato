<x-site-layout title="Articles overview">

    @auth
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors">
            Create New Article
        </a>
    </div>
    @endauth

    <div class="flex flex-col gap-0">

        {{ $articles->links() }}

        @foreach($articles as $article)
            <div class="flex bg-white p-6 hover:bg-black hover:text-white transition-colors">
                <div class="w-32 shrink-0 mr-6">
                    <img class="w-full" src="{{$article->getImageUrl('preview')}}" alt="article main image">
                </div>
                <div>
                    <div class="flex items-center gap-x-4 mb-3">
                        <div class="flex gap-2">
                            @foreach($article->categories as $category)
                                <span class="bg-purple-600 text-white px-2 py-1 text-xs">{{$category->name}}</span>
                            @endforeach
                        </div>
                        <div class="text-sm">written by <span class="font-semibold">{{$article->author->name}}</span></div>
                    </div>
                    <a href="/articles/{{$article->slug}}" class="block mb-2">
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
