@extends('adminlte::page')

@section('title', 'Edição de Área | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/fields/save'>
		@csrf
	    <div class="card" check-fields-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Área</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class=" col-sm-12 col-lg-1">
	        			<a class="btn btn-secondary" href='/adm/fields'>Voltar</a>
	        		</div>
	        		<div class=" col-sm-12 col-lg-1">
	        			<button class="btn btn-primary" id='save' type='submit' >Salvar</button>
	        		</div>
	        	</div>
                <div class="row margin-top-10">
                    <input type='hidden' name='id' value='{{$data->id}}'>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Nome</label>
                        <input type='text' class='form-control' name='name' value='{{$data->name}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Descrição</label>
                        <input type='text' class='form-control' name='description' value='{{$data->description}}'/>
                    </div>                    
                </div>
			</div>
		</div>
	</form>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop