<script type="text/javascript">
    
    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/mte/master_preventive_c/cancel_create",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });

    function show_sparepart(opt_val){
        //  var opt_val =  document.getElementById("opt_radio").value;
        if(opt_val == 1){
            document.getElementById("tool").style.display = "none"; 
        } else {
            document.getElementById("tool").style.display = "block"; 
        }
    }

</script>

<div id="3rd_panel" class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>MANUAL</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open_multipart('mte/master_preventive_c/save_manual', 'class="form-horizontal"'); ?>

        <input name="GROUP_CODE" class="form-control" type="hidden" value="<?php echo $group_code; ?>">
        <input name="GROUP_LINE" class="form-control" type="hidden" value="<?php echo $group_line; ?>">
        <div class="form-group">
            <label class="col-sm-4 control-label">Group Type</label>
            <div class="col-sm-8">
                <select name="MANUAL_GROUP" class="ddl2">
                    <option value="WIS" selected>WIS</option>
                    <option value="FTA">FTA</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Manual Type <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <input name="MANUAL_TYPE" autofocus class="form-control" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Manual Name <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <input name="MANUAL_NAME" autofocus class="form-control" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Common Manual</label>
            <div class="col-sm-8">
                <input name="opt_radio" style="vertical-align:middle;" type="radio" value="1" onclick="show_sparepart(1)" checked>&nbsp; <span style="vertical-align:middle;">Yes</span> &nbsp;
                <input name="opt_radio" style="vertical-align:middle;" type="radio" value="0" onclick="show_sparepart(0)">&nbsp; <span style="vertical-align:middle;">No</span>
            </div>
        </div>
        <div class="form-group" id="tool" style="display:none;">
            <label class="col-sm-4 control-label">Part / Tooling Code</label>
            <div class="col-sm-8">
                <select name="PART_CODE" id="e1" class="form-control">
                    <?php
                        foreach($list_part as $part){
                            echo "<option value='". $part->INT_ID ."'>". $part->CHR_PART_CODE . " - " . $part->CHR_MODEL . " - " . $part->CHR_PART_NAME ."</>";
                        } 
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Manual <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <input name="MANUAL_IMG" id="upload" type="file" required> 
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