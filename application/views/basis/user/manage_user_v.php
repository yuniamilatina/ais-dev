<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
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
        text-align: center;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/basis/user_c') ?>"><strong>Manage Employee</strong></a></li>
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
                        <span class="grid-title"><strong>EMPLOYEE TABLE</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/basis/user_c/create_user/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Employee" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NPK</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <!--<th>Company</th>-->
                                        <th>Division</th>
                                        <th>Group Dept</th>
                                        <th>Dept</th>
                                        <th>Section</th>
                                        <th>Sub Section</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_NPK</td>";
                                        echo "<td>$isi->CHR_USERNAME</td>";
                                        echo "<td>$isi->CHR_ROLE</td>";
//                                    echo "<td>$isi->CHR_COMPANY_DESC</td>";
                                        echo "<td>$isi->CHR_DIVISION</td>";
                                        echo "<td>$isi->CHR_GROUP_DEPT</td>";
                                        echo "<td>$isi->CHR_DEPT</td>";
                                        echo "<td>$isi->CHR_SECTION</td>";
                                        echo "<td>$isi->CHR_SUB_SECTION</td>";
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/basis/user_c/select_by_id_user') . "/" . trim($isi->CHR_NPK) ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                        <a href="<?php echo base_url('index.php/basis/user_c/edit_user') . "/" . trim($isi->CHR_NPK) . "/" . $isi->INT_ID_ROLE ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/basis/user_c/delete_user') . "/" . trim($isi->CHR_NPK) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this user?');"><span class="fa fa-times"></span></a>
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
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>

                                        $(document).ready(function () {
                                            $('#example').DataTable({
                                                scrollX: true,
//                                                fixedColumns: {
//                                                    //leftColumns: 2
//                                                }
                                            });
                                        });
</script>