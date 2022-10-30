<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
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
            <li><a href="<?php echo base_url('index.php/budget/home_c"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module_c"') ?>"><span>Manage Role Module</span></a></li>
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
            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>ROLE MODULE <?php echo strtoupper($role->CHR_ROLE); ?></strong></span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
    <!--                                    <th>Role</th>-->
                                        <th>Application</th>
                                        <th>Module</th>
                                        <!--<th>Module Type</th>-->
                                        <th>Function</th>
                                        <th>URL</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
//                                    echo "<td>$isi->CHR_ROLE</td>";
                                        echo "<td>$isi->CHR_APP</td>";
                                        echo "<td>$isi->CHR_FUNCTION</td>";
                                        echo "<td>$isi->CHR_MODULE</td>";
//                                        echo "<td>$isi->CHR_MODULE_TYPE</td>";
                                        echo "<td>$isi->CHR_URL</td>";
                                        ?>
                                    <td>
                                        <!--<a href="<?php // echo base_url('index.php/role_module_c/view_role_module') . "/" . $isi->INT_ID_FUNCTION; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>-->
                                        <!--<a href="<?php // echo base_url('index.php/role_module_c/edit_role_module') . "/" . $isi->INT_ID_FUNCTION; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                        <a href="<?php echo base_url('index.php/role_module_c/delete_role_module') . "/" . $isi->INT_ID_FUNCTION . "/" . $isi->INT_ID_ROLE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to remove this function?');"><span class="fa fa-times"></span></a>
                                    </td> 
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        echo anchor('role_module_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>ROLE USER</strong></span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NPK</th>
                                        <th>Username</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_role_user as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_NPK</td>";
                                        echo "<td>$isi->CHR_USERNAME</td>";
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/role_module_c/remove_user_role') . "/" . $isi->CHR_NPK. "/" . $isi->INT_ID_ROLE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this role?');"><span class="fa fa-times"></span></a>
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                                            $(document).ready(function () {
                                                                var table = $('#example').DataTable({
                                                                    scrollY: "350px",
                                                                    scrollX: true,
                                                                    scrollCollapse: true,
                                                                    paging: true,
                                                                    fixedColumns: {
                                                                        leftColumns: 2
                                                                    }
                                                                });
                                                            });
</script>