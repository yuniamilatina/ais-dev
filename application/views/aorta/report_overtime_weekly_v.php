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
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT OVERTIME WEEKLY</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- REPORT OVERTIME BY HOUR -->
                <script type="text/javascript">
                    window.onload = function() {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme1",
                                    animationEnabled: true,
                                    title: {
                                        text: "",
                                        fontSize: 30
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    axisY: {
                                        title: "Hour",
                                        gridThickness:0.2,
                                        <?php
                                        if($kd_dept == 'MISY' || $kd_dept == 'KZN' || $kd_dept == 'KQC' || $kd_dept == 'MSU' || $kd_dept == 'PC'){
                                            echo 'interval: 10';
                                        } else if($kd_dept == 'ENG' || $kd_dept == 'MTE' || $kd_dept == 'QC' || $kd_dept == 'QA' || $kd_dept == 'QSY') {
                                            echo 'interval: 20';
                                        } else {
                                            echo 'interval: 40';
                                        }
                                        ?>
                                        
                                    },
                                    axisX: {
                                        gridThickness:0,
                                        labelFontSize: 12,
                                        interval: 1
                                        
                                    },
                                    data: [
<?php
    if($id_section == ''){
        $count_sect = count($all_work_centers);
        $x = 1;
        foreach($all_work_centers as $sect){
            $kd_sect = $sect->KODE;
            $w0 = $aortadb->query("EXEC zsp_get_overtime_weekly_per_section '$start_date0', '$end_date0', '$kd_dept', '$kd_sect'")->row();
            $w1 = $aortadb->query("EXEC zsp_get_overtime_weekly_per_section '$start_date1', '$end_date1', '$kd_dept', '$kd_sect'")->row();
            $w2 = $aortadb->query("EXEC zsp_get_overtime_weekly_per_section '$start_date2', '$end_date2', '$kd_dept', '$kd_sect'")->row();
            $w3 = $aortadb->query("EXEC zsp_get_overtime_weekly_per_section '$start_date3', '$end_date3', '$kd_dept', '$kd_sect'")->row();
            $w4 = $aortadb->query("EXEC zsp_get_overtime_weekly_per_section '$start_date4', '$end_date4', '$kd_dept', '$kd_sect'")->row();
            $w5 = $aortadb->query("EXEC zsp_get_overtime_weekly_per_section '$start_date5', '$end_date5', '$kd_dept', '$kd_sect'")->row();

            echo '       {';
            echo '           type: "column",';
            echo '           indexLabelPlacement: "outside",';
            echo '           indexLabelOrientation: "vertical",';                                            
            echo '           name: "'. $kd_sect .'",';
            echo '           legendText: "'. $kd_sect .'",';
            echo '           showInLegend: true,';
            echo '           dataPoints: [';

            if(count($w0) == 0){
                echo '              {label: "(' . $start_date0 . '-' . $end_date0 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "(' . $start_date0 . '-' . $end_date0 . ')", y:' . $w0->OT_PER_DAY . ', indexLabel:"' . number_format($w0->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w1) == 0){
                echo '              {label: "W1 (' . $start_date1 . '-' . $end_date1 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W1 (' . $start_date1 . '-' . $end_date1 . ')", y:' . $w1->OT_PER_DAY . ', indexLabel:"' . number_format($w1->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w2) == 0){
                echo '              {label: "W2 (' . $start_date2 . '-' . $end_date2 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W2 (' . $start_date2 . '-' . $end_date2 . ')", y:' . $w2->OT_PER_DAY . ', indexLabel:"' . number_format($w2->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w3) == 0){
                echo '              {label: "W3 (' . $start_date3 . '-' . $end_date3 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W3 (' . $start_date3 . '-' . $end_date3 . ')", y:' . $w3->OT_PER_DAY . ', indexLabel:"' . number_format($w3->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w4) == 0){
                echo '              {label: "W4 (' . $start_date4 . '-' . $end_date4 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W4 (' . $start_date4 . '-' . $end_date4 . ')", y:' . $w4->OT_PER_DAY . ', indexLabel:"' . number_format($w4->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w5) == 0){
                echo '              {label: "(' . $start_date5 . '-' . $end_date5 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"}';
            } else {
                echo '              {label: "(' . $start_date5 . '-' . $end_date5 . ')", y:' . $w5->OT_PER_DAY . ', indexLabel:"' . number_format($w5->OT_PER_DAY,2,'.',',') . '"}';
            }

            echo '           ]';
            if ($x != $count_sect){
                echo '},';
            } else {
                echo '}';
            }                                        
            $x++;    
        }
    } else {
        $count_subsect = count($all_lines);
        $x = 1;
        foreach($all_lines as $line){
            $kd_subsect = $line->KODE;
            $w0 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date0', '$end_date0', '$kd_dept', '$id_section', '$kd_subsect'")->row();
            $w1 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date1', '$end_date1', '$kd_dept', '$id_section', '$kd_subsect'")->row();
            $w2 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date2', '$end_date2', '$kd_dept', '$id_section', '$kd_subsect'")->row();
            $w3 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date3', '$end_date3', '$kd_dept', '$id_section', '$kd_subsect'")->row();
            $w4 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date4', '$end_date4', '$kd_dept', '$id_section', '$kd_subsect'")->row();
            $w5 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date5', '$end_date5', '$kd_dept', '$id_section', '$kd_subsect'")->row();

            echo '       {';
            echo '           type: "column",';
            echo '           indexLabelPlacement: "outside",';
            echo '           indexLabelOrientation: "vertical",';                                            
            echo '           name: "'. $kd_subsect .'",';
            echo '           legendText: "'. $kd_subsect .'",';
            echo '           showInLegend: true,';
            echo '           dataPoints: [';

            if(count($w0) == 0){
                echo '              {label: "(' . $start_date0 . '-' . $end_date0 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "(' . $start_date0 . '-' . $end_date0 . ')", y:' . $w0->OT_PER_DAY . ', indexLabel:"' . number_format($w0->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w1) == 0){
                echo '              {label: "W1 (' . $start_date1 . '-' . $end_date1 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W1 (' . $start_date1 . '-' . $end_date1 . ')", y:' . $w1->OT_PER_DAY . ', indexLabel:"' . number_format($w1->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w2) == 0){
                echo '              {label: "W2 (' . $start_date2 . '-' . $end_date2 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W2 (' . $start_date2 . '-' . $end_date2 . ')", y:' . $w2->OT_PER_DAY . ', indexLabel:"' . number_format($w2->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w3) == 0){
                echo '              {label: "W3 (' . $start_date3 . '-' . $end_date3 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W3 (' . $start_date3 . '-' . $end_date3 . ')", y:' . $w3->OT_PER_DAY . ', indexLabel:"' . number_format($w3->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w4) == 0){
                echo '              {label: "W4 (' . $start_date4 . '-' . $end_date4 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                echo '              {label: "W4 (' . $start_date4 . '-' . $end_date4 . ')", y:' . $w4->OT_PER_DAY . ', indexLabel:"' . number_format($w4->OT_PER_DAY,2,'.',',') . '"},';
            }

            if(count($w5) == 0){
                echo '              {label: "(' . $start_date5 . '-' . $end_date5 . ')", y:' . 0 . ', indexLabel:"' . 0 . '"}';
            } else {
                echo '              {label: "(' . $start_date5 . '-' . $end_date5 . ')", y:' . $w5->OT_PER_DAY . ', indexLabel:"' . number_format($w5->OT_PER_DAY,2,'.',',') . '"}';
            }

            echo '           ]';
            if ($x != $count_subsect){
                echo '},';
            } else {
                echo '}';
            }                                        
            $x++;
        }
    }
    
?>
                                    ],
                                    legend: {
                                        cursor: "pointer",
                                        itemclick: function(e) {
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
                    }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title">OVERTIME <strong>WEEKLY</strong> CHART - <strong><?php echo $kd_dept; if($id_section != ''){ echo ' - '.$id_section; } if($id_subsect != ''){ echo ' - '.$id_subsect;} ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($dept_ot == null) { ?>
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
                        <span class="grid-title">REPORT OVERTIME <strong>WEEKLY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('aorta/report_overtime_weekly_c/export_ot_weekly', 'class="form-horizontal"'); ?>
                                <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                                <input name="CHR_DEPT_SELECTED" value="<?php echo $id_dept ?>" type="hidden">
                                <input name="CHR_SECTION_SELECTED" value="<?php echo $id_section ?>" type="hidden">
                                <input name="CHR_SUBSECTION_SELECTED" value="<?php echo $id_subsect ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="25%">
                                        <select id="opt_wcenter" class="ddl2" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) {  $y = $x * 28 ?>
                                                <option value="<?PHP echo site_url('aorta/report_overtime_weekly_c/index/' . date("Ym", strtotime("+$y day")) . "/$id_dept/$id_section/$id_subsect"); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td>Section</td>
                                    <td>
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/report_overtime_weekly_c/index/' . $selected_date . "/$id_dept/ALL/ALL") ?>">ALL</option>
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_overtime_weekly_c/index/' . $selected_date . "/$id_dept/" . trim($row->KODE) . "/ALL"); ?>" 
                                                <?php
                                                if (trim($id_section) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="25%">
                                        <?php if ($npk == '0483' || $npk == '0483a'){ ?> <!-- ADDITIONAL TASK FORCE OVERTIME -->
                                            <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                        <?php } else { ?> <!-- ADDITIONAL TASK FORCE OVERTIME -->
                                        <?php if ($role == 5 || $role == 39 || $role == 45 || $role == 62 || $role == 6) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php } ?>
                                        <?php } ?> <!-- ADDITIONAL TASK FORCE OVERTIME -->
                                                    <option value=""> -- Select Dept -- </option>
                                                <?php foreach ($all_dept as $row) { ?>
                                                    <option value="<?php echo site_url("aorta/report_overtime_weekly_c/index/" . $selected_date . '/' . $row->INT_ID_DEPT . "/ALL/ALL"); ?>" <?php
                                                    if ($id_dept == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT) . " - " . trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td>Sub Section</td>
                                    <td>
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/report_overtime_weekly_c/index/' . $selected_date . "/$id_dept/$id_section/ALL") ?>">ALL</option>
                                            <?php foreach ($all_lines as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_overtime_weekly_c/index/' . $selected_date . "/$id_dept/$id_section/$row->KODE"); ?>" 
                                                <?php
                                                if (trim($id_subsect) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%"></td>
                                    <td width="25%"></td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" >
                                <thead>
                                    <tr class='gradeX' align="center">
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Dept</th>
                                        <th rowspan="3" style="vertical-align: middle;">Section</th>
                                        <th rowspan="3" style="vertical-align: middle;">Sub Section </br>(Line)</th>
                                        <th colspan="3"></th>
                                        <th colspan="12" style="vertical-align: middle; text-align: center;"><?php echo strtoupper(date("F", mktime(null, null, null, substr($selected_date, 4, 2)))) . ' ' . substr($selected_date, 0, 4); ?></th>
                                        <th colspan="3"></th>
                                    </tr>
                                    <tr>                                        
                                        <th colspan="3" style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;"><?php echo '(' . date('Y/m/d', strtotime($start_date0)) . ' - ' . date('Y/m/d', strtotime($end_date0)) . ')'; ?></th>
                                        <th colspan="3" style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;">WEEK 1 <?php echo '(' . date('Y/m/d', strtotime($start_date1)) . ' - ' . date('Y/m/d', strtotime($end_date1)) . ')'; ?></th>
                                        <th colspan="3" style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;">WEEK 2 <?php echo '(' . date('Y/m/d', strtotime($start_date2)) . ' - ' . date('Y/m/d', strtotime($end_date2)) . ')'; ?></th>
                                        <th colspan="3" style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;">WEEK 3 <?php echo '(' . date('Y/m/d', strtotime($start_date3)) . ' - ' . date('Y/m/d', strtotime($end_date3)) . ')'; ?></th>
                                        <th colspan="3" style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;">WEEK 4 <?php echo '(' . date('Y/m/d', strtotime($start_date4)) . ' - ' . date('Y/m/d', strtotime($end_date4)) . ')'; ?></th>
                                        <th colspan="3" style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;"><?php echo '(' . date('Y/m/d', strtotime($start_date5)) . ' - ' . date('Y/m/d', strtotime($end_date5)) . ')'; ?></th>
                                    </tr>
                                    <tr>
                                    <?php
                                        for($i = 0; $i < 6; $i++){
                                    ?>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;">MP/DAY</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;">OT/DAY</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;">MH/DAY</th>
                                    <?php
                                        }
                                    ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $aortadb = $this->load->database("aorta", TRUE);
                                        $no = 1;
                                        foreach($dept_ot as $data){
                                            echo "<tr align='center'>";
                                            echo "<td>$no</td>";
                                            echo "<td>$data->KD_DEPT</td>";
                                            echo "<td>$data->KD_SECTION</td>";
                                            echo "<td>$data->KD_SUB_SECTION</td>";
                                            
                                            //week 0
                                            $week0 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date0', '$end_date0', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
                                            if(count($week0) != 0){
                                                echo "<td>". number_format($week0->MP_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week0->OT_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week0->MH_PER_DAY,2,'.',',') . "</td>";
                                            } else {
                                                echo "<td>0</td>";
                                                echo "<td>0</td>";
                                                echo "<td>0</td>";
                                            }
                                            
                                            //week 1
                                            $week1 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date1', '$end_date1', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
                                            if(count($week1) != 0){
                                                echo "<td>". number_format($week1->MP_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week1->OT_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week1->MH_PER_DAY,2,'.',',') . "</td>";
                                            } else {
                                                echo "<td>0</td>";
                                                echo "<td>0</td>";
                                                echo "<td>0</td>"; 
                                            }
                                            
                                            //week 2
                                            $week2 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date2', '$end_date2', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
                                            if(count($week2) != 0){
                                                echo "<td>". number_format($week2->MP_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week2->OT_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week2->MH_PER_DAY,2,'.',',') . "</td>";
                                            } else {
                                                echo "<td>0</td>";
                                                echo "<td>0</td>";
                                                echo "<td>0</td>"; 
                                            }
                                            
                                            //week 3
                                            $week3 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date3', '$end_date3', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
                                            if(count($week3) != 0){
                                                echo "<td>". number_format($week3->MP_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week3->OT_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week3->MH_PER_DAY,2,'.',',') . "</td>";
                                            } else {
                                                echo "<td>0</td>";
                                                echo "<td>0</td>";
                                                echo "<td>0</td>"; 
                                            }
                                            
                                            //week 4
                                            $week4 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date4', '$end_date4', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
                                            if(count($week4) != 0){
                                                echo "<td>". number_format($week4->MP_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week4->OT_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week4->MH_PER_DAY,2,'.',',') . "</td>";
                                            } else {
                                                echo "<td>0</td>";
                                                echo "<td>0</td>";
                                                echo "<td>0</td>"; 
                                            }    
                                            
                                            //week 5
                                            $week5 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date5', '$end_date5', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
                                            if(count($week5) != 0){
                                                echo "<td>". number_format($week5->MP_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week5->OT_PER_DAY,2,'.',',') . "</td>";
                                                echo "<td>". number_format($week5->MH_PER_DAY,2,'.',',') . "</td>";
                                            } else {
                                                echo "<td>0</td>";
                                                echo "<td>0</td>";
                                                echo "<td>0</td>"; 
                                            }
                                            
                                            echo "</tr>";
                                            $no++;
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
                                            $(document).ready(function() {
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

