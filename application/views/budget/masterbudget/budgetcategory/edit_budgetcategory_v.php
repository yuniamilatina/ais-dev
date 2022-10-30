<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budgetcategory_c/"') ?>">Manage Budget Category</a></li>            
            <li><a href="#"><strong>Edit Budget Category</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/budgetcategory_c/update_budgetcategory', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> BUDGET CATEGORY</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID_BUDGET_CATEGORY" class="form-control" required type="hidden" value="<?php echo $data->INT_ID_BUDGET_CATEGORY; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Category</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_CATEGORY" class="form-control" maxlength="7" required style="width: 80px;text-transform: uppercase;" type="text" value="<?php echo trim($data->CHR_BUDGET_CATEGORY); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Category Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_BUDGET_CATEGORY_DESC" class="form-control" maxlength="50" required type="text" value="<?php echo trim($data->CHR_BUDGET_CATEGORY_DESC); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Type</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_BUDGET_TYPE" id="source" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_budgettype as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"
                                        <?php
                                        if($data->INT_ID_BUDGET_TYPE == $isi->INT_ID_BUDGET_TYPE){
                                            echo ' selected';
                                        }
                                        ?>><?php echo $isi->CHR_BUDGET_TYPE . ' - ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>                        

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('budget/budgetcategory_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"'); 
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