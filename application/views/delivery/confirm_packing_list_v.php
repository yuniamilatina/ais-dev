<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'dd-mm-yy'
        }).val();
    });
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/delivery/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/delivery/export/upload') ?>">Confirm Packing List</a></li>
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
                            <i class="fa fa-university"></i>
                            <span class="grid-title"><strong>Confirm</strong> Packing List</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Packing ID</label>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time">
                                        <input type="text" class="form-control" name="id" value="<?php echo $packing_id ?>" disabled>
                                    </div>
                                </div>
                                <input type="hidden" id="dtp_input3" value="" />
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Delivery Date</label>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4">
                                        <input type="text" class="form-control date-picker" name="delivery_date" value="<?php echo date("d M Y", strtotime($delivery_date)); ?>" disabled>
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    </div>
                                </div>
                                <input type="hidden" id="dtp_input3" value="" />
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Kode Customer</label>
                                <div class="col-sm-3">
                                    <input type="text" name="kode_cust" id="kode_cust" size="20" value="<?php echo $cust_kode; ?>" disabled>
                                </div>
                                <div class="col-sm-8" style="margin-top:10px;">

                                    <input type="text" name="kode_cust" id="kode_cust" size="50" value="<?php echo $cust_name; ?>" disabled>
                                </div>
                            </div>

                            <div class="grid-body">
                                <?php if ($cek_upload_total != $cek_upload_ok) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Error!</strong> Periksa kembali template Anda.
                                    </div>
                                <?php } ?>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <div class="btn-group">
                                        <?php if ($cek_upload_total == $cek_upload_ok) { ?>
                                            <button type="submit" class="btn btn-primary" name="btn-confirm" value="1" onclick="$(this).hide();"><i class="fa fa-check"></i> Save</button>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-primary" name="btn-upload" value="1" disabled><i class="fa fa-check"></i> Save</button>
                                        <?php } ?>
                                        <?php
                                        echo anchor('organization/company_c', 'Cancel', 'class="btn btn-default"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- BEGIN RESPONSIVE TABLE -->
                <div class="col-md-12">
                    <div class="grid no-border">
                        <div class="grid-header">
                            <i class="fa fa-table"></i>
                            <span class="grid-title">Upload Data</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">#</th>
                                            <th style="text-align:center;">Part No</th>
                                            <th style="text-align:center;">Part No Cust</th>
                                            <th style="text-align:center;">Back No</th>
                                            <th style="text-align:center;">Sloc From</th>
                                            <th style="text-align:center;">Qty</th>
                                            <th style="text-align:center;">No Pallet</th>
                                            <th style="text-align:center;">PO Customer</th>
                                            <th style="text-align:center;">PO SAP</th>
                                            <th style="text-align:center;">Additional Info 1</th>
                                            <th style="text-align:center;">Additional Info 2</th>
                                            <th style="text-align:center;">Status</th>
                                            <th style="text-align:center;">Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;

                                        foreach ($packing_list as $value_packing) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $value_packing->CHR_PART_NO ?></td>
                                                <td><?php echo $value_packing->CHR_PARTNO_CUST ?></td>
                                                <td><?php echo $value_packing->CHR_BACK_NO ?></td>
                                                <td><?php echo $value_packing->CHR_SLOC_FROM ?></td>
                                                <td><?php echo $value_packing->INT_QTY ?></td>
                                                <td><?php echo "Palllet-" . $value_packing->INT_NOPALLET ?></td>
                                                <td><?php echo $value_packing->CHR_NOPO_CUST ?></td>
                                                <td><?php echo $value_packing->CHR_NOPO_SAP ?></td>
                                                <td><?php echo $value_packing->CHR_ADD_INFO ?></td>
                                                <td><?php echo $value_packing->CHR_ADD_INFO1 ?></td>
                                                <td style="text-align:center;">
                                                    <?php if ($value_packing->CHR_STAT == '1') { ?>
                                                        <img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="30">
                                                    <?php } else {
                                                    ?>
                                                        <img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="30">
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align:center;"><?php echo $value_packing->CHR_MSG; ?></td>

                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END RESPONSIVE TABLE -->
            </div>


    </section>
</aside>