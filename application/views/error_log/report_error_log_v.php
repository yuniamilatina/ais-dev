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
            <li><a href=""><strong>REPORT ERROR LOG & COGI</strong></a></li>
        </ol>
    </section>



    <section class="content">

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                    window.onload = function () {
                    var chart_errorlog = new CanvasJS.Chart("chart_error_log",
                    {
                    animationEnabled: true,
                            theme: "theme1",
                            title: {
                            fontColor: "white",
                                    text: ""},
                            axisY: {

                            title: "Amount",
                                    gridThickness: 1
                            },
                            dataPointMaxWidth: 80,
                            data: [
<?php
$row = 1;
foreach ($data_chart_error_log as $isi) {
    ?>
    <?php if ($row != $total_row) { ?>

        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '}'
            . ']},';
        }
        $row++;
        ?>

    <?php } else { ?>
        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 
                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->ERROR_TYPE . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        indexLabel:' . '"' . '#total' . '"' . ',
                                                                        legendText:' . '"' . $isi->ERROR_TYPE . '"' . ',
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
                                    chart_errorlog.render();
                                    }
                            }
                    }
                    );
                    chart_errorlog.render();
                    var chart_cogi = new CanvasJS.Chart("chart_cogi",
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
$row_cogi = 1;
foreach ($data_chart_cogi as $isi) {
    ?>
    <?php if ($row_cogi != $total_row_cogi) { ?>

        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PPC') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
        } else {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '}'
            . ']},';
        }
        $row_cogi++;
        ?>

    <?php } else { ?>
        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 
                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PPC') {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        indexLabel:' . '"' . '#total' . '"' . ',
                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:0,label:' . '"' . 'N/A' . '"' . '}'
            . ']}';
        } else {
            echo '{type: "stackedColumn", 

                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->DEPT . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                                        indexLabel:' . '"' . '#total' . '"' . ',
                                                                        legendText:' . '"' . $isi->DEPT . '"' . ',
                                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
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
                                    chart_cogi.render();
                                    }
                            }
                    }
                    );
                    chart_cogi.render();
                    }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>ERROR LOG CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="chart_error_log" style="height: 350px; width: 100%;"></div>
                    </div>
                    <div class="grid-header" style='font-size: 13px;'>
                        <div style='font-size: 14px;' class="pull-right">
                            <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID TO DISPLAY GRID TABLE-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>DETAIL ERROR LOG</strong></span>
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
                                        <?php echo form_open('error_log/error_log_c/print_error_log', 'class="form-horizontal"'); ?>
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th style="text-align:center;">Dept</th>
                                    <th style="text-align:center;">Back. No </th>
                                    <th style="text-align:center;">Part. No </th>
                                    <th style="text-align:center;">Part.Name & Model </th>
                                    <th style="text-align:center;">Valuation Class</th>
                                    <th style="text-align:center;">UOM </th>
                                    <th style="text-align:center;">Error Type </th>
                                    <th style="text-align:center;">Transaction Date</th>
                                    <th style="text-align:center;">Work Center</th>
                                    <th style="text-align:center;">Sloc. From</th>
                                    <th style="text-align:center;">Sloc To </th>
                                    <th style="text-align:center;">Pds </th>
                                    <th style="text-align:center;">No PL </th>
                                    <th style="text-align:center;">Total Qty </th>
                                    <th style="text-align:center;">Message </th>
                                </tr>

                            </thead>
                            <tfoot>
                                <tr class='gradeX'>
                                    <th style="text-align:center;">Dept</th>
                                    <th style="text-align:center;">Back. No </th>
                                    <th style="text-align:center;">Part. No </th>
                                    <th style="text-align:center;">Part.Name & Model </th>
                                    <th style="text-align:center;">Valuation Class</th>
                                    <th style="text-align:center;">UOM </th>
                                    <th style="text-align:center;">Error Type </th>
                                    <th style="text-align:center;">Transaction Date</th>
                                    <th style="text-align:center;">Work Center</th>
                                    <th style="text-align:center;">Sloc. From</th>
                                    <th style="text-align:center;">Sloc To </th>
                                    <th style="text-align:center;">Pds </th>
                                    <th style="text-align:center;">No PL </th>
                                    <th style="text-align:center;">Total Qty </th>
                                    <th style="text-align:center;">Message </th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $r = 1;
                                foreach ($data_error_log as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style=text-align:center;>$isi->CHR_DEPT</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_VAL_CLASS_NAME</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_PART_UOM</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->ERROR_TYPE</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_DATE_ENTRY</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_SLOC_FROM</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_SLOC_TO</td>";
                                    echo "<td style=text-align:right;>$isi->CHR_PDS_NO</td>";
                                    echo "<td style=text-align:right;>$isi->CHR_DEL_NO</td>";
                                    echo "<td style=text-align:right;>$isi->INT_TOTAL_QTY</td>";
                                    echo "<td style=text-align:right;>$isi->CHR_MESSAGE</td>";
                                    ?>
                                    </tr>
                                    <?php
                                    $r++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>COGI CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="chart_cogi" style="height: 350px; width: 100%;"></div>
                    </div>
                    <div class="grid-header" style='font-size: 13px;'>
                        <div style='font-size: 14px;' class="pull-right">
                            <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total_cogi->TOTAL); ?></strong>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID TO DISPLAY GRID TABLE-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>DETAIL COGI</strong></span>
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
                                        <?php echo form_open('error_log/error_log_c/print_detail_cogi', 'class="form-horizontal"'); ?>
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <table id="example2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th style="text-align:center;">Dept</th>
                                    <th style="text-align:center;">Back. No </th>
                                    <th style="text-align:center;">Part. No </th>
                                    <th style="text-align:center;">Part.Name & Model </th>
                                    <th style="text-align:center;">Total Qty </th>
                                    <th style="text-align:center;">UOM </th>
                                    <th style="text-align:center;">SLOC </th>
                                    <th style="text-align:center;">Message </th>
                                </tr>

                            </thead>
                            <tfoot>
                                <tr class='gradeX'>
                                    <th style="text-align:center;">Dept</th>
                                    <th style="text-align:center;">Back. No </th>
                                    <th style="text-align:center;">Part. No </th>
                                    <th style="text-align:center;">Part.Name & Model </th>
                                    <th style="text-align:center;">Total Qty </th>
                                    <th style="text-align:center;">UOM </th>
                                    <th style="text-align:center;">SLOC </th>
                                    <th style="text-align:center;">Message </th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $r = 1;
                                foreach ($data_cogi as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style=text-align:center;>$isi->CHR_DEPT</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                    echo "<td style=text-align:right;>$isi->INT_TOTAL_QTY</td>";
                                    echo "<td style=text-align:right;>$isi->CHR_UOM</td>";
                                    echo "<td style=text-align:right;>$isi->CHR_SLOC</td>";
                                    echo "<td style=text-align:right;>$isi->CHR_MESSAGE</td>";
                                    ?>
                                    </tr>
                                    <?php
                                    $r++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY GRID TABLE-->


    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>

                    $(document).ready(function () {


                    $('#example').DataTable({
                    //    scrollX: true,
                    //        fixedColumns: {
                    //           leftColumns: 2
                    //       },
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
                    $(document).ready(function () {

                    $('#example2').DataTable({

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