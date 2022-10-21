@extends('layouts/public')

@section('content')
    <div class='row margin-top-30'>
        <div class="col-12">

            <div class="columns small-12 small-centered">
                <p align="center">&nbsp;</p>
                <div class="animatedParent animateOnce">
                    <h3 class="head-h3">{{ __('help.help') }}</h3>
                    <p class="head-subtitle">{{ __('help.contact') }}</p>
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
                        <b style="font-size: large;">{{ __('help.inform') }}</b>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row margin-top-30">
                    <div class="col-lg-4">
                        <label for="">{{ __('help.name') }}</label>
                        <input type="text" name='contact_name' class='w-input text-field white-background'>
                    </div>
                    <div class="col-lg-4">
                        <label for="">{{ __('help.email') }}</label>
                        <input type="email" name='contact_mail' class='w-input text-field white-background'>
                    </div>
                </div>
                <div class="row margin-top-30">
                    <div class="col-8">
                        <label for="">{{ __('help.subject') }}</label>
                        <input type="text" name='contact_subject' class='w-input text-field white-background'>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-12">
                        <label for="">{{ __('help.message') }}</label>
                        <textarea name="contact_text" id="" cols="30" rows="10" class='w-input text-field white-background'></textarea>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-12">
                        <label style='float:left;' for="">{{ __('help.attachment') }}</label><small style='float:left;font-size:8pt;line-height:30px;'>(max:2mb)</small><br><br>
                        <input name="contact_file" type='file' accept="image/*, video/* ">
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="col">
                        <button class="btn btn-info">{{ __('help.send') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br><br>
@stop