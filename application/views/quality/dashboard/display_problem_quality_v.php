
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <!-- meta character set -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>		
        <meta name="description" content="Blue One Page Creative HTML5 Template">
        <meta name="keywords" content="one page, single page, onepage, responsive, parallax, creative, business, html5, css3, css3 animation">
        <meta name="author" content="Muhammad Morshed">
        <meta http-equiv="refresh" content="60; URL='dashboard_delia_c'">

        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS
        ================================================== -->

        <!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/font-awesome.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/jquery.fancybox.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/bootstrap.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/owl.carousel.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/slit-slider.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/animate.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/main.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/quality_assets/css/slide-menu.css'); ?>" >

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
        <script src="<?php echo base_url('assets/quality_assets/js/modernizr-2.6.2.min.js') ?>"></script>
<!--        <script>
            $(document).ready(function(){
                setInterval(function() {
                    $("#sl-slider").load("sepia/dashboard_sepia_c");
                }, 10000);
            });

        </script>-->
    </head>

    <body id="body" style="">

    <main class="site-content" role="main">

        <!-- Home Slider
        ==================================== -->
        <section id="home-slider">
            <div id="slider" class="sl-slider-wrapper">
                <?php if (count($schedule_cust) <> 0) { ?>
                <div class="sl-slider">
                   <?php 
                    $i = 1;
                    $num_key_konst = 0;
                    $limit_const   = 25;
                    ?>
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" align='left' style="padding: 20px; border-style: solid; border: 0.5px; border-spacing: 5px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 700; font-size: 60px; background: #3D3D3D;"><img src="<?php echo base_url('assets/img/logo30.png'); ?>" alt="" height="80px"></td>
                                </tr>
                            </table>
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" style="padding: 5px; border-style: solid; border: 0.5px; border-spacing: 5px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 700; font-size: 55px; background: #3D3D3D;">DASHBOARD DELIVERY PERFORMANCE MILKRUN - <?php echo strtoupper(date('d M Y', strtotime($date_now))); ?></td>
                                </tr>
                            </table>
                                
                            <table style='width:100%;font-weight:600;padding:15px;' border='0px'>
                                <thead style="font-size: 33px">
                                    <tr style='height:80px;background:#18181E;'>
                                        <th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>NO</th>
                                        <th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>CUSTOMER</th>
                                        <th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>DOCK</th>
                                        <!--<th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>DIS CHANNEL</th>-->
                                        <th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>ROUTE</th>
                                        <th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>CYCLE</th>
                                        <th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>VENDOR</th>
                                        <th colspan="3" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>AII ARRIVAL</th>
                                        <th colspan="3" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>AII DEPARTURE</th>
                                        <th rowspan="2" style='text-align: center;border-style: solid;border-color: #3D3D3D;'>LK3 RANK</th>
                                    </tr>
                                    <tr style='height:80px;background:#18181E;'>
                                        <th style='text-align: center;border-style: solid;border-color: #3D3D3D;'>PLAN</th>
                                        <th style='text-align: center;border-style: solid;border-color: #3D3D3D;'>ACTUAL</th>
                                        <th style='text-align: center;border-style: solid;border-color: #3D3D3D;'>RESULT</th>
                                        <th style='text-align: center;border-style: solid;border-color: #3D3D3D;'>PLAN</th>
                                        <th style='text-align: center;border-style: solid;border-color: #3D3D3D;'>ACTUAL</th>
                                        <th style='text-align: center;border-style: solid;border-color: #3D3D3D;'>RESULT</th>                                            
                                    </tr>
                                </thead>
                                <tbody style="font-size: 36px">
                                    <?php //$a = 1;
                                    foreach ($actual_checkin as $key => $isi) { 
                                        if ($key < $num_key_konst) {
                                            if ($num_key_konst != 0) {
                                                continue;
                                            }
                                        } else if ($key >= $limit_const) {
                                            continue;
                                        } else { ?>
                                        <?php if ($i % 2 == 0) { ?>
                                            <tr class='gradeX' style='background-color:#000000;height: 60px'>
                                        <?php } else { ?>
                                            <tr class='gradeX' style='background-color:#333333;height: 60px'>    
                                        <?php } ?>
                                                <td style="border-style: solid;border-style: solid;border-color: #3D3D3D;"><?php echo $i; ?></td>
                                                <td style='text-align: left;border-style: solid;border-style: solid;border-color: #3D3D3D;'><?php echo $isi->CHR_CUST_DESC; ?></td>
                                                <td style="border-style: solid;border-style: solid;border-color: #3D3D3D;"><?php echo $isi->CHR_CUST_DOCK; ?></td>
                                                <?php if($isi->CHR_DIS_CHANNEL == 'C1'){ ?>
                                                    <!--<td style="border-style: solid;border-style: solid;border-color: #3D3D3D;">C1 / OEM</td>-->
                                                <?php } else if($isi->CHR_DIS_CHANNEL == 'C2'){ ?>
                                                    <!--<td style="border-style: solid;border-style: solid;border-color: #3D3D3D;">C2 / AM</td>-->
                                                <?php } else if($isi->CHR_DIS_CHANNEL == 'C3'){ ?>
                                                    <!--<td style="border-style: solid;border-style: solid;border-color: #3D3D3D;">C3 / TRIAL</td>-->
                                                <?php } else { ?>
                                                    <!--<td style="border-style: solid;border-style: solid;border-color: #3D3D3D;">C4 / OTHER</td>-->
                                                <?php } ?>

                                                <td style="border-style: solid;border-style: solid;border-color: #3D3D3D;"><?php echo$isi->CHR_ROUTE; ?></td>
                                                <td style="border-style: solid;border-style: solid;border-color: #3D3D3D;"><?php echo$isi->INT_CYCLE; ?></td>
                                                <td style='border-style: solid;border-style: solid;border-color: #3D3D3D;'><?php echo $isi->CHR_LOG_VENDOR; ?></td>

                                                <td style="border-style: solid;border-style: solid;border-color: #3D3D3D;"><?php echo date('H:i', strtotime($isi->CHR_AII_ARRIVAL)); ?></td>
                                                <?php if($isi->CHR_TIME_CHECKIN != NULL){ ?>
                                                    <td style='border-style: solid;border-style: solid;border-color: #3D3D3D;color: gold;'><?php echo date('H:i', strtotime($isi->CHR_TIME_CHECKIN)); ?></td>                                                    
                                                <?php } else { ?>
                                                    <td style='border-style: solid;border-style: solid;border-color: #3D3D3D;'>-</td>
                                                <?php } ?>

                                                <?php if ($isi->INT_CHECKIN_STAT == '2') { ?>
                                                    <td style='background-color:red; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Delayed</td>
                                                <?php } else if ($isi->INT_CHECKIN_STAT == '1') { ?>
                                                    <td style='background-color:green; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Advanced</td>
                                                <?php } else if ($isi->INT_CHECKIN_STAT == '0') { ?>
                                                    <td style='background-color:blue; border-style: solid;border-style: solid;border-color: #3D3D3D;'>On Time</td>
                                                <?php } else { ?>
                                                    <td style='border-style: solid;border-style: solid;border-color: #3D3D3D;'>-</td>
                                                <?php } ?>

                                                <td style="border-style: solid;border-style: solid;border-color: #3D3D3D;"><?php echo date('H:i', strtotime($isi->CHR_AII_DEPARTURE)); ?></td>
                                                <?php if($isi->CHR_TIME_CHECKOUT != NULL){ ?>
                                                    <td style='border-style: solid;border-style: solid;border-color: #3D3D3D;color: gold;'><?php echo date('H:i', strtotime($isi->CHR_TIME_CHECKOUT)); ?></td>                                                    
                                                <?php } else { ?>
                                                    <td style='border-style: solid;border-style: solid;border-color: #3D3D3D;'>-</td>
                                                <?php } ?>

                                                <?php if ($isi->INT_CHECKOUT_STAT == '2') { ?>
                                                    <td style='background-color:red; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Delayed</td>
                                                <?php } else if ($isi->INT_CHECKOUT_STAT == '1') { ?>
                                                    <td style='background-color:green; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Advanced</td>
                                                <?php } else if($isi->INT_CHECKOUT_STAT == '0') { ?>
                                                    <td style='background-color:blue; border-style: solid;border-style: solid;border-color: #3D3D3D;'>On Time</td>
                                                <?php } else { ?>
                                                    <td style='border-style: solid;border-style: solid;border-color: #3D3D3D;'>-</td>
                                                <?php } ?>

                                                <?php if ($isi->SCORING == 1) { ?>
                                                    <td style='background-color:gold; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Very Good</td>
                                                <?php } else if (($isi->SCORING >= 0.8) and ($isi->SCORING <= 0.99)) { ?>
                                                    <td style='background-color:green; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Good</td>
                                                <?php } else if (($isi->SCORING >= 0.7) and ($isi->SCORING <= 0.79)) { ?>
                                                    <td style='background-color:blue; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Fair</td>                                                    
                                                <?php } else { ?>
                                                    <td style='background-color:red; border-style: solid;border-style: solid;border-color: #3D3D3D;'>Poor</td>
                                                <?php } ?>
                                            </tr>    
                                    <?php
                                            $i++;
                                        }
                                    }
                                    $num_key_konst +=25;
                                    $limit_const +=25;
                                    ?>
                                </tbody>
                            </table>
                           
                        </div>
                    </div>                    
                </div><!-- /sl-slider -->
                <?php } else { ?>
                <div class="sl-slider">
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" align='left' style=" padding: 20px; border-style: solid; border: 0.5px; border-spacing: 5px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 700; font-size: 60px; background: #3D3D3D;"><img src="<?php echo base_url('assets/img/logo30.png'); ?>" alt="" height="80px"></td>
                                </tr>
                            </table>
                            <table style="width:100%;height:98px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 0.5px; border-spacing: 5px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 700; font-size: 55px; background: #3D3D3D;"><blink>NO AVAILABLE SCHEDULE DELIVERY CUSTOMER</blink></td>
                                </tr>
                            </table>
                        </div></div>
                </div>
                <?php } ?>

                <nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
                    <a href="javascript:;" class="sl-prev" style='display: none'>
                        <i class="fa fa-angle-left fa-3x"></i>
                    </a>
                    <a href="javascript:;" class="sl-next" style='display: none'>
                        <i class="fa fa-angle-right fa-3x" id="img-side-menu"></i>
                    </a>
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
    <script src="<?php echo base_url('assets/quality_assets/js/jquery-1.11.1.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/jquery.singlePageNav.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/jquery.fancybox.pack.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/owl.carousel.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/jquery.easing.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/jquery.slitslider.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/jquery.ba-cond.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/wow.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/quality_assets/js/main.js') ?>"></script>
    <script type="text/javascript">
        (function() {
          var blinks = document.getElementsByTagName('blink');
          var visibility = 'hidden';
          window.setInterval(function() {
            for (var i = blinks.length - 1; i >= 0; i--) {
              blinks[i].style.visibility = visibility;
            }
            visibility = (visibility === 'visible') ? 'hidden' : 'visible';
          }, 2000);
        })();
      </script>

    <script>
//        setInterval(function(){
//            $('#sl-slider').load('sepia/dashboard_sepia_c');
//         }, 10000);
        
//        $(document).ready(function() {
//            setTimeout(function() {
//                clickSlider();
//            }, 10000);
//
//            //$(".nav-arrow-prev").hide();
//            //$(".nav-arrow-next").hide();
//            var intervalClick = 1;
//            setTimeout(function() {
//                $.ajax({
//                    type: "POST",
//                    url: "<?php echo site_url('delivery/dashboard_delia_c/updateAjax'); ?>",
//                    dataType: 'json',
//                    success: function(data) {
//                        $(".data_table").html(data);
//                    },
//                    error: function(request, status, error) {
//                        alert(request.responseText);
//                    }
//                });
//            });
//        }, 10000);

        function clickSlider() {
            setTimeout(function() {
                $(".nav-arrow-next").click();
                clickSchedule();
            }, 10000);
        }

        function clickSchedule() {
            setTimeout(function() {
                $("#img-side-menu").click();
                $(".nav-arrow-next").click();
//                window.location.reload(1);
                clickSlider();
            }, 10000);
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