<script>
    $(document).ready(function () {
<?php foreach ($data as $isi_nya) { ?>
            $('#row_activity_<?php echo $isi_nya->INT_ID_ACTIVITY ?>').click(function () {
                var id_activity = <?php echo $isi_nya->INT_ID_ACTIVITY ?>;
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/activity_c/getUpdate'); ?>",
                    data: "id_activity=" + id_activity,
                    success: function (data) {
                        $("#update_content").html(data);
                        $("#sub-title").html('EDIT ACTIVITY PROJECT');

                    }
                });
            });
<?php }
?>
    });
</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Manage Project Activity</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <div class="row">
            <?php echo $msg; ?>
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong id='sub-title'>CREATE PROJECT ACTIVITY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div>
                        <div class="grid-body" id="update_content">
                            <?php echo form_open('eci/activity_c/save_activity', 'class="form-horizontal"'); ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">ACTIVITY NAME *</label>
                                <div class="col-sm-8">
                                    <input name="activity_name" id="activity_name" autofocus class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;float:left;">
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-push-4">
                                    <div class="btn-group">
                                        <button id="btn-ok" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                        <?php
                                        echo anchor('eci/activity_c/', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                        echo form_close();
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <font style="color: red; font-weight: bold">* Required Field</font>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PROJECT ACTIVITY TABLE</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No </th>
                                    <th style="text-align:center;">Activity</th>
                                    <th style="text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr id=\"row_activity_$isi->INT_ID_ACTIVITY\">";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_ACTIVITY_NAME</td>";
                                    ?>
                                <td style="text-align:center;">
                                    <a href="<?php echo site_url("eci/activity_c/delete_activity/$isi->INT_ID_ACTIVITY") ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this activity?');"><span class="fa fa-times"></span></a>
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
    </section>
</aside>