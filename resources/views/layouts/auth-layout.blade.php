<x-header-layout
    :title="$title" :override-title="$overrideTitle"
    link-to="{{route('events.index')}}"
>
    <x-slot:headerActions>
        @auth
            <div class="flex gap-2 ">
                <div class="flex gap-2 max-md:hidden">
                    <a href="{{route('events.index')}}" class="btn btn-ghost">Events</a>
                    <a href="{{route('admin.index')}}" class="btn btn-ghost">Admins</a>
                    <a href="{{route('profile.index')}}" class="btn btn-ghost">Profile</a>
                    <form method="post" action="{{route('logout')}}">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-error">Logout</button>
                    </form>
                </div>
                <div class="drawer md:hidden">
                    <input id="my-drawer" type="checkbox" class="drawer-toggle"/>
                    <div class="drawer-content">
                        <!-- Page content here -->
                        <label for="my-drawer" class="btn btn-ghost drawer-button">
                            <x-zondicon-menu class="size-4"/>
                        </label>
                    </div>
                    <div class="drawer-side">
                        <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                        <div class="menu bg-base-200 text-base-content min-h-full w-80 p-4 flex flex-col gap-2">
                            <a href="{{route('events.index')}}" class="btn btn-ghost">Events</a>
                            <a href="{{route('admin.index')}}" class="btn btn-ghost">Admins</a>
                            <a href="{{route('profile.index')}}" class="btn btn-ghost">Profile</a>
                            <div class="flex-1  flex items-end">
                                <form method="post" action="{{route('logout')}}"
                                      class="w-full"
                                >
                                    @csrf
                                    <button type="submit" class="btn btn-outline btn-error w-full">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endauth
    </x-slot:headerActions>
    {{$slot}}
</x-header-layout>
