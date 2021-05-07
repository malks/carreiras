@extends('adminlte::page')

@section('title', 'Edição de Área | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/candidates/save'>
		@csrf
	    <div class="card" check-candidates-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Unidade</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class=" col-sm-12 col-lg-1">
	        			<a class="btn btn-secondary" href='/adm/candidates'>Voltar</a>
	        		</div>
	        		<div class=" col-sm-12 col-lg-1">
	        			<button class="btn btn-primary" id='save' type='submit' >Salvar</button>
	        		</div>
	        	</div>
                <div class="row margin-top-20">
                    <div class=" col-sm-12 col-lg">
                        <i>Última Atualização:</i><i style='margin-left:10px;'> {{$data->updated_at}}</i>
                    </div>
                </div>
                <div class="row margin-top-20">
                    <input type='hidden' name='id' value='{{$data->id}}'>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Nome</label>
                        <input type='text' class='form-control' name='name' id='data-name' value='{{$data->name}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-dob">Data de Nascimento</label>
                        <input type='text' class='form-control' id='data-dob' name='dob' value='{{$data->dob}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-cpf">CPF</label>
                        <input type='text' class='form-control' id='data-cpf' name='cpf' value='{{$data->cpf}}'/>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-phone">Fone</label>
                        <input type='text' class='form-control' id='data-phone' name='phone' value='{{$data->phone}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-address">Endereço</label>
                        <input type='text' class='form-control' name='address' id='data-address' value='{{$data->address}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-zip">CEP</label>
                        <input type='text' class='form-control' name='zip' id='data-zip' value='{{$data->zip}}'/>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-city">Cidade</label>
                        <input type='text' class='form-control' id='data-city' name='city' value='{{$data->city}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-state">Estado</label>
                        <input type='text' class='form-control' id='data-state' name='state' value='{{$data->state}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-country">País</label>
                        <input type='text' class='form-control' id='data-country' name='country' value='{{$data->country}}'/>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <div class=" col-sm-12 col-lg">
                            <a href='{{$data->cv}}' target='_blank'>Ver Curriculum Atualizado</a>
                        </div>
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