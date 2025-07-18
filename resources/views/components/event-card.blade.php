@php
    $badgeClass = 'badge-'. match (\Illuminate\Support\Str::lower($event->status)) {
        'on-going' => 'success',
        'pending' => 'secondary',
        default => 'warning',
    }
@endphp

<div class="card card-border w-md">
    <div class="card-body">
        <h3 class="card-title inline-flex items-start">
            <div class="{{twMerge(['badge badge-sm', $badgeClass])}} ">
                {{$event->status}}
            </div>
            {{Str::limit($event->title, 64)}}
        </h3>
        <p class="text-sm font-light">{{ $event->created_at?->format('D, h:i A') }}</p>
        <div class="card-actions justify-end items-center">
            <div class="flex-1">
                <span class="text-sm font-medium text-gray-700">
                    {{ number_format($event->registrations_count ?? 0) }} <span
                        class="text-gray-500">Registrations</span>
                </span>
            </div>
            <a href="{{route('events.manage', $event->short_name)}}" class="btn">
                <x-fas-edit class="size-4"/>
                Manage
            </a>
            <a href="{{route('events.show', $event->short_name)}}" class="btn btn-primary">
                <x-fas-eye class="size-4"/>
                View
            </a>
        </div>
    </div>
</div>
