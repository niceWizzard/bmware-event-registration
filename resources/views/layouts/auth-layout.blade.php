<x-header-layout
    :title="$title" :override-title="$overrideTitle"
    link-to="{{route('admin.dashboard')}}"
>
    <x-slot:headerActions>
        @auth
            <a href="{{route('admin.index')}}" class="btn btn-text">Admins</a>
            <form method="post" action="{{route('logout')}}">
                @csrf
                <button type="submit" class="btn btn-outline btn-error">Logout
                </button>
            </form>
        @endauth
    </x-slot:headerActions>
    {{$slot}}
</x-header-layout>
