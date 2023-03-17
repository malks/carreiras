<html>
    <head>
        <title>Curriculo | Lunelli Carreiras</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="{{ asset('css/adm.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    </head>
    <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

        <div class="container">
            <div class="row margin-top-50">
                <div class="col">
                    <div class='card'>
            
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <img style='max-width:200px;float:left;' src="{{asset('img/grupo-lunelli-colored.png')}}" alt="Lunelli">
                                    <!--span class="logo-complement">
                                        Carreiras
                                    </span-->
                                </div>
                            </div>

                            <div class="row margin-top-20">
                                @if(!empty($data->picture))
                                    <div class="col-sm-2">
                                        <picture>
                                            <source media="(min-width:50px,max-width:150px;)" srcset="{{$data->picture}}">
                                            <img src="{{$data->picture}}" style='width:auto;max-width:150px;'>
                                        </picture>
                                    </div>
                                @endif
                                <div class="col">
                                    <div class="row margin-top-10">
                                        <div class="col">
                                            <h3 style='text-transform:capitalize'>{{$data->name}}</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>Nascimento: @php echo (!empty($datebirth)) ? implode("/",array_reverse(explode("-",$datebirth))) : '' @endphp</p>
                                        </div>
                                    </div>
                                    <div class="row" style='margin-top:-10px;'>
                                        <div class="col">
                                            <p>@php echo (!empty($data->dob)) ? (idate('Y')-explode("-",$data->dob)[0]) : ''; @endphp anos - {{(!empty($data->civil_state) && is_numeric($data->civil_state)) ? $civil_states[$data->civil_state-1 | 0] : ''}}</p>
                                        </div>
                                    </div>
                                    <div class="row" style='margin-top:-10px;'>
                                        <div class="col">
                                            CPF: &nbsp {{$mask($data->cpf,'###.###.###-##')}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($data->deficiency && !empty($data->defici))
                                <div class="row">
                                    <div class="col">
                                        {{$data->defici->name}}
                                    </div>
                                </div>
                            @endif
                            @if ($data->foreigner)
                                <div class="row ">
                                    <div class="col">
                                        Estrangeiro com registro {{($data->foreign_register) ? $data->foreign_register : 'não informado' }}, emitido pelo órgão: {{$data->foreign_emitter}}
                                    </div>
                                </div>
                            @endif
                            <br>

                        </div>
            
                        <div class="card-body">
                            <div class="row margin-top-20">
                                <div class="col">
                                    <h5>Informações Pessoais</h5>
                                </div>
                            </div>
                            <div class="row margin-top-30">
                                <div class="col">
                                    <p>Natural de {{$data->natural_city}} - {{$data->natural_state}}, {{$data->natural_country}}</p>
                                    <p>Reside em {{$data->address_district}}, {{$data->address_city}} - {{$data->address_state}}, {{$data->address_country}}</p>
                                    <p>{{$data->email}} - {{(!empty($data->ddd_mobile)) ? $data->ddd_mobile : $data->ddd_phone}} {{(!empty($data->mobile)) ? substr($data->mobile,0,1)."-".substr($data->mobile,1,4)."-".substr($data->mobile,5,4) : substr($data->phone,0,4)."-".substr($data->phone,4,4)}}</p>    
                                </div>
                            </div>


                            <hr style='margin-left:-20px;margin-right:-20px;margin-top:30px;'>
                            <div class="row margin-top-40">
                                <div class="col">
                                    <h5>Documentos</h5>
                                </div>
                            </div>
                            <div class="row margin-top-30" >
                                <div class="col">
                                    RG: {{$mask($data->rg,'##.###.###-#####')}} - Emissor: {{$data->rg_emitter}}
                                </div>
                            </div>
                            <div class="row margin-top-10" >
                                <div class="col">
                                    CNH: {{$yes_no[$data->drivers_license | 0]}}
                                </div>
                            </div>
                            <!--div class="row margin-top-10" >
                                <div class="col">
                                    Carteira de Trabalho: {{$data->worker_card}} - {{$data->worker_card_series}} - {{$data->worker_card_digit}}
                                </div>
                            </div-->
                            <div class="row margin-top-10" >
                                <div class="col">
                                    PIS: {{$data->pis}}
                                </div>
                            </div>
                            <div class="row margin-top-10" >
                                <div class="col">
                                    Certificado de Reservista: {{$mask($data->veteran_card,'#### #### #### #')}}
                                </div>
                            </div>
                            <div class="row margin-top-10" >
                                <div class="col">
                                    Titulo de Eleitor: {{$data->elector_card}}
                                </div>
                            </div>

                            <hr style='margin-left:-20px;margin-right:-20px;margin-top:30px;'>
                            <div class="row margin-top-40">
                                <div class="col">
                                    <h5>Família</h5>
                                </div>
                            </div>
                            <div class="row margin-top-30" >
                                <div class="col">
                                    Mãe: {{$data->mother_name}} nascida em {{$carbon->parse($data->mother_dob)->format('d/m/Y')}}
                                </div>
                            </div>
                            @if(!empty($data->father_name))
                                <div class="row margin-top-10" >
                                    <div class="col">
                                        Pai: {{$data->father_name}} nascido em {{$carbon->parse($data->father_dob)->format('d/m/Y')}}
                                    </div>
                                </div>
                            @endif
                            @if (!empty($data->spouse_name))
                                <div class="row margin-top-10" >
                                    <div class="col">
                                        Conjuge: {{$data->spouse_name}}, profissão: {{$data->spouse_job}}
                                    </div>
                                </div>
                            @endif
                            @if($data->children_amount)
                                <div class="row margin-top-10" >
                                    <div class="col">
                                        {{$data->children_amount}} filhos de idade: {{$data->children_age}} que ficarão com {{$data->children_location}}
                                    </div>
                                </div>
                            @endif

                            <hr style='margin-left:-20px;margin-right:-20px;margin-top:30px;'>
                            <div class="row margin-top-40">
                                <div class="col">
                                    <h5>Idiomas</h5>
                                </div>
                            </div>
                            <div class="row margin-top-10" >
                                <div class="col">
                                    @foreach ($data->langs as $lang)
                                        <div class="row margin-top-10">
                                            <div class="col">
                                                {{$lang->name}} {{$language_levels[$lang->pivot->level]}} 
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr style='margin-left:-20px;margin-right:-20px;margin-top:30px;'>
                            <div class="row margin-top-40">
                                <div class="col">
                                    <h5>Escolaridade</h5>
                                </div>
                            </div>
                            <div class="row" style='margin-top:-10px;'>
                                <div class="col">
                                    @foreach ($data->schooling as $schooling)
                                        <div class="row margin-top-30">
                                            <div class="col">
                                                {{$schooling_grades[$schooling->grade]}} {{$schooling_formation[$schooling->formation]}} 
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col">
                                                Curso {{$schooling->course}} {{$course_status[$schooling->status]}} na instituição {{$schooling->institution}} <br> <small>Início: {{$carbon->parse($schooling->start)->format('d/m/Y')}} &nbsp - &nbsp Fim: {{ (!empty($schooling->end)) ? $carbon->parse($schooling->end)->format('d/m/Y') : 'Não concluída'}}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr style='margin-left:-20px;margin-right:-20px;margin-top:30px;'>
                            <div class="row margin-top-40">
                                <div class="col">
                                    <h5>Experiência Profissional</h5>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col">
                                    @foreach ($data->experience as $experience)
                                        <div class="row margin-top-20">
                                            <div class="col">
                                                {{$experience->job}} na {{$experience->business}} <br> <small> De: {{$carbon->parse($experience->admission)->format('d/m/Y')}} &nbsp - &nbsp Até: {{ (!empty($experience->demission)) ? $carbon->parse($experience->demission)->format('d/m/Y') : 'o momento'}}</small>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col">
                                                Atividades: <br> <div style='font-size:10pt;margin-left:10px;'>{!! str_replace("\n","<br>",$experience->activities) !!}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr style='margin-left:-20px;margin-right:-20px;margin-top:30px;'>
                            <div class="row margin-top-40">
                                <div class="col">
                                    <h5>Informações Adicionais</h5>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <h6>Interesses:</h6>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-lg-10">
                                    <ul style="list-style-type: none; height: content-fit; width: 100%; padding: 0px;">
                                        @foreach ($data->interests as $interest)
                                            <li style="float: left; margin-left: 15px;font-size:10pt;">{{$interest->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <h6>Habilidades:</h6>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col margin-left-10" style='font-size:10pt;' >
                                    {!! str_replace("\n","<br>",$data->skills) !!}
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <h6>Outros:</h6>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col margin-left-10" style='font-size:10pt;'>
                                    {!! str_replace("\n","<br>",$data->others) !!}
                                </div>
                            </div>

                            <hr style='margin-left:-20px;margin-right:-20px;margin-top:30px;'>
                            <div class="row margin-top-40">
                                <div class="col">
                                    <h5>Questionário de Seleção:</h5>
                                </div>
                            </div>

                            <div class="row margin-top-30">
                                <div class="col">
                                    <span>Trabalhou anteriormente na Lunelli? </span> <span style='margin-left:5px;'>{{$yes_no[$data->worked_earlier_at_lunelli | 0]}}</span> <br>
                                    @if($data->worked_earlier_at_lunelli)
                                        <small >Início: {{$carbon->parse($data->lunelli_earlier_work_period_start)->format('d/m/Y')}} </small> &nbsp - &nbsp
                                        <small >Fim: {{$carbon->parse($data->lunelli_earlier_work_period_start)->format('d/m/Y')}} </small>
                                    @endif
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Há quanto tempo vive no endereço atual? </span> <span style='margin-left:5px;'>{{$data->time_living_in_sc}}</span>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Em que cidades viveu anteriormente? </span> <span style='margin-left:5px;'>{{$data->cities_lived_before}}</span>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Mora com quem? </span> <span style='margin-left:5px;'>{{$data->living_with}}</span>
                                </div>
                            </div>
                            <!--div class="row margin-top-20">
                                <div class="col">
                                    <span>Qual a profissão das pessoas que moram com você? </span> <span style='margin-left:5px;'>{{$data->living_with_professions}}</span>
                                </div>
                            </div-->
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Como pretende se deslocar até a empresa? </span> <span style='margin-left:5px;'>{{$data->work_commute}}</span>
                                </div>
                            </div>
                            <!--div class="row margin-top-20">
                                <div class="col">
                                    <span>Quando foi pela última vez ao médico? </span> <span style='margin-left:5px;'>{{$carbon->parse($data->last_time_doctor)->format('d/m/Y')}}</span> 
                                    <br> 
                                    <small>Motivo: </small> <small style='margin-left:5px;'>{{$data->last_time_doctor_reason}}</small>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Já passou por alguma cirurgia? </span> <span style='margin-left:5px;'>{{$yes_no[$data->surgery | 0]}}</span> 
                                    @if($data->surgery)
                                        <br>
                                        <small>Motivo: </small> <small style='margin-left:5px;'>{{$data->surgery_reason}}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Já ficou internado(a) por algum motivo? </span> <span style='margin-left:5px;'>{{$yes_no[$data->hospitalized | 0]}}</span> 
                                    @if($data->hospitalized)
                                        <br>
                                        <small>Motivo: </small> <small style='margin-left:5px;'>{{$data->hospitalized_reason}}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Já sofreu acidente de trabalho? </span> <span style='margin-left:5px;'>{{$yes_no[$data->work_accident | 0]}}</span> 
                                    @if($data->work_accident)
                                        <br>
                                        <small>Quando e empresa: </small> <small style='margin-left:5px;'>{{$data->work_accident_where}}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Características pessoais que considera positivas: </span> 
                                    <br>
                                    <small>{{$data->positive_personal_characteristics}}</small>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Características que acredita que poderiam ser melhoradas: </span> 
                                    <br>
                                    <small>{{$data->personal_aspects_for_betterment}}</small>
                                </div>
                            </div-->
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Familiares ou conhecidos na Lunelli: </span> 
                                    <br>
                                    <small>{{$data->lunelli_family}}</small>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Pretensão Salarial: </span> 
                                    <br>
                                    <small>{{$data->pretended_salary}}</small>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Turnos de Preferência: </span> 
                                    <br>
                                    @if (!empty($data->prefered_work_period))
                                        @foreach(explode(",",$data->prefered_work_period) as $k=>$work_period)
                                            <small>{{ $work_periods[$work_period] }}</small>
                                            @if ($k!=count(explode(",",$data->prefered_work_period))-1)
                                            &nbsp<small> / </small>&nbsp
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <!--div class="row margin-top-20">
                                <div class="col">
                                    <span>Ja trabalhou sem registro em carteira? </span> 
                                    <br>
                                    <small>{{$yes_no[$data->worked_without_ctp | 0]}}</small>
                                    @if($data->worked_without_ctp)
                                        <small>
                                            &nbsp - &nbsp
                                            Empresa: {{$data->worked_without_ctp_job}}
                                            &nbsp - &nbsp
                                            Tempo: {{$data->worked_without_ctp_how_long}}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Questão trabalhista? </span> 
                                    <br>
                                    <small>{{$yes_no[$data->previous_work_legal_action | 0]}}</small>
                                    @if($data->previous_work_legal_action)
                                        <small>
                                            &nbsp - &nbsp
                                            Empresa: {{$data->previous_work_legal_action_business}}
                                            &nbsp - &nbsp
                                            Motivo: {{$data->previous_work_legal_action_reason}}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Sonho profissional: </span> 
                                    <br>
                                    <small>{{$data->professional_dream}}</small>
                                </div>
                            </div>

                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>Resumidamente escreva quem é você: </span> 
                                    <br>
                                    <small>{{$data->who_are_you}}</small>
                                </div>
                            </div>

                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>O que o motiva profissionalmente: </span> 
                                    <br>
                                    <small>{{$data->professional_motivation}}</small>
                                </div>
                            </div>

                            <div class="row margin-top-20">
                                <div class="col">
                                    <span>O que o irrita: </span> 
                                    <br>
                                    <small>{{$data->what_irritates_you}}</small>
                                </div>
                            </div-->

                        </div>
            
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>