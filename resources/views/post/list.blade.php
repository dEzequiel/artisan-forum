

<x-app-layout>
    {{ $posts }}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>

        <div class="pt-2">
            <a class="active mr-4" href="#home">All</a>
            <a class="active" href="#myPosts">My Posts</a>

        </div>

    </x-slot>
</x-app-layout>



