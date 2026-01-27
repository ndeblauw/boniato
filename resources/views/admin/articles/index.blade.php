<x-app-layout title="Articles">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My articles
            </h2>
            <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors">
                Create New Article
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($articles->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <p class="mb-4">You don't have any articles yet.</p>
                            <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-block transition-colors">
                                Create Your First Article
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($articles as $article)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{route('admin.articles.show', $article)}}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                    {{ $article->title }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($article->is_published)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex gap-x-3 justify-end items-center">
                                                    @if(!$article->is_published)
                                                        <a class="text-green-600 hover:text-green-800" href="{{route('admin.articles.publish', $article)}}">Publish</a>
                                                    @else
                                                        <a class="text-gray-500 hover:text-gray-700" href="{{route('admin.articles.publish', $article)}}">Unpublish</a>
                                                    @endif

                                                    <a href="/admin/articles/{{$article->id}}/edit" class="text-blue-600 hover:text-blue-800">Edit</a>

                                                    <form action="/admin/articles/{{$article->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-red-600 hover:text-red-800">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

