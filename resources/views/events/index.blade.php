@php
    use \Illuminate\Support\Str;
@endphp

<x-header-layout title="Events" :link-to="route('events.index')">
    <section class="p-8 gap-2 container mx-auto flex flex-col">
        @auth
            <div class="flex justify-end w-full">
                <a href="{{route('events.create')}}" class="btn btn-primary">
                    <x-fas-plus class="size-4"/>
                    Create Event
                </a>
            </div>
        @endauth
        <div class="flex flex-wrap justify-center  gap-2">
            @foreach($events as $event)
                <x-event-card :event="$event"/>
            @endforeach
        </div>
        {{ $events->links('pagination::default') }}
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.transformDataTime();
        });
    </script>
</x-header-layout>
