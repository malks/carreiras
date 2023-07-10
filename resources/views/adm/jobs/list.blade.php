@extends('adminlte::page')

@section('title', 'Vagas | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo urlencode(json_encode($data->toArray()['data']));@endphp'/>

@section('content')
	<form method='GET' action='/adm/jobs' id='app'>
		@csrf
	    <div class="card" check-jobs-list>
	    	<div class='card-header'>
	    		<h5>Vagas</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-1">
	        			<a class="btn btn-primary" id='new' href='/adm/jobs/create'>Nova</a>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-secondary" id='edit' v-on:click='edit()' type='button' v-bind:disabled='canEdit'>Editar</button>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-danger" id='destroy' v-on:click='destroy()' type='button' v-bind:disabled='canDestroy'>Excluir</button>
	        		</div>
	        		<div class="col-2">
	        			<button class="btn btn-success" id='job-from-template' v-on:click='templateFromJob()' type='button' v-bind:disabled='canEdit'>Criar Template</button>
	        		</div>
	        	</div>
	        	<div class='row margin-top-30'>
					<div class="col-lg-3">
						<input type="checkbox" value='1' name='filter_status[]' @if(in_array('1',$filter_status)) checked @endif>
						<label style='margin-left:5px' for="">Ativas</label>
					</div>
					<div class="col-lg-3">
						<input type="checkbox" value='0' name='filter_status[]' @if(in_array('0',$filter_status)) checked @endif >
						<label style='margin-left:5px' for="">Inativas</label>
					</div>
				</div>
				<div class='row margin-top-10'>
					<div class="col-lg-3">
						<label for="">
							Data de Criação Início:
						</label>
						<input type="date" class="form-control" name='filter_created_at_start' value='{{$filter_created_at_start}}'>
					</div>
					<div class="col-lg-3">
						<label for="">
							Data de Criação Fim:
						</label>
						<input type="date" class="form-control" name='filter_created_at_end' value='{{$filter_created_at_end}}'>
					</div>
					<div class="col-lg-1 margin-top-30">
						<button class='btn btn-primary' type='submit'>Buscar</button>
					</div>
				</div>
				<div class="row margin-top-10">
					<div class="col-lg-3">
						<select name="filter_unit" id="filter-unit" class="form-control">
							<option value="0">Filtrar Unidade</option>
							@foreach($units as $unit)
								<option value="{{$unit->id}}" @if($unit->id==$filter_unit) selected @endif>{{$unit->name}}</option>
							@endforeach
						</select>
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
			        				<th>Unidade</th>
			        				<th>Data de Criação</th>
			        				<th>Código Senior</th>
			        				<th>Código RQU Senior</th>
			        				<th>Status</th>
			        			</tr>
			        		</thead>
			        		<tbody>
                                @if($data->total()<=0)
                                    <tr><td colspan='8'>Nenhum registro encontrado</td></tr>
                                @endif
								@foreach($data as $d)
									<tr class='hoverable' v-on:click='addItem({{$d}})' > 
										<td style='width:40px;' for='data-check-{{$d->id}}' class='checker'>
											<input type='checkbox' v-model='selectedIds' class='selected-ids' id='data-check-{{$d->id}}' value='{{$d->id}}' name='ids[]'> </td>
										<td>{{$d->id}}</td>
										<td>{{$d->name}}</td>
										<td>{{ (!empty($d->unit)) ? $d->unit->name : ''}}</td>
										<td>{{(!empty($d->created_at)) ? date_format($d->created_at,"d/m/Y") : ""}}</td>
										<td>{{$d->cod_senior}}</td>
										<td>{{$d->cod_rqu_senior}}</td>
										<td>{{($d->status) ? "Ativa" : "Inativa"}}</td>
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
