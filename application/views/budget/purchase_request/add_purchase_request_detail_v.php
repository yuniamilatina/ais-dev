<div class="col-md-6">
    <div class="grid">
        <div class="grid-header">
            <i class="fa fa-shopping-cart"></i>
            <span class="grid-title"><strong>CREATE</strong> PURCHASE REQUEST</span>
            <div class="pull-right grid-tools">
                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="grid-body">
            <?php
            echo form_open('budget/purchase_request_c/save_budget_to_pureq', 'class="form-horizontal" name="f"');
            ?>

            <div class="form-group">
                <label class="col-sm-4 control-label">No Budget</label>
                <div class="col-sm-7">
                    <input name="INT_NO_BUDGET" class="form-control" maxlength="50" readonly type="text" value="<?php echo $data_detail->INT_NO_BUDGET; ?>">
                </div>
            </div>

            <input name="BIT_FLG_CIP" class="form-control" readonly type="hidden" value="<?php echo $stat_cip; ?>">
            <input name="INT_ID_SECTION" class="form-control" readonly type="hidden" value="<?php echo $section; ?>">
            <input name="INT_ID_DEPT" class="form-control" readonly type="hidden" value="<?php echo $dept; ?>">

            <div class="form-group">
                <label class="col-sm-4 control-label">Purchase Item <b class="mandatory">*</b></label>
                <div class="col-sm-7">
                    <input name="CHR_PURCHASE_ITEM" class="form-control" required maxlength="50"  type="text">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Supplier Name <b class="mandatory">*</b></label>
                <div class="col-sm-7">
                    <input name="CHR_SUPPLIER_NAME" class="form-control" required maxlength="50"  type="text">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">PIC Requestor <b class="mandatory">*</b></label>
                <div class="col-sm-7">
                    <input name="CHR_REQUESTOR" class="form-control" required maxlength="50"  type="text">
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
                <label class="col-sm-4 control-label">Total Amount (Rp)</label>
                <div class="col-sm-4">
                    <input autocomplete="off" class="form-control" type="text" required readonly value="<?php echo number_format($data_detail->DEC_TOTAL, 0, '', '.'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Max Limit (Rp)</label>
                <div class="col-sm-4">
                    <input autocomplete="off" class="form-control" type="text" readonly value="<?php echo number_format($data_detail->LIMIT, 0, '', '.'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Price per Unit (Rp)<b class="mandatory">*</b></label>
                <div class="col-sm-4">
                    <input name="a" autocomplete="off" onkeyup="formatangka(this);
                            replaceChars(document.f.a.value);" class="form-control"  type="text" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Max Qty</label>
                <div class="col-sm-2">
                    <input name="QUANTITY" class="form-control" required readonly type="text" value="<?php echo $data_detail->INT_QUANTITY; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Qty <b class="mandatory">*</b></label>
                <div class="col-sm-2">
                    <input name="INT_QUANTITY" autocomplete="off" onkeyup="angka(this);" class="form-control"  type="text" value="0">
                </div>
            </div>

            <input name="DEC_PRICE_PER_UNIT" type="hidden">

            <hr>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add to detail</button>
                        <?php
                        echo anchor('budget/purchase_request_c', 'Cancel', 'class="btn btn-default"');
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
            <b class="mandatory">*</b> = mandatory
        </div>
    </div>
</div>