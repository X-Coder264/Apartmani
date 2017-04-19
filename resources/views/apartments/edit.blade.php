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
                <h3 class="panel-title"> {{ $apartment->name }} </h3>
            </div>

            <div class="panel-body">
                <form action="{{ route("apartments.update", $apartment) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="description" class="control-label">Opis</label>
                        <textarea id="description" name="description"  class="form-control">{{ $apartment->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price" class="control-label">Cijena (HRK)</label> <br>
                        <input id="price" name="price" type="number" step="0.1" class="form-control" value="{{ $apartment->price }}">
                    </div>

                    <div class="form-group">
                        <label for="county_id" class="control-label">Županija</label>
                        <select id="county_id" class="form-control" name="county_id" required>
                            @foreach($counties as $county)
                                <option value="{{$county->id}}">{{$county->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="stars" class="control-label">
                            Zvijezde
                        </label>
                        <select id="stars" class="form-control" name="stars" required>
                            @for ($i = 1; $i < 6; $i++)
                                <option value="{{$i}}" @if( $apartment->stars == $i) selected @endif >{{$i}}</option>
                            @endfor
                        </select>
                    </div>

                    <label class="control-label">Napravljen</label> <br>
                    <p>{{ $apartment->created_at->diffForHumans() }}</p>
                    <label class="control-label">Zadnja promjena</label> <br>
                    <p>{{ $apartment->updated_at->diffForHumans() }}</p>

                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary" name="button" value="update">Izmijeni</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



@endsection