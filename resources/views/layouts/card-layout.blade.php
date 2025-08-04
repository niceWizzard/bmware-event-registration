@props(['class' => ''])
@php
    $appName = config('app.name')
@endphp

<x-base-layout :title="$title" :override-title="$overrideTitle">
    <div class="flex flex-col gap-2 items-center justify-center min-h-screen">
        <h3 class="text-3xl text-center font-bold ">
            <a href="{{ route('home') }}">{{ $appName }}</a>
        </h3>
        <main class=" bg-surface flex items-center justify-center px-1">
            <div
                class="card card-border bg-base-100 md:min-w-96"
            >
                <div class="{{twMerge(['card-body', $class])}}">
                    <h2 class="{{twMerge(['card-title', $cardTitleClass])}}">{{$cardTitle}}</h2>
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</x-base-layout>
