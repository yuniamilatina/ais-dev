<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        overflow-x:scroll;
        overflow-y:visible;
        font-size: 11px;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT EXCEEDED STOCK</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                            window.onload = function () {
                            var chart_amount = new CanvasJS.Chart("chartContainer_amount",
                            {
                            animationEnabled: true,
                                    theme: "theme1",
                                    title: {
                                    fontColor: "white",
                                            text: "Negative"},
                                    axisY: {

                                    title: "Amount",
                                            gridThickness: 1
                                    },
                                    dataPointMaxWidth: 80,
                                    data: [
<?php
$row = 1;
foreach ($data_summary_inventory_by_prod as $isi) {
    ?>
    <?php if ($row != $total_row) { ?>

        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
        }
        $row++;
        ?>

    <?php } else { ?>
        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 
                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        indexLabel:' . '"' . '#total' . '"' . ',
                                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        }
        ?>
    <?php } ?>

<?php } ?>
                                    ],
                                    legend: {
                                    cursor: "pointer",
                                            itemclick: function (e) {
                                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                            e.dataSeries.visible = false;
                                            } else {
                                            e.dataSeries.visible = true;
                                            }
                                            chart_quality.render();
                                            }
                                    }
                            });
                                    chart_amount.render();
                            }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>EXCEEDED STOCK CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php if ($load_to_sql == 0) { ?>
                        <div class="grid-body">
                            <div id="chartContainer_amount" style="height: 350px; width: 100%;"></div>
                        </div>
                        <div class="grid-header" style='font-size: 13px;'>
                            Data was acquired on <strong><?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?></strong>
                            <div style='font-size: 14px;' class="pull-right">
                                <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="grid-body">
                            <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table>
                        </div>
                        <div class="grid-header" style='font-size: 13px;'>
                            <div style='background: #F3F4F5;' class="pull-right">
                                data is being generated, wait for a few minutes or click <a href='<?php echo base_url('index.php/raw_material/inventory_c') ?>' id="btn_refresh" >Refresh</a> 
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID TO DISPLAY DIAGRAM2-->
        <!--        <div class="row">
                    <div class="col-md-12">
                        <div class="grid">
                            <div class="grid-header">
                                <i class="fa fa-bar-chart-o"></i>
                                <span class="grid-title"><strong>EXCEEDED STOCK CHART</strong></span>
                                <div class="pull-right grid-tools">
                                    <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                </div>
                            </div>
        <?php if ($load_to_sql == 0) { ?>
                                        <div class="grid-body">
                                            <iframe scrolling="no" frameBorder="0" style="width:100%;min-height:400px;overflow:hidden;" width=100% height=100% src="<?php echo site_url("raw_material/inventory_exceed_c/chart_per_unit"); ?>"></iframe>
                                        </div>
                                        <div class="grid-header" style='font-size: 13px;'>
                                            Data was acquired on <strong><?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?></strong>
                                            <div style='font-size: 14px;' class="pull-right">
                                                <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                                            </div>
                                        </div>
        <?php } else { ?>
                                        <div class="grid-body">
                                            <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table>
                                        </div>
                                        <div class="grid-header" style='font-size: 13px;'>
                                            <div style='background: #F3F4F5;' class="pull-right">
                                                data is being generated, wait for a few minutes or click <a href='<?php echo base_url('index.php/raw_material/inventory_c') ?>' id="btn_refresh" >Refresh</a> 
                                            </div>
                                        </div>
        <?php } ?>
                        </div>
                    </div>
                </div>-->
        <!--GRID TO DISPLAY DIAGRAM2-->

        <!--GRID TO DISPLAY GRID TABLE-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>DETAIL EXCEEDED STOCK</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip"  title="Collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%"></td>
                                    <td width="60%">
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                        <?php echo form_open('raw_material/inventory_exceed_c/print_inventory_exceed', 'class="form-horizontal"'); ?>
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <!--                        <div id="table-luar">--><div class="table-wrapper" style="margin-top:20px;">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">Dept</th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Class </th> 
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">UOM </th>
                                        <?php if ($stat_in_out == 0) { ?>
                                            <th style="text-align:center;">Qty Begining Balance </th>
                                            <th style="text-align:center;">Qty In </th>
                                            <th style="text-align:center;">Qty Out </th>
                                        <?php } ?>
                                        <th style="text-align:center;">Qty Stock </th>
                                        <th style="text-align:center;">Amount Stock </th>
                                        <th style="text-align:center;">Qty Max Std </th>
                                        <th style="text-align:center;">Amount Max Std </th>
                                        <th style="text-align:center;">Qty Diff </th>
                                        <th style="text-align:center;">Amount Diff</th>
                                    </tr>

                                </thead>
                                <tfoot>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">Dept</th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Class </th> 
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">UOM </th>
                                        <?php if ($stat_in_out == 0) { ?>
                                            <th style="text-align:center;">Qty Begining Balance </th>
                                            <th style="text-align:center;">Qty In </th>
                                            <th style="text-align:center;">Qty Out </th>
                                        <?php } ?>
                                        <th style="text-align:center;">Qty Stock </th>
                                        <th style="text-align:center;">Amount Stock </th>
                                        <th style="text-align:center;">Qty Max Std </th>
                                        <th style="text-align:center;">Amount Max Std </th>
                                        <th style="text-align:center;">Qty Diff </th>
                                        <th style="text-align:center;">Amount Diff</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_data_inventory_by_prod as $isi) {
                                        $end_bal = intval($isi->INT_QTY_STOCK);
                                        $qty_in = intval($isi->CHR_TRANS_IN);
                                        $qty_out = intval($isi->CHR_TRANS_OUT);
                                        $begin_bal = $end_bal - $qty_in + $qty_out;
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$isi->DEPT</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CLASSNAME</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_SLOC</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:right;>$isi->CHR_PART_UOM</td>";
                                        if ($stat_in_out == 0) {
                                            echo "<td style=text-align:right;>" . number_format($begin_bal) . "</td>";
                                            echo "<td style=text-align:right;>" . number_format($qty_in) . "</td>";
                                            echo "<td style=text-align:right;>" . number_format($qty_out) . "</td>";
                                        }
                                        echo "<td style=text-align:right;>" . number_format($end_bal) . "</td>";
                                        //echo "<td style=text-align:right;>" . number_format($isi->INT_QTY_STOCK) . "</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->AMOUNT_STOCK) . "</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->INT_QTY_UPLOAD) . "</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->AMOUNT_UPLOAD) . "</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->INT_TOTAL_QTY) . "</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->AMOUNT) . "</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($load_to_sql == 0) { ?>
                            <div class="grid-no-header">
                                Data was acquired on <strong><?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?></strong>
                                <div style='font-size: 14px;' class="pull-right">
                                    <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="grid-no-header">
                                <div style='background: #F3F4F5;' class="pull-right">
                                    data is being generated, wait for a few minutes or click <a href='<?php echo base_url('index.php/raw_material/inventory_c') ?>' id="btn_refresh" >Refresh</a> 
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
//                            $(document).ready(function () {
//                    var table = $('#example').DataTable({
//                    //scrollY: "350px",
//                    scrollX: true,
//                            //scrollCollapse: true,
//                            //paging: false,
//                            fixedColumns: {
//                            leftColumns: 2
//                            }
//                    });
//                    });



                            $(document).ready(function() {

//    setTimeout(function () {
//        document.getElementById("hide-sub-menus").click();
//    }, 10);

                    $('#example').DataTable({
//        scrollX: true,
//            fixedColumns: {
//               //leftColumns: 2
//           },
                    initComplete: function () {
                    this.api().columns().every(function () {
                    var column = this;
                            var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                    );
                                    column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });
                            column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                    });
                    });
                    }
                    });
                            });
</script>