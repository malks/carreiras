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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                            <div class="container" style='max-width: 1200px;'>
                                <div >
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
                                    <div id="Hedone" class="hedone-menu-container">
                                        <div class="navbar-right">
                                            @if(empty($logged_in))
                                                <ul class="hedone-menu" id='welcoLogin'>
                                                    <li class="menu-item">
                                                        <a href="/policy">Termos</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="/jobs">Vagas</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="/help">Ajuda</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        &nbsp
                                                    </li>
                                                    <li class="menu-item">
                                                        &nbsp
                                                    </li>

                                                    <li class="menu-item">
                                                        <form id='login-form' action='/login' method='post' >
                                                            <label class='d-block d-sm-none' for="">Login</label>
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
                                                    <li class="menu-item pad-left-10-xs" >
                                                        <div class="pull-left-xs">
                                                            <button v-if='login_user_ok & login_user.length>0' v-on:click="backToUsername()" type='button' class='btn btn-grey' id='back'><i class="fa fa-undo" style='font-size:11pt'></i></button>
                                                            <button  v-if='login_user_ok==0'  v-on:click="checkLogin" type='button' class='btn btn-default' id='ok'>OK</button>
                                                            <button  v-if='checkPass()' type='button' v-on:click="goToLogin" class='btn btn-default' id="login">login</button>
                                                        </div>
                                                        <a href='/register' class="btn btn-green d-block d-sm-none margin-left-20 pull-left"  id='register'>Registre-se</a>
                                                    </li>
                                                    <li class="menu-item d-block d-sm-none margin-top-60">&nbsp</li>
                                                    <li class="menu-item d-block d-sm-none">&nbsp</li>
                                                    <li class="menu-item d-none d-sm-block pull-right" >
                                                        <a href='/register' class="btn btn-green  margin-left-10 margin-top-7-lg"  id='register'>Registre-se</a>
                                                    </li>
                                                </ul>
                                            @else 
                                                <ul class="hedone-menu" id='welcoLogin'>
                                                    <li class="menu-item">
                                                        <a href="/policy">Termos</a>
                                                    </li>
                                                    <li class="menu-item" @if(empty($logged_in) && empty($user_id)) style='display:none;' @endif >
                                                        <a href="/subscriptions">Candidaturas</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="/jobs">Vagas</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="/profile">Perfil</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="/help">Ajuda</a>
                                                    </li>
                                                    <li>
                                                        <span class='small margin-left-20'>
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
        
        <section id="main-content" class="padding-top-120px white-background">
            <div class="container">
                @yield('content')
             </div>
        </section>

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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="{{ asset('js/plugins.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
        <script src="{{ asset('js/welcome.js') }}" type="text/javascript"></script>
    </body>
</html>
