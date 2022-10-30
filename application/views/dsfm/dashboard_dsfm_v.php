
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
        <meta http-equiv="refresh" content="480; URL='dashboard_dsfm_c'">

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
                overflow: hidden;
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
                <?php if ($list_stock_part_num <> 0) { ?>
                <div class="sl-slider">
                   <?php 
                    $i = 1;
                    $total_baris   = 0;
                    $num_key_konst = 0;
                    $limit_const   = 15;
                    for ($llist = 0; $llist < $list_stock_part_num; $llist++) { ?>
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 48px; background: #c42f2f;">REAL TIME STOCK MINIM <?php echo date('d - M - Y', strtotime($date_now)); ?></td>
                                </tr>
                            </table>
                                
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead style="font-size: 23px">
                                        <tr style='height:68px;background:#18181E;'>
                                            <th style='width:10px;text-align: center;border-style: solid;word-wrap: break-word'>NO</th>
                                            <th style='width:40px;text-align: center;border-style: solid;word-wrap: break-word'>BACK NO</th>
                                            <th style='width:60px;text-align: center;border-style: solid;word-wrap: break-word'>PART NO</th>
                                            <th style='width:500px;text-align: center;border-style: solid;word-wrap: break-word'>PART NAME</th>
                                            <th style='width:40px;text-align: center;border-style: solid;word-wrap: break-word'>QTY /BOX</th>
                                            <th style='width:50px;text-align: center;border-style: solid;word-wrap: break-word'>ALAMAT RAK</th>
                                            <th style='width:40px;text-align: center;border-style: solid;word-wrap: break-word'>USAGE /DAY</th>
                                            <th style='width:40px;text-align: center;border-style: solid;word-wrap: break-word'>TOTAL QTY</th>
                                            <th style='width:50px;text-align: center;border-style: solid;word-wrap: break-word'>STOCK POINT < 0.5</th>
                                            <th style='width:40px;text-align: center;border-style: solid;word-wrap: break-word'>UPDATE TIME</th>
                                            <th style='text-align: center;border-style: solid;word-wrap: break-word'>PROBLEM</th>
                                            <th style='text-align: center;border-style: solid;word-wrap: break-word'>C / A</th>
                                            <th style='text-align: center;border-style: solid;word-wrap: break-word'>PIC</th>
                                            <th style='text-align: center;border-style: solid;word-wrap: break-word'>SUPPLIER</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody style="font-size: 21px">
                                        <?php //$a = 1;
                                        foreach ($list_stock_part as $key => $isi) { 
                                            if ($key < $num_key_konst) {
                                                if ($num_key_konst != 0) {
                                                    continue;
                                                }
                                            } elseif ($key >= $limit_const) {
                                                continue;
                                            } else { ?>
                                            <?php if ($i % 2 == 0) { ?>
                                                <tr class='gradeX' style='background-color:#000000;height: 60px'>
                                            <?php } else { ?>
                                                <tr class='gradeX' style='background-color:#333333;height: 60px'>    
                                            <?php } ?>
                                                    <td style="border-style: solid"><?php echo $i; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_BACK_NUMBER; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PART_NO; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PART_NAME; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_QTY_BOX; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_RAKNO; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_USAGEPERDAY; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_PART_QTY; ?></td>
                                                    <td style="border-style: solid"><?php echo round(($isi->INT_PART_QTY) / ($isi->INT_USAGEPERDAY),2); ?></td>
                                                    <td style="border-style: solid"><?php echo date('H:i', strtotime($isi->CHR_JAM)); ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PROBLEM_STOCK; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_CA_STOCK; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PIC; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_SUPPLIER_NAME; ?></td>
                                                </tr>    
                                        <?php
                                                $i++;
                                                //$total_baris++;
                                            }
                                        }
                                        $num_key_konst +=15;
                                        $limit_const +=15;
                                        ?>
                                    </tbody>
                                    
                                </table>
                           
                        </div>
                    </div>
                    <?php } ?>
                    
                </div>
                <?php } else { ?>
                <div class="sl-slider">
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:98px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 40px; background: #2390ef;"><blink>BELUM ADA STOCK MINIM <?php echo date('d - M - Y', strtotime($date_now)); ?></blink></td>
                                </tr>
                            </table>
                        </div></div>
                </div>
                <?php } ?>
                
<!--                <div class="sl-slider">
                   <?php 
                    $i = 1;
                    $total_baris   = 0;
                    $num_key_konst = 0;
                    $limit_const   = 20;
                    for ($llist = 0; $llist < $list_order_part_num; $llist++) { ?>
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 48px; background: #2390ef;">DASHBOARD ORDER KE SUPPLIER <?php echo date('d - M - Y', strtotime($date_now)); ?></td>
                                </tr>
                            </table>
                                
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead style="font-size: 33px">
                                        <tr style='height:70px;background:#18181E;'>
                                            <th style='text-align: center;border-style: solid'>NO</th>
                                            <th style='text-align: center;border-style: solid'>KODE SUPPLIER</th>
                                            <th style='text-align: center;border-style: solid'>NAMA SUPPLIER</th>
                                            <th style='text-align: center;border-style: solid'>CYCLE ISSUE</th>
                                            <th style='text-align: center;border-style: solid'>JAM ORDER</th>
                                            <th style='text-align: center;border-style: solid'>ACTUAL ORDER</th>
                                            <th style='text-align: center;border-style: solid'>TGL KEDATANGAN</th>
                                            <th style='text-align: center;border-style: solid'>CYCLE KEDATANGAN</th>
                                            <th style='text-align: center;border-style: solid'>STATUS ORDER</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 36px">
                                        <?php //$a = 1;
                                        foreach ($list_order_part as $key => $isi) { 
                                            if ($key < $num_key_konst) {
                                                if ($num_key_konst != 0) {
                                                    continue;
                                                }
                                            } elseif ($key >= $limit_const) {
                                                continue;
                                            } else { ?>
                                            <?php if ($i % 2 == 0) { ?>
                                                <tr class='gradeX' style='background-color:#000000;height: 60px'>
                                            <?php } else { ?>
                                                <tr class='gradeX' style='background-color:#333333;height: 60px'>    
                                            <?php } ?>
                                                    <td style="border-style: solid"><?php echo $i; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_SUPPLIER_ID; ?></td>
                                                    <td style='text-align: left;border-style: solid'><?php echo $isi->CHR_SUPPLIER_NAME; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_CYCLE_DAY; ?> - <?php echo $isi->INT_CYCLE_BIN; ?> - <?php echo $isi->CHR_CYCLE_AFTER; ?></td>
                                                    <td style="border-style: solid"><?php echo date('H:i:s', strtotime($isi->CHR_ORDER_TIME)); ?></td>
                                                    <td style="border-style: solid"><?php echo date('H:i:s', strtotime($isi->CHR_CREATE_TIME)); ?></td>
                                                    <td style="border-style: solid"><?php echo date('d-m-Y', strtotime($isi->CHR_DATE_DELIVERY)); ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_TRUCK; ?></td>
                                                    <?php if (date('d - M - Y', strtotime($date_now)) and (strtotime($isi->CHR_ORDER_TIME) < strtotime($isi->CHR_CREATE_TIME))) { ?>                                                    
                                                        <td style='background-color:red;border-style: solid'>DELAY</td>
                                                    <?php } elseif (strtotime($isi->CHR_ORDER_TIME) - strtotime($isi->CHR_CREATE_TIME) <= 1200) { ?>
                                                        <td style='background-color:green;border-style: solid'>NORMAL</td>
                                                    <?php } elseif (strtotime($isi->CHR_ORDER_TIME) - strtotime($isi->CHR_CREATE_TIME) > 1200) { ?>
                                                        <td style='background-color:blue;border-style: solid'>ADVANCED</td>
                                                    <?php } ?>
                                                </tr>    
                                        <?php
                                                $i++;
                                                //$total_baris++;
                                            }
                                        }
                                        $num_key_konst +=20;
                                        $limit_const +=20;
                                        ?>
                                    </tbody>
                                </table>
                           
                        </div>
                    </div>
                    <?php } ?>
                    
                </div>-->
                
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
        
        $(document).ready(function() {
            setTimeout(function() {
                clickSlider();
            }, 30000);

            //$(".nav-arrow-prev").hide();
            //$(".nav-arrow-next").hide();
            var intervalClick = 1;
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('sepia/dashboard_sepia_c/updateAjax'); ?>",
                    dataType: 'json',
                    success: function(data) {
                        $(".data_table").html(data);
                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                    }
                });
            });
        }, 30000);

        function clickSlider() {
            setTimeout(function() {
                $(".nav-arrow-next").click();
                clickSchedule();
            }, 30000);
        }

        function clickSchedule() {
            setTimeout(function() {
                $("#img-side-menu").click();
                $(".nav-arrow-next").click();
//                window.location.reload(1);
                clickSlider();
            }, 30000);
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