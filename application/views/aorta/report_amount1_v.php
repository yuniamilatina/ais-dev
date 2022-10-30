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
<?php
$row_plan_target = count($summary_ot_amount);
$row_plan = 1;
$amount_plan = '';
foreach ($summary_ot_amount as $isi) {

    if ($row_plan == $row_plan_target) {
        $amount_plan .= '{label: "' . $isi->KD_SECTION . '", y:' . $isi->AMO_QUOTA_STD . ', indexLabel:"' . round(number_format($isi->AMO_QUOTA_STD / 1000, 0, ",", "."),2) . '"}';
        $row_plan++;
    } else {
        $amount_plan .= '{label: "' . $isi->KD_SECTION . '", y:' . $isi->AMO_QUOTA_STD . ', indexLabel:"' . round(number_format($isi->AMO_QUOTA_STD / 1000, 0, ",", "."),2) . '"},';
        $row_plan++;
    }
}


$amount_plafond = '';
$row_plan = 1;
foreach ($summary_ot_amount as $isi) {

    if ($row_plan == $row_plan_target) {
        $amount_plafond .= '{label: "' . $isi->KD_SECTION . '", y:' . $isi->AMO_PLAFOND . ', indexLabel:"' . round(number_format($isi->AMO_PLAFOND / 1000, 0, ",", "."),2) . '"}';
        $row_plan++;
    } else {
        $amount_plafond .= '{label: "' . $isi->KD_SECTION . '", y:' . $isi->AMO_PLAFOND . ' , indexLabel:"' . round(number_format($isi->AMO_PLAFOND / 1000, 0, ",", "."),2) . '"},';
        $row_plan++;
    }
}

$amount_actual = '';
$row_plan = 1;
foreach ($summary_ot_amount as $isi) {

    if ($row_plan == $row_plan_target) {
        $amount_actual .= '{label: "' . $isi->KD_SECTION . '", y:' . $isi->TOT_AMOUNT_OVERTIME . ', indexLabel:"' . round(number_format($isi->TOT_AMOUNT_OVERTIME / 1000, 0, ",", "."),2) . '"}';
        $row_plan++;
    } else {
        $amount_actual .= '{label: "' . $isi->KD_SECTION . '", y:' . $isi->TOT_AMOUNT_OVERTIME . ', indexLabel:"' . round(number_format($isi->TOT_AMOUNT_OVERTIME / 1000, 0, ",", "."),2). '"},';
    }
}
?>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT OVERTIME BY AMOUNT</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                    window.onload = function() {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme2",
                                    animationEnabled: true,
                                    title: {
                                        text: "",
                                        fontSize: 8
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    axisY: {
                                        title: "Amount",
                                        interval: 50000000,
                                        gridThickness:0.2
                                    },
                                    axisY2: {
                                        title: "Amount",
                                        interval: 50000000
                                    },
                                    data: [
                                        {
                                            type: "column",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "PLAN (Rp)",
                                            legendText: "PLAN",
                                            showInLegend: true,
                                            dataPoints: [
<?php
echo $amount_plan;
?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "PLAFOND (Rp)",
                                            legendText: "PLAFOND",
                                            //axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
<?php
echo $amount_plafond;
?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "vertical",
                                            indexLabelFontSize: 13,
                                            indexLabelFontColor: "black",
                                            name: "REALIZATION (Rp)",
                                            legendText: "REALISASI",
                                            //axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
<?php
echo $amount_actual;
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
                    }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>OVERTIME COLUMN CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                        </div>

                        <?php if (count($summary_ot_amount) == 0) { ?>
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
                        <span class="grid-title"><strong>REPORT OVERTIME BY AMOUNT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="60%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) {  $y = $x * 28 ?>
                                                <option value="<?PHP echo site_url('aorta/report_amount_c/amount/' . date("Ym", strtotime("+$y day")) . "/$id_prod/$id_section"); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:right;' colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>

                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="60%">
                                        <?php if ($role == 5 || $role == 1 || $role == 14 || $role == 35) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<?php echo site_url("aorta/report_amount_c/amount/" . $selected_date . '/' . $row->INT_ID_DEPT . "/$id_section"); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Section</td>
                                    <td width="60%">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/report_amount_c/amount/' . $selected_date . "/$id_prod/ALL") ?>">ALL</option>
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_amount_c/amount/' . $selected_date . "/$id_prod/$row->KODE"); ?>" 
                                                <?php
                                                if (trim($id_section) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo strtoupper(trim($row->NAMA_SECTION)); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%"></td>
                                    <td width="60%"></td>
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
                                    <tr>
                                        <th  style="vertical-align: middle;text-align:center;">No</th>
                                        <th  style="vertical-align: middle;text-align:center;">NPK</th>
                                        <th  style="vertical-align: middle;text-align:center;">Nama</th>
                                        <th  style="vertical-align: middle;text-align:center;">Kode Section</th>
                                        <th  style="vertical-align: middle;text-align:center;">Quota Standard</th>
                                        <th  style="vertical-align: middle;text-align:center;">Quota Tambahan</th>
                                        <th  style="vertical-align: middle;text-align:center;">Quota Total (Plafond)</th>
                                        <th  style="vertical-align: middle;text-align:center;">Total Durasi OT</th>
                                        <th  style="vertical-align: middle;text-align:center;">Salary</th>
                                        <th  style="vertical-align: middle;text-align:center;">Total Amount OT</th>
                                        <th  style="vertical-align: middle;text-align:center;">Total Take Home Pay</th>
                                        <th  style="vertical-align: middle;text-align:center;">Stat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($summary_ot_per_kry as $value) {
                                        ?>
                                        <tr>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo $no ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo $value->NPK ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo $value->NAMA ?>
                                            </td>

                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo $value->KD_SECTION ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo $value->QUOTA_STD ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo $value->QUOTA_TAMBAHAN ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo $value->PLAFOND ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo $value->TOT_DURASI_OT ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo number_format($value->SALARY, 2) ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo number_format($value->UPAH_LEMBUR, 2) ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <?php echo number_format($value->THP, 2) ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align:center;color:white;<?php
                                                if ($value->STATUS == 'NG') {
                                                    echo "background-color:#b40a0a;";
                                                } else {
                                                    echo "background-color:#0ab415;";
                                                }
                                                ?>">
                                                    <?php echo $value->STATUS ?>
                                            </td>
                                        </tr>

                                        <?php
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