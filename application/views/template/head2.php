<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $title ?></title>
        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/highcharts.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery1.6.1.js') ?>"></script>
        <link rel="icon" href="<?php echo base_url('assets/img/url.jpeg'); ?>" >
        <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace-theme-minimal.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck/skins/square/blue.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/switchery/switchery.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2-bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-slider/css/slider.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-datatables/css/dataTables.bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-niftymodal/css/component.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-gritter/css/jquery.gritter.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/skins.css'); ?>" >
    </head>

    <body class="skin-blue">
        <!-- BEGIN HEADER -->
        <header class="header">
            <!-- BEGIN LOGO -->
            <a href="<?php echo base_url('index.php/basis/home_c'); ?>" class="logo">
                <img src="<?php echo base_url('assets/img/logo-aisin.gif'); ?>" height="35">
            </a>
            <!-- END LOGO -->
            <!-- BEGIN NAVBAR -->
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars fa-lg"></span>
                </a>

                <div class="ticker">
                    <strong>News:</strong>
                    <ul>
                        <li>Aisin Indonesia Integrated Sytem GO-Live</li>
                        <li>Rapat Umum Pemegang Saham (RUPS)</li>
                        <li>e-Ticketing System on Development</li>
                        <!--li>update dept_expense mencangkup pure_expense (+subexpense)</li>
                        <li>update authentication on url</li>
                        <li>ajax on TM</li-->
                        <?php
//                            foreach ($logs as $log) {
//                                $a=  str_split($log->CHR_TIME, 6);
//                                echo $log->CHR_TIME . $a[1];exit();
//                                echo '<li>'.  date('H:i:s', strtotime($a[1])).' '.$log->CHR_USERNAME.' '.$log->CHR_ACTION.' '.$log->CHR_OBJECT.' '.$log->CHR_CPU.'</li>';
//                            }
                        ?>
                    </ul>
                </div>

                <!-- BEGIN RIGHT ICON -->
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-lg"></i>
                                <span class="badge">4</span>
                            </a>
                            <ul class="dropdown-menu box task">
                                <li><div class="up-arrow"></div></li>
                                <li>
                                    <p>You have 4 pending tasks</p>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div class="task-desc">Documentation Project</div>
                                            <div class="task-percent">0%</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                <span class="sr-only">0% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div class="task-desc">Database Migration</div>
                                            <div class="task-percent">20%</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div class="task-desc">Master Budget</div>
                                            <div class="task-percent">70%</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                                <span class="sr-only">70% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div class="task-desc">User Management</div>
                                            <div class="task-percent">80%</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="footer">
                                    <a href="#">See all tasks</a>
                                </li>
                            </ul>
                        </li>


                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell fa-lg"></i>
                                <span class="badge">4</span>
                            </a>
                            <ul class="dropdown-menu box notification">
                                <li><div class="up-arrow"></div></li>
                                <li>
                                    <p>You have 4 new notifications</p>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-blue"></i> New user registered<span class="time pull-right">5 mins</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-database text-green"></i> Database overloaded <span class="time pull-right">20 mins</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-wrench text-yellow"></i> Application error <span class="time pull-right">1 hr</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-tasks text-red"></i> Server not responding <span class="time pull-right">5 hrs</span>
                                    </a>
                                </li>
                                <li class="footer">
                                    <a href="#">See all notifications</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown profile-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user fa-lg"></i>
                                <span class="username"></span>
                                <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu box profile">
                                <li><div class="up-arrow"></div></li>
                                <li>
                                    <p><span ></span>My Profil</p>
                                </li>
                                <li class="border-top">
                                    <?php
                                    $session = $this->session->all_userdata();
                                    $npk = $session['NPK'];
                                    ?>
                                    <a href="<?php echo base_url('index.php/basis/user_c/edit_user/' . $npk); ?>"><i class="fa fa-wrench"></i>Change Password &nbsp;<span class='badge'>!</span></a>
                                </li>
                                <li>
                                    <a href="lockscreen.html"><i class="fa fa-lock"></i>Lock Screen</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('index.php/basis/login_c/off'); ?>"><i class="fa fa-power-off"></i>Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- BEGIN RIGHT ICON -->
            </nav>
            <!-- END NAVBAR -->
        </header>
        <!-- END HEADER -->

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- BEGIN SIDEBAR -->
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url('assets/img/user/naim.jpg'); ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p class="text-left"><strong><?php
                                    echo $session['USERNAME'];
                                    ?></strong></p>

                            <?php
                            $x = NULL;
                            foreach ($app as $value) {
                                if ($x == NULL) {
                                    $x = $value->CHR_ROLE;
                                } else {
                                    break;
                                }
                            }
                            ?>
                            <p class="text-left"><?php echo $x ?></a>
                        </div>
                    </div>

                    <ul class="sidebar-menu">

                        <?php
                        $ap_stat = NULL;
                        $fun_stat = NULL;
                        $mod_stat = NULL;
                        foreach ($app as $app_data) {
                            if ($sidebar->INT_ID_APP == $app_data->INT_ID_APP) {
                                $ap_stat = 'active';
                            } else {
                                $ap_stat = 'null';
                            }
                            echo '<li class="menu ' . $ap_stat . '"><a href="#"><i class="fa fa-' . $app_data->CHR_ICON . '"></i><span>' . strtoupper(trim($app_data->CHR_APP)) . '</span><i class="fa fa-angle-left pull-right"></i></a>';
                            echo '<ul class="sub-menu">';
                            foreach ($module as $module_data) {
                                if ($app_data->INT_ID_APP == $module_data->INT_ID_APP) {
                                    if ($sidebar->INT_ID_MODULE == $module_data->INT_ID_MODULE) {
                                        $mod_stat = 'active';
                                    } else {
                                        $mod_stat = 'null';
                                    }
                                    if ($module_data->INT_LEVEL == '1') {

                                        echo '<li class="menu '.$mod_stat.'">';
                                        echo '<a href="#"><span>' . $module_data->CHR_MODULE, '</span><i class="fa fa-angle-left pull-right"></i></a>';
                                        echo '<ul class="sub-menu">';
                                        foreach ($function as $function_data) {
                                            if ($module_data->INT_ID_MODULE == $function_data->INT_ID_MODULE) {
                                                echo '<li><a href=' . base_url('/index.php/' . trim($function_data->CHR_URL) . '>' . $function_data->CHR_FUNCTION . '</a></li>');
                                            }
                                        }
                                        echo '</ul>';
                                        echo '</li>';
                                    } else {
                                        foreach ($function as $function_data) {
                                            if ($module_data->INT_ID_MODULE == $function_data->INT_ID_MODULE) {
                                                echo '<li><a href=' . base_url('index.php/' . trim($function_data->CHR_URL)) . '><span> ' . $module_data->CHR_MODULE . '</span></a></li>';
                                            }
                                        }
                                    }
                                }
                            }

                            echo '</ul>';
                            echo'</li>';
                        }
                        ?>
                        <!--                        <li class="menu active">
                                                    <a href="#">
                                                        <i class="fa fa-align-left"></i><span>Forms</span>
                                                        <i class="fa pull-right fa-angle-down"></i>
                                                    </a>
                                                    <ul style="display: block;" class="sub-menu">
                                                        <li><a href="forms-components.html">Components</a></li>
                                                        <li><a href="forms-upload.html">Multi Upload</a></li>
                                                        <li class="menu active">
                                                            <a href="#">
                                                                <span>Forms</span>
                                                                <i class="fa pull-right fa-angle-down"></i>
                                                            </a>
                                                            <ul style="display: block;" class="sub-menu">
                                                                <li><a style="margin-left: 10px;" href="forms-components.html">Components</a></li>
                                                                <li><a style="margin-left: 10px;" href="forms-masks.html">Input Masks</a></li>
                                                               <li><a style="margin-left: 10px;" href="forms-upload.html">Multi Upload</a></li>
                                                            </ul>
                                                        </li></ul>
                                                </li>-->



                    </ul>
                </section>
            </aside>
            <!-- END SIDEBAR -->

            <!-- BEGIN CONTENT -->
            <?php $this->load->view($content); ?>
            <!-- END CONTENT -->

            <!-- BEGIN SCROLL TO TOP -->
            <div class="scroll-to-top"></div>
            <!-- END SCROLL TO TOP -->
        </div>

        <!-- BEGIN JS FRAMEWORK -->
        <script src="<?php echo base_url('assets/plugins/jquery-2.1.0.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
        <!-- END JS FRAMEWORK -->

        <!-- BEGIN JS PLUGIN -->
        <script src="<?php echo base_url('assets/plugins/pace/pace.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-totemticker/jquery.totemticker.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-resize/jquery.ba-resize.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-blockui/jquery.blockUI.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/icheck/icheck.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/switchery/switchery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/select2/select2.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-slider/js/bootstrap-slider.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/form.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/jquery-datatables/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-datatables/js/dataTables.bootstrap.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/datatables.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/jquery-niftymodal/js/classie.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-niftymodal/js/modalEffects.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/jquery-gritter/js/jquery.gritter.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/notification.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/jquery-flot/jquery.flot.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-flot/jquery.flot.labels.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-flot/jquery.flot.resize.min.js') ?>"></script>


        <!-- END JS PLUGIN -->

        <!-- BEGIN JS TEMPLATE -->
        <script src="<?php echo base_url('assets/js/main.js') ?>"></script>

        <!-- END JS TEMPLATE -->
    </body>

</html>