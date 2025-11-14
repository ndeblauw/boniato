<x-site-layout title="Create a new category">

    <form action="/admin/categories" method="post">
        @csrf

        <label>Category:</label>
        <input
            type="text"
            name="name"
            placeholder="Add a category name"
            value="{{old('name')}}"
            class="border @error('name') border-red-500 @else border-black @enderror"
        >
        @error('name')
        <div class="text-red-500">{{$message}}</div>
        @enderror


        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Create</button>

        </div>
    </form>

</x-site-layout>
