<script type="text/javascript">
    $(document).ready(function() {

        $("#BUDGET_TYPE").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_budget_category_subexpense",
                data: {BUDGET_TYPE: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_CATEGORY").html(data);
                }
            });
        });
        $("#BUDGET_TYPE").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_budget_category_subexpense",
                data: {BUDGET_TYPE: $(this).val()}, type: "POST",
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
            
            <?php
            if ($type != NULL) {
                foreach ($type as $isi) {
                    ?>
                    <option value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' / ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                <?php
                }
            }else{
                echo '<option value="">!! This Department has no previlledge on this Budget Type !!</option>';
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
    <label id="TEST" class="col-sm-2 control-label">Budget Subcategory</label>
    <div class="col-sm-3">
        <select name="BUDGET_SUBCATEGORY" id="BUDGET_SUBCATEGORY" required class="form-control" style="width:240px">
            <option value=""> -- Select Budget Category First -- </option>
        </select>
    </div>




</div>
<div class="form-group">
    <label class="col-sm-2 control-label">UOM</label>
    <div class="col-sm-3">  
        <select name="UOM" id="UOM" required class="form-control" style="width:240px">
            <?php
            foreach ($unit as $isi) {
                ?>
                <option value="<?php echo $isi->INT_ID_UNIT; ?>"><?php echo $isi->CHR_UNIT . ' / ' . $isi->CHR_UNIT_DESC; ?></option>
                <?php
            }
            ?> 
        </select>
    </div>
    <label class="col-sm-2 control-label">Price Per Unit</label>
    <div class="col-sm-3">
        <input name="PRICE_PER_UNIT" autocomplete="off" id="PRICE_PER_UNIT" class="form-control" style="width:250px" maxlength="20" required type="number">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12 text-center"><span style="color: crimson" >*</span>Input quantities in the text boxes below (select Fiscal Year is Required).
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
