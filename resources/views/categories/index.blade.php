<x-site-layout title="Categories">
    <ul>
        @foreach($categories as $category)
            <li><a href="/categories/{{$category->id}}">{{ $category->name }}</a></li>
        @endforeach
    </ul>

</x-site-layout>

