<script>
    function updateField(id) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('accounting/master_data_c/get_gl'); ?>",
            data: "id=" + id,
            dataType: "JSON",
            success: function (data) {
                $("#id_gl").val(data.id);
                $("#gl_name").val(data.name);
            }
        });
    }
</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Mapping Equal GL</strong></span></a></li>
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
                        <span class="grid-title"><strong id='sub-title'>Manage Mapping</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div>
                        <div class="grid-body" id="update_content">
                            <?php echo form_open('accounting/master_data_c/mapping_gl', 'class="form-horizontal"', 'action="post   "'); ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Equal Name</label>
                                <div class="col-sm-8">
                                    <select class="form-control"  name="id_equal" id="id_equal">
                                        <option></option>
                                        <?php
                                        foreach ($equaldata as $value_equal) {
                                            echo "<option value='$value_equal->CHR_ID_EQUALISASI'";
                                            if (trim($value_equal->CHR_ID_EQUALISASI) == trim($id_equal)) {
                                                echo "selected";
                                            }
                                            echo ">";
                                            echo $value_equal->CHR_NAME . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-push-4">
                                    <div class="btn-group">
                                        <button name="btn_search" id="btn_search" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Search mapping" value="1"><i class="fa fa-check"></i> Search</button>
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
                        <span class="grid-title"><strong>MAPPING TABLE</strong></span>
                        <div class="pull-right grid-tools">
                            <?php echo form_open("accounting/master_data_c/mapping_gl/$id_equal", 'class="form-horizontal"', 'action="post"'); ?>

                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAdd">
                                <i class="fa fa-plus-square"></i> Add
                            </button>
                            <button name="btn_update" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update" value="1"><i class="fa fa-save"></i> Update</button>

                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Checked</th>
                                    <th style="text-align:center;" >Id</th>
                                    <th style="text-align:center;" >Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if (!$master_data == "") {
                                    foreach ($master_data as $isi) {
                                        $id_gl_account = trim($isi->CHR_GL_ACCOUNT);
                                        $name_equalisasi = trim($isi->CHR_NAME);
                                        echo "<tr>";
                                        echo "<td style=\"text-align:center;\">$i</td>";
                                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\"  checked onclick=\"$('#cb_dtb_$id_gl_account').click()\" value='1'></td>";
                                        echo "<td style=\"text-align:center;\">$id_gl_account</td>";
                                        echo "<td>$name_equalisasi</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <table style="display:none;">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Checked</th>
                                    <th style="text-align:center;" >Id</th>
                                    <th style="text-align:center;" >Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if (!$master_data == "") {
                                    foreach ($master_data as $isi) {
                                        $id_gl_account = trim($isi->CHR_GL_ACCOUNT);
                                        $name_equalisasi = trim($isi->CHR_NAME);
                                        echo "<tr>";
                                        echo "<td style=\"text-align:center;\">$i</td>";
                                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" id=\"cb_dtb_$id_gl_account\" name=\"cb_dtb_$id_gl_account\" checked onclick=\"$('#cb_live_$id_gl_account').click()\" value='1'></td>";
                                        echo "<td style=\"text-align:center;\">$id_gl_account</td>";
                                        echo "<td style=\"text-align:center;\">$name_equalisasi</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </section>
</aside>

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-wrapper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel8">Add GL Account</h4>
                </div>
                <div class="modal-body">
                    <div class="grid-body">
                        <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Checked</th>
                                    <th style="text-align:center;" >Id</th>
                                    <th style="text-align:center;" >Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if (!$nmaster_data == "") {
                                    foreach ($nmaster_data as $isi) {
                                        $id_gl_account = trim($isi->CHR_GL_ACCOUNT);
                                        $name_equalisasi = trim($isi->CHR_NAME);
                                        echo "<tr>";
                                        echo "<td style=\"text-align:center;\">$i</td>";
                                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\"   onclick=\"$('#cb_add_live_$id_gl_account').click()\"></td>";
                                        echo "<td style=\"text-align:center;\">$id_gl_account</td>";
                                        echo "<td>$name_equalisasi</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php echo form_open("accounting/master_data_c/mapping_gl/$id_equal", 'class="form-horizontal"', 'action="post"'); ?>
                        <table style="display:none;">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Checked</th>
                                    <th style="text-align:center;" >Id</th>
                                    <th style="text-align:center;" >Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if (!$nmaster_data == "") {
                                    foreach ($nmaster_data as $isi) {
                                        $id_gl_account = trim($isi->CHR_GL_ACCOUNT);
                                        $name_equalisasi = trim($isi->CHR_NAME);
                                        echo "<tr>";
                                        echo "<td style=\"text-align:center;\">$i</td>";
                                        echo "<td style=\"text-align:center;\"><input id=\"cb_add_live_$id_gl_account\" name=\"cb_add_live_$id_gl_account\" type=\"checkbox\"  value='1' ></td>";
                                        echo "<td style=\"text-align:center;\">$id_gl_account</td>";
                                        echo "<td style=\"text-align:center;\">$name_equalisasi</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button name="btn_add_gl" id="btn_add_gl" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Search mapping" value="1"><i class="fa fa-check"></i> Add</button>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>