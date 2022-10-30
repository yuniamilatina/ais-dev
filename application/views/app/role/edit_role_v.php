<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module/role_c/'); ?>">Manage Role</a></li>            
            <li><a href="#"><strong>Edit Module</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('role_module/role_c/update_role', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> ROLE</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID_ROLE" class="form-control" readonly required type="hidden" value="<?php echo $data->INT_ID_ROLE; ?>">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Role Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_ROLE" class="form-control" required type="text" value="<?php echo trim($data->CHR_ROLE); ?>" style="width: 300px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('role_module/role_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>ADD</strong> FUNCTION</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Function</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_FUNCTION" id="source" required class="form-control" style="width:300px">
                                    <?php
                                    foreach ($function as $isi_function) {
                                        ?>
                                        <option value="<?php echo $isi_function->INT_ID_FUNCTION; ?>">
                                            <?php echo $isi_function->CHR_FUNCTION; ?></option>
                                        <?php
                                    }
                                    ?>                                    
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-check"></i> Add</button>
                                    <?php
                                    echo anchor('role_module/role_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title">MANAGE <strong> ROLE FUNCTION</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr style="text-align:center">
                                    <th>Role</th>
                                    <th>Function</th>
                                    <th>Module</th>
                                    <th>Application</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data_edit as $isi2) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi2->CHR_ROLE</td>";
                                    echo "<td>$isi2->CHR_FUNCTION</td>";
                                    echo "<td>$isi2->CHR_MODULE</td>";
                                    echo "<td>$isi2->CHR_APP</td>";
                                ?>
                                <td>
                                    <a href="<?php echo base_url('#') . "/" . $isi2->INT_ID_ROLE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" 
                                                    title="Delete" onclick="return confirm('Are you sure want to delete this Function?');"><span class="glyphicon glyphicon-trash"></span></a> 
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
        </div>
    </section>
</aside>