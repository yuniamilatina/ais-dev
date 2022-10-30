<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Employee</strong></a></li>
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
                        <span class="grid-title"><strong>EMPLOYEE</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/aorta/master_employee_c/create_employee/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Employee" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%">
                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="90%">
                                        <select class="ddl" id="dept" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_dept as $isi) { ?>
                                                <option value="<?php echo site_url('aorta/master_employee_c/index/0/' . $isi->INT_ID_DEPT); ?>" <?php
                                                if ($id_dept == $isi->INT_ID_DEPT) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $isi->CHR_DEPT; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                </tr>                                
                            </table>                            
                        </div>
                        <div>&nbsp;</div>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Group</th>
                                    <th>Department</th>
                                    <th>Section</th>
                                    <th>Sub Section</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td align='center'>$isi->NPK</td>";
                                    echo "<td>$isi->NAMA</td>";
                                    echo "<td align='center'>$isi->KD_GROUP</td>";
                                    echo "<td align='center'>$isi->KD_DEPT</td>";
                                    echo "<td align='center'>$isi->KD_SECTION</td>";
                                    echo "<td align='center'>$isi->KD_SUB_SECTION</td>";
                                    if($isi->FLAG_DELETE == 0){
                                        echo "<td align='center'>Active</td>";
                                    } else {
                                        echo "<td align='center'>Disabled</td>";
                                    }
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/aorta/master_employee_c/edit_employee') . "/" . $isi->NPK;  ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>                                      
                                    <?php if($isi->FLAG_DELETE == 0){ ?>
                                        <a href="<?php echo base_url('index.php/aorta/master_employee_c/delete_employee') . "/" . $isi->NPK; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Disable" onclick="return confirm('Are you sure want to disable this employee?');"><span class="fa fa-times"></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('index.php/aorta/master_employee_c/enable_employee') . "/" . $isi->NPK;  ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Enable"><span class="fa fa-check"></span></a>
                                    <?php } ?>                                    
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