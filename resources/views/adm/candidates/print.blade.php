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
                            <div class="row margin-top-10">
                                <div class="col">
                                    <h3 style='text-transform:capitalize'>{{$data->name}}</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>@php echo (idate('Y')-explode("-",$data->dob)[0]); @endphp anos - {{$civil_states[$data->civil_state-1]}}</p>
                                </div>
                            </div>
                            <div class="row" style='margin-top:-10px;'>
                                <div class="col">
                                    CPF: {{$data->cpf}}
                                </div>
                            </div>
                        </div>
            
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p>Natural de {{$data->natural_city}} - {{$data->natural_state}}, {{$data->natural_country}}</p>
                                    <p>Reside em {{$data->address_city}} - {{$data->address_state}}, {{$data->address_country}}</p>
                                    <p>{{$data->email}} - {{(!empty($data->ddd_mobile)) ? $data->ddd_mobile : $data->ddd_phone}} {{(!empty($data->mobile)) ? substr($data->mobile,0,4)."-".substr($data->mobile,4,4) : substr($data->phone,0,4)."-".substr($data->phone,4,4)}}</p>    
                                </div>
                            </div>

                            <hr style='margin-left:-20px;margin-right:-20px;'>
                            <div class="row margin-top-20">
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

                            <hr style='margin-left:-20px;margin-right:-20px;'>
                            <div class="row margin-top-20">
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
                                                Curso {{$schooling->course}} {{$course_status[$schooling->status]}} na instituição {{$schooling->institution}} ( Início: {{$carbon->parse($schooling->start)->format('d/m/Y')}} &nbsp - &nbsp Fim: {{ (!empty($schooling->end)) ? $carbon->parse($schooling->end)->format('d/m/Y') : 'Não concluída'}} )
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr style='margin-left:-20px;margin-right:-20px;'>
                            <div class="row margin-top-20">
                                <div class="col">
                                    <h5>Experiência Profissional</h5>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col">
                                    @foreach ($data->experience as $experience)
                                        <div class="row margin-top-20">
                                            <div class="col">
                                                {{$experience->job}} na {{$experience->business}} ( De: {{$carbon->parse($experience->admission)->format('d/m/Y')}} &nbsp - &nbsp Até: {{ (!empty($experience->demission)) ? $carbon->parse($experience->demission)->format('d/m/Y') : 'o momento'}} )
                                            </div>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col">
                                                Atividades: <br> <span style='font-size:11pt;'>{!! str_replace("\n","<br>",$experience->activities) !!}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
            
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>