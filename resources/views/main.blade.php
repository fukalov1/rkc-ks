@extends('layouts._main')


@section('content')
    <section id="serv">
        <div class="container">
        <div class="serv-flex">
            <div class="serv-flex-row">
                @foreach($directs as $item)
                <div class="serv-item">
                    <a href="{{ $item->url }}" class="pos-r">
                        <img src="/uploads/{{ $item->image }}" alt="">
                        <div class="serv-item-abs">
                            <span>{!! $item->name !!}</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="serv-mobile">
            @foreach($directs as $item)
                <a href="{{ $item->url }}">{!! $item->name !!}</a><br>
            @endforeach
        </div>
    </div>
    </section>

<section id="home-ico">
    <div class="container pos-r">
        <div class="home-ico-flex">
            <div class="home-ico-item">
                <div class="home-ico-img">
                    <a href="/napravleniya-deyatelnosti-rctr/professionalnaya-orientaciya">
                        <img src="images/i1.png" alt="">
                    </a>
                </div>
                <p>Школьникам</p>
            </div>
            <div class="home-ico-item">
                <div class="home-ico-img">
                    <a href="/napravleniya-deyatelnosti-rctr/sodeystvie-trudoustroystvu">
                        <img src="images/i2.png" alt="">
                    </a>
                </div>
                <p>Студентам</p>
            </div>
            <div class="home-ico-item">
                <div class="home-ico-img">
                    <a href="/napravleniya-deyatelnosti-rctr/povyshenie-kvalifikacii-pedkadrov">
                        <img src="images/i5.png" alt="">
                    </a>
                </div>
                <p>Работающим</p>
            </div>
            <div class="home-ico-item">
                <div class="home-ico-img">
                    <a href="/profstandart-v-obrazovanii">
                        <img src="images/i3.png" alt="">
                    </a>
                </div>
                <p>Образовательным <br>организациям</p>
            </div>
            <div class="home-ico-item">
                <div class="home-ico-img">
                    <a href="/napravleniya-deyatelnosti-rctr/regionalnyy-standart">
                        <img src="images/i4.png" alt="">
                    </a>
                </div>
                <p>Работодателям</p>
            </div>
        </div>
        <div class="top-links">0
            <a href="#top-header" class="anchor"></a>
        </div>
    </div>
</section>

<section id="developments">
    <div class="container">
        <h2>Последние события</h2>
        <div class="row">
            @foreach($banners as $item)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <a href="{{ $item->text }}" target="_blank">
                <div class="developments-banner">
                    <div class="developments-banner-img">
                            <img src="/uploads/{{ $item->image }}" alt="">
                    </div>
                    <h4>{{  $item->title }}</h4>
                </div>
                </a>
            </div>
            @endforeach
{{--            @foreach($center_news as $item)--}}
{{--             <div class="col-md-4 col-lg-3">--}}
{{--                <div class="developments-item">--}}
{{--                    <div class="developments-img">--}}
{{--                        <img src="/uploads/images/thumbnail/{{ $item->image }}" alt="{{ $item->name }}">--}}
{{--                        <div class="developments-abs">--}}
{{--                            <div class="developments-abs-top">--}}
{{--                                <h3>{{ $item->name }}</h3>--}}
{{--                                <p><a href="/news/{{$item->id}}">{{ $item->anons }}</a></p>--}}
{{--                            </div>--}}
{{--                            <div class="developments-date">--}}
{{--                                <div>{{ $item->date }}</div>--}}
{{--                                <div>{{ $item->show }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            @endforeach--}}
        </div>
        <div class="developments-more">
            <a href="/news/all">Все новости</a>
        </div>
    </div>
</section>

<section id="labor">
    <div class="container">
        <h3>Количество посетителей сайта 2546497</h3>
        <div class="row pos-r">
            <div class="col-6 col-sm-3 col-md-3">
                <div class="labor-item">
                    <h4 class="number1">{{ config('employer') }}</h4>
                    <p>Посетителей раздела<br/> Региональный стандарт</p>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-3">
                <div class="labor-item">
                    <h4 class="number2">{{ config('school') }}</h4>
                    <p>Посетителей <br/>раздела Профориентация</p>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-3">
                <div class="labor-item">
                    <h4 class="number3">{{ config('students') }}</h4>
                    <p>Посетителей <br/>раздела Дуальное обучение</p>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-3">
                <div class="labor-item">
                    <h4 class="number4">{{ config('master') }}</h4>
                    <p>Посетителей<br/> раздела Наставничество</p>
                </div>
            </div>
        </div>
    </div>
</section>


    @foreach($page_blocks as $page_block)
        @if($page_block->type == '1')
            <section class="page-block" id="block{{$page_block->id}}">
                <div class="container">
                    <h1>{{ $page_block->header }}</h1>
                    {!! $page_block->text !!}
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
            @foreach($page_block->sliders as $slider)
                    <section id="our-partners">
                        <div class="container">
                            <h2>Наши партнеры</h2>
                            <div class="partners-slider">
                                @foreach($slider->items as $slider_item)
                                    <div>
                                        <div class="partners-slider-item">
                                            <div class="partners-img">
                                                <img src="/uploads/{{$slider_item->image}}" alt="">
                                            </div>
                                            {{--<p>{{ $slider_item->title }}</p>--}}
                                            <a href="{{ $slider_item->url }}" target="_blank">{{ $slider_item->title }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
            @endforeach
        @endif
    @endforeach

    {{--статичный горизонтальный баннер--}}
{{--<section id="horizontally">--}}
    {{--<div class="container pos-r">--}}
        {{--<div class="horizontally-txt">--}}
            {{--<h3>Блок с одним горизонтальным баннером во всю ширину </h3>--}}
            {{--<p>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в домашних условиях.</p>--}}
            {{--<div class="horizontally-girl">--}}
                {{--<img src="images/girl.png" alt="">--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</section>--}}

@stop
