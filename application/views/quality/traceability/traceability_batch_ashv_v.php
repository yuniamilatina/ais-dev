<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/tracebility_c') ?>"><strong>Report Traceability</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>REPORT TRACEABILITY</strong></span>
                        <div class="pull-right grid-tools">
                           <!-- <a href="<?php echo base_url('index.php/prd/tracebility_c/export_report_traceability/' . trim($start_date) . '/' . trim($end_date) . '/' . trim($part_no)) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Report" style="height:30px;font-size:13px;width:120px;color:white;margin-top:-5px;margin-bottom:-5px;"><span class='fa fa-print'></span>Rekap AIIA</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('prd/tracebility_c/search_traceability_batch_data', 'class="form-horizontal"'); ?>                            
                            <table width=100% id='filter'>    
                                <tr>
                                    <td width="5%">Dept</td>                                        
                                    <td width="5%" colspan="4">
                                        <select name="INT_ID_DEPT" id="dept_to_work_center" onchange="get_data_work_center();" class="ddl2" style="width:150px;">
                                                <?php
                                                foreach ($all_dept_prod as $row) {
                                                    if (trim($row->INT_ID_DEPT) == trim($id_dept)) {
                                                        ?>
                                                        <option selected value="<? echo $id_dept; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                    <?php } else { ?>
                                                        <option value="<? echo $row->INT_ID_DEPT; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="60%"></td>
                                    <td width="25%"></td>
                                </tr>                          
                                <tr>
                                    <td width="5%">Work Center</td>                                        
                                    <td width="5%" colspan="4">
                                        <select id="work_center_to_part_no" name="CHR_WORK_CENTER" class="ddl2" style="width:150px;" onchange="get_data_part_no();">
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                                    ?>
                                                    <option selected value="<?php echo trim($work_center); ?>" > <?php echo trim($work_center); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="60%"></td>
                                    <td width="25%"></td>
                                </tr>
                                <tr>
                                    <td width="5%">Part No</td>                                        
                                    <td width="5%" colspan="4">
                                        <select id="e2" name="CHR_PART_NO" class="form-control" style="width:180px;">
                                            <?php
                                            foreach ($all_part_no as $row) {
                                                if (trim($row->CHR_PART_NO) == trim($part_no)) {
                                                    ?>
                                                    <option selected value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO) . " - " . trim($row->CHR_BACK_NO); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO) . " - " . trim($row->CHR_BACK_NO); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="60%"></td>
                                    <td width="25%"></td>
                                </tr>
                                <tr>
                                    <td width="5%">Date from</td>
                                    <td width="9%">
                                        <input name="START_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo date("m/d/Y", strtotime($start_date)); ?>">
                                    </td>
                                    <td width="1%" align="center">to</td>
                                    <td width="10%" style="text-align:right;">
                                        <input name="END_DATE" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo date("m/d/Y", strtotime($end_date)); ?>">
                                    </td>
                                    <td width='9%'>
                                        <!-- <span style='font-style:italic;'>(mm/dd/YYYY)</span>    -->
                                    </td>
                                    <td width="5%" ></td>
                                    <td width="60%"></td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>                                        
                                    <td width="5%">
                                        <button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                        <button type="submit" class="btn btn-primary" name="export" value="1"><span class="fa fa-cloud-download"></span>&nbsp;&nbsp;Export</button>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="60%"></td>
                                    <td width="25%"></td>
                                </tr>
                            </table>
                            <?php form_close(); ?>
                            <div style="width: 60%;">                            
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;" rowspan="2">No</th>    
                                    <th style="text-align:center;" rowspan="2">Prod Order No</th>
                                    <th style="text-align:center;" rowspan="2">Serial One Way</th>                                
                                    <th style="text-align:center;" rowspan="2">Part No</th> 
                                    <th style="text-align:center;" rowspan="2">Back No</th>                                   
                                    <th style="text-align:center;" colspan="8">Detail QR Part</th>
                                    <th style="text-align:center;" rowspan="2">Model</th>
                                    <th style="text-align:center;" colspan="45">Tester Value</th>           
                                    <th style="text-align:center;" rowspan="2">Date Scan</th>
                                    <th style="text-align:center;" rowspan="2">Time Scan</th>
                                    <th style="text-align:center;" rowspan="2">Pallet No</th>
                                    <th style="text-align:center;" rowspan="2">PO No</th>
                                    <th style="text-align:center;" rowspan="2">Deliv Date</th>
                                    <th style="text-align:center;" rowspan="2">Action</th>
                                </tr>
                                <tr>
                                    <!-- QR VALUE -->
                                    <th style="text-align:center;">QR Code</th>     
                                    <th style="text-align:center;">Year</th>                                    
                                    <th style="text-align:center;">Month</th> 
                                    <th style="text-align:center;">Day</th>                                   
                                    <th style="text-align:center;">Hours</th>
                                    <th style="text-align:center;">Minute</th>
                                    <th style="text-align:center;">Second</th>
                                    <th style="text-align:center;">Master No</th>
                                    <!-- TESTER VALUE -->                                    
                                    <th style="text-align:center;">CHR_SMALL_K1_UPP</th>     
                                    <th style="text-align:center;">CHR_SMALL_K1</th>                                    
                                    <th style="text-align:center;">CHR_SMALL_K1_LOW</th> 
                                    <th style="text-align:center;">CHR_SMALL_K2_UPP</th>                                   
                                    <th style="text-align:center;">CHR_SMALL_K2</th>
                                    <th style="text-align:center;">CHR_SMALL_K2_LOW</th>
                                    <th style="text-align:center;">CHR_SMALL_H1_UPP</th>                                   
                                    <th style="text-align:center;">CHR_SMALL_H1</th>
                                    <th style="text-align:center;">CHR_SMALL_H1_LOW</th>
                                    <th style="text-align:center;">CHR_SMALL_H2_UPP</th>                                   
                                    <th style="text-align:center;">CHR_SMALL_H2</th>
                                    <th style="text-align:center;">CHR_SMALL_H2_LOW</th>
                                    <th style="text-align:center;">CHR_MIDDLE_K1_UPP</th>     
                                    <th style="text-align:center;">CHR_MIDDLE_K1</th>                                    
                                    <th style="text-align:center;">CHR_MIDDLE_K1_LOW</th>
                                    <th style="text-align:center;">CHR_MIDDLE_K2_UPP</th>     
                                    <th style="text-align:center;">CHR_MIDDLE_K2</th>                                    
                                    <th style="text-align:center;">CHR_MIDDLE_K2_LOW</th>
                                    <th style="text-align:center;">CHR_MIDDLE_K3_UPP</th>     
                                    <th style="text-align:center;">CHR_MIDDLE_K3</th>                                    
                                    <th style="text-align:center;">CHR_MIDDLE_K3_LOW</th>
                                    <th style="text-align:center;">CHR_MIDDLE_H1_UPP</th>     
                                    <th style="text-align:center;">CHR_MIDDLE_H1</th>                                    
                                    <th style="text-align:center;">CHR_MIDDLE_H1_LOW</th>
                                    <th style="text-align:center;">CHR_MIDDLE_H2_UPP</th>     
                                    <th style="text-align:center;">CHR_MIDDLE_H2</th>                                    
                                    <th style="text-align:center;">CHR_MIDDLE_H2_LOW</th>
                                    <th style="text-align:center;">CHR_LARGE_H2_UPP</th>     
                                    <th style="text-align:center;">CHR_LARGE_H2</th>                                    
                                    <th style="text-align:center;">CHR_LARGE_H2_LOW</th>
                                    <th style="text-align:center;">CHR_LARGE_K2_UPP</th>     
                                    <th style="text-align:center;">CHR_LARGE_K2</th>                                    
                                    <th style="text-align:center;">CHR_LARGE_K2_LOW</th>
                                    <th style="text-align:center;">CHR_LARGE_K3_UPP</th>     
                                    <th style="text-align:center;">CHR_LARGE_K3</th>                                    
                                    <th style="text-align:center;">CHR_LARGE_K3_LOW</th>
                                    <th style="text-align:center;">CHR_LARGE_K4_UPP</th>     
                                    <th style="text-align:center;">CHR_LARGE_K4</th>                                    
                                    <th style="text-align:center;">CHR_LARGE_K4_LOW</th>
                                    <th style="text-align:center;">CHR_MIN_UPP</th>     
                                    <th style="text-align:center;">CHR_MIN</th>                                    
                                    <th style="text-align:center;">CHR_MIN_LOW</th>
                                    <th style="text-align:center;">CHR_POS_UPP</th>     
                                    <th style="text-align:center;">CHR_POS</th>                                    
                                    <th style="text-align:center;">CHR_POS_LOW</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    foreach($data as $val){ 
                                        echo "<tr align='center'>";
                                        echo "<td>" . $no . "</td>";       
                                        echo "<td>" . trim($val->CHR_PRD_ORDER_NO) . "</td>";
                                        echo "<td>" . trim($val->CHR_SERIAL) . "</td>";                                  
                                        echo "<td>" . trim($part_no) . "</td>"; 
                                        echo "<td>" . trim($val->CHR_BACK_NO) . "</td>";
                                        
                                        //=== QR CODE
                                        $y = substr($val->CHR_YEAR,2,2);
                                        if(strlen($val->CHR_MONTH) < 2){
                                            $m = '0' . $val->CHR_MONTH;
                                        } else {
                                            $m = $val->CHR_MONTH;
                                        }

                                        if(strlen($val->CHR_DAY) < 2){
                                            $d = '0' . $val->CHR_DAY;
                                        } else {
                                            $d = $val->CHR_DAY;
                                        }

                                        if(strlen($val->CHR_HOUR) < 2){
                                            $h = '0' . $val->CHR_HOUR;
                                        } else {
                                            $h = $val->CHR_HOUR;
                                        }

                                        if(strlen($val->CHR_MINUTE) < 2){
                                            $i = '0' . $val->CHR_MINUTE;
                                        } else {
                                            $i = $val->CHR_MINUTE;
                                        }

                                        if(strlen($val->CHR_SECOND) < 2){
                                            $s = '0' . $val->CHR_SECOND;
                                        } else {
                                            $s = $val->CHR_SECOND;
                                        }

                                        if(strlen($val->CHR_MASTER_NO) == 3){
                                            $x = $val->CHR_MASTER_NO;
                                        } else if(strlen($val->CHR_MASTER_NO) == 2) {
                                            $x = '0' . $val->CHR_MASTER_NO;
                                        } else {
                                            $x = '00' . $val->CHR_MASTER_NO;
                                        }

                                        $qrcode = $y . $m . $d . $h .$i . $s . $x;

                                        echo "<td>" . trim($val->CHR_QR_PART) . "</td>";
                                        echo "<td>" . $val->CHR_YEAR . "</td>";
                                        echo "<td>" . $m . "</td>";
                                        echo "<td>" . $d . "</td>";
                                        echo "<td>" . $h . "</td>";
                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $s . "</td>";
                                        echo "<td>" . $x . "</td>";
                                        echo "<td>" . trim($val->CHR_MODEL) . "</td>";
                                        //=== DATA TESTER
                                        echo "<td>" . number_format($val->CHR_SMALL_K1_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_K1/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_K1_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_K2_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_K2/1,1,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_K2_LOW/1,1,',','.') . "</td>"; 
                                        echo "<td>" . number_format($val->CHR_SMALL_H1_UPP/1,1,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_H1/1,1,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_H1_LOW/1,1,',','.') . "</td>"; 
                                        echo "<td>" . number_format($val->CHR_SMALL_H2_UPP/1,1,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_H2/1,1,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SMALL_H2_LOW/1,0,',','.') . "</td>"; 
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K1_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K1/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K1_LOW/1,0,',','.') . "</td>"; 
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K2_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K2/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K2_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K3_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K3/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_K3_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_H1_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_H1/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_H1_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_H2_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_H2/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIDDLE_H2_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_H2_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_H2/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_H2_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K2_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K2/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K2_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K3_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K3/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K3_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K4_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K4/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_LARGE_K4_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIN_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIN/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_MIN_LOW/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_POS_UPP/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_POS/1,0,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_POS_LOW/1,0,',','.') . "</td>";
                                        
                                        if($val->CHR_MODIFIED_DATE != NULL && $val->CHR_MODIFIED_DATE != ""){
                                            echo "<td>" . substr($val->CHR_MODIFIED_DATE,0,4) . "/" . substr($val->CHR_MODIFIED_DATE,4,2) . "/" . substr($val->CHR_MODIFIED_DATE,6,2) . "</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }
                            
                                        if($val->CHR_MODIFIED_TIME != NULL && $val->CHR_MODIFIED_TIME != ""){
                                            echo "<td>" . substr($val->CHR_MODIFIED_TIME,0,2) . ":" . substr($val->CHR_MODIFIED_TIME,2,2) . ":" . substr($val->CHR_MODIFIED_TIME,4,2) . "</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }

                                        if($val->CHR_IDPALLET != NULL && $val->CHR_IDPALLET != ""){
                                            echo "<td>" . trim($val->CHR_IDPALLET) . "</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }

                                        if($val->CHR_NOPO_SAP != NULL && $val->CHR_NOPO_SAP != ""){
                                            echo "<td>" . trim($val->CHR_NOPO_SAP) . "</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }

                                        if($val->CHR_DATE_DELIVERY_ACT != NULL && $val->CHR_DATE_DELIVERY_ACT != ""){
                                            echo "<td>" . substr($val->CHR_DATE_DELIVERY_ACT,0,4) . "/" . substr($val->CHR_DATE_DELIVERY_ACT,4,2) . "/" . substr($val->CHR_DATE_DELIVERY_ACT,6,2) . "</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }

                                        echo "<td>"; 
                                        ?> 
                                        <a onclick="view_elina(' <?php echo str_replace('/','-',trim($val->CHR_PRD_ORDER_NO)); ?> ');" title='ELINA' class='label label-info'><span class="fa fa-shopping-cart"></span></a>
                                        <a onclick="view_quinsa(' <?php echo str_replace('/','-',trim($val->CHR_PRD_ORDER_NO)); ?> ');" title='QUINSA' class='label label-warning'><span class="fa fa-check-square-o"></span></a>
                                        <?php
                                        echo "</td>"; 
                                        echo "</tr>";
                                        $no++;     
                                    }
                                ?>                            
                            </tbody>
                        </table>
                    </div>
                    <!-- START MODAL -->  
                    <div class="modal" id="modal_elina" tabindex="-1" align="middle" style="display: none;">
                        <!-- Data by JSON -->
                    </div>
                    <div class="modal" id="modal_quinsa" tabindex="-1" align="middle" style="display: none;">
                        <!-- Data by JSON -->
                    </div>
                    <!-- END MODAL -->
                </div>                
            </div>            
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 2,
                rightColumns: 1                
            }
        });
    });

    function get_data_work_center(){
        var dept_to_work_center = document.getElementById('dept_to_work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
            data:  {
                    INT_ID_DEPT: dept_to_work_center
                    },
            success: function (json_data) {
                $("#work_center_to_part_no").html(json_data['data']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }

    function get_data_part_no(){
        var work_center_to_part_no = document.getElementById('work_center_to_part_no').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('prd/tracebility_c/get_data_part_by_work_center'); ?>",
            data:  {
                    CHR_WCENTER: work_center_to_part_no
                    },
            success: function (json_data) {
                $("#e2").html(json_data['data']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }

    function view_elina(prd_no) {
        // alert(prd_no);

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/tracebility_c/get_data_elina_by_lot_no'); ?>",
            data: "lot_no=" + prd_no,
            success: function (data) {
                // alert(data);     
                document.getElementById("modal_elina").style.display = "block"; 
                $("#modal_elina").html(data);
            }
        });
    }  

    function hide_elina() {
        document.getElementById("modal_elina").style.display = "none"; 
    }

    function view_quinsa(prd_no) {
        // alert(prd_no);

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/tracebility_c/get_data_quinsa_by_lot_no'); ?>",
            data: "order_no=" + prd_no,
            success: function (data) {
                // alert(data);     
                document.getElementById("modal_quinsa").style.display = "block"; 
                $("#modal_quinsa").html(data);
            }
        });
    }  

    function hide_quinsa() {
        document.getElementById("modal_quinsa").style.display = "none"; 
    }
</script>
