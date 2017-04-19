@extends('layouts.app')

@section('stylesheets')
    <link href="/css/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="/css/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}" />
@endsection

@section('content')

    <div class="container">

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Add new apartment
                        </h3>
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Naslov oglasa</label>
                                <input id="name" name="name" type="text"
                                       placeholder="Name" class="form-control required"
                                       value="{!! old('name') !!}" required>
                            </div>

                            <div class="form-group">
                                <label for="county_id" class="col-sm-2 control-label">Županija</label>
                                <select id="county_id" class="form-control" name="county_id" required>
                                    @foreach($counties as $county)
                                        <option value="{{$county->id}}">{{$county->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">Cijena (HRK)</label>
                                    <input id="price" name="price" placeholder="Cijena" type="number" step="0.1"
                                           class="form-control required email" value="{!! old('price') !!}" required>
                            </div>

                            <div class="form-group">
                                <label for="stars" class="control-label">
                                    Koliko zvjezdica ima Vaš apartman?
                                </label>
                                <select id="stars" class="form-control" name="stars" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Opis</label>
                                <textarea id="description" name="description" placeholder="Opis"
                                          class="form-control required" required></textarea>
                            </div>

                            <div class="form-group" id="dates">
                                <label class="control-label">Razdoblje zauzetosti apartmana: </label> <br>
                                <input class="form-control" type="text" name="daterange[]" style="text-align: center">
                                <div class="btn-group pull-right">
                                    <span class="btn btn-default btn-md" id="addBtn">Dodaj polje</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>Prva slika će biti glavna slika apartmana, a ostale slike će se vidjeti u oglasu u galeriji slika.</div>
                                <label class="control-label">Odaberite slike</label>
                                <input type="file" name="images[]" id="filer_input" accept="image/*" multiple>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>

                            </form></div>
                </div>
            </div>
        </div>

    </section>
</div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('input[name="daterange[]"]').daterangepicker({
                "showDropdowns": true,
                "locale": {
                    "format": "DD.MM.YYYY"
                }
            });
        });
    </script>
    <script src="/js/jquery.filer.min.js"></script>
    <script>
        var x = 1;
        $(document).ready(function() {
            $("#addBtn").click(function(){
                $("#dates").append('<div><input class="form-control" type="text" name="daterange[]" id="daterange' + x + '" style="text-align: center"><td><span class="btn btn-danger btn-md center-block" id="removeBtn">Izbriši</span></div>');
                $('#daterange' + x++ + '').daterangepicker({
                    "showDropdowns": true,
                    "locale": {
                        "format": "DD.MM.YYYY"
                    }
                });
            });

            $("#dates").on('click','#removeBtn',function(){
                $(this).parent().remove();
            });

            $('#filer_input').filer({
                limit: 10,
                maxSize: 8,
                extensions: ["jpg", "jpeg", "png", "gif"],
                showThumbs: true,
                addMore: true,
                changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-folder"></i></div><div class="jFiler-input-text"><h3>Kliknite ovdje</h3> <span style="display:inline-block; margin: 15px 0">ili</span></div><a class="jFiler-input-choose-btn btn-custom blue-light">Birajte slike</a></div></div>',
                theme: "dragdropbox",
                templates: filer_default_opts.templates,
                captions: {
                    button: "Odaberi slike",
                    feedback: "Odaberi slike",
                    feedback2: "slike su odabrane",
                    removeConfirmation: "Jeste li sigurni da želite obrisati ovu sliku?",
                    errors: {
                        filesLimit: "Možete uploadati najviše 10 slika po apartmanu.",
                        filesType: "Samo .jpg, .jpeg, .png i .gif slike su dopuštene.",
                        filesSize: "Slika je prevelika. Najveća veličina pojedine slike je 5 MB.",
                        filesSizeAll: "Files you've choosed are too large! Please upload files up to 5 MB."
                    }
                }
            });
        });
    </script>

@endsection