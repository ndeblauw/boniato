<x-app-layout title="Edit {{$category->title}}">

    <form action="/admin/categories/{{$category->id}}" method="POST">
        @csrf
        @method('PUT')

        <x-form-text name="name" label="Category" placeholder="Add a category name" value="{{$category->name}}" />

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Update</button>
        </div>
    </form>

</x-app-layout>
