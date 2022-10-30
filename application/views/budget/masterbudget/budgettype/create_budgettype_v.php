<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/budget/budgettype_c//"') ?>">Manage Subgroup Budget</a></li>
            <li> <a href="#"><strong>Create Subgroup Budget</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/budgettype_c/save_budgettype', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> SUBGROUP BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Type Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_TYPE" autofocus="true" class="form-control" maxlength="5" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Type Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_TYPE_DESC" class="form-control" maxlength="50" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Subgroup</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_BUDGET_SUBGROUP" id="source" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_budgetsubgroup as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_SUBGROUP; ?>"><?php echo $isi->CHR_BUDGET_SUBGROUP . ' - ' . $isi->CHR_BUDGET_SUBGROUP_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('budget/budgettype_c/', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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