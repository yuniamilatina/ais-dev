
<script>
    $(function() {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/delivery/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/delivery/export/upload') ?>">Confirm Employee Master</a></li>
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
                            <span class="grid-title"><strong>Confirm</strong> Employee Master</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            <div class="pull-right grid-tools">
                                <div class="btn-group">
                                    <?php if ($cek_upload_total == $cek_upload_ok) { ?>
                                        <button type="submit" class="btn btn-primary" name="btn-confirm" value="1" onclick="$(this).hide();"><i class="fa fa-check"></i> Save</button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-primary" name="btn-upload" value="1" disabled><i class="fa fa-check"></i> Save</button>
                                    <?php } ?>
                                    <?php
                                    echo anchor('aorta/master_data_c/employee', 'Cancel', 'class="btn btn-default"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($cek_upload_total != $cek_upload_ok) { ?>
                            <div class="grid-body">
                                <div class="grid-body">
                                    <div class="alert alert-danger">
                                        <strong>Error!</strong> Periksa kembali template Anda.
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
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">NPK</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Nama</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Kode Dept</th>                                        
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Kode Group</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Kode Section</th>
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Kode Sub Section</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Position</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Tunjangan Jabatan</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Tunjangan Transport</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Salary</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Stat</th> 
                                            <th rowspan="1" style="vertical-align: middle;text-align:center;">Message</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $r = 1;
                                        if (count($employee_list) > 0) {
                                            foreach ($employee_list as $isi) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td style=text-align:center;>$r</td>";
                                                echo "<td style=vertical-align: top;text-align: center;>$isi->NPK</td>";
                                                echo "<td style=vertical-align: top;text-align: left;>$isi->NAMA</td>";
                                                echo "<td style=text-align:center;>$isi->KD_DEPT</td>";
                                                echo "<td style=text-align:center;>$isi->KD_GROUP</td>";
                                                echo "<td style=text-align:center;>$isi->KD_SECTION</td>";
                                                echo "<td style=text-align:center;>$isi->KD_SUB_SECTION</td>";
                                                echo "<td style=text-align:center;background-color:#f3f4f5;>$isi->position</td>";
                                                echo "<td style=text-align:center;background-color:#f3f4f5;>".number_format($isi->tunj_jabatan)."</td>";
                                                echo "<td style=text-align:center;background-color:#f3f4f5;>".number_format($isi->tunj_transport)."</td>";
                                                echo "<td style=text-align:center;background-color:#f3f4f5;>".number_format($isi->salary)."</td>";
                                                ?>
                                            <td style="text-align:center;">
                                                <?php if ($isi->stat_error == '0') { ?>
                                                    <img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="30">
                                                <?php } else {
                                                    ?>
                                                    <img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="30">
                                                    <?php
                                                }
                                                ?></td>
                                                <?php
                                                if($isi->error_msg == ' '){
                                                     echo "<td style=text-align:center;>OK</td>";
                                                }else{
                                                     echo "<td style=text-align:center;>$isi->error_msg</td>";
                                                }
                                               
                                                ?>
                                            </tr>
                                            <?php
                                            $r++;
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