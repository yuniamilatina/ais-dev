<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<script>
    // var tableToExcel = (function() {
    //     var uri = 'data:application/vnd.ms-excel;base64,',
    //         template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
    //         base64 = function(s) {
    //             return window.btoa(unescape(encodeURIComponent(s)))
    //         },
    //         format = function(s, c) {
    //             return s.replace(/{(\w+)}/g, function(m, p) {
    //                 return c[p];
    //             })
    //         }
    //     return function(table, name) {
    //         if (!table.nodeType)
    //             table = document.getElementById(table)
    //         var ctx = {
    //             worksheet: name || 'Sheet1',
    //             table: table.innerHTML
    //         }
    //         window.location.href = uri + base64(format(template, ctx))
    //     }
    // })()

    $(function() {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
    
    $(function() {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function() {
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function() {
        $( ".datepicker" ).datepicker();
    });
    
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/delivery/export_c/manage_invoice_peb') ?>"><strong>Manage Invoice and PEB</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>MANAGE INVOICE AND PEB NUMBER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <!-- <a href="<?php echo base_url('index.php/delivery/export_c/export_list/' . trim($start_date) . '/' . trim($end_date)) ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Report" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Export</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('delivery/export_c/search_manage_invoice_peb', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter' border=0px>                                
                                <tr>
                                    <td width="10%">Filter By</td>
                                    <td width="10%">
                                        <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_1" value="1" <?php if($type == '1'){ echo "checked"; } ?>> &nbsp; ID Pallet                                        
                                    </td>
                                    <td width="10%">
                                        <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_2" value="2" <?php if($type == '2'){ echo "checked"; } ?>> &nbsp; PO No
                                    </td>
                                    <td width="10%">
                                        <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_4" value="4" <?php if($type == '4'){ echo "checked"; } ?>> &nbsp; Invoice No
                                    </td>
                                    <td>
                                        <!-- <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_4" value="4"> &nbsp; PEB No -->
                                    </td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                </tr>
                                <tr align="left">
                                    <td>Delivery Date From</td>
                                    <td>
                                        <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4" style="width:170px;">
                                            <input type="text" name="date_from" class="form-control date-picker" id="datepicker" name="delivery_date" value="<?php echo date("d-m-Y", strtotime($start_date)) ?>" onchange="get_list_packing()">
                                            <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        </div>
                                    </td>
                                    <td>Delivery Date to</td>
                                    <td>
                                        <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4" style="width:170px;">
                                            <input type="text" name="date_to" class="form-control date-picker" id="datepicker1" name="delivery_date" value="<?php echo date("d-m-Y", strtotime($end_date)) ?>" onchange="get_list_packing()">
                                            <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Select Packing No</td>
                                    <td colspan="3">
                                        <select name="PACK_NO[]" multiple id="e1" class="form-control" style="width:500px" <?php if($type <> "1" ){ echo "disabled"; } ?>>;        
                                            <?php foreach ($list_pack_no as $pack) { ?>
                                                <option value="<?php echo trim($pack->CHR_IDPALLET); ?>" <?php if($list_pallet <> "") { for($i = 0; $i < count($list_pallet); $i++){ if(trim($list_pallet[$i]) == trim($pack->CHR_IDPALLET)){ echo "selected"; } } } ?>>
                                                    <?php echo trim($pack->CHR_IDPALLET); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Select PO No</td>
                                    <td colspan="3">
                                        <select name="PO_NO[]" multiple id="e2" class="form-control" style="width:500px" <?php if($type <> "2" ){ echo "disabled"; } ?>>;        
                                            <?php foreach ($list_po_no as $po) { ?>
                                                <option value="<?php echo trim($po->CHR_NOPO_CUST); ?>" <?php if($list_po <> "") { for($i = 0; $i < count($list_po); $i++){ if(trim($list_po[$i]) == trim($po->CHR_NOPO_CUST)){ echo "selected"; } } } ?>>
                                                    <?php echo trim($po->CHR_NOPO_CUST); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Select Invoice No</td>
                                    <td colspan="3">
                                        <select name="INV_NO[]" multiple id="e4" class="form-control" style="width:500px" <?php if($type <> "4" ){ echo "disabled"; } ?>>;        
                                            <?php foreach ($list_inv_no as $inv) { ?>
                                                <option value="<?php echo trim($inv->CHR_INVOICE_NO); ?>" <?php if($list_inv <> "") { for($i = 0; $i < count($list_inv); $i++){ if(trim($list_inv[$i]) == trim($inv->CHR_INVOICE_NO)){ echo "selected"; } } } ?>>
                                                <?php echo trim($inv->CHR_INVOICE_NO); ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <!-- <tr>
                                    <td>Select PEB No</td>
                                    <td colspan="3">
                                        <select name="PEB_NO[]" multiple id="e4" class="form-control" style="width:500px">;        
                                            <?php //foreach ($list_peb_no as $peb) { ?>
                                                <option value="<?php //echo trim($peb->CHR_PEB_NO); ?>"><?php echo trim($peb->CHR_PEB_NO); ?></option>
                                            <?php //} ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>-->
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" id="btn_filter" class="btn btn-info" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">No</th>
                                    <th rowspan="2" style="text-align:center;">ID Pallet</th>
                                    <th rowspan="2" style="text-align:center;">Part No</th>
                                    <th rowspan="2" style="text-align:center;">Back No</th>
                                    <th rowspan="2" style="text-align:center;">Part Name</th>
                                    <th rowspan="2" style="text-align:center;">Part No Cust</th>
                                    <th rowspan="2" style="text-align:center;">No PO</th>
                                    <th rowspan="2" style="text-align:center;">Invoice No
                                        <a data-toggle="modal" data-target="#modalEditInv_batch" class="label label-warning" title="Edit Invoice"><span class="fa fa-file-text-o"></span></a>
                                    </th>
                                    <th colspan="4" style="text-align:center;">PEB Information
                                        <a data-toggle="modal" data-target="#modalEditPeb_batch" class="label label-warning" title="Edit PEB"><span class="fa fa-truck"></span></a>
                                    </th>
                                    <th rowspan="2" style="text-align:center;">Customer</th>
                                    <th rowspan="2" style="text-align:center;">Qty/Box</th>
                                    <th rowspan="2" style="text-align:center;">Qty Box</th>
                                    <th rowspan="2" style="text-align:center;">Total Qty</th>
                                    <th rowspan="2" style="text-align:center;">Pallet Size</th>
                                    <!-- <th rowspan="2" style="text-align:center;">Shipmark</th> -->
                                    <th rowspan="2" style="text-align:center;">Country</th>                                    
                                    <th rowspan="2" style="text-align:center;">Action</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">PEB No</th>
                                    <th style="text-align:center;">Container No</th>
                                    <th style="text-align:center;">Vessel No</th>
                                    <th style="text-align:center;">Est Deliv Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    if($data != NULL){
                                        foreach ($data as $val) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $i . "</td>";
                                            echo "<td align='left'>" . $val->CHR_IDPALLET . "</td>";
                                            echo "<td align='left'>" . $val->CHR_PART_NO . "</td>";
                                            echo "<td align='center'>" . $val->CHR_BACK_NO . "</td>";
                                            echo "<td align='center'>" . $val->CHR_PART_NAME . "</td>";
                                            echo "<td align='left'>" . $val->CHR_PARTNO_CUST . "</td>";
                                            echo "<td align='left'>" . $val->CHR_NOPO_CUST . "</td>";
                                            echo "<td align='center'>" . $val->CHR_INVOICE_NO . "</td>";
                                            
                                            echo "<td align='center'>" . $val->CHR_PEB_NO . "</td>";
                                            echo "<td align='center'>" . $val->CHR_CONTAINER_NO . "</td>";
                                            echo "<td align='center'>" . $val->CHR_VESSEL_NO . "</td>";
                                            echo "<td align='center'>" . $val->CHR_DATE_DELIVERY_PEB . "</td>";
                                            
                                            echo "<td align='left'>" . $val->CHR_CUST_CODE . "</td>";
                                            echo "<td align='center'>" . $val->INT_QTY_PER_BOX . "</td>";
                                            echo "<td align='center'>" . $val->INT_QTY_PREPARE / $val->INT_QTY_PER_BOX . "</td>";
                                            echo "<td align='center'>" . $val->INT_QTY_PREPARE . "</td>";
                                            echo "<td align='center'>" . $val->CHR_PALLET_SIZE . "</td>";
                                            // echo "<td align='center'>" . $val->CHR_SHIPMARK . "</td>";
                                            echo "<td align='center'>" . $val->CHR_COUNTRY . "</td>";                                            
                                        ?>
                                            <td align='center'>
                                                <a data-toggle="modal" data-target="#modalEditInv_<?php echo trim($val->CHR_IDPALLET); ?>" data-placement="left" title="Edit Invoice" class="label label-warning"><span class="fa fa-file-text-o"></span></a>
                                                <a data-toggle="modal" data-target="#modalEditPeb_<?php echo trim($val->CHR_IDPALLET); ?>" data-placement="left" title="Edit Invoice" class="label label-warning"><span class="fa fa-truck"></span></a>
                                            </td>
                                        <?php
                                            echo "</tr>";
                                        $i++;
                                        } 
                                    }                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>            
            <!-- START MODAL -->                         
                <div class="modal fade" id="modalEditInv_batch" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="width:70%; display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Edit Invoice Batch by <?php if($type == '1'){ echo "ID Pallet"; } else if($type == '2'){ echo "PO Number"; } else { echo "Invoice Number"; } ?></strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Invoice No</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="invoice_batch" name="invoice_no" style="width:200px;" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" onclick="update_invBatch()" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalEditPeb_batch" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="width:70%; display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Edit Invoice & PEB No by <?php if($type == '1'){ echo "ID Pallet"; } else if($type == '2'){ echo "PO Number"; } else { echo "Invoice Number"; } ?></strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">PEB No</label>
                                        <div class="col-sm-5" style="align:center;">
                                            <input type="text" class="form-control" id="peb_batch" name="peb_no" style="width:300px;" value="" required>
                                        </div>
                                    </div>
                                    </br>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Container</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="container_batch" name="container_no" style="width:170px;" value="" required>
                                        </div>
                                    </div>
                                    </br>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Vessel No</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="vessel_batch" name="vessel_no" style="width:170px;" value="" required>
                                        </div>
                                    </div>
                                    </br>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Est Delivery Date</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control date-picker datepicker" id="date_peb_batch" name="date_peb" style="width:170px;" id="datepicker2" value="" required onchange="changeFormatDate_batch(this.value);">
                                        </div>
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" onclick="update_pebBatch()" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            <?php if($data != NULL){ 
                foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditInv_<?php echo trim($isi->CHR_IDPALLET); ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>Edit Invoice Number for Pallet : <?php echo trim($isi->CHR_IDPALLET); ?></strong></h4>
                                    </div>                                        
                                    <div class="modal-body">                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Invoice No</label>
                                            <div class="col-sm-5">
                                                <input type="text" id="invoice_<?php echo trim($isi->CHR_IDPALLET); ?>" name="INVOICE" class="form-control" value="<?php echo trim($isi->CHR_INVOICE_NO) ?>" required>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" onclick="update_inv('<?php echo trim($isi->CHR_IDPALLET); ?>');" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php } 
                }
            ?>
            <?php if($data != NULL){ 
                foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditPeb_<?php echo trim($isi->CHR_IDPALLET); ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>Edit PEB Number for Pallet : <?php echo trim($isi->CHR_IDPALLET); ?></strong></h4>
                                    </div>                                        
                                    <div class="modal-body">                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">PEB No</label>
                                            <div class="col-sm-5">
                                                <input type="text" id="peb_<?php echo trim($isi->CHR_IDPALLET); ?>" name="PEB" class="form-control" style="width:300px;" value="<?php echo trim($isi->CHR_PEB_NO) ?>" required>
                                            </div>
                                        </div>
                                        </br>
                                        <div>&nbsp;</div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Container No</label>
                                            <div class="col-sm-5">
                                                <input type="text" id="container_<?php echo trim($isi->CHR_IDPALLET); ?>" name="CONTAINER" class="form-control" style="width:170px;" value="<?php echo trim($isi->CHR_CONTAINER_NO) ?>" required>
                                            </div>
                                        </div>
                                        </br>
                                        <div>&nbsp;</div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Vessel No</label>
                                            <div class="col-sm-5">
                                                <input type="text" id="vessel_<?php echo trim($isi->CHR_IDPALLET); ?>" name="VESSEL" class="form-control" style="width:170px;" value="<?php echo trim($isi->CHR_VESSEL_NO) ?>" required>
                                            </div>
                                        </div>
                                        </br>
                                        <div>&nbsp;</div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Est Delivery Date</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control date-picker datepicker" name="DATE_PEB" id="date_peb_<?php echo trim($isi->CHR_IDPALLET); ?>" style="width:170px;" value="<?php echo date("d-m-Y", strtotime($isi->CHR_DATE_DELIVERY_PEB)) ?>" required onchange="changeFormatDate(this.value, '<?php echo trim($isi->CHR_IDPALLET); ?>');">
                                            </div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" onclick="update_peb('<?php echo trim($isi->CHR_IDPALLET); ?>');" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
            <?php } 
                }
            ?>
            <!-- END MODAL -->
        </div>
        <!-- SUMMARY DELIVERY -->        
        <div class="row" style="display:none;">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>SUMMARY DELIVERY EXPORT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>                            
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables2" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Part No Cust</th>
                                    <th style="text-align:center;">Part Name</th>
                                    <!-- <th style="text-align:center;">Customer</th> -->
                                    <th style="text-align:center;">Qty/Box</th>
                                    <th style="text-align:center;">Qty Pcs</th>
                                    <th style="text-align:center;">Qty Box</th> 
                                    <th style="text-align:center;">Unit Price</th> 
                                    <th style="text-align:center;">Amount Price</th>
                                    <th style="text-align:center;">Unit Price (IDR)</th> 
                                    <th style="text-align:center;">Amount Price (IDR)</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    if($data_summ_part != NULL){   
                                        $sum_pcs = 0;
                                        $sum_box = 0;   
                                        $sum_price = 0;
                                        $sum_price_idr = 0;                                  
                                        foreach ($data_summ_part as $summ) {
                                            $curr = '';
                                            $price_per_unit = 0;
                                            $price_per_unit_idr = 0;
                                            foreach($data as $val){
                                                if($val->CHR_PART_NO == $summ->CHR_PART_NO){    
                                                    $packno = trim($val->CHR_IDPALLET);
                                                    $partno = trim($val->CHR_PART_NO);
                                                    $custcode = substr($val->CHR_CUST_CODE,0,5);
                                                    // $get_price = $this->db->query("EXEC zsp_get_selling_price_by_partno_and_custcode '$partno', '$custcode'");
                                                    $get_price = $this->db->query("EXEC zsp_get_selling_price_by_packno_and_partno '$packno', '$partno' , '', ''");
                                                    if($get_price->num_rows() > 0){
                                                        $data_price = $get_price->row();
                                                        $price_unit = $data_price->MON_AMOUNT;
                                                        $unit = $data_price->INT_UNIT;
                                                        $curr = $data_price->CHR_CURRENCY;
                                                        $price_per_unit = ($price_unit / $unit);                                                        
                                                        $price_per_unit_idr = ($data_price->MON_AMOUNT_IDR / $unit);
                                                    }
                                                }
                                            }  
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $i . "</td>";
                                            echo "<td align='left'>" . $summ->CHR_PART_NO . "</td>";
                                            echo "<td align='center'>" . $summ->CHR_BACK_NO . "</td>";
                                            echo "<td align='left'>" . $summ->CHR_PARTNO_CUST . "</td>";
                                            echo "<td align='left'>" . $summ->PART_NAME . "</td>";
                                            // echo "<td align='center'>" . $summ->CHR_CUST_CODE . "</td>";                                            
                                            echo "<td align='center'>" . $summ->INT_QTY_PER_BOX . "</td>";
                                            echo "<td align='center'>" . number_format($summ->QTY_PCS,0,',','.') . " PCS</td>";
                                            echo "<td align='center'>" . number_format(($summ->QTY_BOX),0,',','.') . " CTN</td>";
                                            
                                            $amo_price = $price_per_unit * $summ->QTY_PCS;
                                            $amo_price_idr = $price_per_unit_idr * $summ->QTY_PCS;
                                            echo "<td align='right'>" . $curr . " " . number_format($price_per_unit,2,',','.') . "</td>";
                                            echo "<td align='right'>" . $curr . " " . number_format($amo_price,2,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($price_per_unit_idr,2,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($amo_price_idr,2,',','.') . "</td>";
                                            
                                            $sum_pcs = $sum_pcs + $summ->QTY_PCS;
                                            $sum_box = $sum_box + $summ->QTY_BOX; 
                                            $sum_price = $sum_price + $amo_price;
                                            $sum_price_idr = $sum_price_idr + $amo_price_idr;                                                                                       
                                            echo "</tr>";  
                                            $i++;                                        
                                        }
                                        echo "<tr style='background-color:yellow;font-weight:bold;'>";
                                        echo "<td colspan='6' align='right'>TOTAL</td>";
                                        echo "<td align='center'>" . number_format($sum_pcs,0,',','.') . " PCS</td>";
                                        echo "<td align='center'>" . number_format($sum_box,0,',','.') . " CTN</td>"; 
                                        echo "<td align='right'></td>"; 
                                        echo "<td align='right'>" . $curr . " " . number_format($sum_price,2,',','.') . "</td>";
                                        echo "<td align='right'></td>";
                                        echo "<td align='right'>" . number_format($sum_price_idr,2,',','.') . "</td>"; 

                                        echo "</tr>";
                                    }                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Pallet No</th>
                                    <th style="text-align:center;">ID Pallet</th>
                                    <th style="text-align:center;">Part No AII</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Part Name</th>
                                    <th style="text-align:center;">Part No Cust</th>
                                    <th style="text-align:center;">Qty/Box</th>
                                    <th style="text-align:center;">Qty Pcs</th>
                                    <th style="text-align:center;">Qty Box</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    $sum_all_pcs = 0;
                                    $sum_all_box = 0;
                                    if($data_selected_pallet != NULL){
                                        foreach ($data_selected_pallet as $pall){
                                            $sum_pcs = 0;
                                            $sum_box = 0;
                                            foreach ($data as $val) {
                                                if($val->CHR_IDPALLET == $pall->CHR_IDPALLET){
                                                    echo "<tr class='gradeX'>";
                                                    echo "<td align='center'>" . $i . "</td>";
                                                    echo "<td align='left'>" . $pall->CHR_IDPALLET . "</td>";
                                                    echo "<td align='left'>" . $val->CHR_PART_NO . "</td>";
                                                    echo "<td align='left'>" . $val->CHR_BACK_NO . "</td>";
                                                    echo "<td align='left'>" . $val->CHR_PART_NAME . "</td>";
                                                    echo "<td align='left'>" . $val->CHR_PARTNO_CUST . "</td>";
                                                    echo "<td align='center'>" . $val->INT_QTY_PER_BOX . " PCS</td>";
                                                    echo "<td align='center'>" . $val->INT_QTY_PREPARE . " PCS</td>";
                                                    echo "<td align='center'>" . $val->INT_QTY_PREPARE / $val->INT_QTY_PER_BOX . " CTN</td>";
                                                    echo "</tr>";
                                                    $sum_box = $sum_box + ($val->INT_QTY_PREPARE / $val->INT_QTY_PER_BOX);  
                                                    $sum_pcs = $sum_pcs + $val->INT_QTY_PREPARE;                                            
                                                }
                                            }
                                            echo "<tr style='background-color:whitesmoke;font-weight:bold;'>";
                                            echo "<td colspan='7' align='right'>TOTAL</td>";
                                            echo "<td align='center'>" . $sum_pcs . " PCS</td>";
                                            echo "<td align='center'>" . $sum_box . " CTN</td>";
                                            echo "</tr>";
                                            $sum_all_pcs = $sum_all_pcs + $sum_pcs;
                                            $sum_all_box = $sum_all_box + $sum_box;
                                            $i++;
                                        }
                                        echo "<tr style='background-color:yellow;font-weight:bold;'>";
                                        echo "<td align='center'>" . ($i-1) . " PALLET</td>";
                                        echo "<td colspan='6' align='right'>TOTAL ALL PALLET</td>";
                                        echo "<td align='center'>" . $sum_all_pcs . " PCS</td>";
                                        echo "<td align='center'>" . $sum_all_box . " CTN</td>";
                                        echo "</tr>";
                                    }                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- SUMMARY DELIVERY -->
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
            ,fixedColumns: {
                rightColumns: 1,
                leftColumns: 5
            }
        });
    });

    function get_list_packing() {
        var date_from = document.getElementById('datepicker').value;
        var date_to = document.getElementById('datepicker1').value;
        var type_filter = '<?php echo $type; ?>';

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('delivery/export_c/get_list_packing'); ?>",
            data: "date_start=" + date_from + "&date_end=" + date_to + "&type=" + type_filter,
            success: function(json_data) {
                if(type_filter == '1'){
                    $("#e1").html(json_data['data']);
                } else if(type_filter == '2'){
                    $("#e2").html(json_data['data']);
                } else if(type_filter == '4'){
                    $("#e4").html(json_data['data']);
                }                
            },
            error: function(request) {
                alert(request.responseText);
            }
        });        
    }

    function CheckInput() {
        if (document.getElementById('inp_1').checked) {
            document.getElementById('e1').disabled = false;
            document.getElementById('e2').disabled = true;
            document.getElementById('e4').disabled = true;
        } else if (document.getElementById('inp_2').checked){
            document.getElementById('e1').disabled = true;
            document.getElementById('e2').disabled = false;
            document.getElementById('e4').disabled = true;
        } else if (document.getElementById('inp_4').checked){
            document.getElementById('e1').disabled = true;
            document.getElementById('e2').disabled = true;
            document.getElementById('e4').disabled = false;
        }

        get_list_packing()
    }

    function changeFormatDate(oldDate, pallNo){
        var newDate = oldDate.substring(3,5) + '-' + oldDate.substring(0,2) + '-' + oldDate.substring(6,10);
        document.getElementById("date_peb_" + pallNo).value = newDate; 
    }

    function changeFormatDate_batch(oldDate){
        var newDate = oldDate.substring(3,5) + '-' + oldDate.substring(0,2) + '-' + oldDate.substring(6,10);
        document.getElementById("date_peb_batch").value = newDate; 
    }

    function update_inv(palletNo) {
        var inv = document.getElementById('invoice_' + palletNo).value;
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('delivery/export_c/update_data_inv_by_id_pallet'); ?>",
            data: "pallet_id=" + palletNo + "&invoice=" + inv,
            success: function(json_data) {
                document.getElementById('btn_filter').click();
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
        
    }

    function update_invBatch() {
        var date_from = document.getElementById('datepicker').value;
        var date_to = document.getElementById('datepicker1').value;
        var invoice_no = document.getElementById('invoice_batch').value;
        var type_filter = '<?php echo $type; ?>';
        var list_param = [];

        if(type_filter == '1'){
            for(var option of document.getElementById('e1').options){
                if(option.selected){
                    list_param.push(option.value);
                }
            }
        } else if(type_filter == '2') {
            for(var option of document.getElementById('e2').options){
                if(option.selected){
                    list_param.push(option.value);
                }
            }
        } else if(type_filter == '4') {
            for(var option of document.getElementById('e4').options){
                if(option.selected){
                    list_param.push(option.value);
                }
            }            
        }

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('delivery/export_c/update_data_inv_batch'); ?>",
            data: "date_start=" + date_from + "&date_end=" + date_to + "&type=" + type_filter + "&data_param=" + list_param + "&inv_no=" + invoice_no,
            success: function(json_data) {
                document.getElementById('btn_filter').click();
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
        
    }

    function update_peb(palletNo) {
        var peb_no = document.getElementById('peb_' + palletNo).value;
        var cont_no = document.getElementById('container_' + palletNo).value;
        var vess_no = document.getElementById('vessel_' + palletNo).value;
        var del_peb = document.getElementById('date_peb_' + palletNo).value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('delivery/export_c/update_data_peb_by_id_pallet'); ?>",
            data: "pallet_id=" + palletNo + "&peb_id=" + peb_no + "&container_id=" + cont_no + "&vessel_id=" + vess_no + "&del_peb=" + del_peb,
            success: function(json_data) {
                document.getElementById('btn_filter').click();
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
        
    }

    function update_pebBatch() {
        var date_from = document.getElementById('datepicker').value;
        var date_to = document.getElementById('datepicker1').value;
        var peb_batch = document.getElementById('peb_batch').value;
        var cont_batch = document.getElementById('container_batch').value;
        var vess_batch = document.getElementById('vessel_batch').value;
        var date_batch = document.getElementById('date_peb_batch').value;
        var type_filter = '<?php echo $type; ?>';
        var list_param = [];

        if(type_filter == '1'){
            for(var option of document.getElementById('e1').options){
                if(option.selected){
                    list_param.push(option.value);
                }
            }
        } else if(type_filter == '2') {
            for(var option of document.getElementById('e2').options){
                if(option.selected){
                    list_param.push(option.value);
                }
            }
        } else if(type_filter == '4') {
            for(var option of document.getElementById('e4').options){
                if(option.selected){
                    list_param.push(option.value);
                }
            }            
        }

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('delivery/export_c/update_data_peb_batch'); ?>",
            data: "date_start=" + date_from + "&date_end=" + date_to + "&type=" + type_filter + "&data_param=" + list_param + "&peb_id=" + peb_batch + "&container_id=" + cont_batch + "&vessel_id=" + vess_batch + "&del_peb=" + date_batch,
            success: function(json_data) {
                document.getElementById('btn_filter').click();
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
        
    }
</script>