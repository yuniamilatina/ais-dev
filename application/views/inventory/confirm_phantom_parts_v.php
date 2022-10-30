<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/inventory/temp_part_c/manage_phantom_parts') ?>">Confirm Phantom Parts</a></li>
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
                            <span class="grid-title"><strong>Confirm</strong> Phantom Parts</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">                            
                            <div class="grid-body">
                                <?php if ($cek_upload_total != $cek_upload_ok) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Error!</strong> Periksa kembali template Anda.
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Total Part No</label>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time">
                                        <input type="text" class="form-control"  name="id" value="<?php echo $cek_upload_ok ?>" disabled>
                                    </div>
                                </div>
                                <input type="hidden" id="dtp_input3" value="" />
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
                                        echo anchor('inventory/temp_part_c/manage_phantom_parts', 'Cancel', 'class="btn btn-default"');
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
                                            <th style="text-align:center;">Work Center</th>
                                            <th style="text-align:center;">Status</th>
                                            <th style="text-align:center;">Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;

                                        foreach ($phantom_parts as $value) {
                                            ?>
                                            <tr>
                                                <td style="text-align:center;"><?php echo $i ?></td>
                                                <td style="text-align:center;"><?php echo $value->CHR_PART_NO ?></td>
                                                <td style="text-align:center;"><?php echo $value->CHR_WORK_CENTER ?></td>
                                                <td style="text-align:center;">
                                                    <?php if ($value->CHR_STATUS == '1') { ?>
                                                        <img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="30">
                                                    <?php } else {
                                                        ?>
                                                        <img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="30">
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td style="text-align:center;"><?php echo $value->CHR_MESSAGE; ?></td>

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