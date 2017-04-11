@extends('layouts.app')

@section('content')

    @include('partials.navigation-admin')

    <div class="container col-md-8" style="text-align: center">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"> {{ $apartment -> name }} </h3>
            </div>

            <div class="row">
                <label class="control-label">Opis</label> <br>
                <p>{{ $apartment -> description }}</p>
            </div>

            <div class="row">
                <label class="control-label">Cijena</label> <br>
                <p>{{ $apartment -> price }} {{ $apartment -> currency }}</p>
            </div>

            <div class="row">
                <label class="control-label">Napravljeno</label> <br>
                <p>{{ $apartment -> created_at -> diffForHumans() }}</p>
                <label class="control-label">Zadnja promijena</label> <br>
                <p>{{ $apartment -> updated_at -> diffForHumans() }}</p>
            </div>

            <div class="row">
                <label class="control-label">Korisnik</label> <br>
                <a href="{{ route('admin.users.user', $apartment -> user -> slug ) }}">{{ $apartment -> user -> name }}</a> <br> <br>
            </div>

            <form method="POST" action="{{ route('admin.moderator.apartment.response', $apartment->slug) }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <button type="submit" class="btn btn-success" value="Dozvoli" name="button">Dozvoli</button>
                </div>
            </form>
        </div>

        <div class="well">
            <form method="POST" action="{{ route('admin.moderator.apartment.response', $apartment->slug) }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Poruka</label>
                    <textarea id="message" name="message" placeholder="Unesi poruku korisniku..." class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-danger" value="Zabrani" name="button">Zabrani</button>
                </div>
            </form>
        </div>
    </div>



@endsection