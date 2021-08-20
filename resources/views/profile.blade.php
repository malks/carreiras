@extends('layouts/public')

@section('content')
    <div class='row'>
        <div class="col-12">
            <form method='GET' id='app' class='margin-top-20' action='/adm/candidates/save'>
                @csrf
                <input type="hidden" class="hide" id='schooling-data' value='{{ json_encode($data->schooling) }}'>
                <input type="hidden" class="hide" id='experience-data' value='{{ json_encode($data->experience) }}'>
                <input type="hidden" class="hide" id='tags-data' value='{{ json_encode($tags) }}'>
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
                            <li class="nav-item">
                                <a class='nav-link' v-bind:class="{  active: isItMe('extra') }" v-on:click="currentTab='extra'" >Informações Adicionais</a>
                            </li>
                            <li class="nav-item">
                                <a class='nav-link' v-bind:class="{  active: isItMe('questionary') }" v-on:click="currentTab='questionary'" >Questionário de Seleção</a>
                            </li>
                            <!--li class="nav-item">
                                <a  v-bind:class="nav-link { active: isItMe('candidate-data') }" v-on:click="currentTab='candidate-data'" href="#" tabindex="-1" aria-disabled="alwaysTrue">Disabled</a>
                            </li-->
                        </ul>
                        <hr>
                        <div class="tab-content">
        
                            <div class='tab-pane fade padding-top-10'  v-bind:class="{ active: isItMe('candidate-data'), show: isItMe('candidate-data') }" id="candidate-data">
        
                                <div class="row">
                                    <div class="col"><h5>Dados de Contato</h5></div>
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
                                        <label for="data-ddd-phone">Fone</label>
                                        <input type='text' class='w-input text-field white-background' id='data-ddd-phone' name='ddd_phone' value='{{$data->ddd_phone}}'/>
                                        <input type='text' class='w-input text-field white-background' id='data-phone' name='phone' value='{{$data->phone}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-ddd-mobile">Celular</label>
                                        <input type='text' class='w-input text-field white-background' id='data-ddd-mobile' name='ddd_mobile' value='{{$data->ddd_mobile}}'/>
                                        <input type='text' class='w-input text-field white-background' id='data-mobile' name='mobile' value='{{$data->mobile}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-30">
                                    <div class="col"><h5>Endereço Residencial</h5></div>
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
                                    <div class="col"><h5>Naturalidade</h5></div>
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
                                    <div class="col"><h5>Dados Pessoais</h5></div>
                                </div>
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-3">
                                        <label for="data-dob">Data de Nascimento</label>
                                        <input type='date' class='w-input text-field white-background' id='data-dob' name='dob' value='{{$data->dob}}'/>
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
                                        <input type='date' class='w-input text-field white-background' id='data-arrival-date' name='arrival_date' value='{{$data->arrival_date}}'/>
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
                                        <input type='date' class='w-input text-field white-background' id='data-visa-expiration' name='visa_expiration' value='{{$data->visa_expiration}}'/>
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
                                    <div class="col"><h5>Cursos e Certificações</h5></div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-2">
                                        <button class="btn btn-default" v-on:click='addSchooling'   type='button'>Adicionar</button>
                                    </div>
                                </div>
                                <template v-for='(schooling,index) in schoolings'>
                                    <div class="row margin-top-30">
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h5>#@{{index+1}}</h5>
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
                                            <input type='date' class='w-input text-field white-background text-center' :id="'schooling-start'+index"  v-model="schooling.start"
                                            />
                                        </div>
                                        <div class=" col-sm-12 col-lg-3">
                                            <label :for="'schooling-end'+index">Fim</label>
                                            <input type='date' class='w-input text-field white-background text-center' :id="'schooling-end'+index" v-model='schooling.end' />
                                        </div>
                                    </div>
                                </template>
                            </div>
        
                            <div class='tab-pane fade' v-bind:class="{ active: isItMe('experience-data') , show: isItMe('experience-data') }" id="experience">
                                <div class="row">
                                    <div class="col"><h5>Trabalhos Anteriores</h5></div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-2">
                                        <button class="btn btn-default" v-on:click='addExperience'   type='button'>Adicionar</button>
                                    </div>
                                </div>
                                <template v-for="(experience,index) in experiences">
                                    <div class="row margin-top-30">
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h5>#@{{index+1}}</h5>
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
                                            <input type='date' class='w-input text-field white-background text-center' id='experience-admission' name='experience[].admission' v-model="experience.admission"
                                            />
                                        </div>
                                        <div class=" col-sm-12 col-lg-3">
                                            <label for="experience-demission">Demissão</label>
                                            <input type='date' class='w-input text-field white-background text-center' id='experience-demission' v-model='experience.demission'/>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class='tab-pane fade'   v-bind:class="{ active: isItMe('family-data') , show: isItMe('family-data') }" id="family-data">
                                <div class="row">
                                    <div class="col"><h5>Conjuge e Filhos</h5></div>
                                </div>
        
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-spouse-name">Nome do Conjuge</label>
                                        <input type='text' class='w-input text-field white-background' id='data-spouse-name' name='spouse_name' value='{{$data->spouse_name}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-spouse-job">Profissão do Conjuge</label>
                                        <input type='text' class='w-input text-field white-background' id='data-spouse-job' name='spouse_job' value='{{$data->spouse_job}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-6">
                                        <label for="data-children-amount">Numero de Filhos</label>
                                        <input type='text' class='w-input text-field white-background' id='data-children-amount' name='children_amount' value='{{$data->children_amount}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-6">
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
                                    <div class="col"><h5>Pais</h5></div>
                                </div>
        
                                <div class="row">
                                    <div class=" col-sm-12 col-lg-8">
                                        <label for="data-father-name">Nome do Pai</label>
                                        <input type='text' class='w-input text-field white-background' id='data-father-name' name='father_name' value='{{$data->father_name}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-father-dob">Data de nascimento do Pai</label>
                                        <input type='date' class='w-input text-field white-background' id='data-father-dob' name='father_dob' value='{{$data->father_dob}}'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class=" col-sm-12 col-lg-8">
                                        <label for="data-mother-name">Nome da Mãe</label>
                                        <input type='text' class='w-input text-field white-background' id='data-mother-name' name='mother_name' value='{{$data->mother_name}}'/>
                                    </div>
                                    <div class=" col-sm-12 col-lg-4">
                                        <label for="data-mother-dob">Data de nascimento da Mãe</label>
                                        <input type='date' class='w-input text-field white-background' id='data-mother-dob' name='mother_dob' value='{{$data->mother_dob}}'/>
                                    </div>
                                </div>                        
                            </div>
            
                            <div class='tab-pane fade' v-bind:class="{ active: isItMe('documents') , show: isItMe('documents') }" id="documents">
                                <div class="row">
                                    <div class="col"><h5>Dados Civeis</h5></div>
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
                                        <label for="data-pis">PIS</label>
                                        <input type='text' class='w-input text-field white-background' id='data-pis' name='serie' value='{{$data->serie}}'/>
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

                            <div class="tab-pane fade" v-bind:class="{ active: isItMe('extra') , show: isItMe('extra') }" id="extra">
                                <div class="row">
                                    <div class="col"><h5>Informações Adicionais</h5></div>
                                </div>

                                <div class="row margin-top-10">
                                    <div class=" col-sm-12">
                                        <label for="data-interests">Interesses</label>
                                        <input id='data-interests' name='interests' type='hidden' value={{json_encode($data->interests->toArray())}}>
                                        <ul class='interests-holder' id='interests-holder' v-on:mousedown.stop.prevent="targetInterestsInputShow" v-on:mouseup.stop.prevent="targetInterestsInputFocus" >
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
                                    <div class="col-sm-12">
                                        <template v-for='tag in filteredTags'>
                                            @{{tag.name}} &nbsp
                                        </template>
                                    </div>
                                </div>

                                <div class="row margin-top-30">
                                    <div class=" col-sm-12">
                                        <label for="data-skills">Habilidades</label>
                                        <textarea name="skills" id="data-skills"  style='width: 100%;border-radius: 5px;height:150px;'></textarea>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-30">
                                    <div class=" col-sm-12">
                                        <label for="data-others">Outros</label>
                                        <textarea name="others" id="data-others"  style='width: 100%;border-radius: 5px;height:150px;'></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class='tab-pane fade padding-top-10'  v-bind:class="{ active: isItMe('questionary'), show: isItMe('questionary') }" id="questionary">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="data-worked-earlier-at-lunelli">1. Trabalhou anteriormente na Lunelli?</label>
                                        <select class='w-input text-field white-background'  name='worked_earlier_at_lunelli' id='data-worked-earlier-at-lunelli'>
                                            <option value="0" @if($data->worked_earlier_at_lunelli==0) selected @endif>Não</option>
                                            <option value="1" @if($data->worked_earlier_at_lunelli==1) selected @endif>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="data-worked-earlier-at-lunelli-period-start">1.a. Início</label>
                                        <input class='w-input text-field white-background' type='date' value="{{$data->lunelli_earlier_work_period_start}}" name='lunelli_earlier_work_period_start' id='data-lunelli-earlier-work-period-start'/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="data-worked-earlier-at-lunelli-period-end">1.b. Fim</label>
                                        <input class='w-input text-field white-background' type='date' value="{{$data->lunelli_earlier_work_period_end}}" name='lunelli_earlier_work_period_end' id='data-worked-earlier-at-lunelli-period-end'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-6">
                                        <label for="data-time-living-in-sc">2. Há quanto tempo vive em Santa Catarina?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->time_living_in_sc}}" name='time_living_in_sc' id='data-time-living-in-sc'/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="data-cities-lived-before">3. Em que cidades viveu anteriormente?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->cities_lived_before}}" name='cities_lived_before' id='data-cities-lived-before'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-6">
                                        <label for="data-living-with">4. Mora com Quem?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->living_with}}" name='living_with' id='data-living-with'/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="data-living-with-professions">5. Qual a profissão das pessoas que moram com você?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->living_with_professions}}" name='living_with_professions' id='data-living-with-professions'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-work-commute">6. Como pretende se deslocar até a empresa?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->work_commute}}" name='work_commute' id='data-work-commute'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-4">
                                        <label for="data-last-time-doctor">7. Quando foi pela última vez ao médico?</label>
                                        <input class='w-input text-field white-background' type='date' value="{{$data->last_time_doctor}}" name='last_time_doctor' id='data-last-time-doctor'/>
                                    </div>
                                    <div class="col-lg-8">
                                        <label for="data-last-time-doctor-reason">7.a. Qual foi o motivo?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->last_time_doctor_reason}}" name='last_time_doctor_reason' id='data-last-time-doctor-reason'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-4">
                                        <label for="data-surgery">8. Ja passou por alguma cirurgia?</label>
                                        <select class='w-input text-field white-background' name='surgery' id='data-surgery'>
                                            <option value="0" @if($data->surgery==0) selected @endif>Não</option>
                                            <option value="1" @if($data->surgery==1) selected @endif>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="data-surgery-reason">8.a. Qual foi o motivo?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->surgery_reason}}" name='surgery_reason' id='data-surgery-reason'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-4">
                                        <label for="data-hospitalized">9. Já ficou internado(a) por algum motivo?</label>
                                        <select class='w-input text-field white-background'  name='hospitalized' id='data-hospitalized'>
                                            <option value="0" @if($data->hospitalized==0) selected @endif>Não</option>
                                            <option value="1" @if($data->hospitalized==1) selected @endif>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <label for="data-hospitalized-reason">9.a. Qual foi o motivo? Quanto Tempo?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->hospitalized_reason}}" name='hospitalized_reason' id='data-hospitalized-reason'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-4">
                                        <label for="data-work-accident">10. Já sofreu acidente de trabalho? </label>
                                        <select class='w-input text-field white-background'  name='work_accident' id='data-work-accident'>
                                            <option value="0" @if($data->work_accident==0) selected @endif>Não</option>
                                            <option value="1" @if($data->work_accident==1) selected @endif>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <label for="data-work-accident-where">10.a. Quando e qual empresa?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->work_accident_where}}" name='work_accident_where' id='data-work-accident-where'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-positive-personal-characteristics">11. Cite características pessoais que você considera positivas: </label>
                                        <input class='w-input text-field white-background' type='text'value="{{$data->positive_personal_characteristics}}" name='positive_personal_characteristics' id='data-positive-personal-characteristics'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-personal-aspects-for-betterment">12. Cite aspectos pessoais que você acredita que poderiam ser melhorados: </label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->personal_aspects_for_betterment}}" name='personal_aspects_for_betterment' id='data-personal-aspects-for-betterment'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-lunelli-family">13. Possui parentes ou conhecidos que trabalham na Lunelli? Informe o nome:</label>
                                        <input class='w-input text-field white-background' type='text'  value="{{$data->lunelli_family}}" name='lunelli_family' id='data-lunelli-family'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-pretended-salary">14. Pretensão salarial (mensal) em reais:</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->pretended_salary}}" name='pretended_salary' id='data-pretended-salary'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-4">
                                        <label for="data-worked-without-ctp">15. Já trabalhou sem registro em carteira?</label>
                                        <select class='w-input text-field white-background'  name='worked_without_ctp' id='data-worked-without-ctp'>
                                            <option value="0" @if($data->worked_without_ctp==0) selected @endif>Não</option>
                                            <option value="1" @if($data->worked_without_ctp==1) selected @endif>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="data-worked-without-ctp">15.a. Onde?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->worked_without_ctp_job}}" name='worked_without_ctp_job' id='data-worked-without-ctp-job'/>
                                    </div>
                                    <div class="col-lg-4
                                    ">
                                        <label for="data-worked-without-ctp">15.b. Quanto tempo?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->worked_without_ctp_how_long}}" name='worked_without_ctp_how_long' id='data-worked-without-ctp-how-long'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-4">
                                        <label for="data-previous-work-legal-action">16. Possui alguma questão trabalhista?</label>
                                        <select class='w-input text-field white-background' type='text' name='previous_work_legal_action' id='data-previous-work-legal-action'>
                                            <option value="0" @if($data->previous_work_legal_action==1) selected @endif>Não</option>
                                            <option value="1" @if($data->previous_work_legal_action==1) selected @endif>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="data-previous-work-legal-action-business">16.a. Com qual empresa?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->previous_work_legal_action_business}}" name='previous_work_legal_action_business' id='data-previous-work-legal-action-business'/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="data-previous-work-legal-action-reason">16.b. Qual o motivo?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->previous_work_legal_action_reason}}" name='previous_work_legal_action_reason' id='data-previous-work-legal-action-reason'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-professional-dream">17. Qual o seu sonho profissional?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->professional_dream}}" name='professional_dream' id='data-professional-dream'/>
                                    </div>
                                    <!--div class="col-lg-12">
                                        <label for="data-personal-dream">Qual o seu sonho pessoal?</label>
                                        <input class='w-input text-field white-background' type='text' name='personal_dream' id='data-personal-dream'/>
                                    </div-->
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-who-are-you">18. Resumidamente escreva quem é você:</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->who_are_you}}" name='who_are_you' id='data-who-are-you'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-professional-motivation">19. O que o motiva profissionalmente?</label>
                                        <input class='w-input text-field white-background' type='text' value="{{$data->professional_motivation}}" name='professional_motivation' id='data-professional-motivation'/>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-lg-12">
                                        <label for="data-what-irritates-you">20. O que o irrita?</label>
                                        <input class='w-input text-field white-background' value="{{$data->what_irritates_you}}" type='text' name='what_irritates_you' id='data-what-irritates-you'/>
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