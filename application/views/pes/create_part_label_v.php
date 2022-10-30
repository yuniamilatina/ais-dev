
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
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }

</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/pos_c') ?>">MANAGE POS</a></li>
            <li> <a href="#"><strong>CREATE POS</strong></a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE PART LABEL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('pes/part_label_c/save_part_label', 'class="form-horizontal"');
                    ?>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Work Center</label>
                        <div class="col-sm-2">
                            <select id="work_center" name="work_center" readonly class="form-control" onchange="get_data_part();">
                                    <?php
                                    foreach ($all_work_centers as $row) {
                                        if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                            ?>
                                            <option selected value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Part No</label>
                        <div class="col-sm-6" >
                            <select class="form-control" name="part_no" id="part_no_option" required style="width:200px;">
                                <?php 
                                foreach ($data_part_no as $row) {
                                    if (trim($row->CHR_PART_NO) == trim($part_no)) {
                                        ?>
                                        <option selected value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO); ?> </option>
                                    <?php } else { ?>
                                        <option value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO); ?> </option>
                                        <?php
                                    }
                                }
                                ?> 
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Qty</label>
                        <div class="col-sm-1" >
                            <input type="text" autocomplete="off" onkeyup="angka(this);" maxlength="3" required name="qty" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Weight Box</label>
                        <div class="col-sm-1" >
                            <input type="number" autocomplete="off"  maxlength="3" required name="weight_dus" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Weight Product</label>
                        <div class="col-sm-1" >
                            <input type="number" autocomplete="off"  maxlength="3" required name="weight_per_product" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Weight Total</label>
                        <div class="col-sm-1" >
                            <input type="number" autocomplete="off"  maxlength="3" required name="weight_total" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cust Part No</label>
                        <div class="col-sm-3" >
                            <input type="text" autocomplete="off" required name="cust_part_no" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cust Back No</label>
                        <div class="col-sm-3" >
                            <input type="text" autocomplete="off" required name="cust_back_no" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Item Name</label>
                        <div class="col-sm-5" >
                            <input type="text" autocomplete="off" required name="item_name" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Prod Marking</label>
                        <div class="col-sm-2" >
                            <input type="text" autocomplete="off" name="prod_marking" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Item Head</label>
                        <div class="col-sm-2" >
                            <input type="text" autocomplete="off" name="item_head" required class="form-control">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Box Type</label>
                        <div class="col-sm-2" >
                            <input type="text" autocomplete="off" name="box_type" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Customer</label>
                        <div class="col-sm-4" >
                            <input type="text" autocomplete="off" name="customer" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                <?php
                                echo anchor('pes/part_label_c/index/'.$work_center, 'Cancel', 'class="btn btn-default"');
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

    function get_data_part(){
        var work_center = document.getElementById('work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('part/part_c/get_data_part_by_work_center'); ?>",
            data:  {
                    CHR_WCENTER: work_center
                    },
            success: function (json_data) {
                $("#part_no_option").html(json_data['data']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }

</script>