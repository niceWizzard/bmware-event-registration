<x-header-layout
    :title="$title" :override-title="$overrideTitle"
>
    <slot:headerActions>
        @auth
            <form method="post" action="{{route('logout')}}">
                @csrf
                <button type="submit" class="btn text-danger hover:text-on-danger hover:bg-danger ">Logout
                </button>
            </form>
        @endauth
    </slot:headerActions>
    {{$slot}}
</x-header-layout>
