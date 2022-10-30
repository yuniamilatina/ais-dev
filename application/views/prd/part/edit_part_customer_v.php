
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/part/part_customer_c/manage_part_customer_wi') ?>">MANAGE PART CUSTOMER</a></li>
            <li> <a href="#"><strong>EDIT/REUPLOAD PART CUST. WI</strong></a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT/REUPLOAD PART CUST. WI</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('part/part_customer_c/upload_part_customer_wi', 'class="form-horizontal"');
                    ?>
                   
                   <div class="form-group">
                            <label class="col-sm-3 control-label">Cust No</label>
                            <div class="col-sm-2">
                                <select  name="CHR_CUST_NO" id="cust_no" onchange="get_data_part_cust();" class="form-control">
                                    <?php foreach ($data_cust_no as $row_cust_no) { 
                                        if (trim($cust_no) == trim($row_cust_no)){ ?>
                                        <option selected value="<?php echo $row_cust_no->CHR_CUS_NO; ?>"><?php echo trim($row_cust_no->CHR_CUS_NO); ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $row_cust_no->CHR_CUS_NO; ?>"><?php echo trim($row_cust_no->CHR_CUS_NO); ?></option>
                                    <?php }
                                    }
                                    ?> 
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Part No Cust.</label>
                            <div class="col-sm-6">
                                <select  name="CHR_CUS_PART_NO" class="e1" id="e1" required style="width:200px;">
                                    <?php foreach ($data_part_no_customer as $row) { 
                                        if(trim($cust_part_no) == trim($row->CHR_CUS_PART_NO)) { ?>
                                            <option selected value="<?php echo $row->CHR_CUS_PART_NO; ?>"><?php echo trim($row->CHR_CUS_PART_NO); ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $row->CHR_CUS_PART_NO; ?>"><?php echo trim($row->CHR_CUS_PART_NO); ?></option>
                                    <?php }
                                    }
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
                var cust_no = document.getElementById('cust_no').value;
        
                $.ajax({
                    async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('part/part_customer_c/get_data_part_no_cust'); ?>",
                    data:  {
                                CHR_CUS_NO: cust_no
                            },
                    success: function (json_data) {
                        $("#e1").html(json_data['data']);
                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });
            }
</script>

