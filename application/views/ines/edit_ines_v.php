
    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('ines/ines_c/update_ines', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-cube"></i>
                        <span class="grid-title"><strong>EDIT DEVICE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">

                        <div class="form-group"  style="display:none;">
                            <label class="col-sm-3 control-label">Asset Code</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_ASSET" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_asset as $isi) {
                                        if (trim($isi->INT_ID) == trim($row_data_ines->INT_ID_ASSET)) {
                                            ?>
                                            <option selected value="<?php echo $isi->INT_ID; ?>"><?php echo $isi->CHR_ASSET_CODE . ' / ' . $isi->CHR_ASSET_NAME; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID; ?>"><?php echo $isi->CHR_ASSET_CODE . ' / ' . $isi->CHR_ASSET_NAME; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Code</label>
                            <div class="col-sm-4">
                                <input name="CHR_ASSET_CODE" class="form-control" maxlength="30" required type="text" value="<?php echo $data->CHR_ASSET_CODE; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dept</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_DEPT" class="form-control" style="width:100px">
                                    <?php
                                    foreach ($dept as $isi) {
                                        if ($isi->INT_ID_DEPT == $row_data_ines->INT_ID_DEPT) {
                                            ?>
                                            <option selected value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT; ?></option>
                                            <?php
                                        }
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
                                        if (trim($isi->CHR_GROUP_PRODUCT) == trim($row_data_ines->CHR_GROUP_PRODUCT)) {
                                        ?>
                                        <option selected value="<?php echo $isi->CHR_GROUP_PRODUCT; ?>"><?php echo $isi->CHR_GROUP_PRODUCT_NAME; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $isi->CHR_GROUP_PRODUCT; ?>"><?php echo $isi->CHR_GROUP_PRODUCT_NAME; ?></option>
                                        <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-5">
                                <select name="CHR_WORK_CENTER" id="e1" class="form-control" style="width:100px">
                                    <?php
                                    foreach ($data_work_center as $isi) {
                                        if (trim($isi->CHR_WCENTER) == trim($row_data_ines->CHR_WORK_CENTER)) {
                                            ?>
                                            <option selected value="<?php echo $isi->CHR_WCENTER; ?>"><?php echo $isi->CHR_WCENTER; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->CHR_WCENTER; ?>"><?php echo $isi->CHR_WCENTER; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">IP Address</label>
                            <div class="col-sm-3">
                                <input name="CHR_IP" class="form-control" maxlength="100" required type="text" value="<?php echo trim($data->CHR_IP); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Port Address</label>
                            <div class="col-sm-3">
                                <input name="CHR_PORT" class="form-control" maxlength="100" required type="text" value="<?php echo trim($data->CHR_PORT); ?>">
                            </div>
                        </div><div class="form-group">
                            <label class="col-sm-3 control-label">URL Address</label>
                            <div class="col-sm-5">
                                <input name="CHR_URL" class="form-control" maxlength="100" required type="text" value="<?php echo trim($row_data_ines->CHR_URL); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Usage</label>
                            <div class="col-sm-5">
                                <input name="CHR_USAGE" class="form-control" maxlength="100" required type="text" value="<?php echo trim($row_data_ines->CHR_USAGE); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('ines/ines_c', 'Cancel', 'class="btn btn-default"');
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