<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 10px;
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
        document.body.style.zoom = 0.80;
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
                leftColumns: 3,
                rightColumns: 3                
            }
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>DATA REPAIR</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DATA HISTORY REPAIR</strong></span>
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
                                                <option value="<?php echo site_url('mte/report_preventive_c/report_history_repair/' . $group_line . '/' . date("Ym", strtotime("+$x month"))); ?>" <?php
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
                                    <td style="vertical-align:top">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_group_line as $row) { ?>
                                                <option value="<?php echo site_url('mte/report_preventive_c/report_history_repair/' . $row->ID . '/' . $month); ?>" <?php
                                                if ($group_line == $row->ID) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Report History Repair')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>     
                                </tr>                      
                            </table>
                        </div>
                        <br>
                        <div class="table-luar">
                            <table id="dataTables1" class="table table-striped  table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">No</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Tool Code</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Model</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Desc</th>                                                                                
                                        <?php if($group_line != "6") {?>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Problem</th>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Action</th>
                                        <?php } ?>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Last Used</th>
                                        <th style='text-align:center;' colspan="5">Repair</th>
                                        <?php if($group_line != "6") {?>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Spare Part</th>
                                        <?php } ?>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Last Stroke</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Notes</th>
                                        <th style='vertical-align: middle;text-align:center;' rowspan="2">Status</th>
                                        <?php if($group_line != "6") {?>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Confirm</th>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Action</th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
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
                                    foreach ($get_data_history_repair as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->KODE_PART</td>";
                                        echo "<td>".trim($isi->CHR_MODEL)."</td>";
                                        echo "<td>".trim($isi->CHR_PART_NAME)."</td>";
                                        if($isi->KODE_TYPE != 'F'){ //===== NOT ELECTRODE
                                            echo "<td align='left'>".trim($isi->CHR_PROBLEM)."</td>";
                                            echo "<td align='left'>".trim($isi->CHR_ACTION)."</td>";                                                                                       
                                        }
                                        
                                        echo "<td align='center'>".substr($isi->LAST_DATE, 6, 2) . '/' . substr($isi->LAST_DATE, 4, 2 ) . '/' . substr($isi->LAST_DATE, 0, 4 ) . ' ' . substr($isi->LAST_TIME, 0, 2 ) . ':' . substr($isi->LAST_TIME, 2, 2 )."</td>";

                                        if($isi->DATE_START == NULL){
                                            echo "<td align='center'>-</td>";
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            echo "<td align='center'>".substr($isi->DATE_START, 6, 2) . '/' . substr($isi->DATE_START, 4, 2 ) . '/' . substr($isi->DATE_START, 0, 4 ) . ' ' . substr($isi->TIME_START, 0, 2 ) . ':' . substr($isi->TIME_START, 2, 2 )."</td>";
                                            $npk = (strlen((string)$isi->NPK_START) == 3? '0'.$isi->NPK_START: $isi->NPK_START);
                                            $check_name = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
                                            if($check_name->num_rows() > 0){
                                                echo "<td align='center'>".trim(strtoupper($check_name->row()->CHR_USERNAME))."</td>";
                                            } else {
                                                echo "<td align='center'>".trim($isi->NPK_START)." (N/A)</td>";
                                            }                                            
                                        }
                                        
                                        if($isi->DATE_END == NULL){
                                            echo "<td align='center'>-</td>";
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            echo "<td align='center'>".substr($isi->DATE_END, 6, 2) . '/' . substr($isi->DATE_END, 4, 2 ) . '/' . substr($isi->DATE_END, 0, 4 ) . ' ' . substr($isi->TIME_END, 0, 2 ) . ':' . substr($isi->TIME_END, 2, 2 )."</td>";
                                            $npk = (strlen((string)$isi->NPK_END) == 3? '0'.$isi->NPK_END: $isi->NPK_END);
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

                                        if($isi->KODE_TYPE != 'F'){ //===== NOT ELECTRODE
                                            if($isi->INT_QTY_SPARE_PART == 0){
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'><a data-target='#modalDetail" . $isi->INT_ID . "' class='label label-info' data-placement='top' data-toggle='modal' title='Detail Part'>View</a></td>";
                                            } 
                                        }

                                        if($isi->KODE_TYPE != 'F'){ //===== NOT ELECTRODE
                                            echo "<td align='center'>".trim($isi->ACT_STROKE)."</td>";                                                                                   
                                        } else {
                                            echo "<td align='center'>".trim($isi->LAST_STROKE)."</td>"; 
                                        }

                                        if($isi->NOTES == NULL){
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            echo "<td align='center'>".trim($isi->NOTES)."</td>";
                                        }                                        

                                        if($isi->INT_FLG_REPAIR == 0){
                                            $date_now = date("Ymd");
                                            $date1 = new DateTime($date_now);
                                            $date2 = new DateTime($isi->LAST_DATE);
                                            $diff = $date1->diff($date2);                       
                                            $days = $diff->days;

                                            if($days == 1){
                                                echo "<td align='center' style='background-color: orange; color: white;'>NOT YET</td>";
                                            } elseif($days > 1){
                                                echo "<td align='center' style='background-color: red; color: white;'>NOT YET</td>";
                                            } else {
                                                echo "<td align='center'>NOT YET</td>";
                                            }                                           
                                        } else if($isi->INT_FLG_REPAIR == 1){
                                            $date_now = date("Ymd");
                                            $date1 = new DateTime($date_now);
                                            $date2 = new DateTime($isi->DATE_START);
                                            $diff = $date1->diff($date2);                       
                                            $days = $diff->days;
                                            
                                            if($days == 1){
                                                echo "<td align='center' style='background-color: orange; color: white;'>PROGRESS</td>";
                                            } elseif($days > 1){
                                                echo "<td align='center' style='background-color: red; color: white;'>PROGRESS</td>";
                                            } else {
                                                echo "<td align='center' style='background-color: yellow; color: black;'>PROGRESS</td>";
                                            }                                           
                                        } else if($isi->INT_FLG_REPAIR == 2){
                                            echo "<td align='center' style='background-color: #03CF2D; color: white;'>FINISH</td>";
                                        }

                                        if($isi->KODE_TYPE != 'F'){ //===== NOT ELECTRODE
                                            if($isi->INT_FLG_REPAIR == 2){
                                                if($isi->INT_FLG_CONFIRM == 1){
                                                    $npk = $isi->CHR_CONFIRM_BY;
                                                    $check_name = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
                                                    if($check_name->num_rows() > 0){
                                                        echo "<td align='center' style='background-color: #03CF2D; color: white;'>".trim(strtoupper($check_name->row()->CHR_USERNAME))."</td>";
                                                    } else {
                                                        echo "<td align='center' style='background-color: #03CF2D; color: white;'>".trim($isi->CHR_CONFIRM_BY)." (N/A)</td>";
                                                    }
                                                    echo "<td align='center'><a href='#' class='label label-default' data-placement='top' data-toggle='tooltip' title='Edit'><span class='fa fa-pencil'></span></a></td>";
                                                } else {                                                    
                                                    echo "<td align='center'><a href='" . base_url('index.php/mte/preventive_schedule_c/update_confirm_repair') . "/" . $group_line . "/" . $isi->INT_ID . "' class='label label-warning' data-placement='top' data-toggle='tooltip' title='Confirm' onclick='return confirm('Are you really sure you have finished doing the preventive of this Part Code: ". trim($isi->KODE_PART) . " Model: " . trim($isi->CHR_MODEL) . "?');>Confirm</a></td>";
                                                    echo "<td align='center'><a data-target='#modalEdit" . $isi->INT_ID . "' class='label label-warning' data-placement='top' data-toggle='modal' title='Edit'><span class='fa fa-pencil'></span></a></td>";
                                                }
                                            } else {
                                                echo "<td align='center'>NOT YET </td>";
                                                // echo "<td align='center'><a data-target='#modalEdit" . $isi->INT_ID . "' class='label label-warning' data-placement='top' data-toggle='modal' title='Edit'><span class='fa fa-pencil'></span></a></td>";
                                                echo "<td align='center'><a href='#' class='label label-default' data-placement='top' data-toggle='tooltip' title='Edit'><span class='fa fa-pencil'></span></a></td>";
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
                                        <th style='vertical-align: middle;' rowspan="2">Last Stroke</th>
                                        <?php if($group_line != "6") {?>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Problem</th>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Action</th>
                                        <?php } ?>
                                        <th style='vertical-align: middle;' rowspan="2">Last Used</th>
                                        <th style='text-align:center;' colspan="4">Repair</th>
                                        <?php if($group_line != "6") {?>
                                            <th style='vertical-align: middle;text-align:center;' rowspan="2">Spare Part</th>
                                        <?php } ?>
                                        <th style='vertical-align: middle;' rowspan="2">Notes</th>
                                        <th style='vertical-align: middle;' rowspan="2">Status</th>
                                    </tr>
                                    <tr>
                                        <td>Start</td>
                                        <td>Start PIC</td>
                                        <td>Finish</td>
                                        <td>Finish PIC</td>
                                    </tr>
            
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($get_data_history_repair as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->KODE_PART</td>";
                                        echo "<td>".trim($isi->CHR_MODEL)."</td>";
                                        echo "<td>".trim($isi->CHR_PART_NAME)."</td>";
                                        if($isi->KODE_TYPE != 'F'){ //===== NOT ELECTRODE
                                            echo "<td align='center'>".trim($isi->ACT_STROKE)."</td>";
                                            echo "<td align='left'>".trim($isi->CHR_PROBLEM)."</td>";
                                            echo "<td align='left'>".trim($isi->CHR_ACTION)."</td>";                                                                                       
                                        } else {
                                            echo "<td align='center'>".trim($isi->LAST_STROKE)."</td>"; 
                                        }
                                        
                                        echo "<td align='center'>".substr($isi->LAST_DATE, 6, 2) . '/' . substr($isi->LAST_DATE, 4, 2 ) . '/' . substr($isi->LAST_DATE, 0, 4 ) . ' ' . substr($isi->LAST_TIME, 0, 2 ) . ':' . substr($isi->LAST_TIME, 2, 2 )."</td>";

                                        if($isi->DATE_START == NULL){
                                            echo "<td align='center'>-</td>";
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            echo "<td align='center'>".substr($isi->DATE_START, 6, 2) . '/' . substr($isi->DATE_START, 4, 2 ) . '/' . substr($isi->DATE_START, 0, 4 ) . ' ' . substr($isi->TIME_START, 0, 2 ) . ':' . substr($isi->TIME_START, 2, 2 )."</td>";
                                            $npk = $isi->NPK_START;
                                            $check_name = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
                                            if($check_name->num_rows() > 0){
                                                echo "<td align='center'>".trim($check_name->row()->CHR_USERNAME)."</td>";
                                            } else {
                                                echo "<td align='center'>".trim($isi->NPK_START)." (N/A)</td>";
                                            }                                            
                                        }
                                        
                                        if($isi->DATE_END == NULL){
                                            echo "<td align='center'>-</td>";
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            echo "<td align='center'>".substr($isi->DATE_END, 6, 2) . '/' . substr($isi->DATE_END, 4, 2 ) . '/' . substr($isi->DATE_END, 0, 4 ) . ' ' . substr($isi->TIME_END, 0, 2 ) . ':' . substr($isi->TIME_END, 2, 2 )."</td>";
                                            $npk = $isi->NPK_END;
                                            $check_name = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
                                            if($check_name->num_rows() > 0){
                                                echo "<td align='center'>".trim($check_name->row()->CHR_USERNAME)."</td>";
                                            } else {
                                                echo "<td align='center'>".trim($isi->NPK_END)." (N/A)</td>";
                                            }
                                        }

                                        if($isi->KODE_TYPE != 'F'){ //===== NOT ELECTRODE
                                            if($isi->INT_QTY_SPARE_PART == 0){
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'><a data-target='#modalDetail" . $isi->INT_ID . "' class='label label-info' data-placement='top' data-toggle='modal' title='Detail Part'>View</a></td>";
                                            } 
                                        }

                                        if($isi->NOTES == NULL){
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            echo "<td align='center'>".trim($isi->NOTES)."</td>";
                                        }                                        

                                        if($isi->INT_FLG_REPAIR == 0){
                                            $date_now = date("Ymd");
                                            $date1 = new DateTime($date_now);
                                            $date2 = new DateTime($isi->LAST_DATE);
                                            $diff = $date1->diff($date2);                       
                                            $days = $diff->days;

                                            if($days == 1){
                                                echo "<td align='center' style='background-color: orange; color: white;'>NOT YET</td>";
                                            } elseif($days > 1){
                                                echo "<td align='center' style='background-color: red; color: white;'>NOT YET</td>";
                                            } else {
                                                echo "<td align='center'>NOT YET</td>";
                                            }                                           
                                        } else if($isi->INT_FLG_REPAIR == 1){
                                            $date_now = date("Ymd");
                                            $date1 = new DateTime($date_now);
                                            $date2 = new DateTime($isi->DATE_START);
                                            $diff = $date1->diff($date2);                       
                                            $days = $diff->days;
                                            
                                            if($days == 1){
                                                echo "<td align='center' style='background-color: orange; color: white;'>ON PROGRESS</td>";
                                            } elseif($days > 1){
                                                echo "<td align='center' style='background-color: red; color: white;'>ON PROGRESS</td>";
                                            } else {
                                                echo "<td align='center' style='background-color: yellow; color: black;'>ON PROGRESS</td>";
                                            }                                           
                                        } else if($isi->INT_FLG_REPAIR == 2){
                                            echo "<td align='center' style='background-color: green; color: white;'>FINISH REPAIR</td>";
                                        }
                                        
                                        echo "</tr>";
                                        $i++;
                                    }
                                ?>
                                    </tbody>
                            </table>
                        </div>
                        <!-- START MODAL -->  
                        <?php foreach ($get_data_history_repair as $part) { ?>                      
                        <div class="modal fade" id="modalDetail<?php echo $part->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Spare Part</strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Part No</th>
                                                        <th>Spare Part Name</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $x = 1;
                                                    echo "<tr>";
                                                    echo "<td>" . $x . "</td>";
                                                    echo "<td>" . trim($part->CHR_PART_NO_SPARE_PART) . "</td>";
                                                    echo "<td>" . trim($part->CHR_SPARE_PART_NAME) . "</td>";  
                                                    echo "<td>" . trim($part->INT_QTY_SPARE_PART) . "</td>";                                                    
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php foreach ($get_data_history_repair as $val) { ?>                      
                        <div class="modal fade" id="modalEdit<?php echo $val->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Repair Data</strong></h4>
                                        </div>
                                        <?php echo form_open('mte/report_preventive_c/update_history_repair', 'class="form-horizontal"'); ?>
                                        <input type='hidden' name='id_repair' id='id_repair' value='<?php echo $val->INT_ID; ?>'>
                                        <input type='hidden' name='id_group' id='id_group' value='<?php echo $group_line; ?>'>
                                        <input type='hidden' name='period' id='period' value='<?php echo $month; ?>'>
                                        <div class="modal-body">                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Problem</label>
                                                <div class="col-sm-5">
                                                    <textarea class="form-control" id="problem" name="problem" style="width:370px;" required><?php echo $val->CHR_PROBLEM; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Action</label>
                                                <div class="col-sm-5">
                                                    <textarea class="form-control" id="action" name="action" style="width:370px;" required><?php echo $val->CHR_ACTION; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END MODAL -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
