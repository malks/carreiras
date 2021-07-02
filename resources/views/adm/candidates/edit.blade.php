@extends('adminlte::page')

@section('title', 'Edição de Área | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
	<form method='GET' id='app' action='/adm/candidates/save'>
		@csrf
	    <div class="card" check-candidates-edit>
	    	<div class='card-header'>
	    		<h5>Edição de Candidato</h5>
	    	</div>
              
	        <div class="card-body">
	        	<div class='row'>
	        		<div class=" col-sm-12 col-lg-1">
	        			<a class="btn btn-secondary" href='/adm/candidates'>Voltar</a>
	        		</div>
	        		<div class=" col-sm-12 col-lg-1">
	        			<button class="btn btn-primary" id='save' type='submit' >Salvar</button>
	        		</div>
	        	</div>
                <div class="row margin-top-20">
                    <div class=" col-sm-12 col-lg">
                        <i>Última Atualização:</i><i style='margin-left:10px;'> {{$data->updated_at}}</i>
                    </div>
                </div>

                <ul class="nav nav-tabs margin-top-20">
                    <li class="nav-item">
                        <a  class='nav-link'  v-bind:class="{ active: isItMe('candidate-data') }" v-on:click="currentTab='candidate-data'" >Candidato</a>
                    </li>
                    <li class="nav-item">
                        <a  class='nav-link'  v-bind:class="{ active: isItMe('family-data') }" v-on:click="currentTab='family-data'" >Família</a>
                    </li>
                    <li class="nav-item">
                        <a class='nav-link' v-bind:class="{  active: isItMe('documents') }" v-on:click="currentTab='documents'" >Documentos</a>
                    </li>
                    <!--li class="nav-item">
                        <a  v-bind:class="nav-link { active: isItMe('candidate-data') }" v-on:click="currentTab='candidate-data'" href="#" tabindex="-1" aria-disabled="alwaysTrue">Disabled</a>
                    </li-->
                </ul>
    

                <div class="tab-content">

                    <div class='tab-pane fade'  v-bind:class="{ active: isItMe('candidate-data'), show: isItMe('candidate-data') }" id="candidate-data">

                        <div class="row margin-top-30">
                            <div class="col"><h6>Dados de Contato</h6></div>
                        </div>
                        <div class="row">
                            <input type='hidden' name='id' value='{{$data->id}}'>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-name">Nome</label>
                                <input type='text' class='form-control' name='name' id='data-name' value='{{$data->name}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-email">E-mail</label>
                                <input type='text' class='form-control' id='data-email' name='email' value='{{$data->email}}'/>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-phone">Fone</label>
                                <input type='text' class='form-control' id='data-phone' name='phone' value='{{$data->phone}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-mobile">Celular</label>
                                <input type='text' class='form-control' id='data-mobile' name='mobile' value='{{$data->mobile}}'/>
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col"><h6>Endereço Residencial</h6></div>
                        </div>
                        <div class="row">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-address-zip">CEP</label>
                                <input type='text' class='form-control' name='zip' id='data-address-zip' value='{{$data->zip}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-address-state">Estado</label>
                                <input type='text' class='form-control' id='data-address-state' name='address_state' value='{{$data->address_state}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-address-country">País</label>
                                <input type='text' class='form-control' id='data-address-country' name='address_country' value='{{$data->address_country}}'/>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12 col-lg-4">
                                <label for="data-address-city">Cidade</label>
                                <input type='text' class='form-control' id='data-address-city' name='address_city' value='{{$data->address_city}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg-6">
                                <label for="data-address-street">Rua</label>
                                <input type='text' class='form-control' name='address_street' id='data-address-street' value='{{$data->address_street}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg-2">
                                <label for="data-address-number">Numero</label>
                                <input type='text' class='form-control' name='address_number' id='data-address-number' value='{{$data->address_number}}'/>
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col"><h6>Naturalidade</h6></div>
                        </div>
                        <div class="row">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-natural-city">Cidade</label>
                                <input type='text' class='form-control' name='natural_city' id='data-natural-city' value='{{$data->natural_city}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-natural-state">Estado</label>
                                <input type='text' class='form-control' id='data-natural-state' name='natural_state' value='{{$data->natural_state}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-natural-country">País</label>
                                <input type='text' class='form-control' id='data-natural-country' name='natural_country' value='{{$data->natural_country}}'/>
                            </div>
                        </div>
        
                        <div class="row margin-top-30">
                            <div class="col"><h6>Dados Pessoais</h6></div>
                        </div>
                        <div class="row">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-dob">Data de Nascimento</label>
                                <input type='text' class='form-control' id='data-dob' name='dob' value='{{$data->dob}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-civil-state">Estado Civil</label>
                                <select name="civil_state" id="data-civil-state" class="form-control">
                                    <option value="married">Casado</option>
                                    <option value="single">Solteiro</option>
                                    <option value="stable">União Estável</option>
                                </select>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-gender">Genero</label>
                                <select name="gender" id="data-gender" class="form-control">
                                    <option value="male">Masculino</option>
                                    <option value="female">Feminino</option>
                                    <option value="other">Outro</option>
                                </select>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-housing">Casa</label>
                                <select name="housing" id="data-housing" class="form-control">
                                    <option value="owned">Própria</option>
                                    <option value="rented">Alugada</option>
                                    <option value="allowed">Cedida por parentes/amigos</option>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-height">Altura</label>
                                <input type='text' class='form-control' id='data-height' name='height' value='{{$data->height}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-weight">Peso</label>
                                <input type='text' class='form-control' id='data-weight' name='weight' value='{{$data->weight}}'/>
                            </div>
                        </div>
    
                    </div>
    
                    <div class='tab-pane fade'   v-bind:class="{ active: isItMe('family-data') , show: isItMe('family-data') }" id="family-data">
                        <div class="row margin-top-30">
                            <div class="col"><h6>Conjuge e Filhos</h6></div>
                        </div>

                        <div class="row">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-spouse-name">Nome do Conjuge</label>
                                <input type='text' class='form-control' id='data-spouse-name' name='spouse_name' value='{{$data->spouse_name}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-children-amount">Numero de Filhos</label>
                                <input type='text' class='form-control' id='data-children-amount' name='children_amount' value='{{$data->children_amount}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-children-age">Idades dos Filhos</label>
                                <input type='text' class='form-control' id='data-children-age' name='children_age' value='{{$data->children_age}}'  placeholder='10,11,12...'/>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-children-location">Onde ficarão os fihos durante o trabalho?</label>
                                <input type='text' class='form-control' id='data-children-location' name='children_location' value='{{$data->children_location}}'/>
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col"><h6>Pais</h6></div>
                        </div>

                        <div class="row">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-father-name">Nome do Pai</label>
                                <input type='text' class='form-control' id='data-father-name' name='father_name' value='{{$data->father_name}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-father-dob">Data de nascimento do Pai</label>
                                <input type='text' class='form-control' id='data-father-dob' name='father_dob' value='{{$data->father_dob}}'/>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class=" col-sm-12 col-lg">
                                <label for="data-mother-name">Nome da Mãe</label>
                                <input type='text' class='form-control' id='data-mother-name' name='mother_name' value='{{$data->mother_name}}'/>
                            </div>
                            <div class=" col-sm-12 col-lg">
                                <label for="data-mother-dob">Data de nascimento da Mãe</label>
                                <input type='text' class='form-control' id='data-mother-dob' name='mother_dob' value='{{$data->mother_dob}}'/>
                            </div>
                        </div>                        
                    </div>
    
                    <div class='tab-pane fade' v-bind:class="{ active: isItMe('documents') , show: isItMe('documents') }" id="documents">
                        <div class=" col-sm-12 col-lg">
                            <label for="data-cpf">CPF</label>
                            <input type='text' class='form-control' id='data-cpf' name='cpf' value='{{$data->cpf}}'/>
                        </div>
                    </div>                
    
                    <div class="row margin-top-10">
                        <div class=" col-sm-12 col-lg">
                            <div class=" col-sm-12 col-lg">
                                <a href='{{$data->cv}}' target='_blank'>Ver Curriculum Atualizado</a>
                            </div>
                        </div>
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