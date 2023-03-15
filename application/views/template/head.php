<!DOCTYPE html>
<html lang="en">

    <head>
        <!--<meta charset="utf-8">-->
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $title ?></title>
        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/highcharts.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery1.6.1.js') ?>"></script>
        <script src="<?php echo base_url('assets/jquery-ui-1.10.4.custom.min.js') ?>"></script>

        <link rel="icon" href="<?php echo base_url('assets/img/loggo/logo.png'); ?>" > 
        <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace-theme-minimal.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck/skins/square/blue.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/switchery/switchery.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2-bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-slider/css/slider.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-datatables/css/dataTables.bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-niftymodal/css/component.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-gritter/css/jquery.gritter.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/skins.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" >
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.tableTools.css'); ?>">

        <style type="text/css">
            .modal-body .form-horizontal .col-sm-2,
            .modal-body .form-horizontal .col-sm-10 {
                width: 100%
            }

            .modal-body .form-horizontal .control-label {
                text-align: left;
            }
            .modal-body .form-horizontal .col-sm-offset-2 {
                margin-left: 15px;
            }

            .btn-xxl {
                padding: 18px 28px;
                font-size: 24px;
                border-radius: 8px;
                height: 150px;
                width: 100%;
                white-space: normal;
                margin-top: 25px;
            }

            .btn-xl {
                padding: 18px 28px;
                font-size: 20px;
                border-radius: 8px;
                height: 150px;
                width: 100%;
                white-space: normal;
                margin-top: 25px;
            }

            .btn-s {
                font-size: 14px;
                border-radius: 8px;
                height: 100%;
                width: 115px;
            }

            .btn-sl {
                font-size: 16px;
                border-radius: 8px;
                height: 100%;
                width: 230px;
            }

            .glyphicon.glyphicon-play-circle {
                font-size: 80px;
            }
        </style>

        <script>
            $(document).ready(function () {
                $("#hide-sub-menus").click(function () {
                    $(".sub-menu").css("display", "none");
                });

            });
        </script>

        <!-- <script src="<?php echo base_url('assets/gantt/codebase/dhtmlxgantt.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url('assets/gantt/codebase/api.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url('assets/gantt/codebase/ext/dhtmlxgantt_tooltip.js'); ?>" type="text/javascript" charset="utf-8"></script> -->
        <!--script src="<?php echo base_url('assets/gantt/codebase/ext/dhtmlxgantt_quick_info.js'); ?>" type="text/javascript" charset="utf-8"></script-->
        <!-- <link rel="stylesheet" href="<?php echo base_url('assets/gantt/codebase/dhtmlxgantt.css'); ?>" type="text/css" media="screen" title="no title" charset="utf-8">
        <script type="text/javascript" src="<?php echo base_url('assets/gantt/common/testdata.js'); ?>"></script> -->
        <link href="<?php echo base_url('assets/css/fileinput.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/jquery-2.1.1.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/canvas-to-blob.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/fileinput.min.js'); ?>"></script>

    </head>

    <body class="skin-blue">
        <?php
        $news = array();//$this->news_m->get_news();
        $notification = array();//$this->notification_m->get_notification($this->session->userdata("NPK"));
        $notification_total = array();//$this->notification_m->get_notification_total($this->session->userdata("NPK"));
        $notification_budget = $this->notification_m->get_notification_budget($this->session->userdata("NPK"));
        $notification_budget_total = $this->notification_m->get_notification_budget_total($this->session->userdata("NPK"));
        $notification_aorta = $this->notification_m->get_notification_aorta($this->session->userdata("NPK"));
        $notification_aorta_total = $this->notification_m->get_notification_aorta_total($this->session->userdata("NPK"));
        ?>
        <!-- BEGIN HEADER -->
        <header class="header">
            <!-- BEGIN LOGO -->
            <a href="<?php echo base_url('index.php/basis/home_c'); ?>" class="logo">
                <img src="<?php echo base_url('assets/img/loggo/aisin-loggo.svg'); ?>" >
            </a>
            <!-- END LOGO -->
            <!-- BEGIN NAVBAR -->
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" id="hide-sub-menus" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars fa-lg"></span>
                </a>

                <div class="ticker">
                    <strong>News & Event :</strong>
                    <ul>
                        <?php foreach ($news as $new): ?>
                            <li><a href='<?php echo base_url('index.php/portal/news_c/detil/' . $new->INT_ID_NEWS); ?>' style="color:white;"><?php echo $new->CHR_NEWS_TITLE; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- BEGIN RIGHT ICON -->
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!--li class="dropdown navbar-menu">
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
                        </li-->

                        <!-- NOTIFICATION AORTA-->
                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-clock-o fa-lg"></i>
                                <span class="badge"><?php
                                                    if (!empty($notification_aorta_total)) {
                                                        echo $notification_aorta_total[0]->TOTAL;
                                                    }
                                                    ?></span>
                            </a>
                            <ul class="dropdown-menu box notification">
                                <li>
                                    <div class="up-arrow"></div>
                                </li>
                                <li>
                                    <p>You have <?php
                                                if (!empty($notification_aorta_total)) {
                                                    echo $notification_aorta_total[0]->TOTAL;
                                                }
                                                ?> new notifications</p>
                                </li>

                                <?php
                                if (!empty($notification_aorta)) {
                                    foreach ($notification_aorta as $notif) :
                                ?>
                                        <li>
                                            <a href="<?php echo base_url('index.php/basis/home_c/update_notif/' . $notif->INT_ID_NOTIF) ?>" data-placement="left" data-toggle="tooltip" title="<?php echo $notif->CHR_NOTIF_DESC; ?>">
                                                <i class="fa fa-<?php echo $notif->CHR_ICON; ?>  text-blue"></i> <?php echo substr($notif->CHR_NOTIF_TITLE, 0, 20) . '....'; ?>
                                                <span class="time pull-right">5 mins</span>
                                            </a>
                                        </li>
                                <?php
                                    endforeach;
                                }
                                ?>

                                <li class="footer">
                                    <a href="#">See all notifications</a>
                                </li>
                            </ul>
                        </li>
                        <!-- END NOTIFICATION AORTA -->

                        <!-- NOTIFICATION BUDGET-->
                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-usd fa-lg"></i>
                                <span class="badge"><?php
                                    if (!empty($notification_budget_total)) {
                                        echo $notification_budget_total[0]->TOTAL;
                                    }
                                    ?></span>
                            </a>
                            <ul class="dropdown-menu box notification">
                                <li><div class="up-arrow"></div></li>
                                <li>
                                    <p>You have <?php
                                        if (!empty($notification_budget_total)) {
                                            echo $notification_budget_total[0]->TOTAL;
                                        }
                                        ?> new notifications</p>
                                </li>

                                <?php
                                if (!empty($notification_budget)) {
                                    foreach ($notification_budget as $notif):
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url('index.php/basis/home_c/update_notif/' . $notif->INT_ID_NOTIF) ?>" data-placement="left" data-toggle="tooltip" title="<?php echo $notif->CHR_NOTIF_DESC; ?>">
                                                <i class="fa fa-<?php echo $notif->CHR_ICON; ?>  text-blue"></i> <?php echo substr($notif->CHR_NOTIF_TITLE, 0, 20) . '....'; ?>
                                                <span class="time pull-right">5 mins</span>
                                            </a>
                                        </li>
                                        <?php
                                    endforeach;
                                }
                                ?>

                                <li class="footer">
                                    <a href="#">See all notifications</a>
                                </li>
                            </ul>
                        </li>
                        <!-- END NOTIFICATION BUDGET -->

                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell fa-lg"></i>
                                <span class="badge"><?php
                                    if (!empty($notification_total)) {
                                        echo $notification_total[0]->TOTAL;
                                    }
                                    ?></span>
                            </a>
                            <ul class="dropdown-menu box notification">
                                <li><div class="up-arrow"></div></li>
                                <li>
                                    <p>You have <?php
                                        if (!empty($notification_total)) {
                                            echo $notification_total[0]->TOTAL;
                                        }
                                        ?> new notifications</p>
                                </li>

                                <?php
                                if (!empty($notification)) {
                                    foreach ($notification as $notification_l):
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url('index.php/basis/home_c/update_notif/' . $notification_l->INT_ID_NOTIF) ?>" data-placement="left" data-toggle="tooltip" title="<?php echo $notification_l->CHR_NOTIF_DESC; ?>">
                                                <i class="fa fa-<?php echo $notification_l->CHR_ICON; ?>  text-blue"></i> <?php echo substr($notification_l->CHR_NOTIF_TITLE, 0, 20) . '....'; ?>
                                                <span class="time pull-right">5 mins</span>
                                            </a>
                                        </li>
                                        <?php
                                    endforeach;
                                }
                                ?>

                                <li class="footer">
                                    <a href="#">See all notifications</a>
                                </li>
                            </ul>
                        </li>

                        <li></li>
                        <li></li>

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
                                    <a href="lockscreen.html"><i class="fa fa-user"></i>Profil</a>
                                </li>
                                <li >
                                    <?php
                                    $session = $this->session->all_userdata();
                                    $npk = $session['NPK'];
                                    $expired = $session['CHR_EXP_DATE'];
                                    ?>
                                    <a href="<?php echo base_url('index.php/basis/user_c/pre_change_password_user/' . $npk); ?>"><i class="fa fa-wrench"></i>Change Password &nbsp;
                                        <?php if ($expired <= date('Ymd', strtotime(date('Ymd') . ' + 7 days'))) { ?>
                                            <span class='badge'>!</span>
                                        <?php } else { ?>
                                            <span class='badge'></span>
                                        <?php } ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="lockscreen.html"><i class="fa fa-lock"></i>Lock Screen</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('index.php/login_c/off'); ?>"><i class="fa fa-power-off"></i>Log Out</a>
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
                    <div class="user-panel" >
                        <div class="pull-left image">
                            <?php
                            $filename = './assets/img/user/' . $npk . '.jpg';
                            if (file_exists($filename)) {
                                ?><img src="<?php echo base_url('assets/img/user/' . $npk . '.jpg'); ?>" class="img-circle" alt="User Image">'<?php
                            } else {
                                ?><img src="<?php echo base_url('assets/img/user/unknown.jpg'); ?>" class="img-circle" alt="User Image">'<?php
                            }
                            ?>
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
                            <p class="text-left"><?php echo $session['NPK'] ?></a>
                        </div>
                    </div>
                    <!--#001599-->
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

                            $total_notification_app = $this->notification_m->get_notification_total_by_npk_and_app($this->session->userdata("NPK"), $app_data->INT_ID_APP);
                                                      
                            if($total_notification_app){
                                echo '<li class="menu ' . $ap_stat . '"><a href="#"><i class="fa fa-' . $app_data->CHR_ICON . '"></i><span>' . strtoupper(trim($app_data->CHR_APP)) . '</span><small class="badge pull-right" style="background:crimson;">'.$total_notification_app.'</small></a>';
                            }else{
                                if($app_data->INT_ID_APP == 44){
                                    if($session['NPK'] == 'Loop3r' || $session['NPK']== '1905' || $session['NPK']== '0040' || $session['NPK']== '0483'){
                                        echo '<li class="menu ' . $ap_stat . '"><a href="#"><i class="fa fa-' . $app_data->CHR_ICON . '"></i><span>' . strtoupper(trim($app_data->CHR_APP)) . '</span><i class="fa fa-angle-left pull-right"></i></a>';
                                    }else{
                                        
                                    }
                                }else{
                                    echo '<li class="menu ' . $ap_stat . '"><a href="#"><i class="fa fa-' . $app_data->CHR_ICON . '"></i><span>' . strtoupper(trim($app_data->CHR_APP)) . '</span><i class="fa fa-angle-left pull-right"></i></a>';
                                }
                            }
                            

                            echo '<ul class="sub-menu">';
                            foreach ($module as $module_data) {
                                if ($app_data->INT_ID_APP == $module_data->INT_ID_APP) {
                                    if ($sidebar->INT_ID_MODULE == $module_data->INT_ID_MODULE) {
                                        $mod_stat = 'active';
                                    } else {
                                        $mod_stat = 'null';
                                    }
                                    if ($module_data->INT_LEVEL == '1') {

                                        echo '<li class="menu ' . $mod_stat . '">';

                                        $total_notification_modul = $this->notification_m->get_notification_total_by_npk_and_module($this->session->userdata("NPK"), $module_data->INT_ID_MODULE);
                                        if($total_notification_modul){
                                            echo '<a href="#"><span>' . $module_data->CHR_MODULE, '</span><small class="badge pull-right" style="background:crimson;">'.$total_notification_modul.'</small></a>';
                                        }else{
                                            echo '<a href="#"><span>' . $module_data->CHR_MODULE, '</span><i class="fa fa-angle-left pull-right"></i></a>';
                                        }

                                        echo '<ul class="sub-menu">';
                                        foreach ($function as $function_data) {

                                            if ($module_data->INT_ID_MODULE == $function_data->INT_ID_MODULE) {
                                                if ($sidebar->INT_ID_FUNCTION == $function_data->INT_ID_FUNCTION) {
                                                    $fun_stat = ' style="border-left:1px solid #eeeeee; color:white"';
                                                    $fun_ac = 'style="color:white"';
                                                } else {
                                                    $fun_stat = null;
                                                    $fun_ac = null;
                                                }

                                                $total_notification_function = $this->notification_m->get_notification_total_by_npk_and_function($this->session->userdata("NPK"), $function_data->INT_ID_FUNCTION);
                                                if($total_notification_function){
                                                    if ($function_data->INT_ID_FUNCTION == 204 || $function_data->INT_ID_FUNCTION == 223 ||  $function_data->INT_ID_FUNCTION == 90 || $function_data->INT_ID_FUNCTION == 300 || $function_data->INT_ID_FUNCTION == 301 || $function_data->INT_ID_FUNCTION == 103 || $function_data->INT_ID_FUNCTION == 320 ||  $function_data->INT_ID_FUNCTION == 322 || $function_data->INT_ID_FUNCTION == 324 || $function_data->INT_ID_FUNCTION == 332 || $function_data->INT_ID_FUNCTION == 343 || $function_data->INT_ID_FUNCTION == 374 || $function_data->INT_ID_FUNCTION == 375 || $function_data->INT_ID_FUNCTION == 376) {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . trim($function_data->CHR_URL) . '>' . $function_data->CHR_FUNCTION . '</a></li>';
                                                    } else if($function_data->INT_ID_FUNCTION == 260 || $function_data->INT_ID_FUNCTION == 286 || $function_data->INT_ID_FUNCTION == 150){
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . base_url('/index.php/' . trim($function_data->CHR_URL)) . '>' . $function_data->CHR_FUNCTION . '</a></li>';
                                                    } else {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . ' href=' . base_url('/index.php/' . trim($function_data->CHR_URL)) . '>' . $function_data->CHR_FUNCTION . '<small class="badge pull-right" style="background:crimson;">'.$total_notification_function.'</small></a></li>';
                                                    }
                                                }else{
                                                    if ($function_data->INT_ID_FUNCTION == 204 || $function_data->INT_ID_FUNCTION == 223 ||  $function_data->INT_ID_FUNCTION == 90 || $function_data->INT_ID_FUNCTION == 300 || $function_data->INT_ID_FUNCTION == 301 || $function_data->INT_ID_FUNCTION == 103 || $function_data->INT_ID_FUNCTION == 320 ||  $function_data->INT_ID_FUNCTION == 322 || $function_data->INT_ID_FUNCTION == 324 || $function_data->INT_ID_FUNCTION == 332 || $function_data->INT_ID_FUNCTION == 343 || $function_data->INT_ID_FUNCTION == 374 || $function_data->INT_ID_FUNCTION == 375 || $function_data->INT_ID_FUNCTION == 376) {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . trim($function_data->CHR_URL) . '>' . $function_data->CHR_FUNCTION . '</a></li>';
                                                    } else if($function_data->INT_ID_FUNCTION == 260 || $function_data->INT_ID_FUNCTION == 286 || $function_data->INT_ID_FUNCTION == 150){
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . base_url('/index.php/' . trim($function_data->CHR_URL)) . '>' . $function_data->CHR_FUNCTION . '</a></li>';
                                                    } else {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . ' href=' . base_url('/index.php/' . trim($function_data->CHR_URL)) . '>' . $function_data->CHR_FUNCTION . '</a></li>';
                                                    }
                                                }
                                                
                                            }
                                        }
                                        echo '</ul>';
                                        echo '</li>';
                                    } else {
                                        foreach ($function as $function_data) {
                                            if ($module_data->INT_ID_MODULE == $function_data->INT_ID_MODULE) {
                                                if ($sidebar->INT_ID_FUNCTION == $function_data->INT_ID_FUNCTION) {
                                                    $fun_stat = ' style="border-left:1px solid #eeeeee; color:white"';
                                                    $fun_ac = 'style="color:white"';
                                                } else {
                                                    $fun_stat = null;
                                                    $fun_ac = null;
                                                }

                                                $total_notification_function = $this->notification_m->get_notification_total_by_npk_and_function($this->session->userdata("NPK"), $function_data->INT_ID_FUNCTION);
                                                if($total_notification_function){

                                                    if ($function_data->INT_ID_FUNCTION == 204 || $function_data->INT_ID_FUNCTION == 223 ||  $function_data->INT_ID_FUNCTION == 67 || $function_data->INT_ID_FUNCTION == 90 || $function_data->INT_ID_FUNCTION == 300 || $function_data->INT_ID_FUNCTION == 301 || $function_data->INT_ID_FUNCTION == 103 || $function_data->INT_ID_FUNCTION == 320 ||  $function_data->INT_ID_FUNCTION == 322 || $function_data->INT_ID_FUNCTION == 324 || $function_data->INT_ID_FUNCTION == 332 || $function_data->INT_ID_FUNCTION == 343 || $function_data->INT_ID_FUNCTION == 374 || $function_data->INT_ID_FUNCTION == 375 || $function_data->INT_ID_FUNCTION == 376) {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . trim($function_data->CHR_URL) . '><span> ' . $module_data->CHR_MODULE . '</span></a></li>';
                                                    } else if($function_data->INT_ID_FUNCTION == 260 || $function_data->INT_ID_FUNCTION == 286){
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . base_url('index.php/' . trim($function_data->CHR_URL)) . '><span> ' . $module_data->CHR_MODULE . '</span></a></li>';
                                                    } else {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . ' href=' . base_url('index.php/' . trim($function_data->CHR_URL)) . '><span> ' . $module_data->CHR_MODULE . '</span><small class="badge pull-right" style="background:crimson;">'.$total_notification_function.'</small></a></li>';
                                                    }

                                                }else{
                                                    if ($function_data->INT_ID_FUNCTION == 204 || $function_data->INT_ID_FUNCTION == 223 ||  $function_data->INT_ID_FUNCTION == 67 || $function_data->INT_ID_FUNCTION == 90 || $function_data->INT_ID_FUNCTION == 300 || $function_data->INT_ID_FUNCTION == 301 || $function_data->INT_ID_FUNCTION == 103 || $function_data->INT_ID_FUNCTION == 320 ||  $function_data->INT_ID_FUNCTION == 322 || $function_data->INT_ID_FUNCTION == 324 || $function_data->INT_ID_FUNCTION == 332 || $function_data->INT_ID_FUNCTION == 343 || $function_data->INT_ID_FUNCTION == 374 || $function_data->INT_ID_FUNCTION == 375 || $function_data->INT_ID_FUNCTION == 376) {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . trim($function_data->CHR_URL) . '><span> ' . $module_data->CHR_MODULE . '</span></a></li>';
                                                    } else if($function_data->INT_ID_FUNCTION == 260 || $function_data->INT_ID_FUNCTION == 286){
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . 'target="_blank"' . ' href=' . base_url('index.php/' . trim($function_data->CHR_URL)) . '><span> ' . $module_data->CHR_MODULE . '</span></a></li>';
                                                    } else {
                                                        echo '<li' . $fun_stat . '><a ' . $fun_ac . ' href=' . base_url('index.php/' . trim($function_data->CHR_URL)) . '><span> ' . $module_data->CHR_MODULE . '</span></a></li>';
                                                    }
                                                }

                                                
                                            }
                                        }
                                    }
                                }
                            }

                            echo '</ul>';
                            echo'</li>';
                        }
                        ?></ul>
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
        <!--<script src="<?php echo base_url('assets/plugins/jquery-2.1.0.min.js') ?>"></script>-->
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
        <!-- END JS FRAMEWORK -->

        <!-- BEGIN JS PLUGIN -->
        <script src="<?php echo base_url('assets/plugins/pace/pace.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-totemticker/jquery.totemticker.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-resize/jquery.ba-resize.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-blockui/jquery.blockUI.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/icheck/icheck.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/switchery/switchery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/form.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/select2/select2.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-slider/js/bootstrap-slider.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/jquery-datatables/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-datatables/js/dataTables.bootstrap.js') ?>"></script>

        <script src="<?php echo base_url('assets/js/datatables.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/dataTables.tableTools.js'); ?>"></script>


        <script src="<?php echo base_url('assets/plugins/jquery-niftymodal/js/classie.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-niftymodal/js/modalEffects.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/jquery-gritter/js/jquery.gritter.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/notification.js') ?>"></script>

        <script src="<?php echo base_url('assets/plugins/jquery-flot/jquery.flot.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-flot/jquery.flot.labels.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-flot/jquery.flot.resize.min.js') ?>"></script>

        <script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>


        <!-- END JS PLUGIN -->

        <!-- BEGIN JS TEMPLATE -->
        <script src="<?php echo base_url('assets/js/main.js') ?>"></script>

        <script src="<?php echo base_url('assets/js/skycons.js') ?>"></script>


        <script>
            var icons = new Skycons({"color": "white"}),
                    list = [
                        "clear-day", "clear-night", "partly-cloudy-day",
                        "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                        "fog"
                    ],
                    i;

            for (i = list.length; i--; )
                icons.set(list[i], list[i]);

            icons.play();
        </script>

        <script>

            /* INLINE DATETIME */
            function initDatetime() {
                $('#datetimepicker').datetimepicker({
                    startView: 2,
                    minView: 2
                });
            }

            $(function () {
                $("#datepicker").datepicker({dateFormat: 'mm/dd/yy'});
            });
            $(function () {
                $("#datepicker1").datepicker({dateFormat: 'mm/dd/yy'});
            });
            $(function () {
                $("#datepicker2").datepicker({dateFormat: 'mm/dd/yy'});
            });
            $(function () {
                $("#datepicker3").datepicker({dateFormat: 'mm/dd/yy'});
            });
            $(function () {
                $("#datepicker4").datepicker({dateFormat: 'mm/dd/yy'});
            });

        </script>

<!--        <script type="text/javascript" language="javascript" class="init">
            $.fn.dataTable.TableTools.defaults.aButtons = ["copy", "csv", "xls", "pdf"];
            $(document).ready(function () {
                $('#example').DataTable({
                    dom: 'T<"clear">lfrtip',
                    tableTools: {
                        "sSwfPath": "<?php echo base_url('assets/swf/copy_csv_xls_pdf.swf'); ?>"
                    }

                });
            });
        </script>-->

        <!-- END JS TEMPLATE -->

    </body>

</html>