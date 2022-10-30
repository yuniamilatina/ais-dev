<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Section</strong></a></li>
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
                        <span class="grid-title"><strong>SECTION</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/aorta/master_data_c/create_section') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Section" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Section Code</th>
                                    <th>Section Description</th>
                                    <th>Section Head</th>
                                    <th>Department</th>
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
                                    echo "<td>$isi->NAMA_SECTION</td>";
                                    $kasie_npk = trim($isi->KASIE_NPK);
                                    $cek = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$kasie_npk'")->row();                                    
                                    if(count($cek) > 0){
                                        $kasie_name = strtoupper($cek->CHR_USERNAME);
                                    } else {
                                        $kasie_name = '';
                                    }
                                    echo "<td>" . $kasie_npk . ' - ' . $kasie_name . "</td>";
                                    echo "<td>$isi->KODE_DEP</td>";
                                    ?>
                                <td>
                                    <!--<a href="<?php echo base_url('index.php/aorta/master_data_c/select_section') . "/" . $isi->KODE; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>-->
                                    <a href="<?php echo base_url('index.php/aorta/master_data_c/edit_section') . "/" . $isi->KODE; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/aorta/master_data_c/delete_section') . "/" . $isi->KODE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this section?');"><span class="fa fa-times"></span></a>
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


