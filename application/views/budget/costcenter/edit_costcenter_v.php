<aside class="right-side">
    <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
                <li><a href="<?php echo base_url('index.php/budget/costcenter_c/') ?>">Manage Cost Center</a></li>
                <li><a href="#"><strong>Edit Cost Center</strong></a></li>
            </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/costcenter_c/update_costcenter', 'class="form-horizontal"');
        ?> 

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> COST CENTER</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <input name="INT_ID_COST_CENTER" class="form-control" type="hidden"  value="<?php echo $data->INT_ID_COST_CENTER; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cost Center</label>
                            <div class="col-sm-5">
                                <input name="CHR_COST_CENTER" class="form-control" maxlength="6" required type="text" style="width: 80px;text-transform: uppercase;" value="<?php echo trim($data->CHR_COST_CENTER); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cost Center Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_COST_CENTER_DESC" class="form-control" required type="text" value="<?php echo trim($data->CHR_COST_CENTER_DESC); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php echo anchor('budget/costcenter_c', 'Cancel', 'class="btn btn-default"');
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
