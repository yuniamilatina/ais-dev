<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 5px;
    }
    .td-fixed{
        width: 10px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    .filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btnt{
        border:none;
    }

    .btnt:focus{
        outline: none;
    }

    .btnt:hover {
        background: #428bca;
        background-image: -webkit-linear-gradient(top, #428bca, #428bca);
        background-image: -moz-linear-gradient(top, #428bca, #428bca);
        background-image: -ms-linear-gradient(top, #428bca, #428bca);
        background-image: -o-linear-gradient(top, #428bca, #428bca);
        background-image: linear-gradient(to bottom, #428bca, #428bca);
        color:white;
    }

</style>

<script>
    window.onload = function() {
        document.getElementById("hide-sub-menus").click();
    }
</script>

<?php if ($set == 2) { ?>
    <script>
        alert('Maaf, Data sudah di-approve');
        window.location.href = "<?php echo site_url() ?>/pes/inline_scan_c/form/<?php echo $date_l; ?>/<?php echo $shift; ?>/<?php echo $wcenter_l; ?>/1";
    </script>
<?php } ?>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Edit & Approve In Line Scan</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title"><strong>EDIT & APPROVE IN LINE SCAN</strong></span>
                        <div class="pull-right grid-tools" style="font-size:11px;" >

                        </div>
                    </div>

                    <div class="grid-body">
                        <table width="100%" class="filter" border="0px">
                            <tr>
                                <td width="60%" rowspan="4"></td>
                                <td width="10%">Tanggal</td>
                                <td>
                                    <input type="text" onchange="changeDate()" class="ddl" id="datepicker" placeholder="DD/MM/YYYY" value="<?php echo $date; ?>" <?php
                                    if ($set == 1) {
                                        echo 'disabled="yes"';
                                    } else {
                                        echo '';
                                    }
                                    ?>> <input type="submit" style="height:30px;width:70px;background:#428bca;border:none;color:white;" name="send" value="<?php
                                           if ($set == 1) {
                                               echo 'Un-Set';
                                           } else {
                                               echo 'Set';
                                           }
                                           ?>" id="submit" class="<?php
                                           if ($set == 1) {
                                               echo 'active';
                                           } else {
                                               echo 'button';
                                           }
                                           ?>" onClick="getLocation()">
                                </td>
                            </tr>
                            <tr>
                                <td width="150"  height="30" >Work Center</td>
                                <td>
                                    <select id="opt_wcenter" style="width:100px" class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                        <?php
                                        foreach ($wcenters as $wcenter):
                                            $workcenter = trim($wcenter->CHR_WORK_CENTER);
                                            ?>
                                            <option value="<? echo site_url('pes_new/inline_scan_c/form/' . $date_l . '/' . $shift . '/' . ($workcenter) . '/' . $set); ?>" <?php
                                            if ($wcenter_l == $workcenter) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo $workcenter; ?></option>
                                                <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Shift</td>
                                <td colspan="5">
                                    <input type="submit" name="send" value="1" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '1') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/form/' . $date_l . '/1/' . $wcenter_l . '/' . $set) ?>';">
                                    <input type="submit" name="send" value="2" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '2') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/form/' . $date_l . '/2/' . $wcenter_l . '/' . $set) ?>';">
                                    <input type="submit" name="send" value="3" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '3') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/form/' . $date_l . '/3/' . $wcenter_l . '/' . $set) ?>';">
                                    <input type="submit" name="send" value="4" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '4') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/form/' . $date_l . '/4/' . $wcenter_l . '/' . $set) ?>';">
                                </td>
                            </tr>
                        </table>

                    </div>
                    
                    <input type="text" id="idPrd" style="display:none;">
                    <input type="text" id="idNGCat" style="display:none;">
                    <input type="text" id="partNoNg" style="display:none;">
                    <input type="text" id="iii" style="display:none;">
                    <span class="btn btn-primary" id="refreshListNGDetail" style="display:none;"> </span>
                    <!--</div>-->
                    <div class="grid-body">
                        <div class="pull-right">
                        </div>

                        <table  width="100%" border="0px">
                            <tr>
                                <td >
                                    <?php if ($stat_approve_by_leader != 1) { ?>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#modalDefault" data-placement="left" data-toggle="tooltip" title="Add Part" style="display:block;"><span class="fa fa-plus"></span> &nbsp;&nbsp; Add Part</button>
                                    <?php } ?>
                                </td>
                            <form action="" method="POST" onSubmit="return confirmAction()">
                                <td width="90%">
                                    <?php if ($stat_approve_by_leader != 1) { ?>
                                        &nbsp;<button type="submit" name="btn_save" value="Update All" id="submit_save" class="btn btn-primary" style="display:none;"><span class="fa fa-save"></span>&nbsp;&nbsp;Save All</button>
                                        <span value="Save All" id="btn_submit_check" class="btn btn-primary" style="width:80px;"><span class="fa fa-save"></span>&nbsp;&nbsp;Save All  &nbsp;&nbsp;</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <input id="search_back_number" class="ddl" type="text" name="name" placeholder="Search Back No">
                                </td>
                                </tr>
                        </table>

                        <table class="table table-condensed table-striped" id="list_data">
                            <thead>
                                <tr>
                                    <th width="10px" rowspan="2" style="text-align:center;vertical-align:middle">No</th>
                                    <th width="10px" rowspan="2" style="text-align:center;vertical-align:middle">No Sequence</th>
                                    <th width="180px" rowspan="2" style="text-align:center;vertical-align:middle">Part No</th>
                                    <th width="70px" rowspan="2" style="text-align:center;vertical-align:middle">Back No</th>
                                    <th width="560px" rowspan="2" style="text-align:center;vertical-align:middle">P.Name & Model</th>
                                    <th width="560px" rowspan="2" style="text-align:center;vertical-align:middle">Time Scan</th>
                                    <th width="60px" rowspan="2" style="text-align:center;vertical-align:middle">OK</th>
                                    <th width="60px" colspan="4" style="text-align:center;vertical-align:middle">NG</th>
                                    <th width="60px" rowspan="2" style="text-align:center;vertical-align:middle">Total</th>
                                    <th width="60px" rowspan="2" style="text-align:center;vertical-align:middle">Add Notes</th>
                                </tr>
                                <tr>
                                    <th width="60px" style="text-align:center;vertical-align:middle">Proses</th>
                                    <th width="60px" style="text-align:center;vertical-align:middle">B.Test</th>
                                    <th width="60px" style="text-align:center;vertical-align:middle">Set Up / Mat. Asal</th>
                                    <th width="60px" style="text-align:center;vertical-align:middle">Trial</th>
                                </tr>
                            </thead>

                            <tbody> 
                                <?php
                                $i = 1;
                                $arrayPartNumber = array();
                                $arrayIntNumber = array();
                                $resume_int_total_qty = 0;
                                $resume_int_total_ng_process = 0;
                                $resume_int_total_btest = 0;
                                $resume_int_total_setup = 0;
                                $resume_int_total_trial = 0;
                                $resume_int_total_prd = 0;
                                $first = 1;
                                $num_part = 0;
                                foreach ($parts as $part):
                                    $int_number = $part->INT_NUMBER;
                                    if (in_array($int_number, $arrayIntNumber)) {
                                        continue;
                                    }
                                    array_push($arrayIntNumber, $int_number);
                                    $num_part++;
                                endforeach;

                                $arrayIntNumber = array();
                                foreach ($parts as $part):
                                    $partno = trim($part->CHR_PART_NO);
                                    $int_number = $part->INT_NUMBER;

                                    if (in_array($int_number, $arrayIntNumber)) {
                                        continue;
                                    }
                                    array_push($arrayIntNumber, $int_number);

                                    if ($first <> 1) {
                                        if ($partno <> $partno_cek) {
                                            ?>
                                            <tr id="thisRow">
                                                <td colspan="6" style="text-align:right;font-weight: bold;"> Sub Total </td>
                                                <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_qty ?></td>
                                                <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_ng_process ?></td>
                                                <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_btest ?></td>
                                                <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_setup ?></td>
                                                <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_trial ?></td>
                                                <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_prd ?></td>
                                                <td  style="text-align:center;font-weight: bold;"></td>
                                            </tr>
                                            <?php
                                            $resume_int_total_qty = 0;
                                            $resume_int_total_ng_process = 0;
                                            $resume_int_total_btest = 0;
                                            $resume_int_total_setup = 0;
                                            $resume_int_total_trial = 0;
                                            $resume_int_total_prd = 0;
                                        }
                                    }
                                    $resume_int_total_qty = $resume_int_total_qty + $part->INT_TOTAL_QTY;
                                    $resume_int_total_ng_process += $part->INT_NG_PRC;
                                    $resume_int_total_btest += $part->INT_NG_BRKNTEST;
                                    $resume_int_total_setup += $part->INT_NG_SETUP;
                                    $resume_int_total_trial += $part->INT_NG_TRIAL;
                                    $resume_int_total_prd = $resume_int_total_qty + $resume_int_total_ng_process + $resume_int_total_btest + $resume_int_total_setup + $resume_int_total_trial;
                                    $resume_per_row = $part->INT_TOTAL_QTY + $part->INT_NG_PRC + $part->INT_NG_BRKNTEST + $part->INT_NG_SETUP + $part->INT_NG_TRIAL;
                                    $first++;

                                    $partno_cek = $partno;
                                    ?>
                                    <tr id="thisRow">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $part->INT_NUMBER; ?></td>
                                <input type="hidden" name="int_number[<?php echo $i; ?>]" value="<?php echo $part->INT_NUMBER; ?>" />

                                <td class="part_number" style="text-align:center;"><?php echo $partno; ?>
                                    <input type="hidden" name="part_number[<?php echo $i; ?>]" value="<?php echo $partno; ?>" />
                                    <input type="hidden" name="pv[<?php echo $i; ?>]" value="" />
                                    <input type="hidden" name="part_name[<?php echo $i; ?>]" value="<?php echo $part->CHR_PART_NAME; ?>" />
                                    <input type="hidden" name="part_number_hyp[<?php echo $i; ?>]" value="<?php echo $partno; ?>" />
                                </td>
                                <td class="back_number" style="text-align:center;"><?php echo $part->CHR_BACK_NO; ?><input type="hidden" name="back_number[<?php echo $i; ?>]" value="<?php echo $part->CHR_BACK_NO; ?>" /></td>

                                <td class="part_name" style="font-size: 10pt;vertical-align:middle;"><?php echo $part->CHR_PART_NAME; ?><input type="hidden" name="wcenter[<?php echo $i; ?>]" value="<?php echo $part->CHR_WORK_CENTER; ?>" /><input type="hidden" name="wcenter_mn[<?php echo $i; ?>]" value="<?php echo $part->CHR_WORK_CENTER; ?>" /></td>
                                <td class="type" style="text-align:center;"><?php echo date('H:i:s', strtotime($part->CHR_TIME_ENTRY)); ?></td>
                                <td><input autocomplete="off" data-toggle="tooltip" title="OK"  onfocus="if (this.value == '0') {
                                            this.value = '';
                                            this.style.outline = 'none';
                                            var thisRow = document.getElementById('thisRow');
                                            thisRow.style.backgroundColor = '#44D7A8';
                                            this.style.backgroundColor = '#44D7A8';

                                        }" 
                                           onblur="if (this.value == '') {
                                                       this.value = '0';
                                                       this.style.backgroundColor = '#7FFFD4';
                                                   }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalOK(<?php echo $i; ?>)" style="text-align:right;padding-right:0px;width:60px;background: #7FFFD4;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ok[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_TOTAL_QTY, 0, ',', '.'); ?>" <?php
                                           if ($set == '0') {
                                               echo "disabled='yes'";
                                           }
                                           ?> ></td>
                                
                                <td><input id="qty_ng_proses<?php echo $part->INT_NUMBER; ?>" data-toggle="tooltip" title="NG Proses" onfocus="if (this.value == '0') {
                                            this.value = '';
                                        };

                                        document.getElementById('btnNGDetail<?php echo $i; ?>').click();
                                        document.getElementById('btnNGDetailRefresh<?php echo $part->INT_NUMBER; ?>').click();
                                        setTimeout(function () {
                                            document.getElementById('qtyNGOthers<?php echo $part->INT_NUMBER; ?>').click();
                                        }, 3000);" onblur="if (this.value == '') {
                                                    this.value = '0';
                                                }" autocomplete="off" onkeypress="return isNumberKey(event)"   onKeyUp="findTotalNG_proses(<?php echo $i; ?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_proses[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_PRC, 0, ',', '.'); ?>" <?php
                                           if ($set == '0') {
                                               echo "disabled='yes'";
                                           }
                                           ?>></td>
                                
                                <td><input autocomplete="off" data-toggle="tooltip" title="NG B.test" onfocus="if (this.value == '0') {
                                            this.value = '';
                                        }" onblur="if (this.value == '') {
                                                    this.value = '0';
                                                }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_btest(<?php echo $i; ?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_btest[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_BRKNTEST, 0, ',', '.'); ?>" <?php
                                           if ($set == '0') {
                                               echo "disabled='yes'";
                                           }
                                           ?>></td>
                                <td><input  autocomplete="off" data-toggle="tooltip" title="NG Setup"  onfocus="if (this.value == '0') {
                                            this.value = '';
                                        }" onblur="if (this.value == '') {
                                                    this.value = '0';
                                                }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_setup(<?php echo $i; ?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_setup[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_SETUP, 0, ',', '.'); ?>" <?php
                                            if ($set == '0') {
                                                echo "disabled='yes'";
                                            }
                                            ?>></td>
                                <td><input autocomplete="off" data-toggle="tooltip" title="NG Trial" onfocus="if (this.value == '0') {
                                            this.value = '';
                                        }" onblur="if (this.value == '') {
                                                    this.value = '0';
                                                }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_trial(<?php echo $i; ?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_trial[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_TRIAL, 0, ',', '.'); ?>" <?php
                                           if ($set == '0') {
                                               echo "disabled='yes'";
                                           }
                                           ?>></td>
    <!--                                                <td><input autocomplete="off" onfocus="if(this.value == '0'){this.value = '';}" onblur="if(this.value == ''){this.value = '0';}" onclick="document.getElementById('btnNGDetail<?php echo $i; ?>').click();
                                        document.getElementById('btnNGDetailRefresh<?php echo $partno; ?>').click()" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_others(<?php echo $i; ?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_others[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_TRIAL, 0, ',', '.'); ?>" <?php
                                if ($set == '0') {
                                    echo "disabled='yes'";
                                }
                                ?>></td>-->
                                <span style="display:none;" id="btnNGDetail<?php echo $i; ?>" class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary<?php echo $i; ?>">Primary</span>
                                <span style="display:none;" id="btnNGDetailRefresh<?php echo $part->INT_NUMBER; ?>" class="btn btn-primary">Primary</span>
                                <td><input autocomplete="off" style="text-align:right;padding-right:0px;width:60px;font-weight:bold;" type="text" size="1" name="sum_qty[<?php echo $i; ?>]" id="sum_qty[<?php echo $i; ?>]" value="<?php echo $resume_per_row; ?>" readonly="yes"></td>
                                <td style='text-align:center;'><a data-toggle="modal" data-target="#comment_<?php echo $part->INT_NUMBER; ?>" onclick="get_notes_by_id(<?php echo $part->INT_NUMBER; ?>,'NG1')" class="label label-primary"  data-placement="right" title="add Notes"><span class="fa fa-comment"></span></a></td>
                                </tr>

                                <?php
                                $i++;

                                if ($i == $num_part + 1) {
                                    ?>
                                    <tr id="thisRow">
                                        <td colspan="6" style="text-align:right;font-weight: bold;"> Sub Total </td>
                                        <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_qty ?></td>
                                        <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_ng_process ?></td>
                                        <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_btest ?></td>
                                        <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_setup ?></td>
                                        <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_trial ?></td>
                                        <td  style="text-align:center;font-weight: bold;"><?php echo $resume_int_total_prd ?></td>
                                        <td  style="text-align:center;font-weight: bold;"></td>
                                    </tr>
                                    <?php
                                }
                            endforeach;
                            ?>
                            <tr style="background-color: #e7e7e7">
                                <td colspan="6" style="text-align:right;"> Total </td>
                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ok" id="tot_qty_ok" value="" readonly="yes" ></td>
                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_proses" id="tot_qty_ng_proses" value="" readonly="yes"></td>
                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_btest" id="tot_qty_ng_btest" value="" readonly="yes"></td>
                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_setup" id="tot_qty_ng_setup" value="" readonly="yes"></td>
                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_trial" id="tot_qty_ng_trial" value="" readonly="yes"></td>
                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_sum_qty" id="tot_sum_qty" value="" readonly="yes"></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <?php
                        $j = 1;
                        $arrayIntNumber = array();
                        foreach ($parts as $part):
                            //20180306 - problem NG PoP UP tidak sesuai dengan Part Number.
//                          Problem karena di komen untuk logic array pushnya
                            $int_number = $part->INT_NUMBER;
                            if (in_array($int_number, $arrayIntNumber)) {
                                continue;
                            }
                            array_push($arrayIntNumber, $int_number);
                            ?>
                            <div class="modal fade" id="modalPrimary<?php echo $j; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-blue">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel8"><span><strong>NG Others</strong></span><br /> <strong><?php echo trim($part->CHR_PART_NO); ?></strong><?php echo " - " . $part->CHR_PART_NAME; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Qty</label>
                                                    <div class="col-sm-3">
                                                        <input  id="qtyNGOthers<?php echo trim($part->INT_NUMBER); ?>" onkeypress="return isNumberKey(event)" class="form-control" placeholder="0">
                                                    </div>
                                                </div><br />
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Reasons </label>
                                                    <div class="col-sm-5">
                                                        <!--<select id="e<?php echo $j; ?>" class="populate" style="width:300px"></select>-->
                                                        <select id="b<?php echo $j; ?>" class="form-control" style="width:300px">
                                                            <?php
                                                            foreach ($masterNg as $valueMasterng) {
                                                                if ($valueMasterng->CHR_NG_CATEGORY_CODE == '    ' or $valueMasterng->CHR_NG_CATEGORY_CODE == 'NG2 ' or $valueMasterng->CHR_NG_CATEGORY_CODE == 'NG1 ' or $valueMasterng->CHR_NG_CATEGORY_CODE == 'NG3 ' or $valueMasterng->CHR_NG_CATEGORY_CODE == 'NG4 ') {
                                                                    continue;
                                                                }
                                                                ?> 
                                                                <option value="<?php echo $valueMasterng->CHR_NG_CATEGORY_CODE; ?>"><?php echo $valueMasterng->CHR_NG_CATEGORY ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div><br />


                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <div class="btn-group">
                                                            <span type="submit" class="btn btn-primary" id="btnAddQtyNGOthers<?php echo trim($part->INT_NUMBER); ?>">Add/Update</span>
                                                            <span type="submit" class="btn btn-default" data-dismiss="modal">Cancel</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table" id="table_ng<?php echo trim($part->INT_NUMBER); ?>">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Reasons</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- =========================================================================================================================== -->
                            <div class="modal fade" id="comment_<?php echo $part->INT_NUMBER; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel3"><strong>REJECT NOTE ID <?php echo $part->INT_NUMBER ?></strong>&nbsp;&nbsp;<span style='font-size:12px;font-style:italic;'>Deskipsikan reject/NG yang terjadi disini</span></h4>
                                                </div>
                                                <div class="modal-body" >
                                                    <input name="INT_NUMBER" type='hidden' value='<?php echo $part->INT_NUMBER ?>' />
                                                    <input name="CHR_LS_CODE" type='hidden' value='NG1' id='textng_code_<?php echo $part->INT_NUMBER ?>'/>
                                                    <input name="CHR_LS_DESC" type='hidden' value='PROCESS' id='descng_code_<?php echo $part->INT_NUMBER ?>'/>

                                                    <div class="form-group" >
                                                        <label class="col-sm-2 control-label">NG Type</label>
                                                        <select id="ngtype" onchange="get_notes_by_id(<?php echo $part->INT_NUMBER ?>, this.options[this.selectedIndex].value); document.getElementById('textng_code_<?php echo $part->INT_NUMBER ?>').value=this.options[this.selectedIndex].value; document.getElementById('descng_code_<?php echo $part->INT_NUMBER ?>').value=this.options[this.selectedIndex].text;" class="form-control" style="width:200px">
                                                            <option value="NG1">PROCESS</option>
                                                            <option value="NG2">BROKEN TEST</option>
                                                            <option value="NG3">SETUP</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Notes</label>
                                                        <div>
                                                            <textarea id='note_<?php echo $part->INT_NUMBER ?>' name="CHR_NOTE" rows="3" cols="40" ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal" id='close_modal'> Close</button>
                                                        <a onclick="add_notes(<?php echo $part->INT_NUMBER ?>,$('#note_<?php echo $part->INT_NUMBER ?>').val(), $('#textng_code_<?php echo $part->INT_NUMBER ?>').val(), $('#descng_code_<?php echo $part->INT_NUMBER ?>').val());" class="btn btn-success"> Add</a>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--=========================================================================================================================== -->

                            <?php
                            $j++;
                        endforeach;
                        ?>
                        <input type="hidden"  name="i" value="<?php echo $i - 1; ?>">
                        </form>

                        <div class="modal fade" id="modalDefault" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-blue">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel1"><strong>Add Part To List</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('pes_new/inline_scan_c/add_list_part_by_wc', 'class="form-horizontal"'); ?>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Back No</label>
                                                <div class="col-sm-8">
                                                    <select id='e1' name='back_no' style="width:120px" >
                                                        <?php foreach ($part_by_wc as $part_list) { ?>
                                                            <option name='back_no' value="<?php echo $part_list->CHR_BACK_NO ?>"><?php echo $part_list->CHR_BACK_NO; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <input type='hidden' value='<?php echo $wcenter_l; ?>' name='work_center' />
                                            <input type='hidden' value='<?php echo $date_l; ?>' name='date' />
                                            <input type='hidden' value='<?php echo $shift; ?>' name='shift' />
                                            <input type='hidden' value='<?php echo $set; ?>' name='set' />
                                        </div>

                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button id="btn-ok" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add To List" ><i class="fa fa-check"></i> Add to List</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <?php if ($role == 16 || $role == 17) { ?>

                            <?php echo form_open('pes_new/inline_scan_c/approve_by_leader', 'class="form-horizontal"'); ?>
                            <input type='hidden' value='<?php echo $wcenter_l; ?>' name='work_center' />
                            <input type='hidden' value='<?php echo $date_l; ?>' name='date' />
                            <input type='hidden' value='<?php echo $shift; ?>' name='shift' />
                            <input type='hidden' value='<?php echo $set; ?>' name='set' />
                            <?php if ($stat_approve_by_leader == 1) { ?>
                                <button value="Data Has been Approved" disabled class="btn btn-warning"><span class="fa fa-thumbs-up"></span>&nbsp;&nbsp;Data Has been Approved </button>
                            <?php } else { ?>
                                <button type="submit" name="btn_approve" value="Approve" class="btn btn-success" onclick="return confirm('Apakah anda yakin data sudah akurat?');"><span class="fa fa-thumbs-up" ></span>&nbsp;&nbsp;Approve </button>
                            <?php } ?>
                            <?php echo form_close(); ?>

                        <?php } else { ?>

                            <?php echo form_open('pes_new/inline_scan_c/unapprove_by_spv', 'class="form-horizontal"'); ?>
                            <input type='hidden' value='<?php echo $wcenter_l; ?>' name='work_center' />
                            <input type='hidden' value='<?php echo $date_l; ?>' name='date' />
                            <input type='hidden' value='<?php echo $shift; ?>' name='shift' />
                            <input type='hidden' value='<?php echo $set; ?>' name='set' />
                            <?php if ($stat_approve_by_leader == 1) { ?>
                                <button type="submit" name="btn_unapprove" value="Unapprove" class="btn btn-danger" onclick="return confirm('Apakah anda yakin data akan di Unapprove?');"><span class="fa fa-thumbs-down" ></span>&nbsp;&nbsp;Unapprove </button>
                            <?php } else { ?>
                                <button value="Data has not been approved" disabled class="btn btn-warning">Data has not been approved </button>
                            <?php } ?>
                            <?php echo form_close(); ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

<script type="text/javascript">
    function deleteNG(idPrd, idNGCat, partNo) {
        document.getElementById("idPrd").value = idPrd;
        document.getElementById("idNGCat").value = idNGCat;
//        document.getElementById("iii").value = iii;
        document.getElementById("partNoNg").value = partNo;
        document.getElementById("refreshListNGDetail").click();
    }

    function clearBoxPartNo() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = false;
        document.getElementById("search_back_number").value = "";
        document.getElementById("search_back_number").disabled = true;
        document.getElementById("search_part_name").value = "";
        document.getElementById("search_part_name").disabled = true;
        $("#list_data tr td.part_name").parent().show();
    }

    function clearBoxBackNo() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = true;
        document.getElementById("search_back_number").value = "";
        document.getElementById("search_back_number").disabled = false;
        document.getElementById("search_part_name").value = "";
        document.getElementById("search_part_name").disabled = true;
        $("#list_data tr td.part_name").parent().show();
    }

    function clearBoxPartName() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = true;
        document.getElementById("search_back_number").value = "";
        document.getElementById("search_back_number").disabled = true;
        document.getElementById("search_part_name").value = "";
        document.getElementById("search_part_name").disabled = false;
        $("#list_data tr td.part_name").parent().show();
    }

    function showAll() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_back_number").value = "";
        document.getElementById("search_part_name").value = "";
        $("#list_data tr td.part_name").parent().show();
    }

    function getLocation() {
        var t = document.getElementById("opt_wcenter");
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
        if (<?php echo $set ?> == 0)
        {
            location.href = '<?php echo site_url() ?>/pes_new/inline_scan_c/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/1'
        } else
        {
            location.href = '<?php echo site_url() ?>/pes_new/inline_scan_c/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/0'
        }
    }

    function changeDate() {
        var t = document.getElementById("opt_wcenter");
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
        location.href = '<?php echo site_url() ?>/pes_new/inline_scan_c/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/0'
//            if (<?php echo $set ?> == 0)
//            {
//                location.href = '<?php echo site_url() ?>/pes_new/prod_ines_m/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/1'
//            } else
//            {
//                location.href = '<?php echo site_url() ?>/pes_new/inline_scan_c/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/0'
//            }
    }

    function confirmAction() {

        if (document.getElementById("datepicker").disabled === false) {
            alert('Maaf, anda belum set tanggal');
            return false;
        } else {
            return confirm("Anda yakin untuk menyimpan data?");
        }
    }

    function isNumberKey(evt)
    {

        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function makeItBlank(valInput)
    {
        if (valInput = 0) {
            this.value = " "
        }
        alert(valInput);

    }

    function add_notes(id, notes, ngtype, ngdesc){
        console.log(notes);
        console.log(ngtype);

        //save data logic here
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pes_new/inline_scan_c/save_notes'); ?>",
                dataType: 'json',
                data: "id=" + id + "&notes=" + notes + "&ngtype=" + ngtype,
                success: function (data) {
                    if (data) {
                        alert('Tidak ada hasil produksi NG/reject '+ngdesc+' pada kolom dengan id '+id+' ini');
                    }else{
                        $('#close_modal').click();
                    }
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
    }

    function get_notes_by_id(id, ngtype){

            $('#textng_code_'+ id ).val(ngtype);

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pes_new/inline_scan_c/get_notes_by_id'); ?>",
                dataType: 'json',
                data: "id=" + id + "&ngtype=" + ngtype,
                success: function (data) {
                    $('#note_' + id).val(data);
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
    }

</script>

<script type="text/javascript">

    function findTotalOK(arrPart) {
        // $(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_ok[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        var a = tot;
        document.getElementById('tot_qty_ok').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }

    function findTotalNG_proses(arrPart) {
        //$(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_ng_proses[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        document.getElementById('tot_qty_ng_proses').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }

    function findTotalNG_btest(arrPart) {
        //$(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_ng_btest[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        document.getElementById('tot_qty_ng_btest').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }

    function findTotalNG_setup(arrPart) {
        //$(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_ng_setup[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        document.getElementById('tot_qty_ng_setup').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }

    function findTotalNG_trial(arrPart) {
        //$(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_ng_trial[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        document.getElementById('tot_qty_ng_trial').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }

    function findTotalNG_others(arrPart) {
        //$(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_ng_others[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        document.getElementById('tot_qty_ng_others').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }

    function findTotalPart(arrPart) {
        var tot = 0;
        var arrqty_ok = document.getElementsByName('qty_ok[' + arrPart + ']');
        var arrqty_ng_proses = document.getElementsByName('qty_ng_proses[' + arrPart + ']');
        var arrqty_ng_btest = document.getElementsByName('qty_ng_btest[' + arrPart + ']');
        var arrqty_ng_setup = document.getElementsByName('qty_ng_setup[' + arrPart + ']');
        var arrqty_ng_trial = document.getElementsByName('qty_ng_trial[' + arrPart + ']');
        var arrqty_ng_others = document.getElementsByName('qty_ng_others[' + arrPart + ']');
        tot = parseInt(arrqty_ok[0].value.replace(".", "")) + parseInt(arrqty_ng_proses[0].value.replace(".", "")) + parseInt(arrqty_ng_btest[0].value.replace(".", "")) + parseInt(arrqty_ng_setup[0].value.replace(".", "")) + parseInt(arrqty_ng_trial[0].value.replace(".", ""));
        document.getElementById('sum_qty[' + arrPart + ']').value = tot;

        tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {

            var arr = document.getElementsByName('sum_qty[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        document.getElementById('tot_sum_qty').value = tot.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        ;

    }

    findTotalOK();
    findTotalNG_proses();
    findTotalNG_btest();
    findTotalNG_setup();
    findTotalNG_trial();

    var tot = 0;
    for (var i = 1; i <<?php echo $i; ?>; i++) {
        findTotalPart(i);
        var arr = document.getElementsByName('sum_qty[' + i + ']');
        if (parseInt(arr[0].value))
            tot += parseInt(arr[0].value);
    }
    document.getElementById('tot_sum_qty').value = tot;
</script>

<?php $min_date = '2019/03/25'; ?>

<script>
    $(function () {
        $("#datepicker").datepicker({ 
            dateFormat: 'dd/mm/yy', 
            minDate: new Date("<?php echo $min_date; ?>"),
            maxDate: 'today',
            inline: true
        });
    });
</script>

<script type="text/javascript">
    $.expr[':'].Contains = function (x, y, z) {
        return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase()) >= 0;
    };

    $('#search_back_number').keyup(function ()
    {
        var search = $('#search_back_number').val();
        $('#list_data tr').show();
        if (search.length > 0)
        {

            $("#list_data tr td.back_number").not(":Contains('" + search + "')").parent().hide();
        }
    });

    $('#search_part_number').keyup(function ()
    {
        var search = $('#search_part_number').val();
        $('#list_data tr').show();
        if (search.length > 0)
        {
            $("#list_data tr td.part_number").not(":Contains('" + search + "')").parent().hide();
        }
    });

    $('#search_part_name').keyup(function ()
    {
        var search = $('#search_part_name').val();
        $('#list_data tr').show();
        if (search.length > 0)
        {

            $("#list_data tr td.part_name").not(":Contains('" + search + "')").parent().hide();
        }
    });
</script>

<script>
    $(':text').focus(function () {
        $(this).one('mouseup', function (event) {
            event.preventDefault();
        }).select();
    });
</script>

<script>
    $(document).ready(function () {

<?php
$i = 1;

$arrayPartNumber = array();
$arrayIntNumber = array();

foreach ($parts as $part):
    $int_number = $part->INT_NUMBER;
    if (in_array($int_number, $arrayIntNumber)) {
        continue;
    }
    array_push($arrayIntNumber, $int_number);
    ?>
            $("#btnAddQtyNGOthers<?php echo trim($part->INT_NUMBER); ?>").click(function () {
                var partNo = '<?php echo trim($part->CHR_PART_NO); ?>';
                var qty = $("#qtyNGOthers<?php echo trim($part->INT_NUMBER); ?>").val();
                var reason_id = $("#b<?php echo $i; ?>").val();
                var reason = $("#b<?php echo $i; ?> option:selected").text();
                var date = $("#datepicker").val();
                var shift = '<?php echo $shift; ?>';
                var workCenter = '<?php echo $wcenter_l; ?>';
                var back_no = '<?php echo $part->CHR_BACK_NO; ?>';
                var part_name = '<?php echo $part->CHR_PART_NAME ?>';
                var PV = '';
                var iii = '<?php echo $i ?>';
                var int_number_ng = '<?php echo $part->INT_NUMBER ?>';
                
                if (qty == "") {
                    alert("Masukkan Qty Terlebih Dulu");
                }
                else
                {

//                    $.ajax({
//                        type: "POST",
//                        url: "<?php //echo site_url('pes_new/prodentry_c/check_status_interface'); ?>",
//                        dataType: 'json',
//                        data: "date=" + date + "&shift=" + shift + "&work_center=" + work_center,
//                        success: function (data) {
//                            if (data == 1) {
//                                alert('Saat ini data sedang dalam proses ke SAP, mohon tunggu sebentar untuk melakukan perubahan data');
//                            } else {
//                                console.log("SELECT * FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '" + date + "' AND CHR_SHIFT = '" + shift + "' AND CHR_WORK_CENTER = '" + work_center + "' AND (CHR_STATUS = '5' or CHR_STATUS_NG = '5')");
                                $.ajax({type: "POST",
                                    dataType: 'json',
                                    url: "<?php echo site_url('pes_new/inline_scan_c/addNgOthers'); ?>",
                                    data: "partNo=" + partNo + "&qty=" + qty + "&reason=" + reason + "&date=" + date + "&shift=" + shift + "&workCenter=" + workCenter + "&reason_id=" + reason_id + "&backNo=" + back_no + "&partName=" + part_name + "&PV=" + PV + "&iii=" + iii + "&int_number=" + int_number_ng,
                                    success: function (data) {
                                        $("#table_ng<?php echo trim($part->INT_NUMBER); ?>").html(data.a);
                                        $("#qty_ng_proses<?php echo trim($part->INT_NUMBER); ?>").val(data.b);
                                        findTotalNG_proses(<?php echo $i ?>);
                                    }
                                });
//                            }
//                        }
//                    });


                }
            });


            $("#btnNGDetailRefresh<?php echo trim($part->INT_NUMBER) ?>").click(function () {
                var partNo = '<?php echo trim($part->CHR_PART_NO); ?>';
                var date = $("#datepicker").val();
                var shift = '<?php echo $shift; ?>';
                var workCenter = '<?php echo $wcenter_l; ?>';
                var int_number_ng = '<?php echo $part->INT_NUMBER; ?>';

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pes_new/inline_scan_c/refreshTableNG'); ?>",
                    dataType: 'json',
                    data: "partNo=" + partNo + "&date=" + date + "&shift=" + shift + "&workCenter=" + workCenter + "&int_number=" + int_number_ng,
                    success: function (data) {
                        $("#table_ng<?php echo trim($part->INT_NUMBER); ?>").html(data.a);
                        $("#qty_ng_proses<?php echo trim($part->INT_NUMBER); ?>").val(data.b);
                        findTotalNG_proses(<?php echo $i ?>);
                    }
                });
            });

    <?php
    $i++;
endforeach;
?>

        $("#refreshListNGDetail").click(function () { //            var iii = $("#iii").val();
            var partNo = $("#partNoNg").val();
            var idPrd = $("#idPrd").val();
            var idNGCat = $("#idNGCat").val();
            var tableNG = "#table_ng" + iii;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pes_new/inline_scan_c/deleteNG'); ?>",
                data: "idPrd=" + idPrd + "&idNGCat=" + idNGCat + "&partNo=" + partNo, success: function (data) {
                    $("#btnNGDetailRefresh" + idPrd).click();
                }
            });

        });

        //add by toro 20170310
        $("#btn_submit_check").click(function () {
            var date = '<?php echo $date_l; ?>';
            var shift = '<?php echo $shift; ?>';
            var work_center = '<?php echo $wcenter_l; ?>';

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pes_new/prodentry_c/check_status_interface'); ?>",
                dataType: 'json',
                data: "date=" + date + "&shift=" + shift + "&work_center=" + work_center,
                success: function (data) {
                    if (data == 1) {
                        alert('Saat ini data sedang dalam proses ke SAP, mohon tunggu sebentar untuk melakukan perubahan data');
                    } else {
                        console.log("SELECT * FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '" + date + "' AND CHR_SHIFT = '" + shift + "' AND CHR_WORK_CENTER = '" + work_center + "' AND (CHR_STATUS = '5' or CHR_STATUS_NG = '5')")
                        document.getElementById("submit_save").click();
                    }
                }
            });

        });

    });
</script>
