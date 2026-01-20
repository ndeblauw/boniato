<x-site-layout title="Categories">
    <ul class="flex flex-col gap-0">
        @foreach($categories as $category)
            <li class="bg-white hover:bg-purple-600 hover:text-white transition-colors">
                <a href="{{route('categories.show', $category)}}" class="block p-6 text-xl font-semibold">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>

</x-site-layout>

