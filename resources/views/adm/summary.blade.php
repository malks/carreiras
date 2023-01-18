@extends('adminlte::page')

@section('title', 'Edição de Área | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/summary'>
		@csrf
	    <div class="card" check-tagsrh-edit>
	    	<div class='card-header'>
	    		<h5>Resumos</h5>
	    	</div>
	        <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="row margin-top-10">
                            <div class="col-sm-12 col-lg-6">
                                <label for="data-start">Início do Período:</label>
                                <input type="date" class="form-control" id='period-start' name='period_start' value='{{$period_start}}'>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label for="data-end">Fim do Período:</label>
                                <input type="date" class="form-control" id='period-end' name='period_end' value='{{$period_end}}'>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-secondary margin-top-40" >Buscar</button>
                    </div>
                </div>
			</div>
		</div>
	</form>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2">
                    <label for="">Total de cadastros novos no período:</label>
                </div>
                <div class="col-lg-9">
                    {{$registered}}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <label for="">Média de cadastros diários no período:</label>
                </div>
                <div class="col-lg-9">
                    {{$average}}
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2">
                    <label for="">Cadastros novos no período por dia:</label>
                </div>
            </div>
            <div class="row">
                @php
                    $c=0;
                @endphp
                <div class="col-lg-3 margin-top-30">
                    <table class='table striped'>
                        <tbody>
                            @foreach($daily as $day)
                                <tr>
                                    <th>{{implode("/",array_reverse(explode("-",$day->day)))}}</th>
                                    <td>{{$day->data}}</td>
                                </tr>
                                @php $c++; @endphp
                                @if($c>=12)
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-3 margin-top-30">
                                        <table class='table'>
                                            <tbody>
                                    @php $c=0; @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop