<script type="text/javascript">    
    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/mte/master_preventive_c/cancel_edit_drawing",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });

    $("#upload").fileinput({
        'showUpload': false
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
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>MANUAL</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open_multipart('mte/master_preventive_c/update_manual', 'class="form-horizontal"'); ?>

            <input name="ID_MANUAL" value="<?php echo $manual->INT_ID; ?> "class="form-control" type="hidden">
            <input name="GROUP_CODE" class="form-control" type="hidden" value="<?php echo $group_code; ?>">
            <input name="GROUP_LINE" class="form-control" type="hidden" value="<?php echo $group_line; ?>">
            
            <div class="form-group">
                <label class="col-sm-4 control-label">Group Type <span style="color:red;">*</span></label>
                <div class="col-sm-8">
                    <input name="MANUAL_GROUP" value="<?php echo $manual_type; ?> "class="form-control" readonly type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Manual Code <span style="color:red;">*</span></label>
                <div class="col-sm-8">
                    <input name="MANUAL_CODE" value="<?php echo $manual->CHR_WI_CODE; ?> "class="form-control" readonly type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Manual Type <span style="color:red;">*</span></label>
                <div class="col-sm-8">
                    <input name="MANUAL_TYPE" value="<?php echo trim($manual->CHR_WI_TYPE); ?> " autofocus class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Manual Name <span style="color:red;">*</span></label>
                <div class="col-sm-8">
                    <input name="MANUAL_NAME" value="<?php echo trim($manual->CHR_WI_NAME); ?> " autofocus class="form-control" required type="text">
                </div>
            </div>            
            <div class="form-group">
                <label class="col-sm-4 control-label">Common Manual</label>
                <div class="col-sm-8">
                    <?php 
                        $check1 = "";
                        $check2 = "";
                        $display = "";
                        if($manual->INT_ID_PART == NULL || $manual->INT_ID_PART == ""){
                            $check1 = "checked";
                            $check2 = "";
                            $display = "display:none;";
                        } else {
                            $check1 = "";
                            $check2 = "checked";
                            $display = "display:block;";
                        } 
                    ?>
                    <input name="opt_radio" style="vertical-align:middle;" type="radio" value="1" onclick="show_sparepart(1)" <?php echo $check1; ?>>&nbsp; <span style="vertical-align:middle;">Yes</span> &nbsp;
                    <input name="opt_radio" style="vertical-align:middle;" type="radio" value="0" onclick="show_sparepart(0)" <?php echo $check2; ?>>&nbsp; <span style="vertical-align:middle;">No</span>
                </div>
            </div>
            <div class="form-group" id="tool" style="<?php echo $display; ?>">
                <label class="col-sm-4 control-label">Part / Tooling Code</label>
                <div class="col-sm-8">
                    <select name="PART_CODE" id="e1" class="form-control">
                        <?php
                            foreach($list_part as $part){
                                if($manual->INT_ID_PART == $part->INT_ID){
                                    echo "<option value='". $part->INT_ID ."' selected>". $part->CHR_PART_CODE . " - " . $part->CHR_MODEL . " - " . $part->CHR_PART_NAME ."</>";
                                } else {
                                    echo "<option value='". $part->INT_ID ."'>". $part->CHR_PART_CODE . " - " . $part->CHR_MODEL . " - " . $part->CHR_PART_NAME ."</>";
                                }                                
                            } 
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Manual</label>
                <div class="col-sm-8">
                    <input name="MANUAL_IMG" id="upload" type="file"> 
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                        <?php echo anchor('mte/master_preventive_c/manage_manual', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
                </div>               
            </div>
            <?php echo form_close(); ?>
        </div>
    </div> 
</div>