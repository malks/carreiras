@extends('adminlte::page')

@section('title', 'Edição de Estados | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form id='app' method='POST' action='/adm/states-mails/save' enctype='multipart/form-data'>
		@csrf
	    <div class="card" check-states-mails-edit>
	    	<div class='card-header'>
	    		<h5>Edição de E-mails de Status</h5>
	    	</div>
	        <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class='row'>
                            <div class=" col-sm-12 col-lg-1">
                                <a class="btn btn-secondary" href='/adm/states-mails'>Voltar</a>
                            </div>
                            <div class=" col-sm-12 col-lg-1">
                                <button class="btn btn-primary" id='save' type='submit' >Salvar</button>
                            </div>
                        </div>
                        @if (!empty($data->id))
                            <div class="row margin-top-10">
                                <div class="col">
                                    <small><a href='/view-mail/{{$data->id}}' target='_blank'>Pré-visualizar</a></small>
                                </div>
                            </div>
                        @endif
    
                        <div class="row margin-top-10">
                            <input type='hidden' name='id' value='{{$data->id}}'>
                            <input type='hidden' id='full-data'  value='{{urlencode(json_encode($data->toArray()))}}'>
                            <input type='hidden' id='all-states' value='{{urlencode(json_encode($all_states))}}'>
                            <input type='hidden' id='linked-states' value='{{urlencode(json_encode($linked_states))}}'>
                            <div class=" col-sm-12">
                                <label for="data-name">Nome</label>
                                <input type='text' class='form-control' name='name' value='{{$data->name}}'/>
                            </div>
                        </div>
                        <div class="row margin-top-50">
                            <div class=" col-sm-12">
                                <label for="data-header-type">Tipo de Topo</label>
                                <select name="header_type" v-model='header_type' id="" class="form-control">
                                    <option value='text'  >Texto</option>
                                    <option value='image' >Imagem</option>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12">
                                <label for="data-header">Topo</label>

                                <br>
                                <h6 style='margin-left:10px;float:left;'>Cor de Fundo:</h6>
                                <input style='margin-left:10px;float:left;'  type="color" name='header_background' v-model='header_background' value='{{(!empty($data->header_background)) ? $data->header_background : '#ffffff'}}'>

                                <br><br>
                                <h6 style='margin-left:10px;float:left;'>Cor de Fonte:</h6>
                                <input style='margin-left:10px;float:left;'  type="color" name='header_fontcolor' value='{{(!empty($data->header_fontcolor)) ? $data->header_fontcolor : '#000000'}}'><br><br>

                                <textarea v-if="header_type && header_type=='text'" type='text' class='form-control' name='header_value' v-model='header_value'></textarea>
                                <input v-if="header_type && header_type=='image'" type='file' class='form-control' name='header_value'  id='header-image-value' v-on:change='changeHeaderImage()'  />
                                <img v-if="header_type=='image'" style='margin-top:10px;max-height:200px;' :style="'background-color:'+header_background" :src='header_value' alt="">
                            </div>
                        </div>
                        <div class="row margin-top-50">
                            <div class=" col-sm-12">
                                <hr>
                                <label for="data-body-type">Tipo de Corpo</label>
                                <select name="body_type" v-model='body_type' id="" class="form-control">
                                    <option value='text'  >Texto</option>
                                    <option value='image' >Imagem</option>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12">
                                <label for="data-body">Corpo</label>
                                
                                <br>
                                <h6 style='margin-left:10px;float:left;'>Cor de Fundo:</h6>
                                <input style='margin-left:10px;float:left;' type="color"  name='body_background' value='{{(!empty($data->header_background)) ? $data->body_background : '#ffffff'}}'>

                                <br><br>
                                <h6 style='margin-left:10px;float:left;'>Cor de Fonte:</h6>
                                <input style='margin-left:10px;float:left;'  type="color" name='body_fontcolor' value='{{(!empty($data->body_fontcolor)) ? $data->body_fontcolor : '#000000'}}'><br><br>

                                <textarea v-if="body_type=='text'" type='text' class='form-control' name='body_value' v-model='body_value'></textarea>
                                <input v-if="body_type && body_type=='image'" type='file' class='form-control' name='body_value'  id='body-image-value' v-on:change='changeBodyImage()'   />
                                <img v-if="body_type=='image'" style='margin-top:10px;max-height:200px;background-color:#000;' :src='body_value' alt="">
                            </div>
                        </div>
                        <div class="row margin-top-50">
                            <div class=" col-sm-12">
                                <hr>
                                <label for="data-footer-type">Tipo de Rodapé</label>
                                <select name="footer_type" v-model='footer_type' id="" class="form-control">
                                    <option value='text'  >Texto</option>
                                    <option value='image' >Imagem</option>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12">
                                <label for="data-footer">Rodapé</label>

                                <br>
                                <h6 style='margin-left:10px;float:left;'>Cor de Fundo:</h6>
                                <input style='margin-left:10px;float:left;' type="color"  name='footer_background' value='{{(!empty($data->footer_background)) ? $data->footer_background : '#ffffff'}}'>

                                <br><br>
                                <h6 style='margin-left:10px;float:left;'>Cor de Fonte:</h6>
                                <input style='margin-left:10px;float:left;'  type="color" name='footer_fontcolor' value='{{(!empty($data->footer_fontcolor)) ? $data->footer_fontcolor : '#000000'}}'><br><br>

                                <textarea v-if="footer_type=='text'" type='text' class='form-control' name='footer_value' v-model='footer_value' ></textarea>
                                <input v-if="footer_type && footer_type=='image'" type='file' class='form-control' name='footer_value'  id='footer-image-value' v-on:change='changeFooterImage()' />
                                <img v-if="footer_type=='image'" style='margin-top:10px;max-height:200px;background-color:#000;' :src='footer_value' alt="">
                            </div>
                        </div>        
                    </div>
                    <div class=" col-sm-12 col-lg-6 margin-top-50">
                        <label for="data-linked-states">
                            Status Atrelados
                            <br>
                            <small>*Salve para adicionar status ao e-mail</small>
                        </label>
                        
                        <br>
                        <button v-on:click='addState' :disabled='id==null || id==1' type='button' class='btn btn-primary'>Adicionar</button>
                        <template v-if='id!=null' v-for='(state,idx) in states'>
                            <div class="row margin-top-10">
                                <div class="col-lg-4 col-sm-7">
                                    <select type="text" class='form-control' v-model='state' name='states[]'>
                                        <template v-for="instate in all_states">
                                            <option :value="instate.id" :selected="instate.id==state.id" >@{{instate.name}}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-5">
                                    <button class='btn btn-danger' v-on:click='removeState(idx)'><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </template>
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