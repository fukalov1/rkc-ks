@extends('layouts._pages')


@section('content')

    <div class="navig-bottom-height">
        <div class="navig-bottom default-menu" id="menu">
            <div class="container">
                <div class="go-top-top">
                    <a href="#top-header"></a>
                </div>
                <ul>
                    @foreach($page_blocks as $page_block)
                        @if($loop->iteration==2)
                            @if ($data->news_branch)
                                <li><a href="#news{{ $data->id }}" class="anchor">Главные события</a></li>
                            @endif
                        @endif
                        @if($page_block->header!='' and $page_block->submenu)
                            <li><a href="#block{{ $page_block->id }}" class="anchor">{{ $page_block->header }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <section class="w3l-about-breadcrum">
        <section class="breadcrum-bg py-sm-5 py-4">
            <div class="container py-lg-3">
                <h2> {{ $data->name  }}</h2>
                <p>{!! $bread_crumbs !!}</p>
            </div>
        </section>
    </section>


    @foreach($page_blocks as $page_block)
        @if($loop->iteration==2)
            @if ($data->news_branch)
                <section id="developments">
                    <div class="container">
                        <h2 id="news{{ $data->id }}">Главные события</h2>
                        <div class="row">
                            @foreach($data->news as $item)
                                <div class="col-md-4 col-lg-3">
                                    <div class="developments-item">
                                        <div class="developments-img">
                                            <img src="/uploads/images/thumbnail/{{ $item->image }}" alt="{{ $item->name }}">
                                            <div class="developments-abs">
                                                <div class="developments-abs-top">
                                                    <h3>{{ $item->name }}</h3>
                                                    <p><a href="/news/{{$item->id}}">{{ $item->anons }}</a></p>
                                                </div>
                                                <div class="developments-date">
                                                    <div>{{ $item->date }}</div>
                                                    <div>{{ $item->show }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="developments-more">
                            <a href="/news/all/{{ $data->id }}">Все новости </a>
                        </div>
                    </div>
                </section>
            @endif
        @endif
        @if($page_block->type == '1')
            <section class="w3l-content-with-photo-4" id="block{{$page_block->id}}">
                <div class="container py-md-5">
                    <div class="cwp4-two row">
                        <div class="cwp4-text col-lg-12">
                            <h1>{{ $page_block->header }}</h1>
                            {!! preg_replace("/<table>/", "<table class=\"table table-striped\">", $page_block->text) !!}
                        </div>
                    </div>
                </div>
            </section>
        @elseif($page_block->type=='2')
            <div class="blo-photo" id="block{{$page_block->id}}">
                <div class="container pos-r">
                    <h3>{{ $page_block->header }}</h3>
                    <div class="blo-photo-item">
                        <img src="/uploads/{{ $page_block->image }}" alt="{{ $page_block->header }}">
                    </div>
                    <div class="blo-photo-txt">
                        {!! $page_block->text !!}
                    </div>
                </div>
            </div>
        @elseif($page_block->type=='3')
            <section class="promo" id="block{{$page_block->id}}">
                <div class="container">
                    <h3>{{ $page_block->header }}</h3>
                    {!! $page_block->text !!}
                </div>
            </section>
        @elseif($page_block->type=='4')
            <section class="page-block-doc" id="block{{$page_block->id}}">
                <div class="container">
                    <h1>{{ $page_block->header }}</h1>
                    {!! $page_block->text !!}
                </div>
            </section>
        @elseif($page_block->type=='5')
            <section class="page-block-link" id="block{{$page_block->id}}">
                <div class="container">
                    <h1>{{ $page_block->header }}</h1>
                    {!! $page_block->text !!}
                </div>
            </section>
        @elseif($page_block->type=='6')
            <section class="page-block-pdf" id="block{{$page_block->id}}">
                <div class="container">
                    <h1>{{ $page_block->header }}</h1>
                    {!! $page_block->text !!}
                </div>
            </section>
        @elseif($page_block->type=='7')
            <section class="page-block">
                <div class="container">
                    @foreach($page_block->sliders as $slider)
                    <div id="my-slider" class="my-slider">
                        @foreach($slider->items as $item)
                        <div class="slide">
                            <div class="slide-image" style="background: url('/uploads/{{ $item->image }}')">
                                <div class="slide-title">
                                    <h3>
                                        <a href="{{ $item->url }}" target="_blank">
                                        {{ $item->title }}
                                        </a>
                                    </h3>
                                </div>
                                {{--<a href="{{ $item->url }}" target="_blank">--}}
                                {{--<img--}}
                                        {{--src="" alt="{{ $item->title }}"/>--}}
                            {{--</a>--}}

                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </section>
        @elseif($page_block->type=='8')
            <section class="page-block" id="block{{$page_block->id}}">
                {!! $page_block->text !!}
            </section>
        @elseif($page_block->type=='12')
            <section class="answer"  id="block{{$page_block->id}}">
                <div class="container">
                    <h2>{{ $page_block->header }}</h2>
                    {!! $page_block->text !!}
                    <div class="col-12 text-right">
                        <span class="link selected" rel="1">Типовые вопросы</span> /<span class="link" rel="0">Общие вопросы</span>
                    </div>
                    @foreach($page_block->quest_blocks as $quest_block)
                        <div id="accordion">
                            @foreach($quest_block->questions as $question)
                                @if($question->hide==0)
                            <div class="card type{{ $question->type }}">
                                <div class="card-header">
                                    <a class="card-link" data-toggle="collapse" href="#collapse{{ $question->id }}" title="раскрыть вопрос и показать ответ">
                                        {{ $question->quest }}
                                    </a>
                                </div>
                                @if ($loop->first)
                                <div id="collapse{{ $question->id }}" class="collapse show" data-parent="#accordion">
                                    <div class="card-body">
                                        {!! $question->response !!}
                                    </div>
                                </div>
                                @else
                                    <div id="collapse{{ $question->id }}" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! $question->response !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                                @endif
                            @endforeach
                        </div>

                        </div>
                        @if($quest_block->hide==1)
                        <section class="mail-form">
                            <div class="container form-area{{ $quest_block->id }}">

                                <h2>Задайте свой вопрос</h2>
                                <form id="sendquest{{ $quest_block->id }}" class="send-quest" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-inp">
                                            <input type="text" class="field" rel="fio"
                                                   id="fio{{ $quest_block->id }}"
                                                   name="fio" placeholder="ФИО">
                                            <input type="text" class="field" rel="email"
                                                   id="email{{ $quest_block->id }}"
                                                   name="email" placeholder="E-mail">
                                    </div>
                                    <div class="form-textarea">
                                    <textarea name="message{{ $quest_block->id }}" id="message{{ $quest_block->id }}"
                                              placeholder="Ваш вопрос"></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="submit-quest" rel="{{ $quest_block->id }}">Отправить</button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <input type="hidden" name="uid" value="{{ $quest_block->id }}">
                                </form>

                            </div>
                        </section>
                        @endif
                    @endforeach
                </div>
            </section>
        @elseif($page_block->type=='9')
            @foreach($page_block->photosets as $photoset)
                    <section id="photo-gallery">
                        <div class="container" id="block{{ $page_block->id }}">
                            <h2>{{ $photoset->name }}</h2>
                            <div class="row">
                                @foreach($photoset->photos as $photo)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="photo-gallery-item">
                                            <a href="/uploads/images/{{$photo->image}}" class="modalbox"><img
                                                        src="images/search.png" alt=""></a>
                                            <img src="/uploads/images/thumbnail/{{$photo->image}}" alt="">
                                            <div class="title">
                                                {{ $photo->name }}
                                            </div>
                                            @if($photo->text!='')
                                                <div class="title">
                                                    {{ $photo->text }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
            @endforeach
        @elseif($page_block->type=='10')
            @foreach($page_block->mail_forms as $item)
                    <section class="mail-form" id="block{{ $page_block->id }}">
                        <div class="container form-area{{ $item->id }}">
                            <h2>{{ $item->name }}</h2>
                            {!! $page_block->text  !!}
                            <form id="sendform{{ $item->id }}" class="send-form" method="post">
                                {{ csrf_field() }}
                                <div class="form-inp">
                                    @foreach($item->fields as $field)
                                        @if($field->field_name=='direction')
                                            <div class="label">
                                                Укажите тему вопроса, по которой отправляте письмо
                                            </div>
                                            <select class="field" id="{{ $field->field_name }}{{ $item->id }}"
                                                    name="{{ $field->field_name }}">
                                                @foreach($directs as $direct)
                                                    <option value="{{ $direct->name }}">{{ $direct->name }}</option>
                                                @endforeach
                                            </select>

                                        @else
                                            <input type="text" class="field" rel="{{ $field->field_name }}"
                                               id="{{ $field->field_name }}{{ $item->id }}"
                                               name="{{ $field->field_name }}" placeholder="{{ $field->field_value }}">
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-textarea">
                                    <textarea name="message{{ $item->id }}" id="message{{ $item->id }}"
                                              placeholder="Комментарий…"></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="submit-button" rel="{{ $item->id }}">Отправить</button>
                                </div>
                                <div class="clearfix"></div>
                                <input type="hidden" name="uid" value="{{ $item->id }}">
                            </form>
                        </div>
                    </section>
            @endforeach
        @elseif($page_block->type=='11')

            <script src="https://api-maps.yandex.ru/2.1/?apikey=c79faa17-9b3b-4054-9a04-3aad1bb7cb1d&lang=ru_RU&load=Map,Placemark,GeoObjectCollection"
                    type="text/javascript"></script>

            @foreach($page_block->maps as $map)
                    <section class="block_maps"  id="block{{$page_block->id}}">
                        <div class="container">
                            <h2>{{ $map->name }}</h2>

                            <script>
                                ymaps.ready(function () {
                                    // В функцию поступает пространство имен, которое содержит все запрощенные при инициализации модули.
                                    var myMap = new ymaps.Map('map{{ $map->id }}', {
                                        center: [{{ $map->xcoord }}, {{ $map->ycoord }}],
                                        zoom: '{{ $map->zoom }}',
                                        // В данном примере карта создается без контролов, так как те не были загружены при инициализации API.
                                        controls: []
                                    });

                                    @if (count($map->points)>0)
                                    @if ($map->type==1)
                                    myMap.geoObjects
                                    @foreach($map->points as $point)
                                        .add(new ymaps.Placemark(
                                            [{{ $point->xcoord }}, {{ $point->ycoord }}], {
                                                balloonContent: '{{ $point->content }}',
                                                balloonContentHeader: '{{ $point->content }}',
                                                balloonContentBody: '{{ $point->content }}',
                                                hintContent: '{{ $point->content }}',
                                                iconCaption: '{{ $point->name }}'
                                            }))
                                        @endforeach
                                        .add(new ymaps.Placemark(
                                            [53.195538, 50.101783], {
                                                balloonContent: 'Самара город-герой',
                                                balloonContentHeader: "Самара",
                                                balloonContentBody: "описание Самары",
                                                balloonContentFooter: "Подвал",
                                                hintContent: "самара подсказка"
                                            }));
                                    @elseif ($map->type==2)
                                    // Контейнер для меню.
                                    var menu = $('<ul class="map_menu"></ul>');

                                    // Группы объектов
var groups = [
@foreach($map->points as $point)
     @if ($point->parent_id==0)
     {
     name: "{{ $point->name }}",
     style: "islands#redIcon",
     items: [
     @foreach($point->sub_points as $sub_point)
     {
     center: [{{ $sub_point->xcoord }}, {{ $sub_point->ycoord }}],
     name: "{{ $sub_point->name }}"
     },
     @endforeach
     ]
     },
@endif
@endforeach
];

                                    for (var i = 0, l = groups.length; i < l; i++) {
                                        console.log('group ',groups[i]);
                                        createMenuGroup(groups[i]);
                                    }

                                    console.log(groups);

                                    function createMenuGroup(group) {
                                        // Пункт меню.
                                        var menuItem = $('<li><a href="javascript:">' + group.name + '</a></li>'),
                                            // Коллекция для геообъектов группы.
                                            collection = new ymaps.GeoObjectCollection(null, {preset: group.style}),
                                            // Контейнер для подменю.
                                            submenu = $('<ul class="map_submenu"></ul>');

                                        // Добавляем коллекцию на карту.
                                        myMap.geoObjects.add(collection);
                                        // Добавляем подменю.
                                        menuItem
                                            .append(submenu)
                                            // Добавляем пункт в меню.
                                            .appendTo(menu)
                                            // По клику удаляем/добавляем коллекцию на карту и скрываем/отображаем подменю.
                                            .find('a')
                                            .bind('click', function () {
                                                if (collection.getParent()) {
                                                    myMap.geoObjects.remove(collection);
                                                    submenu.hide();
                                                } else {
                                                    myMap.geoObjects.add(collection);
                                                    submenu.show();
                                                }
                                            });
                                        for (var j = 0, m = group.items.length; j < m; j++) {
                                            createSubMenu(group.items[j], collection, submenu);
                                        }
                                    }

                                    function createSubMenu(item, collection, submenu) {
                                        // Пункт подменю.
                                        var submenuItem = $('<li><a href="javascript:">' + item.name + '</a></li>'),
                                            // Создаем метку.
                                            placemark = new ymaps.Placemark(item.center, {balloonContent: item.name, iconCaption: item.name});

                                        // Добавляем метку в коллекцию.
                                        collection.add(placemark);
                                        // Добавляем пункт в подменю.
                                        submenuItem
                                            .appendTo(submenu)
                                            // При клике по пункту подменю открываем/закрываем баллун у метки.
                                            .find('a')
                                            .bind('click', function () {
                                                if (!placemark.balloon.isOpen()) {
                                                    placemark.balloon.open();
                                                } else {
                                                    placemark.balloon.close();
                                                }
                                                return false;
                                            });
                                    }

                                    console.log('menu', menu);
                                    // Добавляем меню в тэг BODY.
                                    menu.appendTo($('#mymenu'));
                                    // Выставляем масштаб карты чтобы были видны все группы.
                                    myMap.setBounds(myMap.geoObjects.getBounds());


                                @endif
                                    @endif

                                });
                            </script>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div id="map{{ $map->id }}" class="mymaps"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div id="mymenu">
                                        <ul class="map-info">
                                            @foreach($map->points as $point)
                                                <li>
                                                    <strong>
                                                        @if($point->content!='')
                                                            <a href="{{ $point->content }}" target="_blank">{{ $point->name }}</a>
                                                        @else
                                                            {{ $point->name }}
                                                        @endif
                                                    </strong>
                                                    @if ($point->body!='')
                                                        - {{ $point->body }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
            @endforeach
        @endif
    @endforeach

    {{--<section class="page-block">--}}
    {{--<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2bba92d5c8e733ccf0d05bcdeff0fdfac3af4b97f607093cabfa6388e841ada8&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>--}}
    {{--</section>--}}

@stop
