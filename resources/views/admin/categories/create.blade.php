<x-app-layout title="Create a new category">

    <form action="/admin/categories" method="post">
        @csrf

        <x-form-text name="name" label="Category" placeholder="Add a category name" />



        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Create</button>

        </div>
    </form>

</x-app-layout>
