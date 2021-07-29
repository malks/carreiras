@extends('adminlte::page')

@section('title', 'Configurações | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')

<div class="card" id="app" check-recruiting>
    @csrf
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
        

            <div :class="jobSize">
                
                <div class="card">
                    <div class="card-header">
                        <h4>Vagas</h4>
                    </div>
                    <div class="card-body" style='overflow-x:hidden'>
                        <div class="row">
                            <div class="col">
                                <select v-on:change="updateData" v-model="pushData.filters.jobs.direct.in.unit_id" class='form-control' id="job-unit-filter">
                                    <option value="">Filtro de Unidade</option>
                                    <template v-for='unit in runData.units'>
                                        <option :value="unit.id">@{{unit.name}}</option>
                                    </template>
                                </select>
                            </div>
                            <div class="col">
                                <select v-on:change="updateData" v-model="pushData.filters.jobs.direct.in.field_id" class='form-control' id="job-field-filter">
                                    <option value="">Filtro de Campo</option>
                                    <template v-for='field in runData.fields'>
                                        <option :value="field.id">@{{field.name}}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Unidade</th>
                                    <th>Campo</th>
                                    <th class='text-center'>Status</th>
                                    <th class='text-right'>Candidatos</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-show="notYet(runData.jobs)">
                                    <td colspan=3> Carregando...</td>
                                </tr>
                                <tr v-show="runData.jobs==null && !notYet(runData.jobs)">
                                    <td colspan=3> Sem resultados...</td>
                                </tr>
                                <template v-for="job in runData.jobs">
                                    <tr v-on:click="inspectJob(job)" class='hoverable' :class="{ 'active':runData.selectedJob.id==job.id }">
                                        <td>@{{ job.name }}</td>
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


            <div  :class="candidateSize">

                <div class="card">
                    <div class="card-header">
                        <h4>Candidatos</h4>
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
                                <label for="">Filtrar Status</label>
                            </div>
                            <div class="col-12">
                                <input type="checkbox" v-model="runData.specificFilter">
                                <label for="">Exibir somente se for status atual</label>
                            </div>
                            <template v-for="state in runData.states">
                                <button class="btn btn-info line-margin" v-on:click="checkState(state.id)">
                                    <i class="fas fa-check" v-show="checkedState(state.id)"></i>
                                    @{{ state.name }}
                                </button>
                            </template>
                        </div>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th class='text-center'>Status</th>
                                    <th class='text-right'>Telefone</th>
                                    <th>Email</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-show="notYet(runData.selectedJob.id)">
                                    <td colspan=4> Selecione uma vaga para ver os candidatos</td>
                                </tr>

                                <template v-for="(subscription,subx) in runData.subscriptions">
                                    <tr class='select-sized' v-show="specificFilter(subscription)">
                                        <td>@{{ getCandidate(subscription).name }}</td>
                                        <td class='text-center'>
                                            <select class="form-control" v-on:change="addSubscriptionState(getCandidate(subscription).id,runData.selectedJob.id,getState(runData.subscriptions[subx].current_state).name)" v-model="runData.subscriptions[subx].current_state">
                                                <template v-for='state in runData.states'>
                                                    <option 
                                                        :value="state.id" >
                                                        @{{state.name}}
                                                    </option>
                                                </template>
                                            </select>
                                            
                                        </td>
                                        <td class='text-right'>@{{ getCandidate(subscription).phone }}</td>
                                        <td>@{{ getCandidate(subscription).email }}</td>
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

@stop

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>