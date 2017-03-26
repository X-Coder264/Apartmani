@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="panel-group" id="accordionNo">
                <div class="panel panel-default has-tree">
                    <div id="collapseCategory" class="panel-collapse collapse in">
                        <div class=" " id="main_nav">

                        </div>
                    </div>
                </div>
                                    <form method="get">
                                        @foreach($_GET as $key => $value)
                                            @if($key == 'orderBy' || $key == 'numberPerPage')
                                                <input type="hidden" name="{{$key}}" value="{{$value}}">
                                            @endif
                                        @endforeach
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="collapseWill active" data-toggle="collapse" href="#collapsePrice">OPCIJE FILTRIRANJA
                                                        <span class="pull-left">
                                                            <i class="fa fa-caret-right"></i>
                                                        </span>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapsePrice" class="panel-collapse collapse in">
                                                <div class="panel-body priceFilterBody form-inline">
                                                    <p>Unesite raspon cijena</p>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="exampleInputEmail2" name="startPrice" placeholder="100"
                                                                   @if(isset($_GET['startPrice']) && is_numeric($_GET['startPrice']))
                                                                   value="{{$_GET['startPrice']}}"
                                                                    @endif>
                                                        </div>
                                                        <div class="form-group sp">do</div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="exampleInputPassword2" name="endPrice" placeholder="500"
                                                                   @if(isset($_GET['endPrice']) && is_numeric($_GET['endPrice']))
                                                                   value="{{$_GET['endPrice']}}"
                                                                    @endif>
                                                        </div>
                                                    <div>
                                                        <div>
                                                            <p>Županija: </p>
                                                        </div>
                                                        <div>
                                                            <select class="form-control" name="county">
                                                                <option
                                                                        @if((isset($_GET['county']) && $_GET['county'] == 0) || ! isset($_GET['county']))
                                                                        selected="selected"
                                                                        @endif value="0">Sve županije</option>
                                                                @foreach($counties as $county)
                                                                    <option
                                                                            @if(isset($_GET['county']) && $_GET['county'] == $county->id)
                                                                            selected="selected"
                                                                            @endif value="{{$county->id}}">{{$county->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div>
                                                            <p>Broj zvjezdica: </p>
                                                        </div>
                                                        <div>
                                                            <select class="form-control" name="stars">
                                                                <option
                                                                        @if((isset($_GET['stars']) && $_GET['stars'] == 0) || ! isset($_GET['stars']))
                                                                        selected="selected"
                                                                        @endif value="0">Nebitno (svi apartmani)</option>
                                                                <option @if(isset($_GET['stars']) && $_GET['stars'] == 1)
                                                                        selected="selected"
                                                                @endif value="1">1</option>
                                                                <option @if(isset($_GET['stars']) && $_GET['stars'] == 2)
                                                                        selected="selected"
                                                                        @endif value="2">2</option>
                                                                <option @if(isset($_GET['stars']) && $_GET['stars'] == 3)
                                                                        selected="selected"
                                                                        @endif value="3">3</option>
                                                                <option @if(isset($_GET['stars']) && $_GET['stars'] == 4)
                                                                        selected="selected"
                                                                        @endif value="4">4</option>
                                                                <option @if(isset($_GET['stars']) && $_GET['stars'] == 5)
                                                                        selected="selected"
                                                                        @endif value="5">5</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary pull-left" style="margin: 10px 0">FILTRIRAJ</button>
                                    </form>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12">
                                <form method="get">
                                    @foreach($_GET as $key => $value)
                                        @if($key == 'startPrice' || $key == 'endPrice' || $key = 'county' || $key = 'stars')
                                            <input type="hidden" name="{{$key}}" value="{{$value}}">
                                        @endif
                                    @endforeach
                                    <div class="w100 productFilter clearfix">
                                        <div style="padding-bottom: 10px;" class="row">
                                            <div class="col-xs-6 col-sm-5 col-md-5 col-lg-4 pull-left">
                                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-4 pull-left">
                                                    <p>Sortiraj: </p>
                                                </div>
                                                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-left">
                                                    <select class="form-control" name="orderBy" onchange="this.form.submit()">
                                                        <option
                                                                @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 0)
                                                                selected="selected"
                                                                @endif value="0">najnoviji</option>
                                                        <option
                                                                @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 1)
                                                                selected="selected"
                                                                @endif value="1">najstariji</option>
                                                        <option
                                                                @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 2)
                                                                selected="selected"
                                                        @endif value="2">s višom cijenom</option>
                                                        <option
                                                                @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 3)
                                                                selected="selected"
                                                        @endif value="3">s nižom cijenom</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-5 col-md-5 col-lg-4 pull-right">
                                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-4 pull-left">
                                                    <p>Prikaži: </p>
                                                </div>
                                                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-7 pull-right">
                                                    <select class="form-control" name="numberPerPage" onchange="this.form.submit()">
                                                        <option
                                                                @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 12)
                                                                selected="selected"
                                                                @endif value="12">12 proizvoda</option>
                                                        <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 24)
                                                                selected="selected"
                                                                @endif value="24">24 proizvoda</option>
                                                        <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 36)
                                                                selected="selected"
                                                                @endif value="36">36 proizvoda</option>
                                                        <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 48)
                                                                selected="selected"
                                                                @endif value="48">48 proizvoda</option>
                                                        <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 0)
                                                                selected="selected"
                                                                @endif value="0">sve proizvode</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
            @foreach ($apartments as $apartment)
                <div>
                {{ $apartment->name }}
                </div>
            @endforeach
            @if(!isset($_GET['numberPerPage']) || (isset($_GET['numberPerPage']) && $_GET['numberPerPage'] != 0))
                <div class="w100 categoryFooter">
                    {{ $apartments->appends($_GET)->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
