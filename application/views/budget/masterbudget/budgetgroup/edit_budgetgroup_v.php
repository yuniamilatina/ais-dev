<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budgetgroup_c/') ?>">Manage Budget Group</a></li>            
            <li><strong>Edit Budget Group</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
        echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >'; }
        echo form_open('budget/budgetgroup_c/update_budgetgroup', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> BUDGET GROUP</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <input name="INT_ID_BUDGET_GROUP" class="form-control" required type="hidden" value="<?php echo $data->INT_ID_BUDGET_GROUP; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Group Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_GROUP" class="form-control" maxlength="5" required type="text" style="width: 80px" value="<?php echo trim($data->CHR_BUDGET_GROUP); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Group Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_GROUP_DESC" class="form-control" maxlength="30" required type="text" value="<?php echo trim($data->CHR_BUDGET_GROUP_DESC); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><span class="fa fa-refresh"></span> Update</button>
                                    <?php echo anchor('budget/budgetgroup_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
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