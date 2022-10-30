<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/unit_c/') ?>">Manage Unit</a></li>            
            <li><a href="#"><strong>Edit Unit</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/unit_c/update_unit', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> UNIT</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <div hidden class="form-group">
                            <label class="col-sm-4 control-label">Id unit</label>
                            <div class="col-sm-2">
                                <input name="INT_ID_UNIT" value="<?php echo $unit->INT_ID_SATUAN; ?> "class="form-control" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">UOM</label>
                            <div class="col-sm-2">
                                <input name="CHR_UNIT" value="<?php echo trim($unit->CHR_SATUAN); ?> " autofocus class="form-control" maxlength="3" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">UOM Description</label>
                            <div class="col-sm-4">
                                <input name="CHR_UNIT_DESC" value="<?php echo trim($unit->CHR_SATUAN_DESC); ?> " class="form-control" maxlength="25" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('budget/unit_c', 'Cancel', 'class="btn btn-default"'); ?>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>