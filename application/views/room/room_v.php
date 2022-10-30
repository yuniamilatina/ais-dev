<script>
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
</script>
<script>
    $(function () {
        $("#timepicker").datetimepicker({
            inline: true
        });
    });
</script>
<script>
    $(function () {
        $("#timepicker1").datetimepicker({
            inline: true
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><strong>Register Room</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('room/room_c/create', 'class="form-horizontal"');

        if ($msg == "register") {
            ?>
            <div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >
        <?php } else if ($msg == "update") { ?>
            <div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >
        <?php } else if ($msg == "delete") { ?>
            <div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >
<?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title"><strong>REGISTER NEW ROOM</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kode Room</label>
                            <div class="col-sm-2">
                                <input name="kode_room" class="form-control" maxlength="5" style="text-transform: uppercase;" required type="text" value="<?php echo trim($id_room); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Room Description</label>
                            <div class="col-sm-5">
                                <input name="description" class="form-control" required type="text" value="<?php echo trim($desc_room); ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button name="btn-Submit"  type="submit" value="1" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <button name="btn-cancel"  type="reset" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Reset">Reset</button>
                                    <?php
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- BEGIN RESPONSIVE TABLE -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>MANAGE ROOM</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="table-responsive">
                            <table id="dataTables1" class="table table-striped  table-condensed table-hover display">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">#</th>
                                        <th style="text-align: center;">Kode Room</th>
                                        <th style="text-align: center;">Room Description</th>
                                        <th style="text-align: center;">URL</th>
                                        <th style="text-align: center;">Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($room as $value_room) {
                                        ?>               
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $value_room->CHR_KODE_ROOM; ?></td>
                                            <td><?php echo $value_room->CHR_DESC; ?></td>
                                            <td><?php echo $value_room->CHR_URL_DISPLAY; ?></td>
                                            <td style="text-align: center;"><a href="<?php echo base_url("index.php/room/room_c/create/1/$value_room->CHR_KODE_ROOM"); ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <a href="<?php echo base_url("index.php/room/room_c/delete_room/$value_room->CHR_KODE_ROOM"); ?>"  class="label label-danger"><span class="fa fa-times"></span></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END RESPONSIVE TABLE -->
        </div>

    </section>
</aside>