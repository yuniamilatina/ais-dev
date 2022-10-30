    <aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/eng/master_model_twist_c/') ?>">Manage Master Model Twist</a></li>
            <li><a href="#"><strong>Edit Model Twist</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('eng/master_model_twist_c/update_master_model_twist', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> MODEL TWIST</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                         <div class="form-group">
                            <label class="col-sm-3 control-label">NO</label>
                            <div class="col-sm-2">
                                <input name="INT_ID" class="form-control" readonly maxlength="5" required type="text" value="<?php echo trim($data->INT_ID); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                <input name="CHR_WORK_CENTER" autocomplete="off" class="form-control" maxlength="5" required type="text" value="<?php echo trim($data->CHR_WORK_CENTER); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Master Model Program</label>
                            <div class="col-sm-2">
                                <input name="CHR_MODEL" autocomplete="off" class="form-control" maxlength="5" required type="number" value="<?php echo trim($data->CHR_MODEL); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Marking Product</label>
                            <div class="col-sm-2">
                                <input name="CHR_MARKING" autocomplete="off" class="form-control" maxlength="10" required type="text" value="<?php echo trim($data->CHR_MARKING); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Number</label>
                            <div class="col-sm-3">
                                <input name="CHR_PART_NO" autocomplete="off" class="form-control" maxlength="11" required type="text" value="<?php echo trim($data->CHR_PART_NO); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Master Model Description</label>
                            <div class="col-sm-3">
                                <input name="CHR_MODEL_DESCRIPTION" autocomplete="off" class="form-control" maxlength="20" required type="text" value="<?php echo trim($data->CHR_MODEL_DESCRIPTION); ?>">
                            </div>
                        </div>
                          
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('eng/master_model_twist_c', 'Cancel', 'class="btn btn-default"');
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