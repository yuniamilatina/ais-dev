
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/target_production_c/'); ?>"><span>Manage Target Production</span></a></li>
            <li><a href=""><strong>Edit Target Production</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('pes/target_production_c/update_target_production', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>EDIT TARGET PRODUCTION</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID" class="form-control" required type="hidden" value="<?php echo $data->INT_ID; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Σ CT(s)</label>
                            <div class="col-sm-3">
                                <input name="INT_CT" class="form-control" value="<?php echo trim($data->INT_CT) ?>"  required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plan MP</label>
                            <div class="col-sm-3">
                                <input name="INT_PLAN_MP1" class="form-control" value="<?php echo trim($data->INT_PLAN_MP1) ?>"  required type="text">
                            </div>
                        </div>
                                  <div class="form-group">
                            <label class="col-sm-3 control-label">Target Delivery</label>
                            <div class="col-sm-3">
                                <input name="INT_TARGET_DEL" class="form-control" value="<?php echo trim($data->INT_TARGET_DEL) ?>"  required type="text">
                            </div>
                        </div>
                                  <div class="form-group">
                            <label class="col-sm-3 control-label">Plan Shift</label>
                            <div class="col-sm-3">
                                <input name="INT_PLAN_SHIFT" class="form-control" value="<?php echo trim($data->INT_PLAN_SHIFT) ?>"  required type="text">
                            </div>
                        </div>
                                  <div class="form-group">
                            <label class="col-sm-3 control-label">Qty/Jam (GEDS)</label>
                            <div class="col-sm-3">
                                <input name="INT_QTY_PER_JAM_GEDS" class="form-control" value="<?php echo trim($data->INT_QTY_PER_JAM_GEDS) ?>"  required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah MP</label>
                            <div class="col-sm-3">
                                <input name="INT_PLAN_MP2" class="form-control" value="<?php echo trim($data->INT_PLAN_MP2) ?>"  required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('pes/target_production_c', 'Cancel', 'class="btn btn-default"');
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