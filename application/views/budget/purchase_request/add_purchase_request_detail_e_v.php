

<div class="col-md-5">
    <div class="grid">
        <div class="grid-header">
            <i class="fa fa-shopping-cart"></i>
            <span class="grid-title">BUDGET PLAN <strong><?php echo $data_head->INT_NO_BUDGET ?></strong></span>
            <div class="pull-right grid-tools">
                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="grid-body">
            <?php
            $minus = 0;
            if ($temp_table != NULL) {
                foreach ($temp_table as $tp) {
                    if ($data_head->INT_NO_BUDGET == $tp->INT_NO_BUDGET) {
                        $minus = $tp->DEC_TOTAL;
                    }
                }
            }
            ?>
            <h4>Total <strong><?php echo $data_head->CHR_BUDGET_NAME ?></strong>'s Budget Remains: Rp <strong><?php echo number_format($data_head->DEC_TOTAL - $minus) ?> </strong> </h4>

            <?php
            $session = $this->session->all_userdata();
            echo form_open('budget/purchase_request_c/add_budget_to_pureq_temp_e/' . $data_head->INT_NO_BUDGET . '/' . $full . '/' . $eos, 'class="form-horizontal"');
            ?>

            <div class="form-group">
                <label class="col-sm-4 control-label">Purchase Item</label>
                <div class="col-sm-7">
                    <input name="CHR_PURCHASE_ITEM" id='CHR_PURCHASE_ITEM' class="form-control" autofocus maxlength="50" required type="text" placeholder="Item's Name">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Supplier Name</label>
                <div class="col-sm-7">
                    <input name="CHR_SUPPLIER_NAME" class="form-control" maxlength="50" required type="text" placeholder="Supplier">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">PIC Requisitioner</label>
                <div class="col-sm-7">
                    <input name="CHR_REQUISIONER" class="form-control" maxlength="50" required type="text" placeholder="Requisitioner" value="<?php echo $session['USERNAME'] ?>">
                </div>
            </div>

            <?php if ($eos == 's') { ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Price Per Unit</label>
                    <div class="col-sm-5">
                        <input name="INT_PRICE_PER_UNIT" class="form-control text-right" required type="text" placeholder="0" value="<?php echo $data_head->DEC_MONEY_PER_UNIT ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Quantity</label>
                    <div class="col-sm-5">
                        <input name="INT_QUANTITY" class="form-control text-right" required type="text" placeholder="Quantity Plan: <?php echo number_format($total_qty) ?>">
                    </div>
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Cost</label>
                    <div class="col-sm-5">
                        <input name="INT_COST" class="form-control text-right"  required type="text" placeholder="Max Rp <?php echo number_format($data_head->DEC_TOTAL - $minus) ?>">
                    </div>
                </div>
            <?php } ?>

            <!--            <div class="form-group">
                            <label class="col-sm-4 control-label">Month Estimation</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_BUDGET" id="e1" class="form-control">
            <?php
//                        $ys = $fiscal->CHR_FISCAL_YEAR_START;
//                        $ye = $fiscal->CHR_FISCAL_YEAR_END;
//                        $ms = $fiscal->CHR_MONTH_START;
//                        $me = $fiscal->CHR_MONTH_END;
//                        if ($ys == $ye) {
//                            echo "<optgroup label='$ys'>";
//                            for ($x = $ms; $x <= $me; $x++) {
//                                echo "<option value='$x'>$x</option>";
//                            }
//
//                            echo "</optgroup>";
//                        } else if ($ys != $ye) {
//                            echo "<optgroup label='$ys'>";
//                            $x = $ms;
//                            do {
//                                echo "<option value='$x'>$x</option>";
//                                $x++;
//                            } while ($x <= 12);
//                            echo "</optgroup>";
//
//                            echo "<optgroup label='$ye'>";
//                            echo "<option value='$me'>$me</option>";
//                            echo "</optgroup>";
//                        }
            ?>
            
                                </select>
                            </div>
                        </div>-->

            <div class="form-group">
                <label class="col-sm-4 control-label">Month Estimation</label>
                <div class="col-sm-5">
                    <input name="INT_MONTH" class="form-control text-right"  required type="text" placeholder="Month">
                </div>
            </div>

            <div class="form-group">
                <div class="text-center">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add </button>
                        <?php
                        echo anchor('budget/purchase_request_c/create_purchase_request_e', 'Cancel', 'class="btn btn-default"');
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>