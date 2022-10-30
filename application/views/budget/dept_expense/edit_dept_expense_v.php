<div class="grid"><div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">EDIT <strong>DEPT EXPENSE</strong></span>

    </div>
    <div class="grid-body">
        <?php echo form_open('budget/dept_expense_c/update_dept_expense', 'class="form-horizontal"'); ?>
        <div hidden class="form-group">
            <label class="col-sm-4 control-label">Department ID</label>
            <div class="col-sm-8">
                <input name="INT_ID_DEPT" value="<?php echo $data_detail->INT_ID_DEPT; ?>" class="form-control" maxlength="7" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Department</label>
               
                <div class="col-sm-8">
                    <input value="<?php echo trim($data_detail->CHR_DEPT) . ' / ' . $data_detail->CHR_DEPT_DESC; ?>" class="form-control" disabled="disabled" type="text">
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-4 control-label">Category on Pure Expenses</label>
            <div class="col-sm-8">
                <select name="INT_ID_BUDGET[]" multiple id="e2" class="form-control" style="width:300px">
                    <?php
                    $x = null;
                    foreach ($pure_expense as $a) {
                        echo '<optgroup label="' . $a->CHR_BUDGET_TYPE . ' / ' . $a->CHR_BUDGET_TYPE_DESC . '">';
                        foreach ($pure_expense_sub as $b) {
                            if ($a->INT_ID_BUDGET_TYPE == $b->INT_ID_BUDGET_TYPE) {
                                foreach ($dept_expense as $c) {
                                    if ($c->INT_ID_BUDGET_CATEGORY == $b->INT_ID_BUDGET_CATEGORY) {
                                        ?>
                                        <option selected value="<?php echo $b->INT_ID_BUDGET_CATEGORY; ?>"><?php echo $b->CHR_BUDGET_CATEGORY.' / '.$b->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                        <?php
                                        $x = $b->INT_ID_BUDGET_CATEGORY;
                                    }
                                }
                                if ($x != $b->INT_ID_BUDGET_CATEGORY) {
                                    ?>
                                    <option value="<?php echo $b->INT_ID_BUDGET_CATEGORY; ?>"><?php echo $b->CHR_BUDGET_CATEGORY.' / '.$b->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                    <?php
                                }
                            }
                        }
                        echo '</optgroup>';
                    }
                    ?> 
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Type on Sub Expenses</label>
            <div class="col-sm-8">
                <select name="INT_ID_BUDGET2[]" multiple id="e1" class="form-control" style="width:300px">
                    <?php
                    $x = null;
                    foreach ($subexpense as $a) {
                        echo '<optgroup label="' . $a->CHR_BUDGET_SUBGROUP . ' / ' . $a->CHR_BUDGET_SUBGROUP_DESC . '">';
                        foreach ($subexpense_sub as $b) {
                            if ($a->INT_ID_BUDGET_SUBGROUP == $b->INT_ID_BUDGET_SUBGROUP) {
                                foreach ($dept_subexpense as $c) {
                                    if ($c->INT_ID_BUDGET_TYPE== $b->INT_ID_BUDGET_TYPE) {
                                        ?>
                                        <option selected value="<?php echo $b->INT_ID_BUDGET_TYPE; ?>"><?php echo $b->CHR_BUDGET_TYPE.' / '.$b->CHR_BUDGET_TYPE_DESC; ?></option>
                                        <?php
                                        $x = $b->INT_ID_BUDGET_TYPE;
                                    }
                                }
                                if ($x != $b->INT_ID_BUDGET_TYPE) {
                                    ?>
                                    <option value="<?php echo $b->INT_ID_BUDGET_TYPE; ?>"><?php echo $b->CHR_BUDGET_TYPE.' / '.$b->CHR_BUDGET_TYPE_DESC; ?></option>
                                    <?php
                                }
                            }
                        }
                        echo '</optgroup>';
                    }
                    ?> 
                </select>
            </div>
        </div>
        
        

        <div class="form-group text-center">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    <?php echo anchor('budget/dept_expense_c', 'Cancel', 'class="btn btn-default"'); ?>
              
            </div>
        </div>
        <?php 
        echo form_close(); ?>
    </div></div>