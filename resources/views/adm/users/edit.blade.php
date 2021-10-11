@extends('adminlte::page')

@section('title', 'Edição de Usuário | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/users/save'>
		@csrf
	    <div class="card" check-users-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Usuário</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-lg-1 col-sm-12">
	        			<a class="btn btn-secondary" href='/adm/users'>Voltar</a>
	        		</div>
	        		<div class="col-lg-1 col-sm-12">
	        			<button class="btn btn-primary" id='save' type='submit' >Salvar</button>
	        		</div>
	        	</div>
                <div class="row margin-top-10">
                    <div class="col-lg-4">
                        <label for="">Função</label>
                        <select name="role" id="user-role" class='form-control'>
                            @foreach($roles as $role)
                            <option value=" {{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <input type='hidden' name='id' value='{{$data->id}}'>
                    <div class="col-lg col-sm-12">
                        <label for="data-name">Nome</label>
                        <input type='text' class='form-control' name='name' value='{{$data->name}}'/>
                    </div>
                    <div class="col-lg col-sm-12">
                        <label for="data-email">Email</label>
                        <input type='text' class='form-control' name='email' value='{{$data->email}}'/>
                    </div>
                    <div class="col-lg col-sm-12">
                        <label for="data-password">Senha</label>
                        <input type='password' class='form-control' name='password' value=''/>
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