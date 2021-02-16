<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Creating a comment') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="post" action="{{ route('posts.comments.store', $post) }}">

                        @csrf

{{--                        <div class="mt-4">--}}
{{--                            <x-label for="title" :value="__('Title')" />--}}
{{--                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" />--}}
{{--                        </div>--}}

                        <div class="mt-4">
                            <x-label for="text" :value="__('Text')" />
                            <textarea id="text" class="block mt-1 w-full" type="text" name="text" :value="old('text')" /></textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
