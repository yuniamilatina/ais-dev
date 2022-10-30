
<script>
    $(function() {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/delivery/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/delivery/export/upload') ?>"><strong>Upload Packing List</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <form method="post" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-cube"></i>
                            <span class="grid-title"><strong>UPLOAD PACKING LIST</strong> </span>
                            <div class="pull-right grid-tools">
                                <?php if ($role == '9172') { //For NPK 
                                ?>
                                    <a data-toggle="modal" data-target="#modalFreePallet" class="btn btn-default" data-placement="left" title="Upload Free Pallet"><i class="fa fa-archive"></i> Upload Free Pallet</a>
                                <?php } ?>
                                <!-- <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a> -->
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Template Packing List</label>
                                <div class="col-sm-5" style="margin: 8px 0px 0px 0px;">
                                    <a href="<?php echo base_url("index.php/delivery/export_c/download") ?>">Download</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Delivery Date</label>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4">
                                        <input autocomplete="off" type="text" class="form-control date-picker" id="datepicker" name="delivery_date" value="<?php date("Y-m-d") ?>">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    </div>

                                </div>
                                <input type="hidden" id="dtp_input3" value="" />
                            </div>

                            <select id="source" class="form-control" style="width:500px;display: none;" >
                                <?php
                                $os = array();
                                foreach ($cust_data as $value_cust) {
                                    ?>
                                    <option value="<?php echo $value_cust->CHR_KODE_CUST ?>"><?php echo $value_cust->CHR_KODE_CUST . " : " . $value_cust->CHR_CUST_DESC ?></option>
                                    <?php
                                }
                                ?>
                                <
                            </select>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Kode Customer</label>
                                <div class="col-sm-5">
                                    <select id="e1" class="populate" style="width:500px" name="kode_cust"></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Upload File</label>
                                <div class="col-sm-5">
                                    <input type="file" name="upload_packing" id="import" size="20"  value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Area Print</label>
                                <div class="col-sm-5">
                                    <select name="area" class="form-control" style="width:300px">
                                        <option value="PPCFGO">PPC - Finish Good</option>
                                        <option value="ASHV01">ERP - Hybrid Damper</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary" name="btn-upload" value="1"><i class="fa fa-check"></i> Upload</button>
                                        <?php
                                        echo anchor('delivery/export_c/manage_packing', 'Cancel', 'class="btn btn-default"');
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