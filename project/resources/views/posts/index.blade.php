<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 leading-tight">
            List of posts
        </h2>
    </x-slot>

    <a href="{{ url('/') }}">
        <button class = " py-2 px-4 bg-blue-500 hover:bg-blue-700 ml-12 mt-12 shadow-2xl rounded-full text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" height="25" width="25">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>

        </button>
    </a>

    <a href="{{ url('/dashboard') }}">
    <button class = " py-2 px-4 bg-blue-500 hover:bg-blue-700 ml-4 mt-12 shadow-2xl rounded-full text-white font-bold">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" height="25" width="25">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    </a>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($posts) === 0)
                        <div>No posts in database.</div>
                    @else
                        <table>
                            <tr>
                                <th>Title</th><th>Content</th><th>Points</th>
                            </tr>

                            @foreach ($posts as $post)
                                <tr>
                                    <div class="shadow-2xl" id="post_{{$post->id}}">
                                        <td class="p-10">{{$post->title}}</td>
                                        <td class="p-10"><a href="/posts/{{ $post->id }}" id="post_{{$post->id}}_details"><button class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold tracking-widest uppercase py-2 px-4 rounded-full">details</button></a></td>
                                        <td class="p-10">{{$post->post_account_balance}}</td>
                                    </div>
                                </tr>

                            @endforeach
                        </table>
                        @endif
                        </br>
                        <a href="{{URL::to('posts/create')}}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" name = "Create new...">CREATE NEW...</button>
                        </a>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
