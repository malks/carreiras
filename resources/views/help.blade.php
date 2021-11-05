@extends('layouts/public')

@section('content')
    <div class='row margin-top-30'>
        <div class="col-12">

            <div class="columns small-12 small-centered">
                <p align="center">&nbsp;</p>
                <div class="animatedParent animateOnce">
                    <h3 class="head-h3">AJUDA</h3>
                    <p class="head-subtitle">contato</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card elegant large-header shadow ">
        <form action="/send-help" method='POST' enctype='multipart/form-data'>
            @csrf
            <div class="card-header" style='background-color:#fff;padding:'>
                <div class="row">
                    <div class="col-12" style='padding:10px!important;'>
                        <b style="font-size: large;">Informe sua dúvida ou problema, entraremos em contato assim que possível</b>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row margin-top-30">
                    <div class="col-lg-4">
                        <label for="">Nome</label>
                        <input type="text" name='contact_name' class='w-input text-field white-background'>
                    </div>
                    <div class="col-lg-4">
                        <label for="">Email</label>
                        <input type="email" name='contact_mail' class='w-input text-field white-background'>
                    </div>
                </div>
                <div class="row margin-top-30">
                    <div class="col-8">
                        <label for="">Assunto</label>
                        <input type="text" name='contact_subject' class='w-input text-field white-background'>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-12">
                        <label for="">Mensagem</label>
                        <textarea name="contact_text" id="" cols="30" rows="10" class='w-input text-field white-background'></textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-12">
                        <label style='float:left;' for="">Anexo</label><small style='float:left;font-size:8pt;line-height:30px;'>(max:2mb)</small><br><br>
                        <input name="contact_file" type='file' accept="image/*, video/* ">
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="col">
                        <button class="btn btn-info">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br><br>
@stop