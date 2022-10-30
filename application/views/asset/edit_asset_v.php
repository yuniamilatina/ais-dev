<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/asset_c/') ?>">Manage Asset</a></li>
            <li><a href="#"><strong>Edit Asset</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('asset/asset_c/update_asset', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> ASSET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Code</label>
                            <div class="col-sm-5">
                                <input name="CHR_ASSET_CODE" class="form-control" maxlength="3" required type="text" style="width: 80px;text-transform: uppercase;" value="<?php echo trim($data->CHR_ASSET_CODE); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_ASSET_NAME" class="form-control" maxlength="40" required type="text" value="<?php echo trim($data->CHR_ASSET_NAME); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_ASSET_DESC" class="form-control" maxlength="40" required type="text" value="<?php echo trim($data->CHR_ASSET_DESC); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('asset/asset_c', 'Cancel', 'class="btn btn-default"');
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

