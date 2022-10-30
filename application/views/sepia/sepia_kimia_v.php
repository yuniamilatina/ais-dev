
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
        <meta http-equiv="refresh" content="480; URL='sepia_kimia_c'">

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
                <?php if ($list_receive_part_num <> 0) { ?>
                <div class="sl-slider">
                   <?php 
                    $i = 1;
                    $total_baris   = 0;
                    $num_key_konst = 0;
                    $limit_const   = 20;
                    for ($llist = 0; $llist < $list_receive_part_num; $llist++) { ?>
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 48px; background: #002AFF;">DASHBOARD SUPPLIER PERFORMANCE (SEPIA) <?php echo date('d - M - Y', strtotime($date_now)); ?></td>
                                </tr>
                            </table>
                                
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead style="font-size: 33px">
                                        <tr style='height:70px;background:#18181E;'>
                                            <th style='text-align: center;border-style: solid'>NO</th>
                                            <th style='text-align: center;border-style: solid'>NAMA</th>
                                            <th style='text-align: center;border-style: solid'>PDS NO</th>
                                            <th style='text-align: center;border-style: solid'>DELIVERY DATE</th>
                                            <th style='text-align: center;border-style: solid'>QTY PDS</th>
                                            <th style='text-align: center;border-style: solid'>QTY ACT.</th>
                                            <th style='text-align: center;border-style: solid'>PLAN ETA</th>
                                            <th style='text-align: center;border-style: solid'>ACT. ETA</th>
                                            <th style='text-align: center;border-style: solid'>RESULT</th>
                                            <th style='text-align: center;border-style: solid'>LK3 RANK</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 36px">
                                        <?php //$a = 1;
                                        foreach ($list_receive_part as $key => $isi) { 
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
                                                    <td style='text-align: left;border-style: solid'><?php echo $isi->CHR_SUPPLIER_NAME; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PDS_NO; ?></td>
                                                    <td style="border-style: solid"><?php echo date('d-m-Y', strtotime($isi->CHR_DELIVERY_DATE)); ?></td>
                                                    <td style="border-style: solid"><?php echo number_format($isi->Part_order); ?></td>
                                                    <?php if ($isi->Part_order <> $isi->Part_act) { ?>
                                                        <td style='background-color:red;border-style: solid'><?php echo number_format($isi->Part_act); ?></td>
                                                    <?php } else { ?>
                                                        <td style="border-style: solid"><?php echo number_format($isi->Part_act); ?></td>
                                                    <?php } ?>
                                                    <td style="border-style: solid"><?php echo date('H:i', strtotime($isi->CHR_TIME)); ?></td>
                                                    <?php if ((($isi->Part_order <> $isi->Part_act) and ($isi->CHR_TIME_CHECKIN > $isi->CHR_TIME) and ($isi->CHR_DATE_CHECKIN > $isi->CHR_DELIVERY_DATE) and ($isi->Status == 'Delayed')) or (($isi->Part_order = $isi->Part_act) and ($isi->CHR_TIME_CHECKIN > $isi->CHR_TIME) and ($isi->CHR_DATE_CHECKIN > $isi->CHR_DELIVERY_DATE) and ($isi->Status == 'Delayed')) 
                                                            or (($isi->Part_order <> $isi->Part_act) and ($isi->CHR_TIME_CHECKIN < $isi->CHR_TIME) and ($isi->CHR_DATE_CHECKIN > $isi->CHR_DELIVERY_DATE) and ($isi->Status == 'Delayed')) or (($isi->Part_order = $isi->Part_act) and ($isi->CHR_TIME_CHECKIN < $isi->CHR_TIME) and ($isi->CHR_DATE_CHECKIN > $isi->CHR_DELIVERY_DATE) and ($isi->Status == 'Delayed'))
                                                            or (($isi->Part_order <> $isi->Part_act) and ($isi->CHR_TIME_CHECKIN > $isi->CHR_TIME) and ($isi->CHR_DATE_CHECKIN = $isi->CHR_DELIVERY_DATE) and ($isi->Status == 'Delayed'))
                                                            or (($isi->Part_order = $isi->Part_act) and ($isi->CHR_TIME_CHECKIN > $isi->CHR_TIME) and ($isi->CHR_DATE_CHECKIN = $isi->CHR_DELIVERY_DATE) and ($isi->Status == 'Delayed'))) { ?>
                                                        <td style='background-color:red;border-style: solid'><?php echo date('H:i', strtotime($isi->CHR_TIME_CHECKIN)); ?></td>
                                                    <?php } else { ?>
                                                        <td style="border-style: solid"><?php echo date('H:i', strtotime($isi->CHR_TIME_CHECKIN)); ?></td>
                                                    <?php } ?>
                                                    <?php if ($isi->Status == 'Delayed') { ?>
                                                        <td style='background-color:red;border-style: solid'><?php echo $isi->Status; ?></td>
                                                    <?php } elseif (($isi->Status == 'Advanced') and ($isi->Arrival == 'C')) { ?>
                                                        <td style='background-color:green;border-style: solid'>Normal</td>
                                                    <?php } else { ?>
                                                        <td style='background-color:blue;border-style: solid'><?php echo $isi->Status; ?></td>
                                                    <?php } ?>
                                                    <?php if ($isi->Nilai_akhir == 1) { ?>
                                                        <td style='background-color:palevioletred;border-style: solid'>Very Good</td>
                                                    <?php } elseif (($isi->Nilai_akhir >= 0.8) and ($isi->Nilai_akhir <= 0.99)) { ?>
                                                        <td style='background-color:green;border-style: solid'>Good</td>
                                                    <?php } elseif (($isi->Nilai_akhir >= 0.7) and ($isi->Nilai_akhir <= 0.79)) { ?>
                                                        <td style='background-color:blue;border-style: solid'>Fair</td>
                                                    
                                                    <?php } else { ?>
                                                        <td style='background-color:red;border-style: solid'>Poor</td>
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
                    
                </div><!-- /sl-slider -->
                <?php } else { ?>
                <div class="sl-slider">
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:98px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 40px; background: #002AFF;"><blink>TIDAK ADA KEDATANGAN BARANG</blink></td>
                                </tr>
                            </table>
                        </div></div>
                </div>
                <?php } ?>
                
                <div class="sl-slider">
                   <?php 
                    $i = 1;
                    $total_baris   = 0;
                    $num_key_konst = 0;
                    $limit_const   = 20;
                    for ($llist = 0; $llist < $list_schedule_part_num; $llist++) { ?>
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 48px; background: #43FF00;">SUPPLIER ON SCHEDULE <?php echo date('d - M - Y', strtotime($date_now)); ?></td>
                                </tr>
                            </table>
                                
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead style="font-size: 33px">
                                        <tr style='height:70px;background:#18181E;'>
                                            <th style='text-align: center;border-style: solid'>NO</th>
                                            <th style='text-align: center;border-style: solid'>NAMA</th>
                                            <th style='text-align: center;border-style: solid'>TIPE SUPPLIER</th>
                                            <th style='text-align: center;border-style: solid'>TIME ARRIVAL</th>
                                            <th style='text-align: center;border-style: solid'>CYCLE</th>                                                                                   
                                        </tr>
                                    </thead>
                                    
                                    <tbody style="font-size: 36px">
                                        <?php //$a = 1;
                                        foreach ($list_schedule_part as $key => $isi) { 
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
                                                    <td style='text-align: left;border-style: solid'><?php echo $isi->CHR_SUPPLIER_NAME; ?></td>
                                                    <?php if ($isi->CHR_MILKRUN_ZONE == null) { ?>
                                                        <td style="border-style: solid">DIRECT</td>
                                                    <?php } else { ?>
                                                        <td style="border-style: solid">MILKRUN</td>
                                                    <?php } ?>
                                                    <td style="border-style: solid"><?php echo date('H:i', strtotime($isi->CHR_TIME)); ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_TRUCK; ?></td>
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
                    
                </div>
                
                <div class="sl-slider">
                   <?php 
                    $i = 1;
                    $total_baris   = 0;
                    $num_key_konst = 0;
                    $limit_const   = 20;
                    for ($llist = 0; $llist < $list_delay_part_num; $llist++) { ?>
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 48px; background: #FF0000;">DELAY SUPPLIER <?php echo date('M - Y', strtotime($date_now)); ?></td>
                                </tr>
                            </table>
                                
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead style="font-size: 33px">
                                        <tr style='height:70px;background:#18181E;'>
                                            <th style='text-align: center;border-style: solid'>NO</th>
                                            <th style='text-align: center;border-style: solid'>NAMA</th>
<!--                                            <th style='text-align: center;border-style: solid'>PLAN ARRIVAL</th>
                                            <th style='text-align: center;border-style: solid'>CYCLE</th>-->
                                            <th style='text-align: center;border-style: solid'>PROBLEM</th>            
                                            <th style='text-align: center;border-style: solid'>C / A</th>
                                            <th style='text-align: center;border-style: solid'>PIC</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody style="font-size: 30px">
                                        <?php //$a = 1;
                                        foreach ($list_delay_part as $key => $isi) { 
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
                                                    <td style='text-align: left;border-style: solid'><?php echo $isi->CHR_SUPPLIER_NAME; ?></td>
<!--                                                    <td style="border-style: solid"><?php echo date('H:i:s', strtotime($isi->CHR_TIME)); ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_TRUCK; ?></td>-->
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PROBLEM_STOCK; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_CA_STOCK; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PIC; ?></td>
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
                    
                </div>
                
                <div class="sl-slider">
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
                                    <thead style="font-size: 30px">
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
                                    <tbody style="font-size: 30px">
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
                                                    <td style="border-style: solid"><?php echo $isi->CHR_SUPPLIER_CYCLE; ?></td>
                                                    <td style="border-style: solid"><?php echo date('H:i:s', strtotime($isi->CHR_ORDER_TIME)); ?></td>
                                                    <td style="border-style: solid"><?php echo date('H:i:s', strtotime($isi->CHR_CREATE_TIME)); ?></td>
                                                    <td style="border-style: solid"><?php echo date('d-m-Y', strtotime($isi->CHR_DATE_DELIVERY)); ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_TRUCK; ?></td>
                                                    <?php if (strtotime($isi->CHR_ORDER_TIME) < strtotime($isi->CHR_CREATE_TIME)) { ?>                                                    
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
                    
                </div><!-- /sl-slider -->
                
<!--                <div class="sl-slider">
                   <?php 
                    $i = 1;
                    $total_baris   = 0;
                    $num_key_konst = 0;
                    $limit_const   = 20;
                    for ($llist = 0; $llist < $list_sum_delay_num; $llist++) { ?>
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;height:78px" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 48px; background: #FF6E00;">SUMMARY DELAY SUPPLIER <?php echo date('M - Y', strtotime($date_now)); ?></td>
                                </tr>
                            </table>
                                
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead style="font-size: 28px">
                                        <tr style='height:70px;background:#18181E;'>
                                            <th style='text-align: center;border-style: solid'>NO</th>
                                            <th style='text-align: center;border-style: solid'>NAMA SUPPLIER</th>
                                            <th style='text-align: center;border-style: solid'>PDS NO</th>
                                            <th style='text-align: center;border-style: solid'>RECOVERY</th>
                                            <th style='text-align: center;border-style: solid'>ISSUE DATE</th>
                                            <th style='text-align: center;border-style: solid'>DELIVERY DATE</th>
                                            <th style='text-align: center;border-style: solid'>CYCLE</th>
                                            <th style='text-align: center;border-style: solid'>PART NAME</th>
                                            <th style='text-align: center;border-style: solid'>BACK NO</th>
                                            <th style='text-align: center;border-style: solid'>DELAY QTY</th>                                                                                   
                                        </tr>
                                    </thead>
                                    
                                    <tbody style="font-size: 27px">
                                        <?php //$a = 1;
                                        foreach ($list_sum_delay as $key => $isi) { 
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
                                                    <td style='text-align: left;border-style: solid'><?php echo $isi->CHR_SUPPLIER_NAME; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PDS_NO; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_RECOVERY; ?></td>
                                                    <td style="border-style: solid"><?php echo date('d-m-Y', strtotime($isi->CHR_ISSUE_DATE)) ?></td>
                                                    <td style="border-style: solid"><?php echo date('d-m-Y', strtotime($isi->CHR_DELIVERY_DATE)) ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_TRUCK; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_PART_NAME; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->CHR_BACK_NO; ?></td>
                                                    <td style="border-style: solid"><?php echo $isi->INT_QTY; ?></td>
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
            }, 10000);

            //$(".nav-arrow-prev").hide();
            //$(".nav-arrow-next").hide();
            var intervalClick = 1;
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('sepia/sepia_kimia_c/updateAjax'); ?>",
                    dataType: 'json',
                    success: function(data) {
                        $(".data_table").html(data);
                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                    }
                });
            });
        }, 10000);

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