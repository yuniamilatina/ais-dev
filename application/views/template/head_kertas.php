<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from vergo-kertas.herokuapp.com/forms-components.html by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 16 Sep 2014 01:38:00 GMT -->
    <head>
        <meta charset="utf-8">
        <!--[if IE]>
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Kertas &ndash; Form Components</title>

        <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" >

        <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" >

        <!-- BEGIN CSS FRAMEWORK -->
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" >
        <!-- END CSS FRAMEWORK -->

        <!-- BEGIN CSS PLUGIN -->
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


        <!-- END CSS PLUGIN -->

        <!-- BEGIN CSS TEMPLATE -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/skins.css'); ?>" >
        <!-- END CSS TEMPLATE -->
    </head>

    <body class="skin-silver pace-done skin-blue">
        <!-- BEGIN HEADER -->
        <header class="header">
            <!-- BEGIN LOGO -->
            <a href="index-2.html" class="logo">
                <img src="assets/img/logo.png" alt="Kertas" height="20">
            </a>
            <!-- END LOGO -->
            <!-- BEGIN NAVBAR -->
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars fa-lg"></span>
                </a>

                <!-- BEGIN NEWS TICKER -->
                <div class="ticker">
                    <strong>News:</strong>
                    <ul>
                        <li>Apliaksi TA 10%</li>
                        <li>Dokumentasi TA 0%</li>
                        <li>User Management 70%</li>
                        <li>Master Budget 0%</li>                        
                        <li>Master Komponen Budget 0%</li>
                        <li>Role Module 70%</li>
                    </ul>
                </div>
                <!-- END NEWS TICKER -->

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
                                            <div class="task-percent">10%</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                                                <span class="sr-only">10% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div class="task-desc">Master Budget</div>
                                            <div class="task-percent">5%</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%">
                                                <span class="sr-only">5% Complete</span>
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
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
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
                                <i class="fa fa-th-large fa-lg"></i>
                                <span class="badge">2</span>
                            </a>
                            <ul class="dropdown-menu box inbox">
                                <li><div class="up-arrow"></div></li>
                                <li>
                                    <p>Single Sign On</p>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="photo"><img src="assets/img/user/avatar02.png" alt="User Image"></span>
                                        <span class="subject">
                                            <span class="from">ASMAN</span>
                                        </span>
                                    </a>
                                    <a href="#">
                                        <span class="photo"><img src="assets/img/user/avatar02.png" alt="User Image"></span>
                                        <span class="subject">
                                            <span class="from">EVITA</span>
                                        </span>
                                    </a>
                                </li>

                                <li class="footer">
                                    <a href="#">More</a>
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
                                    <p>My Profil</p>
                                </li>
                                <li class="border-top">
                                    <a href="pages-user.html"><i class="fa fa-wrench"></i>Change Password &nbsp;<span class='badge'>!</span></a>
                                </li>
                                <li>
                                    <a href="lockscreen.html"><i class="fa fa-lock"></i>Lock Screen</a>
                                </li>
                                <li>
                                    <a href="login.html"><i class="fa fa-power-off"></i>Log Out</a>
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
                            <img src="assets/img/user/avatar01.png" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>Jeffrey <strong>Williams</strong></p>
                            <a href="#"><i class="fa fa-circle text-green"></i> Online</a>
                        </div>
                    </div>
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <ul class="sidebar-menu">
                        <li>
                            <a href="index-2.html">
                                <i class="fa fa-home"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="menu">
                            <a href="#">
                                <i class="fa fa-laptop"></i><span>UI Elements</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="ui-general.html">General</a></li>
                                <li><a href="ui-buttons.html">Buttons</a></li>							
                                <li><a href="ui-grid.html">Grid</a></li>
                                <li><a href="ui-group-list.html">Group List</a></li>
                                <li><a href="ui-icons.html">Icons</a></li>
                                <li><a href="ui-messages.html">Messages & Notifications</a></li>
                                <li><a href="ui-modals.html">Modals</a></li>
                                <li><a href="ui-tabs.html">Tabs & Accordions</a></li>
                                <li><a href="ui-typography.html">Typography</a></li>
                            </ul>
                        </li>
                        <li class="menu active">
                            <a href="#">
                                <i class="fa fa-align-left"></i><span>Forms</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="forms-components.html">Components</a></li>
                                <li><a href="forms-masks.html">Input Masks</a></li>
                                <li><a href="forms-validation.html">Validation</a></li>
                                <li><a href="forms-wizard.html">Wizard</a></li>
                                <li><a href="forms-wysiwyg.html">WYSIWYG Editor</a></li>
                                <li><a href="forms-upload.html">Multi Upload</a></li>
                            </ul>
                        </li>
                        <li class="menu">
                            <a href="#">
                                <i class="fa fa-table"></i><span>Tables</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="tables-basic.html">Basic Tables</a></li>
                                <li><a href="tables-datatables.html">Data Tables</a></li>
                            </ul>
                        </li>
                        <li class="menu">
                            <a href="#">
                                <i class="fa fa-map-marker"></i><span>Maps</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="maps-google.html">Google Map</a></li>
                                <li><a href="maps-vector.html">Vector Map</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="charts.html">
                                <i class="fa fa-bar-chart-o"></i><span>Charts</span>
                            </a>
                        </li>
                        <li class="menu">
                            <a href="#">
                                <i class="fa fa-archive"></i><span>Pages</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="404.html">404 Page</a></li>
                                <li><a href="500.html">500 Page</a></li>
                                <li><a href="pages-blank.html">Blank Page</a></li>
                                <li><a href="pages-blank-header.html">Blank Page Header</a></li>
                                <li><a href="pages-calendar.html">Calendar</a></li>
                                <li><a href="pages-code.html">Code Editor</a></li>
                                <li><a href="pages-gallery.html">Gallery</a></li>
                                <li><a href="pages-invoice.html">Invoice</a></li>
                                <li><a href="lockscreen.html">Lock Screen</a></li>
                                <li><a href="login.html">Login</a></li>
                                <li><a href="register.html">Register</a></li>
                                <li><a href="pages-search.html">Search Result</a></li>
                                <li><a href="pages-support.html">Support Ticket</a></li>
                                <li><a href="pages-timeline.html">Timeline</a></li>
                                <li><a href="pages-user.html">User Profile</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="email.html">
                                <i class="fa fa-envelope"></i><span>Email</span><small class="badge pull-right bg-blue">12</small>
                            </a>
                        </li>
                        <li>
                            <a href="frontend/index.html">
                                <i class="fa fa-flag"></i><span>Frontend</span>
                            </a>
                        </li>
                        <li class="menu">
                            <a href="#">
                                <i class="fa fa-folder-open"></i><span>Menu Levels</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="#">Level 1</a></li>
                                <li class="menu">
                                    <a href="#">
                                        <span>Level 2</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="#">Sub Menu</a></li>
                                        <li><a href="#">Sub Menu</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </section>
            </aside>
            <!-- END SIDEBAR -->

            <!-- BEGIN CONTENT -->
            <aside class="right-side">
                <!-- BEGIN CONTENT HEADER -->
                <section class="content-header">
                    <i class="fa fa-align-left"></i>
                    <span>Form Components</span>
                    <ol class="breadcrumb">
                        <li><a href="index-2.html">Forms</a></li>
                        <li><a href="#">Pages</a></li>
                        <li class="active">Components</li>
                    </ol>
                </section>
                <!-- END CONTENT HEADER -->

                <!-- BEGIN MAIN CONTENT -->
                <section class="content">

                    <div class="row">
                        <!-- BEGIN BASIC ELEMENTS -->
                        <div class="col-md-12">
                            <div class="grid">
                                <div class="grid-header">
                                    <i class="fa fa-align-left"></i>
                                    <span class="grid-title">Basic Elements</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <form class="form-horizontal" >

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Placeholder</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" placeholder="Placeholder" maxlength="4" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Only</label>
                                            <div class="col-sm-5">
                                                <div class="input-group date form_date" data-date="2014-06-14T05:25:07Z" data-date-format="dd-mm-yyyy" data-link-field="dtp_input3">
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Decade Year View</label>
                                            <div class="col-sm-5">
                                                <div class="input-group date form_decade" data-date="2014-06-14T05:25:07Z" data-date-format="dd-mm-yyyy" data-link-field="dtp_input5">
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Year View</label>
                                            <div class="col-sm-5">
                                                <div class="input-group date form_year" data-date="2014-06-14T05:25:07Z" data-date-format="dd-mm-yyyy HH:ii" data-link-field="dtp_input6">
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Basic</label>
                                            <div class="col-sm-7">
                                                <select id="source" class="form-control" style="width:300px">
                                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                                        <option value="AK">Alaska</option>
                                                        <option value="HI">Hawaii</option>
                                                    </optgroup>

                                                    <optgroup label="Mountain Time Zone">
                                                        <option value="AZ">Arizona</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="MT">Montana</option><option value="NE">Nebraska</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="WY">Wyoming</option>
                                                    </optgroup>

                                                </select>
                                            </div>
                                        </div>									
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Default Select2</label>
                                            <div class="col-sm-5">
                                                <select id="e1" class="populate" style="width:300px"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Multi-Value Select Boxes</label>
                                            <div class="col-sm-5">
                                                <select multiple id="e2" class="populate" style="width:300px"></select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-5">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="submit" class="btn btn-default">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END BASIC ELEMENTS -->
                    </div>

                    <div class="row">
                        <!-- BEGIN BASIC DATATABLES -->
                        <div class="col-md-12">
                            <div class="grid no-border">
                                <div class="grid-header">
                                    <i class="fa fa-table"></i>
                                    <span class="grid-title">Basic DataTables</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <table id="dataTables1" class="table table-hover display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Office</th>
                                                <th>Age</th>
                                                <th>Start date</th>
                                                <th>Salary</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Ashton Cox</td>
                                                <td>Junior Technical Author</td>
                                                <td>San Francisco</td>
                                                <td>66</td>
                                                <td>2009/01/12</td>
                                                <td>$86,000</td>
                                            </tr>
                                            <tr>
                                                <td>Cedric Kelly</td>
                                                <td>Senior Javascript Developer</td>
                                                <td>Edinburgh</td>
                                                <td>22</td>
                                                <td>2012/03/29</td>
                                                <td>$433,060</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END BASIC DATATABLES -->
                    </div>

                    <div class="row">
                        <!-- MODAl -->
                        <div class="col-md-6">
                            <div class="grid">
                                <div class="grid-header">
                                    <i class="fa fa-laptop"></i>
                                    <span class="grid-title">Colored Header Modals</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary2">Primary</button>
                                    <button class="md-trigger btn btn-primary" data-modal="modal-12">Just Me</button>

                                    <div class="modal fade md-effect-12" id="modalPrimary2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
                                        <div class="modal-wrapper">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-blue">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel8">Modal Title</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="md-modal md-effect-12" id="modal-12">
                                        <div class="md-content modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel30">Modal Title</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default md-close" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- MODAL -->
                    </div>

                </section>
                <!-- END MAIN CONTENT -->
            </aside>
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
        <!-- END JS PLUGIN -->

        <!-- BEGIN JS TEMPLATE -->
        <script src="<?php echo base_url('assets/js/main.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/skin-selector.js') ?>"></script>

        
        <!-- END JS TEMPLATE -->
    </body>

    <!-- Mirrored from vergo-kertas.herokuapp.com/forms-components.html by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 16 Sep 2014 01:38:20 GMT -->
</html>