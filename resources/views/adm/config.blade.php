@extends('adminlte::page')

@section('title', 'Configurações | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
    <div class="card" id='configurations'>

        <div class="card-header">
            <h2>Configurações</h2>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-5">
                    <div class="row">
                        <div class="col-12">
                            <label class='label-form'>
                                Banners
                            </label>
                            <div class="row">
                                <div class="col-2">
                                    <button class="btn btn-primary" v-on:click='saveBanners' :disabled='saving'>@{{ savingText }}</button>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" v-on:click='editBanner' :disabled='canEdit'>Editar</button>
                                </div>                                
                            </div>
                            <div class="list-group margin-top-10">
                                <template v-for='banner in banners'>
                                    <button v-bind:class=" { 'selected':activeBanner(banner.id) } " v-on:click='selectedBanner=banner.id' :data-key='banner.order' class='list-group-item dropzone' :id="'dbanner'+banner.id"  draggable="true" v-on:dragstart="dragMove" v-on:dragend="dragEnd" v-on:drop="dragDrop"  v-on:dragover="dragOver" >
                                        <span class='clear pull-left'>@{{ banner.name }}</span><br/>
                                        <span class='pull-left'>Ativo de:  &nbsp @{{ banner.active_from.split(" ")[0].split("-").reverse().join("/") }}</span>
                                        <span class='pull-right'>Até: &nbsp @{{ banner.active_to.split(" ")[0].split("-").reverse().join("/") }}</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-7 pull-right">
                    <iframe height="600px" width='100%' src="/" frameborder="0" id='banner-iframe'></iframe>
                </div>
            </div>
        </div>

    </div>
@stop

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
