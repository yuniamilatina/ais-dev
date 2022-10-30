<div id="3rd_panel" class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>PROJECT</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open('budget/project_c/save_project', 'class="form-horizontal"'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Project Code</label>
            <div class="col-sm-8">
                <input name="CHR_PROJECT" autofocus class="form-control" maxlength="7" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Project Desc</label>
            <div class="col-sm-8">
                <input name="CHR_PROJECT_DESC" class="form-control" maxlength="30" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Customer</label>
            <div class="col-sm-8">
                <input name="CHR_CUSTOMER" class="form-control" maxlength="30" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Product</label>
            <div class="col-sm-8">
                <select name="INT_ID_PRODUCT[]" multiple id="e2" class="form-control" style="width:183px">

                    <?php
                    foreach ($product as $isi) {
                        ?>
                        <option value="<?php echo $isi->INT_ID_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' / ' . $isi->CHR_PRODUCT_DESC; ?></option>
                        <?php
                    }
                    ?> 
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">New Project</label>
            <div class="col-sm-5">
                <label class="radio-inline"><input type="radio" name="INT_FLG_NEW" class="icheck" value=1 checked> Yes</label>
                <label class="radio-inline"><input type="radio" name="INT_FLG_NEW" class="icheck" value=0> No</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Masspro</label>
            <div class="col-sm-4">
                <select name="CHR_MASSPRO_MONTH" class="form-control" style="width:100px">
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                    </select>
            </div>
            <div class="col-sm-4">
                <select name="CHR_MASSPRO_YEAR" class="form-control" style="width:80px" required>
                    <?php for ($x = 0; $x <= 15; $x++) { ?>
                    <option value="<?php echo date("Y", strtotime("+$x year")); ?>" <?php
                        if (date("Y") == date("Y", strtotime("+$x year"))) {
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