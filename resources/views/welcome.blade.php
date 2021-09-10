<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>LunelliCarreiras</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/lunelli-small-red.png') }}">

        <!-- Bootstrap -->
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="{{ asset('css/animations.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/owl.carousel.custom.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/hedone.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/colors.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('fonts/KaushanScript-Regular.ttf') }}" />

        <!--[if lte IE 9]>
        <link href="assets/css/animations-ie-fix.css" rel="stylesheet" type="text/css"/>
        <![endif]-->
    </head>
	<body class="royal_preloader" >	
	
		<!-- PRELOADER -->
		<div id="royal_preloader"></div>

        <!-- TOP SCROLL -->
        <div id="top-home-scroll"></div>
        <a href="#top-home-scroll" class="scroll-to-top-arrow-button"></a>

        <!-- AJAX LOADER -->
        <div id="ajax-loader" class="loader loader-default" data-half="" data-text="Loading..."></div>
            
        <!-- IS MOBILE HACK -->
        <div id="isMobile"></div>

        <!-- HEADER -->
        <header>
            <div class="animatedParent animateOnce">
                <div class="nav-back animated fadeInDown">
                    <nav class="navbar">
                        <div class="container-fluid">
                            <div class="container">
                                <div class="row">
                                    <div class="hedone-menu-header">
                                        <div class="nav-button">
                                            <i class="fa fa-bars"></i>
                                        </div>
                                        <!-- SITE LOGO -->
                                        <div class="site-branding">
                                            <a href="/" >
                                                <img src="{{ asset('/img/grupo-lunelli-colored.png') }}" alt="brand logo"/>
                                                <span class='logo-complement'>
                                                    Carreiras
                                                </span>
                                            </a>
                                        </div>      
                                    </div>
                                    <!-- PRIMARY MENU -->
                                    <div id="Hedone" class="hedone-menu-container">
                                        <div class="navbar-right">
                                            @if(empty($logged_in))
                                                <ul class="hedone-menu" id='welcoLogin'>
                                                    <li class="menu-item">
                                                        <a href="/jobs">Vagas</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        &nbsp
                                                    </li>
                                                    <li class="menu-item">
                                                        &nbsp
                                                    </li>

                                                    <li class="menu-item">
                                                        <form id='login-form' action='/login' method='post' >
                                                            <div class="form-group">
                                                                @csrf
                                                                <input v-show='login_user_ok==0' type='text' v-on:keyup.enter="checkLogin" class='form-control' id='login-user' v-model='login_user' name='email' placeholder='usuario'/>
                                                                <input v-show='login_user_ok==1' v-on:keyup.enter="goToLogin" type='password' class='form-control' id='login-pass' v-model='login_pass' name='password' placeholder='senha'/>
                                                                @if($errors->has('email'))
                                                                    <span style='color:#9b0303!important;position:absolute;width:220px;'>Credenciais não conferem.</span>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </li>
                                                    <li class="menu-item" >
                                                        <button v-if='login_user_ok & login_user.length>0' v-on:click="backToUsername()" type='button' class='btn btn-grey' id='back'><i class="fa fa-undo" style='font-size:11pt'></i></button>
                                                        <button  v-if='login_user_ok==0'  v-on:click="checkLogin" type='button' class='btn btn-default' id='ok'>OK</button>
                                                        <button  v-if='checkPass()' type='button' v-on:click="goToLogin" class='btn btn-default' id="login">login</button>
                                                    </li>
                                                    <li class="menu-item margin-left-30" >
                                                        <a href='/register' class="btn btn-green"  id='register'>Registre-se</a>
                                                    </li>
                                                </ul>
                                            @else 
                                                <ul class="hedone-menu" id='welcoLogin'>
                                                    @if($role=='admin')
                                                        <li class="menu-item">
                                                            <a href="/home">Admin</a>
                                                        </li>
                                                    @endif

                                                    <li class="menu-item">
                                                        <a href="/jobs">Vagas</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="/profile">Perfil</a>
                                                    </li>
                                                    <li>
                                                        <span class='small margin-left-30'>
                                                            Bem Vindo, {{$logged_in->name}} (<a href="/logout" style='color:#9b0303;display:inline;padding:2px!important;'>Sair</a>)
                                                        </span>
                                                    </li>
                                                </ul>
                                            
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <!-- HEADER END -->

        <div>
            <input type="hidden" value='@php echo json_encode($jobs->toArray());@endphp' id='jobs-data' check-jobs-home>
            <input type="hidden" value='@php echo json_encode($fields->toArray());@endphp' id='fields-data'>
            <input type="hidden" value='@php echo json_encode($units->toArray());@endphp' id='units-data'>
            <input type="hidden" value='@php echo json_encode($subscriptions);@endphp' id='subscriptions-data'>
            <input type="hidden" value='@php echo $user_id;@endphp' id='user-id'>
            <input type="hidden" value='@php echo $candidate_id;@endphp' id='candidate-id'>
            <!-- HERO SECTION SLIDER-->
            <div class="hero-slider">
                <div class="owl-hero-slider owl-carousel owl-theme">
                    @foreach($banners as $banner)
                        <div class="item">
                            <div class="hero-image" style="background-image: url({{ asset($banner->background) }});"></div>
                            <div class="hero-slider-content">
                                <div class="container">
                                    <div class="row">
                                        <div class="upSection animated slideOutUp">
                                            <div class="text-top {{$banner->title_big_outline}}" style='color:{{$banner->title_big_color}};'>{{$banner->title_big}}</div>
                                            <div class="text-mid  {{$banner->title_small_outline}}" style='color:{{$banner->title_small_color}};'>{{$banner->title_small}}</div>
                                            <div class="slider-line"></div>
                                        </div>
                                        <div class="downSection animated slideOutDown">
                                            <div class="text-bottom">{{$banner->cta}}</div>
                                            <a class="home-move-button" href="#about-home"></a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- ABOUT SECTION -->
            <section id="about-home" class="padding-top-120px white-background">
                <div class="container">
                    <div class="row">
                        <div class="animatedParent animateOnce">
                            <h3 class="head-h3">{{$about_us->title}}</h3>
                            <p class="head-subtitle">{{$about_us->background_title}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="animatedParent animateOnce">
                            <div class="col-sm-4">
                                <img class="img-responsive animated fadeInUp' delay-500" alt="about us" src="{{ asset('/img/'.$about_us->testimonial_author_picture) }}">
                            </div>
                            <div class="col-sm-8">
                                <blockquote>
                                    {{$about_us->testimonial}}
                                </blockquote>
                                <span class='quote-author'>{{$about_us->testimonial_author}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- COUNTER SECTION -->
            <div class="dark-background padding-top-bottom-60px keep-z-index">
                <div class="container">
                    <div class="row">
                        <div class="animatedParent animateOnce">
                            @foreach($our_numbers as $number)
                                <div class="col-sm-{{12/$total_numbers}}">
                                    <div class="facts-number"><span class="counter" data-counter-val="{{$number->number}}">{{$number->number}}</span></div>
                                    <div class="facts-name">{{$number->title}}</div>
                                </div>
                            @endforeach 
                        </div>
                    </div>
                </div>
            </div>

            <!-- OUR TEAM -->
            <section class="padding-top-bottom-120px white-background" id='our-team-home'>
                <div class="container">
                    <div class="row">
                        <div class="animatedParent animateOnce">
                            <h3 class="head-h3">Nosso Time</h3>
                            <p class="head-subtitle">depoimentos</p>
                        </div>
                        <div class="animatedParent animateOnce">
                            @foreach($our_team as $member)
                                <div class="col-sm-{{12/$our_team_count}} team-mem-wrap animated fadeInUp">
                                    <div class="hover-for-team-social">
                                        <ul>
                                            @if(!empty($member->facebook_link))
                                                <li>
                                                    <a href="{{$member->twitter_link}}" class=""><i class="fa fa-facebook"></i></a>
                                                </li>
                                            @endif
                                            @if(!empty($member->twitter_link))
                                                <li>
                                                    <a href="{{$member->twitter_link}}" class=""><i class="fa fa-twitter"></i></a>
                                                </li>
                                            @endif
                                            @if(!empty($member->linkedin_link))
                                                <li>
                                                    <a href="{{$member->twitter_link}}" class=""><i class="fa fa-linkedin"></i></a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <img class="img-responsive team-img" src="{{ asset($member->picture) }}" alt="{{$member->name}}">
                                    <blockquote class='secondary-testimonials'>
                                        "{{$member->testimonial}}"
                                    </blockquote>
                                    <div class="team-names">{{$member->name}}</div>
                                    <div class="team-expert">{{$member->job}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- VIDEO BACKGROUND SECTION -->
            <div class="padding-top-bottom-120px video-section" style="background-image:url({{'/img/'.$video->face}})">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <a  class="lightbox-on-sep popup-video">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- OUR SERVICES -->
            <section class="padding-top-bottom-120px white-background animation-overflow" id='video-home'>
                <div class="container">
                    <div class="row">
                        <div class="animatedParent animateOnce">
                            <h3 class="head-h3 animated">{{$video->title}}</h3>
                            <p class="head-subtitle">{{$video->title_background}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <iframe id='ytplayer' height='600px' width='800px' src="{{$video->file.'?origin=local.lunellicarreiras.com.br&autoplay=1&mute=1'}}" frameborder="0">
                            </iframe>
                        </div>
                    </div>
                </div>
            </section>

            <div  id='home-jobs-app'>
                <!-- BRANDING SLIDER -->
                <div class="padding-top-bottom-60px dark-background" >
                    <div class="container">
                        <div class="row">
                            <div class="brand-slider owl-carousel owl-theme">
                                @foreach ($jobs as $job)
                                    @if($job->index==7)
                                        @php break @endphp
                                    @endif
                                    @if ($job->home_slider==1)
                                        <div class="item">
                                            <div class="brand-logo-holder">
                                                <span class='job-item' style='cursor:pointer;text-transform:capitalize' v-on:click="viewJob({{ $job->id }})">
                                                    {{strtolower($job->name)}}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BLOG SECTION-->
                <section class="padding-top-bottom-120px white-background animation-overflow">
                    <div class="container">
                        <div class="row">
                            <div class="animatedParent animateOnce">
                                <h3 class="head-h3">Vagas</h3>
                                <p class="head-subtitle">Em Aberto</p>
                            </div>
                        </div>
                    </div>
                    <!-- BLOG LISTING THREE COLUMNS -->
                    <div id='job-modal' class="modal" :class="{ 'hide':viewingJob.id==null }" tabindex="-1">
                        @csrf
                        <div class="modal-dialog">
                            <div class="modal-content">
                
                                <div class="modal-header">
                                    <h5 class="modal-title pull-left">@{{ viewingJob.name}}</h5>
                                    <button type="button" class="btn-close pull-right" v-on:click="resetViewingJob" data-bs-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <div class='maxed-height-500'>
                                        <div id='observation-modal' class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Adicionar uma observação?</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea v-model='observation' style='width:100%;min-height:150px;'></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class='btn btn-default'  data-bs-dismiss="modal" v-on:click="closeObsModal">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="" class="control-label">Área</label>
                                                <span> @{{getField(viewingJob.field_id).name}}</span>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="" class="control-label">Unidade</label>
                                                <span> @{{getUnit(viewingJob.unit_id).name}}</span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col-lg-6">
                                                <label for="" class="control-label">Cidade</label>
                                                <span> @{{getUnit(viewingJob.unit_id).city}}</span>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="" class="control-label">Estado</label>
                                                <span> @{{getUnit(viewingJob.unit_id).state}}</span>
                                            </div>
                                        </div>    
                                        <div class="row margin-top-30">
                                            <div class="col-lg-12">
                                                <label for="" class="control-label">Vaga:</label>
                                                <span> @{{viewingJob.name}}</span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col-lg-12">
                                                <label for="" class="control-label">Descrição:</label>
                                                <span v-html='printDescription'></span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col-lg-12">
                                                <label for="" class="control-label">Atividades:</label>
                                                <span v-html='printActivities'> </span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col-lg-12">
                                                <label for="" class="control-label">Requisitos:</label>
                                                <span v-html='printRequired'> </span>
                                            </div>
                                        </div>
                                        <div class="row margin-top-30">
                                            <div class="col-lg-12">
                                                <label for="" class="control-label">Desejável:</label>
                                                <span v-html='printDesirable'></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button v-show="!isSubscribed(viewingJob.id)" class="btn btn-default" v-on:click="applyForJob(viewingJob.id)"> 
                                        Candidate-se à Vaga
                                    </button>
                                    <button v-show="isSubscribed(viewingJob.id)" class="btn btn-warning" v-on:click="cancelApplication(viewingJob.id)" > 
                                        <i class="fa fa-check" style='margin-right:10px'></i>
                                        Cancelar Inscrição
                                    </button>
                                    <button class="btn btn-danger" data-bs-dismiss="modal" v-on:click="closeModal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="blog-page-listing animatedParent animateOnce">
                                @php $count=0 @endphp
                                @foreach ($jobs as $job)
                                    @if($count<3)
                                    <div class="col-sm-6 col-md-4">
                                        <article>
                                            <div class="blog-page-post-wrapp animated">
                                                @if(!empty($job->picture) && $job->picture!='/img/gallery.png')
                                                    <img class="blog-page-post-img" src="{{ asset($job->picture) }}" alt="{{$job->name}}"/>
                                                @endif
                                                <h2 class="blog-page-post-head-h2"><a  href="#job" v-on:click="viewJob({{ $job->id }})">{{$job->name}}</a></h2>
                                                <ul class="blog_post_category">
                                                    <li><i class="fa fa-thumb-tack"></i></li>
                                                    <li><a href="#category">{{$job->field->name}}</a></li>
                                                </ul>
                                                <ul class="blog_post_tags">
                                                    <li><i class="fa fa-tags"></i></li>
                                                    @foreach($job->tags as $tag)
                                                        <li><a href="#category">{{$tag->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                                <div class="blog-page-post-content">
                                                    <p>@php echo str_replace(["\r","\n","\r\n"],"<br>",$job->description)@endphp</p>
                                                </div>
                                                <div class="blog-page-post-author">
                                                    <a href="#job" v-on:click="viewJob({{ $job->id }})">Candidate-se</a>
                                                </div>
                                                <div class="blog-page-post-date">
                                                    <a href="#published">
                                                        @if (!empty($job->created_at))
                                                            {{date_format(DateTime::createFromFormat('Y-m-d H:i:s', $job->created_at),'m/Y')}}
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    @endif
                                    @php $count++ @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- BLOG LISTING FOUR COLUMNS -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="blog-page-listing animatedParent animateOnce">
                                @php $count=0 @endphp
                                @foreach ($jobs as $job)
                                    @if($count>=3 && $count<7)
                                        <div class="col-sm-6 col-md-3">
                                            <article>
                                                <div class="blog-page-post-wrapp animated">
                                                    @if(!empty($job->picture)  && $job->picture!='/img/gallery.png')
                                                        <img class="blog-page-post-img" src="{{ asset($job->picture) }}" alt="{{$job->name}}"/>
                                                    @endif
                                                    <h2 class="blog-page-post-head-h2"><a href="standard-gallery-post.html">{{$job->name}}</a></h2>
                                                    <ul class="blog_post_category">
                                                        <li><i class="fa fa-thumb-tack"></i></li>
                                                        <li><a href="#category">{{$job->field->name}}</a></li>
                                                    </ul>
                                                    <ul class="blog_post_tags">
                                                        <li><i class="fa fa-tags"></i></li>
                                                        @foreach($job->tags as $tag)
                                                            <li><a href="#category">{{$tag->name}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="blog-page-post-content">
                                                        <p>{{$job->description}}</p>
                                                    </div>
                                                    <div class="blog-page-post-author">
                                                        <a href="#author-link" v-on:click="viewJob({{ $job->id }})">Inscreva-se</a>
                                                    </div>
                                                    <div class="blog-page-post-date">
                                                        <a href="#published">
                                                            @if (!empty($job->created_at))
                                                                {{date_format(DateTime::createFromFormat('Y-m-d H:i:s', $job->created_at),'m/Y')}}
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @endif
                                    @php $count++ @endphp
                                @endforeach
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                </section>
                <!-- END BLOG SECTION -->

            </div>

            <!-- SUBSCRIBE SECTION -->
            <div class="padding-top-bottom-60px white-background">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <form id="subscribe-form" name="subscribe-form" method="post" action="/newsletter-subscribe">
                                <input id="subscriber-email" type="text" placeholder="Quer receber nossas novidades? Cadastre seu email aqui!" name="email" required="required" class="subscribe-style">
                                <button type="button" id='subscribe' data-wait="Aguarde..." class="w-button subscribe-button">Assinar</button>
                            </form>
                            <div class="alert alert-success contact-form-done no-border-radius">
                                <p>Obrigado! Inscrição recebida!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="footer">
            <div class="container">
                <div class="row">

                    <div class="footer-social-block">
                        <a href="https://www.instagram.com/grupolunelli/" target='_blank' class="w-inline-block social-wrap">
                            <i class="fa fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/grupo-lunelli" target='_blank' class="w-inline-block social-wrap">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="https://www.facebook.com/grupolunelli" target='_blank' class="w-inline-block social-wrap">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://www.youtube.com/channel/UCPfbbICzMyJAgkC3iDtFlHA/featured"  target='_blank' class="w-inline-block social-wrap">
                            <i class="fa fa-youtube"></i>
                        </a>
                    </div>
                    <div class="footer-text">
                        © <span class="footer-text-span">LunelliCarreiras</span>. 2021
                    </div>
                </div>
            </div>
        </footer>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
        <script src="{{ asset('js/welcome.js') }}" type="text/javascript"></script>
    </body>
</html>
