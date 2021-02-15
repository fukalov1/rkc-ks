<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="noindex">
    <title>РКЦ-Консалтинг Сервис : расчеты, платежи, работа с населением, организациями, банками</title>
    <meta name="description" content="РКЦ-КС, РКЦ-Консалтинг Сервис,расчеты,платежи,работа с населением,организациями,банками,ТСЖ,Тольятти">
    <meta name="keywords" content="РКЦ-КС, РКЦ-Консалтинг Сервис,расчеты,платежи,работа с населением,организациями,банками,ТСЖ,Тольятти">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="format-detection" content="telephone=no">
    <!-- Favicons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
{{--    <link rel="apple-touch-icon" sizes="180x180" href="{{{ asset('images/favicons/site/apple-touch-icon.png') }}}">--}}
{{--    <link rel="icon" type="image/png" sizes="32x32" href="{{{ asset('images/favicons/site/favicon-32x32.png') }}}">--}}
{{--    <link rel="icon" type="image/png" sizes="16x16" href="{{{ asset('images/favicons/site/favicon-16x16.png') }}}">--}}
{{--    <link rel="manifest" href="{{{ asset('images/favicons/site/site.webmanifest') }}}">--}}
{{--    <link rel="mask-icon" href="{{{ asset('images/favicons/site/safari-pinned-tab.svg') }}}" color="#5bbad5">--}}
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    @include('layouts.styles')
</head>
<body>

    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    @include('layouts.scripts')
</body>
</html>
