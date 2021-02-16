<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 leading-tight">
            {{ __('My pocket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($money>0)
                <div class="text-blue-700 text-5xl">
                    You have {{$money}} points in your pocket!
                </div>
            @else
                <div class="text-blue-700 text-5xl">
                    Oops, you have no points in your pocket!
                </div>
            @endif
            <form method="post" action="{{ route('pocket.boost')}}">
            @csrf
            @method('PUT')
                <div class="mt-4 h-200">
                    <x-label for="boost" :value="__('Boost your pocket!')" />
                    <x-input id="boost" class="block mt-1" type="number" min="0" name="boost" :value="old('boost')" />
                    @if ($errors->has('boost'))
                        <?php

                        echo "<script>alert('All fields are required!')</script>";

                        ?>
                    @endif
                    <x-button class="mt-4">
                        {{ __('Boost') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
