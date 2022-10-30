<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<style type="text/css">
    .table-wrapper { 
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
    #filter_prod { 
        border-spacing: 20px;
    }
    #filter { 
        border-spacing: 5px;
    }
    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }
    .td-fixed{
        width: 40px;
    }
    .dll{
        width: 20px;
    }

    .btn_part{
        border:none;
    }

    .btn_part:focus{
        outline: none;
    }
</style>
<script>
    setTimeout(function () {
    document.getElementById("hide-sub-menus").click();
    }, 10);</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT ICM</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                    window.onload = function () {
                    var chart_quality = new CanvasJS.Chart("chartContainer_quality",
                    {
                    animationEnabled: true,
                            theme: "theme2",
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
        if ($isi->DEPT == 'BRP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'ERP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PPC') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
        }
        $row++;
        ?>

    <?php } else { ?>
        <?php
        if ($isi->DEPT == 'BRP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'ERP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PPC') {
            echo '{type: "stackedColumn", 
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else {
            echo '{type: "stackedColumn", 
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            indexLabel:' . '"-' . '#total' . '"' . ',
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
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
                    chart_quality.render();
                    var chart_exceeded_stock = new CanvasJS.Chart("chart_exceeded_stock",
                    {
                    animationEnabled: true,
                            theme: "theme2",
                            title: {
                            fontColor: "white",
                                    text: "Exceeded"},
                            axisY: {

                            title: "Amount",
                                    gridThickness: 1
                            },
                            dataPointMaxWidth: 80,
                            data: [
<?php
$row_exceed_stock = 1;
foreach ($data_summary_inventory_by_prod_exceeded_stock as $isi) {
    ?>
    <?php if ($row_exceed_stock != $total_row_exceeded_stock) { ?>

        <?php
        if ($isi->DEPT == 'BRP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'ERP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PPC') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
        }
        $row_exceed_stock++;
        ?>

    <?php } else { ?>
        <?php
        if ($isi->DEPT == 'BRP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'ERP') {
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PPC') {
            echo '{type: "stackedColumn", 
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else {
            echo '{type: "stackedColumn", 
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 
                                            
                                            indexLabel:' . '"' . '#total' . '"' . ',
                                            legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                            dataPoints: [' .
            '{y:0,label:' . '"' . 'BRP' . '"' . '},' .
            '{y:0,label:' . '"' . 'ERP' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
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
                                    chart_exceeded_stock.render();
                                    }
                            }
                    });
                    chart_exceeded_stock.render();
                    }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>NEGATIVE STOCK CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php if ($load_to_sql == 0 && $load_to_sql_inout == 0) { ?>
                        <div class="grid-body">
                            <div id="chartContainer_quality" style="height: 350px; width: 100%;"></div>
                        </div>
                        <div class="grid-header" style='font-size: 13px;'>
                            Data was acquired on <strong><?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?></strong>
                            <div style='font-size: 14px;' class="pull-right">
                                <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                            </div>
                        </div>
                    <?php } if ($load_to_sql == 1  || $load_to_sql_inout == 1) { ?>
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

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                    var chart1;
                    $(document).ready(function () {
                    chart1 = new Highcharts.Chart({
                    chart: {
                    renderTo: 'container',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: ''
                            },
                            xAxis: {
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
                            },
                            yAxis: {
                            title: {
                            text: 'Negative Stock'
                            }
                            },
                            series: [
<?php foreach ($data_summary_inventory_by_date as $row) { ?>
                                {
                                name: '<?php echo $row->CHR_DEPT; ?>',
                                        data: [
    <?php
    echo $row->DATE_1 . ',' . $row->DATE_2 . ',' . $row->DATE_3 . ',' . $row->DATE_4 . ',' . $row->DATE_5 . ',' . $row->DATE_6 . ',' . $row->DATE_7 . ',' . $row->DATE_8 . ',' . $row->DATE_9
    . ',' . $row->DATE_10 . ',' . $row->DATE_11 . ',' . $row->DATE_12 . ',' . $row->DATE_13 . ',' . $row->DATE_14 . ',' . $row->DATE_15 . ',' . $row->DATE_16 . ',' . $row->DATE_17
    . ',' . $row->DATE_18 . ',' . $row->DATE_19 . ',' . $row->DATE_20 . ',' . $row->DATE_21 . ',' . $row->DATE_22 . ',' . $row->DATE_23 . ',' . $row->DATE_24 . ',' . $row->DATE_25
    . ',' . $row->DATE_26 . ',' . $row->DATE_27 . ',' . $row->DATE_28 . ',' . $row->DATE_29 . ',' . $row->DATE_30 . ',' . $row->DATE_31;
    ?>
                                        ]
                                },
    <?php
}
?>
                            ]
                    });
                    });</script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>NEGATIVE STOCK LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                   
                    
                    
                    <?php if ($load_to_sql == 0 && $load_to_sql_inout == 0) { ?>
                        <div class="grid-body">
                            <div id="container" style="height: 350px; width: 100%;"></div>
                        </div>
                    <div class="grid-header" style='font-size: 13px;'>
                        Data daily captured at <strong>06:00</strong>
                    </div>
                    <?php } if ($load_to_sql == 1  || $load_to_sql_inout == 1) { ?>
                        <div class="grid-body">
                            <table width=100% id='filterdiagram' ><td> Data is being generated</td></table>
                        </div>
                        <div class="grid-header" style='font-size: 13px;'>
                        Data daily captured at <strong>06:00</strong>
                    </div>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID NEGATIVE STOCK-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th"></i>
                        <span class="grid-title"> <strong>DETAIL NEGATIVE STOCK</strong></span>
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
                                        <?php echo form_open('raw_material/inventory_c/print_negative_stock', 'class="form-horizontal"'); ?>
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div class="table-wrapper" style="margin-top:20px;"> <!--<div id="table-luar">-->
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">Dept</th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">Amount </th>
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Class </th> 
                                        <?php if ($stat_in_out == 0) { ?>
                                            <th style="text-align:center;">Qty Begining Balance </th>
                                            <th style="text-align:center;">Qty In </th>
                                            <th style="text-align:center;">Qty Out </th>
                                        <?php } ?>
                                        <th style="text-align:center;">Qty Ending Balance </th>
                                        <th style="text-align:center;">UOM </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;"></th> 
                                        <?php if ($stat_in_out == 0) { ?>
                                            <th style="text-align:center;"></th>
                                            <th style="text-align:center;"></th>
                                            <th style="text-align:center;"></th>
                                        <?php } ?>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;"></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_data_inventory_by_prod as $isi) {
                                        $end_bal = intval($isi->INT_TOTAL_QTY);
                                        $qty_in = intval($isi->CHR_TRANS_IN);
                                        $qty_out = intval($isi->CHR_TRANS_OUT);
                                        $begin_bal = $end_bal - $qty_in + $qty_out;
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$isi->DEPT</td>";
                                        echo "<td style=text-left:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->AMOUNT) . "</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_SLOC</td>";
                                        echo "<td style=text-align:center;>$isi->CLASSNAME</td>";
                                        if ($stat_in_out == 0) {
                                            echo "<td style=text-align:right;>" . number_format($begin_bal) . "</td>";
                                            echo "<td style=text-align:right;>" . number_format($qty_in) . "</td>";
                                            echo "<td style=text-align:right;>" . number_format($qty_out) . "</td>";
                                        }
                                        echo "<td style=text-align:right;>" . number_format($end_bal) . "</td>";
                                        echo "<td style=text-align:right;>$isi->CHR_PART_UOM</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($load_to_sql == 0  && $load_to_sql_inout == 0) { ?>
                            <div class="grid-no-header" style='font-size: 13px;'>
                                Data was acquired on <strong><?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?></strong>
                                <div style='font-size: 14px;' class="pull-right">
                                    <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                                </div>
                                <?php if ($stat_in_out == 1) { ?>
                                    Details data transaction is updating wait until <strong><?php echo date("H", strtotime($acquired_date['CHR_MODIFED_TIME'])) . ":10"; ?></strong>
                                <?php } ?>
                            </div>
                        <?php } if ($load_to_sql == 1  || $load_to_sql_inout == 1) { ?>
                            <div class="grid-no-header" style='font-size: 13px;'>
                                <div style='background: #F3F4F5;' class="pull-right">
                                    <strong>Data is being generated </strong>
                                    Wait for a few minutes or click <a href='<?php echo base_url('index.php/raw_material/inventory_c') ?>' id="btn_refresh" >Refresh</a> 
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

        <!--CHART EXCEEDED STOCK-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>EXCEEDED STOCK CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php if ($load_to_sql == 0  && $load_to_sql_inout == 0) { ?>
                        <div class="grid-body">
                            <div id="chart_exceeded_stock" style="height: 350px; width: 100%;"></div>
                        </div>
                        <div class="grid-header" style='font-size: 13px;'>
                            Data was acquired on <strong><?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?></strong>
                            <div style='font-size: 14px;' class="pull-right">
                                <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total_exceeded_stock->TOTAL); ?></strong>
                            </div>
                        </div>
                    <?php } if ($load_to_sql == 1  || $load_to_sql_inout == 1) { ?>
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
        <!--CHART EXCEEDED STOCK-->

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                    var chart2;
                    $(document).ready(function () {
                    chart2 = new Highcharts.Chart({
                    chart: {
                    renderTo: 'container_exceeded',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: ''
                            },
                            xAxis: {
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
                            },
                            yAxis: {
                            title: {
                            text: 'Exceeded Stock'
                            }
                            },
                            series: [
<?php
foreach ($data_summary_inventory_by_date_exceeded_stock as $row) {
    ?>
                                {
                                name: '<?php echo $row->CHR_DEPT; ?>',
                                        data: [
    <?php
    echo $row->DATE_1 . ',' . $row->DATE_2 . ',' . $row->DATE_3 . ',' . $row->DATE_4 . ',' . $row->DATE_5 . ',' . $row->DATE_6 . ',' . $row->DATE_7 . ',' . $row->DATE_8 . ',' . $row->DATE_9
    . ',' . $row->DATE_10 . ',' . $row->DATE_11 . ',' . $row->DATE_12 . ',' . $row->DATE_13 . ',' . $row->DATE_14 . ',' . $row->DATE_15 . ',' . $row->DATE_16 . ',' . $row->DATE_17
    . ',' . $row->DATE_18 . ',' . $row->DATE_19 . ',' . $row->DATE_20 . ',' . $row->DATE_21 . ',' . $row->DATE_22 . ',' . $row->DATE_23 . ',' . $row->DATE_24 . ',' . $row->DATE_25
    . ',' . $row->DATE_26 . ',' . $row->DATE_27 . ',' . $row->DATE_28 . ',' . $row->DATE_29 . ',' . $row->DATE_30 . ',' . $row->DATE_31;
    ?>
                                        ]
                                },
    <?php
}
?>
                            ]
                    });
                    });</script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>EXCEEDED STOCK LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <?php if ($load_to_sql == 0 && $load_to_sql_inout == 0) { ?>
                        <div class="grid-body">
                            <div id="container_exceeded" style="height: 350px; width: 100%;"></div>
                        </div>
                    <div class="grid-header" style='font-size: 13px;'>
                        Data daily captured at <strong>06:00</strong>
                    </div>
                    <?php } if ($load_to_sql == 1  || $load_to_sql_inout == 1) { ?>
                        <div class="grid-body">
                            <table width=100% id='filterdiagram' ><td> Data is being generated</td></table>
                        </div>
                        <div class="grid-header" style='font-size: 13px;'>
                        Data daily captured at <strong>06:00</strong>
                    </div>
                    <?php } ?>
                    
                   
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID EXCEEDED STOCK-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th"></i>
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
                                        <?php echo form_open('raw_material/inventory_c/print_inventory_exceed', 'class="form-horizontal"'); ?>
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <!--                        <div id="table-luar">--><div class="table-wrapper" style="margin-top:20px;">
                            <table id="example2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">Dept</th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">Amount Diff</th>
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Class </th> 
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
                                    </tr>

                                </thead>
                                <tfoot>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">Dept</th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">Amount Diff</th>
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Class </th> 
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
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_data_inventory_by_prod_exceeded_stock as $isi) {
                                        $end_bal = intval($isi->INT_QTY_STOCK);
                                        $qty_in = intval($isi->CHR_TRANS_IN);
                                        $qty_out = intval($isi->CHR_TRANS_OUT);
                                        $begin_bal = $end_bal - $qty_in + $qty_out;
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$isi->DEPT</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->AMOUNT) . "</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_SLOC</td>";
                                        echo "<td style=text-align:center;>$isi->CLASSNAME</td>";
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
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($load_to_sql == 0  && $load_to_sql_inout == 0) { ?>
                            <div class="grid-no-header">
                                Data was acquired on <strong><?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?></strong>
                                <div style='font-size: 14px;' class="pull-right">
                                    <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total_exceeded_stock->TOTAL); ?></strong>
                                </div>
                            </div>
                        <?php } if ($load_to_sql == 1  || $load_to_sql_inout == 1) { ?>
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

<!--        <div class="row" id="body" data-baseurl="<?php echo base_url(); ?>">
    <div class="col-md-12">
        <div class="grid">
            <div class="grid-header">
                <i class="fa fa-search"></i>
                <span class="grid-title"><strong>SEARCH PART IN OUT</strong></span>
                <div class="pull-right grid-tools">
                    <a data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="grid-body">
                <div class="pull">
                    <table width="70%" id='filter' border=0px>
                        <tr>
                            <td width="10%">
                                <select class="ddl" id='period_show' name='period'>
                                    <option value='201706'>201706</option>
                                    <option value='201707'>201707</option>
                                    <option value='201708' selected>201708</option>
                                </select>
                                <select class="ddl" id="tanggal">
        <?php for ($x = -3; $x <= 0; $x++) { ?>
                                                    <option value="<?php echo date("Ym", strtotime("+$x month")); ?>" <?php
            if ($selected_date == date("Ym", strtotime("+$x month"))) {
                echo 'SELECTED';
            }
            ?> > <?php echo date("Ym", strtotime("+$x month")); ?> </option>
        <?php } ?>
                                </select>
                                <input type="hidden" id="date_value" name='period' value="<?php echo date('Ym'); ?>">
                            </td>
                            <td width="40%">
                                <div class="input-group">
                                    <input type="text" class="form-control" id='part_no' nama='part_no' placeholder="Part Number">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" id='filter_by_part_number' ><i class="fa fa-search"></i>&nbsp;&nbsp;Go </button>
                                    </span>
                                </div>
                            </td>
                            <td width="20%">
                                <span style="font-size:13px;" class='label label-danger' id='message'></span >
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="table-wrapper" style="margin-top:20px;">
                    <table id="dataTables3" class="table table-condensed table-bordered table-striped display" cellspacing="0">
                        <thead>
                            <tr class='gradeX'>
                                <th rowspan="2" style="vertical-align: middle;"><div class='td-fixed'>Sloc. </div></th>
                        <th rowspan="2" style="vertical-align: middle;"><div class='td-fixed'>Stat</div></th>
                        <th rowspan="2" style="vertical-align: middle;"><div class='td-fixed'>Total</div></th>
                        <th colspan='31' style="text-align:center;">Date </th>
                        <th rowspan="2" style="vertical-align: middle;"><div class='td-fixed'>Avg</div></th>
                        </tr>
                        <tr class='gradeX' id='date_column'>
        <?php for ($a = 1; $a <= 31; $a++) { ?>
                                        <td id='<?php echo $a; ?>'  style='text-align:center;'><?php echo $a; ?></td>
        <?php } ?>
                        </tr>
                        </thead>
                        <tbody id='detail_part_inout'>
                        </tbody>
                    </table>
                </div>
                <div id="div-part-name" style="display:none;">
                    <div id="part-name" style="font-size:13px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>-->
    </section>
</aside>

<!--<button class="md-trigger btn btn-primary" data-modal="modal-1" style="display:none;" id="loading">Loading </button>-->

<div class="md-modal md-effect-1" id="modal-1">
    <div class="md-content modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel19" style="text-align:center;">Please Wait ...</h4>
        </div>
        <div class="modal-body">
            <p style="text-align:center;">Connecting to sap Server </p>
            <div style="text-align:center;"><img src="<?php echo base_url('assets/img/ajax-loader-7.gif') ?>"></div>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-default md-close" data-dismiss="modal" id="close-loading" style="display:none;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

    $('#tanggal').on('change', function () {
    $('#date_value').val($(this).val());
    });
    $("#filter_by_part_number").click(function() {
    if ($("#part_no").val() == ''){
    $("#message").html("Part. No Cant be empty");
    } else{
    $("#loading").click();
    $("#message").html("");
    var period = $("#date_value").val();
    var part_no = $("#part_no").val();
    $.ajax({
    type: "POST",
            url: "<?php echo site_url('raw_material/inventory_c/search'); ?>",
            data: "period=" + period + "&part_no=" + part_no,
            dataType: 'json',
            success: function(data) {
            $("#close-loading").click();
            if (data.data_table == "") {
            $("#message").html("Data not Found");
            $("#div-part-name").hide();
            $("#part-name").html("");
            $("#detail_part_inout").html(data.data_table);
            } else {
            $("#detail_part_inout").html(data.data_table);
            $("#div-part-name").show();
            $("#part-name").html(data.part_name);
            $("#date_column").html(data.day);
            console.log(data.day);
            }
            }
    });
    }

    });
    });</script>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>

    $(document).ready(function() {

//    setTimeout(function () {
//        document.getElementById("hide-sub-menus").click();
//    }, 10);

    $('#example').DataTable({
        // scrollY: "400px",
        //     scrollX: true,
        //     scrollCollapse: true,
        //     paging: false,
        //     columnDefs: [{
        //             sortable: false,
        //             "class": "index",
        //             targets: 0
        //         }],
        //     fixedColumns: {
        //         leftColumns: 5
        //     },
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
    });</script>

<script>

    $(document).ready(function() {
        $('#example2').DataTable({

            // scrollY: "400px",
            // scrollX: true,
            // scrollCollapse: true,
            // paging: false,
            // columnDefs: [{
            //         sortable: false,
            //         "class": "index",
            //         targets: 0
            //     }],
            // fixedColumns: {
            //     leftColumns: 5
            // },

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