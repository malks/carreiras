@extends('adminlte::page')

@section('title', 'Configurações | Lunelli Carreiras')

@section('content_header')
@stop

@section('content')
    <div class="card" id='configurations'>
        @csrf

        <div class="card-header">
            <h2>Configurações</h2>
        </div>

        <div class="card-body">
            <div class="row">
                <ul class="nav nav-tabs margin-top-20">
                    <li class="nav-item">
                        <a  class='nav-link'  v-bind:class="{ active: isItMe('banners') }" v-on:click="currentTab='banners'" >Banners</a>
                    </li>
                    <li class="nav-item">
                        <a  class='nav-link'  v-bind:class="{ active: isItMe('about_us') }" v-on:click="currentTab='about_us'" >Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a  class='nav-link'  v-bind:class="{ active: isItMe('our_numbers') }" v-on:click="currentTab='our_numbers'" >Nossos Números</a>
                    </li>
                    <li class="nav-item">
                        <a  class='nav-link'  v-bind:class="{ active: isItMe('our_team') }" v-on:click="currentTab='our_team'" >Nosso Time</a>
                    </li>
                    <li class="nav-item">
                        <a  class='nav-link'  v-bind:class="{ active: isItMe('video') }" v-on:click="currentTab='video'" >Video</a>
                    </li>

                </ul>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                    <div class="tab-content">

                        <div class='tab-pane fade'  v-bind:class="{ active: isItMe('banners'), show: isItMe('banners') }" id="banners-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row margin-top-20">
                                        <div class="col-lg-2 col-sm-6">
                                            <button class="btn btn-secondary" v-on:click='addBanner' >Novo</button>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <button class="btn btn-primary" v-on:click='saveBanners' :disabled='saving'>@{{ savingText }}</button>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <button class="btn btn-info" v-on:click='editBanner' :disabled='canEdit'>Editar</button>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <button class="btn btn-danger" v-on:click='deleteBanner' :disabled='canEdit'>Excluir</button>
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
                        <div class='tab-pane fade'  v-bind:class="{ active: isItMe('about_us'), show: isItMe('about_us') }" id="about_us-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row margin-top-20">
                                        <div class="col-12">
                                            <button class='btn btn-primary' :disabled='saving' v-on:click="saveOtherConf('about_us')">Salvar</button>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Título</label>
                                            <input type="text" class="form-control" v-model='otherConf.about_us.title'>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Fundo do Título</label>
                                            <input type="text" class="form-control" v-model='otherConf.about_us.background_title'>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Depoimento</label>
                                            <textarea type="text" class="form-control" v-model='otherConf.about_us.testimonial'></textarea>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Autor Depoimento</label>
                                            <input type="text" class="form-control" v-model='otherConf.about_us.testimonial_author'>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Foto do Autor do Depoimento</label><br>
                                            <img id='testimonial-author-pic' class='config-block-image' src="" alt="" ><br>
                                            <label for="" class='label-form margin-top-20'>Alterar Foto:</label><br>
                                            <input type="file" class="form-control" name='testimonial_author_picture' id='testimonial-author-picture' v-on:change="updateTestimonialAuthorPicture">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='tab-pane fade'  v-bind:class="{ active: isItMe('our_numbers'), show: isItMe('our_numbers') }" id="our_numbers-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row margin-top-20">
                                        <div class="col-3">
                                            <button class="btn btn-secondary" v-on:click="addNumber">Novo</button>
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-primary" :disabled='saving' v-on:click="saveOtherConf('our_numbers')">Salvar</button>
                                        </div>
                                        <template v-for='(numbers,idx) in otherConf.our_numbers'>
                                            <div class="col-12 margin-top-20" v-show='showNumber(idx)'>
                                                <div class="col-12">
                                                    <hr>
                                                    <button class="btn btn-danger" v-on:click="if (confirm('Tem certeza?')) removeNumber(idx)">Remover</button>
                                                </div>    
                                                <div class="col-12 margin-top-10">
                                                    <label class='label-form' for="">Título</label>
                                                    <input type="text" class="form-control" v-model='numbers.title'>
                                                </div>
                                                <div class="col-12 margin-top-10">
                                                    <label class='label-form' for="">Valor</label>
                                                    <input type="text" class="form-control" v-model='numbers.number'>
                                                </div>
                                                <div class="col-6 margin-top-10">
                                                    <label class='label-form' for="">Ativo de</label>
                                                    <input type="date" class="form-control" v-model='numbers.active_from'>
                                                </div>
                                                <div class="col-6 margin-top-10">
                                                    <label class='label-form' for="">Ativo até</label>
                                                    <input type="date" class="form-control" v-model='numbers.active_to'>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='tab-pane fade'  v-bind:class="{ active: isItMe('our_team'), show: isItMe('our_team') }" id="our_team-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row margin-top-20">
                                        <div class="col-3">
                                            <button class="btn btn-secondary" v-on:click="addTeam">Novo</button>
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-primary" :disabled='saving' v-on:click="saveOtherConf('our_team')">Salvar</button>
                                        </div>
                                        <template v-for='(member,idx) in otherConf.our_team'>
                                            <div class="col-12 margin-top-20" v-show='showTeam(idx)'>
                                                <div class="col-12">
                                                    <hr>
                                                    <button class="btn btn-danger" v-on:click="if (confirm('Tem certeza?')) removeTeam(idx)">Remover</button>
                                                </div>    
                                                <div class="col-12 margin-top-10">
                                                    <label class='label-form' for="">Nome</label>
                                                    <input type="text" class="form-control" v-model='member.name'>
                                                </div>
                                                <div class="col-12 margin-top-10">
                                                    <label class='label-form' for="">Cargo</label>
                                                    <input type="text" class="form-control" v-model='member.job'>
                                                </div>
                                                <div class="col-12 margin-top-10">
                                                    <label class='label-form' for="">Depoimento</label>
                                                    <input type="text" class="form-control" v-model='member.testimonial'>
                                                </div>
                                                <div class="col-6 margin-top-10">
                                                    <label class='label-form' for="">Ativo de</label>
                                                    <input type="date" class="form-control" v-model='member.active_from'>
                                                </div>
                                                <div class="col-6 margin-top-10">
                                                    <label class='label-form' for="">Ativo até</label>
                                                    <input type="date" class="form-control" v-model='member.active_to'>
                                                </div>
                                                <div class="col-12 margin-top-10">
                                                    <label class='label-form' for="">Foto</label><br>
                                                    <img class='config-block-image' :src="member.picture" alt=""><br>
                                                    <label class='label-form' for="" class='margin-top-20'>Alterar Foto:</label><br>
                                                    <input type="file" :id="'team-pic-picker-'+idx" class="form-control team-pic-picker" v-on:change="updateTeamPic(idx)">
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='tab-pane fade'  v-bind:class="{ active: isItMe('video'), show: isItMe('video') }" id="video-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row margin-top-20">
                                        <div class="col-12">
                                            <button class='btn btn-primary' :disabled='saving' v-on:click="saveOtherConf('video')">Salvar</button>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Título</label>
                                            <input type="text" class="form-control" v-model='otherConf.video.title'>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Fundo do Título</label>
                                            <input type="text" class="form-control" v-model='otherConf.video.title_background'>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Capa</label><br>
                                            <img class='config-block-image'  id='video-pic' src="" alt=""><br>
                                            <label class='label-form' for="" class='margin-top-20'>Alterar Foto:</label><br>
                                            <input type="file" class="form-control" name='video_picture' id='video-picture' v-on:change="updateVideoPicture">

                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Ativo</label>
                                            <select name="" id="" class="form-control" v-model='otherConf.video.active'>
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>
                                            </select>
                                        </div>
                                        <div class="col-12 margin-top-10">
                                            <label class='label-form' for="">Link</label><br>
                                            <small>Links do youtube precisam conter /embed/ na URL logo depois do domínio, antes da chave do video e outros parametros</small><br>
                                            <input type="text" class="form-control margin-top-10" v-model='otherConf.video.file'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 pull-right">
                    <h5>Visão da Home</h5>
                    <iframe height="1200px" width='100%' src="/" frameborder="0" id='banner-iframe' style='border:2px solid black;padding:5px;'></iframe>
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
                        <form id='banner-form' action="/save-banner" style='max-height:400px;overflow-y:scroll;overflow-x:clip!important;padding:15px;'>
                            <div class="row">
                                <div class="col-md-6  col-xs-12 margin-top-10">
                                    <label for="">Nome</label>
                                    <input type="text" class='form-control' value=''  v-model='editingBanner.name' name='name'>
                                </div>
                                <div class="col-md-6  col-xs-12 margin-top-10">
                                    <label for="">Ordem</label>
                                    <input type="text" class='form-control' value=''  v-model='editingBanner.order' name='order'>
                                </div>                                
                                <div class="col-12 margin-top-10">
                                    <label for="">Titulo Grande</label>
                                    <input type="text" class='form-control' value=''  v-model='editingBanner.title_big' name='title_big'>
                                </div>
                                <div class="col-md-6  col-xs-12 margin-top-10">
                                    <label for="">Cor</label> 
                                    <input type="color" class='form-control'  v-model='editingBanner.title_big_color' name='title_big_color'>
                                </div>
                                <div class="col-md-6 col-xs-12  margin-top-10">
                                    <label for="">Contorno</label>
                                    <select name="title_big_outline" class='form-control' v-model='editingBanner.title_big_outline' >
                                        <option value="">Nenhum</option>
                                        <option value="outline-dark-grey">Chumbo</option>
                                        <option value="outline-light-grey">Cinza Claro</option>
                                        <option value="outline-dark-white">Branco</option>
                                    </select>
                                </div>
                                <div class="col-12 margin-top-10">
                                    <label for="">Título Pequeno</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.title_small' name='title_small'>
                                </div>
                                <div class="col-md-6 col-xs-12  margin-top-10">
                                    <label for="">Cor</label> 
                                    <input type="color" class='form-control'  v-model='editingBanner.title_small_color' name='title_small_color'>
                                </div>
                                <div class="col-md-6 col-xs-12  margin-top-10">
                                    <label for="">Contorno</label>
                                    <select name="title_small_outline" class='form-control' v-model='editingBanner.title_small_outline' >
                                        <option value="">Nenhum</option>
                                        <option value="outline-dark-grey">Chumbo</option>
                                        <option value="outline-light-grey">Cinza Claro</option>
                                        <option value="outline-dark-white">Branco</option>
                                    </select>
                                </div>
                                <div class="col-12 margin-top-10">
                                    <label for="">Texto do Botão</label>
                                    <input type="text" class='form-control'  v-model='editingBanner.cta' name='cta'>
                                </div>
                                <div class="col-md-6 col-xs-12  margin-top-10">
                                    <label for="">Ativo De</label>
                                    <input type="date" class='form-control'  v-model='editingBanner.active_from' :value='editingBanner.active_from' name='active_from'>
                                </div>
                                <div class="col-md-6 col-xs-12 margin-top-10">
                                    <label for="">Ativo Até</label>
                                    <input type="date" class='form-control'  v-model='editingBanner.active_to' :value='editingBanner.active_to' name='active_to'>
                                </div>
                                <div class="col-12 margin-top-10">
                                    <label for="">Imagem</label><br>
                                    <img  class='config-block-image'  id='banner-background-preview' :src=" editingBanner.background " alt="" style='height:200px;'><Br>
                                    <button type='button' class='btn btn-primary margin-top-10' v-on:click="changeBannerBackground">Alterar</button>
                                    <input style='display:none' type="file" id='banner-background-picker' v-on:change="previewImage" name='background_file'>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  v-on:click="resetEditingBanner" class="btn btn-secondary" data-bs-dismiss="modal" >Fechar</button>
                        <button type="button" class="btn btn-primary" v-on:click="updateBanner" :disabled='saving'>@{{ savingText }}</button>
                    </div>
                </div>
            </div>
        </div>          

    </div>

@stop

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
