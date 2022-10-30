
<script>
    $(function() {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home.c') ?>">Home</a></li>
            <li><a href="">Confirm Monthly Production Target</a></li>
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
                            <span class="grid-title"><strong>Confirm</strong> Master Monthly Production Target </span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            <div class="pull-right grid-tools">
                                <div class="btn-group">
                                    <?php if ($cek_upload_error > 0) { ?>
                                            <button type="submit" class="btn btn-primary" name="btn-upload" value="1" disabled><i class="fa fa-check"></i> Save</button>
                                    <?php } else { ?>
                                            <button type="submit" class="btn btn-primary" name="btn-confirm" value="1" onclick="$(this).hide();"><i class="fa fa-check"></i> Save</button>
                                    <?php } ?>
                                    <?php
                                    echo anchor('aorta/master_prod_target_c/prod_target', 'Cancel', 'class="btn btn-default"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($cek_upload_total != $cek_upload_ok) { ?>
                            <div class="grid-body">
                                <div class="grid-body">
                                    <div class="alert alert-warning">
                                        <strong>Warning!</strong> Periksa kembali template Anda.
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
                                        <tr class='gradeX'>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">No</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Periode</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Dept</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Section</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Line</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Target Prod</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Loading WO</th>                                        
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">MP</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">CT</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">MH/pcs</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Plan Shift</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Working Days</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Status</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Message</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (count($prod_target_list) > 0) {
                                            foreach ($prod_target_list as $isi) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td style=text-align:center;>$no</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_DATE_PERIODE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_DEPT</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_SECTION</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_LINE</td>";
                                                echo "<td style=text-align:center;>$isi->INT_TARGET_PRD</td>";
                                                echo "<td style=text-align:center;>$isi->INT_LOAD</td>";
                                                echo "<td style=text-align:center;>$isi->INT_MP</td>";
                                                echo "<td style=text-align:center;>$isi->INT_CT</td>";
                                                echo "<td style=text-align:center;>$isi->FLT_MH_PCS</td>";
                                                echo "<td style=text-align:center;>$isi->INT_PLAN_SHIFT</td>";
                                                echo "<td style=text-align:center;>$isi->INT_WD</td>";
                                                ?>
                                                <td style="text-align:center;">
                                                <?php if ($isi->STATUS_ERROR == '0') { ?>
                                                    <img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="30">
                                                <?php } else if ($isi->STATUS_ERROR == '2') { ?>
                                                    <img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="30">
                                                <?php } else {
                                                    ?>
                                                    <img src="<?php echo base_url() . "/assets/img/messagebox_warning.png" ?>" width="30">
                                                    <?php
                                                }
                                                ?></td>
                                                <?php
                                                if($isi->MESSAGE == ' '){
                                                     echo "<td style=text-align:center;>OK</td>";
                                                }else{
                                                     echo "<td style=text-align:center;>$isi->MESSAGE</td>";
                                                }
                                               
                                                ?>
                                            </tr>
                                            <?php
                                            $no++;
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