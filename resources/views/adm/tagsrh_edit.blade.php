@extends('adminlte::page')

@section('title', 'Edição de Área | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/tagsrh/save'>
		@csrf
	    <div class="card" check-tagsrh-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Tag RH</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class=" col-sm-12 col-lg-1">
	        			<a class="btn btn-secondary" href='/adm/tagsrh'>Voltar</a>
	        		</div>
	        		<div class=" col-sm-12 col-lg-1">
	        			<button class="btn btn-primary" id='save' type='submit' >Salvar</button>
	        		</div>
	        	</div>
                <div class="row margin-top-10">
                    <input type='hidden' name='id' value='{{$data->id}}'>
                    <div class=" col-sm-12 col-lg-3">
                        <label for="data-name">Nome</label>
                        <input type='text' class='form-control' name='name' value='{{$data->name}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg-1">
                        <label for="data-name">Cor</label>
                        <input type='color' class='form-control' name='color' value='{{$data->color}}'/>
                    </div>
					<div class="col-sm-12 col-lg-1">
                        <label>Cor da Fonte</label><br>
						<button type='button' style='background-color:{{$data->color}}'><b style='color:{{$data->fontcolor}}'>ABC</b></button>
					</div>
                </div>
				<div class="row margin-top-10">
					<div class="col">
						<small>*A cor da fonte se ajustará automaticamente ao salvar a TAG.</small>
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