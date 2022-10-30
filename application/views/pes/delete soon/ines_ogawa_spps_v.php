
<!DOCTYPE html>
<html>
    <head>
        <title>INES</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ines/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ines/jquery-ui.css">
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/img/icon_ines.png'); ?>"/>
    </head>
    <body id="body" data-baseurl="<?php echo base_url(); ?>">
        <section>
            <div id="header">
                <table style="width:100%;">
                    <tr>
                        <td style="text-align:left;width:33%;">
                            <a><img width=50%; src="<?php echo base_url('assets/img/loggo/aisin-ines.png'); ?>"></a>
                        </td>
                        <td style="text-align:center;width:33%;">
                                INES ELISANATA <?php echo strtoupper($wc) ?>
                        </td>
                        <td style="text-align:right;width:33%;">
                            <a><img width=40%; src="<?php echo base_url('assets/img/loggo/aisingroup-ines.png'); ?>"></a>
                        </td>
                    </tr>
                </table>
            </div>

            <audio id="soundHandle" style="display: none;"></audio>
            <input type="hidden" id="input-work-center" value="<?php echo strtoupper($wc) ?>" />

            <div id="loading-scan-center" style="display:none; width: 100%; text-align: center; position: fixed; bottom: 400px;">
                <img src="<?php echo base_url('assets/img/loading2.gif'); ?>">
            </div>

            <img src="<?php echo base_url('assets/img/no_production_image.png'); ?>" style="width:30%;position: fixed;top: 20%;left:35%;" class="img-no-dandori">

            <table class="table" >
                <tr>
                    <td colspan="2" class="box">
                    </td>
                    <td colspan="6" rowspan="3">
                        <div id="back-no"></div>
                        <input type="hidden" id="input-back-no" />
                        <div class="label-material" id="material"></div>
                        <input type="hidden" id="input-material" />

                        <div class="label-material-desc" id="material-description"></div>
                        <input type="hidden" id="input-material-description" />
                    </td>
                    <td colspan="2" class="box" >
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="box">
                        <div class="box-shift" id="shift"></div>
                        <input type="hidden" id="input-shift" />
                    </td>
                    <td colspan="2" class="box">
                        <input type="button" class="button-start" id="btnstart" value="START" />
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="box">
                        <div class="box-header">PLANNING</div>
                        <div class="box-body middle">
                            <span class="label-side" id="planning"></span>
                            <input type="hidden" id="input-planning" />
                        </div>
                        <div class="box-footer">KANBAN</div>
                        <input type="hidden" id="scankanban" />
                    </td>
                    <td colspan="2" class="box">
                        <div class="box-header">ACTUAL</div>
                        <div id="divActual" class="box-body middle">
                            <span class="label-side" id="actual"></span>
                            <input type="hidden" id="input-actual" />
                        </div>
                        <div class="box-footer">KANBAN</div>
                       
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="box">
                        <div class="box-shift" id="prod-order"></div>
                        <input type="hidden" id="input-prod-order" />
                    </td>
                    <td colspan="6">
                        <div class="label-material" id="qty-kanban"></div>
                        <input type="hidden" id="input-qty-product" />
                        <input type="hidden" id="input-qty-kanban" />
                    </td>
                    <td  class="bottom-box">
                        <button type="button" class="button btnReprint">REPRINT</button>
                    </td>
                    <td class="bottom-box">
                        <button type="button" class="button btnDandori">DANDORI</button>
                    </td>

                </tr>
                
                <tr>
                    <td colspan="2"  class="box">
                        <div class="box-shift" style='color:#FFFFFF;' id="prod-order-ref"></div>
                        <input type="hidden" id="input-prod-order-ref" />
                    </td>
                    <td colspan="6" style="text-align: center;">
                        <i style="color: #FFFFFF;display: none;" id="msg-sudah-ada">Kanban sudah pernah di-scan.</i>
                    </td>
                    <td  class="bottom-box">
                        <input type="button" class="button-ls" id="btnLS" value="LINE STOP" />
                    </td>
                    <td class="bottom-box">
                        <button type="button" class="button btnNG">REJECT/NG</button>
                    </td>
                </tr>

                <tr>
                    <td class="bottom-box">
                       
                    </td>
                    <td class="bottom-box">
                        
                    </td>
                    <td class="bottom-box">
                        
                    </td>
                    <td class="bottom-box">
                        
                    </td>
                    <td class="bottom-box">
                       
                    </td>
                    <td class="bottom-box">
                        
                    </td>
                    <td class="bottom-box">
                       
                    </td>
                    <td class="bottom-box">
                        
                    </td>
                    <td class="bottom-box">
                       
                    </td>
                    <td class="bottom-box">
                        
                    </td>
                </tr>
            </table>

            <div style="padding-top:20px;">
            <span style="font-size:10pt;margin-left:4px;">DIGITAL SETUP CHUTE</span>
            </div> 
            <iframe id='setup-chute' src="http://localhost:8080/ines" height="155px" width="100%" style="border:none;"></iframe>
            <div class="bottom-right-summary">
                <ul>
                    <li style="color:#00FC9B;">
                        <span style="color:#FFEB40;" id="total-pershift">TOTAL OK : 0 /Pcs</span>
                    </li>
                    <li style="color:#FF3539;">
                        <span style="color:#FFEB40;" id="total-ng">TOTAL NG : 0 /Pcs</span>
                    </li>
                    <li style="color:#0B2336;">
                        <span style="color:#FFEB40;" id="total-dandori">TOTAL DANDORI : 0</span>
                    </li>
                </ul>
            </div>
            <span class='desc-method' id="method-scan"></span>
            <input type="hidden" id="input-method-scan" />
        </section>

        <div class="popup" data-popup="modalStart">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Registration</div>
                </div>
                <div class="modal-body">
                    <table class="modal-table">
                        <tr>
                            <td width=45% style='text-align:center;' rowspan="2">
                            <input type="text" class="input-modal-qwerty" placeholder='NPK' onkeyup="countChar(this)" id="start-box" />
                                <table class='keyboard'>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="start-box" value="1"></td>
                                        <td><input type="button" class="qwerty" act="start-box" value="2"></td>
                                        <td><input type="button" class="qwerty" act="start-box" value="3"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="start-box" value="4"></td>
                                        <td><input type="button" class="qwerty" act="start-box" value="5"></td>
                                        <td><input type="button" class="qwerty" act="start-box" value="6"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="start-box" value="7"></td>
                                        <td><input type="button" class="qwerty" act="start-box" value="8"></td>
                                        <td><input type="button" class="qwerty" act="start-box" value="9"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="start-box" value="0"></td>
                                        <td colspan="2"><input type="button" class="delete qwerty" act="start-box" value="DELETE"></td>
                                    </tr>
                                </table>
                            </td>
                            
                            <td>
                                <input type="hidden" id="value-shift" />
                                <table class="modal-table-detail">
                                    <tr>
                                        <td colspan="4" class="label-modal-detail">Choose Shift</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" id="shift1" value="1" class="button-shift1">1</button></td>
                                        <td><button type="button" id="shift2" value="2" class="button-shift2">2</button></td>
                                        <td><button type="button" id="shift3" value="3" class="button-shift3">3</button></td>
                                        <td><button type="button" id="shift4" value="4" class="button-shift4">4</button></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width=45%>
                                <input type="hidden" id="value-type-shift" />
                                <hr>
                                <table class="modal-table-detail">
                                    <tr>
                                        <td colspan="2" class="label-modal-detail">Choose Shift Type</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" id="btn-shift-normal" value="N" class="button-type-shift">Normal</button></td>
                                        <td><button type="button" id="btn-shift-long" value="L" class="button-type-shift">Long</button></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                    </table>

                    <div id="false-input" class="message">
                        <i class="message-error" id="msg-false-input"></i>
                    </div>

                </div>
                <div class="modal-footer" >
                    <button type="button" data-popup-close="modalStart" class="button-close">Close</button>
                    <button type="button" id="btn-process-start" class="button-submit">Process</button>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalLabel">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Label Customer</div>
                </div>
                <div class="modal-body">
                    <div id="loading-scan-label" class="message">
                        <img src="<?php echo base_url() ?>assets/css/ines/loader.gif" />
                    </div>
                    <input type="text" class="input-modal" id="scanlabel" placeholder="Scan Label"/>
                    <div id="false-scan-label" class="message">
                        <i class="message-error" id="msg-false-scan-label">Data tidak ditemukan. Silahkan coba lagi.</i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-popup-close="modalLabel" class="button-cancel">Cancel</button>
                </div>
            </div>
        </div>
        
        <div class="popup" data-popup="modalDandori">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Production Order No</div>
                </div>

                <div class="modal-body" style="text-align:center;">
                    <div id="loading-scan" class="message">
                        <img src="<?php echo base_url() ?>assets/css/ines/loader.gif" />
                    </div>
                    <input type="text" class="input-modal" id="scan-order-no" placeholder="Scan order No"/>
                    <div id="false-scan" class="message">
                        <i class="message-error" id="msg-false-scan">Data tidak ditemukan. Silahkan coba lagi.</i>
                    </div>
                    <br>
                    <span style='color:grey;font-size:12px;' id="hint_prd_order_no">Exp : ASCD01/20200220/020</span>
                </div>
                <div class="modal-footer">
                    <button type="button" data-popup-close="modalDandori" class="button-cancel">Cancel</button>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalTotalMP">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Man Power
                    </div>
                </div>
                <div class="modal-body">
                    <div class="label-modal"></div>
                    <input type="text" class="input-modal numeric"  placeholder="Input MP" id="totalmp" readonly />
                    <table class="keyboard">
                        <tr>
                            <td><input type="button" class="qwerty" act="totalmp" value="1"></td>
                            <td><input type="button" class="qwerty" act="totalmp" value="2"></td>
                            <td><input type="button" class="qwerty" act="totalmp" value="3"></td>
                            <td><input type="button" class="qwerty" act="totalmp" value="4"></td>
                        </tr>
                        <tr>
                            <td><input type="button" class="qwerty" act="totalmp" value="5"></td>
                            <td><input type="button" class="qwerty" act="totalmp" value="6"></td>
                            <td><input type="button" class="qwerty" act="totalmp" value="7"></td>
                            <td><input type="button" class="qwerty" act="totalmp" value="8"></td>
                        </tr>
                        <tr>
                            <td><input type="button" class="qwerty" act="totalmp" value="9"></td>
                            <td><input type="button" class="qwerty" act="totalmp" value="0"></td>
                            <td colspan="3"><input type="button" class="delete qwerty" act="totalmp" value="DELETE"></td>
                        </tr>
                    </table>
                </div>

                <div id="false-mp" class="message">
                    <i class="message-error" id="msg-false-mp"></i>
                </div>

                <div class="modal-footer">
                    <button type="button" class="button-process" id="processTotalMP">Process</button>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalLS">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Line Stop</div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="line-stop" />
                        <table class="modal-table">
                            <tr width=50%>
                                <td>
                                    <table> 
                                        <tr>
                                            <td colspan="2" class="label-modal-detail">Planning Line stop</td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-dandori" value="LS1" class="button-dandory">Dandori</button></td>
                                            <td><button type="button" id="ls-qcsetup" value="LS2" class="button-setup">QC/Setup</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-trial" value="LS3" class="button-trial">Trial</button></td>
                                            <td><button type="button" id="ls-henkaten" value="LS10" class="button-henkaten">Henkaten</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-5mtalk" value="LS18" class="button-5talk">5' Talk</button></td>
                                            <td><button type="button" id="ls-genba" value="LS9" class="button-genba">Genba/3S</button></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr width=50%>
                                <td>
                                    <table>
                                        <tr>
                                            <td colspan="2" class="label-modal-detail">Unplanning Line stop</td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-bridging" value="LS14" class="button-bridging">Bridging</button></td>
                                            <td><button type="button" id="ls-machine" value="LS5" class="button-machine">Machine</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-quaprob" value="LS25" class="button-quaprob">Quality</button></td>
                                            <td><button type="button" id="ls-dies" value="LS24" class="button-dies">Dies</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-wait" value="LS6" class="button-wait">Cons. Shortage</button></td>
                                            <td><button type="button" id="ls-mold" value="LS23" class="button-mold">Mold</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-no-kanban" value="LS7" class="button-no-kanban">No kanban</button></td>
                                            <td><button type="button" id="ls-jig" value="LS4" class="button-jig">Jig/Eng</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-no-box" value="LS8" class="button-no-box">No Box</button></td>
                                            <td><button type="button" id="ls-hoist" value="LS11" class="button-hoist">Wait Hoist</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" id="ls-system" value="LS22" class="button-iot">IOT System</button></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                </div>
                <div id="false-ls" class="message">
                    <i class="message-error" id="msg-false-ls"></i>
                </div>
                <div class="modal-footer" >
                    <button type="button" data-popup-close="modalLS" class="button-close">Close</button>
                    <button type="button" id="prosesLS" class="button-submit">Process</button>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalFollowUp">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Followup Problem</div>
                </div>

                <div class="modal-body">
                    <div class="label-modal"></div>
                    <div id="loading-scan-npk" class='message'>
                        <img src="<?php echo base_url() ?>assets/js/ines/loader.gif" />
                    </div>
                    <input type="text" placeholder='Scan NPK' class="input-modal" id="npk-followup" />
                    <div id="false-scan-npk" class="message">
                        <i class="message-error" id="msg-false-scan-npk">NPK tidak ditemukan. Silahkan coba lagi.</i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-popup-close="modalFollowUp" class="button-cancel">Cancel</button>
                </div>

            </div>
        </div>

        <div class="popup" data-popup="modalNeedHelp">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Dialog Line Stop</div>
                </div>
                <div class="modal-body">
                    <div class="modal-dialog" id='labelProblemQuestion'></div>
                    <div class="modal-footer">
                        <button type="button" id="btnYesConfirm" class="button-solved">Ya</button>
                        <button type="button" id="btnWaitHelp" class="button-help">Ask to Help</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalNG">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Input Reject/ NG</div>
                </div>
                <div class="modal-body">
                    <table class="modal-table">
                        <tr>
                            <td>
                                <input type="hidden" id="input-back-no-eceran-reject" />
                                 <table id='table-reject' style='display:none;'>
                                    <tr>
                                        <td colspan="2" class="label-modal-detail">Choose Back No</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" id="back-no-eceran-reject" class="button-part-cavity" value="BACKNO"></button></td>
                                        <td><button type="button" id="back-no-eceran-mate-reject" class="button-part-cavity" value="BACKNO"></button></td>
                                    </tr>
                                </table>
                                <hr>
                            </td>
                            <td rowspan="2">
                                <input type="text" placeholder='Input Qty' class="input-modal numeric" id="qty" />
                                <table class="keyboard" id="tabel-ng">
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><input type="button" class="qwerty" act="qty" value="1"></td>
                                                    <td><input type="button" class="qwerty" act="qty" value="2"></td>
                                                    <td><input type="button" class="qwerty" act="qty" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" class="qwerty" act="qty" value="4"></td>
                                                    <td><input type="button" class="qwerty" act="qty" value="5"></td>
                                                    <td><input type="button" class="qwerty" act="qty" value="6"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" class="qwerty" act="qty" value="7"></td>
                                                    <td><input type="button" class="qwerty" act="qty" value="8"></td>
                                                    <td><input type="button" class="qwerty" act="qty" value="9"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" class="qwerty" act="qty" value="0"></td>
                                                    <td colspan="3"><input type="button" class="delete qwerty" act="qty" value="DELETE"></td>
                                                </tr>					
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width=45%>
                                <input type="hidden" id="value-ng" />
                                <table >
                                    <tr>
                                        <td colspan="2" class="label-modal-detail">Choose Reject / NG</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" id="ng1" value="1" class='button-pop-ng'>Proses</button></td>
                                        <td><button type="button" id="ng2" value="2" class='button-pop-ng'>B. Test</button></td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" id="ng3" value="3" class='button-pop-ng'>Set Up</button></td>
                                        <td><button type="button" id="ng6" value="6" class='button-pop-ng'>Material Asal</button></td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" disabled id="ng5" value="5" class='button-pop-ng'>-</button></td>
                                        <td><button type="button" disabled id="ng4" value="4" class='button-pop-ng'>-</button></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="modal-footer" >
                        <button type="button" data-popup-close="modalNG" class="button-close">Close</button>
                        <button type="button" id="processNG" class="button-submit">Process</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalEceran">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Input Eceran</div>
                </div>

                <div class="modal-body">
                    <table class="modal-table">
                        <tr>
                            <td>
                                <input type="hidden" id="input-back-no-eceran" />
                                <table id='table-eceran' style='display:none;'>
                                    <tr>
                                        <td colspan="2" class="label-modal-detail">Choose Back No</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" id="back-no-eceran" class="button-part-cavity">PART 1</button></td>
                                        <td><button type="button" id="back-no-eceran-mate" class="button-part-cavity">PART 2</button></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <input type="text" class="input-modal" placeholder='Qty Eceran' onkeyup="countChar(this)" id="QtyEceran" />
                                <table class='keyboard'>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="1"></td>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="2"></td>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="3"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="4"></td>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="5"></td>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="6"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="7"></td>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="8"></td>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="9"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="button" class="qwerty" act="QtyEceran" value="0"></td>
                                        <td colspan="2"><input type="button" class="delete qwerty" act="QtyEceran" value="DELETE"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="modal-footer" >
                        <button type="button" data-popup-close="modalEceran" class="button-close">Close</button>
                        <button type="button" id="prosesEceran" class="button-submit">Process</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="popup" data-popup="modalPrint">
            <div class="popup-inner">
                <div class='modal-body'>
                    <div class="modal-dialog">Printing ... </div>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalErrorMessage" id="modalErrorMessage">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Error Message</div>
                </div>
                <div class="modal-body">
                    <div class="label-modal" id="errorMessage"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-popup-close="modalErrorMessage" class="button-cancel">Cancel</button>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalHistory">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Production History
                    </div>
                </div>
                <div class="modal-body">
                    <div class="label-modal-detail" id="table-history-dandory">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-popup-close="modalHistory" class="button-cancel">Close</button>
                </div>
            </div>
        </div>

        <div class="popup" data-popup="modalDetailOneWayLabel">
            <div class="popup-inner">
                <div class="modal-header">
                    <div class="label-modal">Production History Detail
                    </div>
                </div>
                <div class="modal-body">
                    <div class="label-modal-detail" id="table-history-order-no">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-popup-close="modalDetailOneWayLabel" class="button-cancel">Close</button>
                </div>
            </div>
        </div>

    </body>

    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/jquery.scannerdetection.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/ines_ogawa_spps.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/mqtt/mqttws31.min.js"></script>

</html>
