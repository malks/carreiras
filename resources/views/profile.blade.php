<script>
    var profile_data = "{!! urlencode(json_encode($data, JSON_HEX_TAG)) !!}";
</script>
@extends('layouts/public')

@section('content')
    <div class='row'>
        <div class="col-12">
            <input type='hidden' id='current-language' value='{{$curlang}}'/>
            <form method='GET' id='app' class='margin-top-20' action='/adm/candidates/save'>
                @csrf
                <input type="hidden" class="hide" id='schooling-data'           value='{{ json_encode($data->schooling) }}'>
                <input type="hidden" class="hide" id='experience-data'          value='{{ json_encode($data->experience) }}'>
                <input type="hidden" class="hide" id='tags-data'                value='{{ json_encode($tags) }}'>
                <input type="hidden" class="hide" id='schooling-status'         value='{{ json_encode($schooling_status) }}'>
                <input type="hidden" class="hide" id='schooling-grades'         value='{{ json_encode($schooling_grades) }}'>
                <input type="hidden" class="hide" id='schooling-formation'      value='{{ json_encode($schooling_formation) }}'>
                <input type="hidden" class="hide" id='selected-languages'       value='{{ json_encode($selected_languages) }}'>
                <input type="hidden" class="hide" id='languages'                value='{{ json_encode($languages) }}'>
                <input type="hidden" name='schoolings' id='stringed-schoolings' :value='stringedSchoolings'>
                <input type="hidden" name='experiences' :value='stringedExperiences'>
                <input type="hidden" name='excluded_experiences' v-model='stringedExcludedExperiences'>
                <input type="hidden" name='excluded_schoolings' :value='stringedExcludedSchoolings'>

                <div class="card elegant" profile-edit>
                    <div class='card-header'>
                        <div class="animatedParent animateOnce">
                            <h3 class="head-h3">{{ __('profile.seuperfil') }}</h3>
                            <p class="head-subtitle">{{ __('profile.aboutyou') }}</p>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <hr>
                        <ul class="nav nav-tabs">
                            <li class="nav-item"></li>
                            <li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('candidate-data') }" v-on:click="tabTo('candidate-data')" >{{ __('profile.people') }}</a>
                            </li>
                            <li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('schooling-data') }" v-on:click="tabTo('schooling-data')" >{{ __('profile.formation') }}</a>
                            </li>
                            <li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('experience-data') }" v-on:click="tabTo('experience-data')" >{{ __('profile.experience') }}</a>
                            </li>
                            <!--li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('language-data') }" v-on:click="tabTo('language-data')" >Idiomas</a>
                            </li>
                            <li class="nav-item">
                                <a  class='nav-link'  v-bind:class="{ active: isItMe('family-data') }" v-on:click="tabTo('family-data')" >Família</a>
                            </li>
                            <li class="nav-item">
                                <a class='nav-link' v-bind:class="{  active: isItMe('extra') }" v-on:click="tabTo('extra')" >Adicionais</a>
                            </li>
                            <li class="nav-item">
                                <a class='nav-link' v-bind:class="{  active: isItMe('questionary') }" v-on:click="tabTo('questionary')" >Questionário</a>
                            </li>
                            <li class="nav-item"></li-->
                        </ul>
                        <hr>
                        <div v-show="!isItMe('success')">
                            <div class="row" v-if="!gotAvatar">
                                <div class="col" style='margin-bottom:20px;margin-left:40px;'>
                                    <span id='pic-auxer' class='text-center avatar-empty' v-on:click="changeAvatar()">
                                        <i class="fas fa-user avatar-face"></i>
                                        <i class="fas fa-upload avatar-upload"></i>
                                        <span class='avatar-face-text'>{{ __('profile.picture') }}</span>
                                        <span class='avatar-upload-text'>{{ __('profile.add') }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row" v-else>
                                <div class="col" style='margin-bottom:20px;margin-left:40px;'>
                                    <span id='pic-auxer' class='text-center avatar-empty' v-on:click="changeAvatar()">
                                        <picture>
                                            <source media="(min-width:50px,max-width:150px;)" v-bind:srcset="holdingData.picture">
                                            <img v-bind:src="holdingData.picture" style='width:auto;max-width:150px;'>
                                        </picture>
                                        <span class='avatar-face-text'>{{ __('profile.picture') }}</span>
                                        <span class='avatar-upload-text'>{{ __('profile.change') }}</span>
                                    </span>
                                </div>
                            </div>
                            <small style='margin-left:40px;'>{{ __('profile.requireddata') }}</small>
                        </div>
                        <input type="file" style='display:none;' name='picture' id='pic-picker' accept="image/*" v-on:change="setAvatar()">

                        <div v-if='errors.length>0' class="row">
                            <div class="col-lg-6 col-12">
                                <ul class='errors' v-on:click='errors=[]'>
                                    <li>
                                        {{ __('profile.beforegoingon') }}
                                    </li>
                                    <template v-for='(errorTab,idx) in errors'>
                                        <template  v-if="idx!='gotProblem'" v-for='error in errorTab'>
                                            <li>
                                                @{{error}}
                                            </li>
                                        </template>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class='tab-pane fade padding-top-10'  v-bind:class="{ active: isItMe('candidate-data'), show: isItMe('candidate-data') }" id="candidate-data">
        
                                <div class="card elegant large-header shadow">
                                    <h5>{{ __('profile.contactdata') }}</h5>
                                    <div class="card-body">
                                        <div class="row margin-top-10">
                                            <input type='hidden' name='id' value='{{$data->id}}'>
                                            <div class=" col-sm-12 col-lg-6">
                                                <label for="data-name"> {{ __('profile.requiredname') }} </label>
                                                <input type='text' required class='w-input text-field white-background' name='name' id='data-name' value='{{$data->name}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-6">
                                                <label for="data-email">{{ __('profile.requiredemail') }}</label>
                                                <input type='text' class='w-input text-field white-background' id='data-email' name='email' value='{{$data->email}}'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class=" col-sm-12 col-lg-6">
                                                @if($curlang=='ptbr')
                                                    <label for="data-ddd-phone">{{ __('profile.phone') }}</label>
                                                    <input type='text'  v-mask="'###'"  placeholder='DDI' style='width:10%;float:left;' class='w-input text-field white-background' id='data-ddi-phone' v-model='holdingData.ddi_phone' name='ddi_phone' value='{{$data->ddi_phone}}'/>
                                                    <input type='text'  v-mask="'###'"  placeholder='DDD' style='width:10%;float:left;margin-left:5px;' class='w-input text-field white-background' id='data-ddd-phone' v-model='holdingData.ddd_phone' name='ddd_phone' value='{{$data->ddd_phone}}'/>
                                                    <input type='text'  v-mask="'####-####'" v-model="holdingData.phone"  placeholder='3370-0000' style='margin-left:5px;width:70%;float:left;' class='w-input text-field white-background' id='data-phone' name='phone' value='{{$data->phone}}'/>
                                                @else
                                                    <label for="data-ddd-phone">{{ __('profile.phone') }}</label>
                                                    <input type='text'  v-mask="'###'"  placeholder='595' style='width:10%;float:left;' class='w-input text-field white-background' id='data-ddi-phone' v-model='holdingData.ddi_phone' name='ddi_phone' value='{{$data->ddi_phone}}'/>
                                                    <input type='text'  v-mask="'####'"  placeholder='AREA' style='width:10%;float:left;margin-left:5px;' class='w-input text-field white-background' id='data-ddd-phone' v-model='holdingData.ddd_phone' name='ddd_phone' value='{{$data->ddd_phone}}'/>
                                                    <input type='text'  v-mask="'###-###'" v-model="holdingData.phone"  placeholder='610-290' style='margin-left:5px;width:70%;float:left;' class='w-input text-field white-background' id='data-phone' name='phone' value='{{$data->phone}}'/>
                                                @endif
                                            </div>
                                            <div class=" col-sm-12 col-lg-6">
                                                @if($curlang=='ptbr')
                                                    <label for="data-ddd-mobile">{{ __('profile.mobile') }}</label>
                                                    <input type='text'  v-mask="'###'"  placeholder='DDI' style='width:10%;float:left;' class='w-input text-field white-background' id='data-ddi-mobile' v-model='holdingData.ddi_mobile' name='ddi_mobile' value='{{$data->ddi_mobile}}'/>
                                                    <input type='text'  v-mask="'####'" placeholder='DDD' style='width:10%;float:left;margin-left:5px;'  class='w-input text-field white-background' id='data-ddd-mobile' v-model='holdingData.ddd_mobile' name='ddd_mobile' value='{{$data->ddd_mobile}}'/>
                                                    <input type='text' placeholder='9-9999-9999' v-model='holdingData.mobile'  v-mask="'#-####-####'" style='margin-left:5px;width:70%;float:left;'  class='w-input text-field white-background' id='data-mobile' name='mobile' value='{{$data->mobile}}'/>
                                                @else
                                                    <label for="data-ddd-mobile">{{ __('profile.mobile') }}</label>
                                                    <input type='text'  v-mask="'###'"  placeholder='595' style='width:10%;float:left;' class='w-input text-field white-background' id='data-ddi-mobile' v-model='holdingData.ddi_mobile' name='ddi_mobile' value='{{$data->ddi_mobile}}'/>
                                                    <input type='text'  v-mask="'####'" placeholder='AREA' style='width:10%;float:left;margin-left:5px;'  class='w-input text-field white-background' id='data-ddd-mobile' v-model='holdingData.ddd_mobile' name='ddd_mobile' value='{{$data->ddd_mobile}}'/>
                                                    <input type='text' placeholder='9-310-280' v-model='holdingData.mobile'  v-mask="'#-###-###'" style='margin-left:5px;width:70%;float:left;'  class='w-input text-field white-background' id='data-mobile' name='mobile' value='{{$data->mobile}}'/>
                                                @endif
                                            </div>
                                        </div>
        
                                    </div>
                                </div>

                                <div class="card elegant shadow large-header margin-top-30">
                                    <h5>{{ __('profile.residenceaddress') }}</h5>
                                    <div class="card-body">
                                        <div class="row">

                                            @if($curlang=="ptbr")
                                                <div class=" col-sm-12 col-lg-4">
                                                    <label for="data-address-zip">{{ __('profile.requiredcep') }}</label>
                                                    <input type='text' v-mask="'##.###-###'" v-model="holdingData.zip" placeholder="89.250-000" class='w-input text-field white-background' v-on:blur='getCep()' name='zip' id='data-address-zip' value='{{$data->zip}}'/>
                                                </div>
                                            @endif
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-address-state">{{ __('profile.requiredstate') }}</label>
                                                <input type='text' class='w-input text-field white-background' v-model="holdingData.address_state" id='data-address-state' name='address_state' value='{{$data->address_state}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-address-country">{{ __('profile.requiredcountry') }}</label>
                                                <input type='text' class='w-input text-field white-background' v-model="holdingData.address_country" id='data-address-country' name='address_country' value='{{$data->address_country}}'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class=" col-sm-12 col-lg-2">
                                                <label for="data-address-city">{{ __('profile.requiredcity') }}</label>
                                                <input type='text' class='w-input text-field white-background' v-model="holdingData.address_city" id='data-address-city' name='address_city' value='{{$data->address_city}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-2">
                                                <label for="data-address-district">{{ __('profile.requireddistrict') }}</label>
                                                <input type='text' class='w-input text-field white-background' v-model="holdingData.address_district" id='data-address-district' name='address_district' value='{{$data->address_district}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-2">
                                                <label for="data-address-type"> {{ __('profile.typeaddress') }} </label>
                                                <select 
                                                    class='w-input text-field white-background' 
                                                    v-model="holdingData.address_type" 
                                                    name='address_type' 
                                                    id='data-address-type'
                                                >
                                                    @foreach($logradouros as $klog=>$log)
                                                        <option value="{{$klog}}">{{$log}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class=" col-sm-12 col-lg-3">
                                                <label for="data-address-street">{{ __('profile.requiredaddress') }}</label>
                                                <input type='text' class='w-input text-field white-background' v-model="holdingData.address_street" name='address_street' id='data-address-street' value='{{$data->address_street}}'/>
                                            </div>
                                            @if($curlang=="ptbr")
                                                <div class=" col-sm-12 col-lg-1">
                                                    <label for="data-address-number">{{ __('profile.addressnum') }}</label>
                                                    <input type='text' class='w-input text-field white-background' v-model="holdingData.address_number" name='address_number' id='data-address-number' value='{{$data->address_number}}'/>
                                                </div>
                                            @endif
                                            <div class=" col-sm-12 col-lg-2">
                                                <label for="data-address-complement">{{ __('profile.addresscomplement') }}</label>
                                                <input type='text' class='w-input text-field white-background' v-model="holdingData.address_complement" name='address_complement' id='data-address-complement' value='{{$data->address_complement}}'/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card elegant shadow large-header margin-top-30" >
                                    <h5>{{ __('profile.documents') }}</h5>
                                    <div class="card-body">

                                        <div class="row margin-top-10">
                                            @if ($curlang=='ptbr')
                                                <div class=" col-sm-12 col-lg-4">
                                                    <label for="data-cpf">{{ __('profile.documentcpf') }}</label>
                                                    <input type='text' v-mask="'###.###.###-##'" v-model="holdingData.cpf" placeholder="111.111.111-11" class='w-input text-field white-background' id='data-cpf' name='cpf' value='{{$data->cpf}}'/>
                                                </div>
                                            @else
                                                <div class=" col-sm-12 col-lg-4">
                                                    <label for="data-cpf">{{ __('profile.documentcpf') }}</label>
                                                    <input type='text' v-mask="'###.####'" v-model="holdingData.cpf" placeholder="111.1111" class='w-input text-field white-background' id='data-cpf' name='cpf' value='{{$data->cpf}}'/>
                                                </div>
                                            @endif
                                            <!--div class=" col-sm-12 col-lg-4">
                                                <label for="data-work-card">Carteira de Trabalho</label>
                                                <input type='text'  v-mask="'#######'" v-model="holdingData.work_card" placeholder="1234567" class='w-input text-field white-background' id='data-work-card' name='work_card' value='{{$data->work_card}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-2">
                                                <label for="data-work-card-series">Serie</label>
                                                <input type='text' v-mask="'####'" v-model="holdingData.work_card_series" placeholder="1234" class='w-input text-field white-background' id='data-work-card-series' name='work_card_series' value='{{$data->work_card_series}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-2">
                                                <label for="data-work-card-digit">Digito</label>
                                                <input type='text'   v-mask="'##'" v-model="holdingData.work_card_digit" placeholder="12" class='w-input text-field white-background' id='data-work-card-digit' name='work_card_digit' value='{{$data->work_card_digit}}'/>
                                            </div-->
                                            @if($curlang=="ptbr")
                                                <div class=" col-sm-12 col-lg-4">
                                                    <label for="data-rg">{{ __('profile.documentrg') }}</label>
                                                    <input type='text'  v-mask="'##.###.###-#####'" v-model="holdingData.rg" placeholder="12.123.123-12345" class='w-input text-field white-background' id='data-rg' name='rg' value='{{$data->rg}}'/>
                                                </div>
                                                <div class=" col-sm-12 col-lg-4">
                                                    <label for="data-rg-emitter">{{ __('profile.documentrgorgan') }}</label>
                                                    <input type='text' class='w-input text-field white-background' id='data-rg-emitter' name='rg_emitter' value='{{$data->rg_emitter}}'/>
                                                </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            @endif <!--  FECHA O IF DOS DOCUMENTOS PORQUE SENÃO QUEBRA LINHA EM ESPANHOL-->
                                            @if ($curlang=="ptbr")
                                                <div class=" col-sm-12 col-lg-3">
                                                    <label for="data-pis">{{ __('profile.documentpis') }}</label>
                                                    <input type='text'   v-mask="'###.#####.##-#'" v-model="holdingData.pis" placeholder="123.12345.12-1" class='w-input text-field white-background' id='data-pis' name='pis' value='{{$data->pis}}'/>
                                                </div>
                                            @endif
                                            <div class=" col-sm-12 col-lg-3">
                                                <label for="data-drivers-license">{{ __('profile.documentcnh') }}</label>
                                                <select name="drivers_license" id="data-drivers-license" class='w-input text-field white-background' v-model="holdingData.drivers_license">
                                                    <option value="0">{{ $bools[0] }}</option>
                                                    <option value="1">{{ $bools[1] }}</option>
                                                </select>
                                                <!--input type='text'  v-mask="'#### #### ####'" v-model="holdingData.drivers_license" placeholder="12345678901" class='w-input text-field white-background' id='data-drivers-license' name='drivers_license' value='{{$data->drivers_license}}'/-->
                                            </div>
                                            @if($curlang=="ptbr")
                                                <div class=" col-sm-12 col-lg-3">
                                                    <label for="data-elector-card">{{ __('profile.documentelector') }}</label>
                                                    <input type='text'  v-mask="'#### #### #### #'" v-model="holdingData.elector_card" placeholder="1234 1234 1234 1" class='w-input text-field white-background' id='data-elector-card' name='elector_card' value='{{$data->elector_card}}'/>
                                                </div>
                                                <div class=" col-sm-12 col-lg-3">
                                                    <label for="data-veteran-card">{{ __('profile.documentreserve') }}</label>
                                                    <input type='text'   v-mask="'##.###.#####-#'" v-model="holdingData.veteran_card" placeholder="12.123.12345-1" class='w-input text-field white-background' id='data-veteran-card' name='veteran_card' value='{{$data->veteran_card}}'/>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="card elegant shadow large-header margin-top-30">
                                    <h5>{{ __('profile.naturality') }}</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-natural-city">{{ __('profile.naturalcity') }}</label>
                                                <input type='text' class='w-input text-field white-background' name='natural_city' id='data-natural-city' value='{{$data->natural_city}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-natural-state">{{ __('profile.naturalstate') }}</label>
                                                <input type='text' class='w-input text-field white-background' id='data-natural-state' name='natural_state' value='{{$data->natural_state}}'/>
                                            </div>
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-natural-country">{{ __('profile.naturalcountry') }}</label>
                                                <input type='text' class='w-input text-field white-background' id='data-natural-country' name='natural_country' value='{{$data->natural_country}}'/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card elegant shadow large-header margin-top-30" >
                                    <h5>{{ __('profile.family') }}</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" col-sm-12 col-lg-2">
                                                <label for="data-civil-state">{{ __('profile.civilstate') }}</label>
                                                <select name="civil_state" id="data-civil-state" class="w-input text-field white-background">
                                                    <!--option value="married">Casado</option>
                                                    <option value="single">Solteiro</option>
                                                    <option value="stable">União Estável</option-->
                                                    @foreach($civil_states as $k=>$civil_state)
                                                        <option value='{{$k}}' @if ($data->civil_state==$k) selected @endif>{{ $civil_state }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-spouse-name">{{ __('profile.spousename') }}</label>
                                                <input type='text' class='w-input text-field white-background' id='data-spouse-name' name='spouse_name' value='{{$data->spouse_name}}'/>
                                            </div>
                                            <!--div class=" col-sm-12 col-lg-5">
                                                <label for="data-spouse-job">Profissão do Conjuge</label>
                                                <input type='text' class='w-input text-field white-background' id='data-spouse-job' name='spouse_job' value='{{$data->spouse_job}}'/>
                                            </div-->
                                            <div class=" col-sm-12 col-lg-3">
                                                <label for="data-children-amount">{{ __('profile.childrenamounts') }}</label>
                                                <input type='number' min=0  max=30 class='w-input text-field white-background' id='data-children-amount' name='children_amount' v-model='holdingData.children_amount' value='{{$data->children_amount}}'/>
                                            </div>
                                            <div v-show='holdingData.children_amount>0' class=" col-sm-12 col-lg-3">
                                                <label for="data-children-age">{{ __('profile.childrenages') }}</label>
                                                <input type='text' class='w-input text-field white-background' id='data-children-age' name='children_age' value='{{$data->children_age}}'  placeholder='10,11,12...'/>
                                            </div>
                                            <!--div v-show='holdingData.children_amount>0' class=" col-sm-12 col-lg-8">
                                                <label for="data-children-location">Onde ficarão os fihos durante o trabalho?</label>
                                                <input type='text' class='w-input text-field white-background' id='data-children-location' name='children_location' value='{{$data->children_location}}'/>
                                            </div-->
                                        </div>
                                        <div class="row">
                                            <div class="row margin-top-10">
                                                <div class=" col-sm-12 col-lg-8">
                                                    <label for="data-mother-name">{{ __('profile.mothername') }}</label>
                                                    <input type='text' class='w-input text-field white-background' id='data-mother-name' name='mother_name' value='{{$data->mother_name}}'/>
                                                </div>
                                                <div class=" col-sm-12 col-lg-4">
                                                    <label for="data-mother-dob">{{ __('profile.motherdob') }}</label>
                                                    <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background' id='data-mother-dob' name='mother_dob' v-model='holdingData.mother_dob'/>
                                                </div>
                                            </div>
                                            
                                            <div class="row margin-top-10">
                                                <div class=" col-sm-12 col-lg-8">
                                                    <label for="data-father-name">{{ __('profile.fathername') }}</label>
                                                    <input type='text' class='w-input text-field white-background' id='data-father-name' name='father_name' value='{{$data->father_name}}'/>
                                                </div>
                                                <div class=" col-sm-12 col-lg-4">
                                                    <label for="data-father-dob">{{ __('profile.fatherdob') }}</label>
                                                    <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background' id='data-father-dob' name='father_dob' v-model='holdingData.father_dob'/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card elegant shadow large-header margin-top-30">
                                    <h5>{{ __('profile.personaldata') }}</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-dob">{{ __('profile.dob') }}</label>
                                                <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background' id='data-dob' name='dob' v-model='holdingData.dob'/>
                                            </div>
                                            <!--div class=" col-sm-12 col-lg-4">
                                                <label for="data-gender">Genero</label>
                                                <select name="gender" id="data-gender" class="w-input text-field white-background">
                                                    <option value="m" @if ($data->gender=='m') selected @endif>Masculino</option>
                                                    <option value="f" @if ($data->gender=='f') selected @endif>Feminino</option>
                                                    <option value="o" @if ($data->gender=='o') selected @endif>Outro</option>
                                                </select>
                                            </div>
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-housing">Casa</label>
                                                <select name="housing" id="data-housing" class="w-input text-field white-background">
                                                    <option value="owned" @if ($data->housing=='owned') selected @endif >Própria</option>
                                                    <option value="rented" @if ($data->housing=='rented') selected @endif >Alugada</option>
                                                    <option value="allowed" @if ($data->housing=='allowed') selected @endif >Cedida por parentes/amigos</option>
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
                                            </div-->
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class=" col-sm-12 col-lg-8">
                                                <label for="data-foreigner">{{ __('profile.foreigner') }}</label>
                                                <select class='w-input text-field white-background' id='foreigner' name='foreigner' v-model='holdingData.foreigner'>
                                                    <option value='1' @if($data->foreigner) selected @endif>{{ __('profile.yes') }}</option>
                                                    <option value='0'  @if(!$data->foreigner) selected @endif>{{ __('profile.no') }}</option>
                                                </select>
                                            </div>
                                            <div v-show='holdingData.foreigner==1' class="col-sm-12 col-lg-4">
                                                <label for="data-arrival-date">{{ __('profile.arrivaldate') }}</label>
                                                <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background' id='data-arrival-date' name='arrival_date' v-model='holdingData.arrival_date'/>
                                            </div>
                                            <div v-show='holdingData.foreigner==1' class="col-sm-12 col-lg-4 margin-top-10">
                                                <label for="data-foreign-register">{{ __('profile.foreignerregister') }}</label>
                                                <input type='text' class='w-input text-field white-background' id='data-foreign-register' name='foreign_register' value='{{$data->foreign_register}}'/>
                                            </div>
                                            <div v-show='holdingData.foreigner==1' class="col-sm-12 col-lg-4 margin-top-10">
                                                <label for="data-foreign-emitter">{{ __('profile.foreignemitter') }}</label>
                                                <input type='text' class='w-input text-field white-background' id='data-foreign-emitter' name='foreign_emitter' value='{{$data->foreign_emitter}}'/>
                                            </div>
                                            <div v-show='holdingData.foreigner==1' class="col-sm-12 col-lg-4 margin-top-10">
                                                <label for="data-visa-expiration">{{ __('profile.visaexpiration') }}</label>
                                                <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background' id='data-visa-expiration' name='visa_expiration' v-model='holdingData.visa_expiration'/>
                                            </div>                                    
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class=" col-sm-12 col-lg-4">
                                                <label for="data-deficiency">{{ __('profile.gotdeficiency') }}</label>
                                                <select class='w-input text-field white-background' id='deficiency' name='deficiency' v-model='holdingData.deficiency'>
                                                    <option value='1' @if($data->deficiency) selected @endif>{{ __('profile.yes') }}</option>
                                                    <option value='0'  @if(!$data->deficiency) selected @endif>{{ __('profile.no') }}</option>
                                                </select>
                                            </div>
                                            <div v-show='holdingData.deficiency==1' class=" col-sm-12 col-lg-4">
                                                <label for="data-deficiency-id">{{ __('profile.deficiencytype') }}</label>
                                                <select class='w-input text-field white-background' id='data-deficiency-id' name='deficiency_id'>
                                                    <option value=''>{{ __('profile.none') }}</option>
                                                    @foreach($deficiencies as $deficiency)
                                                        <option value='{{$deficiency->id}}' @if($data->deficiency_id==$deficiency->id) selected @endif>{{$deficiency->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div v-show='holdingData.deficiency==1' class="col-sm-12 col-lg-4">
                                                <label for="data-cid">*CID</label>
                                                <input type='text' class='w-input text-field white-background' id='data-cid' name='cid' value='{{$data->cid}}'/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label for="data-worked-earlier-at-lunelli">{{ __('profile.workedearlierlunelli') }}</label>
                                                <select class='w-input text-field white-background'  name='worked_earlier_at_lunelli' id='data-worked-earlier-at-lunelli'>
                                                    <option value="0" @if($data->worked_earlier_at_lunelli==0) selected @endif>{{ __('profile.no') }}</option>
                                                    <option value="1" @if($data->worked_earlier_at_lunelli==1) selected @endif>{{ __('profile.yes') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="data-worked-earlier-at-lunelli-period-start">{{ __('profile.start') }}</label>
                                                <input class='w-input text-field white-background' type='text' v-mask="'##/##/####'" v-model="holdingData.lunelli_earlier_work_period_start" name='lunelli_earlier_work_period_start' id='data-lunelli-earlier-work-period-start'/>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="data-worked-earlier-at-lunelli-period-end">{{ __('profile.end') }}</label>
                                                <input class='w-input text-field white-background' type='text' v-mask="'##/##/####'" v-model="holdingData.lunelli_earlier_work_period_end" name='lunelli_earlier_work_period_end' id='data-worked-earlier-at-lunelli-period-end'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-lunelli-family">{{ __('profile.lunellifamily') }}</label>
                                                <input class='w-input text-field white-background' type='text'  value="{{$data->lunelli_family}}" name='lunelli_family' id='data-lunelli-family'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-6">
                                                <label for="data-time-living-in-sc">{{ __('profile.currentaddresstime') }}</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->time_living_in_sc}}" name='time_living_in_sc' id='data-time-living-in-sc'/>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="data-cities-lived-before">{{ __('profile.citylivedbefore') }}</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->cities_lived_before}}" name='cities_lived_before' id='data-cities-lived-before'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-6">
                                                <label for="data-living-with">{{ __('profile.livingwith') }}</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->living_with}}" name='living_with' id='data-living-with'/>
                                            </div>
                                            <!--div class="col-lg-6">
                                                <label for="data-living-with-professions">5. Qual a profissão das pessoas que moram com você?</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->living_with_professions}}" name='living_with_professions' id='data-living-with-professions'/>
                                            </div-->
                                        </div>
                                                
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-work-commute">{{ __('profile.workcommute') }}</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->work_commute}}" name='work_commute' id='data-work-commute'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-pretended-salary">{{ __('profile.pretendedsalary') }}</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->pretended_salary}}" name='pretended_salary' id='data-pretended-salary'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-prefered-work-period">{{ __('profile.preferedworkperiod') }}</label>
                                            </div>
                                            @foreach($work_periods as $k => $workperiod)
                                                <div class="col-lg-2">
                                                    <input style='float:left;margin-top:5px;' type='checkbox' v-model="holdingData.prefered_work_period" value="{{$k}}" name='prefered_work_period[]' id='data-prefered-work-period{{$k}}'/>
                                                    <label style='float:left;font-weight:normal;font-size:10pt;' for='data-prefered-work-period{{$k}}'>{{$workperiod}}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class='tab-pane fade padding-top-10' v-bind:class="{ active: isItMe('schooling-data') , show: isItMe('schooling-data') }" id="schooling">


                                <div class="card elegant shadow large-header " >
                                    <h5>{{ __('profile.interests') }}</h5>
                                    <div class="card-body">

                                        <div class="row margin-top-10">
                                            <div class="col-sm-12">
                                                <template v-for='(tag,tagIdx) in filteredTags'>
                                                    <template v-if="tagIdx<8">
                                                        <b v-if="tagIdx==0">
                                                            @{{tag.name}} &nbsp
                                                        </b>
                                                        <span style='cursor:pointer;' v-on:click="pickMe(tagIdx)" v-else>
                                                            @{{tag.name}} &nbsp
                                                        </span>
                                                    </template>
                                                </template>
                                                &nbsp
                                            </div>

                                            <div class=" col-sm-12 margin-top-10">
                                                <input id='data-interests' name='interests' type='hidden' value={{urlencode(json_encode($data->interests->toArray()))}}>
                                                <ul class='interests-holder' id='interests-holder' 
                                                v-on:mousedown.stop.prevent="targetInterestsInputShow" 
                                                v-on:mouseup.stop.prevent="targetInterestsInputFocus" >
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
                                                        <button type='button' v-on:click="selectTag()" style="height:36px;" class='btn btn-default'><i class='fa fa-plus'></i></button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card elegant shadow large-header margin-top-30">
                                    <h5>{{ __('profile.skills') }}</h5>
                                    <div class="card-body">
                                        <div class="row margin-top-30">
                                            <div class=" col-sm-12">
                                                <textarea name="skills" id="data-skills"  style='width: 100%;height:150px;border:1px solid #bbb;'>{{$data->skills}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card elegant shadow large-header margin-top-30">
                                    <h5>{{ __('profile.languages') }}</h5>
                                    <div class="card-body">
                                        <div class="row" >
                                            <div class="col">
                                                <button class="btn btn-default" v-on:click="addLang" type='button'>Adicionar</button>
                                            </div>
                                        </div>
                                        <input type='hidden' name='selected_languages' :value='stringedLanguages'/>
                                        <template v-for="(sellang,idx) in selected_languages">
                                            <div class="card  margin-top-10">
                                                <div class="card-body">
        
                                                    <div class="row margin-top-10">
                                                        <div class="col-lg-3">
                                                            <label>{{ __('profile.language') }}</label>
                                                            <select class="form-control" v-model='sellang.id'>
                                                                <option value="">{{ __('profile.select') }}</option>
                                                                <template v-for='lang in languages'>
                                                                    <option :value="lang.id">@{{lang.name}}</option>
                                                                </template>
                                                            </select>
                                                        </div>
                    
                                                        <div class="col-lg-3">
                                                            <label>{{ __('profile.level') }}</label>
                                                            <select v-model='sellang.pivot.level' class='form-control'>
                                                                @foreach($language_levels as $k => $llevel)
                                                                    <option value="{{$k}}">{{ $llevel }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 margin-top-20">
                                                            <button class="btn btn-danger" v-on:click="selected_languages.splice(idx,1)" type='button'>{{ __('profile.remove') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="card elegant shadow large-header margin-top-30">
                                    <h5>{{ __('profile.courses') }}</h5>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-2">
                                                <button class="btn btn-default" v-on:click='addSchooling'   type='button'>{{ __('profile.add') }}</button>
                                            </div>
                                        </div>
                                        <template v-for='(schooling,index) in schoolings'>
                                            <div class="row">
                                                <div class="col">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                </div>
                                            </div>
                                            <div class="card margin-top-30">
                                                <div class="card-body">
                                                    <button class="btn btn-danger" v-on:click='excludeSchooling(index)' type='button'>
                                                        {{ __('profile.remove') }}
                                                    </button>
            
                                                    <div class="row margin-top-10">
                                                        <div class=" col-sm-12 col-lg-6">
                                                            <label :for="'schooling-formation-'+index">*{{ __('profile.formation') }}</label>
                                                            <select :id="'schooling-formation'+index" class="w-input text-field white-background" v-model="schooling.formation">
                                                                <template v-for="(sformation,sfidx) in schooling_formation">
                                                                    <option :value="sfidx" :selected='validateKey(sfidx,schooling.formation)'>
                                                                        @{{sformation}}
                                                                    </option>
                                                                </template>
                                                            </select>
                                                        </div>
                                                        <div class=" col-sm-12 col-lg-6">
                                                            <label :for="'schooling-status'+index">*{{ __('profile.status') }}</label>
                                                            <select :id="'schooling-status'+index" class="w-input text-field white-background" v-model="schooling.status">
                                                                <template v-for="(sstatus,ssidx) in schooling_status">
                                                                    <option :value="ssidx" :selected='validateKey(ssidx,schooling.status)'>
                                                                        @{{sstatus}}
                                                                    </option>
                                                                </template>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-10" v-show="schooling.formation=='superior' | schooling.formation=='technical'">
                                                        <div class=" col-sm-12 col-lg-6">
                                                            <label :for="'schooling-course'+index">*{{ __('profile.course') }}</label>
                                                            <input type='text' class='w-input text-field white-background' :id="'schooling-course-'+index" v-model="schooling.course" />
                                                        </div>
                                                        <div class=" col-sm-12 col-lg-6">
                                                            <label for="schooling-grade">*{{ __('profile.grade') }}</label>
                                                            <select :id="'schooling-grade'+index" class="w-input text-field white-background" v-model="schooling.grade">
                                                                <template v-for="(sgrade,sgidx) in schooling_grades">
                                                                    <option :value="sgidx" :selected='validateKey(sgidx,schooling.grade)'>
                                                                        @{{sgrade}}
                                                                    </option>
                                                                </template>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-10" v-show="schooling.formation=='superior' | schooling.formation=='technical'">
                                                        <div class=" col-sm-12 col-lg-6">
                                                            <label :for="'schooling-institution'+index">*{{ __('profile.institution') }}</label>
                                                            <input type='text' class='w-input text-field white-background' :id="'schooling-institution'+index" v-model='schooling.institution' />
                                                        </div>
                                                        <div class=" col-sm-12 col-lg-3">
                                                            <label :for="'schooling-start'+index">*{{ __('profile.start') }}</label>
                                                            <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background text-center' :id="'schooling-start'+index"  v-model="schooling.start"
                                                            />
                                                        </div>
                                                        <div class=" col-sm-12 col-lg-3">
                                                            <label :for="'schooling-end'+index">{{ __('profile.end') }}</label>
                                                            <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background text-center' :id="'schooling-end'+index" v-model='schooling.end' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
        
                            <div class='tab-pane fade' v-bind:class="{ active: isItMe('experience-data') , show: isItMe('experience-data') }" id="experience">
                                <div class="row" style='margin-top:-20px;'> 
                                    <div class="col-2">
                                        <button class="btn btn-default" v-on:click='addExperience'   type='button'>{{ __('profile.add') }}</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <template  v-for="(experience,index) in experiences">
                                            <div class="card elegant shadow large-header margin-top-30">
                                                <h5>#@{{index+1}}</h5>
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col">
                                                            <input style='float:left;' type="checkbox" v-on:click="uncheckOtherExperiences(index)" v-bind:id="'experience-current-'+index" v-model="experience.current_job">
                                                            <label style='float:left;line-height:10px;' v-bind:for="'experience-current-'+index">{{ __('profile.currentjob') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-20">
                                                        <div class="col-3">
                                                            <button class="btn btn-danger" v-on:click='excludeExperience(index)' type='button'>
                                                                {{ __('profile.remove') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-10">
                                                        <div class=" col-sm-12 col-lg-6">
                                                            <label for="experience-business">{{ __('profile.business') }}</label>
                                                            <input type='text' class='w-input text-field white-background' id='experience-business' v-model='experience.business' />
                                                        </div>
                                                        <div class=" col-sm-12 col-lg-6">
                                                            <label for="experience-job">{{ __('profile.job') }}</label>
                                                            <input type='text' class='w-input text-field white-background' id='experience-job' v-model='experience.job'/>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-10">
                                                        <div class=" col-sm-12 col-lg">
                                                            <label for="experience-activities">{{ __('profile.activities') }}</label>
                                                            <textarea type='text' class='w-input text-field white-background' id='experience-activities' v-model="experience.activities">
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-top-10">
                                                        <div class=" col-sm-12 col-lg-3">
                                                            <label for="experience-admission">{{ __('profile.admission') }}</label>
                                                            <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background text-center' v-bind:class="{ 'error-field':!validDate(experience.admission) }" id='experience-admission' name='experience[].admission' v-model="experience.admission"/>
                                                            <small class='error-label' v-show="!validDate(experience.admission)">{{ __('profile.invaliddate') }}</small>
                                                        </div>
                                                        <div class=" col-sm-12 col-lg-3">
                                                            <label for="experience-demission">{{ __('profile.demission') }}</label>
                                                            <input type='text' v-mask="'##/##/####'" class='w-input text-field white-background text-center' id='experience-demission'  v-bind:class="{ 'error-field':!validDate(experience.demission) }" v-model='experience.demission'/>
                                                            <small class='error-label' v-show="!validDate(experience.demission)">{{ __('profile.invaliddate') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </div>

                            <!--div class='tab-pane fade'   v-bind:class="{ active: isItMe('language-data') , show: isItMe('language-data') }" id="language-data">
                            </div>
                            <div class='tab-pane fade'   v-bind:class="{ active: isItMe('family-data') , show: isItMe('family-data') }" id="family-data">
                            </div-->
                    
                            <!--div class='tab-pane fade' v-bind:class="{ active: isItMe('documents') , show: isItMe('documents') }" id="documents">
                            </div-->

                            <!--div class="tab-pane fade" v-bind:class="{ active: isItMe('extra') , show: isItMe('extra') }" id="extra">
                                        
                                        <div class="row margin-top-30">
                                            <div class=" col-sm-12">
                                                <label for="data-others">Outros</label>
                                                <textarea name="others" id="data-others"  style='width: 100%;height:150px;border:1px solid #bbb;'>{{$data->others}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='tab-pane fade padding-top-10'  v-bind:class="{ active: isItMe('questionary'), show: isItMe('questionary') }" id="questionary">
                                <!--div class="card elegant shadow large-header margin-top-20">
                                    <div class="card-body">

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
                                    </div>
                                </div>
                                <div class="card elegant shadow large-header margin-top-20">
                                    <div class="card-body">

                                        <!--div class="row margin-top-10">
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
                                    </div>
                                </div-->
                                <!--div class="card elegant shadow large-header margin-top-20">
                                    <div class="card-body">
                                        <div class="row margin-top-10">
                                            <div class="col-lg-4">
                                                <label for="data-worked-without-ctp">13. Já trabalhou sem registro em carteira?</label>
                                                <select class='w-input text-field white-background'  name='worked_without_ctp' id='data-worked-without-ctp'>
                                                    <option value="0" @if($data->worked_without_ctp==0) selected @endif>Não</option>
                                                    <option value="1" @if($data->worked_without_ctp==1) selected @endif>Sim</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="data-worked-without-ctp">13.a. Onde?</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->worked_without_ctp_job}}" name='worked_without_ctp_job' id='data-worked-without-ctp-job'/>
                                            </div>
                                            <div class="col-lg-4
                                            ">
                                                <label for="data-worked-without-ctp">13.b. Quanto tempo?</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->worked_without_ctp_how_long}}" name='worked_without_ctp_how_long' id='data-worked-without-ctp-how-long'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-4">
                                                <label for="data-previous-work-legal-action">14. Possui alguma questão trabalhista?</label>
                                                <select class='w-input text-field white-background' type='text' name='previous_work_legal_action' id='data-previous-work-legal-action'>
                                                    <option value="0" @if($data->previous_work_legal_action==1) selected @endif>Não</option>
                                                    <option value="1" @if($data->previous_work_legal_action==1) selected @endif>Sim</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="data-previous-work-legal-action-business">14.a. Com qual empresa?</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->previous_work_legal_action_business}}" name='previous_work_legal_action_business' id='data-previous-work-legal-action-business'/>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="data-previous-work-legal-action-reason">14.b. Qual o motivo?</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->previous_work_legal_action_reason}}" name='previous_work_legal_action_reason' id='data-previous-work-legal-action-reason'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-professional-dream">15. Qual o seu sonho profissional?</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->professional_dream}}" name='professional_dream' id='data-professional-dream'/>
                                            </div>
                                            <div class="col-lg-12">
                                                <label for="data-personal-dream">Qual o seu sonho pessoal?</label>
                                                <input class='w-input text-field white-background' type='text' name='personal_dream' id='data-personal-dream'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-who-are-you">16. Resumidamente escreva quem é você:</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->who_are_you}}" name='who_are_you' id='data-who-are-you'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-professional-motivation">17. O que o motiva profissionalmente?</label>
                                                <input class='w-input text-field white-background' type='text' value="{{$data->professional_motivation}}" name='professional_motivation' id='data-professional-motivation'/>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-12">
                                                <label for="data-what-irritates-you">18. O que o irrita?</label>
                                                <input class='w-input text-field white-background' value="{{$data->what_irritates_you}}" type='text' name='what_irritates_you' id='data-what-irritates-you'/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div--->
                            <div class='tab-pane fade padding-top-10'  v-bind:class="{ active: isItMe('success'), show: isItMe('success') }" id="success">
                                <div class="card margin-top-30">
                                    <div class="card-body text-center">
                                        <h1 style='color:rgb(27, 124, 15);'>{{ __('profile.successregistered') }}</h1>
                                        <h4 style='color:rgb(27, 124, 15);'>{{ __('profile.seeour') }} <a href='/jobs'>{{ __('profile.jobs') }}</a> {{ __('profile.andsubscribe') }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class='btn btn-info margin-left-40' v-on:click="saveProfile" v-bind:disabled="saving" type='button'>{{ __('profile.save') }} </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop


<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
<script src="{{ asset('js/vmask.js') }}"></script>