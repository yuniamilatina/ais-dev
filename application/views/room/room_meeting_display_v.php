
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

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

        <!-- Fontawesome Icon font -->

        <!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/font-awesome.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/jquery.fancybox.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/bootstrap.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/owl.carousel.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/slit-slider.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/animate.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/main.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/aisin_company/css/slide-menu.css'); ?>" >

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
        </style>


        <!-- Modernizer Script for old Browsers -->
        <script src="<?php echo base_url('assets/aisin_company/js/modernizr-2.6.2.min.js') ?>"></script>


    </head>

    <body id="body" style="">

        <!-- <img id="img-side-menu" src="<?php echo base_url('assets/aisin_company/img/contur2.png') ?>" style="left:0px;position: fixed;top: 30%;z-index:201;width:200px;padding:20px 20px 20px 20px;border-radius: 120px;"> -->

        <!-- preloader -->
        <div id="preloader">
            <div class="loder-box">
                <div class="battery"></div>
            </div>
        </div>
        <!-- end preloader -->

        <!--
        Fixed Navigation
        ==================================== -->
        <header id="navigation" class="navbar-inverse navbar-fixed-top animated-header" style='display:none;'>
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                    </button>

                    <h1 class="navbar-brand">

                    </h1>

                </div>

                <nav class="collapse navbar-collapse navbar-right" role="navigation">
                    <ul id="nav" class="nav navbar-nav">
                        <li><a href="#portfolio" id="btn_product">Product</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <!-- End Fixed Navigation -->

    <main class="site-content" role="main">

        <!-- Home Slider -->
        <section id="home-slider">
            <div id="slider" class="sl-slider-wrapper">

                <div class="sl-slider">

                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">

                        <div class="bg-img bg-img-0"></div>
                        <div class="slide-caption">
                            <div class="caption-content">
                                <label id="roomid" style="display:none;"><?php echo $roomid; ?></label>
                                <h1 class="animated fadeInDown"><?php echo $room; ?></h1>
                                <h3 class="animated fadeInDown" id="meeting_info"><?php echo $data_room_desc; ?></h3>
                                <span class="animated fadeInDown" id="meeting_time"><?php echo $data_room_date; ?></span>

                                <!-- BEGIN BASIC TABLE -->
                                <div id="data-table-room">
                                <?php if (count($data_room_next_reservation_table) > 0) { ?>
                                    <div class="col-md-6" style="margin-left:340px;margin-right: auto;color: white;" id="nextRoomTable">
                                        <div class="grid no-border">
                                            <div class="grid-header">
                                                <i class="fa fa-bookmark"></i>
                                                <span class="grid-title">Next Reservation</span>
                                            </div>
                                            <div class="grid-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center;">No</th>
                                                            <th style="text-align: center;">Date</th>
                                                            <th style="text-align: center;">Time</th>
                                                            <th style="text-align: center;">Activity</th>
                                                            <th style="text-align: center;">PIC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($data_room_next_reservation_table as $value_room) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo date("jS F, Y", strtotime($value_room->CHR_DATE_FROM)); ?></td>
                                                                <td><?php echo date("H:i", strtotime($value_room->CHR_TIME_FROM)) . " - " . date("H:i", strtotime($value_room->CHR_TIME_TO)); ?></td>
                                                                <td><?php echo $value_room->CHR_MEETING_DESC; ?></td>
                                                                <td><?php echo $value_room->CHR_MEETING_PIC; ?></td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                </div>
                                <!-- END BASIC TABLE -->
                            </div>
                        </div>
                    </div>

                    <!-- <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">

                        <div class="bg-img bg-img-2"></div>
                        <div class="slide-caption">
                            <div class="caption-content">
                                <h2 class="animated fadeInDown">AISIN INDONESIA</h2>
                                <span class="animated fadeInDown">You've been using our products for year. You just didn't know it</span>

                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- /sl-slider -->

                <nav id="nav-arrows" class="nav-arrows">
                    <span class="nav-arrow-prev">Previous</span>
                    <span class="nav-arrow-next">Next</span>
                </nav>

                <nav id="nav-dots" class="nav-dots visible-xs visible-sm hidden-md hidden-lg">
                    <span class="nav-dot-current"></span>
                    <span></span>
                    <span></span>
                </nav>

            </div><!-- /slider-wrapper -->
        </section>

    </main>

    <!-- Essential jQuery Plugins
    ================================================== -->
    <script src="<?php echo base_url('assets/aisin_company/js/jquery-1.11.1.min.js') ?>"></script>
    <!-- Main jQuery -->
    <script src="<?php echo base_url('assets/aisin_company/js/bootstrap.min.js') ?>"></script>
    <!-- Twitter Bootstrap -->
    <script src="<?php echo base_url('assets/aisin_company/js/jquery.singlePageNav.min.js') ?>"></script>
    <!-- Single Page Nav -->
    <script src="<?php echo base_url('assets/aisin_company/js/jquery.fancybox.pack.js') ?>"></script>
    <!-- jquery.fancybox.pack -->
    <script src="<?php echo base_url('assets/aisin_company/js/owl.carousel.min.js') ?>"></script>
    <!-- Google Map API -->
    <!--<script src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
    <!-- Owl Carousel -->
    <script src="<?php echo base_url('assets/aisin_company/js/jquery.easing.min.js') ?>"></script>
    <!-- jquery easing -->
    <script src="<?php echo base_url('assets/aisin_company/js/jquery.slitslider.js') ?>"></script>
    <!-- Fullscreen slider -->
    <script src="<?php echo base_url('assets/aisin_company/js/jquery.ba-cond.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/aisin_company/js/wow.min.js') ?>"></script>
    <!-- onscroll animation -->
    <script src="<?php echo base_url('assets/aisin_company/js/main.js') ?>"></script>
    <!-- Custom Functions -->

    <script>
        $(document).ready(function() {
            $(".nav-arrow-prev").hide();
            $(".nav-arrow-next").hide();
            var intervalClick = 1;
            
            $("#img-side-menu").click(function() {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('room/room_meeting_display_c/updateAjax'); ?>",
                    data: {idroom: <?php echo "'$roomid'" ?>},
                    success: function(data) {
                        $("#data-table-room").html(data.data_table);
                        $("#meeting_info").html(data.data_room_desc);
                        $("#meeting_time").html(data.data_room_date);
                    }
                });
            });

            setTimeout(function() {
                clickSlider();
            }, 20000);
        });

        function clickSlider() {
            setTimeout(function() {
                $(".nav-arrow-next").click();
                clickSchedule();

            }, 60000);

        }
        function clickSchedule() {
            setTimeout(function() {
                $("#img-side-menu").click();
                $(".nav-arrow-next").click();
                clickSlider();
            }, 5000);
        }

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
                }, 15000);
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

    </script>


</body>
</html>