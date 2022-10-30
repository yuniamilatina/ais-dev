
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

                    <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                        <div class="slide-caption">
                            <table style="width:100%;height: 100%;border-style: solid; border-spacing: 3px; 
                                   border-collapse: separate;border-color: black; background-color: black; color:white;
                                   padding:5px;" border="1px">
                                <tr style="height:5%;background: green;text-align:center;">
                                    <th colspan="5" style="text-align:center;">JUDUL</th>
                                </tr>
                                <tr style="height:5%;background: green;">
                                    <td style="width:20%;">ABSENSI</td>
                                    <td style="width:20%;">INFORMATION</td>
                                    <td style="width:20%;">CONTROL ECI</td>
                                    <td style="width:20%;">PLANNING</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="height:5%;background: green;">
                                    <td style="width:20%;">ABSENSI</td>
                                    <td style="width:20%;">INFORMATION</td>
                                    <td style="width:20%;">CONTROL ECI</td>
                                    <td style="width:20%;">PLANNING</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="height:5%;background: green;">
                                    <td style="width:20%;">ABSENSI</td>
                                    <td style="width:20%;">INFORMATION</td>
                                    <td style="width:20%;">CONTROL ECI</td>
                                    <td style="width:20%;">PLANNING</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="height:5%;background: green;">
                                    <td style="width:20%;">ABSENSI</td>
                                    <td style="width:20%;">INFORMATION</td>
                                    <td style="width:20%;">CONTROL ECI</td>
                                    <td style="width:20%;">PLANNING</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;" border="0px"><tr>
                                    <td colspan="12" style="width:100%;height:5%;vertical-align: middle;font-weight: 800;border-radius: 10px;font-size:18px;">HENKANTEN MANAJEMEN METHOD Versi 1.0 (TRIAL)</td>
                                </tr>
                            </table>
                            <div id="data_table" class='data_table'>
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead>
                                        <tr style='height:50px;background:#18181E;'>
                                            <td style='text-align: center;'>No</th>
                                            <td style='text-align: center;'>Work Center</th>
                                            <td style='text-align: center;'>Process No</th>
                                            <td style='text-align: center;'>Part No</th>
                                            <td style='text-align: center;'>Part Name</th>
                                            <td style='text-align: center;'>Detail</th>
                                            <td style='text-align: center;'>Plan Date</th>
                                            <td style='text-align: center;'>Plan Time</th>
                                            <td style='text-align: center;'>Actual Date</th>
                                            <td style='text-align: center;'>Actual Time</th>
                                            <td style='text-align: center;'>Corrective Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data_henkaten_method as $isi) {
                                            $starttime = date("H:i", strtotime($isi->CHR_SCHEDULE_TIME));
                                            $duetime = date("H:i", strtotime($isi->CHR_ACT_TIME));
                                            $startdate = date("d-m-Y", strtotime($isi->CHR_SCHEDULE_DATE));
                                            $duedate = date("d-m-Y", strtotime($isi->CHR_ACT_DATE));
                                            echo "<tr>";
                                            echo "<td>$i</td>";
                                            echo "<td>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td>$isi->CHR_PROCESS_NO</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_PART_NO</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_PART_NAME</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_DETAIL</td>";
                                            echo "<td>$startdate</td>";
                                            echo "<td>$starttime</td>";
                                            echo "<td>$duedate</td>";
                                            echo "<td>$duetime</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_CORRECT_ACTION</td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                        ?>
                                    <tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;" border="0px"><tr>
                                    <td colspan="12" style="width:100%;height:5%;vertical-align: middle;font-weight: 800;border-radius: 10px;font-size:18px;">HENKANTEN MANAJEMEN MACHINE Versi 1.0 (TRIAL)</td>
                                </tr>
                            </table>
                            <div id="data_table" class='data_table'>
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead>
                                        <tr style='height:50px;background:#18181E;'>
                                            <td style='text-align: center;'>No</th>
                                            <td style='text-align: center;'>Work Center</th>
                                            <td style='text-align: center;'>Process No</th>
                                            <td style='text-align: center;'>Part No</th>
                                            <td style='text-align: center;'>Part Name</th>
                                            <td style='text-align: center;'>Detail</th>
                                            <td style='text-align: center;'>Plan Date</th>
                                            <td style='text-align: center;'>Plan Time</th>
                                            <td style='text-align: center;'>Actual Date</th>
                                            <td style='text-align: center;'>Actual Time</th>
                                            <td style='text-align: center;'>Corrective Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data_henkaten_machine as $isi) {
                                            $starttime = date("H:i", strtotime($isi->CHR_SCHEDULE_TIME));
                                            $duetime = date("H:i", strtotime($isi->CHR_ACT_TIME));
                                            $startdate = date("d-m-Y", strtotime($isi->CHR_SCHEDULE_DATE));
                                            $duedate = date("d-m-Y", strtotime($isi->CHR_ACT_DATE));
                                            echo "<tr>";
                                            echo "<td>$i</td>";
                                            echo "<td>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td>$isi->INT_TYPE</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_PART_NO</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_PART_NAME</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_DETAIL</td>";
                                            echo "<td>$startdate</td>";
                                            echo "<td>$starttime</td>";
                                            echo "<td>$duedate</td>";
                                            echo "<td>$duetime</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_CORRECT_ACTION</td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                        ?>
                                    <tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;" border="0px"><tr>
                                    <td colspan="12" style="width:100%;height:5%;vertical-align: middle;font-weight: 800;border-radius: 10px;font-size:18px;">HENKANTEN MANAJEMEN MATERIAL Versi 1.0 (TRIAL)</td>
                                </tr>
                            </table>
                            <div id="data_table" class='data_table'>
                                <table style='width:100%;font-weight:600;padding:10px;' border='0px'>
                                    <thead>
                                        <tr style='height:50px;background:#18181E;'>
                                            <td style='text-align: center;'>No</th>
                                            <td style='text-align: center;'>Work Center</th>
                                            <td style='text-align: center;'>Classification</th>
                                            <td style='text-align: center;'>Process No</th>
                                            <td style='text-align: center;'>Part No</th>
                                            <td style='text-align: center;'>Part Name</th>
                                            <td style='text-align: center;'>Detail</th>
                                            <td style='text-align: center;'>Plan Date</th>
                                            <td style='text-align: center;'>Plan Time</th>
                                            <td style='text-align: center;'>Actual Date</th>
                                            <td style='text-align: center;'>Actual Time</th>
                                            <td style='text-align: center;'>Corrective Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data_henkaten_material as $isi) {
                                            $starttime = date("H:i", strtotime($isi->CHR_SCHEDULE_TIME));
                                            $duetime = date("H:i", strtotime($isi->CHR_ACT_TIME));
                                            $startdate = date("d-m-Y", strtotime($isi->CHR_SCHEDULE_DATE));
                                            $duedate = date("d-m-Y", strtotime($isi->CHR_ACT_DATE));
                                            echo "<tr>";
                                            echo "<td>$i</td>";
                                            echo "<td>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td>$isi->INT_CLASSIFICATION</td>";
                                            echo "<td>$isi->CHR_PROCESS_NO</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_PART_NO</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_PART_NAME</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_DETAIL</td>";
                                            echo "<td>$startdate</td>";
                                            echo "<td>$starttime</td>";
                                            echo "<td>$duedate</td>";
                                            echo "<td>$duetime</td>";
                                            echo "<td style='text-align: left;'>$isi->CHR_CORRECT_ACTION</td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                        ?>
                                    <tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                        <div class="slide-caption" style="background-color: #18181E;">
                            <table style="width:100%;" border="0px"><tr>
                                    <td colspan="12" style="width:100%;height:5%;vertical-align: middle;font-weight: 800;border-radius: 10px;font-size:18px;">QUALITY INFORMATION SYSTEM Versi 1.0 (TRIAL)</td>
                                </tr>
                            </table>
                            <div id="data_table" class='data_table'>

                            </div>

                        </div>
                    </div>

                </div><!-- /sl-slider -->

                <!--                <nav id="nav-arrows" class="nav-arrows">
                                    <span class="nav-arrow-prev">Previous</span>
                                    <span class="nav-arrow-next">Next</span>
                                </nav>-->

                <nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
                    <a href="javascript:;" class="sl-prev">
                        <i class="fa fa-angle-left fa-3x"></i>
                    </a>
                    <a href="javascript:;" class="sl-next">
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
//            setTimeout(function() {
//                clickSlider();
//            }, 10000);

            //$(".nav-arrow-prev").hide();
            //$(".nav-arrow-next").hide();
            var intervalClick = 1;
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('henkaten/henkaten_method_c/updateAjax'); ?>",
                    dataType: 'json',
                    success: function(data) {
                        $(".data_table").html(data);
                    }//,
//                    error: function(request, status, error) {
//                        alert(request.responseText);
//                    }
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