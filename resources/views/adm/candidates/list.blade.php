@extends('adminlte::page')

@section('title', 'Candidatos | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo json_encode($data_list);@endphp'/>

@section('content')
	<form method='GET' action='/adm/candidates' id='app'>
		@csrf
	    <div class="card" check-candidates-list>
	    	<div class='card-header'>
	    		<h5>Candidatos</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-1">
	        			<a class="btn btn-primary" id='new' href='/adm/candidates/create'>Novo</a>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-secondary" id='edit' v-on:click='edit()' type='button' v-bind:disabled='canEdit'>Editar</button>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-danger" id='destroy' v-on:click='destroy()' type='button' v-bind:disabled='canDestroy'>Excluir</button>
	        		</div>

	        	</div>
                <div class="row margin-top-10">
                    <div class="col-sm-12 col-lg-3">
                        <label for="data-start">Início Última Atualização:</label>
                        <input type="date" class="form-control" id='data-start' name='filter_updated_at_start' value='{{$filter_updated_at_start}}'>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <label for="data-end">Fim Última Atualização:</label>
                        <input type="date" class="form-control" id='data-end' name='filter_updated_at_end' value='{{$filter_updated_at_end}}'>
                    </div>
					<div class="col-sm-12 col-lg-2 margin-top-30">
						<button class="btn btn-primary" type='submit'>Buscar</button>
					</div>
                </div>

	        	<div class='row margin-top-10'>
	        		<div class='col'>
	        			<input class='form-control' placeholder='Busca...' id='search' name='search' @if(!empty($search)) value='{{$search}}' @endif>
	        		</div>
	        	</div>
	        	<div class='row margin-top-10'>
	        		<div class='col-lg-12 table-responsive'>
			        	<table class='table table-bordered dataTable'>
			        		<thead>
			        			<tr>
									<th style='width:40px;'><input type='checkbox' id='check-all' v-on:click='reverseSelection()'></th>
			        				<th>Id</th>
			        				<th>Nome</th>
			        				<th>Cidade</th>
			        				<th>Estado</th>
			        				<th>Última Atualização</th>
			        				<th>Candidaturas</th>
			        				<th>Última Candidatura</th>
			        			</tr>
			        		</thead>
			        		<tbody>
                                @if($data->total()<=0)
                                    <tr><td colspan='3'>Nenhum registro encontrado</td></tr>
                                @endif
								@foreach($data as $d)
									<tr class='hoverable' v-on:click='addItem({{$d->id}})' > 
										<td style='width:40px;' for='data-check-{{$d->id}}' class='checker'>
											<input type='checkbox' v-model='selectedIds' class='selected-ids' id='data-check-{{$d->id}}' value='{{$d->id}}' name='ids[]'> </td>
										<td>{{$d->id}}</td>
										<td>{{$d->name}}</td>
										<td>{{$d->address_city}}</td>
										<td>{{$d->address_state}}</td>
										<td>{{(!empty($d->updated_at)) ? date_format($d->updated_at,'d/m/Y') : ''}}</td>
										<td>{{$d->subscription_amount}}</td>
										<td>{{(!empty($d->subscriptions[0]->created_at)) ? date_format($d->subscriptions[0]->created_at,'d/m/Y') : ''}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class='row'>
					<div class='col-lg-12'>
						<div style='float:left;line-height:35px;'>
							Exibindo {{$data->firstItem()}} a {{$data->total()/max(1,$data->currentPage())}} de {{$data->total()}}
						</div>
						<div style='float:right;'>
							{{$data->withQueryString()->links()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@stop


@section('adminlte_js')
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
