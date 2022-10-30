<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budgetsubcategory_c/') ?>">Manage Sub Category Budget</a></li>
            <li><a href="#"><strong>Create Sub Category Budget</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/budgetsubcategory_c/save_budgetsubcategory', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> SUB CATEGORY BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub Category Budget Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_SUB_CATEGORY" autofocus class="form-control" maxlength="7" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub Category Budget Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_SUB_CATEGORY_DESC" class="form-control" maxlength="50" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_BUDGET_CATEGORY" id="source" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_budgetcategory as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_CATEGORY . ' - ' . $isi->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category A3</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_BUDGET_CATEGORY_A3" id="source" class="form-control" style="width:400px">
                                    <option value="-">-</option>
                                    <?php
                                    foreach ($data_category_a3 as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_CATEGORY_A3; ?>"><?php echo $isi->CHR_CODE_CATEGORY_A3 . ' - ' . $isi->CHR_DESC_CATEGORY_A3; ?></option>
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
                                    <?php echo anchor('budget/budgetsubcategory_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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