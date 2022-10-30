
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/master_line_part_c/"') ?>"><strong>Master Data Device</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>MASTER DEVICE INSPECTION</strong></span>
                       <div class="pull-right">
                            <a href="<?php echo base_url('index.php/raw_material/master_line_part_c/create_data/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create New Device" style="height:30px;font-size:13px;width:120px;padding-left:10px;">New Device</a>
                        </div>
                    </div>
                    <div class="grid-body" >
                    
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Device ID</th>
                                        <th style="text-align:center;">Device Name</th>
                                        <!--<th style="text-align:center;">Line</th>-->
                                        <th style="text-align:center;">Callibration Date</th>
                                        <th style="text-align:center;">Created Date</th>
                                        <th style="text-align:center;">Created By</th>                                        
                                        <th style="text-align:center;">Status</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_dev as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$r</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_DEVICE_ID</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_DEVICE_NAME</td>";
                                        // echo "<td style='text-align:center;'>$isi->CHR_LINE</td>";
                                        ?>
                                        <td style="text-align:center;">
                                            <?php echo date("d-M-Y", strtotime($isi->CHR_CALBR_DATE)) ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo date("d-M-Y", strtotime($isi->CHR_CREATED_DATE)) ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $isi->CHR_CREATED_BY ?>
                                        </td>
                                        <?php 
                                        if($isi->CHR_STAT_DEL=='F'){ ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                        <?php }
                                        ?>
                                    <td style='text-align:center;'>
                                        <a href="<?php echo base_url('index.php/raw_material/master_line_part_c/delete_dt_dev') . "/" . $isi->INT_ID; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Non-Aktif" onclick="return confirm('Yakin ingin non-aktifkan data?');"><span class="fa fa-times"></span></a>
                                        <a href="<?php echo base_url('index.php/raw_material/master_line_part_c/undelete_dt_dev') . "/" . $isi->INT_ID; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Aktif Ulang" onclick="return confirm('Yakin ingin aktifkan kembali data?');"><span class="fa fa-check"></span></a>
                                        <a href="<?php echo base_url('index.php/raw_material/master_line_part_c/edit_dt_dev')  . "/" . $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit Data"><span class="fa fa-pencil"></span></a>
                                    </td>
                                    </tr>
                                    <?php
                                    $r++;
                                }
                                ?>
                                </tbody>
                            </table>
                        
                </div>
            </div>
        </div>
        </div>
    </section>
</aside>
