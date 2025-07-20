@php
    use Illuminate\Support\Str;
    $badgeClass = 'badge-' . Str::lower($event->status);

@endphp

<div class="card card-border w-md max-md:w-full">
    <div class="card-body">
        <h3 class="card-title inline-flex items-start max-md:flex-col">
            <div class="badge {{twMerge([' badge-sm', $badgeClass])}} ">
                {{$event->status}}
            </div>
            {{Str::limit($event->title, 64)}}
        </h3>
        <p class="text-sm font-light" >
            Created at:
            <span data-time="true">{{ $event->created_at?->toString() }}</span>
        </p>
        <p>{{Str::limit(Str::trim($event->description), 48)}}</p>
        <div class="card-actions justify-end max-md:items-start items-center max-md max-md:flex-col">
            <div class="flex-1">
                <span class="text-sm font-medium text-gray-700">
                    {{ number_format($event->registrations_count ?? 0) }} <span
                        class="text-gray-500">Registrations</span>
                </span>
            </div>
            <div class="flex gap-2 justify-end w-full max-sm:flex-col">
                @auth
                    <a href="{{route('events.manage', $event->short_name)}}" class="btn max-md:btn-sm">
                        <x-fas-edit class="size-4"/>
                        Manage
                    </a>
                @endauth
                <a href="{{route('events.show', $event->short_name)}}" class="btn btn-primary max-md:btn-sm">
                    <x-fas-eye class="size-4"/>
                    View
                </a>
            </div>
        </div>
    </div>
</div>
