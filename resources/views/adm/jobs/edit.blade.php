@extends('adminlte::page')

@section('title', 'Edição de Vaga | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' action='/adm/jobs/save'>
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
                        <input type="date" class="form-control" id='data-start' name='start' value='{{$data->start}}'>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <label for="data-end">Data Fim Recrutamento</label>
                        <input type="date" class="form-control" id='data-end' name='end' value='{{$data->end}}'>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-period">Período de Trabalho (Turno)</label>
                        <input class='form-control' id='data-period' name='period' value='{{$data->period}}'/>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-description">Descrição</label>
                        <textarea class='form-control' id='data-description' name='description'>{{$data->description}}</textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-activities">Atividades</label>
                        <textarea class='form-control' id='data-activities' name='activities'>{{$data->activities}}</textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Requisitos</label>
                        <textarea class='form-control' name='required'>{{$data->required}}</textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class=" col-sm-12 col-lg">
                        <label for="data-name">Desejável</label>
                        <textarea class='form-control' name='desirable'>{{$data->desirable}}</textarea>
                    </div>
                </div>
			</div>
		</div>
	</form>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop