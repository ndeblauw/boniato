<x-site-layout title="Create a new category">

    <form action="/categories" method="post">
        @csrf

        <label>Category:</label>
        <input
            type="text"
            name="name"
            placeholder="Add a category name"
            class="border border-black"
        >

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Create</button>

        </div>
    </form>

</x-site-layout>
