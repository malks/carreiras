@extends('adminlte::page')

@section('title', 'Candidatos | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo json_encode($data_list);@endphp'/>

@section('content')
	<div id="app" action='/adm/candidates'>
		<div id='subscribe-job-modal' class="modal" style='display:block;' tabindex="-1" v-show="jobChoosing" v-if="availableJobs.length>0">
			<form action="/adm/candidates/subscribe-job" method='POST'>
				<div class="modal-dialog" style='width:820px;max-width:820px;'>
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Inscrever candidatos na vaga:</h5>
							<button type="button" class="btn-close"  v-on:click="openJobs" data-bs-dismiss="modal" aria-label="Close">X</button>
						</div>
						<div class="modal-body">
							<div class="card" >
								<div class="card-header">
									<div class="row">
										<div class="col-lg-3">
											<input style='float:left;margin-top:5px;' v-model='availableJobsFilterData.status' type="checkbox" value='0' id='filter-jobs-status-0'>
											<label style='float:left;margin-left:5px;' for="filter-jobs-status-0">Inativas</label><br><br>
											<input style='float:left;margin-top:5px;' v-model='availableJobsFilterData.status' type="checkbox" value='1' id='filter-jobs-status-1'>
											<label style='float:left;margin-left:5px;' for="filter-jobs-status-1">Ativas</label>
										</div>
										<div class="col-lg-3">
											<label for="">Nome</label>
											<input class='form-control' v-model='availableJobsFilterData.name' type="text">
										</div>
										<div class="col-lg-3">
											<label for="">Unidade</label>
											<select class='form-control'  v-model='availableJobsFilterData.unit'>
												<option value="0">Todas</option>
												<template v-for='unit in allUnits'>
													<option :value="unit.id">@{{unit.name}}</option>
												</template>
											</select>
										</div>
										<div class="col-lg-3">
											<label for="">Área</label>
											<select class='form-control'  v-model='availableJobsFilterData.field'>
												<option value="0">Todas</option>
												<template v-for='field in allFields'>
													<option :value="field.id">@{{field.name}}</option>
												</template>
											</select>
										</div>
									</div>
								</div>
								<div class="card-body" style='max-height:400px;overflow-y:scroll; overflow-x:show;'>
									<div class="row">
										<div class="col">
											<table class='table table-bordered dataTable'>
												<thead>
													<tr>
														<th></th>
														<th>Vaga</th>
														<th>Unidade</th>
														<th>Área</th>
													</tr>
												</thead>
												<tbody>
													<template v-for="job in availableJobs">
														<tr class='hoverable'  v-on:click="selectJob(job.id)" v-show='filterAvailableJobs(job)'>
															<td><input type='checkbox':checked='selectedJob==job.id' class='selected-ids' :value="job.id" name='selected_jobs[]'> </td>
															<td>@{{job.name}}</td>
															<td>@{{(job.unit!=undefined) ? job.unit.name : ''}}</td>
															<td>@{{(job.field!=undefined) ? job.field.name : ''}}</td>
														</tr>
													</template>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary" type='button' v-on:click="subscribeCandidatesToJob" :disabled="candidatesJobsSelected">Inscrever</button>
							<button class="btn btn-danger" type='button' v-on:click="openJobs">Fechar</button>
						</div>
					</div>
				</div>
			</form>
		</div>

		<form method='GET' action='/adm/candidates' >
			@csrf
			<div class="card" check-candidates-list>
				<div class='card-header'>
					<h5>Candidatos</h5>
				</div>
				<div class="card-body">
					<div class='row'>
						<!--div class="col-1">
							<a class="btn btn-primary" id='new' href='/adm/candidates/create'>Novo</a>
						</div-->
						<div class="col-2 col-xl-1">
							<button class="btn btn-secondary" id='edit' v-on:click='edit()' type='button' v-bind:disabled='canEdit'>Editar</button>
						</div>
						<!--div class="col-1">
							<button class="btn btn-danger" id='destroy' v-on:click='destroy()' type='button' v-bind:disabled='canDestroy'>Excluir</button>
						</div-->
						<div class="col-3 col-xl-2">
							<button class="btn btn-success" v-on:click='openJobs' type='button' v-bind:disabled='canDestroy'>Inscrever em vaga</button>
						</div>
						<div class="col-3 col-xl-2">
							<button class="btn btn-primary" v-on:click='exportCandidates' type='button' v-bind:disabled='canDestroy'>Exportar para Senior</button>
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
						<div class='col-12 col-lg-6'>
							<input class='form-control' placeholder='Busca nome, cpf, telefone, email' id='search' name='search' @if(!empty($search)) value='{{$search}}' @endif>
						</div>
						<div class="col-12 col-lg-6">
							<input class='form-control' placeholder='Busca endereço, cidade, estado' id='searchAddress' name='searchAddress' @if(!empty($searchAddress)) value='{{$searchAddress}}' @endif>
						</div>
					</div>
					<div class='row margin-top-10'>
						<div class="col-12 col-lg-6">
							<input class='form-control' placeholder='Busca interesses, habilidades' id='searchInterests' name='searchInterests' @if(!empty($searchInterests)) value='{{$searchInterests}}' @endif>
						</div>
						<div class="col-12 col-lg-6">
							<input class='form-control' placeholder='Busca trabalhos e experiencias anteriores' id='searchExperiences' name='searchExperiences' @if(!empty($searchExperiences)) value='{{$searchExperiences}}' @endif>
						</div>
					</div>
					<div class='row margin-top-10'>
						<div class='col-lg-12 table-responsive'>
							<table class='table table-bordered dataTable'>
								<thead>
									<tr>
										<th style='width:40px;'><input type='checkbox' id='check-all' v-on:click='reverseSelection()'></th>
										<th>Nome</th>
										<th>Cidade</th>
										<th>Estado</th>
										<th>Última Atualização</th>
										<th>Candidaturas</th>
										<th>Última Candidatura</th>
										<th>Exportado Senior</th>
										<th></th>
										<th></th>
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
											<td>{{$d->name}}</td>
											<td>{{$d->address_city}}</td>
											<td>{{$d->address_state}}</td>
											<td>{{(!empty($d->updated_at)) ? date_format($d->updated_at,'d/m/Y') : ''}}</td>
											<td>{{$d->subscription_amount}}</td>
											<td>{{(!empty($d->subscriptions[0]->created_at)) ? date_format($d->subscriptions[0]->created_at,'d/m/Y') : ''}}</td>
											<td>{{(!empty($d->senior_num_can)) ? 'Exportado: '.$d->senior_num_can : ( ($d->exportado!==null) ? $export_states[$d->exportado] : 'Não' ) }}</td>
											<td class='text-center'>
												<a href="/adm/candidates/edit/{{$d->id}}" target='_blank' > 
													<i class="fas fa-eye action-icon" title="Visualizar Candidato"></i> 
												</a>
											</td>
											<td class='text-center'>
												<a href="/adm/candidates/print/{{$d->id}}" target='_blank' > 
													<i class="fas fa-clipboard-list action-icon" title="Visualizar Curriculum do Candidato"></i> 
												</a>
											</td>
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
	</div>
@stop


@section('adminlte_js')
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
