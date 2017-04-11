@extends('layouts.app')

@section('content')

    @include('partials.navigation-admin')

    <div class="container col-md-8" style="text-align: center">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"> {{ $apartment->name }} </h3>
            </div>

            <div class="panel-body">

                    <label class="control-label">Korisnik</label> <br>
                    <a href="{{ route('admin.users.user', $apartment->user->slug ) }}">{{ $apartment->user->name }}</a> <br> <br>


                <form action="{{ route('admin.users.user.apartment.response', [$apartment -> user -> slug, $apartment->slug]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label">Opis</label>
                        <textarea id="description" name="description"  class="form-control">{{ $apartment->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price" class="control-label">Cijena (HRK)</label> <br>
                        <input id="price" name="price" type="text" class="form-control" value="{{ $apartment->price }}">
                    </div>

                    <div class="form-group">
                        <label for="county_id" class="control-label">Županija</label>
                        <select id="county_id" class="form-control" name="county_id" required>
                            @foreach($counties as $county)
                                <option value="{{$county->id}}" @if( $county->id == $apartment->county_id) selected @endif>{{$county->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="stars" class="control-label">
                            Zvijezde
                        </label>
                        <select id="stars" class="form-control" name="stars" required>
                            @for ($i = 1; $i<6; $i++)
                                <option value="{{$i}}" @if( $apartment->stars == $i) selected @endif >{{$i}}</option>
                            @endfor
                        </select>
                    </div>

                    <label class="control-label">Napravljen</label> <br>
                    <p>{{ $apartment->created_at->diffForHumans() }}</p>
                    <label class="control-label">Zadnja promjena</label> <br>
                    <p>{{ $apartment->updated_at->diffForHumans() }}</p>

                    <div class="form-group col-md-4 col-md-offset-4">
                        <button type="submit" class="btn btn-primary col-md-3" name="button" value="update">Izmijeni</button>
                        <button type="submit" class="btn btn-danger col-md-3 col-md-offset-1" name="button" value="delete">Obriši</button>
                        <button type="submit" class="btn btn-warning col-md-3 col-md-offset-1" name="button" value="block">Zabrani</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



@endsection