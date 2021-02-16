
<x-guest-layout>
    <a href="{{ url('/') }}">
        <button class = " py-2 px-4 bg-blue-500 hover:bg-blue-700 ml-12 mt-12 shadow-2xl rounded-full text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" height="25" width="25">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>

        </button>
    </a>

    <a href="{{ url('/posts') }}" name="take_me_back" >
        <button name="take_me_back"
            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 ml-4 mt-12 shadow-2xl rounded-full text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="25">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
    </a>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$post->title}}

        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-2xl sm:rounded-lg ">
                <div class="p-6 border-b border-gray-200 ">
                    <div class="block mt-1 w-full text-blue-700 text-2xl" disabled>{{$post->title}}</div>
                    <textarea class="block mt-1 w-full" disabled>{{$post->content}}</textarea>
                </div>
                <div class="p-6 bg-white border-b">
                    <small><div class="flex flex-row">Created
                            {{$post->created_at}}
                            by <div class="text-blue-700 px-1">{{$post->user->name}}</div></div>
                        </small>
                </div>

                <div class="p-4 bg-white flex flex-row">
                    Public:
                    @if ($post->isPublic)
                        <p class="text-blue-700 px-2">yes</p>
                    @else
                        <p class="text-red-900 px-2">no</p>
                    @endif
                </div>
                @if(isset($current_user) && Auth::user()->id == $post->user->id)
                    <div class="pl-4 bg-white flex flex-row" >
                        <a href="{{URL::to('posts/'. $post->id . '/edit')}}">
                            <x-button class="" id="post_{{$post->id}}_edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </x-button>
                        </a>


                        <form method="POST" action="/posts/{{$post->id}}">
                            @method('DELETE')
                            @csrf
                            <x-button class="ml-4" id="post_{{$post->id}}_delete" name="delete_post">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </x-button>
                        </form>

                    </div>
                @endif
                <div class="float-right m-4">This post has <strong
                        class="text-blue-700">{{$post->post_account_balance}}</strong> points.
                </div>

                <!--Boost post-->
                <form method="post" action="{{route('posts.boost',$post)}}">
                    @csrf
                    @if(isset($current_user) && $post->user->id != Auth::user()->id)
                        @if(Auth::user()->pocket_money >= 5)
                            @method('PUT')
                            <x-button class="ml-4  m-3" id="post_{{$post->id}}_reward">
                                {{ __('Give 5 points') }}
                            </x-button>
                        @else
                            <div class="flex flex-row p-4">
                                <div class="text-red-500">You do not have enough points to award this post!
                                </div>
                                <div class="pl-2"> Boost your pocket
                                    <a href="{{ url('/pocket') }}" class=" hover:text-blue-700 underline"> here </a>
                                </div>
                            </div>

                        @endif
                    @endif
                </form>

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="text-blue-500 text-5xl ml-48 p-6 text-sm tracking-widest">
            #! comments section
        </div>
        <div class="border-b border-grey-200"></div>
        <div class="border-b border-grey-200">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-12 py-8 mt-4">
            @if (count($post->comments))
                <!-- pokazywanie komentarzy-->
                @include('posts.comments.index', ['comments' => $post->comments, 'post' => $post])
            @else
                <small class="py-12 text-blue-700 font-semibold text-2xl tracking-widest">no comments found!</small>
            @endif
            </div>
        </div>
    </div>
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl">
                @if(isset($current_user))
                    <h3 class="m-4 mt-4 font-semibold text-xl text-white leading-tight">
                        {{ __('Add comment') }}
                    </h3>

                    <form method="post" action="{{route('posts.comments.store',$post)}}">

                        @csrf

                        <div class="m-4 mt-4 h-200">
                            {{--<x-label for="text" :value="__('Text')"/>--}}
                            <textarea id="text" class="block mt-1 w-full" type="text" name="text"
                                     :value="old('text')" placeholder="Comment post..."></textarea>
                            @if ($errors->has('text'))
                                <?php

                                echo "<script>alert('The text filed is required!')</script>";

                                ?>
                            @endif
                        </div>
                        <x-button class="m-4  " name="Create comment">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </x-button>
                    </form>
                @else
                    <small class="py-12 text-blue-700 font-semibold text-2xl">Login to comment!</small>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
