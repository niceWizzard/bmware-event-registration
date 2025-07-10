<header class="w-full shadow-sm  h-16">
    <div class="px-4 py-2 w-full h-full flex justify-between gap-2  items-center">
        <h1 class="text-xl ">Event Registration</h1>
        <div class="flex-1 flex gap-2 justify-end">
            @auth
                <form method="post" action="{{route('logout')}}">
                    @csrf
                    <button type="submit" class="btn text-danger hover:text-on-danger hover:bg-danger ">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</header>
