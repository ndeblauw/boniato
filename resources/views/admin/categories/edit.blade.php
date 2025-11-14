<x-site-layout title="Edit {{$category->title}}">

    <form action="/categories/{{$category->id}}" method="POST">
        @csrf
        @method('PUT')

        <label>Category:</label>
        <input
            type="text"
            name="name"
            placeholder="Add a category name"
            value="{{old('name',$category->name)}}"
            class="border @error('name') border-red-500 @else border-black @enderror"
        >
        @error('name')
            <div class="text-red-500">{{$message}}</div>
        @enderror

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Update</button>
        </div>
    </form>

</x-site-layout>
