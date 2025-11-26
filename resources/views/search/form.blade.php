<x-site-layout>
    <form>

        <x-form-text name="title" label="Search for articles with title" placeholder="your search keyword" :value="$title"/>

        <x-form-select name="category" label="Category" :value="$category" :options="App\Models\Category::orderBy('name')->pluck('name','id')->toArray()"/>



        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Search</button>
        </div>
    </form>

    @if(isset($articles))
        <ul class="list-disc pl-4">
            @foreach($articles as $article)
                <li>{{$article->title}}</li>
            @endforeach
        </ul>
    @else
    nothing to show
    @endif

</x-site-layout>
