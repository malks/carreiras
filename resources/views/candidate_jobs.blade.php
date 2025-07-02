@extends('layouts/public')

@section('content')
    <div class='row margin-top-30'>
        <div class="col-12 margin-bottom-30" id='app' candidate-jobs>
            @csrf
            <input type="hidden" value="{{ urlencode(json_encode($subscriptions)) }}" id='subscriptions-data'>
            <input type="hidden" class="hide" id='jobs-data' value='{{ urlencode(json_encode($jobs)) }}'>
            <input type="hidden" class="hide" id='fields-data' value='{{ urlencode(json_encode($fields)) }}'>
            <input type="hidden" class="hide" id='units-data' value='{{ urlencode(json_encode($units)) }}'>
            <input type="hidden" class="hide" id='user-id' value='{{ $user_id }}'>
            <input type="hidden" class="hide" id='candidate-id' value='{{ $candidate_id }}'>
            <input type="hidden" class="hide" id='talent-bank' value='{{ $talent_bank }}'>
            <input type="hidden" class="hide" id='cur-country' value='@if ($curlang=='ptbr') 1 @else 4 @endif'>

            <div class="card elegant">
                
                <div class='card-header'>
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">{{ __('candidatesjobs.jobs') }}</h3>
                        <p class="head-subtitle">{{ __('candidatesjobs.subscribehere') }}</p>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <small>
                                <p>{{__('candidatesjobs.inclusao1')}}</p>
                                <p>{{__('candidatesjobs.inclusao2')}}</p>
                             </small><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                            <label for="country-filter">{{ __('candidatesjobs.countries') }}</label>
                            <select id="country-filter"  class='w-input text-field white-background' v-model='filterCountry'>
                                <option value='1'>{{ __('candidatesjobs.brazil') }}</option>
                                <option value='4'>{{ __('candidatesjobs.paraguay') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <label for="city-filter">{{ __('candidatesjobs.city') }}</label>
                            <input id="city-filter"  class='w-input text-field white-background' v-model='filterCity' placeholder="Jaragua do sul..."/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="job-filters">{{ __('candidatesjobs.search') }}</label>
                            <input placeholder="vendas marketing comercial...." id='job-filters' type="text" class='w-input text-field white-background' v-model='filters'>
                        </div>
                    </div>

                    <div class="row">
                        <div id='job-modal' class="modal" :class="{ 'hide':viewingJob.id==null }" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">@{{ viewingJob.name}}</h5>
                                        <button type="button" class="btn-close" v-on:click="resetViewingJob" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class='maxed-height-500'>
                                            <div id='observation-modal' class="modal" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5>{{ __('candidatesjobs.addobs') }}?</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea v-model='observation' style='width:100%;min-height:150px;'></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class='btn btn-default'  data-bs-dismiss="modal" v-on:click="closeObsModal">OK</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.area') }}:</label>
                                                    <span> @{{getField(viewingJob.field_id).name}}</span>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.unit') }}:</label>
                                                    <span> @{{getUnit(viewingJob.unit_id).name}}</span>
                                                </div>
                                            </div>
                                            <div class="row margin-top-30">
                                                <div class="col-lg-6">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.city') }}:</label>
                                                    <span> @{{getUnit(viewingJob.unit_id).city}}</span>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.state') }}:</label>
                                                    <span> @{{getUnit(viewingJob.unit_id).state}}</span>
                                                </div>
                                            </div>        
                                            <div class="row margin-top-30">
                                                <div class="col-lg-12">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.job') }}:</label>
                                                    <span> @{{viewingJob.name}}</span>
                                                </div>
                                            </div>
                                            <div v-show="viewingJob.pcd" class="row margin-top-30">
                                                <div class="col-lg-12">
                                                    <label for="" class="control-label">PCD:</label>
                                                    <span>Esta vaga também é destinada a <b>Pessoas com Deficiência</b></span>
                                                </div>
                                            </div>
                                            <div class="row margin-top-30">
                                                <div class="col-lg-12">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.description') }}:</label>
                                                    <span v-html='printDescription'></span>
                                                </div>
                                            </div>
                                            <div class="row margin-top-30">
                                                <div class="col-lg-12">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.activities') }}:</label>
                                                    <span v-html='printActivities'> </span>
                                                </div>
                                            </div>
                                            <div class="row margin-top-30">
                                                <div class="col-lg-12">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.requirements') }}:</label>
                                                    <span v-html='printRequired'> </span>
                                                </div>
                                            </div>
                                            <div class="row margin-top-30">
                                                <div class="col-lg-12">
                                                    <label for="" class="control-label">{{ __('candidatesjobs.desirable') }}:</label>
                                                    <span v-html='printDesirable'></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-default" v-show="!isSubscribed(viewingJob.id)"  v-on:click="applyForJob(viewingJob.id)"> 
                                            {{ __('candidatesjobs.subscribetojob') }}
                                        </button>
                                        <button v-show="isSubscribed(viewingJob.id)" class="btn btn-warning" v-on:click="cancelApplication(viewingJob.id)" > 
                                            <i class="fa fa-check" style='margin-right:10px'></i>
                                            {{ __('candidatesjobs.unsubscribe') }}
                                        </button>
                                        <button class="btn btn-danger" data-bs-dismiss="modal" v-on:click="closeModal">{{ __('candidatesjobs.close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-lg-12" v-if="jobs.length==0">
                            {{ __('candidatesjobs.nojob') }}
                        </div>

                        <template v-for='job in jobs'>
                            <div class="col-lg-6 margin-top-20" v-show='inFilter(job) & countryFilter(job) & cityFilter(job)'>

                                <div class="card elegant-mini" :class=" { 'subscribed-job':isSubscribed(job.id) } ">
                                    <div class="card-header" :class=" { 'subscribed-job':isSubscribed(job.id) } ">
                                        <h5>@{{job.name}}</h5>
                                        <small style='text-transform:uppercase'>@{{getUnit(job.unit_id).city}}</small><br>
                                        <small v-show='job.pcd'>Esta vaga também é destinada a <b>Pesoas com Deficiência</b></small>
                                    </div>
                                    <div class="card-body" :class=" { 'subscribed-job':isSubscribed(job.id) } ">
                                        <!--- SOMENTE IPAD ++  --->
                                        <div class="d-none d-lg-block">
                                            <div class="row">
                                                <div :class="{ 'col-6':gotImage(job)|'col' }">
                                                    <div class="row" v-show="isSubscribed(job.id)">
                                                        <div class="col">
                                                            <b>@{{getSubscriptionState(job.id)}}</b>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-20">
                                                        <div class="col fixed-height-180"  v-html='(job.description!=null) ? job.description.split("\r\n").join("<br>") : ""'>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-10">
                                                        <div class="col fixed-height-120" v-html='(job.required!=null) ? job.required.split("\r\n").join("<br>") : ""'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="gotImage(job)" class="col-6" style='overflow:hidden;'>
                                                    <img :src="job.picture" class='prog-image'>
                                                </div>
                                            </div>
                                            <div class="row margin-top-20">
                                                <div class="col">
                                                    <button class="btn btn-default" v-on:click="viewJob(job)">{{ __('candidatesjobs.view') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- SOMENTE MOBILE --->
                                        <div class="d-block d-lg-none">
                                            <div class="row">
                                                <div v-if="gotImage(job)" class="col" style='overflow:hidden;text-align:center;'>
                                                    <img :src="job.picture" style='width:340px;'>
                                                </div>
                                            </div>
                                            <div class="row" v-show="isSubscribed(job.id)">
                                                <div class="col">
                                                    <b>@{{getSubscriptionState(job.id)}}</b>
                                                </div>
                                            </div>
                                            <div class="row margin-top-20">
                                                <div class="col fixed-height-50"  v-html='(job.description!=null) ? job.description.split("\r\n").join("<br>") : ""'>
                                                </div>
                                            </div>
                                            <div class="row margin-top-10">
                                                <div class="col fixed-height-50" v-html='(job.required!=null) ? job.required.split("\r\n").join("<br>") : ""'>
                                                </div>
                                            </div>
                                            <div class="row margin-top-20">
                                                <div class="col">
                                                    <button class="btn btn-default" v-on:click="viewJob(job)">{{ __('candidatesjobs.view') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </template>
                        <div class="col-lg-4 margin-top-20" >
                            <div class="card elegant-mini" :class="[retTalentBank ? 'yellow' : 'green']">
                                <div class="card-header">
                                    <h5 v-if="retTalentBank" style='font-weight:bold;'>{{ __('candidatesjobs.foundnot') }}</h5>
                                    <h5 v-else>{{ __('candidatesjobs.talentbank') }}</h5>
                                    <small v-if="retTalentBank" style='text-transform:uppercase;font-weight:bold;'>{{ __('candidatesjobs.jointalentbank') }}</small>
                                    <small v-else style='text-transform:uppercase;'>{{ __('candidatesjobs.subscribed') }}</small>
                                </div>
                                <div class="card-body">
                                    <div class="row" >
                                        <div class="col">
                                        </div>
                                    </div>
                                    <div class="row margin-top-20">
                                        <div class="col fixed-height-50" >
                                            {{ __('candidatesjobs.forgetnotinterests') }}
                                        </div>
                                    </div>
                                    <div class="row margin-top-20">
                                        <div class="col fixed-height-50">
                                            {{ __('candidatesjobs.alwaysnewjobs') }}
                                        </div>
                                    </div>
                                    <div class="row margin-top-20" v-show="retTalentBank">
                                        @if(!empty($logged_in))
                                            <div class="col">
                                                <button class="btn btn-warning" v-on:click="changeTalentBank()">{{ __('candidatesjobs.participate') }}</button>
                                            </div>
                                        @else
                                            <div class="col">
                                                <a href='/login' class="btn btn-warning" style='padding:15px;' v-on:click="changeTalentBank()">{{ __('candidatesjobs.participate') }}</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row margin-top-20" v-show="!retTalentBank">
                                        <div class="col">
                                            <button class='btn btn-green' v-on:click="changeTalentBank()"><i class='fa fa-check'></i> {{ __('candidatesjobs.participating') }}</button>
                                        </div>  
                                    </div>
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