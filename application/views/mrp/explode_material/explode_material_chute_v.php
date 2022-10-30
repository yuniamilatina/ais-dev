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
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/mrp/manage_mrp_c/explode_material_by_chute') ?>"><strong>Explode Component by Chute</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>EXPLODE COMPONENT BY DIGITAL CHUTE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <!-- <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/export_explode_material_by_chute/' . trim($periode) . '/' . trim($id_dept)) ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Report" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Export</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('mrp/manage_mrp_c/search_explode_material_by_chute', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Group Product</td>
                                    <td width="5%">
                                        <select name="group_prd" id="group_to_work_center" onchange="get_data_work_center(); document.getElementById('dept_id').value=this.options[this.selectedIndex].value;" class="ddl2" style="width:150px;">
                                            <?php
                                            foreach ($all_group_prd as $row) {
                                                if (trim($row->CHR_GROUP_PRODUCT_CODE) == trim($group_prd)) {
                                            ?>
                                                    <option selected value="<? echo $group_prd; ?>"><?php echo trim($row->CHR_GROUP_PRODUCT_DESC); ?></option>
                                                <?php } else { ?>
                                                    <option value="<? echo $row->CHR_GROUP_PRODUCT_CODE; ?>"><?php echo trim($row->CHR_GROUP_PRODUCT_DESC); ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="5%">
                                        <select id="work_center" name="CHR_WORK_CENTER" class="ddl2" style="width:150px;" onchange="document.getElementById('work_center_id').value=this.options[this.selectedIndex].value;">
                                            <option value="">All</option>
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                            ?>
                                                    <option selected value="<?php echo trim($work_center); ?>"> <?php echo trim($work_center); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>"> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="85%" style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;" onclick="tableToExcel('exportToExcel', 'report_history_setup_chute')" value="Export to Excel"><i class="fa fa-download-up"></i></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%">Filter By</td>
                                    <td width="5%">
                                        <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_1" value="1"> &nbsp; Period                                        
                                    </td>
                                    <td width="5%">
                                        <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_2" value="2"> &nbsp; Sequence
                                    </td>
                                    <td width="85%"></td>
                                </tr>
                                <tr id="period">
                                    <td width="5%">Periode</td>
                                    <td width="5%">
                                        <select class="form-control" id="month" name="PERIODE" disabled>
                                            <?php for ($x = -3; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                                                                                    if ($period == date("Ym", strtotime("+$x month"))) {
                                                                                                                        echo 'SELECTED';
                                                                                                                    }
                                                                                                                    ?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="90%" style='text-align:left;'>
                                    </td>
                                </tr>
                                <tr id="sequence">
                                    <td width="5%">Sequence</td>
                                    <td width="5%"><input name="start_seq" id="start" disabled class="form-control" type="number" min="1" placeholder="START" value="" style="width:150px;"></td>
                                    <td width="5%"><input name="end_seq" id="end" disabled class="form-control" type="number" min="1" placeholder="END" value="" style="width:150px;"></td>
                                    <td width="90%" style='text-align:left;'>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%">
                                        <button type="submit" class="btn btn-info" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="90%" style='text-align:left;'>
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">No</th>
                                    <th rowspan="2" style="text-align:center;">Work Center</th>
                                    <th rowspan="2" style="text-align:center;">Part No FG</th>
                                    <th rowspan="2" style="text-align:center;">Back No FG</th>
                                    <th rowspan="2" style="text-align:center;">Qty FG</th>
                                    <th rowspan="2" style="text-align:center;">Part No Comp</th>
                                    <th rowspan="2" style="text-align:center;">Back No Comp</th>
                                    <th rowspan="2" style="text-align:center;">Area</th>
                                    <th rowspan="2" style="text-align:center;">Qty Comp</th>
                                    <th rowspan="2" style="text-align:center;">UoM</th>
                                    <th rowspan="2" style="text-align:center;">Total</th>
                                    <th colspan="31" style="text-align:center;">Month <?php echo $period; ?></th>
                                </tr>
                                <tr>                                    
                                    <th style="text-align:center;">01</th>
                                    <th style="text-align:center;">02</th>
                                    <th style="text-align:center;">03</th>
                                    <th style="text-align:center;">04</th>
                                    <th style="text-align:center;">05</th>
                                    <th style="text-align:center;">06</th>
                                    <th style="text-align:center;">07</th>
                                    <th style="text-align:center;">08</th>
                                    <th style="text-align:center;">09</th>
                                    <th style="text-align:center;">10</th>
                                    <th style="text-align:center;">11</th>
                                    <th style="text-align:center;">12</th>
                                    <th style="text-align:center;">13</th>
                                    <th style="text-align:center;">14</th>
                                    <th style="text-align:center;">15</th>
                                    <th style="text-align:center;">16</th>
                                    <th style="text-align:center;">17</th>
                                    <th style="text-align:center;">18</th>
                                    <th style="text-align:center;">19</th>
                                    <th style="text-align:center;">20</th>
                                    <th style="text-align:center;">21</th>
                                    <th style="text-align:center;">22</th>
                                    <th style="text-align:center;">23</th>
                                    <th style="text-align:center;">24</th>
                                    <th style="text-align:center;">25</th>
                                    <th style="text-align:center;">26</th>
                                    <th style="text-align:center;">27</th>
                                    <th style="text-align:center;">28</th>
                                    <th style="text-align:center;">29</th>
                                    <th style="text-align:center;">30</th>
                                    <th style="text-align:center;">31</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $mtd_plan = 0;
                                if($data != NULL){
                                    foreach ($data as $val) {
                                        if($val->CHR_SOURCE_TYPE == 'A'){
                                            echo "<tr align='center'>";
                                        } else {
                                            echo "<tr align='center' style='color:blue;'>";
                                        }
                                        
                                        echo "<td align='center'>" . $no . "</td>";
                                        echo "<td align='left'>" . $val->CHR_WORK_CENTER . "</td>";
                                        echo "<td align='left'>" . $val->CHR_PART_NO_FG . "</td>";
                                        echo "<td>" . $val->CHR_BACK_NO_FG . "</td>";
                                        echo "<td>" . $val->INT_QTY_FG . "</td>";
                                        echo "<td>" . $val->CHR_PART_NO_COMP . "</td>";

                                        $partno_comp = trim($val->CHR_PART_NO_COMP);
                                        if($val->CHR_TYPE == 'E'){
                                            $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE = '1' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                            if($get_backno->num_rows() > 0){
                                                $backno = $get_backno->row();
                                                echo "<td align='center'>" . $backno->CHR_BACK_NO . "</td>"; 
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "<td align='center'>(E) In-house</td>"; 
                                        } else if($val->CHR_TYPE == 'F'){
                                            $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE = '0' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                            if($get_backno->num_rows() > 0){
                                                $backno = $get_backno->row();
                                                echo "<td align='center'>" . $backno->CHR_BACK_NO . "</td>"; 
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "<td align='center'>(F) External</td>"; 
                                        } else if($val->CHR_TYPE == 'X'){
                                            $get_backno = $this->db->query("SELECT CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE IN ('0','1') AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                            if($get_backno->num_rows() > 0){
                                                $backno = $get_backno->result();
                                                echo "<td align='center'>";
                                                    foreach($backno as $bn){
                                                        echo $bn->CHR_BACK_NO . ' ';
                                                    }
                                                echo "</td>"; 
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "<td align='center'>(X) Both Proc</td>"; 
                                        } else {
                                            echo "<td align='center'>-</td>";
                                            echo "<td align='center'>No Proc</td>";
                                        }

                                        if($val->CHR_UOM == 'G' || $val->CHR_UOM == 'KG'){
                                            echo "<td>" . number_format(((int)$val->DEC_QTY_COMP)/1000,0,',','.') . "</td>";
                                        } else {
                                            echo "<td>" . $val->DEC_QTY_COMP . "</td>";
                                        }
                                        echo "<td>" . $val->CHR_UOM . "</td>";

                                        $mtd_plan = $val->DAY_01 + $val->DAY_02 + $val->DAY_03 + $val->DAY_04 + $val->DAY_05 + $val->DAY_06 + $val->DAY_07 + $val->DAY_08 + $val->DAY_09 + $val->DAY_10 +
                                            $val->DAY_11 + $val->DAY_12 + $val->DAY_13 + $val->DAY_14 + $val->DAY_15 + $val->DAY_16 + $val->DAY_17 + $val->DAY_18 + $val->DAY_19 + $val->DAY_20 +
                                            $val->DAY_21 + $val->DAY_22 + $val->DAY_23 + $val->DAY_24 + $val->DAY_25 + $val->DAY_26 + $val->DAY_27 + $val->DAY_28 + $val->DAY_29 + $val->DAY_30 +
                                            $val->DAY_31;

                                        if($val->CHR_UOM == 'G' || $val->CHR_UOM == 'KG'){
                                            echo "<td>" . number_format(((int)$mtd_plan)/1000,0,',','.') . "</td>";
                                        } else {
                                            echo "<td>" . $mtd_plan . "</td>";
                                        }
                                        
                                        if($val->CHR_UOM == 'G' || $val->CHR_UOM == 'KG'){
                                            echo "<td>" . number_format(((int)$val->DAY_01)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_02)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_03)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_04)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_05)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_06)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_07)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_08)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_09)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_10)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_11)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_12)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_13)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_14)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_15)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_16)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_17)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_18)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_19)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_20)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_21)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_22)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_23)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_24)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_25)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_26)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_27)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_28)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_29)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_30)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_31)/1000,0,',','.') . "</td>";
                                        } else {
                                            echo "<td>" . $val->DAY_01 . "</td>";
                                            echo "<td>" . $val->DAY_02 . "</td>";
                                            echo "<td>" . $val->DAY_03 . "</td>";
                                            echo "<td>" . $val->DAY_04 . "</td>";
                                            echo "<td>" . $val->DAY_05 . "</td>";
                                            echo "<td>" . $val->DAY_06 . "</td>";
                                            echo "<td>" . $val->DAY_07 . "</td>";
                                            echo "<td>" . $val->DAY_08 . "</td>";
                                            echo "<td>" . $val->DAY_09 . "</td>";
                                            echo "<td>" . $val->DAY_10 . "</td>";
                                            echo "<td>" . $val->DAY_11 . "</td>";
                                            echo "<td>" . $val->DAY_12 . "</td>";
                                            echo "<td>" . $val->DAY_13 . "</td>";
                                            echo "<td>" . $val->DAY_14 . "</td>";
                                            echo "<td>" . $val->DAY_15 . "</td>";
                                            echo "<td>" . $val->DAY_16 . "</td>";
                                            echo "<td>" . $val->DAY_17 . "</td>";
                                            echo "<td>" . $val->DAY_18 . "</td>";
                                            echo "<td>" . $val->DAY_19 . "</td>";
                                            echo "<td>" . $val->DAY_20 . "</td>";
                                            echo "<td>" . $val->DAY_21 . "</td>";
                                            echo "<td>" . $val->DAY_22 . "</td>";
                                            echo "<td>" . $val->DAY_23 . "</td>";
                                            echo "<td>" . $val->DAY_24 . "</td>";
                                            echo "<td>" . $val->DAY_25 . "</td>";
                                            echo "<td>" . $val->DAY_26 . "</td>";
                                            echo "<td>" . $val->DAY_27 . "</td>";
                                            echo "<td>" . $val->DAY_28 . "</td>";
                                            echo "<td>" . $val->DAY_29 . "</td>";
                                            echo "<td>" . $val->DAY_30 . "</td>";
                                            echo "<td>" . $val->DAY_31 . "</td>";
                                        }
                                        
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">No</th>
                                    <th rowspan="2" style="text-align:center;">Work Center</th>
                                    <th rowspan="2" style="text-align:center;">Part No FG</th>
                                    <th rowspan="2" style="text-align:center;">Back No FG</th>
                                    <th rowspan="2" style="text-align:center;">Qty FG</th>
                                    <th rowspan="2" style="text-align:center;">Part No Comp</th>
                                    <th rowspan="2" style="text-align:center;">Back No Comp</th>
                                    <th rowspan="2" style="text-align:center;">Area</th>                                    
                                    <th rowspan="2" style="text-align:center;">Qty Comp</th>
                                    <th rowspan="2" style="text-align:center;">UoM</th>
                                    <th rowspan="2" style="text-align:center;">Total</th>
                                    <th colspan="31" style="text-align:center;">Month <?php echo $period; ?></th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">01</th>
                                    <th style="text-align:center;">02</th>
                                    <th style="text-align:center;">03</th>
                                    <th style="text-align:center;">04</th>
                                    <th style="text-align:center;">05</th>
                                    <th style="text-align:center;">06</th>
                                    <th style="text-align:center;">07</th>
                                    <th style="text-align:center;">08</th>
                                    <th style="text-align:center;">09</th>
                                    <th style="text-align:center;">10</th>
                                    <th style="text-align:center;">11</th>
                                    <th style="text-align:center;">12</th>
                                    <th style="text-align:center;">13</th>
                                    <th style="text-align:center;">14</th>
                                    <th style="text-align:center;">15</th>
                                    <th style="text-align:center;">16</th>
                                    <th style="text-align:center;">17</th>
                                    <th style="text-align:center;">18</th>
                                    <th style="text-align:center;">19</th>
                                    <th style="text-align:center;">20</th>
                                    <th style="text-align:center;">21</th>
                                    <th style="text-align:center;">22</th>
                                    <th style="text-align:center;">23</th>
                                    <th style="text-align:center;">24</th>
                                    <th style="text-align:center;">25</th>
                                    <th style="text-align:center;">26</th>
                                    <th style="text-align:center;">27</th>
                                    <th style="text-align:center;">28</th>
                                    <th style="text-align:center;">29</th>
                                    <th style="text-align:center;">30</th>
                                    <th style="text-align:center;">31</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $mtd_plan = 0;
                                if($data != NULL){
                                    foreach ($data as $val) {
                                        echo "<tr align='center'>";
                                        echo "<td align='center'>" . $no . "</td>";
                                        echo "<td align='left'>" . $val->CHR_WORK_CENTER . "</td>";
                                        echo "<td align='left'>" . $val->CHR_PART_NO_FG . "</td>";
                                        echo "<td>" . $val->CHR_BACK_NO_FG . "</td>";
                                        echo "<td>" . $val->INT_QTY_FG . "</td>";
                                        echo "<td>" . $val->CHR_PART_NO_COMP . "</td>";

                                        $partno_comp = trim($val->CHR_PART_NO_COMP);
                                        if($val->CHR_TYPE == 'E'){
                                            $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE = '1' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                            if($get_backno->num_rows() > 0){
                                                $backno = $get_backno->row();
                                                echo "<td align='center'>" . $backno->CHR_BACK_NO . "</td>"; 
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "<td align='center'>(E) In-house</td>"; 
                                        } else if($val->CHR_TYPE == 'F'){
                                            $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE = '0' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                            if($get_backno->num_rows() > 0){
                                                $backno = $get_backno->row();
                                                echo "<td align='center'>" . $backno->CHR_BACK_NO . "</td>"; 
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "<td align='center'>(F) External</td>"; 
                                        } else if($val->CHR_TYPE == 'X'){
                                            $get_backno = $this->db->query("SELECT CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE IN ('0','1') AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                            if($get_backno->num_rows() > 0){
                                                $backno = $get_backno->result();
                                                echo "<td align='center'>";
                                                    foreach($backno as $bn){
                                                        echo $bn->CHR_BACK_NO . ' ';
                                                    }
                                                echo "</td>"; 
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            echo "<td align='center'>(X) Both Proc</td>"; 
                                        } else {
                                            echo "<td align='center'>-</td>";
                                            echo "<td align='center'>No Proc</td>";
                                        }
                                        
                                        if($val->CHR_UOM == 'G' || $val->CHR_UOM == 'KG'){
                                            echo "<td>" . number_format(((int)$val->DEC_QTY_COMP)/1000,0,',','.') . "</td>";
                                        } else {
                                            echo "<td>" . $val->DEC_QTY_COMP . "</td>";
                                        }
                                        echo "<td>" . $val->CHR_UOM . "</td>";

                                        $mtd_plan = $val->DAY_01 + $val->DAY_02 + $val->DAY_03 + $val->DAY_04 + $val->DAY_05 + $val->DAY_06 + $val->DAY_07 + $val->DAY_08 + $val->DAY_09 + $val->DAY_10 +
                                            $val->DAY_11 + $val->DAY_12 + $val->DAY_13 + $val->DAY_14 + $val->DAY_15 + $val->DAY_16 + $val->DAY_17 + $val->DAY_18 + $val->DAY_19 + $val->DAY_20 +
                                            $val->DAY_21 + $val->DAY_22 + $val->DAY_23 + $val->DAY_24 + $val->DAY_25 + $val->DAY_26 + $val->DAY_27 + $val->DAY_28 + $val->DAY_29 + $val->DAY_30 +
                                            $val->DAY_31;

                                        if($val->CHR_UOM == 'G' || $val->CHR_UOM == 'KG'){
                                            echo "<td>" . number_format(((int)$mtd_plan)/1000,0,',','.') . "</td>";
                                        } else {
                                            echo "<td>" . $mtd_plan . "</td>";
                                        }

                                        if($val->CHR_UOM == 'G' || $val->CHR_UOM == 'KG'){
                                            echo "<td>" . number_format(((int)$val->DAY_01)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_02)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_03)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_04)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_05)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_06)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_07)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_08)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_09)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_10)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_11)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_12)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_13)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_14)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_15)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_16)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_17)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_18)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_19)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_20)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_21)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_22)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_23)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_24)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_25)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_26)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_27)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_28)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_29)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_30)/1000,0,',','.') . "</td>";
                                            echo "<td>" . number_format(((int)$val->DAY_31)/1000,0,',','.') . "</td>";
                                        } else {
                                            echo "<td>" . $val->DAY_01 . "</td>";
                                            echo "<td>" . $val->DAY_02 . "</td>";
                                            echo "<td>" . $val->DAY_03 . "</td>";
                                            echo "<td>" . $val->DAY_04 . "</td>";
                                            echo "<td>" . $val->DAY_05 . "</td>";
                                            echo "<td>" . $val->DAY_06 . "</td>";
                                            echo "<td>" . $val->DAY_07 . "</td>";
                                            echo "<td>" . $val->DAY_08 . "</td>";
                                            echo "<td>" . $val->DAY_09 . "</td>";
                                            echo "<td>" . $val->DAY_10 . "</td>";
                                            echo "<td>" . $val->DAY_11 . "</td>";
                                            echo "<td>" . $val->DAY_12 . "</td>";
                                            echo "<td>" . $val->DAY_13 . "</td>";
                                            echo "<td>" . $val->DAY_14 . "</td>";
                                            echo "<td>" . $val->DAY_15 . "</td>";
                                            echo "<td>" . $val->DAY_16 . "</td>";
                                            echo "<td>" . $val->DAY_17 . "</td>";
                                            echo "<td>" . $val->DAY_18 . "</td>";
                                            echo "<td>" . $val->DAY_19 . "</td>";
                                            echo "<td>" . $val->DAY_20 . "</td>";
                                            echo "<td>" . $val->DAY_21 . "</td>";
                                            echo "<td>" . $val->DAY_22 . "</td>";
                                            echo "<td>" . $val->DAY_23 . "</td>";
                                            echo "<td>" . $val->DAY_24 . "</td>";
                                            echo "<td>" . $val->DAY_25 . "</td>";
                                            echo "<td>" . $val->DAY_26 . "</td>";
                                            echo "<td>" . $val->DAY_27 . "</td>";
                                            echo "<td>" . $val->DAY_28 . "</td>";
                                            echo "<td>" . $val->DAY_29 . "</td>";
                                            echo "<td>" . $val->DAY_30 . "</td>";
                                            echo "<td>" . $val->DAY_31 . "</td>";
                                        }
                                                                                   
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

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
        document.body.style.zoom = 0.85;

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
            ],
            fixedColumns: {
                leftColumns: 11
            }
        });
    });

    function get_data_work_center() {
        var group = document.getElementById('group_to_work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('mrp/manage_mrp_c/get_work_center_by_group'); ?>",
            data: {
                GROUP_CODE: group
            },
            success: function(json_data) {
                $("#work_center").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function CheckInput() {
        if (document.getElementById('inp_1').checked) {
            document.getElementById('month').disabled = false;
            document.getElementById('start').disabled = true;
            document.getElementById('end').disabled = true;
        } else {
            document.getElementById('month').disabled = true;
            document.getElementById('start').disabled = false;
            document.getElementById('end').disabled = false;
        }
    }
</script>