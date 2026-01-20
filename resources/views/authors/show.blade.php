<x-site-layout title="{{ $author->name }}">

    <p class="mb-6 bg-white p-4">Want to contact {{$author->name}}? Use {{ $author->email }}</p>

    <h2 class="text-xl font-semibold mb-4 bg-black text-white p-4">Articles</h2>

    @forelse($author->articles as $article)
        <div class="flex mb-0 bg-white p-6 hover:bg-purple-600 hover:text-white transition-colors">
            <div class="w-32 shrink-0 mr-6">
                <img class="w-full" src="{{ $article->getImageUrl('preview') }}" alt="article main image">
            </div>
            <div>
                <div class="flex items-center gap-x-4 mb-2">
                    <div class="flex gap-2">
                        @foreach($article->categories as $category)
                            <span class="bg-black text-white px-2 py-1 text-xs">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('articles.show', $article->id) }}" class="block mb-1">
                    <h3 class="font-bold text-lg">
                        {{ $article->title }}
                    </h3>
                </a>

                <p>{{ Str::limit($article->content, 200) }}</p>
            </div>
        </div>
    @empty
        <p class="bg-white p-6">No published articles yet.</p>
    @endforelse

</x-site-layout>
