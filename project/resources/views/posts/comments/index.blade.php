<div class="ml-12 mt-4 py-4">
                        <ul>

                            @foreach($comments as $comment)
                                @if(isset($edited_comment_id) && $edited_comment_id==$comment->id)
                                    <li class="py=4 whitespace-nowrap">
                                        <h3 class="m-4 mt-4 font-semibold text-xl text-gray-800 leading-tight">Editing comment...</h3>
                                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                        <form method="post" action="{{ route('posts.comments.update', [$post,$comment]) }}">

                                            @csrf
                                            @method("PUT")
                                            <div class="mt-4">

                                                <textarea id="comment_{{$comment->id}}_update" class="block mt-1 w-full" type="text" name="text" :value="$comment->text" /><?php echo $comment['text'] ?></textarea>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">

                                                <x-button class="ml-4 mb-4" id="comment_{{$comment->id}}_update_button">
                                                    {{ __('Update comment') }}
                                                </x-button>
                                            </div>
                                        </form>
                                    </li>
                                @else
                                    <div class="p-4 mb-2 overflow-hidden shadow-2xl sm:rounded-lg from-blue-900 bg-gradient-to-r via-blue-700 to-blue-500" id="comment_{{$comment->id}}">
                                        <li class="p-1 whitespace-nowrap">
                                            <div class="flex flex-row">
                                                <strong class="text-sm text-white">{{$comment->user->name}}</strong>
                                                <div class="text-sm pl-3 text-white">{{$comment->created_at}}</div>
                                                </div>
                                            <textarea class="block mt-1 w-full" id="comment_{{$comment->id}}_content" disabled>{{$comment->text}}</textarea>
                                            @if($current_user)
                                                <div class="m-2 flex flex-wrap left-0 ">
                                                    @if(Auth::user()->id == $comment->user->id)
                                                        <form method="post" action="{{ route('posts.comments.destroy', [$post, $comment]) }}">
                                                            @csrf
                                                            @method("DELETE")
                                                            <x-button class="m-2" id="comment_{{$comment->id}}_delete">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="16">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>

                                                            </x-button>
                                                        </form>
                                                        <form method="get" action="{{route('posts.comments.edit',[$post,$comment])}}">
                                                            <x-button class="m-2  " id="comment_{{$comment->id}}_edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="16">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                </svg>
                                                            </x-button>
                                                        </form>
                                                    @endif
                                                    <x-button class="m-2 bg-red-600" id="comment_{{$comment->id}}_reply_button" onclick="showReply({{$comment->id}})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="16">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                        </svg>
                                                    </x-button>
                                                </div>
                                            @endif
                                        </li>
                                    </div>
                                        <!--odpowiadanie na komentarz -->

                                        <div id="{{$comment->id}}" style="display: none">
                                            <form method="post" id="comment_{{$comment->id}}_reply_form" action="{{ route('reply.add') }}">

                                                @csrf

                                                <div class="m-4 mt-4 h-200">
                                                    <textarea id="comment_{{$comment->id}}_reply" class="block mt-1 w-full" type="text" name="text" placeholder="Reply..."/></textarea>
                                                </div>

                                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                                <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
                                                <x-button class="m-4 ">
                                                    {{ __('Reply') }}
                                                </x-button>
                                            </form>
                                        </div>

                                        <div class="px-10">
                                        @include('posts.comments.index', ['comments' => $comment->replies, 'post' => $post])
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

</div>

<script>
    function showReply(id) {
        var x = document.getElementById(id);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
