

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>

        <div class="pt-2">
            <a class="active mr-4" href="#home">All</a>
            <a class="active" href="#myPosts">My Posts</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                @foreach ($posts as $post)
                    <div class="flex">
                        <p class="pr-4"> {{ $post->title }}</p>
                        <p class="pr-4"> {{ $post->id }}</p>
                        <form action="{{ route('post.edit', $post->id) }}" method="GET">
                                <input type="submit" value="Edit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800
                                    focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
                                    mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600
                                    dark:focus:ring-blue-800">
                        </form>
                    </div>
                @endforeach


            </div>
        </div>
    </div>



</x-app-layout>



