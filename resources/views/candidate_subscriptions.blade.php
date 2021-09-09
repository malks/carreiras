@extends('layouts/public')

@section('content')
    <div class='row margin-top-30'>
        <div class="col-12 margin-bottom-30" id='app' candidate-subscriptions>
            @csrf
            <input type="hidden" value="{{ json_encode($subscriptions) }}" id='subscriptions-data'>
            <input type="hidden" class="hide" id='fields-data' value='{{ json_encode($fields) }}'>
            <input type="hidden" class="hide" id='units-data' value='{{ json_encode($units) }}'>    
            <input type="hidden" class="hide" id='jobs-data' value='{{ json_encode($jobs) }}'>
            <input type="hidden" class="hide" id='candidate-id' value='{{ $candidate_id }}'>
        
            <div class="card elegant">
                <div id='job-modal' class="modal" :class="{ 'hide':viewingJob.id==null }" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">@{{ viewingJob.name}}</h5>
                                <button type="button" class="btn-close" v-on:click="resetViewingJob" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class='maxed-height-500'>        
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="" class="control-label">Área</label>
                                            <span> @{{getField(viewingJob.field_id).name}}</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="" class="control-label">Unidade</label>
                                            <span> @{{getUnit(viewingJob.unit_id).name}}</span>
                                        </div>
                                    </div>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-6">
                                            <label for="" class="control-label">Cidade</label>
                                            <span> @{{getUnit(viewingJob.unit_id).city}}</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="" class="control-label">Estado</label>
                                            <span> @{{getUnit(viewingJob.unit_id).state}}</span>
                                        </div>
                                    </div>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-12">
                                            <label for="" class="control-label">Vaga:</label>
                                            <span> @{{viewingJob.name}}</span>
                                        </div>
                                    </div>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-12">
                                            <label for="" class="control-label">Descrição:</label>
                                            <span v-html='printDescription'></span>
                                        </div>
                                    </div>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-12">
                                            <label for="" class="control-label">Atividades:</label>
                                            <span v-html='printActivities'> </span>
                                        </div>
                                    </div>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-12">
                                            <label for="" class="control-label">Requisitos:</label>
                                            <span v-html='printRequired'> </span>
                                        </div>
                                    </div>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-12">
                                            <label for="" class="control-label">Desejável:</label>
                                            <span v-html='printDesirable'></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer ">
                                <button v-show="isSubscribed(viewingJob.id)" class="btn btn-warning" v-on:click="cancelApplication(viewingJob.id)" > 
                                    <i class="fa fa-check" style='margin-right:10px'></i>
                                    Cancelar Inscrição
                                </button>    
                                <button class="btn btn-danger" data-bs-dismiss="modal" v-on:click="closeModal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='card-header'>
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">CANDIDATURAS</h3>
                        <p class="head-subtitle">seleções em andamento</p>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="job-filters">Buscar</label>
                            <input placeholder="vendas marketing comercial...." id='job-filters' type="text" class='w-input text-field white-background' v-model='filters'>
                        </div>
                    </div>
                    <div class="row">
                        <template v-for='job in subscriptions'>
                            <div class="col-lg-4 margin-top-20"  v-show='inFilter(getSubscriptionsJob(job))'>

                                <div class="card elegant-mini">
                                    <div class="card-header  info">
                                        <h5>@{{getSubscriptionsJob(job).name}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" v-show="isSubscribed(getSubscriptionsJob(job).id)">
                                            <div class="col">
                                                <b>Status:</b>
                                                <b :class='getStatusClass(getSubscriptionsJob(job).id)'>@{{getSubscriptionState(getSubscriptionsJob(job).id)}}</b>
                                            </div>
                                        </div>

                                        <div class="row margin-top-20">
                                            <div class="col fixed-height-50" v-html='getSubscriptionsJob(job).description.split("\r\n").join("<br>")'>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col fixed-height-50" v-html='getSubscriptionsJob(job).required.split("\r\n").join("<br>")'>
                                            </div>
                                        </div>
                                        <div class="row margin-top-20">
                                            <div class="col">
                                                <button class="btn btn-default" v-on:click="viewJob(getSubscriptionsJob(job))" >Visualizar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>