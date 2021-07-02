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
                                    <button class="btn btn-info" v-on:click='editBanner' :disabled='canEdit'>Editar</button>
                                </div>                                
                            </div>
                            <div class="list-group margin-top-10">
                                <template v-for='banner in banners'>
                                    <button v-bind:class=" { 'selected':activeBanner(banner.id) } " v-on:click=' selectBanner(banner.id) ' :data-key='banner.order' class='list-group-item dropzone' :id="'dbanner'+banner.id"  draggable="true" v-on:dragstart="dragMove" v-on:dragend="dragEnd" v-on:drop="dragDrop"  v-on:dragover="dragOver" >
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

        <div id='banner-modal' class="modal" :class="{ 'hide':editingBanner.id==null }" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Banner</h5>
                        <button type="button" class="btn-close" v-on:click="resetEditingBanner" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <form action="/save-banner">
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Nome</label>
                                    <input type="text" class='form-control' value=''  v-model='editingBanner.name' name='name'>
                                </div>
                                <div class="col-6">
                                    <label for="">Ordem</label>
                                    <input type="text" class='form-control' value=''  v-model='editingBanner.order' name='order'>
                                </div>                                
                                <div class="col-6">
                                    <label for="">Titulo Grande</label>
                                    <input type="text" class='form-control' value=''  v-model='editingBanner.title_big' name='title_big'>
                                </div>
                                <div class="col-3">
                                    <label for="">Cor</label> 
                                    <input type="text" class='form-control'  v-model='editingBanner.title_big_color' name='title_big_color'>
                                </div>
                                <div class="col-3">
                                    <label for="">Contorno</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.title_big_outline' name='title_big_outline'>
                                </div>
                                <div class="col-6">
                                    <label for="">Título Pequeno</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.title_small' name='title_small'>
                                </div>
                                <div class="col-3">
                                    <label for="">Cor</label> 
                                    <input type="text" class='form-control'  v-model='editingBanner.title_small_color' name='title_small_color'>
                                </div>
                                <div class="col-3">
                                    <label for="">Contorno</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.title_small_outline' name='title_small_outline'>
                                </div>
                                <div class="col-6">
                                    <label for="">Chamada</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.cta' name='cta'>
                                </div>
                                <div class="col-3">
                                    <label for="">Ativo De</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.active_from' name='active_from'>
                                </div>
                                <div class="col-3">
                                    <label for="">Ativo Até</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.active_to' name='active_to'>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  v-on:click="resetEditingBanner" class="btn btn-secondary" data-bs-dismiss="modal" >Fechar</button>
                        <button type="button" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
        </div>          

    </div>

@stop

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
