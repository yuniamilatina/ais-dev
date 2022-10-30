
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <!-- meta character set -->
        <meta charset="utf-8">
        <!-- Always force latest IE rendering engine or request asChrome Frame -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Aisin Indonesia</title>		
        <!-- Meta Description -->
        <meta name="description" content="Blue One Page Creative HTML5 Template">
        <meta name="keywords" content="one page, single page, onepage, responsive, parallax, creative, business, html5, css3, css3 animation">
        <meta name="author" content="Muhammad Morshed">

        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS
        ================================================== -->

<!--        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>-->

        <!-- Fontawesome Icon font -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/font-awesome.min.css'); ?>">
        <!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/jquery.fancybox.css'); ?>">
        <!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/bootstrap.min.css'); ?>">
        <!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/owl.carousel.css'); ?>">
        <!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/slit-slider-koperasi.css'); ?>">
        <!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/animate.css'); ?>">
        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/main.css'); ?>">
        <!-- Menu Slider -->
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/slide-menu.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/w3.css'); ?>">


        <style>
            @-webkit-keyframes drop {
                from {
                    left: 0px;
                }
                70% {
                    left: 585px;
                    -webkit-animation-timing-function: ease-in;
                    animation-timing-function: ease-in;
                }
                to {
                    left: 450px;
                    -webkit-animation-timing-function: ease-out;
                    animation-timing-function: ease-out;
                }
            }
            @keyframes drop {
                from {
                    left: 0px;
                }
                70% {
                    left: 585px;
                    -webkit-animation-timing-function: ease-in;
                    animation-timing-function: ease-in;
                }
                to {
                    left: 450px;
                    -webkit-animation-timing-function: ease-out;
                    animation-timing-function: ease-out;
                }
            }



            .button__line {
                background: #ccc;
                width: 90px;
                height: 15px;
            }
            .button__line:not(:first-child) {
                margin-top: 15px;
            }

            .menu {
                width: 100%;
            }

            .menu__list {
                text-align: center;
                width: 100%;
                padding-left: 0;
            }

            .menu__list__item {
                text-align: left;
                position: relative;
                list-style: none;
                padding-bottom: 15px;
                top: 0px;
            }

            .menu__list__item a {
                text-decoration: none;
                color: grey;
                text-align: center;
                font-size: 1.5em;
                font-family: 'Open Sans', sans-serif;
            }

            .menu__list__item {
                opacity: 0;
            }

            .menu__list--animate .menu__list__item {
                -webkit-animation: drop 0.3s;
                animation: drop 0.3s;
                -webkit-animation-fill-mode: forwards;
                animation-fill-mode: forwards;
                opacity: 1;
            }
            .menu__list--animate .menu__list__item:nth-child(2) {
                -webkit-animation-delay: 0.5s;
                animation-delay: 0.5s;
            }
            .menu__list--animate .menu__list__item:nth-child(3) {
                -webkit-animation-delay: 1s;
                animation-delay: 1s;
            }
            /*            .menu__list--animate .menu__list__item:nth-child(4) {
                            -webkit-animation-delay: 1.5s;
                            animation-delay: 1.5s;
                        }
                        .menu__list--animate .menu__list__item:nth-child(5) {
                            -webkit-animation-delay: 2.0s;
                            animation-delay: 2.0s;
                        }*/
            html {
                overflow: scroll;
                overflow-x: hidden;
            }
            ::-webkit-scrollbar {
                width: 0px;  /* remove scrollbar space */
                background: transparent;  /* optional: just make scrollbar invisible */
            }
            /* optional: show position indicator in red */
            ::-webkit-scrollbar-thumb {
                background: #FF0000;
            }

            #containerx{width: 100%; height: 900px; overflow: hidden;}
            iframe{width: 100%; height: 918px;}
        </style>


        <!-- Modernizer Script for old Browsers -->
        <script src="<?php echo base_url('assets/welcome_board/js/modernizr-2.6.2.min.js'); ?>"></script>


    </head>

    <body id="body" style="">

        <!-- preloader -->
        <div id="preloader">
            <div class="loder-box">
                <div class="battery"></div>
            </div>
        </div>
        <!-- end preloader -->

        <!-- Fixed Navigation
        ==================================== -->
        <header id="navigation" class="navbar-inverse navbar-fixed-top animated-header" style="display:none;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <h1 class="navbar-brand">
                        <a href="#body">AISIN</a>
                    </h1>

                </div>


                <nav class="collapse navbar-collapse navbar-right" role="navigation">
                    <ul id="nav" class="nav navbar-nav">
                        <li ><a href="#body" id="back_to_home" onclick="gotoNullIframe();
                                stopAll1();">Home</a></li>
                        <!--                        <li><a href="#service" id="btn_about" onclick="gotoNullIframe();
                                                        stopAll1();">About</a></li>-->
                        <!--                        <li><a href="#portfolio" id="btn_product" onclick="gotoNullIframe();
                                                        stopAll1();">Product</a></li>-->
                        <!--                        <li><a href="#testimonials" id="btn_information">Information</a></li>-->
                        <li><a href="#aisin-10th" id="btn-aisin-10th" style="display:none;" onclick="gotoNullIframe();
                                stopAll1();">Aisin 10th's Video</a></li>
                        <li><a href="#aisin-20th" id="btn-aisin-20th" style="display:none;" onclick="gotoNullIframe();
                                stopAll1();">Aisin 20th's Video</a></li>
                        <li><a href="#aisin-seiki" id="btn_aisin-seikis" style="display:none;" onclick="gotoNullIframe();
                                stopAll1();">Aisin Seiki's Video</a></li>
                        <li><a href="#iframe" id="iframe_maps" style="" onclick="gotoIframe();">Maps</a></li>
                        <li><a href="#location" id="iframe_parking1" style="" onclick="gotoIframe_parking1();"></a></li>
                        <li><a href="" id="check" style="" >Ajax</a></li>
                    </ul>
                </nav>



            </div>
        </header>
        <!--
        End Fixed Navigation
        ==================================== -->

    <main class="site-content" role="main">

        <!--
        Home Slider
        ==================================== -->

        <section id="home-slider">
            <div id="slider" class="sl-slider-wrapper">

                <div class="sl-slider">

                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">

                        <div class="bg-img bg-img-1"></div>

                        <div class="slide-caption">
                            <div class="caption-content">
<!--                                <h2 class="animated fadeInUp" style="font-weight: 800;font-size: 70px;">WELCOME </h2>
                                <h2 class="animated fadeInDown" style="font-weight: 600;">PARTICIPANT OF BUZZ ASTRA<br> </h2>

                                <span style="font-size: 50px;margin-top: 20px;"> TO PT AISIN INDONESIA</span>-->


                            </div>
                        </div>

                    </div>

                    <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">

                        <div class="bg-img bg-img-2"></div>
                        <div class="slide-caption">
                            <div class="caption-content">
<!--                                <h2 class="animated fadeInDown">AISIN INDONESIA</h2>
                                <span class="animated fadeInDown">You've been using our products for year. You just didn't know it</span>-->

                            </div>
                        </div>

                    </div>

<!--                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">

                        <div class="bg-img bg-img-3"></div>
                        <div class="slide-caption">
                            <div class="caption-content">
                                <h2>High Quality Product</h2>
                                <span>We are Commitment to Quality First</span>
                                <a href="#" class="btn btn-blue btn-effect">Join US</a>
                            </div>
                        </div>

                    </div>-->
                    <!--                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
                    
                                            <div class="bg-img bg-img-4"></div>
                                            <div class="slide-caption">
                                                <div class="caption-content">
                                                    <h2>High Technology</h2>
                                                    <span>We are Engaged In Technological development Project</span>
                                                    <a href="#" class="btn btn-blue btn-effect">Join US</a>
                                                </div>
                                            </div>
                    
                                        </div>-->

                </div>
                <!-- /sl-slider -->
                <nav id="nav-arrows" class="nav-arrows">
                    <span class="nav-arrow-prev">Previous</span>
                    <span class="nav-arrow-next">Next</span>
                </nav>

                <!--                    <nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
                                        <a href="javascript:;" class="sl-prev">
                                            <i class="fa fa-angle-left fa-3x"></i>
                                        </a>
                                        <a href="javascript:;" class="sl-next">
                                            <i class="fa fa-angle-right fa-3x"></i>
                                        </a>
                                    </nav>-->

                <nav id="nav-dots" class="nav-dots visible-xs visible-sm hidden-md hidden-lg">
                    <span class="nav-dot-current"></span>
                    <span></span>
                    <span></span>
                </nav>

            </div>
            <!-- /slider-wrapper -->
        </section>
    </main>

    <!-- Essential jQuery Plugins
    ================================================== -->
    <!-- Main jQuery -->
    <script src="<?php echo base_url('assets/welcome_board/js/jquery-1.11.1.min.js'); ?>"></script>
    <!-- Twitter Bootstrap -->
    <script src="<?php echo base_url('assets/welcome_board/js/bootstrap.min.js'); ?>"></script>
    <!-- Single Page Nav -->
    <script src="<?php echo base_url('assets/welcome_board/js/jquery.singlePageNav.min.js'); ?>"></script>
    <!-- jquery.fancybox.pack -->
    <script src="<?php echo base_url('assets/welcome_board/js/jquery.fancybox.pack.js'); ?>"></script>
    <!-- Google Map API -->
    <!--<script src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
    <!-- Owl Carousel -->
    <script src="<?php echo base_url('assets/welcome_board/js/owl.carousel.min.js'); ?>"></script>
    <!-- jquery easing -->
    <script src="<?php echo base_url('assets/welcome_board/js/jquery.easing.min.js'); ?>"></script>
    <!-- Fullscreen slider -->
    <script src="<?php echo base_url('assets/welcome_board/js/jquery.slitslider.js'); ?>"></script>
    <script src="<?php echo base_url('assets/welcome_board/js/jquery.ba-cond.min.js'); ?>"></script>
    <!-- onscroll animation -->
    <script src="<?php echo base_url('assets/welcome_board/js/wow.min.js'); ?>"></script>
    <!-- Custom Functions -->
    <script src="<?php echo base_url('assets/welcome_board/js/main.js'); ?>"></script>

    <script>


                            $(document).ready(function() {
                                var menu = 0;
                                $(".nav-arrow-prev").hide();
                                $(".nav-arrow-next").hide();
                                var intervalClick = 1;

                                setTimeout(function() {
                                    clickNexSlider();
                                }, 5000);
                                setInterval(function() {
                                    $(".nav-arrow-next").click();
                                    $(".nav-arrow-prev").hide();
                                    $(".nav-arrow-next").hide();
                                }, 5000);
                            });

                            function clickNexSlider() {
                                document.getElementsByClassName("img-side-menu").click();
                                if (intervalClick != 1) {
                                    setTimeout(function() {
                                        clickNexSlider();
                                    }, 5000);
                                    if (intervalClick == 3) {
                                        intervalClick = 1;
                                    }
                                } else {
                                    setTimeout(function() {
                                        clickNexSlider();
                                    }, 5000);
                                }
                            }


                            function stopAll() {
                                document.getElementById("img-side-menu").click();
                                var media = document.getElementsByClassName('media'),
                                        i = media.length;

                                while (i--) {
                                    media[i].pause();
                                    media[i].currentTime = 0;
                                }
                            }

                            function stopAll1() {

                                var media = document.getElementsByClassName('media'),
                                        i = media.length;

                                while (i--) {
                                    media[i].pause();
                                    media[i].currentTime = 0;
                                }
                            }

                            function gotoIframe() {
                                var myIframe = document.getElementById('iframe');
                                var i = 0;
                                setTimeout(function() {
                                    var refreshIntervalId =
                                            setInterval(function() {
                                                i = i + 5;
                                                myIframe.contentWindow.scrollTo(0, i);
                                                if (i == 500) {
                                                    clearInterval(refreshIntervalId);
                                                }
                                            }, 10);
                                }, 1300);

                            }

                            function gotoIframe_parking1() {
                                var myIframe = document.getElementById('iframe_parking1');
                                var i = 0;


                                setTimeout(function() {
                                    var refreshIntervalId =
                                            setInterval(function() {
                                                i = i + 5;
                                                myIframe.contentWindow.scrollTo(0, i);
                                                if (i == 500) {
                                                    clearInterval(refreshIntervalId);
                                                }
                                            }, 10);
                                }, 1300);

                            }

                            function gotoNullIframe() {
                                var myIframe = document.getElementById('iframe');
                                myIframe.contentWindow.scrollTo(0, 0);
                            }
    </script>

    <script>
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
            showDivs(slideIndex += n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            x[slideIndex - 1].style.display = "block";
        }
    </script>

</body>
</html>