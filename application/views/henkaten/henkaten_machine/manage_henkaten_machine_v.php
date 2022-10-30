<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Manage Henkaten Machine</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE HENKATEN MACHINE</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/henkaten/henkaten_machine_c/create/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Quality Problem" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Work Center</th>
                                    <th>Process Name</th>
                                    <th>Type</th>
                                    <th>Part No</th>
                                    <th>Time Schedule</th>
                                    <th>Time Actual</th>
                                    <th>Keterangan</th>
                                    <th>Flag NG</th>
                                    <th>Methode Action</th>
                                    <th>PIC</th>
                                    <th>Flag NG Quality</th>
                                    <th>PIC Quality</th>
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

                                    if ($isi->INT_FLG_NG == 0) {
                                        $flag_ng = 'NG';
                                    } else {
                                        $flag_ng = 'OK';
                                    }

                                    if ($isi->INT_TYPE == 0) {
                                        $type = 'PLAN';
                                    } else {
                                        $type = 'BREAKDOWN';
                                    }


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

                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td>$isi->CHR_PROCESS_NO</td>";
                                    echo "<td>$type</td>";
                                    echo "<td>$isi->CHR_PART_NO</td>";
                                    echo "<td>$schedule</td>";
                                    echo "<td>$actual</td>";
                                    echo "<td>$isi->CHR_DETAIL</td>";
                                    echo "<td>$flag_ng</td>";
                                    echo "<td>$isi->CHR_CORRECT_ACTION</td>";
                                    echo "<td>$isi->CHR_PIC</td>";
                                    echo "<td>$flag_quality_ng</td>";
                                    echo "<td>$isi->CHR_PIC_QUALITY</td>";
                                    echo "<td>$flag_spv</td>";
                                    ?>
                                <td>
                                    <!--<a href="<?php echo base_url('index.php/henkaten/henkaten_machine_c/select_henkaten_machine_by_id') . "/" . trim($isi->INT_ID) ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>-->
                                    <!--<a href="<?php echo base_url('index.php/henkaten/henkaten_machine_c/edit_henkaten_machine') . "/" . trim($isi->INT_ID) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                    <a href="<?php echo base_url('index.php/henkaten/henkaten_machine_c/delete_henkaten_machine') . "/" . trim($isi->INT_ID) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this user?');"><span class="fa fa-times"></span></a>
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