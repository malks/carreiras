@extends('adminlte::page')

@section('title', 'Edição de Vaga | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
    @if ($errors->has('field_id'))
        <div class="alert alert-danger alert-dismissible">{{ $errors->first('field_id') }}</div>
    @endif
	<form method='POST' action='/adm/jobs/save' enctype='multipart/form-data'>
		@csrf
	    <div class="card" check-jobs-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Vaga</h5>
	    	</div>
	        <div class="card-body">
	        	<div class='row'>
	        		<div class=" col-sm-12 col-lg-1">
	        			<a class="btn btn-secondary" href='/adm/jobs'>Voltar</a>
	        		</div>
	        		<div class=" col-sm-12 col-lg-1">
	        			<button class="btn btn-primary" id='save' type='submit' >Salvar</button>
	        		</div>
	        	</div>
                <div class="row margin-top-10">
                    <div class="col-lg-6">
                        <label for="">Imagem para o Cargo</label><br>
                        <input type="file" name='picture' id='selected-picture' onchange="changedPicture()"><br><br>
                        <img src='{{$data->picture}}' id='current-picture' style='width:300px;height:300px;'>
                    </div>
	        	</div>
                <div class="row margin-top-10">
                    <div class="col-lg-2">
                        <label for="">Código Cargo Senior</label>
                        <input type="text" class='form-control text-right' readonly value='{{$data->cod_senior}}'>
                    </div>
                    <div class="col-lg-2">
                        <label for="">Código Requisição Senior</label>
                        <input type="text" class='form-control text-right' readonly value='{{$data->cod_rqu_senior}}'>
                    </div>
                    <div class="col-lg-2">
                        <label for="">Código Estrutura do Cargo Senior</label>
                        <input type="text" class='form-control text-right' readonly value='{{$data->cod_est_senior}}'>
                    </div>
                    <div class="col-lg-2">
                        <label for="">Código Hierarquia do Cargo Senior</label>
                        <input type="text" class='form-control text-right' readonly value='{{$data->cod_hie_senior}}'>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <input type='hidden' name='id' value='{{$data->id}}'>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Nome</label>
                        <input type='text' class='form-control' name='name' value='{{$data->name}}'/>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="status-selector">Status</label>
                        <select name="status" id="status-selector" class='form-control'>
                            <option value="0" @if ($data->status==0) selected @endif>Inativa</option>
                            <option value="1" @if ($data->status==1) selected @endif>Ativa</option>
                        </select>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="field-selector">Área</label>
                        <select name="field_id" id="field-selector" class='form-control'>
                            <option value="0">Área</option>
                            @foreach($fields as $field)
                                <option value="{{$field->id}}" @if($data->field_id==$field->id) selected @endif>{{$field->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" col-sm-12 col-lg">
                        <label for="unit-selector">Unidade</label>
                        <select name="unit_id" id="unit-selector" class='form-control'>
                            <option value="0">Unidade</option>
                            @foreach($units as $unit)
                                <option value="{{$unit->id}}"  @if($data->unit_id==$unit->id) selected @endif>{{$unit->name}}</option>
                            @endforeach
                        </select>
                    </div>                    
                </div>
                <div class="row margin-top-10">
                    <div class="col-sm-12 col-lg-6">
                        <label for="data-start">Data Início Recrutamento</label>
                        <input type="date" class="form-control" id='data-start' name='start' value='{{ (!empty(old('start'))) ? old('start') : $data->start}}'>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <label for="data-end">Data Fim Recrutamento</label>
                        <input type="date" class="form-control" id='data-end' name='end' value='{{(!empty(old('end'))) ? old('end') : $data->end}}'>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-period">Período de Trabalho (Turno)</label>
                        <input class='form-control' id='data-period' name='period' value='{{(!empty(old('period'))) ? old('period') : $data->period}}'/>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-description">Descrição</label>
                        <textarea class='form-control' id='data-description' name='description'>{{(!empty(old('description'))) ? old('description') : $data->description}}</textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-activities">Atividades</label>
                        <textarea class='form-control' id='data-activities' name='activities'>{{(!empty(old('activities'))) ? old('activities') : $data->activities}}</textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Requisitos</label>
                        <textarea class='form-control' name='required'>{{(!empty(old('required'))) ? old('required') : $data->required}}</textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Desejável</label>
                        <textarea class='form-control' name='desirable'>{{(!empty(old('desirable'))) ? old('desirable') : $data->desirable}}</textarea>
                    </div>
                </div>
                <div class="row margin-top-10" id='jobs-tags'>
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Tags</label>
                        <input type="hidden" id='initial-tags' value='{{json_encode($data->tags)}}'>
                        <input type="hidden" id='all-tags' value='{{json_encode($tags)}}'>
                        <input name='tags' type='hidden' v-model='stringedTags'>
                        <ul class='interests-holder' 
                            id='interests-holder' 
                            v-on:mousedown.stop.prevent="targetInterestsInputShow" 
                            v-on:mouseup.stop.prevent="targetInterestsInputFocus" 
                            >
                            <template v-for='(tag,idx) in selectedTags'>
                                <li><span  class='badge'>@{{tag.name}} <i class="fa fa-times-circle" v-on:click="removeTag(idx)"></i></span></li>
                            </template>
                            <li  v-show='interestInput' >
                                <input 
                                    type="text" 
                                    v-model="currentInterest" 
                                    :style="currentInterestSize" 
                                    class='interests-input' 
                                    id='interests-input' 
                                    v-on:blur='targetInterestsInputHide' 
                                    v-on:keyup.prevent.stop="filterTags" 
                                    v-on:keydown.stop.exact.backspace="if (currentInterest.length==0) removeTag(selectedTags.length-1)" 
                                    v-on:keydown.prevent.stop.tab="selectTag()" 
                                    v-on:keydown.prevent.stop.enter="selectTag()"
                                >
                            </li>
                        </ul>
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

<script type='text/javascript'>
    function changedPicture(){
        $('#current-picture').attr('src',URL.createObjectURL($('#selected-picture')[0].files[0]))
    }
</script>