<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module/function_c/'); ?>"><strong>Manage Functional</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE FUNCTION</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr style="text-align:center">
                                    <th>ID Function</th>
                                    <th>Module</th>
                                    <th>Function Description</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi->INT_ID_FUNCTION</td>";
                                    echo "<td>$isi->INT_ID_MODULE</td>";
                                    if ($isi->CHR_FUNCTION == NULL) {
                                        echo "<td><span class='label label-warning'>NO DATA</span></td>";
                                    }
                                    else {
                                        echo "<td>$isi->CHR_FUNCTION</td>";                                    
                                    }
                                    if ($isi->CHR_URL == NULL) {
                                        echo "<td><span class='label label-warning'>NO DATA</span></td>";
                                    }
                                    else {
                                        echo "<td>$isi->CHR_URL</td>";                                    
                                    }
                                    
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/app/function_c/edit_function') . "/" . $isi->INT_ID_FUNCTION; ?>" 
                                                    class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>

                                    <a href="<?php echo base_url('index.php/app/function_c/delete_function') . "/" . $isi->INT_ID_FUNCTION; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" 
                                                    title="Delete" onclick="return confirm('Are you sure want to delete this Function?');"><span class="fa fa-times"></span></a> 
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
        
<!--        <div class="row">
            <div class="col-md-5">
                <?php
                    if (validation_errors()) {
                        echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
                    }
                    echo form_open('role_module/function_c/save_function', 'class="form-horizontal"');
                ?>

                <div class="grid">
                    <div class="grid-header">
                            <i class="fa fa-pencil-square-o"></i>
                            <span class="grid-title">CREATE <strong>FUNCTION</strong> </span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Module</label>
                            <div class="#">
                                <select name="INT_ID_MODULE" id="source" required class="form-control" style="width:230px">
                                    <?php
                                    foreach ($data_module as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_MODULE; ?>">
                                            <?php echo $isi->CHR_MODULE; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Function</label>
                            <div class="#">
                                <input name="CHR_FUNCTION" class="form-control" required type="text" style="width: 230px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">URL</label>
                            <div class="#">
                                <input name="CHR_URL" class="form-control" required type="text" style="width: 230px;">
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="col-md-offset-4">
                                        <div class="btn-group">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>  Save</button>
                                                <?php echo anchor('role_module/function_c', 'Cancel', 'class="btn btn-default"'); 
                                                    echo form_close();
                                                ?>
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>		-->
    </section>
</aside>