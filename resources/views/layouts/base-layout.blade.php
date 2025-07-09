@php
    $appName = config('app.name');
    $renderedTitle = match ($overrideTitle) {
        true => $title ?? $appName,
        false => $title ? $title . ' - '.$appName : $appName
    }

@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $renderedTitle}}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('head')
    @stack('scripts')
</head>
<body class="bg-surface text-on-surface ">
    {{$slot}}
</body>
</html>
