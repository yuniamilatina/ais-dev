<script>
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
</script>
<script>
    $(function () {
        $("#timepicker").datetimepicker({
            inline: true,
        });
    });
</script>
<script>
    $(function () {
        $("#timepicker1").datetimepicker({
            inline: true,
        });
    });
</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/room/room_reservation_c') ?>">Manage Reservation</a></li>
            <li><a href="#"><strong>Edit Reservation</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <form action="<?php echo base_url('index.php/room/room_reservation_c/update_reservation') ?>" class="form-horizontal" method="post" accept-charset="utf-8" name="form-room">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-certificate"></i>
                            <span class="grid-title"><strong>EDIT</strong> ROOM RESERVATION</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <input type='hidden' name='CHR_ID_RESERV' value='<?php echo $data->CHR_ID_RESERV; ?>' >

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Room</label>
                                <div class="col-sm-5">
                                    <select name="room" autofocus class="form-control" style="width:200px">
                                        <?php
                                        foreach ($room as $isi) {
                                            ?>
                                            <option value="<?php echo $isi->CHR_KODE_ROOM; ?>"><?php echo $isi->CHR_DESC; ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date , Time</label>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4">
                                        <input type="text" class="form-control date-picker" id="timepicker" name="start_date" value="<?php echo date('Y-m-d', strtotime($data->CHR_DATE_FROM)) . ' ' . date('H:i', strtotime($data->CHR_TIME_FROM)); ?>">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    </div>

                                </div>
                                <div class="col-sm-1">
                                    <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4">
                                        <span style="margin-left: 20px;margin-top: 5px;">To</span>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4">
                                        <input type="text" class="form-control date-picker" id="timepicker1" name="finish_date" value="<?php echo date('Y-m-d', strtotime($data->CHR_DATE_TO)) . ' ' . date('H:i', strtotime($data->CHR_TIME_TO)); ?>">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name of Meeting</label>
                                <div class="col-sm-5">
                                    <input  class="form-control" required type="text" name="meeting_desc" value='<?php echo trim($data->CHR_MEETING_DESC); ?>'>
                                </div>
                            </div>
                            
                            <div class="checkbox" style="padding-left: 260px;padding-bottom: 10px;">
                                <input type="checkbox" class="icheck" name="INT_FLG_MEETING" value="1" <?php if($data->INT_FLG_MEETING == '1'){ echo 'checked'; } ?>>
                                Meeting
                            </div>

                            <div class="checkbox" style="padding-left: 260px;padding-bottom: 10px;">
                                <input type="checkbox" class="icheck" name="INT_FLG_GENBA" value="1" <?php if($data->INT_FLG_GENBA == '1'){ echo 'checked'; } ?>>
                                Plant Tour
                            </div>

                            <div class="checkbox" style="padding-left: 260px;padding-bottom: 10px;">
                                <input type="checkbox" class="icheck" name="INT_FLG_CONFERENCE" value="1" <?php if($data->INT_FLG_CONFERENCE == '1'){ echo 'checked'; } ?>>
                                TV Conference
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">PIC Name (AII)</label>
                                <div class="col-sm-2">
                                    <input class="form-control" maxlength="30" required type="text" name="meeting_pic" value='<?php echo trim($data->CHR_MEETING_PIC); ?>'>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">PIC Dept</label>
                                <div class="col-sm-5">
                                    <select name="dept" autofocus class="form-control" style="width:100px">
                                        <?php
                                        foreach ($dept as $isi) {
                                            ?>
                                            <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT; ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select> 
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Agenda</label>
                                <div class="col-sm-6">
                                    <textarea name="CHR_AGENDA" rows="8" cols="500" class="form-control" placeholder="Please detail the agenda" maxlength="500"><?php echo $data->CHR_AGENDA; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <div class="btn-group">
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                        <?php
                                        echo anchor('room/room_reservation_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                        echo form_close();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
</aside>