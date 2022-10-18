@extends('core::template.inner')

@section('header')
    @if (array_key_exists('title', View::getSections()))
        <nav class="navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <h1 class="title-page">@yield('title')</h1>
            </div>
        </nav>
    @endif
@endsection

@section('content')
    <div class="row border-bottom white-bg">
        @yield('header')
    </div>
    @if (array_key_exists('before-content', View::getSections()))
        @yield('before-content')
    @endif
    @if (array_key_exists('module-content', View::getSections()))
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">

                            @yield('module-content')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (array_key_exists('after-content', View::getSections()))
        @yield('after-content')
    @endif
@endsection
