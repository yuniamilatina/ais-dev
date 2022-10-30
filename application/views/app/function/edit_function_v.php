<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module/function_c/'); ?>">Manage Function</a></li>            
            <li><a href="#"><strong>Edit Module</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('app/function_c/update_function', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT FUNCTION</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID_FUNCTION" class="form-control" readonly required type="hidden" value="<?php echo $data->INT_ID_FUNCTION; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Module </label>
                            <div class="col-sm-5">
                                <select name="INT_ID_MODULE" required class="form-control" style="width:300px">
                                    <?php
                                    foreach ($data_module as $isi) {
                                        if ($isi->INT_ID_MODULE == $row_data_module->INT_ID_MODULE) {
                                            ?>
                                            <option selected value="<?php echo $isi->INT_ID_MODULE; ?>"><?php echo $isi->CHR_MODULE; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_MODULE; ?>"><?php echo $isi->CHR_MODULE; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Function Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_FUNCTION" class="form-control" required type="text" value="<?php echo trim($data->CHR_FUNCTION); ?>" style="width: 300px;text-transform: uppercase;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">URL</label>
                            <div class="col-sm-5">
                                <input name="CHR_URL" class="form-control"  required type="text" value="<?php echo trim($data->CHR_URL); ?>" style="width: 500px;text-transform: uppercase;">              
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('app/function_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
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