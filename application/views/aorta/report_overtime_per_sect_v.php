<?php
$aortadb = $this->load->database("aorta", TRUE);
?>

<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
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
    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
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
        width: 220px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT OVERTIME PER SECTION</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <!-- REPORT OVERTIME BY HOUR -->
                <script type="text/javascript">
                    window.onload = function () {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme2",
                                    toolTip: {
                                        shared: true
                                    },
                                    axisY: {
                                        title: "Man Hour (MH)",
                                        gridThickness:0.2,
                                        interval: 5000
                                    },
                                    axisX: {
                                        labelFontSize: 14
                                    },
                                    data: [
                                        {
                                            type: "column",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "OBG (Hour)",
                                            legendText: "OBG",
                                            showInLegend: true,
                                            dataPoints: [
<?php
$count_over_plan = count($overtime_summary);
$row_plan = 1;
foreach ($overtime_summary as $plan) {
    if ($row_plan == $count_over_plan) {
        if ($plan->OBG <= 0) {
            echo '{label: "' . $plan->KD_SECTION . '", y:' . 0 . '}';
        } else {
            echo '{label: "' . $plan->KD_SECTION . '", y:' . $plan->OBG . ', indexLabel:"' . number_format($plan->OBG, 0, ",", ".") . '"}';
        }
    } else {
        if ($plan->OBG <= 0) {
            echo '{label: "' . $plan->KD_SECTION . '", y:' . 0 . '},';
        } else {
            echo '{label: "' . $plan->KD_SECTION . '", y:' . $plan->OBG . ', indexLabel:"' . number_format($plan->OBG, 0, ",", ".") . '"},';
        }
        $row_plan++;
    }
}
?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "OUTLOOK (Hour)",
                                            legendText: "OUTLOOK",
                                            //axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
<?php
$count_over_quota = count($overtime_summary);
$row_quo = 1;
foreach ($overtime_summary as $quota) {
    if ($row_quo == $count_over_quota) {
        echo '{label: "' . $quota->KD_SECTION . '", y:' . $quota->QUOTA_STD . ', indexLabel:"' . number_format($quota->QUOTA_STD, 0, ",", ".") . '"}';
    } else {
        echo '{label: "' . $quota->KD_SECTION . '", y:' . $quota->QUOTA_STD . ', indexLabel:"' . number_format($quota->QUOTA_STD, 0, ",", ".") . '"},';
        $row_quo++;
    }
}
?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "QUOTA (Hour)",
                                            legendText: "QUOTA",
                                            //axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
<?php
$count_over_quota = count($overtime_summary);
$row_quo = 1;
foreach ($overtime_summary as $quota) {
    if ($row_quo == $count_over_quota) {
        echo '{label: "' . $quota->KD_SECTION . '", y:' . ($quota->QUOTA_PLAN + $quota->QUOTA_PLAN1) . ', indexLabel:"' . number_format(($quota->QUOTA_PLAN + $quota->QUOTA_PLAN1), 0, ",", ".") . '"}';
    } else {
        echo '{label: "' . $quota->KD_SECTION . '", y:' . ($quota->QUOTA_PLAN + $quota->QUOTA_PLAN1) . ', indexLabel:"' . number_format(($quota->QUOTA_PLAN + $quota->QUOTA_PLAN1), 0, ",", ".") . '"},';
        $row_quo++;
    }
}
?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "ACTUAL (Hour)",
                                            legendText: "ACTUAL",
                                            //axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
<?php
$count_over_actual = count($overtime_summary);
$row_act = 1;
foreach ($overtime_summary as $actual) {
    if ($row_act == $count_over_actual) {
        echo '{label: "' . $actual->KD_SECTION . '", y:' . $actual->TOT_DURASI_OVERTIME . ', indexLabel:"' . number_format($actual->TOT_DURASI_OVERTIME, 0, ",", ".") . '"}';
    } else {
        echo '{label: "' . $actual->KD_SECTION . '", y:' . $actual->TOT_DURASI_OVERTIME . ', indexLabel:"' . number_format($actual->TOT_DURASI_OVERTIME, 0, ",", ".") . '"},';
        $row_act++;
    }
}
?>
                                            ]
                                        }
                                    ],
                                    legend: {
                                        cursor: "pointer",
                                        itemclick: function (e) {
                                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                                e.dataSeries.visible = false;
                                            }
                                            else {
                                                e.dataSeries.visible = true;
                                            }
                                            chart.render();
                                        }
                                    }
                                });

                        chart.render();
                    };
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>OVERTIME PER SECTION CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        
                        <?php if ($overtime_summary == null && $overtime_quota == null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT OVERTIME PER SECTION</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">

                                <table width="100%" id='filter' border=0px>
                                    <tr>
                                        <td width="5%">Periode</td>
                                        <td width="15%">
                                            <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                                <?php for ($x = -20; $x <= 1; $x++) {  $y = $x * 28 ?>
                                                    <option value="<?php echo site_url('aorta/report_overtime_persect_c/index/' . date("Ym", strtotime("+$y day")) . "/$id_dept/$id_section"); ?>" <?php
                                                    if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                        <?php } ?>
                                            </select>
                                        </td>
                                        <td width="5%">Dept</td>
                                        <td width="10%">
                                            <?php //if ($role == 5 || $role == 6 || $role == 39 || $role == 45) { ?>
                                                <!-- <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2"> -->
                                                <?php //} else { ?>
                                                    <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                    <?php //} ?>
                                                        <!--<option value="<?php //echo site_url('aorta/report_overtime_persect_c/index/' . $selected_date . "/ALL") ?>">ALL</option>-->
                                                        <option value="">-- Select Dept --</option>
                                                    <?php foreach ($all_dept_prod as $row) { ?>
                                                        <option value="<?php echo site_url("aorta/report_overtime_persect_c/index/" . $selected_date . '/' . $row->INT_ID_DEPT . "/ALL"); ?>" <?php
                                                        if ($id_dept == $row->INT_ID_DEPT) {
                                                            echo 'SELECTED';
                                                        }
                                                        ?> ><?php echo trim($row->CHR_DEPT_DESC); ?></option>
                                                            <?php } ?>
                                                </select>

                                           
                                        </td>
                                        <td width="55%" style='text-align:right;'>
                                            <?php echo form_open('aorta/report_overtime_persect_c/print_report_overtime', 'class="form-horizontal"'); ?>
                                                <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                                                <input name="CHR_DEPT_SELECTED" value="<?php echo $id_dept ?>" type="hidden">
                                                <input name="CHR_SECTION_SELECTED" value="<?php echo $id_section ?>" type="hidden">
                                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                            <?php echo form_close() ?>     
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                         <td>Section</td>
                                        <td>
                                            <select  onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <option value="<?php echo site_url('aorta/report_overtime_persect_c/index/' . $selected_date . "/$id_dept/ALL") ?>">ALL</option>
                                                <?php foreach ($all_section as $row) { ?>
                                                    <option value="<?php echo site_url('aorta/report_overtime_persect_c/index/' . $selected_date . "/$id_dept/" . trim($row->KODE)); ?>" 
                                                    <?php
                                                    if (trim($id_section) == trim($row->KODE)) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> >
                                                        <?php echo trim($row->KODE); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td >    
                                          
                                        </td>
                                    </tr>
                                   
                                </table>
                            </div>
                            
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" >
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">Section</th>
                                        <th rowspan="2" style="vertical-align: middle;">Criteria</th>
                                        <th rowspan="2" style="vertical-align: middle;"></th>
                                        <th rowspan="2" style="vertical-align: middle;">Total</th>
                                        <th colspan="31" style="vertical-align: middle;text-align:center;">Date</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        //(date("t", strtotime($selected_date . "01")) + 1)
                                        for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                            $day = sprintf("%02d", $index);
                                            $date = $selected_date . $day;
                                            $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                            . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                            if ($holiday == 0) {
                                                ?>
                                                <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:50px;" ><?php echo $index ?></th>
                                                <?php
                                            } else {
                                                ?>
                                                <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:50px; color: #ffffff; background-color: #DD0000" ><?php echo $index ?></th>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>


                                </thead>
                                <tbody>

                                    <?php foreach ($overtime_summary as $value) { ?>
                                        <!-- MAN POWER -->
                                        <tr>
                                            <td rowspan="11" style="text-align: center; vertical-align: middle; background-color: #F3F4F5">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="1" style="text-align: right; vertical-align: middle; background-color: #F3F4F5">
                                                Man Power (MP)
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                ---
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo $value->MP; ?>
                                            </td>

                                            <?php
                                            //(date("t", strtotime($selected_date . "01")) + 1)
                                            for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                //$holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                //                . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                //if ($holiday == 0) {
                                                    ?>
                                                    <td style="text-align:center;"><?php echo $value->MP; ?></td>
                                                <?php //} else { ?>
                                                    <!--<td style="text-align:center;">0</td>-->
                                                    <?php
                                                //}
                                            }
                                            ?>

                                        </tr>

                                        <!-- OT PLAN - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                OT Plan
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                MH
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                <?php
                                                if ($value->PLAN_BY_WO <= 0) {
                                                    echo '0,0';
                                                } else {
                                                    echo number_format($value->PLAN_BY_WO,1,',','.');
                                                }
                                                ?>
                                            </td>

                                            <?php
                                            if($value->PLAN_BY_WO <= 0){
                                                $plan_wo = 0;
                                            }else{
                                                $plan_wo = $value->PLAN_BY_WO;
                                            }
                                            
                                            if($value->WORKING_DAY == 0){
                                                $wd = 20;
                                            }else{
                                                $wd = $value->WORKING_DAY;
                                            }
                                            
                                            if($value->MP == 0){
                                                $mp = 1;
                                            }else{
                                                $mp = $value->MP;
                                            }
                                            
                                            $max_ot_per_day = 3.5*$mp;
                                            $max_ot_holiday = 8*$mp;
                                            $ot_day = $plan_wo / $max_ot_per_day;
                                            $ot_per_day = $plan_wo / $wd;
                                            if ($ot_day <= $wd) {
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($ot_per_day,1,',','.'); ?></td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <td style="text-align:center;">0,0</td>
                                                        <?php
                                                    }                                                    
                                                }
                                            }else{
                                                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($max_ot_per_day,1,',','.'); ?></td>
                                                        <?php
                                                    }else{
                                                        if($ot_holiday >= $max_ot_holiday){
                                                            ?>
                                                            <td style="text-align:center;"><?php echo number_format($max_ot_holiday,1,',','.'); ?></td>
                                                        <?php
                                                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($ot_holiday,1,',','.'); ?></td>
                                                        <?php
                                                        }else{
                                                        ?>
                                                            <td style="text-align:center;">0,0</td>
                                                        <?php
                                                        }
                                                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        
                                        <!-- OT PLAN - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Plan
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <?php
                                                if($value->PLAN_BY_WO <= 0){
                                                    $plan_wo = 0;
                                                }else{
                                                    $plan_wo = $value->PLAN_BY_WO;
                                                }

                                                if($value->WORKING_DAY == 0){
                                                    $wd = 20;
                                                }else{
                                                    $wd = $value->WORKING_DAY;
                                                }

                                                if($value->MP == 0){
                                                    $mp = 1;
                                                }else{
                                                    $mp = $value->MP;
                                                }

                                                $max_ot_per_day = 3.5*$mp;
                                                $max_ot_holiday = 8*$mp;
                                                $ot_day = $plan_wo / $max_ot_per_day;
                                                $ot_per_day = $plan_wo / $wd;
                                                $amount = $value->AVG_TUL;
                                            ?>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($amount*2*$plan_wo*0.006,2,',','.'); ?>
                                            </td>
                                            <?php
                                            if($ot_day <= $wd){
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($amount*2*$ot_per_day*0.006,2,',','.')  ;?></td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td style="text-align:center;">0,00</td>
                                                        <?php
                                                    }
                                                    
                                                }
                                            }else{
                                                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($amount*2*$max_ot_per_day*0.006,2,',','.')  ;?></td>
                                                        <?php
                                                    } else {
                                                        if($ot_holiday >= $max_ot_holiday){
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($amount*2*$max_ot_holiday*0.006,2,',','.')  ;?></td>
                                                        <?php
                                                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($amount*2*$ot_holiday*0.006,2,',','.')  ;?></td>
                                                        <?php
                                                        }else{
                                                        ?>
                                                            <td style="text-align:center;">0,00</td>
                                                        <?php
                                                        }
                                                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                                                    }        
                                                }
                                            }
                                            ?>
                                        </tr>
                                        
                                        <!-- OT ACTUAL - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Actual
                                            </td>
                                            <td style="text-align:center;">
                                                MH
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($value->TOT_DURASI_OVERTIME,1,',','.'); ?>
                                            </td>
                                            <?php
                                            $actual_hour = $aortadb->query("EXEC zsp_get_actual_overtime_hour_section '$selected_date', '" . $value->KD_DEPT . "' , '" . $value->KD_SECTION . "'")->row();

                                            for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $act_hour = 'HOUR_' . $day;
                                                ?>
                                                <td style="text-align:center;">
                                                    <?php echo number_format($actual_hour->$act_hour,1,',','.'); ?>
                                                </td>
                                                <?php
                                            }
                                            ?>

                                        </tr>
                                        <!-- OT ACTUAL - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($value->TOT_AMOUNT_OVERTIME,2,',','.'); ?>
                                            </td>

                                            <?php
                                            $actual_amount = $aortadb->query("EXEC zsp_get_actual_overtime_amount_section '$selected_date', '" . $value->KD_DEPT . "' , '" . $value->KD_SECTION . "'")->row();

                                            for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $act_amo = 'AMO_' . $day;
                                                ?>
                                                <td style="text-align:center;">
                                                    <?php echo number_format($actual_amount->$act_amo,2,',','.'); ?>
                                                </td>
                                                <?php
                                            }
                                            ?>

                                        </tr>
                                        <!-- ACCUMULATIVE PLAN - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center;vertical-align: middle; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Accumulative Plan 
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                MH
                                            </td>
                                            <?php
                                                if($value->PLAN_BY_WO <= 0){
                                                    $plan_wo = 0;
                                                }else{
                                                    $plan_wo = $value->PLAN_BY_WO;
                                                }

                                                if($value->WORKING_DAY == 0){
                                                    $wd = 20;
                                                }else{
                                                    $wd = $value->WORKING_DAY;
                                                }

                                                if($value->MP == 0){
                                                    $mp = 1;
                                                }else{
                                                    $mp = $value->MP;
                                                }

                                                $max_ot_per_day = 3.5*$mp;
                                                $max_ot_holiday = 8*$mp;
                                                $ot_day = $plan_wo / $max_ot_per_day;
                                                $ot_per_day = $plan_wo / $wd;
                                                $plan_accu = 0;
                                            ?>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($plan_wo,1,',','.'); ?>
                                            </td>
                                            <?php 
                                            if($ot_day <= $wd){
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $plan_accu = $plan_accu + $ot_per_day;
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_accu,1,',','.'); ?></td>
                                                        <?php    
                                                    } else {
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_accu,1,',','.'); ?></td>
                                                        <?php
                                                    }
                                                    
                                                }
                                            }else{
                                                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $plan_accu = $plan_accu + $max_ot_per_day;    
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_accu,1,',','.'); ?></td>
                                                        <?php
                                                    }else{
                                                        if($ot_holiday >= $max_ot_holiday){
                                                            $plan_accu = $plan_accu + $max_ot_holiday;
                                                            ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_accu,1,',','.'); ?></td>
                                                        <?php
                                                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                                                            $plan_accu = $plan_accu + $ot_holiday;
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_accu,1,',','.'); ?></td>
                                                        <?php
                                                        }else{
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_accu,1,',','.'); ?></td>
                                                        <?php
                                                        }
                                                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        
                                        <!-- ACCUMULATIVE PLAN - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; //$value->NAMA_SUBSECT;      ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Accumulative Plan
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <?php
                                                if($value->PLAN_BY_WO <= 0){
                                                    $plan_wo = 0;
                                                }else{
                                                    $plan_wo = $value->PLAN_BY_WO;
                                                }
                                                
                                                if($value->WORKING_DAY == 0){
                                                    $wd = 20;
                                                }else{
                                                    $wd = $value->WORKING_DAY;
                                                }

                                                if($value->MP == 0){
                                                    $mp = 1;
                                                }else{
                                                    $mp = $value->MP;
                                                }

                                                $max_ot_per_day = 3.5*$mp;
                                                $max_ot_holiday = 8*$mp;
                                                $ot_day = $plan_wo / $max_ot_per_day;
                                                $ot_per_day = $plan_wo / $wd;
                                                $plan_amount = 0;
                                            ?>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($amount*2*$plan_wo*0.006,2,',','.'); ?>
                                            </td>
                                            <?php
                                            if($ot_day <= $wd){
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $plan_amount = $plan_amount + ($amount*2*$ot_per_day*0.006);
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_amount,2,',','.')  ;?></td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td style="text-align:center;"><?php echo number_format($plan_amount,2,',','.'); ?></td>
                                                        <?php
                                                    }
                                                    
                                                }
                                            }else{
                                                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $plan_amount = $plan_amount + ($amount*2*$max_ot_per_day*0.006);
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_amount,2,',','.')  ;?></td>
                                                        <?php
                                                    } else {
                                                        if($ot_holiday >= $max_ot_holiday){
                                                            $plan_amount = $plan_amount + ($amount*2*$max_ot_holiday*0.006);
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_amount,2,',','.')  ;?></td>
                                                        <?php
                                                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                                                            $plan_amount = $plan_amount + ($amount*2*$ot_holiday*0.006);
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($plan_amount,2,',','.')  ;?></td>
                                                        <?php
                                                        }else{
                                                        ?>
                                                            <td style="text-align:center;">0,00</td>
                                                        <?php
                                                        }
                                                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                                                    }        
                                                }                                                
                                            }
                                            ?>
                                        </tr>
                                        
                                        <!-- ACCUMULATIVE ACTUAL - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Accumulative Actual
                                            </td>
                                            <td style="text-align:center;">
                                                MH
                                            </td>

                                            <?php
                                            $actual_hour = $aortadb->query("EXEC zsp_get_actual_overtime_hour_section '$selected_date', '" . $value->KD_DEPT . "' , '" . $value->KD_SECTION . "'")->row();
                                            $actual_hour_accu = 0;
                                            ?>

                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_TOTAL,1,',','.'); ?>
                                            </td>

                                            <?php
                                            for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $act_hour = 'HOUR_' . $day;
                                                $actual_hour_accu = $actual_hour_accu + $actual_hour->$act_hour;
                                                ?>
                                                <td style="text-align:center;">
                                                    <?php echo number_format($actual_hour_accu,1,',','.'); ?>
                                                </td>
                                                <?php
                                            }
                                            ?>

                                        </tr>
                                        <!-- ACCUMULATIVE ACTUAL - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Accumulative Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>

                                            <?php
                                            $actual_amount = $aortadb->query("EXEC zsp_get_actual_overtime_amount_section '$selected_date', '" . $value->KD_DEPT . "' , '" . $value->KD_SECTION . "'")->row();
                                            $actual_amount_accu = 0;
                                            ?>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMOUNT_TOTAL,2,',','.'); ?>
                                            </td>

                                            <?php
                                            for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $act_amo = 'AMO_' . $day;
                                                $actual_amount_accu = $actual_amount_accu + $actual_amount->$act_amo;
                                                ?>
                                                <td style="text-align:center;">
                                                    <?php echo number_format($actual_amount_accu,2,',','.'); ?>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        
                                        <!-- BALANCE OT PLAN VS ACTUAL - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; ?>
                                            </td>
                                            <td rowspan="1" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Balance OT Plan vs Actual
                                            </td>
                                            <td style="text-align:center;">
                                                MH
                                            </td>
                                            <?php
                                                if($value->PLAN_BY_WO <= 0){
                                                    $plan_wo = 0;
                                                }else{
                                                    $plan_wo = $value->PLAN_BY_WO;
                                                }
                                                
                                                if($value->WORKING_DAY == 0){
                                                    $wd = 20;
                                                }else{
                                                    $wd = $value->WORKING_DAY;
                                                }

                                                if($value->MP == 0){
                                                    $mp = 1;
                                                }else{
                                                    $mp = $value->MP;
                                                }

                                                $max_ot_per_day = 3.5*$mp;
                                                $max_ot_holiday = 8*$mp;
                                                $ot_day = $plan_wo / $max_ot_per_day;
                                                $ot_per_day = $plan_wo / $wd;
                                                $actual_duration = $value->TOT_DURASI_OVERTIME;
                                                $balance_ot_hour = $plan_wo - $actual_duration;
//                                                
                                            ?>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo  number_format($balance_ot_hour,1,',','.'); ?>
                                            </td>

                                            <?php
                                            if($ot_day <= $wd){
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $act_hour = 'HOUR_'.$day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $balance_ot = $ot_per_day - $actual_hour->$act_hour ;
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot,1,',','.'); ?></td>
                                                    <?php
                                                    } else {
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format(0 - $actual_hour->$act_hour,1,',','.');?></td>
                                                        <?php
                                                    }
                                                }
                                            }else{
                                                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $balance_ot = $max_ot_per_day - $actual_hour->$act_hour ;    
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot,1,',','.'); ?></td>
                                                        <?php
                                                    }else{
                                                        if($ot_holiday >= $max_ot_holiday){
                                                            $balance_ot = $max_ot_holiday - $actual_hour->$act_hour ;
                                                            ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot,1,',','.'); ?></td>
                                                        <?php
                                                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                                                            $balance_ot = $ot_holiday - $actual_hour->$act_hour ;;
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot,1,',','.'); ?></td>
                                                        <?php
                                                        }else{
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot,1,',','.'); ?></td>
                                                        <?php
                                                        }
                                                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        
                                        <!-- BALANCE ACC PLAN VS ACTUAL - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->KD_SECTION; //$value->NAMA_SUBSECT;     ?>
                                            </td>
                                            <td rowspan="1" style="text-align:right; background-color: #F3F4F5; vertical-align: center;">
                                                Balance ACC Plan vs Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <?php
                                                if($value->PLAN_BY_WO <= 0){
                                                    $plan_wo = 0;
                                                }else{
                                                    $plan_wo = $value->PLAN_BY_WO;
                                                }
                                                
                                                if($value->WORKING_DAY == 0){
                                                    $wd = 20;
                                                }else{
                                                    $wd = $value->WORKING_DAY;
                                                }

                                                if($value->MP == 0){
                                                    $mp = 1;
                                                }else{
                                                    $mp = $value->MP;
                                                }

                                                $max_ot_per_day = 3.5*$mp;
                                                $max_ot_holiday = 8*$mp;
                                                $ot_day = $plan_wo / $max_ot_per_day;
                                                $ot_per_day = $plan_wo / $wd;
                                                $balance_ot_amount = ($amount*2*$plan_wo*0.006)-$actual_amount->AMOUNT_TOTAL;
//                                               
                                            ?>
                                            <td rowspan="" style="text-align:center;">
                                                <?php echo number_format($balance_ot_amount,2,',','.'); ?>
                                            </td>

                                            <?php
                                            if($ot_day <= $wd){
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $act_amount = 'AMO_'.$day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $balance_ot_amount = ($amount*2*$ot_per_day*0.006) - $actual_amount->$act_amount ;
                                                    ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot_amount,2,',','.'); ?></td>
                                                    <?php
                                                    } else {
                                                    ?>
                                                            <td style="text-align:center;"><?php echo number_format(0 - $actual_amount->$act_amount,2,',','.');?></td>
                                                    <?php
                                                    }
                                                }
                                            }else{
                                                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                                                for ($index = 1; $index < (date("t", strtotime($selected_date . "01")) + 1); $index++) {
                                                    $day = sprintf("%02d", $index);
                                                    $date = $selected_date . $day;
                                                    $act_amount = 'AMO_'.$day;
                                                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                                    if ($holiday == 0) {
                                                        $balance_ot_amount = ($amount*2*$max_ot_per_day*0.006) - $actual_amount->$act_amount ;    
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot_amount,2,',','.'); ?></td>
                                                        <?php
                                                    }else{
                                                        if($ot_holiday >= $max_ot_holiday){
                                                            $balance_ot_amount = ($amount*2*$max_ot_holiday*0.006) - $actual_amount->$act_amount ;
                                                            ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot_amount,2,',','.'); ?></td>
                                                        <?php
                                                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                                                            $balance_ot_amount = ($amount*2*$ot_holiday*0.006) - $actual_amount->$act_amount ;
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot_amount,2,',','.'); ?></td>
                                                        <?php
                                                        }else{
                                                        ?>
                                                            <td style="text-align:center;"><?php echo number_format($balance_ot_amount,2,',','.'); ?></td>
                                                        <?php
                                                        }
                                                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                                    $(document).ready(function () {
                                                        var table = $('#example').DataTable({
                                                            scrollY: "350px",
                                                            scrollX: true,
                                                            scrollCollapse: true,
                                                            paging: false,
                                                            fixedColumns: {
                                                                leftColumns: 4
                                                            }
                                                        });
                                                    });
</script>

