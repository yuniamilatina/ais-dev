<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budgetgroup_c/') ?>">Manage Budget Group</a></li>
            <li><a href="#"><strong>Create Budget Group</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/budgetgroup_c/save_budgetgroup', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> GROUP BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group Budget Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_GROUP" autofocus="true" class="form-control" maxlength="5" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group Budget Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_GROUP_DESC" class="form-control" maxlength="50" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('budget/budgetgroup_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"'); 
                                    echo form_close();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>