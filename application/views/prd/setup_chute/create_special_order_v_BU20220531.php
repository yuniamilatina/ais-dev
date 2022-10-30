
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/part/setup_chute_c/index') ?>">MANAGE SETUP CHUTE</a></li>
            <li> <a href="#"><strong>CREATE SPECIAL ORDER</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE SPECIAL ORDER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                        echo form_open_multipart('prd/setup_chute_c/save_special_order', 'class="form-horizontal"');
                    ?>
                        
                    <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center); ?>">
                    <input name="INT_ID_DEPT" class="form-control" id='dept_id' required type="hidden" style="width: 300px;" value="<?php echo $id_dept; ?>">
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sequence</label>
                        <div class="col-sm-4">
                            <input class="form-control" name="INT_SEQUENCE" id="int_seq" type="number" min="<?php if($max_seq >= 7){ echo '7'; } else { echo $max_seq+1; } ?>" max="<?php echo $max_seq+1; ?>" required style="width:70px;" value="7"> 
                        </div>
                    </div>
                        
                    <div style="display:none;" class="form-group">
                        <label class="col-sm-3 control-label">Department</label>
                        <div class="col-sm-2">
                            <select class="ddl" style="background-color: whitesmoke;" onChange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                <?php foreach ($all_dept_prod as $row) { ?>
                                    <option value="<?php echo trim($row->INT_ID_DEPT); ?>"  <?php
                                if ($id_dept == trim($row->INT_ID_DEPT)) {
                                    echo 'selected';
                                }
                                    ?> > <?php echo trim($row->CHR_DEPT); ?> </option>
                                        <?php } ?>
                            </select>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Work Center</label>
                        <div class="col-sm-2">
                            <select class="ddl" style="background-color: whitesmoke;" onChange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                <?php foreach ($all_work_centers as $row) { ?>
                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>"  <?php
                                if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                    echo 'selected';
                                }
                                    ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                        <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Part No</label>
                        <div class="col-sm-6" >
                            <select class="form-control" name="CHR_PART_NO" id="e1" required style="width:160px;" onchange="getPartName(value);checkCavity(value);">
                                <?php foreach ($all_part_no as $row) { ?>
                                    <option value="<?php echo $row->CHR_PART_NO; ?>"><?php echo trim($row->CHR_PART_NO); ?></option>
                                <?php }
                                ?> 
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Back No - Part Name</label>
                        <div class="col-sm-2">
                            <input name="CHR_PART_NAME" readonly id="part_name" class='form-control' type="text" style="width: 300px;">
                        </div>
                    </div>

                    <div class="form-group" id="div_cav" style="display:none;">
                        <label class="col-sm-3 control-label">Back No - Part Name (Cavity)</label>
                        <div class="col-sm-2">
                            <input name="CHR_PART_NAME_CAV" readonly id="part_name_cav" class='form-control' type="text" style="width: 300px;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Lot Size</label>
                        <div class="col-sm-4">
                            <input class="form-control" min="1" name="INT_LOT_SIZE" id="lot_size" type="number" onchange="calculateQty()" required style="width:90px;"> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Qty per Box</label>
                        <div class="col-sm-4">
                            <input class="form-control" min="1" name="INT_QTY_PER_BOX" id="int_qty_box" type="number" onchange="calculateQty()" required style="width:90px;"> 
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Total Qty Pcs</label>
                        <div class="col-sm-4">
                            <input class="form-control" min="1" name="INT_QTY_PCS" id="int_qty_pcs" type="number" disabled style="width:90px; background-color: whitesmoke;"> 
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <div class="btn-group">
                                <button id="btnPrepareSubmit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                <button type="submit" style="display:none;" id="btnTrueSubmit"> True Save</button>
                                <?php
                                echo anchor('prd/setup_chute_c/search_setup_chute/0/' . $id_dept . '/' . $work_center, 'Cancel', 'class="btn btn-default"');
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

<script type="text/javascript" src="<?php echo base_url() ?>assets/mqtt/mqttws31.min.js"></script>

<script type="text/javascript" language="javascript">

    //add by toro
    $("#btnPrepareSubmit").on('click', function (event) {
        event.preventDefault();
        var el = $(this);
        $("#btnTrueSubmit").click();
        el.prop('disabled', true);

        client = new Paho.MQTT.Client("192.168.0.234", 9001, 'setup_chute');
        client.connect({onSuccess: onConnect});
    });

    $("#upload").fileinput({
        'showUpload': false
    });

    function onConnect() {
        var wc = document.getElementById('work_center_id').value;
        message = new Paho.MQTT.Message(wc);

        var pos1 = 1;
        message.destinationName = 'SETUPCHUTE/'+wc+'/'+pos1;
        client.send(message);

        var pos2 = 2;
        message.destinationName = 'SETUPCHUTE/'+wc+'/'+pos2;
        client.send(message);

        var pos3 = 3;
        message.destinationName = 'SETUPCHUTE/'+wc+'/'+pos3;
        client.send(message);

        var pos4 = 4;
        message.destinationName = 'SETUPCHUTE/'+wc+'/'+pos4;
        client.send(message);

        var pos5 = 5;
        message.destinationName = 'SETUPCHUTE/'+wc+'/'+pos5;
        client.send(message);

        var pos6 = 6;
        message.destinationName = 'SETUPCHUTE/'+wc+'/'+pos6;
        client.send(message);

    }

    function calculateQty(){
        var lot_size = document.getElementById('lot_size').value;
        var qty_per_box = document.getElementById('int_qty_box').value;
        
        var tot_qty = lot_size * qty_per_box;
        $("#int_qty_pcs").val(tot_qty);               
    }

    function getPartName(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/setup_chute_c/get_part_name'); ?>",
            data: "part_no=" + value,
            success: function(data) {
                $("#part_name").val(data);
            }
        });
    }

    function checkCavity(part) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/setup_chute_c/check_cavity'); ?>",
            data: "partno=" + part,
            success: function(data) {
                // alert(data);
                if(data.trim() == ''){
                    document.getElementById('div_cav').style.display = 'none';
                } else {
                    $("#part_name_cav").val(data);
                    document.getElementById('div_cav').style.display = 'block';
                }                
            }
        });
    }
</script>

