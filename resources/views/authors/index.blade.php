<x-site-layout title="Authors">

    <p class="mb-6">Meet our top writers</p>

    <ul class="grid grid-cols-2 gap-8">
        @foreach($authors as $author)
            <a href="{{ route('authors.show', $author) }}">
            <li class="flex justify-between items-center bg-[#26054D]/10 hover:bg-[#26054D]/15   rounded-xl p-4">
                <span class="font-semibold">
                    {{ $author->name }}
                </span>
                <span class="text-sm text-gray-600">
                    {{ $author->articles_count }} articles
                </span>
            </li>
            </a>
        @endforeach
    </ul>

</x-site-layout>
