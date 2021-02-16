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

    <a href="{{ url('/posts') }}" name="take_me_back">
        <button
            class=" py-2 px-4 bg-blue-500 hover:bg-blue-700 ml-4 mt-12 shadow-2xl rounded-full text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="25">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
    </a>
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-blue-700 uppercase text-sm font-semibold tracking-widest text-2xl"> creating post </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="/posts">
                        @csrf

                        <div class="mt-4">
{{--                            <x-label for="title" :value="__('Title')" />--}}
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" placeholder="post title"/>
                            @if ($errors->has('title'))
                                <?php

                                echo "<script>alert('All fields are required!')</script>";

                                ?>
                            @endif
                        </div>

                        <div class="mt-4">
{{--                            <x-label for="content" :value="__('content')" />--}}
                            <textarea id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')" placeholder="content"/></textarea>
                            @if ($errors->has('content'))
                                <?php

                                echo "<script>alert('All fields are required!')</script>";

                                ?>
                            @endif
                        </div>

                        <div class="mt-4 flex flex-row">
                            <x-label for="isPublic" :value="__('Public')" />
                            <x-input class="ml-2" id="isPublic" type="checkbox" name="isPublic" checked value="{{old('isPublic')}}" onclick="show_non_public_form()"/>
                        </div>
                        <div class="mt-4">
{{--                            <x-label for="users" :value="__('users')" />--}}
                            <textarea id="users" class="block mt-1 w-full" style="display: none" type="text" name="users" :value="old('users')" placeholder="input user emails separated by colon"/></textarea>
                        </div>
                        </br></br>
                        <button class="bg-blue-500  font-bold py-2 px-4 rounded-full">
                            <input class="text-white bg-blue-500 font-semibold text-xs uppercase tracking-widest" type = "submit" name = "Create" value="Create">
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

<script>
    function show_non_public_form() {
        var x = document.getElementById('users');
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
