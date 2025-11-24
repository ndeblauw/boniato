<x-site-layout title="{{ $author->name }}">

    <p class="text-gray-600 mb-6">Want to contact {{$author->name}}? Use {{ $author->email }}</p>

    <h2 class="text-xl font-semibold mb-4">Articles</h2>

    @forelse($author->articles as $article)
        <div class="flex mb-6">
            <div class="w-32 shrink-0 mr-4">
                <img class="w-full" src="{{ $article->getImageUrl('preview') }}" alt="article main image">
            </div>
            <div>
                <div class="flex items-center gap-x-4 mb-2">
                    <div>
                        @foreach($article->categories as $category)
                            <a href="/categories/{{ $category->id }}"
                               class="bg-[#FC6E7F] text-[#26054D] rounded-full px-2">
                                {{ $category->name }}
                            </a>
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
        <p>No published articles yet.</p>
    @endforelse

</x-site-layout>
