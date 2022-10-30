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
            <li><a href="<?php echo base_url('index.php/budget/budget_capex_c/"') ?>">Manage Budget Capex</a></li>
            <li class="active"> <a href="#"><strong>Confirm Budget Capex</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong style="text-transform: uppercase;">CONFIRM BUDGET CAPEX  - <?php echo $CHR_DEPT_DESC . " - " . $CHR_SECTION_DESC . "  (" . $CHR_FISCAL_YEAR . ")" ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/budget_capex_c/create_budget_capex', 'class="form-horizontal"');
                        ?>

                        <div class="alert alert-info">                            
                            <div class="form-group" style="margin-bottom:0px;">
                                <div class="col-sm-2 control-label">
                                    <strong>Price per Unit</strong> 
                                </div>
                                <div class="col-sm-8 control-label" style="text-align: left;">
                                    : <?php echo number_format($detail_confirm[0]->MON_AMT_SUM) . " IDR"; ?>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0px;">
                                <div class="col-sm-2 control-label">
                                    <strong>Total Item</strong> 
                                </div>
                                <div class="col-sm-8 control-label" style="text-align: left;">
                                    : <strong><?php echo count($detail_confirm) . " Item" ?></strong>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <strong>Total Amount</strong> 
                                </div>
                                <div class="col-sm-8 control-label" style="text-align: left;">
                                    : <strong>
                                    <?php
                                    foreach ($SUM_AMT as $value) {
                                        echo number_format($value->sum) . " IDR";
                                    }
                                    ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col--2 control-label"></label>
                            <label class="col-sm-3 control-label"></label>

                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">

                            </div>
                            <a href='<?php echo site_url("budget/budget_capex_c/create_budget_capex"); ?>' type="submit" class="btn btn-danger"  name="btn-cancel" value="1" style="float: right;margin-right: 15px;"><i class="fa fa-reply"></i>&nbsp; Cancel</a>
                            <a href='<?php echo site_url("budget/budget_capex_c/save_budget_capex/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE") ?>' type="submit" class="btn btn-success"  name="btn-save" value="1" style="float: right;margin-right: 15px;"><i class="fa fa-check"></i>&nbsp; Confirm</a>
                        </div>

                        <?php echo form_close(); ?>

                    </div >
                    
                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Description</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">CIP</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Sub Category</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Category</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Purpose</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Project</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Product</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Owner</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Supplier</th>

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
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_DESC; ?></td>
                                            <?php if($value->INT_FLG_CIP == 1){ ?>
                                                <td style="vertical-align: middle;text-align:center;">Yes</td>
                                            <?php } else {?>
                                                <td style="vertical-align: middle;text-align:center;">No</td>
                                            <?php } ?>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_CATEGORY_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PURPOSE; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PROJECT; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PRODUCT; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_DIE_OWNER; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_SUPPLIER_LOCATION; ?></td>

                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN04; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN04); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN05; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN05); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN06; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN06); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN07; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN07); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN08; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN08); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN09; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN09); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN10; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN10); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN11; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN11); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN12; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN12); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN01; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN01); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN02; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN02); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN03; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN03); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_SUM; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_SUM); ?></td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
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
            fixedColumns: {
                leftColumns: 5
            }
        });
    });
</script>