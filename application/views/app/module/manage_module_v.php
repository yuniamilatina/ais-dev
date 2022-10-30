<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module/module_c/'); ?>"><strong>Manage Module</strong></a></li>
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
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>MANAGE MODULE</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr style="text-align:center">
                                    <th>ID Module</th>
                                    <th>Application</th>
                                    <th>Module</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi->INT_ID_MODULE</td>";
                                    echo "<td>$isi->CHR_APP</td>";
                                    
                                    if ($isi->CHR_MODULE == NULL) {
                                        echo "<td><span class='label label-warning'>NO DATA</span></td>";
                                    }
                                    else {
                                        echo "<td>$isi->CHR_MODULE</td>";
                                    
                                    }
                                    if ($isi->INT_LEVEL == '1') {
                                        echo "<td>Sub Module</td>";
                                    }
                                    else {
                                        echo "<td>Module</td>";
                                    }
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/app/module_c/edit_module') . "/" . $isi->INT_ID_MODULE; ?>" 
                                                    class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>

                                    <a href="<?php echo base_url('index.php/app/module_c/delete_module') . "/" . $isi->INT_ID_MODULE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" 
                                                    title="Delete" onclick="return confirm('Are you sure want to delete this Module?');"><span class="fa fa-times"></span></a> 
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
                        
<!--            <div class="col-md-5">
                <?php
                    if (validation_errors()) {
                        echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
                    }
                    echo form_open('role_module/module_c/save_module', 'class="form-horizontal"');
                ?>

                <div class="grid">
                    <div class="grid-header">
                            <i class="fa fa-pencil-square-o"></i>
                            <span class="grid-title">CREATE <strong>MODULE</strong> </span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Application</label>
                            <div class="#">
                                <select name="INT_ID_APP" id="source" required class="form-control" style="width:230px">
                                    <?php
                                    foreach ($data_application as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_APP; ?>">
                                            <?php echo $isi->CHR_APP; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Module</label>
                            <div class="#">
                                <input name="CHR_MODULE" class="form-control" maxlength="15" required type="text" style="width: 230px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Level</label>
                            <div class="#">
                                <select name="INT_LEVEL" required class="form-control" style="width:230px">
                                    <option value="1">Sub Module</option>
                                    <option value="0">Module</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="col-md-offset-4">
                                        <div class="btn-group">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>  Save</button>
                                                <?php echo anchor('role_module/module_c', 'Cancel', 'class="btn btn-default"'); 
                                                    echo form_close();
                                                ?>
                                        </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>-->
    </div>		
	</section>
</aside>