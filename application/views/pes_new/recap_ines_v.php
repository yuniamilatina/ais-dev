<script>
    window.onload = function() {
        document.getElementById("hide-sub-menus").click();
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Recap In Line Scan Result</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title"><strong>RECAP IN LINE SCAN RESULT</strong></span>
                        <div class="pull-right grid-tools" style="font-size:11px;" >
                        </div>
                    </div>

                    <div class="grid-body">

						<div class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-sm-2 control-label">Tgl. Produksi / Work Center</label>
								<div class="col-sm-2">
									<input <?php echo ($set == 1 ? 'disabled' : '' ); ?>  type="text" onchange="changeDate()" class="form-control" id="datepicker" placeholder="DD/MM/YYYY" value="<?php echo $date; ?>"> 
								</div>
								<div class="col-sm-2">
									<select id="opt_wcenter" class="form-control" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                        <?php foreach ($wcenters as $wcenter): ?>
                                            <option <?php echo ($wcenter_l == trim($wcenter->CHR_WORK_CENTER)? 'selected' : ''); ?> value="<?php echo site_url('pes_new/inline_scan_c/recapReject/' . $date_l . '/' . $shift . '/' . trim($wcenter->CHR_WORK_CENTER) . '/' . $set); ?>"><?php echo trim($wcenter->CHR_WORK_CENTER); ?></option>
                                        <?php endforeach; ?>
                                    </select>
								</div>
								<div class="col-sm-4">
									<input type="submit" name="send" value="1" id="submit" class="<?php echo ($shift == '1' ? 'btn btn-primary btn-radius' : 'btn btn-default btn-radius') ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/recapReject/' . $date_l . '/1/' . $wcenter_l . '/' . $set) ?>';">
                                    <input type="submit" name="send" value="2" id="submit" class="<?php echo ($shift == '2' ? 'btn btn-primary btn-radius' : 'btn btn-default btn-radius') ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/recapReject/' . $date_l . '/2/' . $wcenter_l . '/' . $set) ?>';">
                                    <input type="submit" name="send" value="3" id="submit" class="<?php echo ($shift == '3' ? 'btn btn-primary btn-radius' : 'btn btn-default btn-radius') ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/recapReject/' . $date_l . '/3/' . $wcenter_l . '/' . $set) ?>';">
                                    <input type="submit" name="send" value="4" id="submit" class="<?php echo ($shift == '4' ? 'btn btn-primary btn-radius' : 'btn btn-default btn-radius') ?>" onClick="location.href = '<?php echo site_url('pes_new/inline_scan_c/recapReject/' . $date_l . '/4/' . $wcenter_l . '/' . $set) ?>';">
									<button type="submit" class="btn btn-primary btn-radius" name="send" id="submit" onClick="getLocation()"><i class="fa fa-<?php echo ($set == 1 ? 'lock':  'unlock'); ?>"></i><?php echo ($set == 1 ? ' Unlock':  ' Lock'); ?></button>
								</div>
								<div class="col-sm-2">
									<input id="search_back_number" class="form-control" type="text" name="name" placeholder="Search Back No">
								</div>
							</div>
							<div style="display:none;">
								<input type="text" id="idPrd" >
								<input type="text" id="idNGCat">
								<input type="text" id="partNoNg">
								<input type="text" id="iii">
								<span class="btn btn-primary" id="refreshListNGDetail" ></span>
							</div>
						</div>
                   

					<form action="" method="POST" onSubmit="return confirmAction()">

						<!-- <button class="btn btn-success" data-toggle="modal" data-target="#modalDefault" data-placement="left" data-toggle="tooltip" title="Add Part"><i class="fa fa-plus"></i>  Add Part</button> -->
						<!-- <input type="submit" name="save" class="btn btn-primary btn-lg btn-block" value='Save'> -->
					
                        <table class="table table-condensed table-striped" id="list_data">
                            <thead>
                                <tr>
                                    <th width="10px" rowspan="2" style="text-align:center;vertical-align:middle">ID</th>
                                    <th width="180px" rowspan="2" style="text-align:center;vertical-align:middle">P/N</th>
                                    <th width="70px" rowspan="2" style="text-align:center;vertical-align:middle">B/N</th>
                                    <th width="560px" rowspan="2" style="text-align:center;vertical-align:middle">P.Name & Model</th>
                                    <th width="560px" rowspan="2" style="text-align:center;vertical-align:middle">Scan Time</th>
                                    <th width="560px" rowspan="2" style="text-align:center;vertical-align:middle">Total OK</th>
                                    <th width="60px" colspan="4" style="text-align:center;vertical-align:middle">NG Detail</th>
                                    <th width="60px" rowspan="2" style="text-align:center;vertical-align:middle">Total</th>
                                    <th width="60px" rowspan="2" style="text-align:center;vertical-align:middle">Notes</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Proses</th>
                                    <th style="text-align:center;">B.Test</th>
                                    <th style="text-align:center;">Set Up / Mat. Asal</th>
                                    <th style="text-align:center;">Trial</th>
                                </tr>
                            </thead>

                            <tbody> 
                                <?php
                                $i = 1;
                                $arrayIntNumber = array();
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
                                                <td colspan="6"> Sub Total </td>
                                                <td><?php echo $resume_int_total_ng_process ?></td>
                                                <td><?php echo $resume_int_total_btest ?></td>
                                                <td><?php echo $resume_int_total_setup ?></td>
                                                <td><?php echo $resume_int_total_trial ?></td>
                                                <td style="text-align;right;"><?php echo $resume_int_total_prd ?></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $resume_int_total_ng_process = 0;
                                            $resume_int_total_btest = 0;
                                            $resume_int_total_setup = 0;
                                            $resume_int_total_trial = 0;
                                            $resume_int_total_prd = 0;
                                        }
                                    }
                                    $resume_int_total_ng_process += $part->INT_NG_PRC;
                                    $resume_int_total_btest += $part->INT_NG_BRKNTEST;
                                    $resume_int_total_setup += $part->INT_NG_SETUP;
                                    $resume_int_total_trial += $part->INT_NG_TRIAL;
                                    $resume_int_total_prd = $resume_int_total_ng_process + $resume_int_total_btest + $resume_int_total_setup + $resume_int_total_trial;
                                    $resume_per_row = $part->INT_NG_PRC + $part->INT_NG_BRKNTEST + $part->INT_NG_SETUP + $part->INT_NG_TRIAL;
                                    $first++;

                                    $partno_cek = $partno;
                                    ?>
                                
								<tr id="thisRow">
                                    <td><input style="border:none;background:transparent;width:55px;" type="text" readonly name="int_number[<?php echo $i; ?>]" value="<?php echo $part->INT_NUMBER; ?>" /> </td>
									<td><input style="border:none;background:transparent;width:90px;" type="text" readonly name="part_number[<?php echo $i; ?>]" value="<?php echo $partno; ?>" /></td>
                                	<td><input style="border:none;background:transparent;width:40px;" type="text" readonly name="back_number[<?php echo $i; ?>]" value="<?php echo $part->CHR_BACK_NO; ?>" /></td>
                                	<td><input style="border:none;background:transparent;width:200px;" type="text" readonly name="part_name[<?php echo $i; ?>]" value="<?php echo $part->CHR_PART_NAME; ?>" /></td>
                               		<td><?php echo date('H:i:s', strtotime($part->CHR_TIME_ENTRY)); ?></td>
                               		<td style="text-align:center;"><?php echo $part->INT_TOTAL_QTY; ?></td>
                                	<td>
										<input id="qty_ng_proses<?php echo $part->INT_NUMBER; ?>" autocomplete="off" data-toggle="tooltip" title="NG Proses" onblur="if (this.value == '') { this.value = '0'; }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_proses(<?php echo $i; ?>)" style="text-align:left;padding-right:0px;width:60px;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_proses[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_PRC, 0, ',', '.'); ?>" <?php echo ($set == '0' ? 'disabled' : '' ); ?>
										onfocus="if (this.value == '0') { this.value = ''; };
                                        document.getElementById('btnNGDetail<?php echo $i; ?>').click(); 
										document.getElementById('btnNGDetailRefresh<?php echo $part->INT_NUMBER; ?>').click();
                                        setTimeout(function () { document.getElementById('qtyNGOthers<?php echo $part->INT_NUMBER; ?>').click(); }, 3000);" 
										>
									</td>
                                	<td><input autocomplete="off" data-toggle="tooltip" title="NG B.test" onfocus="if (this.value == '0') { this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_btest(<?php echo $i; ?>)" style="text-align:left;padding-right:0px;width:60px;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_btest[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_BRKNTEST, 0, ',', '.'); ?>" <?php echo ($set == '0' ? 'disabled' : '' ); ?>></td>
                                	<td><input autocomplete="off" data-toggle="tooltip" title="NG Setup" onfocus="if (this.value == '0') { this.value = ''; }" onblur="if (this.value == '') {this.value = '0'; }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_setup(<?php echo $i; ?>)" style="text-align:left;padding-right:0px;width:60px;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_setup[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_SETUP, 0, ',', '.'); ?>" <?php echo ($set == '0' ? 'disabled' : '' ); ?>></td>
                                	<td><input autocomplete="off" data-toggle="tooltip" title="NG Trial" onfocus="if (this.value == '0') { this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }" onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_trial(<?php echo $i; ?>)" style="text-align:left;padding-right:0px;width:60px;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_trial[<?php echo $i; ?>]" value="<?php echo number_format($part->INT_NG_TRIAL, 0, ',', '.'); ?>" <?php echo ($set == '0' ? 'disabled' : '' ); ?>></td>
									<a style="display:none;" id="btnNGDetail<?php echo $i; ?>" data-toggle="modal" data-target="#modalPrimary<?php echo $i; ?>">btnNGDetail</a>
									<a style="display:none;" id="btnNGDetailRefresh<?php echo $part->INT_NUMBER; ?>" >btnNGDetailRefresh</a>
									<td><input autocomplete="off" style="text-align:center;padding-right:0px;width:60px;font-weight:bold;border:none;background:transparent" type="text" size="1" name="sum_qty[<?php echo $i; ?>]" id="sum_qty[<?php echo $i; ?>]" value="<?php echo $resume_per_row; ?>" readonly></td>
									<td><a data-toggle="modal" data-target="#comment_<?php echo $part->INT_NUMBER; ?>" onclick="get_notes_by_id(<?php echo $part->INT_NUMBER; ?>,'NG1')" data-placement="right" title="add Notes"><span class="fa fa-ellipsis-h"></span></a></td>
                                </tr>

                                	<?php
                                	$i++;
									if ($i == $num_part + 1) { ?>
										<tr id="thisRow">
											<td colspan="6" style="text-align:right;font-weight: bold;"> Sub Total </td>
											<td><?php echo $resume_int_total_ng_process ?></td>
											<td><?php echo $resume_int_total_btest ?></td>
											<td><?php echo $resume_int_total_setup ?></td>
											<td><?php echo $resume_int_total_trial ?></td>
											<td style="text-align;right;"><?php echo $resume_int_total_prd ?></td>
											<td></td>
										</tr>
										<?php
									}
                            	endforeach;
                            ?>
                            <tr style="background-color: #e7e7e7">
                                <td colspan="6" style="text-align:right;"> Total </td>
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
                                                <h4 class="modal-title" id="myModalLabel8"><span>NG Others</span><strong><?php echo trim($part->CHR_PART_NO); ?></strong><?php echo " - " . $part->CHR_PART_NAME; ?></h4>
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
                                                </div>
												<br />
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <div class="btn-group">
                                                            <span type="submit" class="btn btn-primary" id="btnAddQtyNGOthers<?php echo trim($part->INT_NUMBER); ?>">Add/Update</span>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

                            <?php
                            $j++;
                        endforeach;
                        ?>
                        <input type="hidden"  name="i" value="<?php echo $i - 1; ?>">
						<input type="submit" name="save" class="btn btn-primary btn-lg btn-block" value='Save'>

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
        document.getElementById("partNoNg").value = partNo;
        document.getElementById("refreshListNGDetail").click();
    }

    function getLocation() {
        var t = document.getElementById("opt_wcenter");
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
        if (<?php echo $set ?> == 0)
        {
            location.href = '<?php echo site_url() ?>/pes_new/inline_scan_c/recapReject/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/1'
        } else
        {
            location.href = '<?php echo site_url() ?>/pes_new/inline_scan_c/recapReject/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/0'
        }
    }

    function changeDate() {
        var t = document.getElementById("opt_wcenter");
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
        location.href = '<?php echo site_url() ?>/pes_new/inline_scan_c/recapReject/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/0'
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
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

    function findTotalNG_proses(arrPart) {
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
        var arrqty_ng_proses = document.getElementsByName('qty_ng_proses[' + arrPart + ']');
        var arrqty_ng_btest = document.getElementsByName('qty_ng_btest[' + arrPart + ']');
        var arrqty_ng_setup = document.getElementsByName('qty_ng_setup[' + arrPart + ']');
        var arrqty_ng_trial = document.getElementsByName('qty_ng_trial[' + arrPart + ']');
        var arrqty_ng_others = document.getElementsByName('qty_ng_others[' + arrPart + ']');
        tot = parseInt(arrqty_ng_proses[0].value.replace(".", "")) + parseInt(arrqty_ng_btest[0].value.replace(".", "")) + parseInt(arrqty_ng_setup[0].value.replace(".", "")) + parseInt(arrqty_ng_trial[0].value.replace(".", ""));
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

    var tot = 0;
    for (var i = 1; i <<?php echo $i; ?>; i++) {
        findTotalPart(i);
        var arr = document.getElementsByName('sum_qty[' + i + ']');
        if (parseInt(arr[0].value))
            tot += parseInt(arr[0].value);
    }
    document.getElementById('tot_sum_qty').value = tot;

	$(function () {
        $("#datepicker").datepicker({ 
            dateFormat: 'dd/mm/yy', 
            minDate: new Date("<?php echo "2022/03/25"; ?>"),
            maxDate: 'today',
            inline: true
        });
    });

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
                } else {
                	$.ajax({type: "POST",
                	    dataType: 'json',
                	    url: "<?php echo site_url('pes_new/inline_scan_c/addNgProcess'); ?>",
                	    data: "partNo=" + partNo + "&qty=" + qty + "&reason=" + reason + "&date=" + date + "&shift=" + shift + "&workCenter=" + workCenter + "&reason_id=" + reason_id + "&backNo=" + back_no + "&partName=" + part_name + "&PV=" + PV + "&iii=" + iii + "&int_number=" + int_number_ng,
                	    success: function (data) {
                	        $("#table_ng<?php echo trim($part->INT_NUMBER); ?>").html(data.a);
                	        $("#qty_ng_proses<?php echo trim($part->INT_NUMBER); ?>").val(data.b);
                	        findTotalNG_proses(<?php echo $i ?>);
                	    }
                	});
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
                    url: "<?php echo site_url('pes_new/inline_scan_c/inputNgProcess'); ?>",
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

        $("#refreshListNGDetail").click(function () { 
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

    });
</script>