
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
        <link rel="icon" href="<?php echo base_url('assets/welcome_board/img/contur2.png'); ?>" > 
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
        <link rel="stylesheet" href="<?php echo base_url('assets/welcome_board/css/slit-slider.css'); ?>">
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
                //padding-bottom: 15px;
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

        <!-- <img id="img-side-menu" src="<?php echo base_url('assets/welcome_board/img/contur2.png'); ?>" style="left:0px;position: fixed;top: 43%;z-index:201;width:150px;padding:20px 20px 20px 20px;border-radius: 120px;"> -->

        <div class="menu-side">
            <ul class="menu__list">
                <!--<li class="menu__list__item"  style="margin-top:-70px;margin-left:-380px;background-color: activeborder;color:white;width:80px;padding:5px;text-align: center;border-radius: 120px;font-size:8px;font-weight: bold;border-color: #ffffff;" onclick='document.getElementById("back_to_home").click();'><a>Home</a></li>-->
                <li class="menu__list__item" id="ajx-vid-10-th" style="margin-left:-220px;margin-top: 10px;background-color: activeborder;color:white;width:150px;padding:5px;text-align: center;border-radius: 120px;font-size:8px;font-weight: bold;display:none;" onclick='document.getElementById("btn-aisin-proper").click();
                        stopAll();
                        document.getElementById("video-aisin-proper").play();'><a>Proper</a></li>
                <li class="menu__list__item" id="ajx-vid-20-th" style="width:100%;height:900px;display:none;" onclick='document.getElementById("btn-aisin-20th").click();
                        stopAll();
                        document.getElementById("video-aisin-20th").play();'><a>20th's Video</a></li>
                <li class="menu__list__item" id="ajx-vid-aisin-seiki" style="margin-left:-220px;margin-top: 30px;background-color: activeborder;color:white;width:150px;padding:5px;text-align: center;border-radius: 120px;font-size:8px;font-weight: bold;display:none;" onclick='document.getElementById("btn_aisin-seikis").click();
                        stopAll();
                        document.getElementById("video-aisin-seiki").play();'><a>Aisin Seiki's Video</a></li>
                <!--<li class="menu__list__item" style="margin-top:40px;margin-left:-380px;background-color: activeborder;color:white;width:80px;padding:5px;text-align: center;border-radius: 120px;font-size:8px;font-weight: bold;" onclick='document.getElementById("btn_gallery").click();'><a>Portfolio</a></li>-->
            </ul>
        </div>

        <!-- preloader -->
        <div id="preloader">
            <div class="loder-box">
                <div class="battery"></div>
            </div>
        </div>
        <!-- end preloader -->

        <!-- Fixed Navigation  ==================================== -->
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
                        <li ><a href="" id="back_to_home" onclick="gotoNullIframe();
                                stopAll1();
                                scrollToTop();">Home</a></li>
                        <li><a href="#aisin-proper" id="btn-aisin-proper" style="display:none;" onclick="gotoNullIframe();
                                stopAll1();">Aisin Proper</a></li>
                        <li><a href="#aisin-20th" id="btn-aisin-20th" style="display:none;" onclick="gotoNullIframe();
                                stopAll1();">Aisin 20th's Video</a></li>
                        <li><a href="#aisin-seiki" id="btn_aisin-seikis" style="display:none;" onclick="gotoNullIframe();
                                stopAll1();">Aisin Seiki's Video</a></li>
                        <li><a href="#iframe" id="iframe_maps" style="" onclick="gotoIframe();
                                stopAll1();">Maps</a></li>
                        <li><a href="#location" id="iframe_parking1" style="" onclick="gotoIframe_parking1();
                                stopAll1();"></a></li>
                        <li><a href="#parkir1-div" id="parkir1" style="" onclick="gotoNullIframe();
                                stopAll1();">PARKIR 1</a></li>
                        <li><a href="#parkir2-div" id="parkir2" style="" onclick="gotoNullIframe();
                                stopAll1();">PARKIR 2</a></li>
                        <li><a href="#lobby-div" id="lobby" style="" onclick="gotoNullIframe();
                                stopAll1();">LOBBY</a></li>
                        <li><a href="#masjid-div" id="masjid" style="" onclick="gotoNullIframe();
                                stopAll1();">MASJID</a></li>
                        <li><a href="#lapangan-div" id="lapangan" style="" onclick="gotoNullIframe();
                                stopAll1();">LAPANGAN</a></li>
                        <li><a href="#koperasi-div" id="koperasi" style="" onclick="gotoNullIframe();
                                stopAll1();">KOPERASI</a></li>
                        <li><a href="#plant-tour-div" id="plant_tour" style="" onclick="gotoNullIframe();
                                stopAll1();">PLANT TOUR</a></li>
                        <li><a href="" id="check" style="" >Ajax</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="site-content" role="main">
            <!-- Home Slider -->
            <section id="home-slider" >
                <div id="slider" class="sl-slider-wrapper">

                    <div class="sl-slider" style="height:800px;">
                        
                        <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                            <div class="bg-img bg-img-1"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    <h2 class="animated fadeInUp" style=" font-size: 30px;font-weight:450;"> WELCOME TO</h2>
                                    <span class="animated fadeInDown" style=" font-size: 45px;font-weight:600;">   PT AISIN INDONESIA</span>
									
                                    <div id="table-data">
                                        <?php //foreach ($data_guest as $isi) { ?>
                                            <!-- <h3 style=" font-size:40px;font-weight:600;text-transform: capitalize;" class="animated fadeInDown">  <?php //echo $isi->CHR_FIRSTNAME;  ?>  </h3>  -->
                                            <h3 style=" font-size:60px;font-weight:600;text-transform: capitalize;" class="animated fadeInDown">  TPS JISHUKEN - TMMIN </h3> 
                                            <h3 style=" font-size:25px;font-weight:300;text-transform: capitalize;" class="animated fadeInDown"> POLITEKNIK MANUFAKTUR ASTRA  </h3> 
                                        <?php //} ?>

                                    </div>
                                </div>
                            </div>
                        </div>
<!-- 
                        <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                            <div class="bg-img bg-img-1"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    
                                    <h2 class="animated fadeInUp" style=" font-size: 50px;font-weight:500;"> AISIN INDONESIA </h2>
                                    <span class="animated fadeInDown" style=" font-size: 40px;font-weight:600;margin-bottom: 10px;">  PLANNING CYCLE (RAPIM) YEAR 2020</span> 
                                    <span class="animated fadeInDown" style=" font-size: 30px;font-weight:300;"> PR HALL AISIN INDONESIA </span>

                                      <h2 class="animated fadeInDown" style=" font-size: 20px;">- February 12th 2020 -</h2>
                                        <span class="animated fadeInDown"></span>
                                 </div>
                            </div>
                        </div> -->

                        <!-- <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                            <div class="bg-img bg-img-2"></div>
                            <div class="slide-caption">
                                <div class="caption-content">  -->
                                     <!-- <h2 class="animated fadeInDown">AISIN INDONESIA</h2>
                                    <span class="animated fadeInDown">You've been using our products for years. You just didn't know it</span>  -->
                                <!-- </div>
                            </div>
                        </div> -->

                        <!-- <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
                            <div class="bg-img bg-img-3"></div>
                            <div class="slide-caption">
                                <div class="caption-content"> -->
                                <!-- <h2 class="animated fadeInUp" style=" font-size: 50px;font-weight:500;"> WELCOME TO </h2>
                                    <span class="animated fadeInDown" style=" font-size: 55px;font-weight:700;">  PT AISIN INDONESIA </span> -->
									
                                    <!-- <div id="table-data3">
                                        <?php //foreach ($data_guest3 as $isi) { ?>
                                            <h3 style=" font-size: 35px;text-transform: capitalize;" class="animated fadeInDown">  <?php //echo $isi->CHR_FIRSTNAME ?>  </h3> 
                                        <?php //} ?>
                                    </div>  -->

                                    <!-- <h2>High Quality Product</h2>
                                    <span>We are Commitment to Quality First</span>
                                </div>
                            </div>
                        </div> -->
                        
                        <!-- <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
                            <div class="bg-img bg-img-4"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    <h2>High Technology</h2>
                                    <span>We are Engaged In Technological development Project</span>  
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
                            <div style="sl-slide" class="bg-img bg-img-5"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    <h2></h2>
                                    <span></span>  
                                </div>
                            </div>
                        </div>

                        <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
                            <div class="bg-img bg-img-6"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    <h2></h2>
                                    <span></span>  
                                </div>
                            </div>
                        </div> -->

                    </div>
                    
                    <!-- /sl-slider -->
                    <!-- <nav id="nav-arrows" class="nav-arrows">
                        <span class="nav-arrow-prev">Previous</span>
                        <span class="nav-arrow-next">Next</span>
                    </nav>

                    <nav id="nav-dots" class="nav-dots visible-xs visible-sm hidden-md hidden-lg">
                        <span class="nav-dot-current"></span>
                        <span></span>
                        <span></span>
                    </nav> -->

                </div>
            </section>

            <!-- End Home SliderEnd -->
            <!-- <section id="service" style="margin-top:-150px;">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;">FLOOR MAPS</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn">
                            <div class="service-item">

                                <div id="containerx">
                                    <iframe src="http://192.168.0.231/aisin_welcome_board/b.html" style="border:none;width: 110%;height:1000px;overflow:hidden;" id="iframe" scrolling="no"></iframe>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- <section id="parkir1-div" style="margin-top:-15px;">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;padding:0px;">PARKING LOT #1</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-25px;">
                            <div class="service-item">

                                <div id="containerx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- <section id="parkir2-div" style="">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;padding:0px;">PARKING LOT #2</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-25px;">
                            <div class="service-item">

                                <div id="containerx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- <section id="lobby-div" style="">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;padding:0px;">LOBBY</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-25px;">
                            <div class="service-item">

                                <div id="containerx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- <section id="masjid-div" style="">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;padding:0px;">MOSQUE</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-25px;">
                            <div class="service-item">

                                <div id="containerx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

           <!-- <section id="lapangan-div" style="">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;padding:0px;">SPORT AREA</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-25px;">
                            <div class="service-item">

                                <div id="containerx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- <section id="koperasi-div" style="">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;padding:0px;">MINI MART</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-25px;">
                            <div class="service-item">

                                <div id="containerx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- <section id="plant-tour-div" style="">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;padding:0px;">DOCUMENTATION</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-25px;">
                            <div class="service-item">

                                <div id="containerx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!--Video  Aisin 10Th--> 
            <!-- <section id="aisin-proper">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;">Aisin Proper</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-70px;">
                            <div class="service-item">
                                <center>
                                    <video class="media" id="video-aisin-proper" width="100%" height="750" controls style="z-index: 400" autoplay loop>
                                        <source src="<?php echo base_url('assets/welcome_board/video/proper_2018.mp4'); ?>" type="video/mp4" >
                                    </video>      
                                </center>
                            </div>
                        </div>

                    </div>
                </div>
            </section> -->
            <!--Video  Aisin 10Th 

             Video  Aisin 20Th -->
            <!-- <section id="aisin-20th">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;">Aisin 20th's Video</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-50px;">

                            <video class="media" id="video-aisin-20th" width="100%" height="750" controls style="z-index: 400">
                                <source src="<?php echo base_url('assets/welcome_board/video/AII FINAL.mov'); ?>" type="video/mp4" >
                            </video>      

                        </div> 
                    </div>
                </div>
            </section> -->
             <!--Video  Aisin 20Th--> 

             <!--Vidio Aisin Seiki--> 
            <!-- <section id="aisin-seiki">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2 style="margin-top:-15px;">Aisin Seiki's Video</h2>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center wow animated zoomIn" style="margin-top:-90px;">
                            <div class="service-item">
                                <center>
                                    <video class="media" id="video-aisin-seiki" width="100%" height="750" controls style="z-index: 400">
                                        <source src="<?php echo base_url('assets/welcome_board/video/aisin-seiki.mp4'); ?>" type="video/mp4" >
                                    </video>      
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <!-- Vidio Aisin Seiki -->
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

       

    </body>
</html>