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


<aside >

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <?php if ($detail_confirm <> null) { ?>
                        <div class="grid-body" style="padding-top: 0px">
                            <div id="table-luar">
                                <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No Budget</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Item Description</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Sub Category</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Category</th>                                                                                    
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Name of Category A3</th>  
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Category Product</th>                                          
                                            
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Purpose</th>
                                            
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Periode</th>                                               
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
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_NO_BUDGET; ?></td>
                                                <td style="vertical-align: middle;text-align:desc;"><?php echo $value->CHR_ITEM_DESC; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_CATEGORY_DESC; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_CODE_CATEGORY_A3_DESC; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_CATEGORY_PRODUCT_DESC; ?></td>
                                                
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PURPOSE; ?></td>
                                                
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PERIODE; ?></td>                                                
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
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
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

                        <?php } else { ?>
                            <div style="margin-top: 20px;height: 10px;"></div>
                            <div class="grid-body" style="padding-top: 0px">
                            </div>
                        <?php } ?>


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
                leftColumns: 3
            }
        });
    });
</script>