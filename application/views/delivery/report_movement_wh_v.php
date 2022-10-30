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
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Sheet1',
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()

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
            <li><a href="<?php echo base_url('index.php/delivery/export_c/report_movement_wh') ?>"><strong>Report Movement Warehouse</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-cubes"></i>
                        <span class="grid-title"><strong>REPORT MOVEMENT WAREHOUSE</strong></span>
                        <div class="pull-right grid-tools">                            
                            <!-- <a href="<?php echo base_url('index.php/delivery/export_c/export_movement_wh/' . trim($start_date) . '/' . trim($end_date)) ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Report" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Export</a> -->
                            <input type="button" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;" onclick="tableToExcel('exportToExcel', 'report_history_movement_wh')" value="Export to Excel"><i class="fa fa-download-up"></i></input>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('delivery/export_c/search_report_movement_wh', 'class="form-horizontal"'); ?>
                            <table width="50%" id='filter' border=0px>                                
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
                                    <td>
                                    <button type="submit" id="btn_filter" class="btn btn-info" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
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
                                    <th rowspan="2" style="text-align:center;">Pallet WH</th>
                                    <th rowspan="2" style="text-align:center;">PO No</th>
                                    <th rowspan="2" style="text-align:center;">Packing</th>
                                    <th rowspan="2" style="text-align:center;">Pallet No</th>
                                    <th rowspan="2" style="text-align:center;">Part No</th>
                                    <th rowspan="2" style="text-align:center;">Back No</th>
                                    <th rowspan="2" style="text-align:center;">Part Name</th>
                                    <th rowspan="2" style="text-align:center;">Part No Cust</th>
                                    <th rowspan="2" style="text-align:center;">Qty Box</th>
                                    <th rowspan="2" style="text-align:center;">Qty/Box</th>                                    
                                    <th rowspan="2" style="text-align:center;">Total Qty</th>
                                    <!-- <th rowspan="2" style="text-align:center;">Pallet Size</th> -->
                                    <th colspan="4" style="text-align:center;">Data OUT</th>
                                    <th colspan="4" style="text-align:center;">Data IN</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Date Time</th>
                                    <th style="text-align:center;">Sloc From-To</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">SAP</th>
                                    <th style="text-align:center;">Date Time</th>
                                    <th style="text-align:center;">Sloc From-To</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">SAP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    if($data->num_rows() > 0){
                                        foreach ($data->result() as $val) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $i . "</td>";
                                            echo "<td align='center'>" . trim($val->CHR_IDPALLET_WH) . "</td>";
                                            echo "<td align='center'>" . trim($val->CHR_NOPO_CUST) . "</td>";
                                            echo "<td align='center'>" . $val->CHR_IDPACKING . "</td>";
                                            
                                            $get_tot_pallet = $this->db->query("SELECT TOP 1 INT_NOPALLET FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$val->CHR_IDPACKING' ORDER BY INT_NOPALLET DESC")->row();
                                            $tot_pallet = $get_tot_pallet->INT_NOPALLET;

                                            echo "<td align='center'>" . $val->INT_NOPALLET . '/' . $tot_pallet . "</td>";
                                            echo "<td align='center'>" . $val->CHR_PART_NO . "</td>";
                                            echo "<td align='center'>" . $val->CHR_BACK_NO . "</td>";
                                            echo "<td align='center'>" . trim($val->CHR_PART_NAME) . "</td>";
                                            echo "<td align='center'>" . trim($val->CHR_PARTNO_CUST) . "</td>";
                                            echo "<td align='center'>" . $val->INT_QTY_PREPARE / $val->INT_QTY_PER_BOX . "</td>";
                                            echo "<td align='center'>" . $val->INT_QTY_PER_BOX . "</td>";                                            
                                            echo "<td align='center'>" . $val->INT_QTY_PREPARE . "</td>";
                                            // echo "<td align='center'>" . $val->CHR_PALLET_SIZE . "</td>";
                                            echo "<td align='center'>" . substr($val->DATE_OUT,6,2) . '/' . substr($val->DATE_OUT,4,2) . '/' . substr($val->DATE_OUT,0,4) . ' ' . substr($val->TIME_OUT,0,2) . ':' . substr($val->TIME_OUT,2,2) . "</td>";
                                            echo "<td align='center'>" . $val->SLOC_FROM_OUT . ' - ' . $val->SLOC_TO_OUT . "</td>";
                                            if($val->FLG_MOVE_OUT == '0'){
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'><span style='color:green;' class='fa fa-check-circle'></td>";
                                                $id_out = $val->ID_MOVE_OUT;
                                                if($id_out != NULL){
                                                    $check_iface = $this->db->query("SELECT CHR_UPLOAD, CHR_STATUS, CHR_MESSAGE FROM TT_GOODS_MOVEMENT_L WHERE INT_NUMBER = '$id_out'")->row();
                                                    if($check_iface->CHR_UPLOAD == '1'){
                                                        if($check_iface->CHR_STATUS == 'S'){
                                                            echo "<td align='center'><span style='color:green;' data-toggle='tooltip' title='" . $check_iface->CHR_MESSAGE . "' class='fa fa-check-circle'></td>";
                                                        } else {
                                                            echo "<td align='center'><span style='color:red;' data-toggle='tooltip' title='" . $check_iface->CHR_MESSAGE . "' class='fa fa-times-circle'></td>";
                                                        }                                                        
                                                    } else {
                                                        if($check_iface->CHR_STATUS == 'E'){
                                                            echo "<td align='center'><span style='color:red;' data-toggle='tooltip' title='" . $check_iface->CHR_MESSAGE . "' class='fa fa-times-circle'></td>";
                                                        } else {
                                                            echo "<td align='center'><span style='color:orange;' class='fa fa-warning'></td>";
                                                        } 
                                                    }                                                    
                                                } else {                                                    
                                                    echo "<td align='center'>-</td>";
                                                }   
                                            }

                                            if($val->DATE_IN != NULL){
                                                echo "<td align='center'>" . substr($val->DATE_IN,6,2) . '/' . substr($val->DATE_IN,4,2) . '/' . substr($val->DATE_IN,0,4) . ' ' . substr($val->TIME_IN,0,2) . ':' . substr($val->TIME_IN,2,2) . "</td>";
                                                echo "<td align='center'>" . $val->SLOC_FROM_IN . ' - ' . $val->SLOC_TO_IN . "</td>";
                                                if($val->FLG_MOVE_IN == '0'){
                                                    echo "<td align='center'>-</td>";
                                                    echo "<td align='center'>-</td>";
                                                } else {
                                                    echo "<td align='center'><span style='color:green;' class='fa fa-check-circle'></td>";
                                                    $id_in = $val->ID_MOVE_IN;
                                                    if($id_in != NULL){
                                                        $check_iface = $this->db->query("SELECT CHR_UPLOAD, CHR_STATUS, CHR_MESSAGE FROM TT_GOODS_MOVEMENT_L WHERE INT_NUMBER = '$id_in'")->row();
                                                        if($check_iface->CHR_UPLOAD == '1'){
                                                            if($check_iface->CHR_STATUS == 'S'){
                                                                echo "<td align='center'><span style='color:green;' data-toggle='tooltip' title='" . $check_iface->CHR_MESSAGE . "' class='fa fa-check-circle'></td>";
                                                            } else {
                                                                echo "<td align='center'><span style='color:red;' data-toggle='tooltip' title='" . $check_iface->CHR_MESSAGE . "' class='fa fa-times-circle'></td>";
                                                            }                                                        
                                                        } else {
                                                            if($check_iface->CHR_STATUS == 'E'){
                                                                echo "<td align='center'><span style='color:red;' data-toggle='tooltip' title='" . $check_iface->CHR_MESSAGE . "' class='fa fa-times-circle'></td>";
                                                            } else {
                                                                echo "<td align='center'><span style='color:orange;' class='fa fa-warning'></td>";
                                                            } 
                                                        }                                                     
                                                    } else {                                                    
                                                        echo "<td align='center'>-</td>";
                                                    }
                                                }
                                            } else {
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "</tr>";                                            
                                        $i++;
                                        } 
                                    }                                    
                                ?>
                            </tbody>
                        </table>
                        <table id="exportToExcel" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">No</th>
                                    <th rowspan="2" style="text-align:center;">Pallet WH</th>
                                    <th rowspan="2" style="text-align:center;">PO No</th>
                                    <th rowspan="2" style="text-align:center;">Packing</th>
                                    <th colspan="3" style="text-align:center;">Pallet Detail</th>
                                    <th rowspan="2" style="text-align:center;">Est Date</th>
                                    <th rowspan="2" style="text-align:center;">Part No</th>
                                    <th rowspan="2" style="text-align:center;">Back No</th>
                                    <th rowspan="2" style="text-align:center;">Part Name</th>
                                    <th rowspan="2" style="text-align:center;">Part No Cust</th>                                    
                                    <th rowspan="2" style="text-align:center;">Qty Box</th>
                                    <th rowspan="2" style="text-align:center;">Qty/Box</th>
                                    <th rowspan="2" style="text-align:center;">Total Qty</th>
                                    <!-- <th rowspan="2" style="text-align:center;">Pallet Size</th> -->
                                    <th colspan="4" style="text-align:center;">Data OUT</th>
                                    <th colspan="4" style="text-align:center;">Data IN</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Pallet No</th>
                                    <th style="text-align:center;">From</th>
                                    <th style="text-align:center;">Total Pallet</th>
                                    <th style="text-align:center;">Date Time</th>
                                    <th style="text-align:center;">Sloc From-To</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">SAP</th>
                                    <th style="text-align:center;">Date Time</th>
                                    <th style="text-align:center;">Sloc From-To</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">SAP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    if($data->num_rows() > 0){
                                        foreach ($data->result() as $val) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $i . "</td>";
                                            echo "<td align='left'>" . trim($val->CHR_IDPALLET_WH) . "</td>";
                                            echo "<td align='left'>" . trim($val->CHR_NOPO_CUST) . "</td>";
                                            echo "<td align='center'>" . $val->CHR_IDPACKING . "</td>";

                                            $get_tot_pallet = $this->db->query("SELECT TOP 1 INT_NOPALLET FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$val->CHR_IDPACKING' ORDER BY INT_NOPALLET DESC")->row();
                                            $tot_pallet = $get_tot_pallet->INT_NOPALLET;

                                            echo "<td align='center'>" . $val->INT_NOPALLET . "</td>";
                                            echo "<td align='center'>/</td>";
                                            echo "<td align='center'>" . $tot_pallet . "</td>";
                                            echo "<td align='center'>" . substr($val->CHR_DATE_DELIVERY,6,2) . '/' . substr($val->CHR_DATE_DELIVERY,4,2) . '/' . substr($val->CHR_DATE_DELIVERY,0,4) . "</td>";
                                            echo "<td align='left'>" . $val->CHR_PART_NO . "</td>";
                                            echo "<td align='center'>" . $val->CHR_BACK_NO . "</td>";
                                            echo "<td align='center'>" . trim($val->CHR_PART_NAME) . "</td>";
                                            echo "<td align='left'>" . trim($val->CHR_PARTNO_CUST) . "</td>";
                                            echo "<td align='center'>" . $val->INT_QTY_PREPARE / $val->INT_QTY_PER_BOX . "</td>";
                                            echo "<td align='center'>" . $val->INT_QTY_PER_BOX . "</td>";                                            
                                            echo "<td align='center'>" . $val->INT_QTY_PREPARE . "</td>";
                                            // echo "<td align='center'>" . $val->CHR_PALLET_SIZE . "</td>";
                                            echo "<td align='center'>" . substr($val->DATE_OUT,6,2) . '/' . substr($val->DATE_OUT,4,2) . '/' . substr($val->DATE_OUT,0,4) . ' ' . substr($val->TIME_OUT,0,2) . ':' . substr($val->TIME_OUT,2,2) . "</td>";
                                            echo "<td align='center'>" . $val->SLOC_FROM_OUT . ' - ' . $val->SLOC_TO_OUT . "</td>";
                                            if($val->FLG_MOVE_OUT == '0'){
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'>OK</td>";
                                                $id_out = $val->ID_MOVE_OUT;
                                                if($id_out != NULL){
                                                    $check_iface = $this->db->query("SELECT CHR_UPLOAD, CHR_STATUS, CHR_MESSAGE FROM TT_GOODS_MOVEMENT_L WHERE INT_NUMBER = '$id_out'")->row();
                                                    if($check_iface->CHR_UPLOAD == '1'){
                                                        if($check_iface->CHR_STATUS == 'S'){
                                                            echo "<td align='center'>OK</td>";
                                                        } else {
                                                            echo "<td align='center'>Err</td>";
                                                        }                                                        
                                                    } else {
                                                        if($check_iface->CHR_STATUS == 'E'){
                                                            echo "<td align='center'>Err</td>";
                                                        } else {
                                                            echo "<td align='center'>Wait</td>";
                                                        }
                                                    }                                                    
                                                } else {                                                    
                                                    echo "<td align='center'>-</td>";
                                                }   
                                            }

                                            if($val->DATE_IN != NULL){
                                                echo "<td align='center'>" . substr($val->DATE_IN,6,2) . '/' . substr($val->DATE_IN,4,2) . '/' . substr($val->DATE_IN,0,4) . ' ' . substr($val->TIME_IN,0,2) . ':' . substr($val->TIME_IN,2,2) . "</td>";
                                                echo "<td align='center'>" . $val->SLOC_FROM_IN . ' - ' . $val->SLOC_TO_IN . "</td>";
                                                if($val->FLG_MOVE_IN == '0'){
                                                    echo "<td align='center'>-</td>";
                                                    echo "<td align='center'>-</td>";
                                                } else {
                                                    echo "<td align='center'>OK</td>";
                                                    $id_in = $val->ID_MOVE_IN;
                                                    if($id_in != NULL){
                                                        $check_iface = $this->db->query("SELECT CHR_UPLOAD, CHR_STATUS, CHR_MESSAGE FROM TT_GOODS_MOVEMENT_L WHERE INT_NUMBER = '$id_in'")->row();
                                                        if($check_iface->CHR_UPLOAD == '1'){
                                                            if($check_iface->CHR_STATUS == 'S'){
                                                                echo "<td align='center'>OK</td>";
                                                            } else {
                                                                echo "<td align='center'>Err</td>";
                                                            }                                                        
                                                        } else {
                                                            if($check_iface->CHR_STATUS == 'E'){
                                                                echo "<td align='center'>Err</td>";
                                                            } else {
                                                                echo "<td align='center'>Wait</td>";
                                                            }
                                                        }                                                    
                                                    } else {                                                    
                                                        echo "<td align='center'>-</td>";
                                                    }
                                                }
                                            } else {
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "</tr>";                                            
                                        $i++;
                                        } 
                                    }                                    
                                ?>
                            </tbody>
                        </table>
                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d : </strong></td>
                                    <td width="10%">
                                        <button disabled class="btn btn-default">PP*</button> : Aisin
                                    </td>
                                    <td width="10%">
                                        <button disabled class="btn btn-default">WH30</button> : SGL
                                    </td>
                                    <td width="10%">
                                        <button disabled class="btn btn-default">WH20</button> : Multisarana
                                    </td>
                                    <td width="10%">
                                        <button disabled class="btn btn-default">WH10</button> : Yusen
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        document.body.style.zoom = 0.90;

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
                leftColumns: 2,
                rightColumns: 8
            }
        });
    });

    function changeFormatDate(oldDate, pallNo){
        var newDate = oldDate.substring(3,5) + '-' + oldDate.substring(0,2) + '-' + oldDate.substring(6,10);
        document.getElementById("date_peb_" + pallNo).value = newDate; 
    }

    function changeFormatDate_batch(oldDate){
        var newDate = oldDate.substring(3,5) + '-' + oldDate.substring(0,2) + '-' + oldDate.substring(6,10);
        document.getElementById("date_peb_batch").value = newDate; 
    }
</script>