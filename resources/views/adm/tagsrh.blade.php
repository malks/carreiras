@extends('adminlte::page')

@section('title', 'Tags RH | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo json_encode($data->toArray()['data']);@endphp'/>

@section('content')
	<div id='addtag-modal' class="modal hide" tabindex="-1">
		<form action="/adm/tagsrh/save" method='POST'>
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Nova Tag</h5>
						<button type="button" class="btn-close"  onclick="$('#addtag-modal').hide()" data-bs-dismiss="modal" aria-label="Close">X</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col">
								@csrf
								<label for="">Tag:</label>
								<input type="text" name='name' class='form-control'>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" type='submit'>Salvar</button>
						<button class="btn btn-danger" type='button' onclick="$('#addtag-modal').hide()">Fechar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<form method='GET' action='/adm/tagsrh' id='app'>
		@csrf
	    <div class="card" check-tags-list>
	    	<div class='card-header'>
	    		<h5>Tags</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class="col-1">
	        			<button type='button' class="btn btn-primary" id='new' onclick="window.location.href='/adm/tagsrh/create'">Nova</button>
	        		</div>
	        		<div class="col-1">
	        			<button class="btn btn-secondary" id='edit' v-on:click='edit()' type='button' v-bind:disabled='canEdit'>Editar</button>
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
			        				<th>Nome</th>
			        				<th>Cor</th>
			        				<th>Cor da Fonte</th>
			        			</tr>
			        		</thead>
			        		<tbody>
                                @if($data->total()<=0)
                                    <tr><td colspan='3'>Nenhum registro encontrado</td></tr>
                                @endif
								@foreach($data as $d)
									<tr class='hoverable' v-on:click='addItem({{$d->id}})' > 
										<td style='width:40px;' for='data-check-{{$d->id}}' class='checker'>
											<input type='checkbox' v-model='selectedIds' class='selected-ids' id='data-check-{{$d->id}}' value='{{$d->id}}' name='ids[]'> 
										</td>
										<td>{{$d->name}}</td>
										<td><input type='color' value='{{$d->color}}' readonly></td>
										@php
											$hexalfa=['a','b','c','d','e','f'];
											$hexnums=[10,11,12,13,14,15];
											$tempcolor=str_split($d->color);
											array_shift($tempcolor);
											foreach($tempcolor as $k=>$tc)
												$tempcolor[$k]=str_replace($hexalfa,$hexnums,$tc);
										@endphp
										<td><input type='color' value='{{  (array_sum($tempcolor)>45) ? '#000000' : '#ffffff'}}'/></td>
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
