<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script> 

<aside class="right-side">



    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>">Manage Budget Expense</a></li>
            <li class="active"> <a href="#"><strong>Confirm Budget Expense</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong style="text-transform: uppercase;">CONFIRM BUDGET EXPENSE  - <?php echo $CHR_BUDGET_TYPE_DESC . " - " . $CHR_DEPT_DESC . " - " . $CHR_SECTION_DESC . "  (" . $CHR_FISCAL_YEAR . ")" ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/budget_expense_c/upload_budget_expense', 'class="form-horizontal"');
                        ?>

                        <div class="alert alert-info">
                            <div class="form-group" style="margin-bottom:0px;">
                                <div class="col-sm-2 control-label">
                                    <strong>Total Item</strong> 
                                </div>
                                <div class="col-sm-8 control-label" style="text-align: left;">
                                    : <?php echo count($detail_confirm) . " Item" ?>
                                </div>


                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <strong>Total Amount</strong> 
                                </div>
                                <div class="col-sm-8 control-label" style="text-align: left;">
                                    : 
                                    <?php
                                    foreach ($SUM_AMT as $value) {
                                        echo number_format($value->sum) . "  " . $value->CHR_ORG_CURR . "<br> &nbsp;&nbsp;";
                                    }
                                    ?>

                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col--2 control-label"></label>
                            <label class="col-sm-3 control-label"></label>

                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">

                            </div>
                            <a href='' type="submit" class="btn btn-danger"  name="btn-save" value="1" style="float: right;margin-right: 15px;"><i class="fa fa-reply"></i>&nbsp; Cancel</a>
                            <a href='<?php echo site_url("budget/budget_expense_c/save_budget/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/RMB") ?>' type="submit" class="btn btn-success"  name="btn-save" value="1" style="float: right;margin-right: 15px;"><i class="fa fa-check"></i>&nbsp; Confirm</a>
                        </div>

                        <?php echo form_close(); ?>

                    </div >
                    
                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Item Description</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Sub Category</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Category</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Category A3</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Category Product</th>                                        
                                        
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Purpose</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Part Number</th>                                        
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Supplier Name</th>                                        
                                        
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Satuan</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Org Curr</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Rate Curr</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Price Org Curr</th>

                                        <th colspan="2" style="text-align:center;">Apr</th>
                                        <th colspan="2" style="text-align:center;">May</th>
                                        <th colspan="2" style="text-align:center;">Jun</th>
                                        <th colspan="2" style="text-align:center;">Jul</th>
                                        <th colspan="2" style="text-align:center;">Aug</th>
                                        <th colspan="2" style="text-align:center;">Sept</th>
                                        <th colspan="2" style="text-align:center;">Oct</th>
                                        <th colspan="2" style="text-align:center;">Nov</th>
                                        <th colspan="2" style="text-align:center;">Dec</th>
                                        <th colspan="2" style="text-align:center;">Jan</th>
                                        <th colspan="2" style="text-align:center;">Feb</th>
                                        <th colspan="2" style="text-align:center;">Mar</th>
                                        <th colspan="2" style="text-align:center;">Total Yearly</th>
                                    </tr>
                                    <tr>
                                        <?php for ($i = 1; $i <= 13; $i++) { ?>
                                            <th>Qty</th>
                                            <th>Amt</th>
                                        <?php } ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($detail_confirm as $value) {
                                        ?>
                                        <tr>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $no; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_ITEM_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_CATEGORY_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_CODE_CATEGORY_A3_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_CATEGORY_PRODUCT_DESC; ?></td>
                                            
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PURPOSE; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PART_NO; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_SUPPLIER_NAME; ?></td>

                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_SATUAN; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_ORG_CURR; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->FLT_RATE_CURR); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->FLT_PRICE_CURR); ?></td>

                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN04); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN04); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN05); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN05); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN06); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN06); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN07); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN07); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN08); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN08); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN09); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN09); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN10); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN10); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN11); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN11); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN12); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN12); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN01); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN01); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN02); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN02); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN03); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN03); ?></td>

                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_SUM); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_SUM); ?></td>

                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                        <?php foreach ($detail_confirm_sum as $value) { ?>
                                        <tr>
                                          
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd; color: #dddddd;"><?php echo $no; ?></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;">Total</td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>                                            
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN04); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN04); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN05); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN05); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN06); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN06); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN07); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN07); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN08); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN08); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN09); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN09); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN10); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN10); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN11); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN11); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN12); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN12); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN01); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN01); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN02); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN02); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_BLN03); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN03); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->INT_QTY_SUM); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_SUM); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            order: [[0, 'asc']],
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>