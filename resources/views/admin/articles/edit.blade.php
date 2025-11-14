<x-site-layout title="Edit {{$article->title}}">

    <form action="/admin/articles/{{$article->id}}" method="POST">
        @csrf
        @method('PUT')

        <x-form-text name="title" label="Title" placeholder="Short but catchy phrase" value="{{$article->title}}" />

        <x-form-textarea name="content" label="Content" placeholder="" rows="10" value="{{$article->content}}" />


        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Update</button>
        </div>
    </form>

</x-site-layout>
