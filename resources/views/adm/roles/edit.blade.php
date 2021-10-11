@extends('adminlte::page')

@section('title', 'Edição de Função | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/roles/save'>
		@csrf
	    <div class="card" check-roles-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Função</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class=" col-sm-12 col-lg-1">
	        			<a class="btn btn-secondary" href='/adm/roles'>Voltar</a>
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
                </div>
                <div class="row margin-top-10">
					<input style='margin-left:10px;' class='hide' name='permissions[]' type="checkbox" value="1" checked>
					@foreach($permissions as $permission)
						<div class="col-lg-4">
							<input style='margin-left:10px;' name='permissions[]' type="checkbox" value="{{ $permission->id }}" id="data-{{ $permission->name }}" @if(!empty($data->permissions) && in_array($permission->id,$selected_permissions)!==false) checked @endif>
							<label style='margin-left:10px;' for="data-{{ $permission->name }}">{{ $permission->desc }}</label>
						</div>
					@endforeach
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