@php
    use \Illuminate\Support\Str;
@endphp
<x-auth-layout title="Dashboard">
    <section class="p-8 gap-2 container mx-auto flex flex-col">
        <div class="flex justify-end w-full">
            <a href="{{route('events.create')}}" class="btn btn-primary">
                <x-fas-plus class="size-4"/>
                Create Event
            </a>
        </div>
        <div class="flex flex-wrap justify-center  gap-2">
            @foreach($events as $event)
                <x-event-card :event="$event"/>
            @endforeach
        </div>
        {{ $events->links('pagination::default') }}
    </section>
</x-auth-layout>
