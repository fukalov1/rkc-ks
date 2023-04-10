<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Новости. Региональный центр трудовых ресурсов г. Тольятти</title>
    <meta name="description" content="Новости. Региональный центр трудовых ресурсов г. Тольятти" />
    <meta name="keywords" content="Новости Региональный центр трудовых ресурсов Тольятти"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.png" type="image/png"/>
    <link rel="stylesheet" href="css/menu-style.css" />
    @include('layouts.styles')
</head>
<body>
    @include('layouts.header')

    @yield('content')


<section id="footer-links">
    <div class="container">
        <ul>
            @foreach($pages as $page)
                <li>
                    @if($page->redirect=='')
                        <a href='/{{ $page->url }}'>{!! $page->name  !!} </a>
                    @else
                        <a href='/{{ $page->redirect }}'>{!! $page->name  !!} </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</section>

@include('layouts.footer')

<div class="go-top">
    <a href="#top-header"></a>
</div>

@include('layouts.scripts')
</body>
</html>
