
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
        <meta http-equiv="refresh" content="60; URL='quality_dashboard_c'">

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

    </head>

    <body id="body" style="">

        <!-- preloader -->
        <!--        <div id="preloader">
                    <div class="loder-box">
                        <div class="battery"></div>
                    </div>
                </div>-->
        <!-- end preloader -->

    <main class="site-content" role="main">

        <!-- Home Slider
        ==================================== -->
        <section id="home-slider">
            <div id="slider" class="sl-slider-wrapper">

                <div class="sl-slider">
                    <?php
                    $count = count($data);
                    if($count != 0){
                        foreach ($data as $isi) { ?>
                        <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                            <div class="slide-caption">
                                <?php
                                    $dept = substr($isi->CHR_SECTION_PIC,0,2);
                                    if($dept == 'PR'){ //IF BEFORE PROCESS IS PRODUCTION --> USING TEAM PIC
                                ?>
                                <table style="width:100%; height: 100%; border-style: solid; border-spacing: 3px; 
                                       border-collapse: separate; border-color: black; background-color: black; 
                                       padding:5px;" border="1px">
                                    <tr>
                                        <td colspan="12" style="width:100%; height:5%; background: #002AFF; vertical-align: middle; font-weight: 800; font-size: 20px; border-radius: 5px;">QUALITY INFORMATION SYSTEM</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" rowspan="9" style="width:60%; background: #333333; vertical-align: middle; border-radius: 5px;"><img width="750" height="350" src="<?php echo base_url($isi->CHR_FILENAME); ?>" style="color: white; font-size:15px; font-weight: 600; max-height: 350; max-width: 850;" alt="NO IMAGE HAS BEEN CAPTURED"></td>
                                        <td colspan="4" style="height:5%; width:10%; background: gold; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: #333333;">DETAIL PART</td>
                                        <td colspan="2" style="height:5%; width:10%; background: gold; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: #333333;">PROBLEM</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 32px; border-radius: 5px; color: gold;"><?php echo $isi->CHR_BACK_NO; ?></td>
                                        <td colspan="2" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 14px; border-radius: 5px; color: gold;"><?php echo substr($isi->CHR_PART_NAME,0,20); ?></td>
                                        <td colspan="2" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: gold;"><?php echo $isi->CHR_QPROBLEM_TITLE; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;">REQUESTOR</td>
                                        <td colspan="3" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;">SECTION</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:10%; height:8%; background: #333333; font-weight: 600; font-size: 18px; border-radius: 5px; color: white;"><?php echo strtoupper($isi->CHR_USERNAME); ?></td>
                                        <td colspan="3" style="width:10%; height:8%; background: #333333; font-weight: 600; border-radius: 5px; color: white;"><?php echo $isi->CHR_SECTION_REQ; ?></td>
                                    </tr>                                  
                                    <tr>
                                        <td colspan="2" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 16px; border-radius: 5px; color: white;">PIC QUA</td>
                                        <td colspan="2" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 16px; border-radius: 5px; color: white;">PIC PRD</td>
                                        <td colspan="2" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 16px; border-radius: 5px; color: white;">PIC ENG</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" rowspan="3" style="height:15%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;"><img src="<?php echo base_url('assets/file/qis_feedback/' . trim($isi->NPK_PIC) . '.jpg'); ?>" width="145px" height="170px" alt="User Image"></td>
                                        <?php
                                            $team = $this->db->query("SELECT CHR_NPK,CHR_USERNAME FROM QUA.TM_MAPPING_TEAM_PIC WHERE INT_ID_TEAM = '$isi->INT_ID_TEAM' AND CHR_POSITION LIKE '%SPV' ORDER BY CHR_POSITION DESC")->result();
                                            foreach($team as $pic_team){
                                        ?>
                                        <td colspan="2" rowspan="3" style="height:15%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;"><img src="<?php echo base_url('assets/file/qis_feedback/' . trim($pic_team->CHR_NPK) . '.jpg'); ?>" width="145px" height="170px" alt="User Image"></td>
                                        <?php } ?>
                                    </tr>
                                    <tr></tr>
                                    <tr></tr>
                                    <?php
                                    $startd = date("d", strtotime($isi->CHR_START_DATE));
                                    $startm = date("M", strtotime($isi->CHR_START_DATE));
                                    $starty = date("Y", strtotime($isi->CHR_START_DATE));
                                    $startt = date("H:i", strtotime($isi->CHR_START_TIME));
                                    $dued = date("d", strtotime($isi->CHR_DUE_DATE));
                                    $duem = date("M", strtotime($isi->CHR_DUE_DATE));
                                    $duey = date("Y", strtotime($isi->CHR_DUE_DATE));
                                    $duet = date("H:i", strtotime($isi->CHR_DUE_TIME));
                                    ?>
                                    <tr>
                                        <td colspan="2" style="height:8%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 14px; border-radius: 5px; color: white;"><?php echo strtoupper(substr($isi->CHR_PIC, 0, strpos($isi->CHR_PIC, ' '))); ?></td>
                                        <?php
                                            foreach($team as $pic_team){
                                        ?>
                                        <td colspan="2" style="height:8%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 14px; border-radius: 5px; color: white;"><?php echo strtoupper($pic_team->CHR_USERNAME); ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php if ($isi->INT_STATUS == 0) { 
                                                if(date('Ymd') > $isi->CHR_DUE_DATE){
                                        ?>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: red; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>
                                        <?php 
                                                } else {
                                                    if(date('His') > $isi->CHR_DUE_TIME){
                                        ?>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: red; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>
                                        <?php                
                                                
                                                    } else {
                                        ?>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; height:10%; background: darkorange; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>
                                        <?php
                                            
                                                    }
                                                }
                                              } else if ($isi->INT_STATUS == 1) { ?>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: darkorange; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>

                                        <?php } else { ?>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; height:10%; background: #00EE00; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>

                                        <?php } ?>   
                                            
                                        <td colspan="3" style="background: #002AFF; height:3%; font-weight: 600; font-size: 18px; border-radius: 5px;">ACCEPTED DATE</td>
                                        <td colspan="3" style="background: #002AFF; height:3%; font-weight: 600; font-size: 18px; border-radius: 5px;">DUE DATE</td>                                        
                                    </tr>  
                                    <tr>
                                        <td colspan="3" style="background: #002AFF; height:7%; font-weight: 600;font-size: 36px; background: #333333; color: white; border-radius: 5px"><?php echo $startd . ' ' . strtoupper($startm); ?></td>
                                        <td colspan="3" style="background: #002AFF; height:7%; font-weight: 600;font-size: 36px; background: #333333; color: white; border-radius: 5px"><?php echo $dued . ' ' . strtoupper($duem);?></td>
                                    </tr>
                                    <tr>
                                        <?php if ($isi->INT_STATUS == 0) { 
                                                if(date('Ymd') > $isi->CHR_DUE_DATE){
                                        ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">NO FOLLOW UP</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                        <?php 
                                                } else {
                                                    if(date('His') > $isi->CHR_DUE_TIME){
                                        ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">NO FOLLOW UP</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>       
                                        <?php                                                
                                                    } else {
                                        ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">TEMP ACTION</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                        <?php
                                                    }
                                                }
                                            } else if ($isi->INT_STATUS == 1) { ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">TEMP ACTION</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                        <?php } else { ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">FIX ACTION</td>
                                        <?php } ?>                                               
                                        
                                        <td colspan="3" style="height:8%; background: gold; font-weight: 600; font-size: 30px; color: black; border-radius: 5px"><?php echo $startt; ?> WIB</td>
                                        <td colspan="3" style="height:8%; background: gold; font-weight: 600; font-size: 30px; color: black; border-radius: 5px"><?php echo $duet; ?> WIB</td>
                                    </tr>
                                </table>
                                    
                                    <?php } else { //IF BEFORE PROCESS IS PRODUCTION --> USING SINGLE PIC ?>
                                
                                <table style="width:100%; height: 100%; border-style: solid; border-spacing: 3px; 
                                       border-collapse: separate; border-color: black; background-color: black; 
                                       padding:5px;" border="1px">
                                    <tr>
                                        <td colspan="12" style="width:100%; height:5%; background: #002AFF; vertical-align: middle; font-weight: 800; font-size: 20px; border-radius: 5px;">QUALITY INFORMATION SYSTEM</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" rowspan="9" style="width:60%; background: #333333; vertical-align: middle; border-radius: 5px;"><img width="900" height="380" src="<?php echo base_url($isi->CHR_FILENAME); ?>" style="color: white; font-size:15px; font-weight: 600;" alt="NO IMAGE HAS BEEN CAPTURED"></td>
                                        <td colspan="6" style="height:5%; width:10%; background: gold; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: #333333;">DETAIL PART</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 40px; border-radius: 5px; color: gold;"><?php echo $isi->CHR_BACK_NO; ?></td>
                                        <td colspan="3" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 16px; border-radius: 5px; color: gold;"><?php echo $isi->CHR_PART_NAME; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height:5%; width:10%; background: gold; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: #333333;">PROBLEM DESC</td>
                                        <td colspan="3" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;">PIC (BP)</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 20px; border-radius: 5px; color: gold;"><?php echo $isi->CHR_QPROBLEM_TITLE; ?></td>
                                        <td colspan="3" rowspan="4" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;"><img src="<?php echo base_url('assets/file/qis_feedback/' . trim($isi->NPK_PIC) . '.jpg'); ?>" width="145px" height="170px" alt="User Image"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;">INSPECTOR</td>                                        
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;"><?php echo strtoupper($isi->CHR_REQUESTOR); ?></td>
                                        <td style="height:10%; width:10%; background: #333333; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;"><?php echo $isi->CHR_SECTION_REQ; ?></td>                                        
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height:5%; width:10%; background: #002AFF; font-weight: 600; padding-left: 8px; font-size: 18px; border-radius: 5px; color: white;">REQUESTOR</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="width:15%; background: #333333; font-weight: 600; font-size: 18px; border-radius: 5px; color: white;"><?php echo $isi->CHR_USERNAME; ?></td>
                                        <td style="width:5%; background: #333333; font-weight: 600; border-radius: 5px; color: white;"><?php echo $isi->CHR_SECTION_REQ; ?></td>
                                        <td colspan="2" style="width:15%; background: #333333; font-weight: 600; font-size: 18px; border-radius: 5px; color: white;"><?php echo substr($isi->CHR_PIC, 0, strpos($isi->CHR_PIC, ' ')); ?></td>
                                        <td style="width:5%; background: #333333; font-weight: 600; border-radius: 5px; color: white;"><?php echo $isi->CHR_SECTION_PIC; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="background: #002AFF; height:5%; font-weight: 600; font-size: 18px; border-radius: 5px;">ACCEPTED DATE</td>
                                        <td colspan="3" style="background: #002AFF; height:5%; font-weight: 600; font-size: 18px; border-radius: 5px;">DUE DATE</td>
                                    </tr>
                                    <?php
                                    $startd = date("d", strtotime($isi->CHR_START_DATE));
                                    $startm = date("M", strtotime($isi->CHR_START_DATE));
                                    $starty = date("Y", strtotime($isi->CHR_START_DATE));
                                    $startt = date("H:i", strtotime($isi->CHR_START_TIME));
                                    $dued = date("d", strtotime($isi->CHR_DUE_DATE));
                                    $duem = date("M", strtotime($isi->CHR_DUE_DATE));
                                    $duey = date("Y", strtotime($isi->CHR_DUE_DATE));
                                    $duet = date("H:i", strtotime($isi->CHR_DUE_TIME));
                                    ?>
                                    <tr>
                                        <?php if ($isi->INT_STATUS == 0) { 
                                                if(date('Ymd') > $isi->CHR_DUE_DATE){
                                        ?>
                                            <td colspan="2" rowspan="2" style="width:23%; background: red; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>
                                        <?php 
                                                } else {
                                                    if(date('His') > $isi->CHR_DUE_TIME){
                                        ?>
                                            <td colspan="2" rowspan="2" style="width:23%; background: red; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>
                                        <?php                
                                                
                                                    } else {
                                        ?>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: darkorange; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>
                                        <?php
                                            
                                                    }
                                                }
                                              } else if ($isi->INT_STATUS == 1) { ?>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: darkorange; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>

                                        <?php } else { ?>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/cross.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #333333; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/triangle.png') ?>" width='100' height='100'></td>
                                            <td colspan="2" rowspan="2" style="width:23%; background: #00EE00; font-weight: 800; border-radius: 5px"><img src="<?php echo base_url('assets/quality_assets/img/circle.png') ?>" width='100' height='100'></td>

                                        <?php } ?>
                                        <td colspan="2" rowspan="2" style="width:10%; background: #333333; color: white; font-size: 70px; border-radius: 5px"><?php echo $startd; ?></td>
                                        <td style="width:5%; font-weight: 600;font-size: 25px; background: #333333; color: white; border-radius: 5px"><?php echo strtoupper($startm); ?></td>
                                        <td colspan="2" rowspan="2" style="width:10%; background: #333333; color: white; font-size: 70px; border-radius: 5px"><?php echo $dued; ?></td>
                                        <td style="width:5%; font-weight: 600;font-size: 25px; background: #333333; color: white; border-radius: 5px"><?php echo strtoupper($duem); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #002AFF;font-weight: 600;font-size: 20px; background: #333333; color: white; border-radius: 5px"><?php echo $starty; ?></td>
                                        <td style="background: #002AFF;font-weight: 600;font-size: 20px; background: #333333; color: white; border-radius: 5px"><?php echo $duey; ?></td>
                                    </tr>
                                    <tr>
                                        <?php if ($isi->INT_STATUS == 0) { 
                                                if(date('Ymd') > $isi->CHR_DUE_DATE){
                                        ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">NO FOLLOW UP</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                        <?php 
                                                } else {
                                                    if(date('His') > $isi->CHR_DUE_TIME){
                                        ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">NO FOLLOW UP</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>       
                                        <?php                                                
                                                    } else {
                                        ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">TEMP ACTION</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                        <?php
                                                    }
                                                }
                                            } else if ($isi->INT_STATUS == 1) { ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">TEMP ACTION</td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                        <?php } else { ?>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px"></td>
                                            <td colspan="2" style="height:8%; background: #002AFF;font-weight: bolder;font-size: 25px; border-radius: 5px">FIX ACTION</td>
                                        <?php } ?>

                                        <td colspan="3" style="height:8%; background: gold; font-weight: 600; font-size: 30px; color: black; border-radius: 5px"><?php echo $startt; ?> WIB</td>
                                        <td colspan="3" style="height:8%; background: gold; font-weight: 600; font-size: 30px; color: black; border-radius: 5px"><?php echo $duet; ?> WIB</td>
                                    </tr>
                                </table>
                                
                                <?php } ?>
                                
                            </div>
                        </div>
                    <?php } ?>

                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;" border="0px">
                                <tr>
                                    <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:15%; vertical-align: middle; font-weight: 800; font-size: 20px; background: #002AFF;">QUALITY INFORMATION SYSTEM</td>
                                </tr>
                            </table>
                                <div id="data_table" class='data_table'></div>
                        </div>
                    </div>
                    
                    <?php
                        } else {
                    ?>
                        <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                            <div class="slide-caption" style="background-color: black;">
                                <table style="width: 100%; height: 100%" border="0px">
                                    <tr>
                                        <td colspan="12" style=" padding: 3px; border-style: solid; border: 1px; border-spacing: 3px; border-color: black; width:100%; height:5%; vertical-align: middle; font-weight: 800; font-size: 20px; background: #002AFF;">QUALITY INFORMATION SYSTEM</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="8" rowspan="10" valign="middle" style="height: 90%; font-size: 30px;">
                                            <marquee><strong> NO PROBLEM FOUND </strong></marquee>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div><!-- /sl-slider -->

                <!--                <nav id="nav-arrows" class="nav-arrows">
                                    <span class="nav-arrow-prev">Previous</span>
                                    <span class="nav-arrow-next">Next</span>
                                </nav>-->

                <nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
                    <a href="javascript:;" class="sl-prev" style="display:none;">
                        <i class="fa fa-angle-left fa-3x"></i>
                    </a>
                    <a href="javascript:;" class="sl-next" style="display:none;">
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

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                clickSlider();
            }, 5000);

            //$(".nav-arrow-prev").hide();
            //$(".nav-arrow-next").hide();
            var intervalClick = 1;
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('quality/quality_dashboard_c/updateAjax'); ?>",
                    dataType: 'json',
                    success: function(data) {
                        $(".data_table").html(data);
                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                    }
                });
            });
        }, 5000);

        function clickSlider() {
            setTimeout(function() {
                $(".nav-arrow-next").click();
                clickSchedule();
            }, 5000);
        }

        function clickSchedule() {
            setTimeout(function() {
                $("#img-side-menu").click();
                $(".nav-arrow-next").click();
//                window.location.reload(1);
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

    </script>
</body>
</html>