@php
    use App\View\Components\Breadcrumb;

    $breadcrumbs = Breadcrumb::createEventIndex([
        [
            'text' => 'Create',
        ],
    ]);

@endphp
<x-auth-layout title="Create Event">
    <section class="container mx-auto w-full p-8 flex flex-col items-center relative">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium self-start"/>
        <h2 class="text-lg font-bold">
            Create an Event
        </h2>
        <x-events.create-form
            action="{{route('events.store')}}"
            method="post"
        />
    </section>

</x-auth-layout>
