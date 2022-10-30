<script>

    function updateField(id) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('accounting/master_data_c/get_equal'); ?>",
            data: "id=" + id,
            dataType: "JSON",
            success: function (data) {
                $("#id_equalisasi").val(data.id);
                $("#equalisasi_name").val(data.name);
            }
        });
    }

    $(document).ready(function () {

    });
</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Master Data Equalisasi</strong></span></a></li>
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
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong id='sub-title'>Manage Equalisasi</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div>
                        <div class="grid-body" id="update_content">
                            <?php echo form_open('accounting/master_data_c/equalisasi', 'class="form-horizontal"', 'action="post   "'); ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Id Equalisasi *</label>
                                <div class="col-sm-8">
                                    <input name="id_equalisasi" id="id_equalisasi" autofocus class="form-control" maxlength="4" required type="text" style="width: 100px;text-transform: uppercase;float:left;">
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Equalisasi Name *</label>
                                <div class="col-sm-8">
                                    <input name="equalisasi_name" id="equalisasi_name" autofocus class="form-control" maxlength="50" required type="text" style="width: 95%;text-transform: uppercase;float:left;">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-push-4">
                                    <div class="btn-group">
                                        <button name="btn_save" id="btn-save" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data" value="1"><i class="fa fa-check"></i> Save</button>
                                        <?php
                                        echo anchor('#', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            echo form_close();
                            ?>
                            <font style="color: red; font-weight: bold">* Required Field</font>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>EQUALISASI  TABLE</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;" rowspan="2">Id</th>
                                    <th style="text-align:center;" rowspan="2">Name</th>
                                    <th style="text-align:center;" colspan="3">Create</th>
                                    <th style="text-align:center;" colspan="3">Modified</th>
                                    <th style="text-align:center;" rowspan="2">Action</th>
                                </tr>
                                <tr onclick="">
                                    <th style="text-align:center;">User</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Time</th>
                                    <th style="text-align:center;">User</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($master_data as $isi) {
                                    $id_equalisasi = trim($isi->CHR_ID_EQUALISASI);
                                    $name_equalisasi = trim($isi->CHR_NAME);
                                    $user_create = trim($isi->CHR_CREATE_USER);
                                    $date_create = date("d-M-Y", strtotime(trim($isi->CHR_CREATE_DATE)));
                                    $time_create = date("H:i:s", strtotime(trim($isi->CHR_CREATE_TIME)));
                                    $user_modified = trim($isi->CHR_MODIFIED_USER);
                                    if (!$user_modified == null) {
                                        $date_modified = date("d-M-Y", strtotime(trim($isi->CHR_MODIFIED_DATE)));
                                        $time_modified = date("H:i:s", strtotime(trim($isi->CHR_MODIFIED_TIME)));
                                    } else {
                                        $date_modified = "";
                                        $time_modified = "";
                                    }

                                    echo "<tr id=\"row_MD_" . trim($isi->CHR_ID_EQUALISASI) . "\" onclick=\"updateField()\">";
                                    echo "<td>$id_equalisasi</td>";
                                    echo "<td>$name_equalisasi</td>";
                                    echo "<td>$user_create</td>";
                                    echo "<td>$date_create</td>";
                                    echo "<td>$time_create</td>";
                                    echo "<td>$user_modified</td>";
                                    echo "<td>$date_modified</td>";
                                    echo "<td>$time_modified</td>";
                                    ?>
                                <td style="text-align:center;">
                                    <a class="label label-warning" data-placement="right" data-toggle="tooltip" title="Edit" onclick="updateField('<?php echo $id_equalisasi ?>')"><span class="fa fa-edit"></span></a>
                                    <a href="<?php echo site_url("accounting/master_data_c/equalisasi/$id_equalisasi") ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this?');"><span class="fa fa-times"></span></a>
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