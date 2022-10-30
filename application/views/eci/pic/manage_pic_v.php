<script>
    $(document).ready(function () {
<?php foreach ($data as $isi_nya) { ?>
            $('#row_activity_<?php echo $isi_nya->INT_ID_PIC ?>').click(function () {
                var id_activity = <?php echo $isi_nya->INT_ID_PIC ?>;
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/pic_c/getUpdate'); ?>",
                    data: "id_activity=" + id_activity,
                    success: function (data) {
                        $("#update_content").html(data);
                        $("#sub-title").html('EDIT PROJECT PIC');
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
            <li><a href="#"><span><strong>Manage Project PIC</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong id='sub-title'>CREATE PROJECT PIC</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  id="update_content">
                        <?php echo form_open('eci/pic_c/save_pic', 'class="form-horizontal"'); ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">NPK *</label>
                            <div class="col-sm-8">
                                <input name="CHR_NPK" autofocus class="form-control" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama *</label>
                            <div class="col-sm-8">
                                <input name="CHR_NAME" class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Dept *</label>
                            <div class="col-sm-8">
                                <input name="CHR_DEPT" autofocus class="form-control" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input name="CHR_EMAIL" class="form-control" maxlength="50" style="width: 290px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Superior</label>
                            <div class="col-sm-8">
                                <input name="CHR_NAME_SUPERIOR" class="form-control" maxlength="50" style="width: 290px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email Superior</label>
                            <div class="col-sm-8">
                                <input name="CHR_EMAIL_SUPERIOR" class="form-control" maxlength="50" style="width: 290px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-push-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('eci/pic_c', 'Reset', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <font style="color: red; font-weight: bold">* Required Field</font>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PROJECT PIC TABLE</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Dept</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr id=\"row_activity_$isi->INT_ID_PIC\">";
                                    echo "<td>$isi->CHR_NPK</td>";
                                    echo "<td>$isi->CHR_NAME</td>";
                                    echo "<td>$isi->CHR_DEPT</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/eci/pic_c/delete_pic') . "/" . $isi->INT_ID_PIC; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this PIC?');"><span class="fa fa-times"></span></a>
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