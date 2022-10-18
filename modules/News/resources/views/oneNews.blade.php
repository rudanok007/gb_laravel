@include("core::template.inner")

@section('content')
    <div class="wrapper">
        <div class="container">

            <div class="title">
                <h1>{{ $oneNews['title'] }}</h1>
            </div>

            <div class="col-lg-12">
                <div class="card-small-text">
                    {{ $oneNews['small-text']}}
                </div>
                    <div class="card-big-text">
                    {{ $oneNews['big-text'] }}
                    </div>
                            </div>

                </div>
            </div>


