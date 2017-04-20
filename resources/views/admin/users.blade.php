@extends('layouts.app')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.css') }}" />
@endsection

@section('content')

    <div class="row">

        @include('partials.navigation-admin')

        <div class="col-md-8">

            <h3>Korisnici</h3>

            <div id="users-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer ">

                <div class="panel-body flip-scroll">
                    <table class="table table-bordered table-hover flip-content" id="users-table">
                        <thead>
                        <tr class="filters">
                            <th>Id</th>
                            <th>Ime</th>
                            <th>E-mail</th>
                            <th>Role</th>
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

@stop


@section('scripts')

    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.js') }}" ></script>

    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route ('admin.users.datatable')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'role.role', name: 'role.role'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

        });

    </script>

@endsection