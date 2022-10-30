<script type="text/javascript">
    $(document).ready(function() {
        $("#BUDGET_TYPE").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_budget_category",
                data: {BUDGET_TYPE: $(this).val(),
                    INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_CATEGORY").html(data);
                }
            });
        });
        $("#BUDGET_TYPE").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_budget_category",
                data: {BUDGET_TYPE: $(this).val(),
                    INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_CATEGORY").html(data);
                }
            });
        });

        $("#BUDGET_CATEGORY").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_budget_subcategory",
                data: {BUDGET_CATEGORY: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_SUBCATEGORY").html(data);
                }
            });
        });
        $("#BUDGET_CATEGORY").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_budget_subcategory",
                data: {BUDGET_CATEGORY: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_SUBCATEGORY").html(data);
                }
            });

        });
    });
</script>
<aside class="right-side">
    <!-- BEGIN CONTENT HEADER -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>">Manage Budget Expense</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/edit_expense/' . $data->INT_NO_BUDGET_EXP . '"') ?>"><strong>Edit Budget Expense</strong></a></li>
        </ol>
    </section>
    <!-- END CONTENT HEADER -->

    <!-- BEGIN MAIN CONTENT -->
    <section class="content">

        <div class="row">
            <!-- BEGIN BASIC ELEMENTS -->

            <div class="grid">
                <div class="grid-header">
                    <i class="fa fa-certificate"></i>
                    <span class="grid-title">EDIT BUDGET <strong>EXPENSE</strong></span>
                    <div class="pull-right grid-tools">
                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="grid-body">
                    <?php echo form_open('budget/budget_expense_c/update_budget_expense/e/'.$data->INT_REVISE, 'class="form-horizontal"'); ?>


                    <div class="form-group">
                        <div hidden class="col-sm-3">
                            <input disabled="disabled" name="INT_ID_DEPT" value="<?php echo $data->INT_ID_DEPT ?>" id="INT_ID_DEPT" class="form-control" style="width:250px" maxlength="50" required type="text">
                        </div>
                        <div disabled="disabled" hidden class="col-sm-3">
                            <input name="INT_NO_BUDGET_EXP"  value="<?php echo $data->INT_NO_BUDGET_EXP ?>" id="INT_NO_BUDGET_EXP" class="form-control" style="width:250px" maxlength="50" required type="text">
                        </div>
                        <label class="col-sm-2 control-label">Budget Planning Name</label>
                        <div class="col-sm-3">
                            <input name="CHR_BUDGET_NAME" value="<?php echo trim($data->CHR_BUDGET_NAME) ?>" id="CHR_BUDGET_NAME" class="form-control" style="width:250px" maxlength="50" required type="text">
                        </div>
                        <label class="col-sm-2 control-label">Budget Allocation</label>
                        <div class="col-sm-3">
                            <select name="BUDGET_ALLOCATION" id="BUDGET_ALLOCATION" class="form-control" required style="width:250px">
                                <?php
                                $x = $data->INT_ALLOCATE;
                                for ($i = 1; $i < 4; $i++) {
                                    $val[$i] = "";
                                    if ($i == $x) {
                                        $val[$i] = "selected";
                                    }
                                }
                                ?>
                                <option <?php echo $val[1] ?> value="1">Regular (Preventive)</option>
                                <option <?php echo $val[2] ?> value="2">Irregular</option>
                                <option <?php echo $val[3] ?> value="3">New Project</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Budget Type</label>
                        <div class="col-sm-3">
                            <select autofocus name="BUDGET_TYPE" required id="BUDGET_TYPE" class="form-control" style="width:250px">

                                <?php
                                foreach ($type as $isi) {
                                    if ($data->INT_ID_BUDGET_TYPE == $isi->INT_ID_BUDGET_TYPE) {
                                        ?>
                                        <option selected value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' / ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' / ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                                        <?php
                                    }
                                }
                                ?> 
                            </select>

                        </div>
                        <label id="TEST" class="col-sm-2 control-label">Budget Category</label>
                        <div class="col-sm-4">
                            <select name="BUDGET_CATEGORY" id="BUDGET_CATEGORY" required class="form-control" style="width:250px">
                                <option value=""> -- Select Budget Subtype First -- </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="TEST" class="col-sm-2 control-label">Budget Sub Category</label>
                        <div class="col-sm-3">
                            <select name="BUDGET_SUBCATEGORY" required id="BUDGET_SUBCATEGORY" class="form-control" style="width:250px">
                                <option value=""> -- Select Budget Category First -- </option>
                            </select>

                        </div>
                    </div>
                    <hr>

                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                            <?php echo anchor('budget/budget_expense_c', 'Cancel', 'class="btn btn-default"'); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>


                </div>

                <!-- END BASIC ELEMENTS -->
            </div>


    </section>
    <!-- END MAIN CONTENT -->
</aside>