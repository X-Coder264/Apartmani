@extends('layouts.app')

@section('content')

    @include('partials.navigation-admin')

    <div class="container col-md-8">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"> {{ $user -> name }} </h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('admin.users.user.response', $user -> slug ) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}


                    <label class="control-label">E-mail</label> <br>
                    <input id="email" name="email" type="text" placeholder="{{ $user -> email }}" class="form-control" value="{{ $user -> email }}">

                    <div class="form-group">
                        <label for="role" class="control-label">
                            Odaberi ulogu
                        </label>
                        <select id="role" class="form-control" name="role" required>
                            <option value="2" @if( $user -> role ->role == "User") selected @endif  >Korisnik</option>
                            <option value="3" @if( $user -> role ->role == "Client") selected @endif >Klijent</option>
                            <option value="1" @if( $user -> role ->role == "Admin") selected @endif >Admin</option>
                        </select>
                    </div>

                    <label class="control-label">Napravljen</label> <br>
                    <p>{{ $user -> created_at -> diffForHumans() }}</p>
                    <label class="control-label">Zadnja promjena</label> <br>
                    <p>{{ $user -> updated_at -> diffForHumans() }}</p>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Izmijeni</button>
                    </div>

                </form>


            </div>
        </div>
    </div>
    </div>

    <div class="container col-md-8 col-md-offset-3" style="text-align: center">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"> Aktivni oglasi </h3>
            </div>

            <div id="users-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer ">

                <div class="panel-body flip-scroll">
                    <table class="table table-bordered table-hover flip-content" id="active-ads-table">
                        <thead>
                        <tr class="filters">
                            <th>Id</th>
                            <th>Ime</th>
                            <th>Opis</th>
                            <th>Datum</th>
                            <th>Opcije</th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>

    <div class="container col-md-8 col-md-offset-3" style="text-align: center">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"> Neaktivni oglasi </h3>
            </div>

            <div id="users-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer ">

                <div class="panel-body flip-scroll">
                    <table class="table table-bordered table-hover flip-content" id="inactive-ads-table">
                        <thead>
                        <tr class="filters">
                            <th>Id</th>
                            <th>Ime</th>
                            <th>Opis</th>
                            <th>Datum</th>
                            <th>Opcije</th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <div class="container col-md-8 col-md-offset-3" style="text-align: center">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"> Zabranjeni oglasi </h3>
            </div>

            <div id="users-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer ">

                <div class="panel-body flip-scroll">
                    <table class="table table-bordered table-hover flip-content" id="banned-ads-table">
                        <thead>
                        <tr class="filters">
                            <th>Id</th>
                            <th>Ime</th>
                            <th>Opis</th>
                            <th>Datum</th>
                            <th>Opcije</th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.js') }}" ></script>

    <script>
        $(function() {
            $('#active-ads-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.datatable.ads', ['user' => $user->slug ,'adType' => 1]) }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

        });

        $(function() {
            $('#inactive-ads-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.datatable.ads', ['user' => $user->slug ,'adType' => 2]) }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

        });

        $(function() {
            $('#banned-ads-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.datatable.ads', ['user' => $user->slug ,'adType' => -1]) }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

        });

    </script>


@endsection