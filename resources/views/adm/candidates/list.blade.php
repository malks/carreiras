@extends('adminlte::page')

@section('title', 'Candidatos | Lunelli Carreiras')

@section('content_header')
@stop

<input type='hidden' id='full-data' value='@php echo json_encode($data_list);@endphp'/>
<input type='hidden' id='filtered-tagsrh' value='@php echo json_encode($tagsrh_filters);@endphp'/>
<input type='hidden' id='viewed-data' value='{{$viewed_list}}'/>
<input type='hidden' id='usermail' value='{{$usermail}}'/>

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
		<div id='subscribe-tagrh-modal' class="modal" style='display:block;' tabindex="-1" v-show="tagSetting" v-if="availableTagsRh.length>0">
			<form action="/adm/candidates/subscribe-tagrh" method='POST' id='tagsrhform'>
				@csrf
				<input type="hidden" name='candidate_id' v-model='selectedCandidateId'>
				<div class="modal-dialog" style='width:820px;max-width:820px;'>
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Adicionar TAG ao Candidato:</h5>
							<button type="button" class="btn-close"  v-on:click="openTags" data-bs-dismiss="modal" aria-label="Close">X</button>
						</div>
						<div class="modal-body">
							<div class="card" >
								<div class="card-header">
									<label for="">@{{selectedCandidateName}}</label>
								</div>
								<div class="card-body">
									<div class="row">
										<template v-for="leTagRh in availableTagsRh">
											<div class="col-4 margin-top-10">
												<button type='button' style='width:100%' v-on:click="switchTagRh(leTagRh.id)" :style="(isUserSelectedTagRh(leTagRh.id)) ? 'background-color:'+leTagRh.color : 'background-color:#eee'">
													<b :style="(isUserSelectedTagRh(leTagRh.id)) ? 'color:'+leTagRh.fontcolor : 'color:#999'">@{{leTagRh.name}}</b>
												</button>
												<input style='display:none;' type="checkbox" name='tags_rh[]' :value="leTagRh.id" :checked="isUserSelectedTagRh(leTagRh.id)">
											</div>
										</template>
									</div>
								</div>
								<div class="card-footer">
									<button v-if="!saving & selectedCandidateName!=''" type='submit' v-on:click="saving=true;$('#tagsrhform').submit()" class='btn btn-primary'>Salvar</button>
									<button v-if="!saving" type='button' class="btn btn-danger"  v-on:click="openTags" >Sair</button>
									<label for=""  v-if="saving">Salvando...</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div id="check-before-export" class="modal">
			<div class="modal-dialog" style='width:820px;max-width:820px;'>
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Verifique antes de exportar:</h5>
						<button type="button" class="btn-close"  v-on:click="openCheckExportCandidates" data-bs-dismiss="modal" aria-label="Close">X</button>
					</div>
					<div class="modal-body">
						<div class="card" >
							<div class="card-header">
								<h5 v-if="exportCheckPrevCad">Alguns <b>candidatos selecionados</b> para exportação <b>SÃO EX COLABORADORES</b></h5>
							</div>
							<div class="card-body">
								<div class="row" style='max-height:300px;overflow:auto;'>
									<template v-for="prevData in previousLunelliCadData">
										<div class="col-lg-6 col-xs-12">
											<div class="card">
												<div class="card-header">
													<h6>@{{prevData.nome}}</h6>
												</div>
												<div class="card-body">
													<p><b style='margin-right:5px;'>Cadastro:</b> @{{prevData.cadastro}}</p>
													<p><b style='margin-right:5px;'>Unidade:</b> @{{prevData.unidade}}</p>
													<p><b style='margin-right:5px;'>Cargo:</b> @{{prevData.vaga}}</p>
													<p><b style='margin-right:5px;'>Data:</b> @{{printDate(prevData.data)}}</p>
												</div>
											</div>
										</div>
									</template>
								</div>
								<div class="row margin-top-20">
									<h5>Tem certeza de que deseja realizar a exportação?</h5>
									<br>
									<p>Caso realmente queira continuar com a exportação desses usuários, mesmo <b>estando ciente dessas informações</b>, preencha <b>seu email</b> de usuário do sistema no campo abaixo:</p>
									<br>
									<input type="text" name='exporter_email' class='form-control' v-model='exporterEmail' autocomplete="off">
								</div>
							</div>
							<div class="card-footer">
								<button v-bind:disabled="validateExport" type='button' v-on:click="exportCandidates" class='btn btn-primary'>Exportar</button>
								<button v-if="!saving" type='button' class="btn btn-danger"  v-on:click="openCheckExportCandidates" >Sair</button>
							</div>
						</div>
					</div>
				</div>
			</div>
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
							<button class="btn btn-primary" v-on:click='openCheckExportCandidates' type='button' v-bind:disabled='canExport'>Exportar para Senior</button>
						</div>
						<div class="col-3 col-xl-2">
							<button class="btn btn-warning" v-on:click='tagsRh(false)' type='button' v-bind:disabled='canEdit'>Tags RH</button>
						</div>
					</div>
					<div class="row margin-top-10">
						<div class="col-sm-12 col-lg-3">
							<label for="dob-start">País:</label>
							<select name="country_filter" id="filter-country" class='form-control'>
								<option value="brasil" @if(!empty($country_filter) && $country_filter=="brasil") selected @endif>Brasil</option>
								<option value="paraguai"  @if(!empty($country_filter) && $country_filter=="paraguai") selected @endif>Paraguai</option>
							</select>
						</div>
					</div>
					<div class="row margin-top-10">
						<div class="col-lg-6">
							<div>
								<label for="">Filtrar Tags RH:</label>
								<div class="row">
									<div class="col-lg-6">
										<select name="tagrh_filter_type" class="form-control" id="" v-on:change="$('form').submit()">
											<option value="only" @if ($tagrh_filter_type=='only') selected @endif>COM as Tags RH selecionadas</option>
											<option value="except" @if ($tagrh_filter_type=='except') selected @endif>SEM as Tags RH selecionadas</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="hide">
										<input type="checkbox" name='lala'>
									</div>
									<template v-for="tagRh in availableTagsRh">
										<div class="hide">
											<input type="checkbox" v-model="filterTagRh" name="filter_tagrh[]" :value="tagRh.id" :checked="isSelectedTagRh(tagRh.id)">
										</div>
										<div class="col-lg-4 margin-top-10">
											<button 
												type='button' 
												v-on:click="addTagRhFilter(tagRh.id)"
												style='z-index:9999999;width:100%;font-weight:bold;'
												:style="[isSelectedTagRh(tagRh.id) ? { 'background-color':tagRh.color,'color':tagRh.fontcolor } : {'background-color':'#6c757d','color':'#fff'}]"
												class="btn btn-secondary">
												@{{tagRh.name}}
											</button>
										</div>
									</template>
								</div>
							</div>
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
					</div>
					<div class="row margin-top-10">
						<div class="col-sm-12 col-lg-3">
							<label for="dob-start">Início Data de Nascimento:</label>
							<input type="date" class="form-control" id='dob-start' name='filter_dob_start' value='{{$filter_dob_start}}'>
						</div>
						<div class="col-sm-12 col-lg-3">
							<label for="dob-end">Fim Data de Nascimento:</label>
							<input type="date" class="form-control" id='dob-end' name='filter_dob_end' value='{{$filter_dob_end}}'>
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
										<th>TagsRH</th>
										<th>PCD</th>
										<th>Cidade</th>
										<th>Estado</th>
										<th>Última Atualização</th>
										<th>Candidaturas</th>
										<th>Última Candidatura</th>
										<th>Exportado Senior</th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@if($data->total()<=0)
										<tr><td colspan='3'>Nenhum registro encontrado</td></tr>
									@endif
									@foreach($data as $d)
										<tr @if($d->duplicate_cpf) title='CPF do Candidato está Duplicado no Sistema' @endif class='hoverable @if($d->duplicate_cpf) duplicate-cpf @endif' v-on:click="addItem({{$d}})" > 
											<td style='width:40px;' for='data-check-{{$d->id}}' class='checker'>
												<input type='checkbox' v-model='selectedIds' class='selected-ids' id='data-check-{{$d->id}}' value='{{$d->id}}' name='ids[]'>
											</td>
											<td>
												@if($d->duplicate_cpf)
													<i style='float:left;font-size:8pt;color:rgb(112, 2, 2)'  class="fas fa-exclamation-circle"></i>
												@endif
												{{$d->name}}
											</td>
											<td> <button v-on:click.prevent="tagsRh({{$d->id}})" type='button' style='z-index:9999999;width:100%;font-weight:bold;@if(!empty($d->Tagsrh[0])) background-color:{{$d->Tagsrh[0]->color}};color:{{$d->Tagsrh[0]->fontcolor}} @endif' class="btn btn-secondary" >{{$d->tagsrhcount}}</button></td>
											<td>@php echo ($d->deficiency) ? '<span style="color:green">Sim<span>' : '<span style="color:red">Não</span>' @endphp</td>
											<td>{{$d->address_city}}</td>
											<td>{{$d->address_state}}</td>
											<td>{{(!empty($d->updated_at)) ? date_format($d->updated_at,'d/m/Y') : ''}}</td>
											<td>{{$d->subscription_amount}}</td>
											<td>{{(!empty($d->subscriptions[0]->created_at)) ? date_format($d->subscriptions[0]->created_at,'d/m/Y') : ''}}</td>
											<td>{{(!empty($d->senior_num_can)) ? 'Exportado: '.$d->senior_num_can : ( ($d->exportado!==null) ? $export_states[$d->exportado] : 'Não' ) }}</td>
											<td> <i class="fas just-icon" :class="{ 'fa-eye': isViewed({{$d->id}}), 'fa-window-minimize': !isViewed({{$d->id}}) } "> </i> </td>
											<td class='text-center'>
												<a href="/adm/candidates/edit/{{$d->id}}" target='_blank' v-on:click="addViewed({{$d->id}})" > 
													<i class="fas fa-id-card action-icon" title="Visualizar Candidato"></i> 
												</a>
											</td>
											<td class='text-center'>
												<a href="/adm/candidates/print/{{$d->id}}" target='_blank' v-on:click="addViewed({{$d->id}})" > 
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
								Exibindo {{(int) $data->withQueryString()->firstItem()}} a {{$data->withQueryString()->firstItem()+$data->withQueryString()->perPage()}} de {{$data->withQueryString()->lastItem()}}
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
