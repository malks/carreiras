@extends('layouts/public')

@section('content')
    <div class='row margin-top-30'>
        <div class="col-12 margin-bottom-30" id='app' candidate-jobs>
            <input type="hidden" class="hide" id='jobs-data' value='{{ json_encode($jobs) }}'>
            <input type="hidden" class="hide" id='fields-data' value='{{ json_encode($fields) }}'>
            <input type="hidden" class="hide" id='units-data' value='{{ json_encode($units) }}'>
            <input type="hidden" class="hide" id='user-id' value='{{ $user_id }}'>

            <div class="card">
                
                <div class='card-header'>
                    <h3>Vagas</h3>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="job-filters">Filtrar</label>
                            <input placeholder="vendas marketing comercial...." id='job-filters' type="text" class='form-control' v-model='filters'>
                        </div>
                    </div>
                    <div class="row">
                        <div id='job-modal' class="modal" :class="{ 'hide':viewingJob.id==null }" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">@{{ viewingJob.name}}</h5>
                                        <button type="button" class="btn-close" v-on:click="resetViewingJob" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!--
                                        'field_id'=>'1',
                                        'unit_id'=>'1',
                                        'name'=>'Desenvolvedor',
                                        'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                                        'activities'=>'atividadesss',
                                        'required'=>'requisitos',
                                        'desirable'=>'desejavel',
                                        'status'=>'1',
                                        'home_highlights'=>'1',
                                        'home_slider'=>'1',
                                        'period'=>'07 as 12 e 13 as 17',
                                        'created_at'=>'2021-06-05 01:03:04',
                                        -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="" class="control-label">Área</label>
                                                <span> @{{fields[viewingJob.field_id].name}}</span>
                                            </div>
                                            <div class="col-6">
                                                <label for="" class="control-label">Unidade</label>
                                                <span> @{{units[viewingJob.unit_id].name}}</span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col">
                                                <label for="" class="control-label">Vaga:</label>
                                                <span> @{{viewingJob.name}}</span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col">
                                                <label for="" class="control-label">Descrição:</label>
                                                <span> @{{viewingJob.description}}</span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col">
                                                <label for="" class="control-label">Atividades:</label>
                                                <span> @{{viewingJob.activities}}</span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col">
                                                <label for="" class="control-label">Requisitos:</label>
                                                <span> @{{viewingJob.required}}</span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col">
                                                <label for="" class="control-label">Desejável:</label>
                                                <span> @{{viewingJob.desirable}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-default" :class=" { 'hide':canApply } " v-on:click="applyForJob"> 
                                            Aplicar para Vaga
                                        </button>
                                        <button class="btn btn-danger" data-bs-dismiss="modal" v-on:click="closeModal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <template v-for='job in jobs'>
                            <div class="col-lg-4 margin-top-20" v-show='inFilter(job)'>

                                <div class="card">
                                    <div class="card-header">
                                        <h5>@{{job.name}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                @{{job.description}}
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col">
                                                @{{job.required}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button class="btn btn-default" v-on:click="viewJob(job)">Visualizar</button>
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