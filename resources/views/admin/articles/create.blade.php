<x-site-layout title="Create article">

    <form action="/admin/articles" method="POST">
        @csrf

        <x-form-text name="title" label="Title" placeholder="Short but catchy phrase" />

        <x-form-textarea name="content" label="Content" placeholder="" rows="10" />

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Create</button>
        </div>
    </form>

</x-site-layout>
