@extends('layouts.app')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.css') }}" />
@endsection

@section('content')

    <div class="container">

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
            @if (session('error'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            Korisničko ime: {{$user->name}} <br>
                            Email: {{$user->email}} <br>
                            Registriran: {{$user->created_at}} <br>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="text-align: center">

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Aktivni i validirani oglasi</h3>
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
            </div>

            <div class="row">
                <div class="col-md-12" style="text-align: center">

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Neaktivni oglasi</h3>
                        </div>

                        <div id="users-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

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
            </div>

            <div class="row">
                <div class="col-md-12" style="text-align: center">

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Oglasi koji čekaju validaciju</h3>
                        </div>

                        <div id="users-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                            <div class="panel-body flip-scroll">
                                <table class="table table-bordered table-hover flip-content" id="awaiting-validation-ads-table">
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
            </div>

        </section>
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
                ajax: '{{ route('user.apartments.datatable', ['user' => $user->slug ,'type' => 1]) }}',
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
                ajax: '{{ route('user.apartments.datatable', ['user' => $user->slug , 'type' => 2]) }}',
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
            $('#awaiting-validation-ads-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.apartments.datatable', ['user' => $user->slug , 'type' => 0]) }}',
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