<x-site-layout title="Authors">

    <p class="mb-6 bg-white p-4">Meet our top writers</p>

    <ul class="grid grid-cols-2 gap-0">
        @foreach($authors as $author)
            <a href="{{ route('authors.show', $author) }}">
            <li class="flex justify-between items-center bg-purple-600 text-white hover:bg-purple-700 p-6 transition-colors">
                <img src="{{ $author->getImageUrl('profile') }}" alt="{{ $author->name }}" class="w-20 h-20 object-cover">
                <span class="font-semibold text-lg">
                    {{ $author->name }}
                </span>
                <span class="text-sm">
                    {{ $author->articles_count }} articles
                </span>
            </li>
            </a>
        @endforeach
    </ul>

</x-site-layout>
