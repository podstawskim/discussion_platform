<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editing a comment') }}
        </h2>
    </x-slot>
    <div class="py-12 mb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="post" action="{{ route('posts.comments.update', [$post, $comment]) }}">

                        @csrf
                        @method('PUT')

                        <div class="mt-4 flex flex-row">
{{--                            <x-label for="title" :value="__('Title')" />--}}
{{--                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$comment->title" />--}}


                            <textarea id="text" class="block mt-1 w-full" type="text" name="text" :value="$comment->text" /><?php echo $comment['text'] ?></textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4 mb-12">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
