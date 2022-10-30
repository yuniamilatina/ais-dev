    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('ines/ines_c/save_ines', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE DEVICE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Asset Code</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_ASSET" class="form-control" style="width:100px;">
                                    <?php
                                    foreach ($data_asset as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID; ?>"><?php echo $isi->CHR_ASSET_CODE . ' / ' . $isi->CHR_ASSET_NAME; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Code</label>
                            <div class="col-sm-4">
                                <input name="CHR_ASSET_CODE" class="form-control" maxlength="30" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dept</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_DEPT"  id="e2" class="form-control" style="width:100px">
                                    <?php
                                    foreach ($dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group Product</label>
                            <div class="col-sm-5">
                                <select name="CHR_GROUP_PRODUCT"  class="form-control" style="width:180px">
                                    <?php
                                    foreach ($data_group_product as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_GROUP_PRODUCT; ?>"><?php echo $isi->CHR_GROUP_PRODUCT_NAME; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-5">
                                <select name="CHR_WORK_CENTER" id="e1" class="form-control" style="width:150px">
                                <option value="OTHER">OTHER</option>
                                    <?php
                                    foreach ($data_work_center as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_WCENTER; ?>"><?php echo $isi->CHR_WCENTER; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">IP Address</label>
                            <div class="col-sm-3">
                                <input name="CHR_IP" class="form-control" maxlength="80" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Port Address</label>
                            <div class="col-sm-3">
                                <input name="CHR_PORT" class="form-control" maxlength="80" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">URL Address</label>
                            <div class="col-sm-5">
                                <input name="CHR_URL" class="form-control" maxlength="100" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Usage</label>
                            <div class="col-sm-5">
                                <input name="CHR_USAGE" class="form-control" maxlength="100" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('ines/ines_c', 'Cancel', 'class="btn btn-default"');
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

