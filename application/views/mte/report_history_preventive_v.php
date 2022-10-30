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
    .td-fixed-2{
        width: 90px;
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

<script>     
    var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)))
        }
    , format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
        return c[p];
    })
    }
    return function (table, name) {
    if (!table.nodeType)
        table = document.getElementById(table)
    var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>

<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#dataTables1').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                //leftColumns: 4,
                rightColumns: 2                
            }
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>DATA PREVENTIVE</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DATA HISTORY PREVENTIVE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" style="margin-bottom:-20px;" id='filter' border=0px>
                                <tr>
                                    <td style="vertical-align:top">Period</td>
                                    <td style="vertical-align:top">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php for ($x = -4; $x <= 0; $x++) { ?>
                                                <option value="<?php echo site_url('mte/report_preventive_c/report_history_preventive/' . $group_line . '/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                    if ($month == date("Ym", strtotime("+$x month"))) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>  
                                </tr>
                                <tr>
                                    <td style="vertical-align:top">Tools Type</td>
                                    <td style="vertical-align:top" width="10%">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_group_line as $row) { ?>
                                                <option value="<?php echo site_url('mte/report_preventive_c/report_history_preventive/' . $row->ID . '/' . $month); ?>" <?php
                                                if ($group_line == $row->ID) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>        
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Report History Preventive')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>  
                                </tr>                      
                            </table>
                        </div>
                        <br>
                        <div class="table-luar">
                            <table id="dataTables1" class="table table-striped table-bordered table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">No</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Tool Code</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Model</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Desc</th>
                                        <th style='text-align:center;' colspan="7">Preventive</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Notes</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Checksheet</th>
                                        <?php if($group_line != "6") {?>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Confirm</th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th style='text-align:center;'>Stroke</th>
                                        <th style='text-align:center;'>Type</th>
                                        <th style='text-align:center;'>Start</th>
                                        <th style='text-align:center;'>Start PIC</th>
                                        <th style='text-align:center;'>Finish</th>
                                        <th style='text-align:center;'>Finish PIC</th>
                                        <th style='text-align:center;'>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($get_data_history_preventive as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->KODE_PART</td>";
                                        echo "<td>".trim($isi->CHR_MODEL)."</td>";
                                        echo "<td>".trim($isi->CHR_PART_NAME)."</td>";
                                        echo "<td align='center'>".number_format($isi->STROKE,0,',','.')."</td>";
                                        echo "<td align='center'>".trim($isi->TYPE_PREV)."</td>";

                                        if($isi->DATE_START == NULL){
                                            if(strlen($isi->PREV_TIME) < 6){
                                                echo "<td align='center'>".substr($isi->PREV_DATE, 6, 2) . '/' . substr($isi->PREV_DATE, 4, 2 ) . '/' . substr($isi->PREV_DATE, 0, 4 ) . ' ' . substr($isi->PREV_TIME, 0, 1 ) . ':' . substr($isi->PREV_TIME, 1, 2 )."</td>";
                                            } else {
                                                echo "<td align='center'>".substr($isi->PREV_DATE, 6, 2) . '/' . substr($isi->PREV_DATE, 4, 2 ) . '/' . substr($isi->PREV_DATE, 0, 4 ) . ' ' . substr($isi->PREV_TIME, 0, 2 ) . ':' . substr($isi->PREV_TIME, 2, 2 )."</td>";
                                            }
                                            
                                            echo "<td align='center'>".trim(strtoupper($isi->PIC))."</td>";
                                        } else {
                                            echo "<td align='center'>".substr($isi->DATE_START, 6, 2) . '/' . substr($isi->DATE_START, 4, 2 ) . '/' . substr($isi->DATE_START, 0, 4 ) . ' ' . substr($isi->TIME_START, 0, 2 ) . ':' . substr($isi->TIME_START, 2, 2 )."</td>";
                                            $npk = $isi->NPK_START;
                                            $check_name = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
                                            if($check_name->num_rows() > 0){
                                                echo "<td align='center'>".trim(strtoupper($check_name->row()->CHR_USERNAME))."</td>";
                                            } else {
                                                echo "<td align='center'>".trim($isi->NPK_START)." (N/A)</td>";
                                            }                                            
                                        }

                                        if($isi->DATE_END == NULL){
                                            if(strlen($isi->PREV_TIME) < 6){
                                                echo "<td align='center'>".substr($isi->PREV_DATE, 6, 2) . '/' . substr($isi->PREV_DATE, 4, 2 ) . '/' . substr($isi->PREV_DATE, 0, 4 ) . ' ' . substr($isi->PREV_TIME, 0, 1 ) . ':' . substr($isi->PREV_TIME, 1, 2 )."</td>";
                                            } else {
                                                echo "<td align='center'>".substr($isi->PREV_DATE, 6, 2) . '/' . substr($isi->PREV_DATE, 4, 2 ) . '/' . substr($isi->PREV_DATE, 0, 4 ) . ' ' . substr($isi->PREV_TIME, 0, 2 ) . ':' . substr($isi->PREV_TIME, 2, 2 )."</td>";
                                            }
                                            
                                            echo "<td align='center'>".trim(strtoupper($isi->PIC))."</td>";
                                        } else {
                                            echo "<td align='center'>".substr($isi->DATE_END, 6, 2) . '/' . substr($isi->DATE_END, 4, 2 ) . '/' . substr($isi->DATE_END, 0, 4 ) . ' ' . substr($isi->TIME_END, 0, 2 ) . ':' . substr($isi->TIME_END, 2, 2 )."</td>";
                                            $npk = $isi->NPK_END;
                                            $check_name = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
                                            if($check_name->num_rows() > 0){
                                                echo "<td align='center'>".trim(strtoupper($check_name->row()->CHR_USERNAME))."</td>";
                                            } else {
                                                echo "<td align='center'>".trim($isi->NPK_END)." (N/A)</td>";
                                            }
                                        }

                                        if($isi->DATE_END != NULL){
                                            $datetime_now = $isi->DATE_END . ' ' . $isi->TIME_END;
                                        } else {
                                            $datetime_now = date('Ymd') . ' ' . date('His');
                                        }
                                        $datetime_start = $isi->DATE_START . ' ' . $isi->TIME_START;
                                        $datetime_1 = new datetime($datetime_start);
                                        $datetime_2 = new datetime($datetime_now);
                                        $diff = $datetime_1->diff($datetime_2);
                                        // $duration = $diff->format('%y years %m months %a days %h hours %i minutes %s seconds');
                                        $duration = $diff->format('%a days %h hours %i min %s sec');

                                        echo "<td align='center'>".$duration."</td>";

                                        if($isi->NOTES == NULL){
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            echo "<td align='center'>".trim($isi->NOTES)."</td>";
                                        }  

                                        echo "<td align='center'><a data-target='#modalDetail" . $isi->INT_ID_PREV_DETAIL . "' class='label label-info' data-placement='top' data-toggle='modal' title='Detail Part'>View</a></td>";
                                        
                                        if($isi->KODE_TYPE != 'F'){ //===== NOT ELECTRODE
                                            if($isi->INT_FLG_CONFIRM == 1){
                                                $npk = $isi->CHR_CONFIRM_BY;
                                                $check_name = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
                                                if($check_name->num_rows() > 0){
                                                    echo "<td align='center' style='background-color: green; color: white;'>".trim(strtoupper($check_name->row()->CHR_USERNAME))."</td>";
                                                } else {
                                                    echo "<td align='center' style='background-color: green; color: white;'>".trim($isi->CHR_CONFIRM_BY)." (N/A)</td>";
                                                }
                                            } else {
                                                // echo "<td align='center' style='background-color: red; color: white;'>NOT YET</td>";
                                                echo "<td align='center'><a href='" . base_url('index.php/mte/preventive_schedule_c/update_confirm_prev') . "/" . $group_line . "/" . $isi->INT_ID . "' class='label label-warning' data-placement='top' data-toggle='tooltip' title='Confirm' onclick='return confirm('Are you really sure you have finished doing the preventive of this Part Code: ". trim($isi->KODE_PART) . " Model: " . trim($isi->CHR_MODEL) . "?');>Confirm</a></td>";
                                            }
                                        }

                                        echo "</tr>";
                                        $i++;
                                    }
                                ?>
                                </tbody>
                            </table>
                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr>
                                        <th style='vertical-align: middle;' rowspan="2">No</th>
                                        <th style='vertical-align: middle;' rowspan="2">Tool Code</th>
                                        <th style='vertical-align: middle;' rowspan="2">Model</th>
                                        <th style='vertical-align: middle;' rowspan="2">Desc</th>
                                        <th style='text-align:center;' colspan="5">Preventive</th>
                                    </tr>
                                    <tr>
                                        <th style='text-align:center;'>Stroke</th>
                                        <th style='text-align:center;'>Type</th>
                                        <th style='text-align:center;'>PIC</th>
                                        <th style='text-align:center;'>Date</th>
                                        <th style='text-align:center;'>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($get_data_history_preventive as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->KODE_PART</td>";
                                        echo "<td>".trim($isi->CHR_MODEL)."</td>";
                                        echo "<td>".trim($isi->CHR_PART_NAME)."</td>";
                                        echo "<td align='center'>".trim($isi->STROKE)."</td>";
                                        echo "<td align='center'>".trim($isi->TYPE_PREV)."</td>";
                                        echo "<td align='center'>".trim($isi->PIC)."</td>";
                                        echo "<td align='center'>".substr($isi->PREV_DATE, 6, 2).' '.date("F", mktime(null, null, null, substr($isi->PREV_DATE, 4, 2))).' '.substr($isi->PREV_DATE, 0, 4)."</td>";
                                        echo "<td align='center'>".substr(trim($isi->PREV_TIME), 0, 2).':'.substr(trim($isi->PREV_TIME), 2, 2).':'.substr(trim($isi->PREV_TIME), 4, 2)."</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- START MODAL - CHECKSHEET -->  
                        <?php foreach ($get_data_history_preventive as $prev) { ?>                      
                        <div class="modal fade" id="modalDetail<?php echo $prev->INT_ID_PREV_DETAIL; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Checksheet Preventive</strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Checksheet Code</th>
                                                        <th>Checksheet Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $id_prev = $prev->INT_ID_PREV_DETAIL;
                                                    $id_type = $prev->KODE_TYPE;
                                                    $id_part = $prev->INT_ID_PART;
                                                    $get_detail = $this->db->query("SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE
                                                                                    WHERE CHR_TYPE = '$id_type' AND INT_FLG_DEL = '0' AND INT_ID_PART IS NULL
                                                                                    UNION
                                                                                    SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE
                                                                                    WHERE CHR_TYPE = '$id_type' AND INT_FLG_DEL = '0' AND INT_ID_PART = '$id_part'");
                                                    if($get_detail->num_rows() > 0){
                                                        $x = 1;
                                                        $data = $get_detail->result();
                                                        foreach($data as $check){
                                                            echo "<tr>";
                                                            echo "<td>" . $x . "</td>";
                                                            echo "<td>".$check->CHR_CHECKSHEET_CODE."</td>";
                                                            echo "<td>".$check->CHR_CHECKSHEET_NAME."</td>";  
                                                            echo "<td><a data-target='#modalCheck" . $id_prev . "_".$check->INT_ID."' class='label label-info' data-placement='top' data-toggle='modal' title='Detail Part'>View</a></td>"; 
                                                            echo "</tr>";
                                                            $x++;  
                                                        }                                                        
                                                    } else {
                                                        echo "<tr>";
                                                        echo "<td colspan='4'>No Data Detail</td>";
                                                        echo "<tr>";
                                                    }                                                 
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END MODAL -->
                        <!-- START MODAL - CHECKSHEET DETAIL -->  
                        <?php 
                            foreach ($get_data_history_preventive as $prev) { 
                                $id_prev = $prev->INT_ID_PREV_DETAIL;
                                $id_type = $prev->KODE_TYPE;
                                $id_part = $prev->INT_ID_PART;
                                $get_detail = $this->db->query("SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE
                                                                WHERE CHR_TYPE = '$id_type' AND INT_FLG_DEL = '0' AND INT_ID_PART IS NULL
                                                                UNION
                                                                SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE
                                                                WHERE CHR_TYPE = '$id_type' AND INT_FLG_DEL = '0' AND INT_ID_PART = '$id_part'");
                                if($get_detail->num_rows() > 0){
                                    $x = 1;
                                    $data = $get_detail->result();
                                    foreach($data as $check){
                                        $id_check = $check->INT_ID;
                        ?>                      
                        <div class="modal fade" id="modalCheck<?php echo $id_prev."_".$id_check; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Checksheet - <?php echo $check->CHR_CHECKSHEET_NAME; ?></strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Activity</th>
                                                        <th>Item Check</th>
                                                        <th>Tool</th>
                                                        <th>Standard</th>
                                                        <th>Check</th>
                                                        <th>Before</th>
                                                        <th>After</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $get_activity = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE WHERE INT_ID_CHECKSHEET = '$id_check'");
                                                    if($get_activity->num_rows() > 0){
                                                        $n = 'A';
                                                        foreach($get_activity->result() as $act){
                                                            $id_act = $act->INT_ID;
                                                            echo "<tr>";
                                                            echo "<td style='font-weight:bold;'>" . $n . "</td>";
                                                            echo "<td colspan='8' style='font-weight:bold;'>" . trim($act->CHR_ACTIVITY) . "</td>";
                                                            echo "</tr>";
                                                            $get_activity_detail = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL WHERE INT_ID_ACTIVITY = '$id_act'");
                                                            if($get_activity_detail->num_rows() > 0){
                                                                $i = 1;
                                                                foreach($get_activity_detail->result() as $act_detail){
                                                                    $id_act_detail = $act_detail->INT_ID;
                                                                    $get_activity_trans = $this->db->query("SELECT * FROM MTE.TT_CHECKSHEET_PREVENTIVE WHERE INT_ID_PREV_DETAIL = '$id_prev' AND INT_ID_ACTIVITY_DETAIL = '$id_act_detail'");
                                                                    
                                                                    if($get_activity_trans->num_rows() > 0){
                                                                        $act_trans = $get_activity_trans->row();
                                                                        echo "<tr>";
                                                                        echo "<td>" . $i . "</td>";
                                                                        echo "<td>" . trim($act_detail->CHR_ACTIVITY_DETAIL) . "</td>";
                                                                        echo "<td>" . trim($act_detail->CHR_ITEM_CHECK) . "</td>";  
                                                                        echo "<td>" . trim($act_detail->CHR_TOOL) . "</td>"; 
                                                                        echo "<td>" . trim($act_detail->CHR_STD_CHECK) . "</td>"; 
                                                                        
                                                                        if($act_trans->INT_FLG_CHECK == '1'){
                                                                            echo "<td align='center'><img src='" . base_url() . "/assets/img/check1.png' width='18'></td>";
                                                                        } else {
                                                                            echo "<td align='center'><img src='" . base_url() . "/assets/img/error1.png' width='18'></td>";
                                                                        }                                                                        
                                                                        
                                                                        if($act_trans->CHR_STATUS_BEFORE == "NG"){
                                                                            echo "<td align='center' style='font-weight:bold;color:red;'>" . trim($act_trans->CHR_STATUS_BEFORE) . "</td>"; 
                                                                        } else {
                                                                            echo "<td align='center' style='font-weight:bold;color:green;'>" . trim($act_trans->CHR_STATUS_BEFORE) . "</td>"; 
                                                                        }
                                                                        
                                                                        if($act_trans->CHR_STATUS_AFTER == "NG"){
                                                                            echo "<td align='center' style='font-weight:bold;color:red;'>" . trim($act_trans->CHR_STATUS_AFTER) . "</td>"; 
                                                                        } else {
                                                                            echo "<td align='center' style='font-weight:bold;color:green;'>" . trim($act_trans->CHR_STATUS_AFTER) . "</td>"; 
                                                                        }

                                                                        echo "<td>" . trim($act_trans->CHR_REMARKS) . "</td>"; 
                                                                        echo "</tr>";
                                                                        
                                                                    }
                                                                    $i++; 
                                                                }
                                                            }
                                                            $n++;
                                                        }
                                                    }                                               
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                                    } 
                                } 
                            } 
                        ?>
                        <!-- END MODAL -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>