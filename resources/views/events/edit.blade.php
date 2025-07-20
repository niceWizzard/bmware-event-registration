@php
    $breadcrumbs = [
            [
                'link' => route('events.index'),
                'text' => 'Events',
            ],
            [
                'text' => 'Edit',
            ],
        ];
@endphp

<x-auth-layout title="Edit">
    <section class="container p-8 mx-auto">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium" />
        <x-events.create-form
            :event="$event"
            action="{{route('events.update', $event->short_name)}}"
            specialMethod="PATCH"
        />
    </section>
</x-auth-layout>
