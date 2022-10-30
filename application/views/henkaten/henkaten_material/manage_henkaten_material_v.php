<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Manage Henkaten Material</strong></a></li>
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
                        <i class="fa fa-gear"></i>
                        <span class="grid-title"><strong>HENKATEN MATERIAL</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/henkaten/henkaten_material_c/create/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Quality Problem" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Classification</th>
                                    <th>Work Center</th>
                                    <th>Process No</th>
                                    <th>Part No</th>
                                    <th>Keterangan</th>
                                    <th>Date Schedule</th>
                                    <th>Time Schedule</th>
                                    <th>Date Actual</th>
                                    <th>Time Actual</th>
                                    <th>Corrective Action</th>
                                    <th>Flag NG Quality</th>
                                    <th>PIC Quality</th>
                                    <th>ECI No</th>
                                    <th>CP</th>
                                    <th>SPV Check</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $schedule = date("H:i", strtotime($isi->CHR_SCHEDULE_TIME));
                                    $actual = date("H:i", strtotime($isi->CHR_ACT_TIME));
                                    $schedule_date = date("d-m-Y", strtotime($isi->CHR_SCHEDULE_DATE));
                                    $actual_date = date("d-m-Y", strtotime($isi->CHR_ACT_DATE));

                                    if ($isi->INT_FLG_QUALITY == 0) {
                                        $flag_quality_ng = 'NG';
                                    } else {
                                        $flag_quality_ng = 'OK';
                                    }

                                    if ($isi->INT_SPV_CHECK == 0) {
                                        $flag_spv = 'Not Approve';
                                    } else {
                                        $flag_spv = 'Approve';
                                    }

                                    if ($isi->INT_CLASSIFICATION == 0) {
                                        $classification = 'ECI';
                                    } else {
                                        $classification = 'OTHER';
                                    }

                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$classification</td>";
                                    echo "<td>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td>$isi->CHR_PROCESS_NO</td>";
                                    echo "<td>$isi->CHR_PART_NO</td>";
                                    echo "<td>$isi->CHR_DETAIL</td>";
                                    echo "<td>$schedule_date</td>";
                                    echo "<td>$schedule</td>";
                                    echo "<td>$actual_date</td>";
                                    echo "<td>$actual</td>";
                                    echo "<td>$isi->CHR_CORRECT_ACTION</td>";
                                    echo "<td>$flag_quality_ng</td>";
                                    echo "<td>$isi->CHR_PIC_QUALITY</td>";
                                    echo "<td>$isi->CHR_ECI_NO</td>";
                                    echo "<td>$isi->CHR_CP</td>";
                                    echo "<td>$flag_spv</td>";
                                    ?>
                                <td>
                                    <!--<a href="<?php echo base_url('index.php/henkaten/henkaten_material_c/select_henkaten_material_by_id') . "/" . trim($isi->INT_ID) ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>-->
                                    <!--<a href="<?php echo base_url('index.php/henkaten/henkaten_material_c/edit_henkaten_material') . "/" . trim($isi->INT_ID) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                    <a href="<?php echo base_url('index.php/henkaten/henkaten_material_c/delete_henkaten_material') . "/" . trim($isi->INT_ID) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this user?');"><span class="fa fa-times"></span></a>
                                </td>
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

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>

                                    $(document).ready(function() {
                                        $('#example').DataTable({
                                            scrollX: true,
                                            fixedColumns: {
                                                leftColumns: 3
                                            }
                                        });
                                    });
</script>