<div class="col-md-7">
    <div class="grid">
        <div class="grid-header">
            <i class="fa fa-shopping-cart"></i>
            <span class="grid-title"><strong>TEMPORARY </strong> PRCHASE REQUEST</span>
            <div class="pull-right grid-tools">
                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="grid-body">

            <h4>Total <strong><?php echo $org->CHR_SECTION ?></strong>'s Temporary Budget: Rp <strong><?php echo number_format($temp_table_total) ?> </strong> </h4>

            <table id="dataTables1" class="table table-condensed table-hover table-bordered table-responsive display" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Budget</th>
                        <th>Total</th>
                        <th>Item</th>
                        <th>Supplier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if ($temp_table != null) {
                        foreach ($temp_table as $isi) {
                            $x = 'e';
                            if ($isi->INT_ID_UNIT != 0) {
                                $x = 's';
                            }
                            echo "<tr class='gradeX'>";
                            echo "<td>$i</td>";
                            echo "<td>$isi->INT_NO_BUDGET</td>";
                            echo "<td class='text-right'>" . number_format($isi->DEC_TOTAL) . "</td>";
                            echo "<td>$isi->CHR_PURCHASE_ITEM</td>";
                            echo "<td>$isi->CHR_SUPPLIER_NAME</td>";
                            ?>
                        <td>
                            <a href="<?php echo base_url('index.php/budget/purchase_request_c/add_pureq_detail_e') . "/" . $isi->INT_ID_SECTION . "/" . $isi->INT_NO_BUDGET . "/" . $x; ?>" class="label label-success"><span class="fa fa-plus"></span></a>
                        </td>
                        </tr>

                        <?php
                        $i++;
                    }
                }
                ?>
                </tbody>
            </table>
            <div class="form-group">
                <div class="text-center">
                    <div class="btn-group">
                        <a data-toggle="modal" data-target="#modalSavePR" class="btn btn-primary" title="Save"><i class="fa fa-check"></i> Save</a>
                        <a data-toggle="modal" data-target="#modalResetPR" class="btn btn-default" title="Reset"></i> Reset</a>
                        <div class="modal fade md-effect-9" id="modalSavePR" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel9">Save Purchase Request</h4>

                                        </div>
                                        <?php echo form_open('budget/purchase_request_c/save_purchase_request_e/' . $org->INT_ID_SECTION, 'class="form-horizontal"'); ?>
                                        <div class="modal-body">
                                            <div class="modal-body">
                                                <p>Are you sure want to Save this Purchase Request?</p>
                                                <p>Make sure all budgets on the Temporary Table is appropriate with Purchase Request's Requirement.</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Save</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade md-effect-9" id="modalResetPR" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-red">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel9">Reset Purchase Request</h4>

                                        </div>
                                        <?php echo form_open('budget/purchase_request_c/reset_purchase_request_e/' . $org->INT_ID_SECTION, 'class="form-horizontal"'); ?>
                                        <div class="modal-body">
                                            <div class="modal-body">
                                                <p>Are you sure want to reset this Purchase Request?</p>
                                                <p>All budget on this Temporary Table will be deleted.</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reset</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>