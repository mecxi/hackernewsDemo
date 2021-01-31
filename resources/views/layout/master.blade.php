<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HackerNews Demo - {{ $title }}</title>
    <link rel="stylesheet" href="{{url('assets/css/hint.css-2.6.0/hint.base.min.css')}}"/>
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}"/>
</head>
<body>
<div id="sidebar">
    <h3>Hacker News Demo</h3>
    <ul id="types">
        @foreach($types as $type)
            <li>
                <a href="/{{ $type }}">{{ $type }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div id="items-container">
    @yield('contents')
</div>
<script src="{{ url('assets/js/app.js') }}"></script>
</body>
</html>