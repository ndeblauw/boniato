<div class="mx-auto w-4/5 mt-8">
    <div class="border-2 border-pink-500 text-pink-500 p-6 rounded-lg">

        <form action="{{route('subscriptions.store')}}" method="post" class="flex justify-between items-center">
            @csrf
            <x-form-text name="email" label="Email" />
            <button type="submit" class="bg-pink-500 text-white px-4 py-3 rounded font-medium">Subscribe</button>
        </form>

    </div>
</div>
