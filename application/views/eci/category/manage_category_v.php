<script>
    $(document).ready(function () {
<?php foreach ($data as $isi_nya) { ?>
            $('#row_activity_<?php echo $isi_nya->INT_ID_CATEGORY ?>').click(function () {
                var id_activity = <?php echo $isi_nya->INT_ID_CATEGORY ?>;
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/category_c/getUpdate'); ?>",
                    data: "id_activity=" + id_activity,
                    success: function (data) {
                        $("#update_content").html(data);
                         $("#sub-title").html('EDIT PROJECT CATEGORY');
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
            <li><a href="#"><span><strong>Manage Project Category</strong></span></a></li>
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
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong id='sub-title'>CREATE PROJECT CATEGORY</strong></span>
                    </div>
                    <div class="grid-body"  id="update_content">
                        <?php echo form_open('eci/category_c/save_category', 'class="form-horizontal"'); ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Category Initial *</label>
                            <div class="col-sm-8">
                                <input name="CHR_CODE_CATEGORY" autofocus class="form-control" maxlength="6" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Category Description *</label>
                            <div class="col-sm-8">
                                <input name="CHR_CATEGORY_NAME" class="form-control" maxlength="20" required type="text" style="width: 290px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-push-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('eci/category_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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
                        <span class="grid-title"><strong>PROJECT CATEGORY TABLE</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category Initial</th>
                                    <th>Category Description</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr id=\"row_activity_$isi->INT_ID_CATEGORY\">";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_CODE_CATEGORY</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/eci/category_c/delete_category') . "/" . $isi->INT_ID_CATEGORY; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this category?');"><span class="fa fa-times"></span></a>
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