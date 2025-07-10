<x-header-layout
    :title="$title" :override-title="$overrideTitle"
    link-to="{{route('admin.dashboard')}}"
>
    <x-slot:headerActions>
        @auth
            <form method="post" action="{{route('logout')}}">
                @csrf
                <button type="submit" class="btn text-danger hover:text-on-danger hover:bg-danger ">Logout
                </button>
            </form>
        @endauth
    </x-slot:headerActions>
    {{$slot}}
</x-header-layout>
