<x-site-layout title="Articles">
    <ul>
        @foreach($articles as $article)
            <li class="flex justify-between hover:bg-gray-200">
                <a href="/admin/articles/{{$article->id}}">{{ $article->title }}</a>

                <div class="flex gap-x-4">
                    <a href="/admin/articles/{{$article->id}}/edit">EDIT</a>

                    <form action="/admin/articles/{{$article->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>DELETE</button>
                    </form>

                </div>
            </li>
        @endforeach
    </ul>

</x-site-layout>

