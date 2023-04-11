@extends('layouts._main')


@section('content')

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
            <section class="w3l-feature-1"  id="block{{$page_block->id}}">
                <div class="grid top-bottom mb-lg-5 pb-lg-5">
                    <div class="container">
                        <div class="middle-section grid-column text-center">
                            <div class="three-grids-columns">
                                <span class="fa fa-laptop"></span>
                                    <h3>{{ $page_block->header }}</h3>
                                    {!! $page_block->text !!}
                            </div>
                        </div>
                    </div>
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
            <section class="w3l-main-slider" id="home">
            @foreach($page_block->sliders as $slider)
                        <div class="companies20-content">
                            <div class="owl-one owl-carousel owl-theme">
                                @foreach($slider->items as $slider_item)
                                    <div class="item">
                                        <li>
                                            <div class="slider-info banner-view bg bg2" data-selector=".bg.bg2"
                                                 style="background: url('/uploads/{{$slider_item->image}}')">
                                                <div class="banner-info">
                                                    <div class="container">
                                                        <div class="banner-info-bg mx-auto text-center">
                                                            <h5>{{ $slider_item->title }}</h5>
                                                            <a class="btn btn-secondary btn-theme2 mt-md-5 mt-4"
                                                               href="{{ $slider_item->url }}">подробнее</a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </div>
                                @endforeach
                            </div>
                        </div>
            @endforeach
            </section>
        @endif
    @endforeach

    <section class="w3l-feature-3"  id="block_directs">
        <div class="grid top-bottom mb-lg-5 pb-lg-5">
            <div class="container">
                <div class="middle-section grid-column text-center">
                    @foreach($directs as $item)

                        <div class="three-grids-columns">
                            <span class="fa fa-laptop"></span>
                            <h3>{{ $item->header }}</h3>
                            {!! $item->text !!}
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </section>

@stop
