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
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>CHECKSHEET</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open('mte/master_preventive_c/update_checksheet', 'class="form-horizontal"'); ?>

            <input name="ID_CHECKSHEET" value="<?php echo $checksheet->INT_ID; ?> "class="form-control" type="hidden">
            <input name="GROUP_CODE" class="form-control" type="hidden" value="<?php echo $group_code; ?>">
            <input name="GROUP_LINE" class="form-control" type="hidden" value="<?php echo $group_line; ?>">
            
            <div class="form-group">
                <label class="col-sm-4 control-label">Checksheet Code <span style="color:red;">*</span></label>
                <div class="col-sm-8">
                    <input name="CHECKSHEET_CODE" value="<?php echo $checksheet->CHR_CHECKSHEET_CODE; ?> "class="form-control" readonly type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Checksheet Name <span style="color:red;">*</span></label>
                <div class="col-sm-8">
                    <input name="CHECKSHEET_NAME" value="<?php echo trim($checksheet->CHR_CHECKSHEET_NAME); ?> " autofocus class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Common Checksheet</label>
                <div class="col-sm-8">
                    <?php 
                        $check1 = "";
                        $check2 = "";
                        $display = "";
                        if($checksheet->INT_ID_PART == NULL || $checksheet->INT_ID_PART == ""){
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
                                if($checksheet->INT_ID_PART == $part->INT_ID){
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
                <div class="text-center">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                        <?php echo anchor('mte/master_preventive_c', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
               
            </div>
            <?php echo form_close(); ?>
        </div>
    </div> 
</div>