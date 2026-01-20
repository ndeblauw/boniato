<x-site-layout title="{{$category->name}}">

    <ul class="flex flex-col gap-0">
    @foreach($category->articles as $article)
        <li class="bg-white hover:bg-black hover:text-white transition-colors">
            <a href="/articles/{{$article->id}}" class="block p-6 text-lg font-semibold">{{ $article->title }}</a>
        </li>
    @endforeach
    </ul>

</x-site-layout>
