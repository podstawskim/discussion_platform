<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Creating a post
        </h2>
    </x-slot>
    <a href="{{ url('/') }}">
        <button
            class=" py-2 px-4 bg-blue-500 hover:bg-blue-700 ml-12 mt-12 shadow-2xl rounded-full text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" height="25" width="25">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </button>
    </a>

    <a href="{{ route('posts.show', $post) }}">
        <button
            class=" py-2 px-4 bg-blue-500 hover:bg-blue-700 ml-4 mt-12 shadow-2xl rounded-full text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="25">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
    </a>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="post" action="{{ route('posts.update', $post) }}">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <x-label for="title" :value="__('Title')" />
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$post->title"/>
                            @if ($errors->has('title'))
                                <?php

                                echo "<script>alert('All fields are required!')</script>";

                                ?>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="content" :value="__('content')" />
                            <textarea id="content" class="block mt-1 w-full" type="text" name="content"/><?php echo $post['content'] ?></textarea>
                            @if ($errors->has('content'))
                                <?php

                                echo "<script>alert('All fields are required!')</script>";

                                ?>
                            @endif
                        </div>

{{--                        <div class="mt-4">--}}
{{--                            <x-label for="isPublic" :value="__('isPublic')" />--}}
{{--                            <input class=""type="checkbox" name="isPublic" checked :value="$post->isPublic">--}}
{{--                            @if ($errors->has('isPublic'))--}}
{{--                                <li style="color:red;">{{$errors->first('isPublic')}}</li>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                        </br></br>
                        <button class="bg-blue-500  font-bold py-2 px-4 rounded-full">
                            <input class="text-white bg-blue-500 font-semibold text-xs uppercase tracking-widest" type = "submit" name = "Update" value="Update">
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
