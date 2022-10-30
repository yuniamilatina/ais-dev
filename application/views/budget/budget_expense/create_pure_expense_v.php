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
                data: {BUDGET_CATEGORY: $(this).val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_SUBCATEGORY").html(data);
                }
            });
        });
        $("#BUDGET_CATEGORY").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_budget_subcategory",
                data: {BUDGET_CATEGORY: $(this).val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_SUBCATEGORY").html(data);
                }
            });

        });
    });
</script> 
<div class="form-group"><hr></div>
<div class="form-group">


    <label class="col-sm-2 control-label">Budget Type</label>
    <div class="col-sm-3">
        <select name="BUDGET_TYPE" required id="BUDGET_TYPE" class="form-control" style="width:240px">
            <option value=""> -- Budget Type -- </option>
            <?php
            foreach ($type as $isi) {
                ?>
                <option value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' / ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                <?php
            }
            ?> 
        </select>

    </div>
    <label id="TEST" class="col-sm-2 control-label">Budget Category</label>
    <div class="col-sm-4">
        <select name="BUDGET_CATEGORY" id="BUDGET_CATEGORY" required class="form-control" style="width:250px">
            <option value=""> -- Select Budget Type First -- </option>
        </select>
    </div>
</div> 
<div class="form-group">
    <label id="TEST" class="col-sm-2 control-label">Budget Sub Category</label>
    <div class="col-sm-3">
        <select name="BUDGET_SUBCATEGORY" required id="BUDGET_SUBCATEGORY" class="form-control" style="width:240px">
            <option value=""> -- Select Budget Category First -- </option>
        </select>

    </div>
    



</div>
<div class="form-group">
    <div class="col-sm-12 text-center"><span style="color: crimson" >*</span>Input amount of money in the text boxes below (select Fiscal Year is Required).
    </div>
</div>


<div class="form-group" id="fiscal_month">

</div>

<hr>

<div class="form-group text-center">
    <div class="btn-group">
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
        <?php echo anchor('budget/budget_expense_c', 'Cancel', 'class="btn btn-default"'); ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/form.js') ?>"></script>
