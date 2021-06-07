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

        <!--[if lte IE 9]>
        <link href="assets/css/animations-ie-fix.css" rel="stylesheet" type="text/css"/>
        <![endif]-->
    </head>
	<body class="royal_preloader">	
	
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
                                            <a href="index.html" >
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
                                            <ul class="hedone-menu">
                                                <li class="menu-item menu-item menu-item-has-children current-page-ancestor current-menu-ancestor current-menu-parent current-page-parent current_page_parent current_page_ancestor">
                                                    <a href="#">Home</a>
                                                    <ul class="sub-menu">
                                                        <li class="menu-item">
                                                            <a href="index.html">text effects on load</a>
                                                        </li>
                                                        <li class="menu-item current-menu-item">
                                                            <a href="home-slider.html">home slider</a>
                                                        </li>
                                                        <li class="menu-item">
                                                            <a href="home-video.html">home video</a>
                                                        </li>
                                                        <li class="menu-item">
                                                            <a href="home-fullscreen.html">home fullscreen</a>
                                                        </li>
                                                        <li class="menu-item">
                                                            <a href="agency.html">design agency-animated</a>
                                                        </li>
                                                        <li class="menu-item">
                                                            <a href="one-page.html">one-page version</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="about.html">About</a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="services.html">services</a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="blog.html">blog</a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="contact.html">contact</a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="elements.html">elements</a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="/login">login</a>
                                                </li>
                                            </ul>
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

        <!-- HERO SECTION SLIDER-->
        <div class="hero-slider">
            <div class="owl-hero-slider owl-carousel owl-theme">
                <div class="item">
                    <div class="hero-image" style="background-image: url({{ asset('/img/slide-2.jpg') }});"></div>
                    <div class="hero-slider-content">
                        <div class="container">
                            <div class="row">
                                <div class="upSection animated slideOutUp">
                                    <div class="text-top">great</div>
                                    <div class="text-mid">strategy</div>
                                    <div class="slider-line"></div>
                                </div>
                                <div class="downSection animated slideOutDown">
                                    <div class="text-bottom">build great brands</div>
                                    <a class="home-move-button" href="#about-home"></a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="item">
                    <div class="hero-image" style="background-image: url({{ asset('/img/slide-1.jpg') }});"></div>
                    <div class="hero-slider-content">
                        <div class="container">
                            <div class="row">
                                <div class="upSection animated slideOutUp">
                                    <div class="text-top">moving</div>
                                    <div class="text-mid">boundaries</div>
                                    <div class="slider-line"></div>
                                </div>
                                <div class="downSection animated slideOutDown">
                                    <div class="text-bottom">into digital solution</div>
                                    <a class="home-move-button" href="#about-home"></a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="item">
                    <div class="hero-image" style="background-image: url({{ asset('/img/slide-3.jpg') }});"></div>
                    <div class="hero-slider-content">
                        <div class="container">
                            <div class="row">
                                <div class="upSection animated slideOutUp">
                                    <div class="text-top">magic</div>
                                    <div class="text-mid">& design</div>
                                    <div class="slider-line"></div>
                                </div>
                                <div class="downSection animated slideOutDown">
                                    <div class="text-bottom">to connect people</div>
                                    <a class="home-move-button" href="#about-home"></a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>


        <!-- ABOUT SECTION -->
        <section id="about-home" class="padding-top-120px white-background">
            <div class="container">
                <div class="row">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">We're Hedone</h3>
                        <p class="head-subtitle">creative agency</p>
                    </div>
                </div>
                <div class="row">
                    <div class="animatedParent animateOnce">
                        <div class="col-sm-4">
                            <img class="img-responsive animated fadeInUp delay-500" alt="about us" src="{{ asset('/img/about_1.jpg') }}">
                        </div>
                        <div class="col-sm-8">
                            <blockquote class="quote">
                                "We are a new creative studio. veritatis, eosquiso uam asperi oresipsum itaque dignissimos reprehen derit. non quos ratione ipsa facilisis. Vivamus dapibus rutrum mi ut aliquam. In hac habitasse platea dictumst. Integer sagittis neque a tortor tempor in porta sem vulputate."
                            </blockquote>
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
                        <div class="col-sm-3">
                            <div class="facts-number"><span class="counter" data-counter-val="374">374</span></div>
                            <div class="facts-name">active users</div>
                        </div>
                        <div class="col-sm-3">
                            <div class="facts-number"><span class="counter" data-counter-val="179">179</span></div>
                            <div class="facts-name">apps created</div>
                        </div>
                        <div class="col-sm-3">
                            <div class="facts-number"><span class="counter" data-counter-val="16420">16420</span></div>
                            <div class="facts-name">lines of code</div>
                        </div>
                        <div class="col-sm-3">
                            <div class="facts-number"><span class="counter" data-counter-val="527">527</span></div>
                            <div class="facts-name">coffee cups</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- OUR TEAM -->
        <section class="padding-top-bottom-120px white-background">
            <div class="container">
                <div class="row">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">Our team</h3>
                    </div>
                    <div class="animatedParent animateOnce">
                        <div class="col-sm-4 team-mem-wrap animated fadeInUp">
                            <div class="hover-for-team-social">
                                <ul>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <img class="img-responsive team-img" src="{{ asset('/img/mem_1.jpg') }}" alt="Alex Andrews">
                            <div class="team-names">Alex Andrews</div>
                            <div class="team-expert">founder</div>
                        </div>
                        <div class="col-sm-4 team-mem-wrap animated fadeInUp delay-250">
                            <div class="hover-for-team-social">
                                <ul>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <img class="img-responsive team-img" src="{{ asset('/img/mem_2.jpg') }}" alt="Marko Kulis">
                            <div class="team-names">Marko Kulis</div>
                            <div class="team-expert">art director</div>
                        </div>
                        <div class="col-sm-4 team-mem-wrap animated fadeInUp delay-500">
                            <div class="hover-for-team-social">
                                <ul>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class=""><i class="fa fa-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <img class="img-responsive team-img" src="{{ asset('/img/mem_3.jpg') }}" alt="Frank Furious">
                            <div class="team-names">Frank Furious</div>
                            <div class="team-expert">developer</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VIDEO BACKGROUND SECTION -->
        <div class="padding-top-bottom-120px video-section">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <a href="https://vimeo.com/153959792" class="lightbox-on-sep popup-video">
                            <img src="{{ asset('/img/play-button.png') }}" class="play-button play-on-sep" alt="play button">
                        </a>
                    </div>
                    <div class="animatedParent animateOnce">
                        <div class="col-xs-12 sep-text">
                            A typical day at the office
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- OUR SERVICES -->
        <section class="padding-top-bottom-120px white-background animation-overflow">
            <div class="container">
                <div class="row">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3 animated">Our services</h3>
                        <p class="head-subtitle">we do magic</p>
                    </div>
                </div>
                <div class="row">
                    <div class="animatedParent animateOnce">
                        <div class="col-sm-4 animated fadeInUp">
                            <div class="service-wrap">
                                <div class="service-icon">
                                    <i class="fa fa-code"></i>
                                </div>
                                <div class="head-h6 services-head-h6">web design</div>
                                <div class="text-center">Vestibulum rutrum, mi nec elementum vehicula. Non quos ratione ipsa facilisis.</div>
                            </div>
                        </div>
                        <div class="col-sm-4 animated fadeInUp delay-250">
                            <div class="service-wrap">
                                <div class="service-icon">
                                    <i class="fa fa-wordpress"></i>
                                </div>
                                <div class="head-h6 services-head-h6">branding</div>
                                <div class="text-center">Non quos ratione ipsa facilisis. Vivamus dapibus rutrum mi ut aliquam.</div>
                            </div>
                        </div>
                        <div class="col-sm-4 animated fadeInUp delay-500">
                            <div class="service-wrap">
                                <div class="service-icon">
                                    <i class="fa fa-camera-retro"></i>
                                </div>
                                <div class="head-h6 services-head-h6">photography</div>
                                <div class="text-center">Non quos ratione ipsa facilisis. Vivamus dapibus rutrum mi ut aliquam.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="animatedParent animateOnce">
                        <div class="col-sm-4 animated fadeInUp">
                            <div class="service-wrap">
                                <div class="service-icon">
                                    <i class="fa fa-gamepad"></i>
                                </div>
                                <div class="head-h6 services-head-h6">game design</div>
                                <div class="text-center">Non quos ratione ipsa facilisis. Vivamus dapibus rutrum mi ut aliquam.</div>
                            </div>
                        </div>
                        <div class="col-sm-4 animated fadeInUp delay-250">
                            <div class="service-wrap">
                                <div class="service-icon">
                                    <i class="fa fa-tachometer"></i>
                                </div>
                                <div class="head-h6 services-head-h6">speed analysys</div>
                                <div class="text-center">Non quos ratione ipsa facilisis. Vivamus dapibus rutrum mi ut aliquam.</div>
                            </div>
                        </div>
                        <div class="col-sm-4 animated fadeInUp delay-500">
                            <div class="service-wrap">
                                <div class="service-icon">
                                    <i class="fa fa-terminal"></i>
                                </div>
                                <div class="head-h6 services-head-h6">server scripting</div>
                                <div class="text-center">Non quos ratione ipsa facilisis. Vivamus dapibus rutrum mi ut aliquam.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BRANDING SLIDER -->
        <div class="padding-top-bottom-60px dark-background">
            <div class="container">
                <div class="row">
                    <div class="brand-slider owl-carousel owl-theme">
                        <div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white1.png') }}" alt="brand logo"/>
                            </div>
                        </div>
                        <div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white2.png') }}" alt="brand logo"/>
                            </div>
                        </div><div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white3.png') }}" alt="brand logo"/>
                            </div>
                        </div><div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white4.png') }}" alt="brand logo"/>
                            </div>
                        </div><div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white5.png') }}" alt="brand logo"/>
                            </div>
                        </div><div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white6.png') }}" alt="brand logo"/>
                            </div>
                        </div><div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white1.png') }}" alt="brand logo"/>
                            </div>
                        </div><div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white2.png') }}" alt="brand logo"/>
                            </div>
                        </div><div class="item">
                            <div class="brand-logo-holder">
                                <img src="{{ asset('/img/white3.png') }}" alt="brand logo"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOG SECTION-->
        <section class="padding-top-bottom-120px white-background animation-overflow">
            <div class="container">
                <div class="row">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">journal</h3>
                        <p class="head-subtitle">latest news</p>
                    </div>
                </div>
            </div>
            <!-- BLOG LISTING THREE COLUMNS -->
            <div class="container-fluid">
                <div class="row">
                    <div class="blog-page-listing animatedParent animateOnce">
                        <div class="col-sm-6 col-md-4">
                            <article>
                                <div class="blog-page-post-wrapp animated">
                                    <img class="blog-page-post-img" src="{{ asset('/img/post-4.jpg') }}" alt="Standard Gallery Post"/>
                                    <h2 class="blog-page-post-head-h2"><a href="standard-gallery-post.html">Standard Gallery Post</a></h2>
                                    <ul class="blog_post_category">
                                        <li><i class="fa fa-thumb-tack"></i></li>
                                        <li><a href="#category">branding</a></li>
                                        <li><a href="#category">design</a></li>
                                        <li><a href="#category">art</a></li>
                                    </ul>
                                    <ul class="blog_post_tags">
                                        <li><i class="fa fa-tags"></i></li>
                                        <li><a href="#category">template</a></li>
                                        <li><a href="#category">post formats</a></li>
                                    </ul>
                                    <div class="blog-page-post-content">
                                        <p>Aliquam quis nunc quam. Maecenas feugiat dui venenatis dui convallis, a consectetur quam ornare.</p>
                                    </div>
                                    <div class="blog-page-post-author">
                                        <a href="#author-link">Alex Andrews</a>
                                    </div>
                                    <div class="blog-page-post-date">
                                        <a href="#published">March 7, 2016</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <article>
                                <div class="blog-page-post-wrapp animated">
                                    <img class="blog-page-post-img" src="{{ asset('/img/post-2.jpg') }}" alt="Standard Video Post"/>
                                    <h2 class="blog-page-post-head-h2"><a href="standard-video-post.html">Standard Video Post</a></h2>
                                    <ul class="blog_post_category">
                                        <li><i class="fa fa-thumb-tack"></i></li>
                                        <li><a href="#category">branding</a></li>
                                        <li><a href="#category">design</a></li>
                                        <li><a href="#category">art</a></li>
                                    </ul>
                                    <ul class="blog_post_tags">
                                        <li><i class="fa fa-tags"></i></li>
                                        <li><a href="#category">template</a></li>
                                        <li><a href="#category">post formats</a></li>
                                    </ul>
                                    <div class="blog-page-post-content">
                                        <p>Aliquam quis nunc quam. Maecenas feugiat dui venenatis dui convallis, a consectetur quam ornare.</p>
                                    </div>
                                    <div class="blog-page-post-author">
                                        <a href="#author-link">Frank Furius</a>
                                    </div>
                                    <div class="blog-page-post-date">
                                        <a href="#published">March 7, 2016</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <article>
                                <div class="blog-page-post-wrapp animated">
                                    <img class="blog-page-post-img" src="{{ asset('/img/post-1.jpg') }}" alt="Standard Image Post"/>
                                    <h2 class="blog-page-post-head-h2"><a href="standard-image-post.html">Standard Image Post</a></h2>
                                    <ul class="blog_post_category">
                                        <li><i class="fa fa-thumb-tack"></i></li>
                                        <li><a href="#category">branding</a></li>
                                        <li><a href="#category">design</a></li>
                                        <li><a href="#category">art</a></li>
                                    </ul>
                                    <ul class="blog_post_tags">
                                        <li><i class="fa fa-tags"></i></li>
                                        <li><a href="#category">template</a></li>
                                        <li><a href="#category">post formats</a></li>
                                    </ul>
                                    <div class="blog-page-post-content">
                                        <p>Aliquam quis nunc quam. Maecenas feugiat dui venenatis dui convallis, a consectetur quam ornare.</p>
                                    </div>
                                    <div class="blog-page-post-author">
                                        <a href="#author-link">Marko Kulis</a>
                                    </div>
                                    <div class="blog-page-post-date">
                                        <a href="#published">March 7, 2016</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BLOG LISTING FOUR COLUMNS -->
            <div class="container-fluid">
                <div class="row">
                    <div class="blog-page-listing animatedParent animateOnce">
                        <div class="col-sm-6 col-md-3">
                            <article>
                                <div class="blog-page-post-wrapp animated">
                                    <img class="blog-page-post-img" src="{{ asset('/img/post-5.jpg') }}" alt="Images & Quote Post"/>
                                    <h2 class="blog-page-post-head-h2"><a href="images-and-quote-post.html">Images & Quote Post</a></h2>
                                    <ul class="blog_post_category">
                                        <li><i class="fa fa-thumb-tack"></i></li>
                                        <li><a href="#category">branding</a></li>
                                        <li><a href="#category">design</a></li>
                                        <li><a href="#category">art</a></li>
                                    </ul>
                                    <ul class="blog_post_tags">
                                        <li><i class="fa fa-tags"></i></li>
                                        <li><a href="#category">template</a></li>
                                        <li><a href="#category">post formats</a></li>
                                    </ul>
                                    <div class="blog-page-post-content">
                                        <p>Aliquam quis nunc quam. Maecenas feugiat dui venenatis dui convallis, a consectetur quam ornare.</p>
                                    </div>
                                    <div class="blog-page-post-author">
                                        <a href="#author-link">Alex Andrews</a>
                                    </div>
                                    <div class="blog-page-post-date">
                                        <a href="#published">March 7, 2016</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <article>
                                <div class="blog-page-post-wrapp animated">
                                    <img class="blog-page-post-img" src="{{ asset('/img/post-6.jpg') }}" alt="Quote Post"/>
                                    <h2 class="blog-page-post-head-h2"><a href="quote-post.html">Quote Post</a></h2>
                                    <ul class="blog_post_category">
                                        <li><i class="fa fa-thumb-tack"></i></li>
                                        <li><a href="#category">branding</a></li>
                                        <li><a href="#category">design</a></li>
                                        <li><a href="#category">art</a></li>
                                    </ul>
                                    <ul class="blog_post_tags">
                                        <li><i class="fa fa-tags"></i></li>
                                        <li><a href="#category">template</a></li>
                                        <li><a href="#category">post formats</a></li>
                                    </ul>
                                    <div class="blog-page-post-content">
                                        <p>Aliquam quis nunc quam. Maecenas feugiat dui venenatis dui convallis, a consectetur quam ornare.</p>
                                    </div>
                                    <div class="blog-page-post-author">
                                        <a href="#author-link">Frank Furius</a>
                                    </div>
                                    <div class="blog-page-post-date">
                                        <a href="#published">March 7, 2016</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <article>
                                <div class="blog-page-post-wrapp animated">
                                    <img class="blog-page-post-img" src="{{ asset('/img/post-7.jpg') }}" alt="Link Post"/>
                                    <h2 class="blog-page-post-head-h2"><a href="link-post.html">Link Post</a></h2>
                                    <ul class="blog_post_category">
                                        <li><i class="fa fa-thumb-tack"></i></li>
                                        <li><a href="#category">branding</a></li>
                                        <li><a href="#category">design</a></li>
                                        <li><a href="#category">art</a></li>
                                    </ul>
                                    <ul class="blog_post_tags">
                                        <li><i class="fa fa-tags"></i></li>
                                        <li><a href="#category">template</a></li>
                                        <li><a href="#category">post formats</a></li>
                                    </ul>
                                    <div class="blog-page-post-content">
                                        <p>Aliquam quis nunc quam. Maecenas feugiat dui venenatis dui convallis, a consectetur quam ornare.</p>
                                    </div>
                                    <div class="blog-page-post-author">
                                        <a href="#author-link">Marko Kulis</a>
                                    </div>
                                    <div class="blog-page-post-date">
                                        <a href="#published">March 7, 2016</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <article>
                                <div class="blog-page-post-wrapp animated">
                                    <img class="blog-page-post-img" src="{{ asset('/img/post-8.jpg') }}" alt="Audio Post"/>
                                    <h2 class="blog-page-post-head-h2"><a href="audio-post.html">Audio Post</a></h2>
                                    <ul class="blog_post_category">
                                        <li><i class="fa fa-thumb-tack"></i></li>
                                        <li><a href="#category">branding</a></li>
                                        <li><a href="#category">design</a></li>
                                        <li><a href="#category">art</a></li>
                                    </ul>
                                    <ul class="blog_post_tags">
                                        <li><i class="fa fa-tags"></i></li>
                                        <li><a href="#category">template</a></li>
                                        <li><a href="#category">post formats</a></li>
                                    </ul>
                                    <div class="blog-page-post-content">
                                        <p>Aliquam quis nunc quam. Maecenas feugiat dui venenatis dui convallis, a consectetur quam ornare.</p>
                                    </div>
                                    <div class="blog-page-post-author">
                                        <a href="#author-link">Marko Kulis</a>
                                    </div>
                                    <div class="blog-page-post-date">
                                        <a href="#published">March 7, 2016</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </section>
        <!-- END BLOG SECTION -->

        <!-- SUBSCRIBE SECTION -->
        <div class="padding-top-bottom-60px white-background">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <form id="subscribe-form" name="subscribe-form" method="post">
                            <input id="subscribe-email" type="text" placeholder="subscribe (we hate spam)" name="email" required="required" class="subscribe-style">
                            <button type="button" data-value="subscribe" data-wait="Please wait..." class="w-button subscribe-button">subscribe</button>
                        </form>
                        <div class="alert alert-success contact-form-done no-border-radius">
                            <p>Thank you! Your submission has been received!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="footer-logo">
                        <img src="{{ asset('/img/logo-white.png') }}" alt="footer logo"/>
                    </div>
                    <div class="footer-social-block">
                        <a href="#" class="w-inline-block social-wrap">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#" class="w-inline-block social-wrap">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="#" class="w-inline-block social-wrap">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#" class="w-inline-block social-wrap">
                            <i class="fa fa-youtube"></i>
                        </a>
                    </div>
                    <div class="footer-text">
                        © We are <span class="footer-text-span">Hedone</span>. All rights reserved. 2017<br>Made by <span class="footer-text-span">IG Design</span> in Kraljevo, Serbia
                    </div>
                </div>
            </div>
        </footer>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    </body>
</html>
