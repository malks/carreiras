@extends('adminlte::page')

@section('title', 'Edição de Unidades | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/units/save'>
		@csrf
	    <div class="card" check-units-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Unidade</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-lg-1 col-sm-12">
	        			<a class="btn btn-secondary" href='/adm/units'>Voltar</a>
	        		</div>
	        		<div class="col-lg-1 col-sm-12">
	        			<button class="btn btn-primary" id='save' type='submit' >Salvar</button>
	        		</div>
	        	</div>
                <div class="row margin-top-10">
                    <input type='hidden' name='id' value='{{$data->id}}'>
                    <div class="col-lg col-sm-12">
                        <label for="data-name">Nome</label>
                        <input type='text' class='form-control' name='name' value='{{$data->name}}'/>
                    </div>
                    <div class="col-lg col-sm-12">
                        <label for="data-name">Endereço</label>
                        <input type='text' class='form-control' name='address' value='{{$data->address}}'/>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-lg col-sm-12">
                        <label for="data-name">Cidade</label>
                        <input type='text' class='form-control' name='city' value='{{$data->city}}'/>
                    </div>
                    <div class="col-lg col-sm-12">
                        <label for="data-name">Estado</label>
                        <input type='text' class='form-control' name='state' value='{{$data->state}}'/>
                    </div>
                    <div class="col-lg col-sm-12">
                        <label for="data-name">País</label>
                        <input type='text' class='form-control' name='country' value='{{$data->country}}'/>
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