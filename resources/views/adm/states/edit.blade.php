@extends('adminlte::page')

@section('title', 'Edição de Estados | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/states/save'>
		@csrf
	    <div class="card" check-states-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Estados</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class=" col-sm-12 col-lg-1">
	        			<a class="btn btn-secondary" href='/adm/states'>Voltar</a>
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
                        <label for="data-name">Visível para Candidato?</label>
						<select name="candidate_visible" id="" class="form-control">
							<option value="0" @if ($data->candidate_visible==0) selected @endif>Não</option>
							<option value="1" @if ($data->candidate_visible==1) selected @endif>Sim</option>
						</select>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Sincronizar com Senior neste status?</label>
						<select name="sync_to_senior" id="" class="form-control">
							<option value="0" @if ($data->sync_to_senior==0) selected @endif>Não</option>
							<option value="1" @if ($data->sync_to_senior==1) selected @endif>Sim</option>
						</select>
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