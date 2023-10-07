<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", "Examonimy | Dashboard")</title>
    <meta name="description" content="Admin Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="/">

    @yield("before_css")
    @include('components.admin.embedded.head')
    @yield("after_css")
</head>
<body>
@include("components.admin.dashboard.header")
<main>
    @yield("main")
</main>
@include("components.admin.dashboard.sidebar")
@include("components.admin.dashboard.footer")

@yield("before_js")
@include('components.admin.embedded.script')
@yield("after_js")
</body>
</html>
