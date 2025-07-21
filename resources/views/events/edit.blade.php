@php
    $breadcrumbs = [
            [
                'link' => route('events.index'),
                'text' => 'Events',
            ],
            [
                'link' => route('events.show', $event->short_name),
                'text' => \Illuminate\Support\Str::limit($event->title, 24),
            ],
            [
                'text' => 'Edit',
            ],
        ];
@endphp

<x-auth-layout title="Edit">
    <section class="container p-8 mx-auto">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium"/>
        <x-events.create-form
            :event="$event"
            action="{{route('events.update', $event->short_name)}}"
            specialMethod="PATCH"
        />
    </section>
</x-auth-layout>
