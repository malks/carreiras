@extends('layouts/public')

@section('content')

    @csrf
    <input type="hidden" id='job-id' value={{$data->id}}>
    @if(!empty($logged_in))
        <input type="hidden" id='user-id' value={{$candidate->id}}>
    @endif
    <div class='row'>
        <div class="offset-1 col-10">

            <div>
                <div>
                    <div class='row'>
                        <div class="col-12">
                
                            <div class="columns small-12 small-centered">
                                <p>&nbsp;</p>
                                <div class="animatedParent animateOnce">
                                    <h3 class="head-h3">{{ $data->name }}</h3>
                                    <div class="col-lg-12 text-center">
                                        <img src='{{$data->picture}}' id='current-picture' style='max-height:400px;'>
                                    </div>
                                </div>
                            </div>
                
                        </div>
                    </div>
                </div>
                <div>
                    <br>
                    <br>
                    <hr>
                    <div class="row margin-top-60">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.area') }}:</label>
                            <span> {{$data->field->name}}</span>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.unit') }}:</label>
                            <span> {{$data->unit->name}}</span>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.city') }}:</label>
                            <span> {{$data->unit->city}}</span>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.state') }}:</label>
                            <span> {{$data->unit->state}}</span>
                        </div>
                    </div>        
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.job') }}:</label>
                            <span> {{$data->name}}</span>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.description') }}:</label>
                            <span> {{$data->description}} </span>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.activities') }}:</label>
                            <span> {{$data->activities}} </span>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.requirements') }}:</label>
                            <span> {{$data->required}} </span>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                        <div class="offset-lg-1 col-lg-10">
                            <label for="" class="control-label">{{ __('candidatesjobs.desirable') }}:</label>
                            <span> {{$data->desirable}} </span>
                        </div>
                    </div>
                    <br>
                    <br>
                    <hr>
                </div>
                <div class="row margin-top-30">
                    <div class="offset-1 col-2">
                        <a href="/jobs" style='padding:15px;' class='btn btn-default'>Ver mais vagas</a>
                    </div>
                    <div class="offset-1 col-2">
                        @if (!empty($logged_in))
                            @if (empty($subscribed))
                                <button type='button' class='btn btn-secondary' id='subscribe'>Inscrever-se</button>
                            @else
                                <button type='button' class='btn btn-green' id='unsubscribe'>Inscrito</button>
                            @endif
                        @else
                            <a href='/login?afterlogin=/detalhe-vaga/{{$data->id}}'  style='padding:15px;' class='btn btn-secondary' id='subscribe'>Inscrever-se</a>
                        @endif
                    </div>
                </div>
    
            </div>

        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
@stop

<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (document.getElementById('subscribe')){
            document.getElementById('subscribe').addEventListener('click', function (event) {
                document.getElementById('subscribe').disabled=true;
                let tempData = {};
                tempData['_token']=document.getElementsByName('_token')[0].value;
                tempData['job_id']=document.getElementById('job-id').value;
                tempData['candidate_id']=document.getElementById('user-id').value;
                tempData['obs']='';
                tempData['states']=[{name:'Inscrito'}];

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {

                    if (xhr.readyState !== 4) return;

                    if (xhr.status >= 200 && xhr.status < 300) {
                        window.location.reload();
                    } 

                };
                xhr.open("POST","/apply-for-job");
                xhr.setRequestHeader('Content-Type', 'application/json');
                console.log(tempData);
                xhr.send(JSON.stringify(tempData));
            });
        }

        if (document.getElementById('unsubscribe')){
            document.getElementById('unsubscribe').addEventListener('click', function (event) {
                document.getElementById('unsubscribe').disabled=true;
                let tempData = {};
                tempData['_token']=document.getElementsByName('_token')[0].value;
                tempData['job_id']=document.getElementById('job-id').value;
                tempData['candidate_id']=document.getElementById('user-id').value;

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {

                    if (xhr.readyState !== 4) return;

                    if (xhr.status >= 200 && xhr.status < 300) {
                        window.location.reload();
                    } 

                };
                xhr.open("POST","/cancel-application");
                xhr.setRequestHeader('Content-Type', 'application/json');
                console.log(tempData);
                xhr.send(JSON.stringify(tempData));
            });
        }

    }, false);
</script>