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
            <li><a href="<?php echo base_url('index.php/prd/report_ogawa_c/history_production_chute') ?>"><strong>History Production Chute</strong></a></li>
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
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>HISTORY PRODUCTION CHUTE PER DATE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <!-- <a href="<?php echo base_url('index.php/prd/report_ogawa_c/export_history_prod_chute/' . trim($periode) . '/' . trim($id_dept)) ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Report" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Export</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('prd/report_ogawa_c/search_history_production_chute', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Dept</td>
                                    <td width="5%">
                                        <select name="INT_ID_DEPT" id="dept_to_work_center" onchange="get_data_work_center(); document.getElementById('dept_id').value=this.options[this.selectedIndex].value;" class="ddl2" style="width:110px;">
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
                                    <td width="5%">
                                        <select id="work_center" name="CHR_WORK_CENTER" class="ddl2" style="width:150px;" onchange="document.getElementById('work_center_id').value=this.options[this.selectedIndex].value;">
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
                                    <td width="5%">Periode</td>
                                    <td width="5%">
                                        <select class="form-control" id="month" name="PERIODE">
                                            <option value=""></option>
                                            <?php for ($x = -3; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                                                                                    if ($periode == date("Ym", strtotime("+$x month"))) {
                                                                                                                        echo 'SELECTED';
                                                                                                                    }
                                                                                                                    ?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%">
                                        <button type="submit" class="btn btn-success" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
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
                                    <th rowspan="2" style="text-align:center;">Part No</th>
                                    <th rowspan="2" style="text-align:center;">Back No</th>
                                    <th rowspan="2" style="text-align:center;">Part No Cust</th>
                                    <!-- <th rowspan="2" style="text-align:center;">Work Center</th> -->
                                    <th colspan="2" style="text-align:center;">01</th>
                                    <th colspan="2" style="text-align:center;">02</th>
                                    <th colspan="2" style="text-align:center;">03</th>
                                    <th colspan="2" style="text-align:center;">04</th>
                                    <th colspan="2" style="text-align:center;">05</th>
                                    <th colspan="2" style="text-align:center;">06</th>
                                    <th colspan="2" style="text-align:center;">07</th>
                                    <th colspan="2" style="text-align:center;">08</th>
                                    <th colspan="2" style="text-align:center;">09</th>
                                    <th colspan="2" style="text-align:center;">10</th>
                                    <th colspan="2" style="text-align:center;">11</th>
                                    <th colspan="2" style="text-align:center;">12</th>
                                    <th colspan="2" style="text-align:center;">13</th>
                                    <th colspan="2" style="text-align:center;">14</th>
                                    <th colspan="2" style="text-align:center;">15</th>
                                    <th colspan="2" style="text-align:center;">16</th>
                                    <th colspan="2" style="text-align:center;">17</th>
                                    <th colspan="2" style="text-align:center;">18</th>
                                    <th colspan="2" style="text-align:center;">19</th>
                                    <th colspan="2" style="text-align:center;">20</th>
                                    <th colspan="2" style="text-align:center;">21</th>
                                    <th colspan="2" style="text-align:center;">22</th>
                                    <th colspan="2" style="text-align:center;">23</th>
                                    <th colspan="2" style="text-align:center;">24</th>
                                    <th colspan="2" style="text-align:center;">25</th>
                                    <th colspan="2" style="text-align:center;">26</th>
                                    <th colspan="2" style="text-align:center;">27</th>
                                    <th colspan="2" style="text-align:center;">28</th>
                                    <th colspan="2" style="text-align:center;">29</th>
                                    <th colspan="2" style="text-align:center;">30</th>
                                    <th colspan="2" style="text-align:center;">31</th>
                                    <th colspan="3" style="text-align:center;">MTD</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $mtd_plan = 0;
                                $mtd_act = 0;
                                foreach ($data as $val) {
                                    if ($val->CHR_BACK_NO == 'TOTAL') {
                                        echo "<tr align='center' style='background-color:whitesmoke; font-weight:900;'>";
                                        echo "<td style='color:whitesmoke'>" . $no . "</td>";
                                    } else {
                                        echo "<tr align='center'>";
                                        echo "<td>" . $no . "</td>";
                                    }
                                    echo "<td align='left'>" . $val->CHR_PART_NO . "</td>";
                                    echo "<td>" . $val->CHR_BACK_NO . "</td>";

                                    $part_no_cust = $this->db->query("select distinct CHR_CUS_PART_NO from TM_SHIPPING_PARTS where CHR_PART_NO = '$val->CHR_PART_NO'")->result();
                                    $part_no_cust_value = "";
                                    if (count($part_no_cust) > 0) {
                                        foreach ($part_no_cust as $key => $value) {
                                            $part_no_cust_value .= $value->CHR_CUS_PART_NO;
                                            if ($key <> count($part_no_cust) - 1) {
                                                $part_no_cust_value .= " | ";
                                            }
                                        }
                                    }
                                    echo "<td>" . $part_no_cust_value . "</td>";

                                    if ($val->PLAN_01 != 0) {
                                ?>
                                        <td><a onclick='view_plan_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "01"; ?>")'><?php echo $val->PLAN_01; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->PLAN_01 . "</td>";
                                    }
                                    if ($val->ACT_01 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "01"; ?>")'><?php echo $val->ACT_01; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_01 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_02 . "</td>";
                                    if ($val->ACT_02 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "02"; ?>")'><?php echo $val->ACT_02; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_02 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_03 . "</td>";
                                    if ($val->ACT_03 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "03"; ?>")'><?php echo $val->ACT_03; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_03 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_04 . "</td>";
                                    if ($val->ACT_04 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "04"; ?>")'><?php echo $val->ACT_04; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_04 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_05 . "</td>";
                                    if ($val->ACT_05 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "05"; ?>")'><?php echo $val->ACT_05; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_05 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_06 . "</td>";
                                    if ($val->ACT_06 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "06"; ?>")'><?php echo $val->ACT_06; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_06 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_07 . "</td>";
                                    if ($val->ACT_07 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "07"; ?>")'><?php echo $val->ACT_07; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_07 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_08 . "</td>";
                                    if ($val->ACT_08 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "08"; ?>")'><?php echo $val->ACT_08; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_08 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_09 . "</td>";
                                    if ($val->ACT_09 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "09"; ?>")'><?php echo $val->ACT_09; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_09 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_10 . "</td>";
                                    if ($val->ACT_10 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "10"; ?>")'><?php echo $val->ACT_10; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_10 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_11 . "</td>";
                                    if ($val->ACT_11 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "11"; ?>")'><?php echo $val->ACT_11; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_11 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_12 . "</td>";
                                    if ($val->ACT_12 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "12"; ?>")'><?php echo $val->ACT_12; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_12 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_13 . "</td>";
                                    if ($val->ACT_13 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "13"; ?>")'><?php echo $val->ACT_13; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_13 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_14 . "</td>";
                                    if ($val->ACT_14 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "14"; ?>")'><?php echo $val->ACT_14; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_14 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_15 . "</td>";
                                    if ($val->ACT_15 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "15"; ?>")'><?php echo $val->ACT_15; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_15 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_16 . "</td>";
                                    if ($val->ACT_16 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "16"; ?>")'><?php echo $val->ACT_16; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_16 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_17 . "</td>";
                                    if ($val->ACT_17 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "17"; ?>")'><?php echo $val->ACT_17; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_17 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_18 . "</td>";
                                    if ($val->ACT_18 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "18"; ?>")'><?php echo $val->ACT_18; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_18 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_19 . "</td>";
                                    if ($val->ACT_19 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "19"; ?>")'><?php echo $val->ACT_19; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_19 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_20 . "</td>";
                                    if ($val->ACT_20 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "20"; ?>")'><?php echo $val->ACT_20; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_20 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_21 . "</td>";
                                    if ($val->ACT_21 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "21"; ?>")'><?php echo $val->ACT_21; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_21 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_22 . "</td>";
                                    if ($val->ACT_22 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "22"; ?>")'><?php echo $val->ACT_22; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_22 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_23 . "</td>";
                                    if ($val->ACT_23 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "23"; ?>")'><?php echo $val->ACT_23; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_23 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_24 . "</td>";
                                    if ($val->ACT_24 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "24"; ?>")'><?php echo $val->ACT_24; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_24 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_25 . "</td>";
                                    if ($val->ACT_25 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "25"; ?>")'><?php echo $val->ACT_25; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_25 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_26 . "</td>";
                                    if ($val->ACT_26 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "26"; ?>")'><?php echo $val->ACT_26; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_26 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_27 . "</td>";
                                    if ($val->ACT_27 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "27"; ?>")'><?php echo $val->ACT_27; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_27 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_28 . "</td>";
                                    if ($val->ACT_28 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "28"; ?>")'><?php echo $val->ACT_28; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_28 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_29 . "</td>";
                                    if ($val->ACT_29 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "29"; ?>")'><?php echo $val->ACT_29; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_29 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_30 . "</td>";
                                    if ($val->ACT_30 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "30"; ?>")'><?php echo $val->ACT_30; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_30 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_31 . "</td>";
                                    if ($val->ACT_31 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "31"; ?>")'><?php echo $val->ACT_31; ?></a></td>
                                <?php
                                    } else {
                                        echo "<td>" . $val->ACT_31 . "</td>";
                                    }


                                    $mtd_plan = $val->PLAN_01 + $val->PLAN_02 + $val->PLAN_03 + $val->PLAN_04 + $val->PLAN_05 + $val->PLAN_06 + $val->PLAN_07 + $val->PLAN_08 + $val->PLAN_09 + $val->PLAN_10 +
                                        $val->PLAN_11 + $val->PLAN_12 + $val->PLAN_13 + $val->PLAN_14 + $val->PLAN_15 + $val->PLAN_16 + $val->PLAN_17 + $val->PLAN_18 + $val->PLAN_19 + $val->PLAN_20 +
                                        $val->PLAN_21 + $val->PLAN_22 + $val->PLAN_23 + $val->PLAN_24 + $val->PLAN_25 + $val->PLAN_26 + $val->PLAN_27 + $val->PLAN_28 + $val->PLAN_29 + $val->PLAN_30 +
                                        $val->PLAN_31;
                                    $mtd_act = $val->ACT_01 + $val->ACT_02 + $val->ACT_03 + $val->ACT_04 + $val->ACT_05 + $val->ACT_06 + $val->ACT_07 + $val->ACT_08 + $val->ACT_09 + $val->ACT_10 +
                                        $val->ACT_11 + $val->ACT_12 + $val->ACT_13 + $val->ACT_14 + $val->ACT_15 + $val->ACT_16 + $val->ACT_17 + $val->ACT_18 + $val->ACT_19 + $val->ACT_20 +
                                        $val->ACT_21 + $val->ACT_22 + $val->ACT_23 + $val->ACT_24 + $val->ACT_25 + $val->ACT_26 + $val->ACT_27 + $val->ACT_28 + $val->ACT_29 + $val->ACT_30 +
                                        $val->ACT_31;
                                    $balance = $mtd_act - $mtd_plan;
                                    echo "<td>" . $mtd_plan . "</td>";
                                    echo "<td>" . $mtd_act . "</td>";
                                    if($balance < 0){
                                        echo "<td style='font-weight:bold; color:red;'>" . $balance . "</td>";
                                    } else {
                                        echo "<td>" . $balance . "</td>";
                                    }
                                    
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">No</th>
                                    <th rowspan="2" style="text-align:center;">Part No</th>
                                    <th rowspan="2" style="text-align:center;">Back No</th>
                                    <th rowspan="2" style="text-align:center;">Part No Cust</th>
                                    <!-- <th rowspan="2" style="text-align:center;">Work Center</th> -->
                                    <th colspan="2" style="text-align:center;">01</th>
                                    <th colspan="2" style="text-align:center;">02</th>
                                    <th colspan="2" style="text-align:center;">03</th>
                                    <th colspan="2" style="text-align:center;">04</th>
                                    <th colspan="2" style="text-align:center;">05</th>
                                    <th colspan="2" style="text-align:center;">06</th>
                                    <th colspan="2" style="text-align:center;">07</th>
                                    <th colspan="2" style="text-align:center;">08</th>
                                    <th colspan="2" style="text-align:center;">09</th>
                                    <th colspan="2" style="text-align:center;">10</th>
                                    <th colspan="2" style="text-align:center;">11</th>
                                    <th colspan="2" style="text-align:center;">12</th>
                                    <th colspan="2" style="text-align:center;">13</th>
                                    <th colspan="2" style="text-align:center;">14</th>
                                    <th colspan="2" style="text-align:center;">15</th>
                                    <th colspan="2" style="text-align:center;">16</th>
                                    <th colspan="2" style="text-align:center;">17</th>
                                    <th colspan="2" style="text-align:center;">18</th>
                                    <th colspan="2" style="text-align:center;">19</th>
                                    <th colspan="2" style="text-align:center;">20</th>
                                    <th colspan="2" style="text-align:center;">21</th>
                                    <th colspan="2" style="text-align:center;">22</th>
                                    <th colspan="2" style="text-align:center;">23</th>
                                    <th colspan="2" style="text-align:center;">24</th>
                                    <th colspan="2" style="text-align:center;">25</th>
                                    <th colspan="2" style="text-align:center;">26</th>
                                    <th colspan="2" style="text-align:center;">27</th>
                                    <th colspan="2" style="text-align:center;">28</th>
                                    <th colspan="2" style="text-align:center;">29</th>
                                    <th colspan="2" style="text-align:center;">30</th>
                                    <th colspan="2" style="text-align:center;">31</th>
                                    <th colspan="3" style="text-align:center;">MTD</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Actual</th>
                                    <th style="text-align:center;">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $mtd_plan = 0;
                                $mtd_act = 0;
                                foreach ($data as $val) {
                                    if ($val->CHR_BACK_NO == 'TOTAL') {
                                        echo "<tr align='center' style='background-color:whitesmoke; font-weight:900;'>";
                                        echo "<td style='color:whitesmoke'>" . $no . "</td>";
                                    } else {
                                        echo "<tr align='center'>";
                                        echo "<td>" . $no . "</td>";
                                    }
                                    echo "<td align='left'>" . $val->CHR_PART_NO . "</td>";
                                    echo "<td>" . $val->CHR_BACK_NO . "</td>";

                                    $part_no_cust = $this->db->query("select distinct CHR_CUS_PART_NO from TM_SHIPPING_PARTS where CHR_PART_NO = '$val->CHR_PART_NO'")->result();
                                    $part_no_cust_value = "";
                                    if (count($part_no_cust) > 0) {
                                        foreach ($part_no_cust as $key => $value) {
                                            $part_no_cust_value .= $value->CHR_CUS_PART_NO;
                                            if ($key <> count($part_no_cust) - 1) {
                                                $part_no_cust_value .= " | ";
                                            }
                                        }
                                    }
                                    echo "<td>" . $part_no_cust_value . "</td>";

                                    if ($val->PLAN_01 != 0) {
                                ?>
                                        <td><a onclick='view_plan_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "01"; ?>")'><?php echo $val->PLAN_01; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->PLAN_01 . "</td>";
                                    }
                                    if ($val->ACT_01 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "01"; ?>")'><?php echo $val->ACT_01; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_01 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_02 . "</td>";
                                    if ($val->ACT_02 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "02"; ?>")'><?php echo $val->ACT_02; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_02 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_03 . "</td>";
                                    if ($val->ACT_03 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "03"; ?>")'><?php echo $val->ACT_03; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_03 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_04 . "</td>";
                                    if ($val->ACT_04 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "04"; ?>")'><?php echo $val->ACT_04; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_04 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_05 . "</td>";
                                    if ($val->ACT_05 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "05"; ?>")'><?php echo $val->ACT_05; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_05 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_06 . "</td>";
                                    if ($val->ACT_06 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "06"; ?>")'><?php echo $val->ACT_06; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_06 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_07 . "</td>";
                                    if ($val->ACT_07 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "07"; ?>")'><?php echo $val->ACT_07; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_07 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_08 . "</td>";
                                    if ($val->ACT_08 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "08"; ?>")'><?php echo $val->ACT_08; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_08 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_09 . "</td>";
                                    if ($val->ACT_09 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "09"; ?>")'><?php echo $val->ACT_09; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_09 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_10 . "</td>";
                                    if ($val->ACT_10 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "10"; ?>")'><?php echo $val->ACT_10; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_10 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_11 . "</td>";
                                    if ($val->ACT_11 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "11"; ?>")'><?php echo $val->ACT_11; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_11 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_12 . "</td>";
                                    if ($val->ACT_12 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "12"; ?>")'><?php echo $val->ACT_12; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_12 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_13 . "</td>";
                                    if ($val->ACT_13 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "13"; ?>")'><?php echo $val->ACT_13; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_13 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_14 . "</td>";
                                    if ($val->ACT_14 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "14"; ?>")'><?php echo $val->ACT_14; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_14 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_15 . "</td>";
                                    if ($val->ACT_15 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "15"; ?>")'><?php echo $val->ACT_15; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_15 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_16 . "</td>";
                                    if ($val->ACT_16 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "16"; ?>")'><?php echo $val->ACT_16; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_16 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_17 . "</td>";
                                    if ($val->ACT_17 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "17"; ?>")'><?php echo $val->ACT_17; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_17 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_18 . "</td>";
                                    if ($val->ACT_18 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "18"; ?>")'><?php echo $val->ACT_18; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_18 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_19 . "</td>";
                                    if ($val->ACT_19 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "19"; ?>")'><?php echo $val->ACT_19; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_19 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_20 . "</td>";
                                    if ($val->ACT_20 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "20"; ?>")'><?php echo $val->ACT_20; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_20 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_21 . "</td>";
                                    if ($val->ACT_21 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "21"; ?>")'><?php echo $val->ACT_21; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_21 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_22 . "</td>";
                                    if ($val->ACT_22 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "22"; ?>")'><?php echo $val->ACT_22; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_22 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_23 . "</td>";
                                    if ($val->ACT_23 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "23"; ?>")'><?php echo $val->ACT_23; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_23 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_24 . "</td>";
                                    if ($val->ACT_24 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "24"; ?>")'><?php echo $val->ACT_24; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_24 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_25 . "</td>";
                                    if ($val->ACT_25 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "25"; ?>")'><?php echo $val->ACT_25; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_25 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_26 . "</td>";
                                    if ($val->ACT_26 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "26"; ?>")'><?php echo $val->ACT_26; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_26 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_27 . "</td>";
                                    if ($val->ACT_27 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "27"; ?>")'><?php echo $val->ACT_27; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_27 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_28 . "</td>";
                                    if ($val->ACT_28 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "28"; ?>")'><?php echo $val->ACT_28; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_28 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_29 . "</td>";
                                    if ($val->ACT_29 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "29"; ?>")'><?php echo $val->ACT_29; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_29 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_30 . "</td>";
                                    if ($val->ACT_30 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "30"; ?>")'><?php echo $val->ACT_30; ?></a></td>
                                    <?php
                                    } else {
                                        echo "<td>" . $val->ACT_30 . "</td>";
                                    }

                                    echo "<td>" . $val->PLAN_31 . "</td>";
                                    if ($val->ACT_31 != 0) {
                                    ?>
                                        <td style='font-weight:bold;'><a onclick='view_actual_lot(" <?php echo $val->CHR_BACK_NO; ?> ","<?php echo $periode . "31"; ?>")'><?php echo $val->ACT_31; ?></a></td>
                                <?php
                                    } else {
                                        echo "<td>" . $val->ACT_31 . "</td>";
                                    }


                                    $mtd_plan = $val->PLAN_01 + $val->PLAN_02 + $val->PLAN_03 + $val->PLAN_04 + $val->PLAN_05 + $val->PLAN_06 + $val->PLAN_07 + $val->PLAN_08 + $val->PLAN_09 + $val->PLAN_10 +
                                        $val->PLAN_11 + $val->PLAN_12 + $val->PLAN_13 + $val->PLAN_14 + $val->PLAN_15 + $val->PLAN_16 + $val->PLAN_17 + $val->PLAN_18 + $val->PLAN_19 + $val->PLAN_20 +
                                        $val->PLAN_21 + $val->PLAN_22 + $val->PLAN_23 + $val->PLAN_24 + $val->PLAN_25 + $val->PLAN_26 + $val->PLAN_27 + $val->PLAN_28 + $val->PLAN_29 + $val->PLAN_30 +
                                        $val->PLAN_31;
                                    $mtd_act = $val->ACT_01 + $val->ACT_02 + $val->ACT_03 + $val->ACT_04 + $val->ACT_05 + $val->ACT_06 + $val->ACT_07 + $val->ACT_08 + $val->ACT_09 + $val->ACT_10 +
                                        $val->ACT_11 + $val->ACT_12 + $val->ACT_13 + $val->ACT_14 + $val->ACT_15 + $val->ACT_16 + $val->ACT_17 + $val->ACT_18 + $val->ACT_19 + $val->ACT_20 +
                                        $val->ACT_21 + $val->ACT_22 + $val->ACT_23 + $val->ACT_24 + $val->ACT_25 + $val->ACT_26 + $val->ACT_27 + $val->ACT_28 + $val->ACT_29 + $val->ACT_30 +
                                        $val->ACT_31;
                                    $balance = $mtd_plan - $mtd_act;
                                    echo "<td>" . $mtd_plan . "</td>";
                                    echo "<td>" . $mtd_act . "</td>";
                                    echo "<td>" . $balance . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- MODAL FOR PLAN AND ACTUAL LOT -->
                    <div class="modal" id="modalActualLot" tabindex="-1" style="display: none;"></div>
                    <div class="modal" id="modalPlanLot" tabindex="-1" style="display: none;"></div>
                    <!-- END MODAL -->
                </div>
            </div>

            <!-- VIEW PROD RESULT -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>SUMMARY HISTORY PRODUCTION CHUTE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools"></div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='450px' src="<?php echo site_url("prd/report_ogawa_c/view_history_production_chute/" . $work_center . "/" . $periode); ?>"></iframe>
                    </div>
                </div>
            </div>
            <!-- VIEW PROD RESULT -->
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
            ],
            fixedColumns: {
                leftColumns: 4,
                rightColumns: 3
            }
        });
    });

    function get_data_work_center() {
        var dept_to_work_center = document.getElementById('dept_to_work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
            data: {
                INT_ID_DEPT: dept_to_work_center
            },
            success: function(json_data) {
                $("#work_center").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function view_actual_lot(back_no, act_date) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/report_ogawa_c/view_actual_lot'); ?>",
            data: "backno=" + back_no + "&date_act=" + act_date,
            success: function(data) {
                // alert(data);     
                document.getElementById("modalActualLot").style.display = "block";
                $("#modalActualLot").html(data);
            }
        });
    }

    function hide_actual_lot() {
        document.getElementById("modalActualLot").style.display = "none";
    }

    function view_plan_lot(back_no, plan_date) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/report_ogawa_c/view_plan_lot'); ?>",
            data: "backno=" + back_no + "&date_plan=" + plan_date,
            success: function(data) {
                // alert(data);     
                document.getElementById("modalPlanLot").style.display = "block";
                $("#modalPlanLot").html(data);
            }
        });
    }

    function hide_plan_lot() {
        document.getElementById("modalPlanLot").style.display = "none";
    }
</script>