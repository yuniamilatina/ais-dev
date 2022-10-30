<div class="grid"><div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">EDIT <strong>PROJECT</strong></span>

    </div>
    <div class="grid-body">
        <?php echo form_open('budget/project_c/update_project', 'class="form-horizontal"'); ?>
        <div hidden class="form-group">
            <label class="col-sm-4 control-label">Project ID</label>
            <div class="col-sm-8">
                <input name="INT_ID_PROJECT" value="<?php echo trim($project->INT_ID_PROJECT); ?>" class="form-control" maxlength="7" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Project Code</label>
            <div class="col-sm-8">
                <input name="CHR_PROJECT" value="<?php echo trim($project->CHR_PROJECT); ?>" autofocus class="form-control" maxlength="7" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Project Desc</label>
            <div class="col-sm-8">
                <input name="CHR_PROJECT_DESC" value="<?php echo trim($project->CHR_PROJECT_DESC); ?>" class="form-control" maxlength="30" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Customer</label>
            <div class="col-sm-8">
                <input name="CHR_CUSTOMER" value="<?php echo trim($project->CHR_CUSTOMER); ?>" class="form-control" maxlength="30" required type="text">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Product</label>
            <div class="col-sm-8">
                <select name="INT_ID_PRODUCT[]" multiple id="e2" class="form-control" style="width:183px">

                    <?php
                    $x = 1;
                    foreach ($product as $isi) {
                        foreach ($project_product as $pp) {
                            if ($pp->INT_ID_PRODUCT == $isi->INT_ID_PRODUCT) {
                                ?>
                                <option selected value="<?php echo $isi->INT_ID_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' / ' . $isi->CHR_PRODUCT_DESC; ?></option>
                                <?php
                                $x = $isi->INT_ID_PRODUCT;
                            }
                        }
                        if ($isi->INT_ID_PRODUCT != $x) {
                            ?>
                            <option value="<?php echo $isi->INT_ID_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' / ' . $isi->CHR_PRODUCT_DESC; ?></option>
                            <?php
                        }
                    }
                    ?> 
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">New Project</label>
            <div class="col-sm-5">
                <label class="radio-inline"><input type="radio" name="INT_FLG_NEW" class="icheck" value=1 <?php if($project->BIT_FLG_NEW_PROJECT == 1){ echo "checked"; } ?>> Yes</label>
                <label class="radio-inline"><input type="radio" name="INT_FLG_NEW" class="icheck" value=0 <?php if($project->BIT_FLG_NEW_PROJECT == 0){ echo "checked"; } ?>> No</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Masspro</label>
            <div class="col-sm-4">
                <select name="CHR_MASSPRO_MONTH" class="form-control" style="width:100px">
                    <option value="01" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "01"){ echo "selected"; } ?>>January</option>
                    <option value="02" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "02"){ echo "selected"; } ?>>February</option>
                    <option value="03" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "03"){ echo "selected"; } ?>>March</option>
                    <option value="04" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "04"){ echo "selected"; } ?>>April</option>
                    <option value="05" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "05"){ echo "selected"; } ?>>May</option>
                    <option value="06" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "06"){ echo "selected"; } ?>>June</option>
                    <option value="07" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "07"){ echo "selected"; } ?>>July</option>
                    <option value="08" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "08"){ echo "selected"; } ?>>August</option>
                    <option value="09" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "09"){ echo "selected"; } ?>>September</option>
                    <option value="10" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "10"){ echo "selected"; } ?>>October</option>
                    <option value="11" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "11"){ echo "selected"; } ?>>November</option>
                    <option value="12" <?php if(substr($project->CHR_MASSPRO_DATE, 4, 2) == "12"){ echo "selected"; } ?>>December</option>
                    </select>
            </div>
            <div class="col-sm-4">
                <select name="CHR_MASSPRO_YEAR" class="form-control" style="width:80px" required>
                    <?php for ($x = 0; $x <= 15; $x++) { ?>
                    <option value="<?php echo date("Y", strtotime("+$x year")); ?>" <?php
                        if (substr($project->CHR_MASSPRO_DATE, 0, 4) == date("Y", strtotime("+$x year"))) {
                            echo 'SELECTED';
                        }
                    ?> > <?php echo date("Y", strtotime("+$x year")); ?> </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group text-center">
            <div class="btn-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <?php echo anchor('budget/project_c', 'Cancel', 'class="btn btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div></div>