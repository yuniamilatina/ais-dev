<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/asset/asset_c/') ?>">Manage Asset</a></li>
            <li><a href="#"><strong>Create Asset</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('asset/asset_c/save_asset', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE</strong> ASSET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Code</label>
                            <div class="col-sm-5">
                                <input name="CHR_ASSET_CODE" class="form-control" maxlength="5" required type="text" style="width: 100px;text-transform: uppercase;">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_ASSET_NAME" class="form-control" maxlength="30" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_ASSET_DESC" class="form-control" maxlength="100" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('asset/asset_c', 'Cancel', 'class="btn btn-default"');
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

