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
                    <div class="grid-body" style="padding-top: 0px;">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Calculation</th>
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
                                </thead>
                                <tbody>                                    
                                    <!-- =========== SALES PRODUCT ========= -->
                                    <?php
                                        $tot_sales_bln04 = 0;
                                        $tot_sales_bln05 = 0;
                                        $tot_sales_bln06 = 0;
                                        $tot_sales_bln07 = 0;
                                        $tot_sales_bln08 = 0;
                                        $tot_sales_bln09 = 0;
                                        $tot_sales_bln10 = 0;
                                        $tot_sales_bln11 = 0;
                                        $tot_sales_bln12 = 0;
                                        $tot_sales_bln01 = 0;
                                        $tot_sales_bln02 = 0;
                                        $tot_sales_bln03 = 0;
                                        $tot_sales_sum = 0;
                                        
                                        if($tot_sales_aii <> null){
                                            $tot_sales_bln04 = $tot_sales_aii->MON_AMT_BLN04;
                                            $tot_sales_bln05 = $tot_sales_aii->MON_AMT_BLN05;
                                            $tot_sales_bln06 = $tot_sales_aii->MON_AMT_BLN06;
                                            $tot_sales_bln07 = $tot_sales_aii->MON_AMT_BLN07;
                                            $tot_sales_bln08 = $tot_sales_aii->MON_AMT_BLN08;
                                            $tot_sales_bln09 = $tot_sales_aii->MON_AMT_BLN09;
                                            $tot_sales_bln10 = $tot_sales_aii->MON_AMT_BLN10;
                                            $tot_sales_bln11 = $tot_sales_aii->MON_AMT_BLN11;
                                            $tot_sales_bln12 = $tot_sales_aii->MON_AMT_BLN12;
                                            $tot_sales_bln01 = $tot_sales_aii->MON_AMT_BLN01;
                                            $tot_sales_bln02 = $tot_sales_aii->MON_AMT_BLN02;
                                            $tot_sales_bln03 = $tot_sales_aii->MON_AMT_BLN03;
                                            $tot_sales_sum = $tot_sales_aii->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">1</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total Sales Product AII</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_sales_sum); ?></td>
                                    </tr>
                                    <!-- ========== DIRECT MATERIAL ======== -->
                                    <?php
                                        $tot_dimat_bln04 = 0;
                                        $tot_dimat_bln05 = 0;
                                        $tot_dimat_bln06 = 0;
                                        $tot_dimat_bln07 = 0;
                                        $tot_dimat_bln08 = 0;
                                        $tot_dimat_bln09 = 0;
                                        $tot_dimat_bln10 = 0;
                                        $tot_dimat_bln11 = 0;
                                        $tot_dimat_bln12 = 0;
                                        $tot_dimat_bln01 = 0;
                                        $tot_dimat_bln02 = 0;
                                        $tot_dimat_bln03 = 0;
                                        $tot_dimat_sum = 0;
                                        
                                        if($tot_dimat_aii <> null){
                                            $tot_dimat_bln04 = $tot_dimat_aii->MON_AMT_BLN04;
                                            $tot_dimat_bln05 = $tot_dimat_aii->MON_AMT_BLN05;
                                            $tot_dimat_bln06 = $tot_dimat_aii->MON_AMT_BLN06;
                                            $tot_dimat_bln07 = $tot_dimat_aii->MON_AMT_BLN07;
                                            $tot_dimat_bln08 = $tot_dimat_aii->MON_AMT_BLN08;
                                            $tot_dimat_bln09 = $tot_dimat_aii->MON_AMT_BLN09;
                                            $tot_dimat_bln10 = $tot_dimat_aii->MON_AMT_BLN10;
                                            $tot_dimat_bln11 = $tot_dimat_aii->MON_AMT_BLN11;
                                            $tot_dimat_bln12 = $tot_dimat_aii->MON_AMT_BLN12;
                                            $tot_dimat_bln01 = $tot_dimat_aii->MON_AMT_BLN01;
                                            $tot_dimat_bln02 = $tot_dimat_aii->MON_AMT_BLN02;
                                            $tot_dimat_bln03 = $tot_dimat_aii->MON_AMT_BLN03;
                                            $tot_dimat_sum = $tot_dimat_aii->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">2</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total Direct Material</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_dimat_sum); ?></td>
                                    </tr>
                                    <!-- =========== DIRECT LABOR ========== -->
                                    <?php
                                        $tot_labor_bln04 = 0;
                                        $tot_labor_bln05 = 0;
                                        $tot_labor_bln06 = 0;
                                        $tot_labor_bln07 = 0;
                                        $tot_labor_bln08 = 0;
                                        $tot_labor_bln09 = 0;
                                        $tot_labor_bln10 = 0;
                                        $tot_labor_bln11 = 0;
                                        $tot_labor_bln12 = 0;
                                        $tot_labor_bln01 = 0;
                                        $tot_labor_bln02 = 0;
                                        $tot_labor_bln03 = 0;
                                        $tot_labor_sum = 0;
                                        
                                        if($tot_direct_labor <> null){
                                            $tot_labor_bln04 = $tot_direct_labor->MON_AMT_BLN04;
                                            $tot_labor_bln05 = $tot_direct_labor->MON_AMT_BLN05;
                                            $tot_labor_bln06 = $tot_direct_labor->MON_AMT_BLN06;
                                            $tot_labor_bln07 = $tot_direct_labor->MON_AMT_BLN07;
                                            $tot_labor_bln08 = $tot_direct_labor->MON_AMT_BLN08;
                                            $tot_labor_bln09 = $tot_direct_labor->MON_AMT_BLN09;
                                            $tot_labor_bln10 = $tot_direct_labor->MON_AMT_BLN10;
                                            $tot_labor_bln11 = $tot_direct_labor->MON_AMT_BLN11;
                                            $tot_labor_bln12 = $tot_direct_labor->MON_AMT_BLN12;
                                            $tot_labor_bln01 = $tot_direct_labor->MON_AMT_BLN01;
                                            $tot_labor_bln02 = $tot_direct_labor->MON_AMT_BLN02;
                                            $tot_labor_bln03 = $tot_direct_labor->MON_AMT_BLN03;
                                            $tot_labor_sum = $tot_direct_labor->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">3</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total Direct Labor</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_labor_sum); ?></td>
                                    </tr>
                                    <!-- ========= TOT DIRECT COST ========= -->
                                    <?php
                                        $tot_cost_bln04 = $tot_dimat_bln04 + $tot_labor_bln04;
                                        $tot_cost_bln05 = $tot_dimat_bln05 + $tot_labor_bln05;
                                        $tot_cost_bln06 = $tot_dimat_bln06 + $tot_labor_bln06;
                                        $tot_cost_bln07 = $tot_dimat_bln07 + $tot_labor_bln07;
                                        $tot_cost_bln08 = $tot_dimat_bln08 + $tot_labor_bln08;
                                        $tot_cost_bln09 = $tot_dimat_bln09 + $tot_labor_bln09;
                                        $tot_cost_bln10 = $tot_dimat_bln10 + $tot_labor_bln10;
                                        $tot_cost_bln11 = $tot_dimat_bln11 + $tot_labor_bln11;
                                        $tot_cost_bln12 = $tot_dimat_bln12 + $tot_labor_bln12;
                                        $tot_cost_bln01 = $tot_dimat_bln01 + $tot_labor_bln01;
                                        $tot_cost_bln02 = $tot_dimat_bln02 + $tot_labor_bln02;
                                        $tot_cost_bln03 = $tot_dimat_bln03 + $tot_labor_bln03;
                                        $tot_cost_sum = $tot_dimat_sum + $tot_labor_sum;  
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">4</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total Direct Cost</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cost_sum); ?></td>
                                    </tr>
                                    <!-- ============ TOTAL FOH ============ -->
                                    <?php
                                        $tot_foh_bln04 = 0;
                                        $tot_foh_bln05 = 0;
                                        $tot_foh_bln06 = 0;
                                        $tot_foh_bln07 = 0;
                                        $tot_foh_bln08 = 0;
                                        $tot_foh_bln09 = 0;
                                        $tot_foh_bln10 = 0;
                                        $tot_foh_bln11 = 0;
                                        $tot_foh_bln12 = 0;
                                        $tot_foh_bln01 = 0;
                                        $tot_foh_bln02 = 0;
                                        $tot_foh_bln03 = 0;
                                        $tot_foh_sum = 0;
                                        
                                        if($tot_foh <> null){
                                            $tot_foh_bln04 = $tot_foh->MON_AMT_BLN04;
                                            $tot_foh_bln05 = $tot_foh->MON_AMT_BLN05;
                                            $tot_foh_bln06 = $tot_foh->MON_AMT_BLN06;
                                            $tot_foh_bln07 = $tot_foh->MON_AMT_BLN07;
                                            $tot_foh_bln08 = $tot_foh->MON_AMT_BLN08;
                                            $tot_foh_bln09 = $tot_foh->MON_AMT_BLN09;
                                            $tot_foh_bln10 = $tot_foh->MON_AMT_BLN10;
                                            $tot_foh_bln11 = $tot_foh->MON_AMT_BLN11;
                                            $tot_foh_bln12 = $tot_foh->MON_AMT_BLN12;
                                            $tot_foh_bln01 = $tot_foh->MON_AMT_BLN01;
                                            $tot_foh_bln02 = $tot_foh->MON_AMT_BLN02;
                                            $tot_foh_bln03 = $tot_foh->MON_AMT_BLN03;
                                            $tot_foh_sum = $tot_foh->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">5</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total FOH</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_foh_sum); ?></td>
                                    </tr>
                                    <!-- ============ COGS ============ -->
                                    <?php
                                        $tot_cogs_bln04 = $tot_cost_bln04 + $tot_foh_bln04;
                                        $tot_cogs_bln05 = $tot_cost_bln05 + $tot_foh_bln05;
                                        $tot_cogs_bln06 = $tot_cost_bln06 + $tot_foh_bln06;
                                        $tot_cogs_bln07 = $tot_cost_bln07 + $tot_foh_bln07;
                                        $tot_cogs_bln08 = $tot_cost_bln08 + $tot_foh_bln08;
                                        $tot_cogs_bln09 = $tot_cost_bln09 + $tot_foh_bln09;
                                        $tot_cogs_bln10 = $tot_cost_bln10 + $tot_foh_bln10;
                                        $tot_cogs_bln11 = $tot_cost_bln11 + $tot_foh_bln11;
                                        $tot_cogs_bln12 = $tot_cost_bln12 + $tot_foh_bln12;
                                        $tot_cogs_bln01 = $tot_cost_bln01 + $tot_foh_bln01;
                                        $tot_cogs_bln02 = $tot_cost_bln02 + $tot_foh_bln02;
                                        $tot_cogs_bln03 = $tot_cost_bln03 + $tot_foh_bln03;
                                        $tot_cogs_sum = $tot_cost_sum + $tot_foh_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">6</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total COGS</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_cogs_sum); ?></td>
                                    </tr>
                                    <!-- ========== GROSS PROFIT =========== -->
                                    <?php
                                        $tot_gross_bln04 = $tot_sales_bln04 - $tot_cogs_bln04;
                                        $tot_gross_bln05 = $tot_sales_bln05 - $tot_cogs_bln05;
                                        $tot_gross_bln06 = $tot_sales_bln06 - $tot_cogs_bln06;
                                        $tot_gross_bln07 = $tot_sales_bln07 - $tot_cogs_bln07;
                                        $tot_gross_bln08 = $tot_sales_bln08 - $tot_cogs_bln08;
                                        $tot_gross_bln09 = $tot_sales_bln09 - $tot_cogs_bln09;
                                        $tot_gross_bln10 = $tot_sales_bln10 - $tot_cogs_bln10;
                                        $tot_gross_bln11 = $tot_sales_bln11 - $tot_cogs_bln11;
                                        $tot_gross_bln12 = $tot_sales_bln12 - $tot_cogs_bln12;
                                        $tot_gross_bln01 = $tot_sales_bln01 - $tot_cogs_bln01;
                                        $tot_gross_bln02 = $tot_sales_bln02 - $tot_cogs_bln02;
                                        $tot_gross_bln03 = $tot_sales_bln03 - $tot_cogs_bln03;
                                        $tot_gross_sum = $tot_sales_sum - $tot_cogs_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">7</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total Gross Profit</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_gross_sum); ?></td>
                                    </tr>
                                    <!-- ============ TOTAL OPEX ============ -->
                                    <?php
                                        $tot_opx_bln04 = 0;
                                        $tot_opx_bln05 = 0;
                                        $tot_opx_bln06 = 0;
                                        $tot_opx_bln07 = 0;
                                        $tot_opx_bln08 = 0;
                                        $tot_opx_bln09 = 0;
                                        $tot_opx_bln10 = 0;
                                        $tot_opx_bln11 = 0;
                                        $tot_opx_bln12 = 0;
                                        $tot_opx_bln01 = 0;
                                        $tot_opx_bln02 = 0;
                                        $tot_opx_bln03 = 0;
                                        $tot_opx_sum = 0;
                                        
                                        if($tot_opx <> null){
                                            $tot_opx_bln04 = $tot_opx->MON_AMT_BLN04;
                                            $tot_opx_bln05 = $tot_opx->MON_AMT_BLN05;
                                            $tot_opx_bln06 = $tot_opx->MON_AMT_BLN06;
                                            $tot_opx_bln07 = $tot_opx->MON_AMT_BLN07;
                                            $tot_opx_bln08 = $tot_opx->MON_AMT_BLN08;
                                            $tot_opx_bln09 = $tot_opx->MON_AMT_BLN09;
                                            $tot_opx_bln10 = $tot_opx->MON_AMT_BLN10;
                                            $tot_opx_bln11 = $tot_opx->MON_AMT_BLN11;
                                            $tot_opx_bln12 = $tot_opx->MON_AMT_BLN12;
                                            $tot_opx_bln01 = $tot_opx->MON_AMT_BLN01;
                                            $tot_opx_bln02 = $tot_opx->MON_AMT_BLN02;
                                            $tot_opx_bln03 = $tot_opx->MON_AMT_BLN03;
                                            $tot_opx_sum = $tot_opx->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">8</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPEX</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opx_sum); ?></td>
                                    </tr>
                                    <!-- ========== OPIN PRODUCT AII =========== -->
                                    <?php
                                        $tot_opin_product_aii_bln04 = $tot_gross_bln04 - $tot_opx_bln04;
                                        $tot_opin_product_aii_bln05 = $tot_gross_bln05 - $tot_opx_bln05;
                                        $tot_opin_product_aii_bln06 = $tot_gross_bln06 - $tot_opx_bln06;
                                        $tot_opin_product_aii_bln07 = $tot_gross_bln07 - $tot_opx_bln07;
                                        $tot_opin_product_aii_bln08 = $tot_gross_bln08 - $tot_opx_bln08;
                                        $tot_opin_product_aii_bln09 = $tot_gross_bln09 - $tot_opx_bln09;
                                        $tot_opin_product_aii_bln10 = $tot_gross_bln10 - $tot_opx_bln10;
                                        $tot_opin_product_aii_bln11 = $tot_gross_bln11 - $tot_opx_bln11;
                                        $tot_opin_product_aii_bln12 = $tot_gross_bln12 - $tot_opx_bln12;
                                        $tot_opin_product_aii_bln01 = $tot_gross_bln01 - $tot_opx_bln01;
                                        $tot_opin_product_aii_bln02 = $tot_gross_bln02 - $tot_opx_bln02;
                                        $tot_opin_product_aii_bln03 = $tot_gross_bln03 - $tot_opx_bln03;
                                        $tot_opin_product_aii_sum = $tot_gross_sum - $tot_opx_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">9</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN_Product_AII</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_sum); ?></td>
                                    </tr>
                                    <!-- ========== OPIN PRODUCT AII + OTHER INCOME =========== -->
                                    <?php
                                        if($tot_other_income <> null){
                                            $tot_opin_product_aii_bln04 = $tot_opin_product_aii_bln04 + $tot_other_income->MON_AMT_BLN04;;
                                            $tot_opin_product_aii_bln05 = $tot_opin_product_aii_bln05 + $tot_other_income->MON_AMT_BLN05;;
                                            $tot_opin_product_aii_bln06 = $tot_opin_product_aii_bln06 + $tot_other_income->MON_AMT_BLN06;;
                                            $tot_opin_product_aii_bln07 = $tot_opin_product_aii_bln07 + $tot_other_income->MON_AMT_BLN07;;
                                            $tot_opin_product_aii_bln08 = $tot_opin_product_aii_bln08 + $tot_other_income->MON_AMT_BLN08;;
                                            $tot_opin_product_aii_bln09 = $tot_opin_product_aii_bln09 + $tot_other_income->MON_AMT_BLN09;;
                                            $tot_opin_product_aii_bln10 = $tot_opin_product_aii_bln10 + $tot_other_income->MON_AMT_BLN10;;
                                            $tot_opin_product_aii_bln11 = $tot_opin_product_aii_bln11 + $tot_other_income->MON_AMT_BLN11;;
                                            $tot_opin_product_aii_bln12 = $tot_opin_product_aii_bln12 + $tot_other_income->MON_AMT_BLN12;;
                                            $tot_opin_product_aii_bln01 = $tot_opin_product_aii_bln01 + $tot_other_income->MON_AMT_BLN01;;
                                            $tot_opin_product_aii_bln02 = $tot_opin_product_aii_bln02 + $tot_other_income->MON_AMT_BLN02;;
                                            $tot_opin_product_aii_bln03 = $tot_opin_product_aii_bln03 + $tot_other_income->MON_AMT_BLN03;;
                                            $tot_opin_product_aii_sum = $tot_opin_product_aii_sum + $tot_other_income->MON_AMT_SUM;;
                                        }                                        
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">10</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN_Product_AII + Other Income</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_sum); ?></td>
                                    </tr>
                                    <!-- ============ OPIN TOOLING AII ============ -->
                                    <?php
                                        $tot_opin_tooling_aii_bln04 = 0;
                                        $tot_opin_tooling_aii_bln05 = 0;
                                        $tot_opin_tooling_aii_bln06 = 0;
                                        $tot_opin_tooling_aii_bln07 = 0;
                                        $tot_opin_tooling_aii_bln08 = 0;
                                        $tot_opin_tooling_aii_bln09 = 0;
                                        $tot_opin_tooling_aii_bln10 = 0;
                                        $tot_opin_tooling_aii_bln11 = 0;
                                        $tot_opin_tooling_aii_bln12 = 0;
                                        $tot_opin_tooling_aii_bln01 = 0;
                                        $tot_opin_tooling_aii_bln02 = 0;
                                        $tot_opin_tooling_aii_bln03 = 0;
                                        $tot_opin_tooling_aii_sum = 0;
                                        
                                        if($tot_opin_tooling_aii <> null){
                                            $tot_opin_tooling_aii_bln04 = $tot_opin_tooling_aii->MON_AMT_BLN04;
                                            $tot_opin_tooling_aii_bln05 = $tot_opin_tooling_aii->MON_AMT_BLN05;
                                            $tot_opin_tooling_aii_bln06 = $tot_opin_tooling_aii->MON_AMT_BLN06;
                                            $tot_opin_tooling_aii_bln07 = $tot_opin_tooling_aii->MON_AMT_BLN07;
                                            $tot_opin_tooling_aii_bln08 = $tot_opin_tooling_aii->MON_AMT_BLN08;
                                            $tot_opin_tooling_aii_bln09 = $tot_opin_tooling_aii->MON_AMT_BLN09;
                                            $tot_opin_tooling_aii_bln10 = $tot_opin_tooling_aii->MON_AMT_BLN10;
                                            $tot_opin_tooling_aii_bln11 = $tot_opin_tooling_aii->MON_AMT_BLN11;
                                            $tot_opin_tooling_aii_bln12 = $tot_opin_tooling_aii->MON_AMT_BLN12;
                                            $tot_opin_tooling_aii_bln01 = $tot_opin_tooling_aii->MON_AMT_BLN01;
                                            $tot_opin_tooling_aii_bln02 = $tot_opin_tooling_aii->MON_AMT_BLN02;
                                            $tot_opin_tooling_aii_bln03 = $tot_opin_tooling_aii->MON_AMT_BLN03;
                                            $tot_opin_tooling_aii_sum = $tot_opin_tooling_aii->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">11</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN Tooling AII</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aii_sum); ?></td>
                                    </tr>
                                    <!-- ========== OPIN PRODUCT AII + TOOLING AII =========== -->
                                    <?php
                                        $tot_opin_product_aii_bln04 = $tot_opin_product_aii_bln04 + $tot_opin_tooling_aii_bln04;
                                        $tot_opin_product_aii_bln05 = $tot_opin_product_aii_bln05 + $tot_opin_tooling_aii_bln05;
                                        $tot_opin_product_aii_bln06 = $tot_opin_product_aii_bln06 + $tot_opin_tooling_aii_bln06;
                                        $tot_opin_product_aii_bln07 = $tot_opin_product_aii_bln07 + $tot_opin_tooling_aii_bln07;
                                        $tot_opin_product_aii_bln08 = $tot_opin_product_aii_bln08 + $tot_opin_tooling_aii_bln08;
                                        $tot_opin_product_aii_bln09 = $tot_opin_product_aii_bln09 + $tot_opin_tooling_aii_bln09;
                                        $tot_opin_product_aii_bln10 = $tot_opin_product_aii_bln10 + $tot_opin_tooling_aii_bln10;
                                        $tot_opin_product_aii_bln11 = $tot_opin_product_aii_bln11 + $tot_opin_tooling_aii_bln11;
                                        $tot_opin_product_aii_bln12 = $tot_opin_product_aii_bln12 + $tot_opin_tooling_aii_bln12;
                                        $tot_opin_product_aii_bln01 = $tot_opin_product_aii_bln01 + $tot_opin_tooling_aii_bln01;
                                        $tot_opin_product_aii_bln02 = $tot_opin_product_aii_bln02 + $tot_opin_tooling_aii_bln02;
                                        $tot_opin_product_aii_bln03 = $tot_opin_product_aii_bln03 + $tot_opin_tooling_aii_bln03;
                                        $tot_opin_product_aii_sum = $tot_opin_product_aii_sum + $tot_opin_tooling_aii_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">12</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN_Product + Tooling_AII</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_sum); ?></td>
                                    </tr>
                                    <!-- ============ OPIN PASSTHRU AIIA ============ -->
                                    <?php
                                        $tot_opin_passthru_aiia_bln04 = 0;
                                        $tot_opin_passthru_aiia_bln05 = 0;
                                        $tot_opin_passthru_aiia_bln06 = 0;
                                        $tot_opin_passthru_aiia_bln07 = 0;
                                        $tot_opin_passthru_aiia_bln08 = 0;
                                        $tot_opin_passthru_aiia_bln09 = 0;
                                        $tot_opin_passthru_aiia_bln10 = 0;
                                        $tot_opin_passthru_aiia_bln11 = 0;
                                        $tot_opin_passthru_aiia_bln12 = 0;
                                        $tot_opin_passthru_aiia_bln01 = 0;
                                        $tot_opin_passthru_aiia_bln02 = 0;
                                        $tot_opin_passthru_aiia_bln03 = 0;
                                        $tot_opin_passthru_aiia_sum = 0;
                                        
                                        if($tot_opin_passthru_aiia <> null){
                                            $tot_opin_passthru_aiia_bln04 = $tot_opin_passthru_aiia->MON_AMT_BLN04;
                                            $tot_opin_passthru_aiia_bln05 = $tot_opin_passthru_aiia->MON_AMT_BLN05;
                                            $tot_opin_passthru_aiia_bln06 = $tot_opin_passthru_aiia->MON_AMT_BLN06;
                                            $tot_opin_passthru_aiia_bln07 = $tot_opin_passthru_aiia->MON_AMT_BLN07;
                                            $tot_opin_passthru_aiia_bln08 = $tot_opin_passthru_aiia->MON_AMT_BLN08;
                                            $tot_opin_passthru_aiia_bln09 = $tot_opin_passthru_aiia->MON_AMT_BLN09;
                                            $tot_opin_passthru_aiia_bln10 = $tot_opin_passthru_aiia->MON_AMT_BLN10;
                                            $tot_opin_passthru_aiia_bln11 = $tot_opin_passthru_aiia->MON_AMT_BLN11;
                                            $tot_opin_passthru_aiia_bln12 = $tot_opin_passthru_aiia->MON_AMT_BLN12;
                                            $tot_opin_passthru_aiia_bln01 = $tot_opin_passthru_aiia->MON_AMT_BLN01;
                                            $tot_opin_passthru_aiia_bln02 = $tot_opin_passthru_aiia->MON_AMT_BLN02;
                                            $tot_opin_passthru_aiia_bln03 = $tot_opin_passthru_aiia->MON_AMT_BLN03;
                                            $tot_opin_passthru_aiia_sum = $tot_opin_passthru_aiia->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">13</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN Passthru AIIA</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_passthru_aiia_sum); ?></td>
                                    </tr>
                                    <!-- ========== OPIN PRODUCT AII + TOOLING AII + PASSTHRU AIIA =========== -->
                                    <?php
                                        $tot_opin_product_aii_bln04 = $tot_opin_product_aii_bln04 + $tot_opin_passthru_aiia_bln04;
                                        $tot_opin_product_aii_bln05 = $tot_opin_product_aii_bln05 + $tot_opin_passthru_aiia_bln05;
                                        $tot_opin_product_aii_bln06 = $tot_opin_product_aii_bln06 + $tot_opin_passthru_aiia_bln06;
                                        $tot_opin_product_aii_bln07 = $tot_opin_product_aii_bln07 + $tot_opin_passthru_aiia_bln07;
                                        $tot_opin_product_aii_bln08 = $tot_opin_product_aii_bln08 + $tot_opin_passthru_aiia_bln08;
                                        $tot_opin_product_aii_bln09 = $tot_opin_product_aii_bln09 + $tot_opin_passthru_aiia_bln09;
                                        $tot_opin_product_aii_bln10 = $tot_opin_product_aii_bln10 + $tot_opin_passthru_aiia_bln10;
                                        $tot_opin_product_aii_bln11 = $tot_opin_product_aii_bln11 + $tot_opin_passthru_aiia_bln11;
                                        $tot_opin_product_aii_bln12 = $tot_opin_product_aii_bln12 + $tot_opin_passthru_aiia_bln12;
                                        $tot_opin_product_aii_bln01 = $tot_opin_product_aii_bln01 + $tot_opin_passthru_aiia_bln01;
                                        $tot_opin_product_aii_bln02 = $tot_opin_product_aii_bln02 + $tot_opin_passthru_aiia_bln02;
                                        $tot_opin_product_aii_bln03 = $tot_opin_product_aii_bln03 + $tot_opin_passthru_aiia_bln03;
                                        $tot_opin_product_aii_sum = $tot_opin_product_aii_sum + $tot_opin_passthru_aiia_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">14</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN_Product AII + Tooling_AII + Passthru AIIA</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_sum); ?></td>
                                    </tr>
                                    <!-- ============ OPIN TOOLING AIIA ============ -->
                                    <?php
                                        $tot_opin_tooling_aiia_bln04 = 0;
                                        $tot_opin_tooling_aiia_bln05 = 0;
                                        $tot_opin_tooling_aiia_bln06 = 0;
                                        $tot_opin_tooling_aiia_bln07 = 0;
                                        $tot_opin_tooling_aiia_bln08 = 0;
                                        $tot_opin_tooling_aiia_bln09 = 0;
                                        $tot_opin_tooling_aiia_bln10 = 0;
                                        $tot_opin_tooling_aiia_bln11 = 0;
                                        $tot_opin_tooling_aiia_bln12 = 0;
                                        $tot_opin_tooling_aiia_bln01 = 0;
                                        $tot_opin_tooling_aiia_bln02 = 0;
                                        $tot_opin_tooling_aiia_bln03 = 0;
                                        $tot_opin_tooling_aiia_sum = 0;
                                        
                                        if($tot_opin_tooling_aiia <> null){
                                            $tot_opin_tooling_aiia_bln04 = $tot_opin_tooling_aiia->MON_AMT_BLN04;
                                            $tot_opin_tooling_aiia_bln05 = $tot_opin_tooling_aiia->MON_AMT_BLN05;
                                            $tot_opin_tooling_aiia_bln06 = $tot_opin_tooling_aiia->MON_AMT_BLN06;
                                            $tot_opin_tooling_aiia_bln07 = $tot_opin_tooling_aiia->MON_AMT_BLN07;
                                            $tot_opin_tooling_aiia_bln08 = $tot_opin_tooling_aiia->MON_AMT_BLN08;
                                            $tot_opin_tooling_aiia_bln09 = $tot_opin_tooling_aiia->MON_AMT_BLN09;
                                            $tot_opin_tooling_aiia_bln10 = $tot_opin_tooling_aiia->MON_AMT_BLN10;
                                            $tot_opin_tooling_aiia_bln11 = $tot_opin_tooling_aiia->MON_AMT_BLN11;
                                            $tot_opin_tooling_aiia_bln12 = $tot_opin_tooling_aiia->MON_AMT_BLN12;
                                            $tot_opin_tooling_aiia_bln01 = $tot_opin_tooling_aiia->MON_AMT_BLN01;
                                            $tot_opin_tooling_aiia_bln02 = $tot_opin_tooling_aiia->MON_AMT_BLN02;
                                            $tot_opin_tooling_aiia_bln03 = $tot_opin_tooling_aiia->MON_AMT_BLN03;
                                            $tot_opin_tooling_aiia_sum = $tot_opin_tooling_aiia->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">15</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN Tooling AIIA</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_tooling_aiia_sum); ?></td>
                                    </tr>
                                    <!-- ========== OPIN PRODUCT AII + TOOLING AII + PASSTHRU AIIA + TOOLING AIIA =========== -->
                                    <?php
                                        $tot_opin_product_aii_bln04 = $tot_opin_product_aii_bln04 + $tot_opin_passthru_aiia_bln04 + $tot_opin_tooling_aiia_bln04;
                                        $tot_opin_product_aii_bln05 = $tot_opin_product_aii_bln05 + $tot_opin_passthru_aiia_bln05 + $tot_opin_tooling_aiia_bln05;
                                        $tot_opin_product_aii_bln06 = $tot_opin_product_aii_bln06 + $tot_opin_passthru_aiia_bln06 + $tot_opin_tooling_aiia_bln06;
                                        $tot_opin_product_aii_bln07 = $tot_opin_product_aii_bln07 + $tot_opin_passthru_aiia_bln07 + $tot_opin_tooling_aiia_bln07;
                                        $tot_opin_product_aii_bln08 = $tot_opin_product_aii_bln08 + $tot_opin_passthru_aiia_bln08 + $tot_opin_tooling_aiia_bln08;
                                        $tot_opin_product_aii_bln09 = $tot_opin_product_aii_bln09 + $tot_opin_passthru_aiia_bln09 + $tot_opin_tooling_aiia_bln09;
                                        $tot_opin_product_aii_bln10 = $tot_opin_product_aii_bln10 + $tot_opin_passthru_aiia_bln10 + $tot_opin_tooling_aiia_bln10;
                                        $tot_opin_product_aii_bln11 = $tot_opin_product_aii_bln11 + $tot_opin_passthru_aiia_bln11 + $tot_opin_tooling_aiia_bln11;
                                        $tot_opin_product_aii_bln12 = $tot_opin_product_aii_bln12 + $tot_opin_passthru_aiia_bln12 + $tot_opin_tooling_aiia_bln12;
                                        $tot_opin_product_aii_bln01 = $tot_opin_product_aii_bln01 + $tot_opin_passthru_aiia_bln01 + $tot_opin_tooling_aiia_bln01;
                                        $tot_opin_product_aii_bln02 = $tot_opin_product_aii_bln02 + $tot_opin_passthru_aiia_bln02 + $tot_opin_tooling_aiia_bln02;
                                        $tot_opin_product_aii_bln03 = $tot_opin_product_aii_bln03 + $tot_opin_passthru_aiia_bln03 + $tot_opin_tooling_aiia_bln03;
                                        $tot_opin_product_aii_sum = $tot_opin_product_aii_sum + $tot_opin_passthru_aiia_sum + $tot_opin_tooling_aiia_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">16</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total OPIN_Product AII + Tooling_AII + Passthru AIIA + Tooling AIIA</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_sum); ?></td>
                                    </tr>
                                    <!-- ============ TOTAL NOPIN ============ -->
                                    <?php
                                        $tot_nopin_bln04 = 0;
                                        $tot_nopin_bln05 = 0;
                                        $tot_nopin_bln06 = 0;
                                        $tot_nopin_bln07 = 0;
                                        $tot_nopin_bln08 = 0;
                                        $tot_nopin_bln09 = 0;
                                        $tot_nopin_bln10 = 0;
                                        $tot_nopin_bln11 = 0;
                                        $tot_nopin_bln12 = 0;
                                        $tot_nopin_bln01 = 0;
                                        $tot_nopin_bln02 = 0;
                                        $tot_nopin_bln03 = 0;
                                        $tot_nopin_sum = 0;
                                        
                                        if($tot_nopin <> null){
                                            $tot_nopin_bln04 = $tot_nopin->MON_AMT_BLN04;
                                            $tot_nopin_bln05 = $tot_nopin->MON_AMT_BLN05;
                                            $tot_nopin_bln06 = $tot_nopin->MON_AMT_BLN06;
                                            $tot_nopin_bln07 = $tot_nopin->MON_AMT_BLN07;
                                            $tot_nopin_bln08 = $tot_nopin->MON_AMT_BLN08;
                                            $tot_nopin_bln09 = $tot_nopin->MON_AMT_BLN09;
                                            $tot_nopin_bln10 = $tot_nopin->MON_AMT_BLN10;
                                            $tot_nopin_bln11 = $tot_nopin->MON_AMT_BLN11;
                                            $tot_nopin_bln12 = $tot_nopin->MON_AMT_BLN12;
                                            $tot_nopin_bln01 = $tot_nopin->MON_AMT_BLN01;
                                            $tot_nopin_bln02 = $tot_nopin->MON_AMT_BLN02;
                                            $tot_nopin_bln03 = $tot_nopin->MON_AMT_BLN03;
                                            $tot_nopin_sum = $tot_nopin->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">17</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total Non Operating Income</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_nopin_sum); ?></td>
                                    </tr>
                                    <!-- ========== IBIT =========== -->
                                    <?php
                                        $tot_opin_product_aii_bln04 = $tot_opin_product_aii_bln04 + $tot_opin_passthru_aiia_bln04 + $tot_opin_tooling_aiia_bln04 + $tot_nopin_bln04;
                                        $tot_opin_product_aii_bln05 = $tot_opin_product_aii_bln05 + $tot_opin_passthru_aiia_bln05 + $tot_opin_tooling_aiia_bln05 + $tot_nopin_bln05;
                                        $tot_opin_product_aii_bln06 = $tot_opin_product_aii_bln06 + $tot_opin_passthru_aiia_bln06 + $tot_opin_tooling_aiia_bln06 + $tot_nopin_bln06;
                                        $tot_opin_product_aii_bln07 = $tot_opin_product_aii_bln07 + $tot_opin_passthru_aiia_bln07 + $tot_opin_tooling_aiia_bln07 + $tot_nopin_bln07;
                                        $tot_opin_product_aii_bln08 = $tot_opin_product_aii_bln08 + $tot_opin_passthru_aiia_bln08 + $tot_opin_tooling_aiia_bln08 + $tot_nopin_bln08;
                                        $tot_opin_product_aii_bln09 = $tot_opin_product_aii_bln09 + $tot_opin_passthru_aiia_bln09 + $tot_opin_tooling_aiia_bln09 + $tot_nopin_bln09;
                                        $tot_opin_product_aii_bln10 = $tot_opin_product_aii_bln10 + $tot_opin_passthru_aiia_bln10 + $tot_opin_tooling_aiia_bln10 + $tot_nopin_bln10;
                                        $tot_opin_product_aii_bln11 = $tot_opin_product_aii_bln11 + $tot_opin_passthru_aiia_bln11 + $tot_opin_tooling_aiia_bln11 + $tot_nopin_bln11;
                                        $tot_opin_product_aii_bln12 = $tot_opin_product_aii_bln12 + $tot_opin_passthru_aiia_bln12 + $tot_opin_tooling_aiia_bln12 + $tot_nopin_bln12;
                                        $tot_opin_product_aii_bln01 = $tot_opin_product_aii_bln01 + $tot_opin_passthru_aiia_bln01 + $tot_opin_tooling_aiia_bln01 + $tot_nopin_bln01;
                                        $tot_opin_product_aii_bln02 = $tot_opin_product_aii_bln02 + $tot_opin_passthru_aiia_bln02 + $tot_opin_tooling_aiia_bln02 + $tot_nopin_bln02;
                                        $tot_opin_product_aii_bln03 = $tot_opin_product_aii_bln03 + $tot_opin_passthru_aiia_bln03 + $tot_opin_tooling_aiia_bln03 + $tot_nopin_bln03;
                                        $tot_opin_product_aii_sum = $tot_opin_product_aii_sum + $tot_opin_passthru_aiia_sum + $tot_opin_tooling_aiia_sum + $tot_nopin_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">18</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total IBIT</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_sum); ?></td>
                                    </tr>
                                    <!-- ============ TOTAL TAX ============ -->
                                    <?php
                                        $tot_tax_bln04 = 0;
                                        $tot_tax_bln05 = 0;
                                        $tot_tax_bln06 = 0;
                                        $tot_tax_bln07 = 0;
                                        $tot_tax_bln08 = 0;
                                        $tot_tax_bln09 = 0;
                                        $tot_tax_bln10 = 0;
                                        $tot_tax_bln11 = 0;
                                        $tot_tax_bln12 = 0;
                                        $tot_tax_bln01 = 0;
                                        $tot_tax_bln02 = 0;
                                        $tot_tax_bln03 = 0;
                                        $tot_tax_sum = 0;
                                        
                                        if($tot_tax <> null){
                                            $tot_tax_bln04 = $tot_tax->MON_AMT_BLN04;
                                            $tot_tax_bln05 = $tot_tax->MON_AMT_BLN05;
                                            $tot_tax_bln06 = $tot_tax->MON_AMT_BLN06;
                                            $tot_tax_bln07 = $tot_tax->MON_AMT_BLN07;
                                            $tot_tax_bln08 = $tot_tax->MON_AMT_BLN08;
                                            $tot_tax_bln09 = $tot_tax->MON_AMT_BLN09;
                                            $tot_tax_bln10 = $tot_tax->MON_AMT_BLN10;
                                            $tot_tax_bln11 = $tot_tax->MON_AMT_BLN11;
                                            $tot_tax_bln12 = $tot_tax->MON_AMT_BLN12;
                                            $tot_tax_bln01 = $tot_tax->MON_AMT_BLN01;
                                            $tot_tax_bln02 = $tot_tax->MON_AMT_BLN02;
                                            $tot_tax_bln03 = $tot_tax->MON_AMT_BLN03;
                                            $tot_tax_sum = $tot_tax->MON_AMT_SUM;
                                        }
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">19</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total Tax</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_tax_sum); ?></td>
                                    </tr>
                                    <!-- ========== NPAT =========== -->
                                    <?php
                                        $tot_opin_product_aii_bln04 = $tot_opin_product_aii_bln04 + $tot_opin_passthru_aiia_bln04 + $tot_opin_tooling_aiia_bln04 + $tot_nopin_bln04 + $tot_tax_bln04;
                                        $tot_opin_product_aii_bln05 = $tot_opin_product_aii_bln05 + $tot_opin_passthru_aiia_bln05 + $tot_opin_tooling_aiia_bln05 + $tot_nopin_bln05 + $tot_tax_bln05;
                                        $tot_opin_product_aii_bln06 = $tot_opin_product_aii_bln06 + $tot_opin_passthru_aiia_bln06 + $tot_opin_tooling_aiia_bln06 + $tot_nopin_bln06 + $tot_tax_bln06;
                                        $tot_opin_product_aii_bln07 = $tot_opin_product_aii_bln07 + $tot_opin_passthru_aiia_bln07 + $tot_opin_tooling_aiia_bln07 + $tot_nopin_bln07 + $tot_tax_bln07;
                                        $tot_opin_product_aii_bln08 = $tot_opin_product_aii_bln08 + $tot_opin_passthru_aiia_bln08 + $tot_opin_tooling_aiia_bln08 + $tot_nopin_bln08 + $tot_tax_bln08;
                                        $tot_opin_product_aii_bln09 = $tot_opin_product_aii_bln09 + $tot_opin_passthru_aiia_bln09 + $tot_opin_tooling_aiia_bln09 + $tot_nopin_bln09 + $tot_tax_bln09;
                                        $tot_opin_product_aii_bln10 = $tot_opin_product_aii_bln10 + $tot_opin_passthru_aiia_bln10 + $tot_opin_tooling_aiia_bln10 + $tot_nopin_bln10 + $tot_tax_bln10;
                                        $tot_opin_product_aii_bln11 = $tot_opin_product_aii_bln11 + $tot_opin_passthru_aiia_bln11 + $tot_opin_tooling_aiia_bln11 + $tot_nopin_bln11 + $tot_tax_bln11;
                                        $tot_opin_product_aii_bln12 = $tot_opin_product_aii_bln12 + $tot_opin_passthru_aiia_bln12 + $tot_opin_tooling_aiia_bln12 + $tot_nopin_bln12 + $tot_tax_bln12;
                                        $tot_opin_product_aii_bln01 = $tot_opin_product_aii_bln01 + $tot_opin_passthru_aiia_bln01 + $tot_opin_tooling_aiia_bln01 + $tot_nopin_bln01 + $tot_tax_bln01;
                                        $tot_opin_product_aii_bln02 = $tot_opin_product_aii_bln02 + $tot_opin_passthru_aiia_bln02 + $tot_opin_tooling_aiia_bln02 + $tot_nopin_bln02 + $tot_tax_bln02;
                                        $tot_opin_product_aii_bln03 = $tot_opin_product_aii_bln03 + $tot_opin_passthru_aiia_bln03 + $tot_opin_tooling_aiia_bln03 + $tot_nopin_bln03 + $tot_tax_bln03;
                                        $tot_opin_product_aii_sum = $tot_opin_product_aii_sum + $tot_opin_passthru_aiia_sum + $tot_opin_tooling_aiia_sum + $tot_nopin_sum + $tot_tax_sum;
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">20</td>
                                        <td style="vertical-align: middle;text-align:left;font-weight: bold;">Total NPAT</td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln04); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln05); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln06); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln07); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln08); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln09); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln10); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln11); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln12); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln01); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln02); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_bln03); ?></td>
                                        <td style="vertical-align: middle;text-align:center;"><?php echo number_format($tot_opin_product_aii_sum); ?></td>
                                    </tr>
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
            scrollY: "700px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>