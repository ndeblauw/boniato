<x-app-layout title="Create article">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Article
            </h2>
            <a href="{{ route('admin.articles.index') }}" class="text-gray-600 hover:text-gray-800">
                Back to Articles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.articles.store') }}" method="POST">
                        @csrf

                        <x-form-text name="title" label="Title" placeholder="Short but catchy phrase" />

                        <x-form-text name="slug" label="Slug" placeholder="leave empty if you want autogeneration" />

                        <x-form-textarea name="content" label="Content" placeholder="" rows="10" />

                        <x-form-checkboxes name="categories" label="Categories" :values="[]"
                            :options="App\Models\Category::orderBy('name')->pluck('name', 'id')->toArray()" />

                        <div class="mt-6 flex gap-3">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors" type="submit">Create Article</button>
                            <a href="{{ route('admin.articles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-md transition-colors inline-block">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
