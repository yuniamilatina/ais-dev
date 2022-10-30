<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAMALONA</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pos_scan_material_css/pos_scan_material.css'); ?>" >
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pos_scan_material_css/font-awesome.min.css'); ?>" >
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/pos_scan_material_js/jquery-ui.css'); ?>" >
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/img/icon.png'); ?>"/>
</head>

<body id="body" data-baseurl="<?php echo base_url(); ?>" >
        <nav class="navbar navbar-inverse navbar-fixed-top" >
            <div class="container-fluid">
            </div>
        </nav>
    
        <div class="main-wrapper">   

            <h2 class="left-sidebar">
                <!-- <span id="count-comp-finish" class="label-left-sidebar-finish">0</span> -->
                <span id="count-comp" class="label-left-sidebar">0/0</span>
            </h2>

            <div class="sidebar-container col-xs-3">
                <!-- <div class="sidebar-header">
                    <img src="<?php echo base_url('assets/img/logo30.png'); ?>" style="width:200px;">
                </div> -->
                <div class="sidebar">
                    <nav>
                        <ul class="sidebar-component" id="component-pis">
                            
                            <li class="side-bar-component">
                            <table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;margin-bottom:5px;background:#FFEB40;'><tr><td style="border-radius:10%;">BACKNO</td></tr></table>

                                 <div class="sekunder-image" >
                                    <img src="<?php echo base_url('assets/img/no_part_scan.png'); ?>" class="image-component">

                                    <div class="sidebar-bottom-right-comp">
                                    </div>
                                </div>
                                
                                <table border=0px; style='width:100%;border-color:white;font-size:12px;padding-left:0%;padding-right:0%;'>
                                <tr style='font-style: italic;'><td style="background:#00FC9B;color:#000000;">PLAN</td><td style="background:#E84447;color:#FFF">ACTL</td></tr>
                                <tr style="height:50px;font-size:18pt;"><td style="background:#00FC9B;color:#000000">0 BOX</td><td style="background:#E84447;color:#FFF">0 BOX</td></tr>
                            </table>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="main-view" >
                    <div class="container-main">
                    <input type="hidden" id="input-work-center" value="<?php echo $wc ?>">
                    <input type="hidden" id="input-pos" value="<?php echo $pos ?>">
                    <input type="hidden" id="input-prd-order-no" value="">
                        <table width=100%  cellspacing="0" cellpadding="0" style="border: none;"><tr>
                            <td width="70%" class="dandori-table"><span id="back-no-fg"></span>&nbsp;&nbsp;<span style="letter-spacing: -2px;font-weight:300;" id="prd-order-no"></span>&nbsp;&nbsp;<span id="part-no-fg"></span> </span></td>
                            <td width="30%" class="title-table">SAMALONA <?php echo ' POS '.$pos ?></td>
                        </tr></table>

                        <div class="primary-image">
                            <!-- <h2 class="left-content">
                                PART NO FG: <span id="part-no-fg" style="font-weight:500;background:#ffeb3b;"> - </span>  &nbsp;&nbsp;BACK NO FG : <span id="back-no-fg" style="font-weight:500;background:#ffeb3b;">-</span>&nbsp;&nbsp;
                                PRD ORDER : <span id="prd-order-no" style="font-weight:500;background:#ffeb3b;"> - </span>
                            </h2> -->

                            <!-- <h2 class="center-content">
                                PLAN : <span id="plan-box" class="label-right-content"">0</span> BOX &nbsp;&nbsp;ACTUAL : <span id="actual-box" class="label-right-content"">0</span> BOX 
                            </h2> -->

                            <h2 class="center-content">
                                <span id="plan-box" class="label-right-content" style="background:#00FC9B;color:#000000;">0</span>
                                <span id="actual-box" class="label-right-content" style="background:#E84447;color:#FFFFFF;">0</span> 
                            </h2>

                             <h2 class="right-content">
                                <span id="back-no-comp" class="label-right-content"></span> 
                            </h2>

                            <div id="fg-pis">
                                <img src="<?php echo base_url('assets/img/no_prod.png'); ?>" style="width:75%;height:75%;">
                                <!-- <button type="button" id="button-show-fg" class="button-fg">OK</button> -->
                            </div>

                            <h3 class="text-error" id="msg-error"></h3>
                            <div class="img-button-close" id="component-close">
                                <!-- <img src="<?php echo base_url('assets/img/close.png'); ?>" alt="close" style="width:40%;"> -->
                            </div>
                        </div>

                        <!-- setup-chute-komponen -->
                        <div id="setup-chute-table">
                                <table class="table" border=0px>
                                    <tr id="setup-chute-comp">
                                        <td class="bottom-box" id='td-setup-chute-1'>
                                            <!-- <div class="input-box-header-bottom">1</div>
                                            <div class="input-box-bottom-1">
                                                <span class="label-bottom" id="back-no-bottom-1"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-1">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-1"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-1"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-2'>
                                            <!-- <div class="input-box-header-bottom">2</div>
                                            <div class="input-box-bottom-2">
                                                <span class="label-bottom" id="back-no-bottom-2"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-2">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-2"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-2"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-3'>
                                            <!-- <div class="input-box-header-bottom">3</div>
                                            <div class="input-box-bottom-3">
                                                <span class="label-bottom" id="back-no-bottom-3"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-3">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-3"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-3"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-4'>
                                            <!-- <div class="input-box-header-bottom">4</div>
                                            <div class="input-box-bottom-4">
                                                <span class="label-bottom" id="back-no-bottom-4"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-4">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-4"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-4"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-5'>
                                            <!-- <div class="input-box-header-bottom">5</div>
                                            <div class="input-box-bottom-5">
                                                <span class="label-bottom" id="back-no-bottom-5"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-5">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-5"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-5"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-6'>
                                            <!-- <div class="input-box-header-bottom">6</div>
                                            <div class="input-box-bottom-6">
                                                <span class="label-bottom" id="back-no-bottom-6"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-6">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-6"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-6"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-7'>
                                            <!-- <div class="input-box-header-bottom">7</div>
                                            <div class="input-box-bottom-7">
                                                <span class="label-bottom" id="back-no-bottom-7"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-7">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-7"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-7"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-8'>
                                            <!-- <div class="input-box-header-bottom">8</div>
                                            <div class="input-box-bottom-8">
                                                <span class="label-bottom" id="back-no-bottom-8"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-8">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-8"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-8"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-9'>
                                            <!-- <div class="input-box-header-bottom">9</div>
                                            <div class="input-box-bottom-9">
                                                <span class="label-bottom" id="back-no-bottom-9"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-9">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-9"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-9"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="bottom-box" id='td-setup-chute-10'>
                                            <!-- <div class="input-box-header-bottom">10</div>
                                            <div class="input-box-bottom-10">
                                                <span class="label-bottom" id="back-no-bottom-10"></span>
                                                <span class="label-total-bottom" id="total-kanban-bottom-10">
                                                    <span class="label-pcs-bottom" id="pcs-kanban-bottom-10"></span>
                                                </span>
                                                <div class="label-status-bottom">
                                                    <span class="label-status-span-bottom" id="status-bottom-10"></span>
                                                </div>
                                            </div> -->
                                        </td>
                                    </tr>
                                </table>
                        </div>
                        <!-- setup-chute-komponen -->

                        <div id="setup-chute-iframe">
                            <iframe src="http://192.168.0.234:8089/samalona?wc=<?php echo strtoupper($wc) ?>&pos=<?php echo $pos ?>" height="200px" width="100%" style="border:none;"></iframe>
                        </div>

                    </div>
            </div>
        </div>
    
  <div class="zoom">
    <a class="zoom-fab zoom-btn-large" id="zoomBtn"><i class="fa fa-lock"></i></a>
    <ul class="zoom-menu">
      <li><a id="btn-dandori" class="zoom-fab zoom-btn-sm zoom-btn-report scale-transition scale-out"><i class="fa fa-gear"></i></a></li>
      <li><a id="btn-user" class="zoom-fab zoom-btn-sm zoom-btn-person scale-transition scale-out"><i class="fa fa-user"></i></a></li>
    </ul>
  </div>

    <div class="popup" data-popup="modalDandori">
        <div class="popup-inner-dandori">
                <!-- <div class="label-modal">LOADING...</div> -->
                <div id="loading-scan" style="width: 100%; text-align: center; margin-top: 10px; display: none;">
                    <img src="<?php echo base_url('assets/img/loading2.gif'); ?>">
                </div>
        </div>
    </div>
    
        <div class="popup" data-popup="modalRegistration">
            <div class="popup-inner-cavity">
                <button type="button" data-popup-close="modalRegistration" class="button-cancel">&times;</button>
                <div class="modal-header">
                    <div class="label-modal-title">&nbsp; REGISTRATION </div>
                </div>

                <table class="modal-table-eceran" border=0px>
                <tr>
                        <td>

                            <div class="modal-body-eceran"> 
                                 <div class="modal-body-eceran-dalam">

                            <div class="label-modal-v2">NPK</div>

                            <table border=0px>
                                <tr>
                                    <td colspan=3><input type="text" class="keyboard-npk" onkeyup="countChar(this)" id="postman" /></td>
                                </tr>
                                <tr>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="1"></td>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="2"></td>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="3"></td>
                                </tr>

                                <tr>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="4"></td>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="5"></td>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="6"></td>
                                </tr>

                                <tr>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="7"></td>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="8"></td>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="9"></td>
                                </tr>

                                <tr>
                                    <td><input type="button" class="qwerty-npk" act="postman" value="0"></td>
                                    <td colspan="2"><input type="button" class="delete-npk qwerty-npk" act="postman" value="DELETE"></td>
                                </tr>

                            </table>
                        </div>
                    </div>

                        </td>
                        
                            </tr>
                            <tr style="line-height: 1px;">
                                <td><h3 class="text-error-npk" id="msg-error-npk"></h3></td>
                            </tr>
                        </table>
                    <div class="modal-footer">
                        <button type="button" id="prosesRegistration" class="button-footer">PROCESS</button>
                    </div>
            </div>
        </div>

        <!--LIST OF BACK NUMBER add by BugsMaker 2017 03 07-->
        <div class="popup" data-popup="modalBlockage">
                <div class="popup-inner-history-dandory">
                    <button type="button" data-popup-close="modalBlockage" class="button-cancel">&times;</button>
                    <div class="modal-header">
                        <div class="label-modal-title">&nbsp;BLOCKAGE SETUP CHUTE
                        </div>
                    </div>
                    <div class="modal-body">
                        <div style="padding-right:10px;padding-left:10px;">
                            <h3>Pilih abnormal Back Number yang ingin di produksi kembali atau tap tombol SKIP untuk mengabaikan</h3>
                        </div>
                        <center id="table-blockage-dandory"></center>
                        <br>
                    </div>
                    <div class="modal-footer-dialog">
                        <button type="button" id="btnSkip" class="button-footer-dialog-no">SKIP</button>
                    </div>
                </div>
        </div>

	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/pos_scan_material_js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/pos_scan_material_js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/pos_scan_material_js/jquery.scannerdetection.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/pos_scan_material_js/pos_scan_material.js"></script>
	
    <!-- Loading when click Action -->
    <script type="text/javascript">
            $(document).ready(function () {
                $(document).ajaxStart(function () {
                    $('[data-popup="modalDandori"]').show();
                }).ajaxStop(function () {
                    $('[data-popup="modalDandori"]').hide();
                });
            });
    </script>

</body>
</html>
