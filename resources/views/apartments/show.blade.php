@extends('layouts.app')

@section('content')

    <div class="container">

        <section class="content">

        {{$apartment->name}} - {{$apartment->user->name}}

        @if(Auth::check())
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <form method="POST" action="{{route("comments.store", $apartment)}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="comment">Komentar</label>
                        <textarea id="comment" name="comment" placeholder="Komentar"
                                  class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
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