<x-auth-layout title="Edit">
    <section class="container p-8">
        <x-events.create-form
            :event="$event"
            action="{{route('events.update', $event->short_name)}}"
            specialMethod="PATCH"
        />
    </section>
</x-auth-layout>
