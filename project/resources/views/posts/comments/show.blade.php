<x-guest-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Viewing a comment') }}
        </h2>

        <h1>
{{--            {{ $comment->title }}--}}
        </h1>



        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            @markdown($comment->text)
        </div>

        <div class="m-3 flex flex-row" >
            <form method="get" action="{{ route('posts.comments.edit', [$post,$comment]) }}">
                <x-button class="ml-4">
                    {{ __('Edit') }}
                </x-button>
            </form>

            <form method="post" action="{{ route('posts.comments.destroy', [$post, $comment]) }}">

                @csrf
                @method("DELETE")

                <x-button class="ml-4">
                    {{ __('Delete') }}
                </x-button>
            </form>
        </div>
    </div>

</x-guest-layout>
