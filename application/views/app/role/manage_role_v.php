<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module/role_c/'); ?>"><strong>Manage Role</strong></a></li>
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
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title">MANAGE <strong>FUNCTION</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr style="text-align:center">
                                    <th>ID Role</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi->INT_ID_ROLE</td>";
                                    if ($isi->CHR_ROLE == NULL) {
                                        echo "<td><span class='label label-warning'>NO DATA</span></td>";
                                    }
                                    else {
                                        echo "<td>$isi->CHR_ROLE</td>";                                    
                                    }
                                    
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/role_module/role_c/edit_role') . "/" . $isi->INT_ID_ROLE; ?>" 
                                                    class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>                                                 
                                    <a href="<?php echo base_url('index.php/role_module/role_c/delete_role') . "/" . $isi->INT_ID_ROLE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" 
                                                    title="Delete" onclick="return confirm('Are you sure want to delete this Role?');"><span class="glyphicon glyphicon-trash"></span></a> 
                                </td>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="col-md-5">
                <?php
                    if (validation_errors()) {
                        echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
                    }
                    echo form_open('role_module/role_c/save_role', 'class="form-horizontal"');
                ?>

                <div class="grid">
                    <div class="grid-header">
                            <i class="fa fa-pencil-square-o"></i>
                            <span class="grid-title">CREATE <strong>ROLE</strong> </span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Role Name</label>
                            <div class="#">
                                <input name="CHR_ROLE" class="form-control" required type="text" style="width: 230px;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-offset-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>  Save</button>
                                    <?php echo anchor('role_module/role_c', 'Cancel', 'class="btn btn-default"'); 
                                        echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>		
    </section>
</aside>