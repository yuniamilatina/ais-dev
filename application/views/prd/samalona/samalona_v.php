<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>SAMALONA</title>
  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/samalona/main.css'); ?>" >
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/samalona/font-awesome.min.css'); ?>" >
  <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" > -->
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/img/loggo/logo-round.png'); ?>"/>
</head>

<body id="body" data-baseurl="<?php echo base_url(); ?>" >
    
        <div class="sidebar" id='sidebar'>
            <nav>
                <ul class="sidebar-component" id="component-pis">
                    <li class="side-bar-component">
                        <div style='width:160px;'></div>
                    </li>
                </ul>
            </nav>
            <div class="left-sidebar"><h2 id="count-comp" class="label-left-sidebar" ></h2></div>
        </div>

        <div class="main-wrapper" id='wrapper'>   
            <input type="hidden" id="input-work-center" value="<?php echo $wc ?>">
            <input type="hidden" id="input-pos" value="<?php echo $pos ?>">
            <input type="hidden" id="input-prd-order-no" value="">
                <table width=100%  cellspacing="0" cellpadding="0" border=0px>
                    <tr>
                        <td width="5%" >
                            <div class="humberger" id="sidebarToggle">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                            </div>
                        </td>
                            <td width="65%" class="dandori-table"><span id="part-no-fg"></span>&nbsp;&nbsp; <span id="back-no-fg"></span> &nbsp;&nbsp;<span id="prd-order-no"></span></td>
                            <td width="30%" onclick='show_history();' class="title-table"><?php echo  $wc.' / POS '.$pos ?></td>
                        </tr>
                </table>
                        
                        <div class="primary-image">

                            <h2 class="left-content">
                                <span id="pos-note"></span>
                            </h2>

                            <h2 class="center-content" style='display:none;'>
                                <span id="plan-box" class="label-right-content" style="background:#00FC9B;color:#000000;">0</span>
                                <span id="actual-box" class="label-right-content" style="background:#E84447;color:#FFFFFF;">0</span> 
                            </h2>

                            <h2 class="right-content" style='display:none;'>
                                <span id="back-no-comp" class="label-right-content"></span> 
                            </h2>

                            <h2 class="right-content" style='top:80px;right:-140px;'>
                                <img width=30% src="<?php echo base_url('assets/img/loggo/aisin-loggo.svg'); ?>">
                            </h2>

                            <div id="fg-pis" class='img-pis'>
                                <img id='img-content' src="<?php echo base_url('assets/img/no_prod.png'); ?>"  style='max-width:80%;max-height:80%;'>
                            </div>

                            <h3 class="text-error" id="msg-error"></h3>
                            <div class="img-button-close" id="component-close"></div>

                            <!-- <div class="loggo-aisin">
                                <img width=30% src="<?php echo base_url('assets/img/loggo/aisin-loggo.svg'); ?>">
                            </div> -->

                        </div>
                        <div>
                            <iframe src="http://localhost:8080/samalona" height="150px" width="100%" style="border:none;"></iframe>
                        </div>
        </div>

    <!-- <div class="float-button-fg"><a class="float-button-fg-fab float-button-fg-large" id="button-show-fg"><i class="fa fa-check"></i></a></div> -->

    <div class="zoom">
        <a class="zoom-fab zoom-btn-large" id="zoomBtn"><i class="fa fa-lock"></i></a>
        <ul class="zoom-menu">
        <li><a id="btn-dandori" class="zoom-fab zoom-btn-sm zoom-btn-report scale-transition scale-out"><i class="fa fa-gear"></i></a></li>
        <li><a id="btn-user" class="zoom-fab zoom-btn-sm zoom-btn-person scale-transition scale-out"><i class="fa fa-user"></i></a></li>
        </ul>
    </div>

    <div class="popup" data-popup="modalDandori">
        <div class="popup-inner">
            <div id="loading-scan">
                <img src="<?php echo base_url('assets/img/loading2.gif'); ?>">
            </div>
        </div>
    </div>

    <div class="popup" data-popup="modalKanban">
        <div class="popup-inner-orderno">
            <div class="modal-header">
                <div class="label-modal-title">Prod Order No</div>
            </div>
            <div class="modal-body">
                <input type="text" placeholder='Scan Barcode' class="input-modal" id="scankanban" />
                <div id="false-scan-kanban" style="width: 100%; text-align: center; margin-top: 10px; display: none">
                    <i class="message-error" id="msg-false-scan-kanban">Data tidak ditemukan. Silahkan coba lagi.</i>
                </div>
                <br>
            </div>
            <div class="modal-footer-dialog">
                <button type="button" data-popup-close="modalKanban" class="button-cancel">Cancel</button>
            </div>
        </div>
    </div>
    
    <div class="popup" data-popup="modalRegistration">
        <div class="popup-inner-registration">
            <div class="modal-header">
                <div class="label-modal-title">Registration</div>
            </div>
            <div class="modal-body-registration"> 
                <input type="text" placeholder="N P K" class="keyboard-npk" autocomplete=off onkeyup="countChar(this)" id="postman"/>
                    <table style='margin: 0 auto;'>
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
            <h3 class="text-error-npk" id="msg-error-npk"></h3>
            <div class="modal-footer-button">
                <button type="button" data-popup-close="modalRegistration" class="button-submit-cancel">Cancel</button>
                <button type="button" id="prosesRegistration" class="button-submit">Submit</button>
            </div>
        </div>
    </div>

    <div class="popup" data-popup="modalHistory">
            <div class="popup-inner-history">
                <div class="modal-header"><span class="label-modal-title">Completed Order Number</span></div>
                <div class="modal-body">
                    <div id="table-history-setupchute"><span class='label-modal'>No History Has Recorded</span></div>
                </div>
                <div class="modal-footer-dialog">
                    <button type="button" data-popup-close="modalHistory" class="button-cancel">Cancel</button>
                </div>
            </div>
    </div>
    
    <div class="popup" data-popup="modalQua">
        <div class="popup-inner-qua">
            <div class="modal-body-qua"> 
                <iframe id='iframe_patricia' height="650px" width="100%" style="border:none;" frameborder="0"  ></iframe>
            </div>
            <div class="modal-footer-dialog">
                <button type="button" data-popup-close="modalQua" class="button-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <!--LIST OF BACK NUMBER add by BugsMaker 2017 03 07-->
    <div class="popup" data-popup="modalBlockage">
        <div class="popup-inner-blockage">
            <div class="modal-header">
                <div class="label-modal-title">Uncomplete Setup Chute
            </div>
        </div>
        <div class="modal-body">
            <center id="table-blockage-dandory"></center>
            <br>
            </div>
            <div class="modal-footer-button">
                <button type="button" data-popup-close="modalBlockage" class="button-submit-cancel">Cancel</button>
                <button type="button" id="btnSkip" class="button-submit">Skip</button>
            </div>
        </div>
    </div>

	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/samalona/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/samalona/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/samalona/jquery.scannerdetection.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/samalona/samalona.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/mqtt/mqttws31.min.js"></script>
    <script>
        var $sidebarAndWrapper = $("#sidebar,#wrapper");

        $("#sidebarToggle").click(function () {
            $sidebarAndWrapper.toggleClass("hide-sidebar");
            $sidebarAndWrapper.toggleClass("change");
        });

  </script>

</body>
</html>
