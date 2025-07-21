@php
    use App\View\Components\Breadcrumb;
    $breadcrumbs = Breadcrumb::createEvent($event,
        [
            [
                'text' => 'Manage',
            ],
        ]
    );
@endphp
<x-auth-layout title="Manage">
    <section class="p-8 container mx-auto w-full flex flex-col gap-4">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium"/>
        <div class="flex justify-between max-md:flex-col gap-4">
            <h2 class="text-xl font-medium">Event Information</h2>
            <div class="flex justify-center max-md:flex-col gap-2">
                <a href="{{route('events.registrations.show', $event->short_name)}}"
                   class="btn btn-accent btn-outline">
                    View Registrations
                </a>
                <a href="{{route('events.edit', $event->short_name)}}" class="btn btn-secondary btn-outline">
                    <x-fas-edit class="size-4"/>
                    Edit Event
                </a>
                <a href="{{route('events.download', $event->short_name)}}" class="btn btn-primary">
                    Download Data
                </a>
                <form
                    action="{{route('events.delete', $event->short_name)}}"
                    method="post"
                    x-data="{clicked: false}"
                    @submit.prevent="if(clicked) $el.submit(); clicked = true;"
                    class="w-full"
                >
                    @csrf
                    <button class="btn btn-error w-full"
                            x-text="clicked ? 'Delete Now?' : 'Delete'"
                            @click.outside="clicked = false;"
                    >Delete Event
                    </button>
                </form>
            </div>
        </div>
        <div class="flex gap-2 w-full max-md:flex-col ">
            <div class="flex max-w-md max-md:max-w-none flex-col">
                <div class="card bg-secondary text-primary-content w-full rounded-b-none">
                    <div class="card-body items-center">
                        <h3 class="card-title text-xl   ">
                            Event {{$event->status}}
                        </h3>
                    </div>
                </div>
                <div class="card card-border border-b border-r border-l rounded-t-none w-full">
                    <div class="card-body">
                        <p class="text-xl ">
                            Total Registrations: <span class="font-medium">
                                {{number_format($event->total_registrations)}}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card card-border flex-1">
                <div class="card-body">
                    <h3 class="card-title">
                        {{$event->title}}
                    </h3>
                    <p>
                        <span class="font-medium">Event Period: </span>
                        <span data-time="true">{{ $event->start_date->toString() }}</span>
                        to <span data-time="true">{{ $event->end_date->toString() }}</span>
                    </p>
                    <p>
                        <span class="font-medium">Registration Period: </span>
                        <span
                            data-time="true">{{ $event->registration_start_date->toString() }}</span>
                        to <span
                            data-time="true">{{ $event->registration_end_date->toString() }}</span>
                    </p>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-medium">Event Statistics</h2>
        <div class="flex flex-col w-sm max-md:w-full">
            <div class="card bg-info text-info-content rounded-b-none">
                <div class="card-body items-center">
                    <h3 class="card-title">Registrations by Gender</h3>
                </div>
            </div>
            <div class="card card-border rounded-t-none border-t-none">
                <div class="card-body flex-row">
                    <p class="text-lg">
                        <span class="font-medium">
                            Female:
                        </span>
                        <span>
                            {{number_format($event->female_registrations)}}
                        </span>
                    </p>
                    <p class="text-lg">
                        <span class="font-medium">
                            Male:
                        </span>
                        <span>
                            {{number_format($event->male_registrations)}}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.transformDataTime();
        });
    </script>
</x-auth-layout>
