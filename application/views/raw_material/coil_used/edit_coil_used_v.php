<script language="JavaScript">
    <!--
       function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    //-->
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/coil_used/coil_used_c/'); ?>"><span>Manage Coil Return</span></a></li>
            <li><a href=""><strong>Edit Coil Return</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('raw_material/coil_used_c/update_coil_used', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>EDIT COIL RETURN</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID" class="form-control" required type="hidden" value="<?php echo $data->INT_ID; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Coil</label>
                            <div class="col-sm-2">
                                <input name="CHR_PART_NO_RM" autocomplete="off" class="form-control" readonly type="text" value="<?php echo trim($data->CHR_PART_NO_RM) ?>">
                            </div>
                        </div>

                        <!--                        <div class="form-group">
                                                    <label class="col-sm-3 control-label">Part No</label>
                                                    <div class="col-sm-2">
                                                        <input name="CHR_PART_NO" autocomplete="off" class="form-control" readonly type="text" value="<?php echo trim($data->CHR_PART_NO) ?>">
                                                    </div>
                                                </div>-->

                        <div class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-3">
                                <input name="CHR_WORK_CENTER" autocomplete="off" class="form-control" readonly type="text" value="<?php echo trim($data->CHR_WORK_CENTER) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">PDS No</label>
                            <div class="col-sm-4">
                                <input name="CHR_PDS_NO" autocomplete="off" class="form-control" readonly type="text" value="<?php echo trim($data->CHR_PDS_NO) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Serial No</label>
                            <div class="col-sm-4">
                                <input name="CHR_SERIAL_NO" autocomplete="off" class="form-control" readonly type="text" value="<?php echo trim($data->CHR_SERIAL_NO) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">SCI No</label>
                            <div class="col-sm-4">
                                <input name="CHR_BATCH" autocomplete="off" class="form-control" readonly type="text" value="<?php echo trim($data->CHR_BATCH) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Weight (KG)</label>
                            <div class="col-sm-2">
                                <input name="INT_WEIGHT" autocomplete="off" onkeyup="angka(this);" class="form-control" readonly type="text" value="<?php echo trim($data->INT_WEIGHT) ?>">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">UOM</label>
                            <div class="col-sm-2">
                                <input name="CHR_UOM" autocomplete="off" onkeyup="angka(this);" class="form-control" readonly type="text" value="KG">
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Actual Weight (KG)</label>
                            <div class="col-sm-2">
                                <input name="INT_WEIGHT_ACTUAL" autocomplete="off" class="form-control"  required type="text" onkeypress="return isNumberKey(event)" value="<?php echo trim($data->INT_WEIGHT_ACTUAL) ?>">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Actual UOM</label>
                            <div class="col-sm-2">
                                <select name="CHR_ACTUAL_UOM" class="form-control" >
                                    <option selected value="KG">KG</option>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('raw_material/coil_used_c/new_coil_used', 'Cancel', 'class="btn btn-default"');
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