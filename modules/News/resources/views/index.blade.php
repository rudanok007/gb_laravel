@include("core::template.inner")

@section('content')
    <div class="wrapper">
        <div class="container">

            <div class="title">
                <h1>Новостной портал</h1>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    @foreach($news as $item)
                        <div class="col-lg-4">
                            <div class="card">
                                <a href="{{ url("/get_news", ['id' => $item['id']]) }}">
                                <div class="card-title">{{$item['title']}}</div>
                                <div class="card-small-text">{{$item['small-text']}}</div>
                                <div class="card-img"><img src="img/{{$item['img']}}" style="width: 100%" alt=""></div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>

        </div>
    </div>
