<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Manage Henkaten MP</strong></a></li>
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
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>MANAGE HENKATEN MP</strong>( Absensi - Pindah Line )</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/henkaten/henkaten_man_c/create/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Quality Problem" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Work Center</th>
                                    <th>Process Name</th>
                                    <th>Absent Status</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Corrective Action</th>
                                    <th>Status</th>
                                    <th>SPV Check</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $schedule = date("d-m-Y", strtotime($isi->CHR_SCHEDULE_DATE));
                                    $actual = date("d-m-Y", strtotime($isi->CHR_ACT_DATE));
                                    
                                    if ($isi->INT_STATUS_ABSEN == 0){
                                        $status = 'S.I.A';
                                    }else if($isi->INT_STATUS_ABSEN == 1){
                                        $status = 'CUTI';
                                    }else{
                                        $status = 'OUT';
                                    }
                                    
                                    if ($isi->INT_SPV_CHECK == 0){
                                        $status_app = '-';
                                    }else{
                                        $status_app = 'Approve';
                                    }
                                    
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td>$isi->CHR_PROCESS_NAME</td>";
                                    echo "<td>$status</td>";
                                    echo "<td>$isi->CHR_NPK</td>";
                                     echo "<td>$isi->CHR_USERNAME</td>";
                                    echo "<td>$schedule</td>";
                                    echo "<td>$actual</td>";
                                    echo "<td>$status_app</td>";
                                    ?>
                                <td>
                                    <!--<a href="<?php echo base_url('index.php/henkaten/henkaten_man_c/select_henkaten_man_by_id') . "/" . trim($isi->INT_ID) ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>-->
                                    <!--<a href="<?php echo base_url('index.php/henkaten/henkaten_man_c/edit_henkaten_man') . "/" . trim($isi->INT_ID) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                    <a href="<?php echo base_url('index.php/henkaten/henkaten_man_c/delete_henkaten_man') . "/" . trim($isi->INT_ID) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this user?');"><span class="fa fa-times"></span></a>
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