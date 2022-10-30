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
            <li><a href="<?php echo base_url('index.php/budget/budget_dimat_c/"') ?>">Manage Budget Direct Material</a></li>
            <li class="active"> <a href="#"><strong>Confirm Budget Direct Material</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong style="text-transform: uppercase;">CONFIRM BUDGET DIRECT MATERIAL  - <?php echo $CHR_BUDGET_TYPE_DESC . " - " . $CHR_DEPT_DESC . " - " . $CHR_SECTION_DESC . "  (" . $CHR_FISCAL_YEAR . ")" ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/budget_dimat_c/upload_budget_expense', 'class="form-horizontal"');
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
                                        echo number_format($value->sum) . " IDR <br> &nbsp;&nbsp;";
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
                            <a href='<?php echo site_url("budget/budget_dimat_c/save_budget/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/RMB") ?>' type="submit" class="btn btn-success"  name="btn-save" value="1" style="float: right;margin-right: 15px;"><i class="fa fa-check"></i>&nbsp; Confirm</a>
                        </div>

                        <?php echo form_close(); ?>

                    </div >
                    
                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Sub Category</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Category</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Category A3</th>

                                        <th style="text-align:center;">Apr</th>
                                        <th style="text-align:center;">May</th>
                                        <th style="text-align:center;">Jun</th>
                                        <th style="text-align:center;">Jul</th>
                                        <th style="text-align:center;">Aug</th>
                                        <th style="text-align:center;">Sept</th>
                                        <th style="text-align:center;">Oct</th>
                                        <th style="text-align:center;">Nov</th>
                                        <th style="text-align:center;">Dec</th>
                                        <th style="text-align:center;">Jan</th>
                                        <th style="text-align:center;">Feb</th>
                                        <th style="text-align:center;">Mar</th>
                                        <th style="text-align:center;">Total Yearly</th>
                                    </tr>
                                    <tr>
                                        <?php for ($i = 1; $i <= 13; $i++) { ?>
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
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_CATEGORY_DESC; ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_CODE_CATEGORY_A3_DESC; ?></td>

                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN04); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN05); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN06); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN07); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN08); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN09); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN10); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN11); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN12); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN01); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN02); ?></td>
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN03); ?></td>
                                            
                                            <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_SUM); ?></td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                        <?php foreach ($detail_confirm_sum as $value) { ?>
                                        <tr>                                          
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd; color: #dddddd;"><?php echo $no; ?></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            <td style="font-weight: bold;text-align: right;background-color: #dddddd;">Total</td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN04); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN05); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN06); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN07); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN08); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN09); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN10); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN11); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN12); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN01); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN02); ?></td>
                                            <td style="font-weight: bold;vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN03); ?></td>
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
                leftColumns: 4
            }
        });
    });
</script>