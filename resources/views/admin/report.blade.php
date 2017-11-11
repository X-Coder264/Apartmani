@extends('layouts.app')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}" />
@endsection

@section('content')
<div class="row">
    @include('partials.navigation-admin')

    <div class="container col-md-8">
    <div class="container">
        <h1>Statistike</h1>

        <p>Prikazuje se stvoreni broj korisnika ili apartmana za odabrano razdoblje.</p>
        <p>Za dane nema smisla birati raspon veći od mjesec dana ili za mjesece veći od godinu dana. U suprotnome će se zbrojiti isti mjeseci iz razlićitih godina</p>

        <canvas id="daily-reports" width="300" height="100"></canvas>

    </div>

    <div class="container well" style="text-align: center">
            <form action="{{ route('admin.report.filter') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="control-label">Razdoblje: </label> <br>
                    <input class="form-control" type="text" name="daterange" value="{{$dateStart}} - {{$dateEnd}}" style="text-align: center" />
                </div>

                <div class="form-group">
                    <label for="role" class="control-label">
                        Podaci
                    </label>
                    <select id="role" class="form-control" name="data" required style="text-align: center">
                        <option value="Apartment" @if( $data == "Apartment") selected @endif>Apartmani</option>
                        <option value="User" @if( $data == "User") selected @endif>Korisnici</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="role" class="control-label">
                        Raspon
                    </label>
                    <select id="role" class="form-control" name="range" required style="text-align: center">
                        <option value="YEAR" @if( $rangeType == "YEAR") selected @endif>Godine</option>
                        <option value="MONTH" @if( $rangeType == "MONTH") selected @endif>Mjeseci</option>
                        <option value="DAY" @if( $rangeType == "DAY") selected @endif>Dani</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Prikaži</button>
                </div>

            </form>
    </div>

    <br> <br> <br>
    <div class="container  well">
        <h3 style="text-align: center">Tablični prikaz grafa</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ $rangeType }}</th>
                    <th>NUMBER</th>
                </tr>
            </thead>
        @foreach($range as $i => $ran)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>@if($rangeType == "MONTH"){{ date("F", mktime(0, 0, 0, $ran, 1)) }}@else{{ $ran }}@endif</td>
                    <td>{{ $number[$i] }}</td>
                </tr>
        @endforeach
        </table>

    </div>
    </div>
</div>
@stop


@section('scripts')

    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                "showDropdowns": true,
                "locale": {
                    "format": "DD.MM.YYYY"
                }
            });
        });
    </script>

    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
        (function() {
            var ctx = document.getElementById('daily-reports').getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {{ json_encode($range) }},
                    datasets: [{
                        data: {{ json_encode($number) }},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });


        })();
    </script>

@endsection