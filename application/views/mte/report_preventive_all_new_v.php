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
    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        /* border-radius: 4px; */
        /* border-width: 0.4em;
        border-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        /* border-color: #bce8f1; */
        border-width: 0.4em;
        border-color: #bce8f1;
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
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>DATA PREVENTIVE</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <?php 
                            $group_type = "";
                            if($group_line == 1){
                                $group_type = "MOLD";
                            } else if($group_line == 2){
                                $group_type = "DIES STP";
                            } else if($group_line == 3){
                                $group_type = "DIES DF";
                            } else if($group_line == 4){
                                $group_type = "MACHINE";
                            } else if($group_line == 5){
                                $group_type = "JIG";
                            } else if($group_line == 6){
                                $group_type = "ELECTRODE";
                            }
                        ?>
                        <span class="grid-title"><strong>DATA PREVENTIVE - <?php echo $group_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" style="margin-bottom:-20px;">
                                <td width="10%">
                                    <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                        <?php foreach ($all_group_line as $row) { ?>
                                            <option value="<?php echo site_url('mte/report_preventive_c/report_preventive_all/0/' . $row->ID); ?>" <?php
                                            if ($group_line == $row->ID) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                <?php } ?>
                                    </select>
                                </td>
                                <td width="75%" style="text-align:right;">
                                    <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Report Preventive')" value="Export to Excel" style="margin-bottom: 20px;">
                                </td>                              
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
                                    <th style='vertical-align: middle;text-align:center;' rowspan="2">Work Center</th>
                                    <?php if($group_line == 4){ ?>
                                        <th style='text-align:center;' colspan="6">Hour</th>
                                    <?php } else { ?>
                                        <th style='text-align:center;' colspan="6">Stroke</th>
                                    <?php } ?>
                                   
                                    <th style='vertical-align: middle;text-align:center;' rowspan="2">Action</th>
                                </tr>
                                <tr>
                                    <th style='text-align:center;'>Std. Prev</th>
                                    <th style='text-align:center;'>Last Prev</th>
                                    <th style='text-align:center;'>Next Prev</th>
                                    <th style='text-align:center;'>Running</th>
                                    <th style='text-align:center;'>Remain</th>
                                    <th style='text-align:center;'>Est Date</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($get_all_data_preventive_mte as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_PART_CODE</td>";
                                        echo "<td>".trim($isi->CHR_MODEL)."</td>";
                                        echo "<td>".trim($isi->CHR_PART_NAME)."</td>";
                                        
                                        $wc = trim($isi->CHR_WORK_CENTER);
                                        $code = trim($isi->CHR_PART_CODE); 
                                        if($group_line == '1' || $group_line == '2' || $group_line == '3'){                                            
                                            $get_wc = $this->db->query("SELECT DISTINCT CHR_WORK_CENTER FROM TM_PARTS_MTE_DETAIL WHERE CHR_PART_CODE = '$code' AND INT_FLAG_DELETE <> '1'")->result();
                                            $wc = '';
                                            foreach($get_wc as $data){
                                                $wc .= $data->CHR_WORK_CENTER;
                                                $wc .= ' ';
                                            }

                                            
                                        }  
                                        
                                        $last_stroke_prev = 0;
                                        $get_last_prev = $this->db->query("SELECT TOP 1 * FROM TT_PREVENTIVE WHERE CHR_PART_CODE = '$code' ORDER BY INT_ID DESC");
                                        if($get_last_prev->num_rows() > 0){
                                            $last_stroke_prev = $get_last_prev->row()->INT_COUNT;
                                        }

                                        echo "<td align='center'>".$wc."</td>";                                        
                                        echo "<td align='right'>".str_replace(',','.', number_format($isi->INT_STROKE_SMALL))."</td>";
                                        echo "<td align='right'>".str_replace(',','.', number_format($last_stroke_prev))."</td>";
                                        echo "<td align='right'>".str_replace(',','.', number_format($isi->INT_STROKE_BIG))."</td>";
                                        echo "<td align='right'>".str_replace(',','.', number_format($isi->INT_STROKE))."</td>";

                                        //===== Get total days from 3 month ago;
                                        $date_now = date('Ymd') . ' ' . date('His');
                                        $date_start = date('Ymd', strtotime("-90 days")) . ' 000001';
                                        $date_1 = new datetime($date_start);
                                        $date_2 = new datetime($date_now);
                                        $diff_days = $date_1->diff($date_2);
                                        $tot_days = (int)$diff_days->format('%a');
                                                                                
                                        //===== Average stroke per day
                                        //===== If machine MTE
                                        if($group_line == 4 || $group_line == 6){
                                            $avg_stroke = $isi->INT_STROKE / $tot_days;
                                        } else {
                                            $avg_stroke = $isi->INT_STROKE_3MONTH / $tot_days;
                                        }
                                        
                                        $remain_stroke = $isi->INT_STROKE_BIG - $isi->INT_STROKE;
                                        if($avg_stroke == 0){
                                            $tot_days_to_prev = 0;
                                        } else {
                                            $tot_days_to_prev = floor($remain_stroke / $avg_stroke);
                                        }
                                        

                                        if ($isi->CHR_STATUS == '1' || $isi->CHR_STATUS == '4') {
                                            echo "<td align='right' style='background:yellow'>".str_replace(',','.', number_format($remain_stroke))."</td>";
                                        }
                                        else if ($isi->CHR_STATUS == '2' || $isi->CHR_STATUS == '5') {
                                            echo "<td align='right' style='background:red; color:white;'>".str_replace(',','.', number_format($remain_stroke))."</td>";
                                        }
                                        else if ($isi->CHR_STATUS == '3' || $isi->CHR_STATUS == '6') {
                                            echo "<td align='right' style='background:purple; color:white;'>".str_replace(',','.', number_format($remain_stroke))."</td>";
                                        } 
                                        else {
                                            echo "<td align='right'>".str_replace(',','.', number_format($remain_stroke))."</td>";
                                        }

                                        if($group_line == 4){
                                            echo "<td align='center'>-</td>";
                                        } else {
                                            if($tot_days_to_prev == 0){
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'>" . date('d/m/Y', strtotime("+$tot_days_to_prev days"))."</td>";
                                            }
                                            
                                        }
                                        ?>
                                        <?php
                                        if ($isi->CHR_STATUS == 0 || $isi->CHR_TYPE == 'F') { ?>                                         
                                            <td align="center"><a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Not yet">Done</a></td>                                                                          
                                        <?php } else { ?>
                                            <td align="center">
                                                <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/update_flag_prev') . "/" . $isi->INT_ID; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Done"  onclick="return confirm('Are you really sure you have finished doing the preventive of this Part Code: <?php echo trim($isi->CHR_PART_CODE) . ' Model: ' . trim($isi->CHR_MODEL); ?>?');">Done</a>
                                            </td> 
                                        <?php } ?>

                                    </tr>
                                    <?php
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
                                        <th style='vertical-align: middle;' rowspan="2">Work Center</th>
                                        <?php if($group_line == 4){ ?>
                                            <th style='text-align:center;' colspan="4">Hour</th>
                                        <?php } else { ?>
                                            <th style='text-align:center;' colspan="4">Stroke</th>
                                        <?php } ?>
                                    
                                    </tr>
                                    <tr>
                                        <td>Std. Prev</td>
                                        <td>Prev.</td>
                                        <td>Running</td>
                                        <td>Remaining</td>
                                    </tr>
                                </thead>

                                <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($get_all_data_preventive_mte as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td>$i</td>";
                                            echo "<td>$isi->CHR_PART_CODE</td>";
                                            echo "<td>".trim($isi->CHR_MODEL)."</td>";
                                            echo "<td>".trim($isi->CHR_PART_NAME)."</td>";
                                            
                                            $wc = trim($isi->CHR_WORK_CENTER);
                                            if($group_line == '1' || $group_line == '2' || $group_line == '3'){
                                                $code = trim($isi->CHR_PART_CODE); 
                                                $get_wc = $this->db->query("SELECT DISTINCT CHR_WORK_CENTER FROM TM_PARTS_MTE_DETAIL WHERE CHR_PART_CODE = '$code' AND INT_FLAG_DELETE <> '1'")->result();
                                                $wc = '';
                                                foreach($get_wc as $data){
                                                    $wc .= $data->CHR_WORK_CENTER;
                                                    $wc .= ' ';
                                                }
                                            }                                        

                                            echo "<td align='center'>".$wc."</td>";
                                            echo "<td align='right'>".str_replace(',','.', number_format($isi->INT_STROKE_SMALL))."</td>";
                                            echo "<td align='right'>".str_replace(',','.', number_format($isi->INT_STROKE_BIG))."</td>";
                                            echo "<td align='right'>".str_replace(',','.', number_format($isi->INT_STROKE))."</td>";
                                            if ($isi->CHR_STATUS == '1' || $isi->CHR_STATUS == '4') {
                                                echo "<td align='right' style='background:yellow'>".str_replace(',','.', number_format(($isi->INT_STROKE_BIG - $isi->INT_STROKE)))."</td>";
                                            }
                                            else if ($isi->CHR_STATUS == '2' || $isi->CHR_STATUS == '5') {
                                                echo "<td align='right' style='background:red; color:white;'>".str_replace(',','.', number_format(($isi->INT_STROKE_BIG - $isi->INT_STROKE)))."</td>";
                                            }
                                            else if ($isi->CHR_STATUS == '3' || $isi->CHR_STATUS == '6') {
                                                echo "<td align='right' style='background:purple; color:white;'>".str_replace(',','.', number_format(($isi->INT_STROKE_BIG - $isi->INT_STROKE)))."</td>";
                                            } 
                                            else {
                                                echo "<td align='right'>".str_replace(',','.', number_format(($isi->INT_STROKE_BIG - $isi->INT_STROKE)))."</td>";
                                            }
                                            ?>

                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                            </table>

                        </div>
                        <div class='pull'>
                            <div class = 'legend legend-info'>
                                <strong>Formula : </strong> 
                                <br>
                                <span style='font-style:italic;'>(1) <strong>Next Prev </strong>= Last Prev + Std Prev </span>
                                <br>
                                <span style='font-style:italic;'>(2) <strong>Remain </strong>= Next Prev + Running </span>
                                <br>
                                <span style='font-style:italic;'>(3) <strong>Est Date </strong>= Menggunakan rata-rata stroke per hari dari 3 bulan terakhir</span>
                            </div >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
