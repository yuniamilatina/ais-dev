

<script>
    $(document).ready(function () {
        var date = new Date();
        $("#datepicker1").datepicker({dateFormat: 'yymmdd'}).val();
    });
</script>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);
</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    .ddl3{
        width:50px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>PRODUCTION ACTIVITY</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PRODUCTION ACTIVITY </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style='text-align:center;'>Wo Number</th>
                                        <th style='text-align:center;'>Shift <br> Type</th>
                                        <th style='text-align:center;'>Start <br> Production</th>

                                        <th style='text-align:center;'>Shift Reference  <br> Time (m)</th>
                                        <th style='text-align:center;'>Operating <br> Time (m)</th>
                                        <th style='text-align:center;background:#b4fab7'>Break + 3S &<br> Bridging (m)</th>
                                        <th style='text-align:center;background:#d60909;color:#FFF;'>Prod.<br>  Time (m)</th>
                                        <th style='text-align:center;background:#ff9e9e;color:#FFF;'>Line <br> Stop (m)</th>
                                        <th style='text-align:center;background:#f73434;color:#FFF;'>Prod. <br> Runtime (m)</th>

                                        <th style='text-align:center;background:#025a9e;color:#FFF;'>Target <br> Based CT</th>
                                        <th style='text-align:center;background:#ffc414'>OK</th>
                                        <th style='text-align:center;background:#fce397'>NG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data as $isi) {
                                        echo "<td style=text-align:center;>$isi->CHR_WO_NUMBER</td>";
                                        echo "<td style=text-align:center;>$isi->FLG_SHIFT</td>";
                                        echo "<td style=text-align:center;>".date("d-m-Y", strtotime($isi->CHR_CREATED_DATE)).' '.date("H:i:s", strtotime($isi->CHR_CREATED_TIME))."</td>";
                                        
                                        echo "<td style=text-align:center;>$isi->NORMAL_TIME</td>";
                                        echo "<td style=text-align:center;>$isi->INT_OPERATING_TIME_MINUTE</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PLANNED_DOWNTIME_MINUTE</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PRODUCTION_TIME_MINUTE</td>";
                                        echo "<td style=text-align:center;>$isi->INT_UNPLANNED_DOWNTIME_MINUTE</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PRODUCTION_RUNTIME_MINUTE</td>";

                                        echo "<td style=text-align:center;>$isi->INT_PLAN_CT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_OK</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PRODUCTION ACTIVITY DETAIL </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style='text-align:center'; >Wo Number</th>
                                        <th style='text-align:center'; >Dandori <br> Ke-</th>
                                        <th style='text-align:center'; >P/N</th>
                                        <th style='text-align:center'; >MP</th>
                                        <th style='text-align:center'; >CT</th>
                                        <th style='text-align:center'; >Plan</th>
                                        <th style='text-align:center'; >OK</th>
                                        <th style='text-align:center'; >NG</th>
                                        <th style='text-align:center'; >Start</th>
                                        <th style='text-align:center'; >Stop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_detail as $isi) {
                                        echo "<td style='text-align:center';>$isi->CHR_WO_NUMBER</td>";
                                        echo "<td style='text-align:center';>$isi->INT_PR_SEQUENCE</td>";
                                        echo "<td style='text-align:left';>$isi->CHR_PART_NO</td>";
                                        echo "<td style='text-align:center';>$isi->INT_MP</td>";
                                        echo "<td style='text-align:center';>$isi->INT_CT</td>";
                                        echo "<td style='text-align:center';>$isi->INT_PLAN_CT</td>";
                                        echo "<td style='text-align:center';>$isi->INT_TOTAL_OK</td>";
                                        echo "<td style='text-align:center';>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style='text-align:center';>$isi->CHR_START_CHANGE</td>";
                                        echo "<td style='text-align:center';>$isi->CHR_STOP_CHANGE</td>";
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>LINE STOP PRODUCTION </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style='text-align:center'; >No</th>
                                        <th style='text-align:center'; >Wo Number</th>
                                        <th style='text-align:center'; >L/N</th>
                                        <th style='text-align:center'; >Line Stop</th>
                                        <th style='text-align:center'; >Durasi LS. (m)</th>
                                        <th style='text-align:center'; >Durasi Waiting (m)</th>
                                        <th style='text-align:center'; >Durasi Repair (m)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_ls as $isi) {
                                        echo "<td style='text-align:center';>$r</td>";
                                        echo "<td style='text-align:center';>$isi->CHR_WO_NUMBER</td>";
                                        echo "<td style='text-align:center';>$isi->FLG_SHIFT</td>";
                                        echo "<td style='text-align:left';>$isi->CHR_LINE_STOP</td>";
                                        echo "<td style='text-align:center';>$isi->INT_DURASI_LS</td>";
                                        echo "<td style='text-align:center';>$isi->INT_DURASI_WAITING</td>";
                                        echo "<td style='text-align:center';>$isi->INT_DURASI_REPAIR</td>";
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PROBLEM & CORRECTIVE ACTION </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style='text-align:center'; >No</th>
                                        <th style='text-align:center'; >Wo Number</th>
                                        <th style='text-align:center'; >Problem</th>
                                        <th style='text-align:center'; >C/A</th>
                                        <th style='text-align:center'; >Start Time</th>
                                        <th style='text-align:center'; >End Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_comment as $isi) {
                                        echo "<td style='text-align:center';>$r</td>";
                                        echo "<td style='text-align:center';>$isi->CHR_WO_NUMBER</td>";
                                        echo "<td style='text-align:left';>$isi->CHR_PROBLEM</td>";
                                        echo "<td style='text-align:left';>$isi->CHR_CORRECTIVE_ACTION</td>";
                                        echo "<td style='text-align:center';>$isi->CHR_START</td>";
                                        echo "<td style='text-align:center';>$isi->CHR_END</td>";
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
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            // fixedColumns: {
            //     leftColumns:2
            // }
        });
    });

</script>