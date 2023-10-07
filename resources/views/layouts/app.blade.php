<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Examonimy, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "Examonimy")</title>
    <base href="/">

    @yield("before_css")
    @include('components.embedded.head')
    @yield("after_css")
</head>
<body>
@include("components.spinner")
@include("components.header")
<main>
    @yield("main")
</main>
@include("components.footer")

@yield("before_js")
@include('components.embedded.script')
@yield("after_js")
</body>
</html>
