<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        font-size: 11px;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Department</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DEPARTMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/aorta/master_data_c/create_dept/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Department" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div id="table-luar">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department Code</th>
                                    <th>Department Description</th>
                                    <th>Dept Head</th>
                                    <th>Group Department</th>
                                    <th>Min. Backdate (day[s])</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->KODE</td>";
                                    echo "<td>$isi->NAMA_DEP</td>";
                                    $kadep_npk = trim($isi->KADEP_NPK);
                                    $cek = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$kadep_npk'")->row();                                    
                                    if(count($cek) > 0){
                                        $kadep_name = strtoupper($cek->CHR_USERNAME);
                                    } else {
                                        $kadep_name = '';
                                    }
                                    echo "<td>" . $kadep_npk . ' - ' . $kadep_name . "</td>";
                                    echo "<td>$isi->KD_GROUP</td>";
                                    echo "<td>$isi->MIN_BACKDATE</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/aorta/master_data_c/select_dept') . "/" . $isi->KODE; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/aorta/master_data_c/edit_dept') . "/" . $isi->KODE; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/aorta/master_data_c/delete_dept') . "/" . $isi->KODE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this department?');"><span class="fa fa-times"></span></a>
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
        </div>

    </section>
</aside>


