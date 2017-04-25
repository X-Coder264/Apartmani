@extends('layouts.app')

@section('stylesheets')
    <link href="/css/bootstrap-datepicker3.standalone.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="/css/blueimp-gallery.min.css">
    <style>
        @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css);
        fieldset, label { margin: 0; padding: 0; }

        /****** Style Star Rating Widget *****/

        .rating {
            border: none;
            float: left;
        }

        .rating > input { display: none; }
        .rating > label:before {
            margin: 5px;
            font-size: 1.25em;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
            content: "\f089";
            position: absolute;
        }

        .rating > label {
            color: #ddd;
            float: right;
        }

        /***** CSS Magic to Highlight Stars on Hover *****/

        .rating > input:checked ~ label, /* show gold star when clicked */
        .rating:not(:checked) > label:hover, /* hover current star */
        .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

        .rating > input:checked + label:hover, /* hover current star when changing rating */
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
        .rating > input:checked ~ label:hover ~ label { color: #FFED85;  }
    </style>
@endsection

@section('content')

    <div class="container col-md-8 col-md-offset-2" style="text-align: center">

        <section class="content">
            @if (session('success'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
            @endif

            <h2>{{$apartment->name}}</h2>
                <h5>Korisnik: {{$apartment->user->name}}</h5>

            @if(Auth::check() && (Auth::user()->id === $apartment->user_id || Auth::user()->role->role == "Admin"))
                    <a href="{{route('apartments.edit', $apartment)}}" class="btn btn-primary">Editiraj oglas</a> <br><br>
            @endif

        {{--    @if(Auth::user()->id === $apartment->user_id || Auth::user()->role->role == "Admin")
                <form action="{{route("apartments.destroy", $apartment->slug)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit" class="btn btn-danger" name="button" value="delete">Obriši ovaj oglas</button>
                </form>
            @endif --}}

         @if($number_of_ratings)
             <div>Prosječna ocjena: {{$average_rating}}  Broj glasova: {{$number_of_ratings}}</div>
         @else
             <div>Ovaj apartman još nije ocijenjen.</div>
         @endif

        @if($apartment->main_image != "")
            <div id="blueimp-gallery-carousel" class="blueimp-gallery blueimp-gallery-carousel">
                <div class="slides"></div>
                <h3 class="title"></h3>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="play-pause"></a>
                <ol class="indicator"></ol>
            </div>
        @endif
            <div class="row well">
                <p>{{$apartment->description}}</p>
            </div>

         @if(isset($dates) && ! empty($dates))
                <div class="row">
                    <div class="col-md-6 col-md-offset-5" id="datepicker"></div>
                </div>
         @endif

        @if(Auth::check())
        <div class="row" >
            <div class="col-md-6 col-md-offset-5">
                <form method="POST" action="{{route("apartments.rate", $apartment)}}" id="rating">
                    {{ csrf_field() }}
                    <fieldset class="rating">
                        <input type="radio" id="star5" name="rating" value="5.0" @if($current_user_rated && $user_rating == 5.0) checked @endif>
                        <label class="full" for="star5" title="Savršeno - ocjena 5"></label>
                        <input type="radio" id="star4half" name="rating" value="4.5" @if($current_user_rated && $user_rating == 4.5) checked @endif>
                        <label class="half" for="star4half" title="Odlično - ocjena 4.5"></label>
                        <input type="radio" id="star4" name="rating" value="4.0" @if($current_user_rated && $user_rating == 4.0) checked @endif>
                        <label class="full" for="star4" title="Jako dobro - ocjena 4"></label>
                        <input type="radio" id="star3half" name="rating" value="3.5" @if($current_user_rated && $user_rating == 3.5) checked @endif>
                        <label class="half" for="star3half" title="Dobro - ocjena 3.5"></label>
                        <input type="radio" id="star3" name="rating" value="3.0" @if($current_user_rated && $user_rating == 3.0) checked @endif>
                        <label class="full" for="star3" title="Prosječno - ocjena 3"></label>
                        <input type="radio" id="star2half" name="rating" value="2.5" @if($current_user_rated && $user_rating == 2.5) checked @endif>
                        <label class="half" for="star2half" title="Ispodprosječno - ocjena 2.5"></label>
                        <input type="radio" id="star2" name="rating" value="2.0" @if($current_user_rated && $user_rating == 2.0) checked @endif>
                        <label class="full" for="star2" title="Loše - ocjena 2"></label>
                        <input type="radio" id="star1half" name="rating" value="1.5" @if($current_user_rated && $user_rating == 1.5) checked @endif>
                        <label class="half" for="star1half" title="Jako loše - ocjena 1.5"></label>
                        <input type="radio" id="star1" name="rating" value="1.0" @if($current_user_rated && $user_rating == 1.0) checked @endif>
                        <label class="full" for="star1" title="Užasno - ocjena 1"></label>
                        <input type="radio" id="starhalf" name="rating" value="0.5" @if($current_user_rated && $user_rating == 0.5) checked @endif>
                        <label class="half" for="starhalf" title="Katastrofa - ocjena 0.5"></label>
                    </fieldset>
                </form>
            </div>
        </div>

        <div class="row" style="text-align: center">
            <div class="col-lg-6 col-md-6 col-sm-6 col-md-offset-3">
                <form method="POST" action="{{route("comments.store", $apartment)}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="comment">Komentar</label>
                        <textarea id="comment" name="comment" placeholder="Komentar"
                                  class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Pošalji</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

            <div class="row well">
                <div class="col-lg-6 col-md-6 col-sm-6 col-md-offset-3">
                    @foreach($apartment->comments as $comment)
                        <div class="row">
                            {{$comment->comment}} - {{$comment->user->name}} - {{$comment->created_at->diffForHumans()}}
                        </div>
                    @endforeach
                </div>
            </div>

        </section>
    </div>

@endsection

@section('scripts')
    <script src="/js/blueimp-gallery.min.js"></script>

    <script>
        $('#rating input').change(function() {
            $(this).closest('form').submit();
        });
    </script>

    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('#datepicker').datepicker({
            datesDisabled: [
                @foreach($dates as $date)
                    new Date('{{$date}}'),
                @endforeach
            ]
        });</script>

    <script>
        $.ajax({
            url: '{{route('apartments.getImages', $apartment)}}',
            dataType: 'json'
        }).done(function (result) {
            var carouselLinks = [];
            $.each(result, function (index) {
                carouselLinks.push({
                    href: result[index]
                })
            });
            // Initialize the Gallery as image carousel:
            blueimp.Gallery(carouselLinks, {
                container: '#blueimp-gallery-carousel',
                carousel: true
            })
        });
    </script>

@endsection