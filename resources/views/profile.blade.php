@extends('layouts/public')

@section('content')
    <div class='row'>
        <div class="col-12">
            <form method='GET' id='app' class='margin-top-20' action='/adm/candidates/save'>
                @csrf
                <input type="hidden" class="hide" id='schooling-data' value='{{ json_encode($data->schooling) }}'>
                <input type="hidden" class="hide" id='experience-data' value='{{ json_encode($data->experience) }}'>
                <input type="hidden" class="hide" id='schooling-status' value='{{ json_encode($schooling_status) }}'>
                <input type="hidden" class="hide" id='schooling-grades' value='{{ json_encode($schooling_grades) }}'>
                <input type="hidden" class="hide" id='schooling-formation' value='{{ json_encode($schooling_formation) }}'>
                <input type="hidden" name='schoolings' :value='stringedSchoolings'>
                <input type="hidden" name='experiences' :value='stringedExperiences'>
                <input type="hidden" name='excluded_experiences' v-model='stringedExcludedExperiences'>
                <input type="hidden" name='excluded_schoolings' :value='stringedExcludedSchoolings'>

                <div class="card elegant" profile-edit>
                    <div class='card-header'>
                        <div class="animatedParent animateOnce">
                            <h3 class="head-h3">SEU PERFIL</h3>
                            <p class="head-subtitle">queremos conhecer você</p>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <hr>
        
                        <ul class="nav nav-tabs margin-left-20">
                            <li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('candidate-data') }" v-on:click="currentTab='candidate-data'" >Pessoal</a>
                            </li>
                            <li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('schooling-data') }" v-on:click="currentTab='schooling-data'" >Escolaridade</a>
                            </li>
                            <li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('experience-data') }" v-on:click="currentTab='experience-data'" >Experiência</a>
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
                        <hr>
                        <div class="tab-content">
        
                            <div class='tab-pane fade padding-top-10'  v-bind:class="{ active: isItMe('candidate-data'), show: isItMe('candidate-data') }" id="candidate-data">
        
                                <div class="row">
                                    <div class="col"><h6>Dados de Contato</h6></div>
                                </div>
                                <div class="row">
                                    <input type='hidden' name='id' value='{{$data->id}}'>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-name">Nome</label>
                                        <input type='text' class='w-input text-field white-background' name='name' id='data-name' value='{{$data->name}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-email">E-mail</label>
                                        <input type='text' class='w-input text-field white-background' id='data-email' name='email' value='{{$data->email}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-phone">Fone</label>
                                        <input type='text' class='w-input text-field white-background' id='data-phone' name='phone' value='{{$data->phone}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-mobile">Celular</label>
                                        <input type='text' class='w-input text-field white-background' id='data-mobile' name='mobile' value='{{$data->mobile}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-30">
                                    <div class="col"><h6>Endereço Residencial</h6></div>
                                </div>
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-address-zip">CEP</label>
                                        <input type='text' class='w-input text-field white-background' name='zip' id='data-address-zip' value='{{$data->zip}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-address-state">Estado</label>
                                        <input type='text' class='w-input text-field white-background' id='data-address-state' name='address_state' value='{{$data->address_state}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-address-country">País</label>
                                        <input type='text' class='w-input text-field white-background' id='data-address-country' name='address_country' value='{{$data->address_country}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-address-city">Cidade</label>
                                        <input type='text' class='w-input text-field white-background' id='data-address-city' name='address_city' value='{{$data->address_city}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-address-street">Rua</label>
                                        <input type='text' class='w-input text-field white-background' name='address_street' id='data-address-street' value='{{$data->address_street}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-2">
                                        <label for="data-address-number">Numero</label>
                                        <input type='text' class='w-input text-field white-background' name='address_number' id='data-address-number' value='{{$data->address_number}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-30">
                                    <div class="col"><h6>Naturalidade</h6></div>
                                </div>
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-natural-city">Cidade</label>
                                        <input type='text' class='w-input text-field white-background' name='natural_city' id='data-natural-city' value='{{$data->natural_city}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-natural-state">Estado</label>
                                        <input type='text' class='w-input text-field white-background' id='data-natural-state' name='natural_state' value='{{$data->natural_state}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-natural-country">País</label>
                                        <input type='text' class='w-input text-field white-background' id='data-natural-country' name='natural_country' value='{{$data->natural_country}}'/>
                                    </div>
                                </div>
                
                                <div class="row margin-top-30">
                                    <div class="col"><h6>Dados Pessoais</h6></div>
                                </div>
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-3">
                                        <label for="data-dob">Data de Nascimento</label>
                                        <input type='text' class='w-input text-field white-background' id='data-dob' name='dob' value='{{$data->dob}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-3">
                                        <label for="data-civil-state">Estado Civil</label>
                                        <select name="civil_state" id="data-civil-state" class="w-input text-field white-background">
                                            <option value="married">Casado</option>
                                            <option value="single">Solteiro</option>
                                            <option value="stable">União Estável</option>
                                        </select>
                                    </div>
                                    <div class=" col-sm-12 col-lg-3">
                                        <label for="data-gender">Genero</label>
                                        <select name="gender" id="data-gender" class="w-input text-field white-background">
                                            <option value="male">Masculino</option>
                                            <option value="female">Feminino</option>
                                            <option value="other">Outro</option>
                                        </select>
                                    </div>
                                    <div class=" col-sm-12 col-lg-3">
                                        <label for="data-gender">Casa</label>
                                        <select name="gender" id="data-gender" class="w-input text-field white-background">
                                            <option value="owned">Própria</option>
                                            <option value="rented">Alugada</option>
                                            <option value="allowed">Cedida por parentes/amigos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-height">Altura</label>
                                        <input type='text' class='w-input text-field white-background' id='data-height' name='height' value='{{$data->height}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-weight">Peso</label>
                                        <input type='text' class='w-input text-field white-background' id='data-weight' name='weight' value='{{$data->weight}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-8">
                                        <label for="data-foreigner">Estrangeiro?</label>
                                        <select class='w-input text-field white-background' id='foreigner' name='foreigner' >
                                            <option value='1' @if($data->foreigner) selected @endif>Sim</option>
                                            <option value='0'  @if(!$data->foreigner) selected @endif>Não</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-lg-4">
                                        <label for="data-arrival-date">Data de Chegada</label>
                                        <input type='text' class='w-input text-field white-background' id='data-arrival-date' name='arrival_date' value='{{$data->arrival_date}}'/>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 margin-top-10">
                                        <label for="data-foreign-register">Registro de Estrangeiro</label>
                                        <input type='text' class='w-input text-field white-background' id='data-foreign-register' name='foreign_register' value='{{$data->foreign_register}}'/>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 margin-top-10">
                                        <label for="data-foreign-emitter">Orgão Emissor</label>
                                        <input type='text' class='w-input text-field white-background' id='data-foreign-emitter' name='foreign_emitter' value='{{$data->foreign_emitter}}'/>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 margin-top-10">
                                        <label for="data-visa-expiration">Validade do Visto</label>
                                        <input type='text' class='w-input text-field white-background' id='data-visa-expiration' name='visa_expiration' value='{{$data->visa_expiration}}'/>
                                    </div>                                    
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-deficiency">Apresenta deficiencia?</label>
                                        <select class='w-input text-field white-background' id='deficiency' name='deficiency' >
                                            <option value='1' @if($data->deficiency) selected @endif>Sim</option>
                                            <option value='0'  @if(!$data->deficiency) selected @endif>Não</option>
                                        </select>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-deficiency-id">Tipo de deficiencia</label>
                                        <select class='w-input text-field white-background' id='data-deficiency-id' name='deficiency_id'>
                                            @foreach($deficiencies as $deficiency)
                                                <option value='{{$deficiency->id}}' @if($data->deficiency_id==$deficiency->id) selected @endif>{{$deficiency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-lg-4">
                                        <label for="data-cid">CID</label>
                                        <input type='text' class='w-input text-field white-background' id='data-cid' name='cid' value='{{$data->cid}}'/>
                                    </div>
                                </div>

                            </div>

                            <div class='tab-pane fade' v-bind:class="{ active: isItMe('schooling-data') , show: isItMe('schooling-data') }" id="schooling">
                                <div class="row">
                                    <div class="col"><h6>Cursos e Certificações</h6></div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-2">
                                        <button class="btn btn-default" v-on:click='addSchooling'   type='button'>Adicionar</button>
                                    </div>
                                </div>
                                <template v-for='(schooling,index) in schoolings'>
                                    <div class="row margin-top-30">
                                        <hr>
                                        <hr style='color:rgb(2, 5, 133)!important;'>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h6>#@{{index+1}}</h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <button class="btn btn-danger" v-on:click='excludeSchooling(index)' type='button'>
                                                Excluir
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class=" col-sm-12 col-lg-6">
                                            <label :for="'schooling-formation-'+index">Formação</label>
                                            <select :id="'schooling-formation'+index" class="w-input text-field white-background" v-model="schooling.formation">
                                                <template v-for="(sformation,sfidx) in schooling_formation">
                                                    <option :value="sfidx" :selected='validateKey(sfidx,schooling.formation)'>
                                                        @{{sformation}}
                                                    </option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class=" col-sm-12 col-lg-6">
                                            <label :for="'schooling-status'+index">Status</label>
                                            <select :id="'schooling-status'+index" class="w-input text-field white-background" v-model="schooling.status">
                                                <template v-for="(sstatus,ssidx) in schooling_status">
                                                    <option :value="ssidx" :selected='validateKey(ssidx,schooling.status)'>
                                                        @{{sstatus}}
                                                    </option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class=" col-sm-12 col-lg-6">
                                            <label :for="'schooling-course'+index">Curso</label>
                                            <input type='text' class='w-input text-field white-background' :id="'schooling-course-'+index" v-model="schooling.course" />
                                        </div>
                                        <div class=" col-sm-12 col-lg-6">
                                            <label for="schooling-grade">Grau</label>
                                            <select :id="'schooling-grade'+index" class="w-input text-field white-background" v-model="schooling.grade">
                                                <template v-for="(sgrade,sgidx) in schooling_grades">
                                                    <option :value="sgidx" :selected='validateKey(sgidx,schooling.grade)'>
                                                        @{{sgrade}}
                                                    </option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class=" col-sm-12 col-lg-6">
                                            <label :for="'schooling-institution'+index">Instituição</label>
                                            <input type='text' class='w-input text-field white-background' :id="'schooling-institution'+index" v-model='schooling.institution' />
                                        </div>
                                        <div class=" col-sm-12 col-lg-3">
                                            <label :for="'schooling-start'+index">Início</label>
                                            <input type='text' class='w-input text-field white-background text-center' :id="'schooling-start'+index"  v-model="schooling.start"
                                            />
                                        </div>
                                        <div class=" col-sm-12 col-lg-3">
                                            <label :for="'schooling-end'+index">Fim</label>
                                            <input type='text' class='w-input text-field white-background text-center' :id="'schooling-end'+index" v-model='schooling.end' />
                                        </div>
                                    </div>
                                </template>
                            </div>
        
                            <div class='tab-pane fade' v-bind:class="{ active: isItMe('experience-data') , show: isItMe('experience-data') }" id="experience">
                                <div class="row">
                                    <div class="col"><h6>Trabalhos Anteriores</h6></div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-2">
                                        <button class="btn btn-default" v-on:click='addExperience'   type='button'>Adicionar</button>
                                    </div>
                                </div>
                                <template v-for="(experience,index) in experiences">
                                    <div class="row margin-top-30">
                                        <hr>
                                        <hr style='color:rgb(2, 5, 133)!important;'>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h6>#@{{index+1}}</h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <button class="btn btn-danger" v-on:click='excludeExperience(index)' type='button'>
                                                Excluir
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class=" col-sm-12 col-lg-6">
                                            <label for="experience-business">Empresa</label>
                                            <input type='text' class='w-input text-field white-background' id='experience-business' v-model='experience.business' />
                                        </div>
                                        <div class=" col-sm-12 col-lg-6">
                                            <label for="experience-job">Cargo</label>
                                            <input type='text' class='w-input text-field white-background' id='experience-job' v-model='experience.job'/>
                                        </div>                                
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class=" col-sm-12 col-lg">
                                            <label for="experience-activities">Atividades</label>
                                            <textarea type='text' class='w-input text-field white-background' id='experience-activities' v-model="experience.activities">
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class=" col-sm-12 col-lg-3">
                                            <label for="experience-admission">Admissão</label>
                                            <input type='text' class='w-input text-field white-background text-center' id='experience-admission' name='experience[].admission' v-model="experience.admission"
                                            />
                                        </div>
                                        <div class=" col-sm-12 col-lg-3">
                                            <label for="experience-demission">Demissão</label>
                                            <input type='text' class='w-input text-field white-background text-center' id='experience-demission' v-model='experience.demission'/>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class='tab-pane fade'   v-bind:class="{ active: isItMe('family-data') , show: isItMe('family-data') }" id="family-data">
                                <div class="row">
                                    <div class="col"><h6>Conjuge e Filhos</h6></div>
                                </div>
        
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-spouse-name">Nome do Conjuge</label>
                                        <input type='text' class='w-input text-field white-background' id='data-spouse-name' name='spouse_name' value='{{$data->spouse_name}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-children-amount">Numero de Filhos</label>
                                        <input type='text' class='w-input text-field white-background' id='data-children-amount' name='children_amount' value='{{$data->children_amount}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-children-age">Idades dos Filhos</label>
                                        <input type='text' class='w-input text-field white-background' id='data-children-age' name='children_age' value='{{$data->children_age}}'  placeholder='10,11,12...'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg">
                                        <label for="data-children-location">Onde ficarão os fihos durante o trabalho?</label>
                                        <input type='text' class='w-input text-field white-background' id='data-children-location' name='children_location' value='{{$data->children_location}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-30">
                                    <div class="col"><h6>Pais</h6></div>
                                </div>
        
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-8">
                                        <label for="data-father-name">Nome do Pai</label>
                                        <input type='text' class='w-input text-field white-background' id='data-father-name' name='father_name' value='{{$data->father_name}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-father-dob">Data de nascimento do Pai</label>
                                        <input type='text' class='w-input text-field white-background' id='data-father-dob' name='father_dob' value='{{$data->father_dob}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-8">
                                        <label for="data-mother-name">Nome da Mãe</label>
                                        <input type='text' class='w-input text-field white-background' id='data-mother-name' name='mother_name' value='{{$data->mother_name}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-mother-dob">Data de nascimento da Mãe</label>
                                        <input type='text' class='w-input text-field white-background' id='data-mother-dob' name='mother_dob' value='{{$data->mother_dob}}'/>
                                    </div>
                                </div>                        
                            </div>
            
                            <div class='tab-pane fade' v-bind:class="{ active: isItMe('documents') , show: isItMe('documents') }" id="documents">
                                <div class="row">
                                    <div class="col"><h6>Dados Civeis</h6></div>
                                </div>

                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-cpf">CPF</label>
                                        <input type='text' class='w-input text-field white-background' id='data-cpf' name='cpf' value='{{$data->cpf}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-work-card">Carteira de Trabalho</label>
                                        <input type='text' class='w-input text-field white-background' id='data-work-card' name='work_card' value='{{$data->work_card}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-serie">Serie</label>
                                        <input type='text' class='w-input text-field white-background' id='data-serie' name='serie' value='{{$data->serie}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-serie">PIS</label>
                                        <input type='text' class='w-input text-field white-background' id='data-serie' name='serie' value='{{$data->serie}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-rg">RG</label>
                                        <input type='text' class='w-input text-field white-background' id='data-rg' name='rg' value='{{$data->rg}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-rg-emitter">Órgão Expedidor</label>
                                        <input type='text' class='w-input text-field white-background' id='data-rg-emitter' name='rg_emitter' value='{{$data->rg_emitter}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-elector-card">Título de Eleitor</label>
                                        <input type='text' class='w-input text-field white-background' id='data-elector-card' name='elector_card' value='{{$data->elector_card}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-veteran-card">Certificado de Reservista</label>
                                        <input type='text' class='w-input text-field white-background' id='data-veteran-card' name='veteran_card' value='{{$data->veteran_card}}'/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class='btn btn-info margin-left-40' v-on:click="saveProfile" v-bind:disabled="saving">SALVAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop


<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>