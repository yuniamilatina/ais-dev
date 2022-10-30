<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/cavity_c/') ?>">Manage Part Cavity</a></li>
            <li><a href="#"><strong>Edit Part Cavity</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('pes/cavity_c/update_cavity', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>EDIT PART CAVITY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Id</label>
                            <div class="col-sm-5">
                                <input name="INT_ID" class="form-control" required type="text" value="<?php echo $data->INT_ID; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No</label>
                            <div class="col-sm-4">
                                <select  name="CHR_PART_NO" id="e1" required class="form-control">
                                    <?php foreach ($data_part_no as $part_no) { ?>
                                        <?php if (trim($data->CHR_PART_NO) == trim($part_no->CHR_PART_NO)) { ?>
                                            <option value="<?php echo trim($part_no->CHR_PART_NO); ?>" SELECTED><?php echo trim($part_no->CHR_PART_NO); ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($part_no->CHR_PART_NO); ?>"><?php echo trim($part_no->CHR_PART_NO); ?></option>
                                        <?php } ?>
                                    <?php }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No Mate</label>
                            <div class="col-sm-4">
                                <select  name="CHR_PART_NO_MATE" id="e2" required class="form-control">
                                    <?php foreach ($data_part_no_mate as $part_no_mate) { ?>
                                        <?php if (trim($data->CHR_PART_NO_MATE) == trim($part_no_mate->CHR_PART_NO)) { ?>
                                            <option value="<?php echo trim($part_no_mate->CHR_PART_NO); ?>" SELECTED><?php echo trim($part_no_mate->CHR_PART_NO); ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($part_no_mate->CHR_PART_NO); ?>"><?php echo trim($part_no_mate->CHR_PART_NO); ?></option>
                                        <?php } ?>
                                    <?php }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                <select  name="CHR_WORK_CENTER" id="part_no_mate" required class="form-control">
                                    <?php foreach ($data_work_center as $work_center) { ?>
                                        <?php if (trim($data->CHR_WORK_CENTER) == trim($work_center->CHR_WORK_CENTER)) { ?>
                                            <option value="<?php echo trim($work_center->CHR_WORK_CENTER); ?>" SELECTED><?php echo trim($work_center->CHR_WORK_CENTER); ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($work_center->CHR_WORK_CENTER); ?>"><?php echo trim($work_center->CHR_WORK_CENTER); ?></option>
                                        <?php } ?>
                                    <?php }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('pes/cavity_c', 'Cancel', 'class="btn btn-default"');
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

