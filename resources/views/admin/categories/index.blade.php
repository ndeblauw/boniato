<x-site-layout title="Categories">
    <ul>
        @foreach($categories as $category)
            <li class="flex gap-x-4">
                <a href="/admin/categories/{{$category->id}}">{{ $category->name }}</a>
                <a href="/admin/categories/{{$category->id}}/edit">EDIT</a>

                <form action="admin/categories/{{$category->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button>DELETE</button>
                </form>
            </li>
        @endforeach
    </ul>

</x-site-layout>

