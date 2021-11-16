@extends('adminlte::page')

@section('title', 'Seleção e Recrutamento | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')

<div class="card" id="app" check-recruiting>
    @csrf
    <input type="hidden" value='{{json_encode($schooling_grades)}}' id='data-schooling-grades'>
    <div class='card-header'>
        <h5>Seleção e Recrutamento de Candidatos</h5>
    </div>
    <div class="card-body">

        <div class='row'>

            <div id='note-modal' class="modal":class="{ 'hide':runData.notepad==false }" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Anotações</h5>
                            <button type="button" class="btn-close" v-on:click="closeNotes" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <label for="">Observações do Candidato:</label><br>
                                    <template v-for='obs in notingObservation'>
                                        <span>@{{obs}}</span><bR>
                                    </template>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="col">
                                    <label for="">Anotações de Recrutamento:</label><br>
                                    <textarea width='100%' style='width:inherit;min-height:200px;' v-model="runData.notingSubscription.notes"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" v-on:click="updateNotes" :disabled='runData.saving'>Salvar</button>
                            <button class="btn btn-danger" v-on:click="closeNotes">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        

            <div class='col-12' :class="jobSize">
                
                <div class="card">
                    <div class="card-header">
                        <h4>Vagas</h4>
                        <div class="row">
                            <div class="col-xs-12 col-lg-6">
                                <h6 class='margin-top-10'>Vagas criadas de:</h6>
                                <input type="date" class="form-control" name='filter-date-from' v-model='pushData.filters.jobs.direct.gt.created_at' v-on:change='updateData'>
                            </div>
                            <div class="col-xs-12 col-lg-6">
                                <h6 class='margin-top-10'>Vagas criadas até:</h6>
                                <input type="date" class="form-control" name='filter-date-to' v-model='pushData.filters.jobs.direct.lt.created_at' v-on:change='updateData'>
                            </div>

                            <div class="col-xs-12 col-lg-6">
                                <h6 class='margin-top-10'>Filtrar por Nome</h6>
                                <input type="text" placeholder="Buscar vaga por nome" class='form-control' id='job-search' v-model='otherData.jobNameSearch'>
                            </div>
                            <div class="col-xs-12 col-lg-6">
                                <h6 class='margin-top-10'>Filtrar por Tags</h6>
                                <input type="text" placeholder="Buscar vaga por tags ex: vendas comercial" class='form-control' id='job-tag-search' v-model='otherData.tagFilters'>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col">
                                <h6 >Filtrar por Status:&nbsp</h6>
                                <input style='margin-left:10px' type="checkbox" id='active-status-filter' v-model='pushData.filters.jobs.direct.in.status' value='1' v-on:change='updateData'>
                                <label class='control-label' style='margin-left:3px' for="active-status-filter">Ativas</label>
                                <input type="checkbox" style='margin-left:10px' id='inactive-status-filter' v-model='pushData.filters.jobs.direct.in.status' value='0'  v-on:change='updateData'>
                                <label class='control-label'  style='margin-left:3px' for="inactive-status-filter">Inativas</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style='overflow-x:hidden'>
                        <div class="row">
                            <div class="col">
                                <select v-on:change="updateData" v-model="pushData.filters.jobs.direct.in.unit_id" class='form-control' id="job-unit-filter">
                                    <option value="">Todas as Unidades</option>
                                    <template v-for='unit in runData.units'>
                                        <option :value="unit.id">@{{unit.name}}</option>
                                    </template>
                                </select>
                            </div>
                            <div class="col">
                                <select v-on:change="updateData" v-model="pushData.filters.jobs.direct.in.field_id" class='form-control' id="job-field-filter">
                                    <option value="">Todas as Áreas</option>
                                    <template v-for='field in runData.fields'>
                                        <option :value="field.id">@{{field.name}}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col">
                                <label for="">Selecione uma vaga para ver os candidatos</label>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col-xs-12 col-lg-12 table-responsive">
                                <table class='table dataTable'>
                                    <thead>
                                        <tr>
                                            <th>Vaga</th>
                                            <th>Cod. RQU</th>
                                            <th>Unidade</th>
                                            <th>Área</th>
                                            <th class='text-center'>Status</th>
                                            <th class='text-right'>Candidatos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
        
                                        <tr v-show="notYet(runData.jobs)">
                                            <td colspan=3> Carregando...</td>
                                        </tr>
                                        <tr v-show="(runData.jobs==null || runData.jobs.length==0) && !notYet(runData.jobs) && !runData.updating">
                                            <td colspan=3> Sem resultados</td>
                                        </tr>
                                        <template v-for="job in runData.jobs">
                                            <tr v-show='inFilter(job) && inJobNameFilter(job)' v-on:click="inspectJob(job)" class='hoverable' :class="{ 'active':runData.selectedJob.id==job.id }">
                                                <td><a :href="'/adm/jobs/edit/'+job.id" target='_blank'> @{{ job.name }}</a></td>
                                                <td>@{{job.cod_rqu_senior}}</td>
                                                <td>@{{ getUnitById(job.unit_id).name }}</td>
                                                <td>@{{ getFieldById(job.field_id).name }}</td>
                                                <td class='text-center'>@{{ runData.jobStatusNames[job.status] }}</td>
                                                <td class='text-right'>@{{ job.subscription_amount }}</td>
                                            </tr>
                                        </template>                        
        
                                    </tbody>
                                </table>        
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class='col-12' :class="candidateSize">

                <button class='btn btn-primary' v-show='runData.selectedJob.id!=null' v-on:click="uninspectJob()"><i class="fas fa-arrow-alt-circle-left"></i> Voltar</button>
                <div  class="card margin-top-10"  v-if='runData.selectedJob.id!=null'>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 style='float:left;'>Vaga Selecionada:</h5>
                                <span style='float:left;margin-left:10px;font-size:10pt;line-height:28px;'>@{{runData.selectedJob.name}} </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 style='float:left;'>Requisições Abertas:</h5>
                                <span style='float:left;margin-left:10px;font-size:10pt;line-height:28px;'>@{{ runData.selectedJob.requisition_amount }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 style='float:left;'>Unidade:</h5>
                                <span style='float:left;margin-left:10px;font-size:10pt;line-height:28px;'>@{{ getUnitById(runData.selectedJob.unit_id).name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card margin-top-10">
                    <div class="card-header">
                        <h4>Candidatos</h4>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <h6 class='margin-top-10'>Filtrar por Nome</h6>
                                <input type="text" placeholder="Buscar candidato por nome" class='form-control' id='candidate-search' v-model='otherData.candidateNameSearch' >
                            </div>
                            <div class="col-lg-6 col-12">
                                <h6 class='margin-top-10'>Filtrar por Interesses</h6>
                                <input type="text" placeholder="Buscar candidato por interesses ex: vendas comercial" class='form-control' id='candidate-tag-search' v-model='otherData.candidateTagSearch'>
                            </div>
                            <div class="col-lg-6 col-12">
                                <h6 class='margin-top-10'>Filtrar por Atividades de Trabalhos Anteriores</h6>
                                <input type="text" placeholder="Buscar candidato por atividades passadas ex: merchandising projetos" class='form-control' id='candidate-exp-search' v-model='otherData.candidateExpSearch'>
                            </div>
                            <div class="col-lg-6 col-12">
                                <h6 class='margin-top-10'>Filtrar por Cidade/Estado</h6>
                                <input type="text" placeholder="Buscar candidato por cidade/estado ex: guaramirim jaragua" class='form-control' id='candidate-location-search' v-model='otherData.candidateLocSearch'>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="hide">
                            <template v-for="state in runData.states">
                                <div class="col-lg-2">
                                    <input type="checkbox" :value="state.id" v-model="pushData.filters.jobs.deep.subscriptions.mustHave.states.in.state_id">
                                    <label>@{{state.name}}</label>
                                </div>
                            </template>
                        </div>
                        <div class="row" v-show='!notYet(runData.selectedJob.id)'>
                            <div class="col-12">
                                <h6 for="">Filtrar Status</h6>
                            </div>
                            <div class="col-12">
                                <input id='specific-filter-run-data' type="checkbox" value='true' v-model="runData.specificFilter">
                                <label for="specific-filter-run-data">Exibir somente se for status atual</label>
                            </div>
                            <template v-for="state in runData.states">
                                <button class="btn line-margin" :class="{ 'btn-info':checkedState(state.id),'btn-default':(!checkedState(state.id)) }" v-on:click="checkState(state.id)">
                                    <i class="fas fa-check" v-show="checkedState(state.id)"></i>
                                    @{{ state.name }}
                                </button>
                            </template>
                        </div>
                        <div class="row margin-top-20">
                            <div class="col-xs-12 col-lg-12 table-responsive">
                                <table class='table dataTable'>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cidade</th>
                                            <th>Estado</th>
                                            <th class='text-right'>Telefone</th>
                                            <th>Email</th>
                                            <th class='text-center'>Status</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
        
                                        <tr v-show="notYet(runData.selectedJob.id)">
                                            <td colspan=4> Selecione uma vaga para ver os candidatos</td>
                                        </tr>
        
                                        <template v-for="(subscription,subx) in runData.subscriptions">
                                            <tr v-show="candidateNameFilter(getCandidate(subscription)) && candidateLocFilter(getCandidate(subscription)) && candidateExpFilter(getCandidate(subscription)) && candidateTagFilter(getCandidate(subscription)) && specificFilter(subscription)" class='select-sized'>
                                                <td>@{{ getCandidate(subscription).name }}</td>
                                                <td>@{{ getCandidate(subscription).address_city }}</td>
                                                <td>@{{ getCandidate(subscription).address_state }}</td>
                                                <td class='text-right'>@{{ getCandidate(subscription).phone }}</td>
                                                <td>@{{ getCandidate(subscription).email }}</td>
                                                <td class='text-center'>
                                                    <select class="form-control" v-on:change="addSubscriptionState(getCandidate(subscription).id,runData.selectedJob.id,getState(runData.subscriptions[subx].current_state).name)" v-model="runData.subscriptions[subx].current_state">
                                                        <template v-for='state in runData.states'>
                                                            <option 
                                                                :value="state.id" :disabled='state.id==5'>
                                                                @{{state.name}}
                                                            </option>
                                                        </template>
                                                    </select>
                                                </td>
                                                <td class='text-right'>
                                                    <a :href="'/adm/candidates/edit/'+getCandidate(subscription).id" target='_blank' v-on:click="viewCandidate(subscription)"> 
                                                        <i class="fas fa-eye action-icon" title="Visualizar Candidato"></i> 
                                                    </a>
                                                </td>
                                                <td>
                                                    <a v-on:click="showNotes(subscription)">
                                                        <i class="fas fa-clipboard action-icon" title="Anotações"></i> 
                                                    </a>
                                                </td>
                                            </tr>
                                        </template>                        
        
                                    </tbody>
                                </table>
        
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>
</div>

@stop

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>