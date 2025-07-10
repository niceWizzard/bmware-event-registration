@props(['headerTitle' => 'Header', 'linkTo' => null])

<header class="w-full shadow-sm  h-16">
    <div class="px-4 py-2 w-full h-full flex justify-between gap-2  items-center">
        <h1 class="text-xl ">
            @if($linkTo)
                <a href="{{$linkTo}}">{{$headerTitle}}</a>
            @else
                {{$headerTitle}}
            @endif
        </h1>
        <div class="flex flex-1  w-full gap-2 items-center justify-end ">
            {{$slot}}
        </div>
    </div>
</header>
