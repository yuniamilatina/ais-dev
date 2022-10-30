<!DOCTYPE html>
<html>

<head>
    <title>INES MANUFACTURE</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ines/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ines/jquery-ui.css">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/img/icon_ines.png" />
</head>

<body id="body" data-baseurl="<?php echo base_url(); ?>">
    <section>
        <div id="header">
            <table style="width:100%;">
                <tr>
                    <td style="text-align:left;width:33%;">
                        <a><img width=30%; src="<?php echo base_url('assets/img/loggo/aisin-loggo.svg'); ?>"></a>
                    </td>
                    <td style="text-align:center;width:33%;color:#FFF;">
                        MANUFACTURE <?php echo strtoupper($work_center) ?>
                    </td>
                    <td style="text-align:right;width:33%;">
                        <a style='color:#FFFFFF;font-size: 1em;' id='clock'></a>
                    </td>
                </tr>
            </table>
        </div>

        <audio id="soundHandle" style="display: none;"></audio>
        <audio id="soundSuccessHandle" style="display: none;"></audio>

        <input type="hidden" id="input-work-center" value="<?php echo strtoupper($work_center) ?>" />
        <input type="hidden" id="input-shift" />
        <input type="hidden" id="input-back-no" />
        <input type="hidden" id="input-part-no" />
        <input type="hidden" id="input-part-name" />
        <input type="hidden" id="input-qty-kanban" />
        <input type="hidden" id="input-planning" />
        <input type="hidden" id="input-actual" />
        <input type="hidden" id="input-part-no-coil" />
        <input type="hidden" id="input-qty-weight" />

        <table class="table">
            <tr>
                <td colspan="2" class="box">
                    <div class="box-wo-number" id="shift"></div>
                </td>
                <td colspan="6" rowspan="2">
                    <div id="prod-order"></div>
                    <div style="font-size:100px;" id="back-no"></div>
                    <div class="label-material" id="part-no"></div>
                    <div style="font-size: 1em;" class="label-material-desc" id="part-name"></div>
                </td>
                <td colspan="2" class="box">
                    <input type="button" class="button-start" id="btn-start" value="START" />
                </td>
            </tr>

            <tr>
                <td colspan="2" class="box">
                    <div class="box-header">PLANNING</div>
                    <div class="box-body middle">
                        <span class="label-side" id="planning"></span>
                    </div>
                    <div class="box-footer">KANBAN</div>
                </td>
                <td colspan="2" class="box">
                    <div class="box-header">ACTUAL</div>
                    <div id="btnModalEceran" class="box-body middle">
                        <span class="label-side" id="actual"></span>
                        <span class="label-side-actual-pieces" id="actual-pieces"></span>
                    </div>
                    <div class="box-footer">KANBAN</div>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="bottom-box">
                    <button type="button" style="display:none;" class="button btnReprint">REPRINT</button>
                </td>
                <td colspan="6">
                    <div class="label-material" id="qty-kanban"></div>
                </td>
                <td colspan="2" class="bottom-box">
                    <button type="button" style="display:none;" class="button btnDandori">DANDORI</button>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="box">
                    <div class="label-material-desc" style='font-size: 1.5em;color:#FFFFFF;display:none;' id="prod-order-ref"></div>
                </td>
                <td colspan="3">
                    <div class="label-material" id="part-no-coil" style="font-weight:300;font-style: italic;font-size:1em;"></div>
                </td>
                <td colspan="3">
                    <div class="label-material" id="qty-weight" style="font-weight:300;font-style: italic;font-size:1em;"></div>
                </td>
                <td colspan="2" class="bottom-box">
                    <input type="button" style="display:none;" class="button" id="btnAddCoil" value="ADD COIL" />
                </td>
            </tr>

            <tr>
                <td colspan="2" class="box">
                    <!-- <div class="box-shift" style='color:#FFFFFF;display:none;' id="prod-order-ref"></div> -->
                </td>
                <td colspan="6" style="text-align: center;">
                    <i style="color: #FFFFFF;display: none;" id="msg-sudah-ada">Kanban sudah pernah di-scan.</i>
                </td>
                <td class="bottom-box">
                    <input type="button" style="display:none;" class="button-ls" id="btnLS" value="LINE STOP" />
                </td>
                <td class="bottom-box">
                    <button type="button" style="display:none;" class="button btnNG">REJECT/NG</button>
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

        <div style="padding-top:10px;">
            <span style="font-size:10pt;margin-left:4px;">DIGITAL SETUP CHUTE</span>
        </div>
        <iframe id='setup-chute' src="http://localhost:8080/ines" height="155px" width="100%" style="border:none;"></iframe>
        <div class="bottom-right-summary" style="width: 98%; bottom: 0px; position: fixed;">
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
            <div class="modal-footer">
                <button type="button" data-popup-close="modalStart" class="button-close">Close</button>
                <button type="button" id="btn-process-start" class="button-submit">Process</button>
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
                <input type="text" class="input-modal" id="scan-order-no" placeholder="Scan order No" />
                <div id="false-scan" class="message">
                    <i class="message-error" id="msg-false-scan"></i>
                </div>
                <br>
                <span style='color:grey;font-size:12px;' id="hint_prd_order_no">Exp : ASCD01/20200220/020</span>
            </div>
            <div class="modal-footer">
                <button type="button" data-popup-close="modalDandori" class="button-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div class="popup" data-popup="modalDandoriCoil">
        <div class="popup-inner">
            <div class="modal-header">
                <div class="label-modal">Dandori Coil</div>
            </div>
            <div class="modal-body">
                <div id="loading-scan-coil" class="message">
                    <img src="<?php echo base_url() ?>assets/css/ines/loader.gif" />
                </div>
                <input type="text" placeholder="Scan Kanban Coil" class="input-modal" id="barcode-value-coil" />
                <div id="false-scan-coil" class="message">
                    <i class="message-error" id="msg-false-scan-coil">Data tidak ditemukan. Silahkan coba lagi.</i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-popup-close="modalDandoriCoil" class="button-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div class="popup" data-popup="modalAddCoil">
        <div class="popup-inner">
            <div class="modal-header">
                <div class="label-modal">Add Coil</div>
            </div>

            <div class="modal-body">
                <div id="loading-scan-additional" class="message">
                    <img src="<?php echo base_url() ?>assets/css/ines/loader.gif" />
                </div>
                <input type="text" placeholder="Scan Coil" class="input-modal" id="barcode-value-coil-additional" />
                <div id="false-scan-coil-additional" class="message">
                    <i class="message-error" id="msg-false-scan-coil-additional">Data tidak ditemukan. Silahkan coba lagi.</i>
                </div>
                <div class="modal-footer">
                    <button type="button" data-popup-close="modalAddCoil" class="button-cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="popup" data-popup="modalConfirmReturn">
        <div class="popup-inner" style="padding-right: 5%;padding-left: 5%;">
            <button type="button" data-popup-close="modalConfirmReturn" class="button-close-x">&times;</button>
            <div class="modal-header">
                <div class="label-modal">Return Coil
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-dialog" id='return-message'></div>
                <div class="modal-footer">
                    <button type="button" id="btnYesReturn" class="button-solved">Ya</button>
                    <button type="button" id="btnNoRegardAsNG" class="button-help">Tidak, Coil habis</button>
                </div>
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
                <input type="text" class="input-modal numeric" placeholder="Input MP" id="totalmp" readonly />
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

    <div class="popup" data-popup="modalHistory">
        <div class="popup-inner">
            <div class="modal-header">
                <div class="label-modal">History of Dandori
                </div>
            </div>
            <div class="modal-body">
                <div class="label-modal-detail" id="table-history-dandory">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-popup-close="modalHistory" class="button-cancel">Cancel</button>
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
                                    <td><button type="button" id="ls-barrel" value="LS20" class="button-bridging">Barrel</button></td>
                                    <td><button type="button" id="ls-genba" value="LS9" class="button-genba">Genba/3S</button></td>
                                </tr>
                                <tr>
                                    <td><button type="button" id="ls-cleaning-scrapt" value="LS21" class="button-henkaten">Cleaning Scrap</button></td>
                                    <td><button type="button" id="ls-5mtalk" value="LS18" class="button-5talk">5' Talk</button></td>
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
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="false-ls" class="message">
                <i class="message-error" id="msg-false-ls"></i>
            </div>
            <div class="modal-footer">
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
                            <table>
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
                            </table>
                        </td>
                    </tr>
                </table>
                <div id="false-reject" class="message">
                    <i class="message-error" id="msg-false-reject"></i>
                </div>
                <div class="modal-footer">
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
                            <input type="text" class="input-modal" placeholder='Input Eceran' onkeyup="countChar(this)" id="QtyEceran" />
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
                <div id="false-eceran" class="message">
                    <i class="message-error" id="msg-false-eceran"></i>
                </div>
                <div class="modal-footer">
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

    <div class="popup" data-popup="modalDetailOneWayLabel">
        <div class="popup-inner">
            <div class="modal-header">
                <div class="label-modal">Print One Way Kanban
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

    <div class="popup" data-popup="modalDetailProduction" id="modalDetailProduction">
        <div class="popup-inner">
            <div class="modal-header">
                <div class="label-modal" style='font-size:30px;'>Detail Production</div>
            </div>
            <br>
            <div class="modal-body">
                <div class="label-modal" id="username"></div>
                <hr>
                <div class="label-modal" id="work_center"></div>
                <div class="label-modal" id="production_date"></div>
                <div class="label-modal" id="flg_shift_type"></div>
                <div class="label-modal" id="man_power"></div>
                <hr>
                <div class="label-modal" id="total_dandori"></div>
                <div class="label-modal" id="part_no"></div>
                <div class="label-modal" id="back_no"></div>
                <div class="label-modal" id="cycle_time"></div>
                <div class="label-modal" id="takt_time"></div>
            </div>
            <div class="modal-footer">
                <button type="button" data-popup-close="modalDetailProduction" class="button-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div id="loading-scan-center" style="display:none; width: 100%; text-align: center; position: fixed; bottom: 400px;">
        <img src="<?php echo base_url('assets/img/loading2.gif'); ?>">
    </div>

    <div class="popup" data-popup="modalForceStop">
        <div class="popup-inner">
            <div class='modal-body'>
                <div class="modal-dialog">Try Connecting ...</div>
            </div>
            <div class="modal-footer">
                <button type="button" data-popup-close="modalForceStop" class="button-cancel" id="btn-refresh">FORCE STOP</button>
            </div>
        </div>
    </div>

</body>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/jquery.scannerdetection.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/ines.common.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/ines/ines.coil.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/mqtt/mqttws31.min.js"></script>

</html>

<script>
    startTime();

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        if (m < 10) {
            m = "0" + m;
        };
        if (s < 10) {
            s = "0" + s;
        };
        $('#clock').html(h + ":" + m + ":" + s);
        var t = setTimeout(startTime, 500);
    }
</script>