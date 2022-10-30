<?php
    $aortadb = $this->load->database("aorta", TRUE);
    $chart_plan = null;
    $chart_real = null;
    for($i = 1; $i < 13; $i++){
        $month = sprintf("%02d", $i);
        $month_name = substr(strtoupper(date("F", mktime(null, null, null, $month))),0,3);
        $periode = $year . $month;
        $ovtime = $aortadb->query("SELECT SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, SUM(CAST((CASE WHEN REAL_DURASI_OV_TIME = '' THEN 0 ELSE REAL_DURASI_OV_TIME END) AS DECIMAL(10,2)))/60 AS REAL_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE KD_DEPT = '$kd_dept' AND KD_SECTION LIKE '$id_section%' AND KD_SUB_SECTION LIKE '$id_subsect%' AND TGL_OVERTIME LIKE '$periode%'")->row();
        if ($i == 12) {
            if ($ovtime->RENC_DURASI_OV_TIME <= 0 || $ovtime->RENC_DURASI_OV_TIME == NULL) {
                $chart_plan .= '{label: "' . $month_name . '", y:' . 0 . ', indexLabel:"' . 0 . '"}';
            } else {
                $chart_plan .= '{label: "' . $month_name . '", y:' . $ovtime->RENC_DURASI_OV_TIME . ', indexLabel:"' . number_format($ovtime->RENC_DURASI_OV_TIME, 2, ".", ",") . '"}';
            }                    
        } else {
            if ($ovtime->RENC_DURASI_OV_TIME <= 0 || $ovtime->RENC_DURASI_OV_TIME == NULL) {
                $chart_plan .= '{label: "' . $month_name . '", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                $chart_plan .= '{label: "' . $month_name . '", y:' . $ovtime->RENC_DURASI_OV_TIME . ', indexLabel:"' . number_format($ovtime->RENC_DURASI_OV_TIME, 2, ".", ",") . '"},';
            }
        }
        
        if ($i == 12) {
            if ($ovtime->REAL_DURASI_OV_TIME <= 0 || $ovtime->REAL_DURASI_OV_TIME == NULL) {
                $chart_real .= '{label: "' . $month_name . '", y:' . 0 . ', indexLabel:"' . 0 . '"}';
            } else {
                $chart_real .= '{label: "' . $month_name . '", y:' . $ovtime->REAL_DURASI_OV_TIME . ', indexLabel:"' . number_format($ovtime->REAL_DURASI_OV_TIME, 2, ".", ",") . '"}';
            }                    
        } else {
            if ($ovtime->REAL_DURASI_OV_TIME <= 0 || $ovtime->REAL_DURASI_OV_TIME == NULL) {
                $chart_real .= '{label: "' . $month_name . '", y:' . 0 . ', indexLabel:"' . 0 . '"},';
            } else {
                $chart_real .= '{label: "' . $month_name . '", y:' . $ovtime->REAL_DURASI_OV_TIME . ', indexLabel:"' . number_format($ovtime->REAL_DURASI_OV_TIME, 2, ".", ",") . '"},';
            }
        }
    }
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
            <li><a href=""><strong>REPORT SUMMARY OVERTIME</strong></a></li>
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
                                            echo 'interval: 50';
                                        } else {
                                            echo 'interval: 2000';
                                        }
                                        ?>
                                        
                                    },
                                    axisX: {
                                        gridThickness:0,
                                        labelFontSize: 12,
                                        interval: 1
                                        
                                    },
                                    data: [
                                        {
                                            type: "column",
                                            click: onClick,
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical", 
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "PLAN OT (Hour)",
                                            legendText: "PLAN OT",
                                            showInLegend: true,
                                            dataPoints: [
<?php
    echo $chart_plan;
?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            click: onClick,
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "ACTUAL OT (Hour)",
                                            legendText: "ACTUAL OT",
                                            //axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
<?php
    echo $chart_real;
?>
                                            ]
                                        }

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
                        function onClick(e) {
                            $.ajax({
                                async: false,
                                type: "POST",
                                url: "<?php echo site_url('aorta/report_summary_overtime_c/get_data_perdate'); ?>",
                                data: "month_click=" + e.dataPoint.label + "&dept_click=" + '<?php echo $kd_dept ?>' + "&sect_click=" + '<?php echo $id_section ?>' + "&subsect_click=" + '<?php echo $id_subsect ?>' + "&year_click=" + '<?php echo $year ?>',
                                success: function (data) {
                                    if (data == 0) {
                                        $("#row_perday").css("display", "none");
                                        alert("No Data Available");
                                    } else {
                                        $("#row_perday").css("display", "block");
                                        $(".data_perday").html(data);
                                    }
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });

                        }
                    }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title">OVERTIME <strong>PLAN VS ACTUAL</strong> CHART - <strong><?php echo $kd_dept; if($id_section != ''){ echo ' - '.$id_section; } if($id_subsect != ''){ echo ' - '.$id_subsect;} ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($all_overtime == null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>                    
                </div>
            </div>
        </div>
        
        <div class="row" id="row_perday" style="display:none;">
            <div class="col-md-12">
                <div id="data_perday" class="data_perday">
                </div>
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title">OVERTIME <strong>PLAN VS ACTUAL</strong> CHART PER DAY</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container" style="height: 350px; width: 100%;display:block;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">REPORT SUMMARY OVERTIME <strong>PLAN VS ACTUAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('aorta/report_summary_overtime_c/export_summary_ot', 'class="form-horizontal"'); ?>
                                <input name="CHR_YEAR_SELECTED" value="<?php echo $year ?>" type="hidden">
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
                                    <td width="10%">Year</td>
                                    <td width="25%">
                                        <select name="CHR_YEAR" id="opt_wcenter" class="ddl2" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -2; $x <= 1; $x++) { ?>
                                                <option value="<?php echo site_url('aorta/report_summary_overtime_c/index/' . date("Y", strtotime("+$x year"))) . '/'. $id_dept . '/' . $id_section . '/' . $id_subsect; ?>" <?php
                                                if ($year == date("Y", strtotime("+$x year"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Y", strtotime("+$x year")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td>Section</td>
                                    <td>
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/report_summary_overtime_c/index/' . $year . "/$id_dept/ALL/ALL") ?>">ALL</option>
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_summary_overtime_c/index/' . $year . "/$id_dept/" . trim($row->KODE) . "/ALL"); ?>" 
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
                                        <?php if ($role == 39 || $role == 45 || $role == 62 || $role == 6) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php } ?>
                                        <?php } ?> <!-- ADDITIONAL TASK FORCE OVERTIME -->
                                                    <option value=""> -- Select Dept -- </option>
                                                <?php foreach ($all_dept as $row) { ?>
                                                    <option value="<?php echo site_url("aorta/report_summary_overtime_c/index/" . $year . '/' . $row->INT_ID_DEPT . "/ALL/ALL"); ?>" <?php
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
                                            <option value="<?php echo site_url('aorta/report_summary_overtime_c/index/' . $year . "/$id_dept/$id_section/ALL") ?>">ALL</option>
                                            <?php foreach ($all_lines as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_summary_overtime_c/index/' . $year . "/$id_dept/$id_section/$row->KODE"); ?>" 
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
                                    <tr class='gradeX'>
                                        <th style="vertical-align: middle;">No</th>
                                        <th style="vertical-align: middle;">Dept</th>
                                        <th style="vertical-align: middle;">Section</th>
                                        <th style="vertical-align: middle;">Sub Section </br>(Line)</th>
                                        <th style="vertical-align: middle;">OT</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >JAN</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >FEB</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >MAR</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >APR</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >MAY</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >JUN</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >JUL</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >AUG</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >SEP</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >OCT</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >NOV</th>
                                        <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" >DEC</th>                                        
                                        <th style="vertical-align: middle;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $aortadb = $this->load->database("aorta", TRUE);
                                        $no = 1;
                                        foreach($all_overtime as $ot){
                                            echo "<tr>";
                                            echo "<td rowspan='2' style='vertical-align: middle;'>$no</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$ot->KD_DEPT</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$ot->KD_SECTION</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$ot->KD_SUB_SECTION</td>";
                                            echo "<td>PLAN</td>";
                                            
                                            $tot_renc = 0;
                                            for ($index = 1; $index < 13; $index++) {
                                                $month = sprintf("%02d", $index);
                                                $periode = $year . $month;
                                                $ot_plan = $aortadb->query("SELECT SUM(CAST(RENC_DURASI_OV_TIME AS INT)) AS RENC_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE KD_DEPT = '$ot->KD_DEPT' AND KD_SECTION = '$ot->KD_SECTION' AND KD_SUB_SECTION = '$ot->KD_SUB_SECTION' AND TGL_OVERTIME LIKE '$periode%'")->row();
                                                if(count($ot_plan) != 0){
                                                    $tot_renc = $tot_renc + number_format($ot_plan->RENC_DURASI_OV_TIME/60,2,'.',',');
                                                    echo "<td style='vertical-align: middle;text-align:center;'>" . number_format($ot_plan->RENC_DURASI_OV_TIME/60,2,'.',',') . "</td>";
                                                } else {
                                                    echo "<td style='vertical-align: middle;text-align:center;'>0</td>";
                                                }
                                            }
                                            
                                            echo "<td style='vertical-align: middle;text-align:center;'><strong>$tot_renc</strong></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td rowspan='' style='vertical-align: middle; display: none;'>$no</td>";
                                            echo "<td rowspan='' style='vertical-align: middle; display: none;'>$ot->KD_DEPT</td>";
                                            echo "<td rowspan='' style='vertical-align: middle; display: none;'>$ot->KD_SECTION</td>";
                                            echo "<td rowspan='' style='vertical-align: middle; display: none;'>$ot->KD_SUB_SECTION</td>";
                                            echo "<td>ACTUAL</td>";
                                            
                                            $tot_real = 0;
                                            for ($index = 1; $index < 13; $index++) {
                                                $month = sprintf("%02d", $index);
                                                $periode = $year . $month;
                                                $ot_real = $aortadb->query("SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT)) AS REAL_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE KD_DEPT = '$ot->KD_DEPT' AND KD_SECTION = '$ot->KD_SECTION' AND KD_SUB_SECTION = '$ot->KD_SUB_SECTION' AND TGL_OVERTIME LIKE '$periode%'")->row();
                                                if(count($ot_real) != 0){
                                                    $tot_real = $tot_real + number_format($ot_real->REAL_DURASI_OV_TIME/60,2,'.',',');
                                                    echo "<td style='vertical-align: middle;text-align:center;'>" . number_format($ot_real->REAL_DURASI_OV_TIME/60,2,'.',',') . "</td>";
                                                } else {
                                                    echo "<td style='vertical-align: middle;text-align:center;'>0</td>";
                                                }
                                            }
                                            
                                            echo "<td style='vertical-align: middle;text-align:center;'><strong>$tot_real</strong></td>";
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
                                                        leftColumns: 5
                                                    }
                                                });
                                            });
</script>

