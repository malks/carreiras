@extends('adminlte::page')

@section('title', 'Destinatários | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo json_encode($data->toArray()['data']);@endphp'/>

@section('content')
	<div id='addhelp-contacts-modal' class="modal hide" tabindex="-1">
		<form action="/adm/help-contacts/create" method='POST'>
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Novo Destinatário</h5>
						<button type="button" class="btn-close"  onclick="$('#addhelp-contacts-modal').hide()" data-bs-dismiss="modal" aria-label="Close">X</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col">
								@csrf
								<label for="">Destinatário:</label>
								<input type="text" name='email' class='form-control'>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" type='submit'>Salvar</button>
						<button class="btn btn-danger" type='button' onclick="$('#addhelp-contacts-modal').hide()">Fechar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<form method='GET' action='/adm/help-contacts' id='app'>
		@csrf
	    <div class="card" check-help-contacts-list>
	    	<div class='card-header'>
	    		<h5>Destinatários</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-1">
	        			<button type='button' class="btn btn-primary" id='new' onclick="$('#addhelp-contacts-modal').show()">Novo</button>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-secondary" id='toggle' v-on:click='toggle()' type='button' v-bind:disabled='canDestroy'>Alterar Status</button>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-danger" id='destroy' v-on:click='destroy()' type='button' v-bind:disabled='canDestroy'>Excluir</button>
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
			        				<th>Email</th>
			        				<th>Status</th>
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
										<td>{{$d->email}}</td>
										<td>{{$active_inactive[$d->status]}}</td>
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
