<x-app-layout title="{{$category->name}}">

    <ul>
    @foreach($category->articles as $article)
        <li><a href="/articles/{{$article->id}}">{{ $article->title }}</a></li>
    @endforeach
    </ul>

</x-app-layout>
