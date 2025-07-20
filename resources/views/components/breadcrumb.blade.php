@props([
    'class' => '',
])

<div class="{{twMerge(['breadcrumbs text-sm', $class])}}">
    <ul>
        @foreach($breadcrumbs as $breadcrumb )
            <li>
                @if(isset($breadcrumb['link']))
                    <a href="{{$breadcrumb['link']}}">
                        {{$breadcrumb['text']}}
                    </a>
                @else
                    {{$breadcrumb['text']}}
                @endif
            </li>
        @endforeach
    </ul>
</div>
