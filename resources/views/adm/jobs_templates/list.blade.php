@extends('adminlte::page')

@section('title', 'Templates de Vagas | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo json_encode($data->toArray()['data']);@endphp'/>

@section('content')
	<form method='GET' action='/adm/jobs-templates' id='app'>
		@csrf
	    <div class="card" check-jobs-templates-list>
	    	<div class='card-header'>
	    		<h5>Templates de Vagas</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-1">
	        			<a class="btn btn-primary" id='new' href='/adm/jobs-templates/create'>Nova</a>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-secondary" id='edit' v-on:click='edit()' type='button' v-bind:disabled='canEdit'>Editar</button>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-danger" id='destroy' v-on:click='destroy()' type='button' v-bind:disabled='canDestroy'>Excluir</button>
	        		</div>
	        		<div class="col-2">
	        			<button class="btn btn-success" id='job-from-template' v-on:click='jobFromTemplate()' type='button' v-bind:disabled='canEdit'>Nova Vaga</button>
	        		</div>
	        	</div>
				<div class='row margin-top-10'>
	        		<div class='col-lg-4'>
						<select name="filter_field" id="data-filter-field" class="form-control">
							<option value="0">Filtro de Área</option>
							@foreach($fields as $field)
								<option value="{{ $field->id }}" @if($filter_field==$field->id) selected @endif>{{ $field->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-2">
						<button class='btn btn-primary' type='submit'>Buscar</button>
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
			        				<th>Área</th>
			        				<th>Código Senior</th>
			        				<th>Código RQU Senior</th>
			        			</tr>
			        		</thead>
			        		<tbody>
                                @if($data->total()<=0)
                                    <tr><td colspan='8'>Nenhum registro encontrado</td></tr>
                                @endif
								@foreach($data as $d)
									<tr class='hoverable' v-on:click='addItem({{$d->id}})' > 
										<td style='width:40px;' for='data-check-{{$d->id}}' class='checker'>
											<input type='checkbox' v-model='selectedIds' class='selected-ids' id='data-check-{{$d->id}}' value='{{$d->id}}' name='ids[]'> </td>
										<td>{{$d->id}}</td>
										<td>{{$d->name}}</td>
										<td>{{$d->field->name}}</td>
										<td>{{$d->cod_senior}}</td>
										<td>{{$d->cod_rqu_senior}}</td>
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
