<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
</style>

<script src="<?php echo base_url('assets/datetimepicker/jquery.timepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/jquery.timepicker.css'); ?>" >
<script src="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.css'); ?>" >

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/delivery/') ?>">Home</a></li>
            <li><a href=""><strong>Pick Up Export</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid border">
                    <div class="grid-header">
                        <i class="fa fa-truck"></i>
                        <span class="grid-title"><strong>PICK UP EXPORT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <form action="<?php echo base_url('index.php/delivery/pickup_export_c/index') ?>" class="form-horizontal" method="post">
                                <div id="datepairExample">
                                    <div  class="form-group" >
                                    <div class="col-sm-3">
                                        <div class="input-group" >
                                            <input type="text" class="form-control date start" autocomplete="off" name="start_date" value='<?php echo $start_date; ?>'>
                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control time start" autocomplete="off" name="start_time" value='<?php echo $start_time; ?>'>
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                    <strong>TO</strong>
                                    </div><div  class="form-group" >
                                    <div class="col-sm-3">
                                        <div class="input-group" data-date-format="HH:ii" >
                                            <input type="text" class="form-control date end" autocomplete="off" name="finish_date" value='<?php echo $finish_date; ?>'>
                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control time end" autocomplete="off" name="finish_time" value='<?php echo $finish_time; ?>'>
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                    <button type="submit" name="btn_submit" value="1" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                                </div></div>
                            </form>
                        </div>
                    </div>
                    <div class='grid-body'>
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped display">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">NPK</th>
                                        <th style="text-align:center;">Name</th>
                                        <th style="text-align:center;">Customer</th>
                                        <th style="text-align:center;">Date</th>
                                        <th style="text-align:center;">Time</th>
                                        <th style="text-align:center;">Pallet Id</th>
                                        <th style="text-align:center;">Packing Id</th>
                                        <th style="text-align:center;">No PO</th>
                                        <th style="text-align:center;">Pallet Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_pickup_export as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$r</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_NPK</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_USERNAME</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_CUST_NAME</td>";
                                        echo "<td style='text-align:center;'><div style='width:80px;'>$isi->CHR_DATE_SCAN</td>";
                                        echo "<td style='text-align:center;'>" . date("H:i:s", strtotime($isi->CHR_TIME_SCAN)) . "</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_IDPALLET</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_IDPACKING</td>";
                                        echo "<td style='text-align:left;'>$isi->CHR_NOPO_CUST</td>";
                                        echo "<td style='text-align:center;'>1</td></tr>";
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

<script>
    $('#datepairExample .time').timepicker({
        'showDuration': true,
        'timeFormat': 'G:i'
    });

    $('#datepairExample .date').datepicker({
        'format': 'dd-mm-yyyy',
        'autoclose': true
    });

    $('#datepairExample').datepair();
</script>