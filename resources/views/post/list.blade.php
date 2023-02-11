

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>

        <div class="pt-2">
            <a class="active" href="#myPosts">My Posts</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                @foreach ($posts as $post)
                    <div class="flex">
                        <p class="pr-4"> Title => {{ $post->title }}</p>
                        <form action="{{ route('post.edit', $post->id) }}" method="GET">
                            <input type="submit" value="✏️">
                        </form>
                    </div>
                @endforeach


            </div>
        </div>
    </div>



</x-app-layout>



