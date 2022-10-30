<script language="JavaScript">
    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "" + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = Number(c);
    }

    function Number(s) {

        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/eng/master_model_twist_c/') ?>">Master Model Twist</a></li>
            <li> <a href="#"><strong>Create Master Model Twist</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('eng/master_model_twist_c/save_master_model_twist', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE MODEL TWIST</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                <select name="CHR_WORK_CENTER" id="e1" onchange="get_part_by_work_center()" style='width:160px;' class="form-control">
                                    <?php foreach ($all_work_centers as $row) { ?>
                                        <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Number</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="CHR_PART_NO" id="part_no_aisin"  required style="width:200px;">
                                    <?php foreach ($part_no_aisin as $row) { ?>
                                        <option value="<?php echo $row->CHR_PART_NO; ?>"><?php echo trim($row->CHR_PART_NO); ?></option>
                                    <?php }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Master Model Program</label>
                            <div class="col-sm-2">
                                <input name="CHR_MODEL" autocomplete="off" class="form-control" maxlength="5" required onkeyup="angka(this);"  type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Marking Product</label>
                            <div class="col-sm-2">
                                <input name="CHR_MARKING" autocomplete="off" class="form-control" maxlength="7" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Master Model Description</label>
                            <div class="col-sm-3">
                                <input name="CHR_MODEL_DESCRIPTION" autocomplete="off" class="form-control" maxlength="20" required type="text">
                            </div>
                        </div>
                           <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('eng/master_model_twist_c', 'Cancel', 'class="btn btn-default"'); 
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

<script type="text/javascript" language="javascript">

    function get_part_by_work_center(){
        var work_center = document.getElementById('e1').value;
            $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('part/process_part_c/get_part_by_work_center'); ?>",
            data:  { CHR_WORK_CENTER: work_center },
            success: function (json_data) {
                $("#part_no_aisin").html(json_data);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }
    
</script>