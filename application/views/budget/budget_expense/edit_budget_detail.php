<script type="text/javascript">
    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/budget/fiscal_c/cancel_create",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });
</script>
<?php echo form_open("budget/budget_expense_c/edit_expense_detail/" . "/" . $isi->INT_NO_BUDGET_EXP . "/" . $isi->INT_REVISE . "/" . $isi->INT_MONTH_PLAN, 'class="form-horizontal"'); ?>
<div class="form-group">
    <p><h4>Edit Budget <strong>....</strong>  Detail </h4></p>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label">Month</label>
    <div class="col-sm-8">
        <select name="INT_MONTH_PLAN" required id="INT_MONTH_PLAN" class="form-control" style="width:250px">
            <option value="a"> -- Select Budget Category First -- </option>
        </select>
    </div>
</div>
<br><br>
<div class="form-group">
    <label class="col-sm-4 control-label">Quantity</label>
    <div class="col-sm-8">
        <input name="INT_QUANTITY" value="<?php ?>" id="INT_QUANTITY" class="form-control" style="width:250px" maxlength="50" required type="text">
    </div>
</div>
<br><br>
<div class="form-group">
    <div class="text-center">
        <div class="btn-group">
            <button type="submit" class="btn btn-warning"><i class="fa fa-check"></i> Update</button>
            <button id="btn_cancel" class="btn btn-default"> Cancel</button>
            <?php echo anchor('budget/fiscal_c', 'Cancel', 'class="btn btn-default"'); ?>
        </div>

    </div>
    <?php echo form_close(); ?>
</div>
