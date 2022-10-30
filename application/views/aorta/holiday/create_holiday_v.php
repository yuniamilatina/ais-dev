<script type="text/javascript">
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });
    
    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/aorta/master_holiday_c/cancel_create",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });
</script>

<div id="3rd_panel" class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>HOLIDAY</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open('aorta/master_holiday_c/save_holiday', 'class="form-horizontal"'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Date</label>
            <div class="col-sm-8">
                <input name="DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="">
                <!--<i class="fa fa-calendar"></i>-->
                <!--<input name="DATE" autofocus class="form-control" minlength="8" maxlength="8" required type="text">-->
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <input name="DESCRIPTION" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="STATUS" class="form-control" style="width:130px">
                    <option value="1" selected>Hari Libur</option>
                    <option value="0">Hari Kerja</option>
                </select>
                <!--<input name="STATUS" class="form-control" maxlength="1" required>-->
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Type</label>
            <div class="col-sm-8">
                <select name="STATUS" class="form-control" style="width:130px">
                    <option value="1" selected>Weekend</option>
                    <option value="2">Hari Raya</option>
                </select>
<!--                <input name="TYPE" class="form-control" maxlength="1" required>-->
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    <a href="#"id="btn_cancel" class="btn btn-default"> Cancel</a>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>