<x-app-layout title="Edit {{$article->title}}">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Article
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
                    <form action="/admin/articles/{{$article->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-form-text name="title" label="Title" placeholder="Short but catchy phrase" value="{{$article->title}}" />

                        <x-form-text name="slug" label="Slug" placeholder="leave empty if you want autogeneration" value="{{$article->slug}}" />

                        <x-form-textarea name="content" label="Content" placeholder="" rows="10" value="{{$article->content}}" rte />

                        <x-form-select name="author_id" label="Author" :options="App\Models\User::orderBy('name')->pluck('name','id')->toArray()" :selected="$article->author_id" />

                        <x-form-checkboxes name="categories" label="Categories" :values="$article->categories->pluck('id')->toArray()" :options="App\Models\Category::orderBy('name')->pluck('name','id')->toArray()"/>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Article Image</label>
                            <input type="file" name="photo" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                            " />
                            @error('photo')
                            <div class="text-red-500 text-sm mt-1">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors" type="submit">Update Article</button>
                            <a href="{{ route('admin.articles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-md transition-colors inline-block">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
