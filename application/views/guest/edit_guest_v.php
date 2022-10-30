<script src="<?php echo base_url('assets/datetimepicker/jquery.timepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/jquery.timepicker.css'); ?>" >
<script src="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.css'); ?>" >

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/guest_c/') ?>">Manage Guest</a></li>
            <li><a href="#"><strong>Edit Guest</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('guest/guest_c/update_guest', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>EDIT GUEST</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <input name="INT_ID" class="form-control"  type="hidden" value="<?php echo $data->INT_ID; ?>">

                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-3">
                                <input name="CHR_FIRST_NAME" class="form-control" maxlength="200" required type="text" value="<?php echo $data->CHR_FIRSTNAME; ?>">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Last Name</label>
                            <div class="col-sm-3">
                                <input name="CHR_LAST_NAME" class="form-control" maxlength="50" type="text" value="<?php echo $data->CHR_LASTNAME; ?>">
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Company</label>
                            <div class="col-sm-4">
                                <input name="CHR_COMPANY" class="form-control" maxlength="100" type="text" value='<?php echo $data->CHR_COMPANY; ?>'>
                            </div>
                        </div> -->
                        <div id="datepairExample">
                            <div  class="form-group">
                                <label class="col-sm-3 control-label">Schedule Date</label>
                                <div class="col-sm-3">
                                    <div class="input-group" >
                                        <input type="text" class="form-control date start" autocomplete="off" name="CHR_SCHEDULE_DATE" value='<?php echo date('d-m-Y', strtotime($data->CHR_SCHEDULE_DATE)); ?>'>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control time start" autocomplete="off" name="CHR_SCHEDULE_TIME" value='<?php echo $data->CHR_SCHEDULE_TIME; ?>'>
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div> -->
                            </div>
                        </div>   
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('guest/guest_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <i>* Format pada Dashboard Welcomeboard</i>
                        <br>
                        <strong>FIRTSNAME LASTNAME | COMPANY NAME<strong>
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
