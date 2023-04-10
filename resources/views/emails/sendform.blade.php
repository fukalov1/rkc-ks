<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.png" type="image/png"/>
    <link rel="stylesheet" href="css/menu-style.css" />
    @include('layouts.styles')
</head>
<body>

@if(key_exists('direction', $data))
    Направление деятельности: {{ $data['direction'] }} <br/>
@endif

@if(key_exists('fio', $data))
    @if(isset($data['fio']))
        ФИО: {{ $data['fio'] }}<br/>
    @endif
@endif
@if(key_exists('name', $data))
    @if(isset($data['name']))
        Наименование: {{ $data['name'] }}<br/>
    @endif
@endif
E-mail: {{ $data['email'] }}<br/>
@if(key_exists('phone', $data))
    @if(isset($data['phone']))
        Телефон: {{ $data['phone'] }}<br/>
        @endif
@endif
<br/><br/>

Текст сообщения: {{ $data['message'] }}


</body>
</html>
