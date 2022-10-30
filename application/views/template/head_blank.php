<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $title ?></title>
        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/highchart/highcharts.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/highchart/highcharts-more.js') ?>"></script>
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

        <script src="<?php echo base_url('assets/gantt/codebase/dhtmlxgantt.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url('assets/gantt/codebase/api.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url('assets/gantt/codebase/ext/dhtmlxgantt_tooltip.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <!--script src="<?php echo base_url('assets/gantt/codebase/ext/dhtmlxgantt_quick_info.js'); ?>" type="text/javascript" charset="utf-8"></script-->
        <link rel="stylesheet" href="<?php echo base_url('assets/gantt/codebase/dhtmlxgantt.css'); ?>" type="text/css" media="screen" title="no title" charset="utf-8">
        <script type="text/javascript" src="<?php echo base_url('assets/gantt/common/testdata.js'); ?>"></script>
        <link href="<?php echo base_url('assets/css/fileinput.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/jquery-2.1.1.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/canvas-to-blob.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/fileinput.min.js'); ?>"></script>

    </head>

    <body class="skin-blue" style="background:#ffffff;  ">

        <div class="wrapper row-offcanvas row-offcanvas-left" style="margin-top:0px;">
            <?php $this->load->view($content); ?>
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

        <!--script src="<?php echo base_url('assets/js/dashboard.js') ?>"></script-->
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
    </body>

</html>