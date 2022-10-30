
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/part/part_customer_c/manage_part_customer_wi') ?>">MANAGE PART CUSTOMER</a></li>
            <li> <a href="#"><strong>CREATE/UPLOAD PART CUST. WI</strong></a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE/UPLOAD PART CUST. WI</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                    <?php
                    echo form_open_multipart('part/part_customer_c/upload_part_customer_wi', 'class="form-horizontal"');
                    ?>
                   
                   <div class="form-group">
                        <label class="col-sm-3 control-label">Part No (Customer)</label>
                        <div class="col-sm-2">
                            <select  name="CHR_CUS_PART_NO" id="e1" onchange="get_data_part_cust();get_data_cust();" class="form-control" style="width:200px;">
                                <?php foreach ($data_part_cust_no as $row_cust_no) { 
                                    if (trim($part_no_customer) == trim($row_cust_no->CHR_CUS_PART_NO)){ ?>
                                    <option selected value="<?php echo $row_cust_no->CHR_CUS_PART_NO; ?>"><?php echo trim($row_cust_no->CHR_CUS_PART_NO); ?></option>
                                    <?php }else{ ?>
                                    <option value="<?php echo $row_cust_no->CHR_CUS_PART_NO; ?>"><?php echo trim($row_cust_no->CHR_CUS_PART_NO); ?></option>
                                <?php }
                                }
                                ?> 
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Part No (AII)</label>
                        <div class="col-sm-6" >
                            <select class="form-control" name="CHR_PART_NO" id="part_no_aisin"  required style="width:200px;">
                                <?php foreach ($data_part_no_aisin as $row) { ?>
                                    <option value="<?php echo $row->CHR_PART_NO; ?>"><?php echo trim($row->CHR_PART_NO); ?></option>
                                <?php }
                                ?> 
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Customer Name</label>
                        <div class="col-sm-6" >
                            <select class="form-control" name="CHR_CUS_NO" id="cus_no" required style="width:300px;">
                                <?php foreach ($data_cus_no as $row) { ?>
                                    <option value="<?php echo $row->CHR_CUS_NO; ?>"><?php echo trim($row->CHR_CUS_NAME); ?></option>
                                <?php }
                                ?> 
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Work Instruction</label>
                        <div class="col-sm-4">
                            <input name="CHR_IMG_FILE_NAME" id="upload" type="file" required> 
                        </div>
                    </div>

                    <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('part/part_customer_c/manage_part_customer_wi', 'Cancel', 'class="btn btn-default"');
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
    $("#upload").fileinput({
        'showUpload': false
    });

    function get_data_part_cust(){
        var e1 = document.getElementById('e1').value;
            $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('part/part_customer_c/get_data_part_no_aisin'); ?>",
            data:  { CHR_CUS_PART_NO: e1 },
            success: function (json_data) {
                $("#part_no_aisin").html(json_data['data']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }

    function get_data_cust(){
        var e1 = document.getElementById('e1').value;
            $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('part/part_customer_c/get_data_cust_no'); ?>",
            data:  { CHR_CUS_PART_NO: e1 },
            success: function (json_data) {
                $("#cus_no").html(json_data['data']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }
</script>

