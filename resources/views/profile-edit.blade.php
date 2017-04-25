@extends('layouts.app')

@section('content')

    <div class="container col-md-12" style="text-align: center">

        <div class="panel panel-info">
            @if (session('success'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="panel-heading">
                <h3 class="panel-title"> {{ $user->name }} </h3>
            </div>

            <div class="panel-body">
                <form action="{{ route("profile.update", $user) }}" method="POST">
                    {{ csrf_field() }}
                    {{method_field('PUT')}}

                    <div class="form-group">
                        <label for="name" class="control-label">Korisničko ime</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{ $user->name }}">
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">Email</label> <br>
                        <input id="email" name="email" type="email" class="form-control" value="{{ $user->email }}">
                    </div>

                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary" name="button" value="update">Izmijeni</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



@endsection