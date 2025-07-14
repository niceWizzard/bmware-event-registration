<x-auth-layout title="Manage">
    <a href="{{route('events.download', $event->short_name)}}" class="btn btn-primary">
        Download
    </a>
</x-auth-layout>
