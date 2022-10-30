<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_c') ?>">Manage Spare Part</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_c/create_sp/') ?>">Create Spare Part</a></li>
            <li> <a href="#"><strong>Upload Data Confirmation</strong></a></li>
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
                            <i class="fa fa-gear"></i>
                            <span class="grid-title">UPLOAD DATA <strong>CONFIRMATION</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            <div class="pull-right grid-tools">
                                <div class="btn-group">
                                    <?php //if ($cek_upload_total == $cek_upload_ok) { ?>
                                        <button type="submit" class="btn btn-primary" name="btn-confirm" value="1" onclick="$(this).hide();"><i class="fa fa-check"></i> Confirm & Save</button>
                                    <?php //} else { ?>
                                        <!--<button type="submit" class="btn btn-primary" name="btn-upload" value="1" disabled><i class="fa fa-check"></i> Save</button>-->
                                    <?php //} ?>
                                    <?php
                                        echo anchor('samanta/spare_parts_c/cancel_upload/', 'Cancel', 'class="btn btn-default"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($cek_upload_total != $cek_upload_ok) { ?>
                            <div class="grid-body">
                                <div class="grid-body">
                                    <div class="alert alert-warning">
                                        <strong>Perhatian!</strong> Periksa kembali template upload Anda.
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- BEGIN RESPONSIVE TABLE -->
                <div class="col-md-12">
                    <div class="grid no-border">
                        <div class="grid-header">
                            <i class="fa fa-table"></i>
                            <span class="grid-title">LIST <strong>DATA</strong></span></span>
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
                                        <tr class='gradeX'>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">No</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Part No</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Rack No</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Part Name</th>                                        
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Component</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Model</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Back No</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Type</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Specification</th>                                            
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Price</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Qty Use</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Qty Min</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Qty Max</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Qty Act</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Status</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $x = 1;
                                        if (count($data_list) > 0) {
                                            foreach ($data_list as $isi) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td style=text-align:center;>$x</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_RACK_NO</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_SPARE_PART_NAME</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_COMPONENT</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_MODEL</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_TYPE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_SPECIFICATION</td>";
                                                echo "<td style=text-align:center;>Rp $isi->CHR_PRICE</td>";
                                                echo "<td style=text-align:center;>$isi->INT_QTY_USE</td>";
                                                echo "<td style=text-align:center;>$isi->INT_QTY_MIN</td>";
                                                echo "<td style=text-align:center;>$isi->INT_QTY_MAX</td>";
                                                echo "<td style=text-align:center;>$isi->INT_QTY_ACT</td>";
                                                ?>
                                            <td style="text-align:center;">
                                                <?php if ($isi->STATUS == '0') { ?>
                                                    <img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="30">
                                                <?php } else {
                                                    ?>
                                                    <img src="<?php echo base_url() . "/assets/img/messagebox_warning.png" ?>" width="30">
                                                    <?php
                                                }
                                                ?></td>
                                                <?php
                                                if($isi->MESSAGE == ' '){
                                                     echo "<td style=text-align:center;>OK</td>";
                                                } else{
                                                     echo "<td style=text-align:center;>$isi->MESSAGE</td>";
                                                }
                                               
                                                ?>
                                            </tr>
                                            <?php
                                            $x++;
                                        }
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