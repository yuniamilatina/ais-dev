<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/purposebudget_c/') ?>">Manage Purpose budget</a></li>            
            <li><a href="#"><strong>Edit Purpose budget</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/purposebudget_c/update_purposebudget', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> PURPOSE BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID_PURPOSE" class="form-control" required type="hidden" value="<?php echo trim($data->INT_ID_PURPOSE); ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Purpose budget</label>
                            <div class="col-sm-5">
                                <input name="CHR_PURPOSE" class="form-control" maxlength="5" style="width: 80px;text-transform: uppercase;" required type="text" value="<?php echo trim($data->CHR_PURPOSE); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Purpose budget Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_PURPOSE_DESC" class="form-control" maxlength="30" required type="text" value="<?php echo trim($data->CHR_PURPOSE_DESC); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php echo anchor('budget/purposebudget_c', 'Cancel', 'class="btn btn-default"'); 
                                    echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>