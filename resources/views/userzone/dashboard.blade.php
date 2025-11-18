<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    {{ __("You're logged in!") }}
                <a href="/admin/articles">go to your articles</a>
</x-app-layout>
