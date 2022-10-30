
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module_c"') ?>"><strong>Manage Role Module</strong></a></li>
            <li><a href="#"><strong>View Role Module</strong></a></li>
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
                        <span class="grid-title"><strong>ROLE MODULE</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/role_module_c/add_function') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Role" style="height:30px;font-size:13px;width:100px;">Add Function</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Role</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_ROLE</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/role_module_c/role_detail') . "/" . $isi->INT_ID_ROLE; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/role_module_c/edit_role') . "/" . $isi->INT_ID_ROLE ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/role_module_c/delete_role') . "/" . $isi->INT_ID_ROLE ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this role?');"><span class="fa fa-times"></span></a>
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

<!--            <div id="2nd_panel" class="col-md-7">
                <?php
//                if ($subcontent != NULL) {
//                    $this->load->view($subcontent);
//                }
                ?>
            </div>-->
            
               </div>

    </section>
</aside>
