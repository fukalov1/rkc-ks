@extends('layouts.layout')


@section('content')
    <div id="app">
    <section class="w3l-about-breadcrum">
        <div class="breadcrum-bg py-sm-5 py-4">
            <div class="container py-lg-3">
                <h2>Личный кабинет</h2>
                <p><a href="/">Главная</a> &nbsp; / &nbsp; Личный кабинет</p>
            </div>
        </div>
    </section>
    <!-- content-with-photo4 block -->
    <section class="w3l-content-with-photo-4">
        <div id="content-with-photo4-block" class="pt-5">
            <div class="container py-md-5">
                <div class="cwp4-two row">

                    <div class="cwp4-text col-lg-12">

                        <client-component
                            :qr_auth="{{ $qr_auth }}"
                            :check_day_start="{{ $check_day_start }}"
                            :check_day_end="{{ $check_day_end }}"
                        />


                    </div>

                </div>
            </div>
        </div>
    </section>
    </div>
@stop
