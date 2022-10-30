<div class="col-md-6">
    <div class="grid">
        <div class="grid-header">
            <i class="fa fa-shopping-cart"></i>
            <span class="grid-title"><strong>EDIT </strong> PURCHASE REQUEST</span>
            <div class="pull-right grid-tools">
                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="grid-body">
            <?php
            echo form_open('budget/purchase_request_detail_c/update_purchase_request_detail', 'class="form-horizontal" name="f"');
            ?>

            <div class="form-group">
                <label class="col-sm-4 control-label">No Budget</label>
                <div class="col-sm-7">
                    <input name="INT_NO_BUDGET" class="form-control" maxlength="50" readonly type="text" value="<?php echo $data_detail->INT_NO_BUDGET; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">No Purchase Request</label>
                <div class="col-sm-7">
                    <input name="INT_NO_PUREQ" class="form-control" maxlength="50" readonly type="text" value="<?php echo $data_detail->INT_NO_PUREQ; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Purchase Item</label>
                <div class="col-sm-7">
                    <input name="CHR_PURCHASE_ITEM" class="form-control" maxlength="50" required type="text" value="<?php echo $data_detail->CHR_PURCHASE_ITEM ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Supplier Name</label>
                <div class="col-sm-7">
                    <input name="CHR_SUPPLIER_NAME" class="form-control" maxlength="50" required type="text" value="<?php echo $data_detail->CHR_SUPPLIER_NAME ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">PIC Requisioner</label>
                <div class="col-sm-7">
                    <input name="CHR_REQUESTOR" class="form-control" maxlength="50" required type="text" value="<?php echo $data_detail->CHR_REQUESTOR ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">UoM</label>
                <div class="col-sm-3">  
                    <select name="INT_ID_UNIT" id="UOM_input" class="form-control" style="width:160px">
                        <?php
                        foreach ($data_unit as $isi) {
                            ?>
                            <option value="<?php echo $isi->INT_ID_UNIT; ?>"><?php echo $isi->CHR_UNIT . ' - ' . $isi->CHR_UNIT_DESC; ?></option>
                            <?php
                        }
                        ?> 
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Estimation Month</label>
                <div class="col-sm-3">
                    <select name="INT_MONTH_ESTIMATE" class="form-control">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>


            <input name="DEC_PRICE_PER_LIST_OLD" class="form-control" type="hidden" readonly value="<?php echo $data_detail->DEC_PRICE_PER_UNIT; ?>">
            <input name="DEC_TOTAL" class="form-control" type="hidden" readonly value="<?php echo $data->DEC_TOTAL; ?>">


            <div class="form-group">
                <label class="col-sm-4 control-label">Price per Unit</label>
                <div class="col-sm-4">
                    <input name="a" autocomplete="off" onkeyup="formatangka(this);
                            replaceChars(document.f.a.value);" class="form-control" required type="text" value="<?php echo $data_detail->DEC_PRICE_PER_UNIT; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Qty</label>
                <div class="col-sm-2">
                    <input name="INT_QUANTITY" autocomplete="off" onkeyup="angka(this);" class="form-control" required type="text" value="<?php echo $data_detail->INT_QUANTITY; ?>">
                </div>
            </div>

            <input name="DEC_PRICE_PER_UNIT" type="hidden" value="<?php echo $data_detail->DEC_PRICE_PER_UNIT; ?>" >

            <hr>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update detail</button>
                        <?php
                        echo form_close();
                        echo anchor('budget/purchase_request_c/edit_purchase_request' . '/' . $data_detail->INT_NO_PUREQ, 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>