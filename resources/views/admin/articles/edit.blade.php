<x-app-layout title="Edit {{$article->title}}">

    <form action="/admin/articles/{{$article->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-form-text name="title" label="Title" placeholder="Short but catchy phrase" value="{{$article->title}}" />

        <x-form-textarea name="content" label="Content" placeholder="" rows="10" value="{{$article->content}}" />

        <input type="file" name="photo" />
        @error('photo')
        <div class="text-red-500">{{$message}}</div>
        @enderror

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Update</button>
        </div>
    </form>

</x-app-layout>
