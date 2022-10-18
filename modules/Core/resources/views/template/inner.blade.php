@extends('core::template.base')

@section('body')
    {{--    <div id="wrapper">--}}
    <div class="container-fluid">
        <div class="row">
            <div class="menu panel-group">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Курсы Laravel</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <a class="nav-link active" aria-current="page" href="{{ route('main') }}">Главная</a>
                                <a class="nav-link" href="{{ route('news') }}">Новости</a>
                                <a class="nav-link" href="{{ route('about') }}">О нас</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="container content panel-group">
    @yield('content')
    </div>
