@extends('adminlte::page')

@section('title', 'Áreas | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo json_encode($data->toArray()['data']);@endphp'/>

@section('content')
	<form method='GET' action='/adm/subscribers' id='app'>
        <input type="hidden" name='export' id='export' value='0'>
		@csrf
	    <div class="card" check-subscribers-list>
	    	<div class='card-header'>
	    		<h5>Áreas</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-12 col-lg-1">
	        			<button class="btn btn-primary" onclick="$('#export').val(1);$('form').submit();$('#export').val(0);" type='button'>Exportar</button>
	        		</div>

	        		<div class="col-12 col-lg-1">
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
