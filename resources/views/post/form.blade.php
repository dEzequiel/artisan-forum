

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>

        <div class="pt-2">
            <a class="active mr-4" href="#home">All</a>
            <a class="active" href="{{route('post.list')}}">My Posts</a>

        </div>


    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <form action="{{ route('post.store')  }}" method="POST">
                    @csrf
                    <!-- TITLE -->
                        <label for="title" class="">Title</label><br>
                        <input class="w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                               type="text" id="title" name="title" value="{{ old('title')  }}" ><br> <!-- required -->

                    @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <br>

                    <!-- EXTRACT -->
                    <label for="extract">Short Description</label><br>
                    <input class="w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50" type="text"
                           id="extract" name="extract" value="{{ old('extract')  }}"><br>

                    @error('extract')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <br>

                    <!-- CONTENT -->
                    <label for="content">Content</label><br>
                    <textarea id="body" name="body" rows="10" class="w-full p-2 w-full rounded-lg border-gray-300"
                              placeholder="Write your thoughts here..."></textarea>                    @error('body')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <br>

                    <!-- CHECKBOX -->
                    <div class="pr-3">
                        <input id="expirable" type="checkbox" name="expirable" value="1"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        Caducable

                        <input id="commentable" type="checkbox" name="commentable" value="1"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        Comentable
                    </div>

                    <!-- SELECT -->
                    <select class="border border-gray-300 rounded-lg bg-gray-50" id="visibility" name="visibility">
                        <option value="0">Privado</option>
                        <option value="1">Publico</option>
                    </select>

                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

{{--

--}}
</x-app-layout>



