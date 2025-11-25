<x-site-layout title="Categories">
    <ul>
        @foreach($categories as $category)
            <li class="flex gap-x-4">
                <a href="{{route('categories.show', $category)}}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>

</x-site-layout>

