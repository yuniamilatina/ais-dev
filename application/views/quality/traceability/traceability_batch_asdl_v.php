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
                                    <th style="text-align:center;" rowspan="2">QR Part</th>
                                    <th style="text-align:center;" rowspan="2">Model</th>
                                    <th style="text-align:center;" colspan="35">Tester Value</th>           
                                    <th style="text-align:center;" rowspan="2">Date Scan</th>
                                    <th style="text-align:center;" rowspan="2">Time Scan</th>
                                    <th style="text-align:center;" rowspan="2">Pallet No</th>
                                    <th style="text-align:center;" rowspan="2">PO No</th>
                                    <th style="text-align:center;" rowspan="2">Deliv Date</th>
                                    <th style="text-align:center;" rowspan="2">Action</th>
                                </tr>
                                <tr>
                                    <!-- TESTER VALUE -->                                    
                                    <th style="text-align:center;">SPIN PWL BASEPLATE <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th>     
                                    <th style="text-align:center;">SPIN LCT BASEPLATE <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th>                                    
                                    <th style="text-align:center;">SPIN PWL SUBPLATE <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th> 
                                    <th style="text-align:center;">SPIN LCT SUBPLATE <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th>                                   
                                    <th style="text-align:center;">PTC THREAD 1 <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th>
                                    <th style="text-align:center;">PTC THREAD 2</th>
                                    <th style="text-align:center;">PTC THREAD 3</th>                                   
                                    <th style="text-align:center;">INT LIFT</th>
                                    <th style="text-align:center;">DEC OPENLIFT</th>
                                    <th style="text-align:center;">DEC CUS A</th>                                   
                                    <th style="text-align:center;">DEC CUS B</th>
                                    <th style="text-align:center;">DEC SPR LATCH A</th>
                                    <th style="text-align:center;">DEC SPR LATCH B</th>     
                                    <th style="text-align:center;">DEC SPR LATCH C</th>                                    
                                    <th style="text-align:center;">SPR PAWL</th>
                                    <th style="text-align:center;">DET LATCH</th>     
                                    <th style="text-align:center;">DET SPR LATCH</th>                                    
                                    <th style="text-align:center;">DET PAWL</th>
                                    <th style="text-align:center;">RTR CURRENT <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th>     
                                    <th style="text-align:center;">CAN MECHANISME</th>                                    
                                    <th style="text-align:center;">CNT SWITCH <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th>
                                    <th style="text-align:center;">HEIGHT SCREW 1</th>     
                                    <th style="text-align:center;">HEIGHT SCREW 2</th>                                    
                                    <th style="text-align:center;">HEIGHT SCREW 3</th>
                                    <th style="text-align:center;">INS RESIST <img style="width:15px;" src="<?php echo base_url('assets/img/j-mark.png'); ?>"></th>
                                    <th style="text-align:center;">OPR ACT</th>
                                    <th style="text-align:center;">OPR TIME</th>
                                    <th style="text-align:center;">OUT OPN LEVER</th>
                                    <th style="text-align:center;">MIN OPR VOLT</th>
                                    <th style="text-align:center;">LTC OPN CLC</th>
                                    <th style="text-align:center;">LCK MECHANISME</th>
                                    <th style="text-align:center;">KEY LESS</th>
                                    <th style="text-align:center;">MOT MECHANISME</th>
                                    <th style="text-align:center;">CHL MECHANISME</th>
                                    <th style="text-align:center;">AUTO SCREW</th>
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
                                        echo "<td>" . trim($val->CHR_QR_PART) . "</td>";
                                        echo "<td>" . trim($val->CHR_MODEL) . "</td>";
                                        //=== DATA TESTER
                                        echo "<td>" . number_format($val->CHR_SPIN_PWL_BASEPLATE/10000,4,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SPIN_LCT_BASEPLATE/10000,4,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SPIN_PWL_SUBPLATE/10000,4,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_SPIN_LCT_SUBPLATE/10000,4,',','.') . "</td>";
                                        if($val->CHR_PTC_THREAD_1 == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_PTC_THREAD_2 == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_PTC_THREAD_3 == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_INT_LIFT == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DEC_OPENLIFT == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DEC_CUS_A == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DEC_CUS_B == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DEC_SPR_LATCH_A == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DEC_SPR_LATCH_B == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DET_SPR_LATCH_C == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_SPR_PAWL == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DET_LATCH == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DET_SPR_LATCH == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_DET_PAWL == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_RTR_CURRENT == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_CAN_MECHANISME == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_CNT_SWITCH == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        echo "<td>" . number_format($val->CHR_GAP_SCREW_1/100,2,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_GAP_SCREW_2/100,2,',','.') . "</td>";
                                        echo "<td>" . number_format($val->CHR_GAP_SCREW_3/100,2,',','.') . "</td>";

                                        if($val->CHR_INS_RESIST == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_OPR_ACT == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_OPR_TIME == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_OUT_OPN_LEVER == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_MIN_OPR_VOLT == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_LTC_OPN_CLC == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_LCK_MECHANISME == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_KEY_LESS == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_MOT_MECHANISME == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }

                                        if($val->CHR_CHL_MECHANISME == '1'){
                                            echo "<td>OK</td>";
                                        } else {
                                            echo "<td style='background-color:red; color:white;'>NG</td>";
                                        }
                                        
                                        echo "<td>" . $val->CHR_AUTO_SCREW . "</td>";
                                        
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
