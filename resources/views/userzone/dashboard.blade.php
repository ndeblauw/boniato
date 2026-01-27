<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __("Welcome back!") }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <a href="{{ route('admin.articles.index') }}" class="block p-6 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <h4 class="font-semibold text-lg mb-2">My Articles</h4>
                            <p class="text-gray-600 text-sm">View and manage your fantastic articles</p>
                        </a>

                        <a href="{{ route('admin.articles.create') }}" class="block p-6 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                            <h4 class="font-semibold text-lg mb-2">Create New Article</h4>
                            <p class="text-gray-600 text-sm">Write a new article</p>
                        </a>

                        @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.categories.index') }}" class="block p-6 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                            <h4 class="font-semibold text-lg mb-2">Manage Categories</h4>
                            <p class="text-gray-600 text-sm">Add, edit, or delete categories</p>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <livewire:api-key-generator />
            </div>
        </div>
    </div>

</x-app-layout>
