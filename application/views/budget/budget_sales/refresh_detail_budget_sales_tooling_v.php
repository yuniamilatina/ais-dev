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
            <?php if ($sub_category <> null) { ?>
            <div class="col-md-12">
                <div class="grid">                    
                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>                                        
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Sub Category</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Project Name</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Customer Name</th>

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
                                        
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Approve Man</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Approve GM</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Approve Dir</th>
                                    </tr>
                                    <tr>
                                            <?php for ($i = 1; $i <= 13; $i++) { ?>
                                                <th>Amt</th>
                                            <?php } ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php                                        
                                        foreach ($sub_category as $value) {
                                            $detail_budget = $this->db->query("SELECT CHR_BUDGET_SUB_CATEGORY_DESC, CHR_PROJECT_NAME, CHR_CUSTOMER_NAME, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                                                    FROM CPL.TT_BUDGET_SALES
                                                                    WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_BUDGET_SUB_CATEGORY = '$value->CHR_BUDGET_SUB_CATEGORY')
                                                                    GROUP BY CHR_BUDGET_SUB_CATEGORY_DESC, CHR_PROJECT_NAME, CHR_CUSTOMER_NAME, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
                                            
                                            $sum_bln04 = 0;
                                            $sum_bln05 = 0;
                                            $sum_bln06 = 0;
                                            $sum_bln07 = 0;
                                            $sum_bln08 = 0;
                                            $sum_bln09 = 0;
                                            $sum_bln10 = 0;
                                            $sum_bln11 = 0;
                                            $sum_bln12 = 0;
                                            $sum_bln01 = 0;
                                            $sum_bln02 = 0;
                                            $sum_bln03 = 0;
                                            $sum_all = 0;
                                            
                                            foreach($detail_budget as $data){
                                                echo '<tr>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . $data->CHR_BUDGET_SUB_CATEGORY_DESC . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . $data->CHR_PROJECT_NAME . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . $data->CHR_CUSTOMER_NAME . '</td>';
                                                
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN04) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN05) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN06) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN07) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN08) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN09) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN10) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN11) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN12) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN01) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN02) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_BLN03) . '</td>';
                                                echo '<td style="vertical-align: middle;text-align:center;">' . number_format($data->MON_AMT_SUM) . '</td>';
                                                
                                                if($data->CHR_FLAG_APP_MAN == 1){                                                            
                                                    echo '<td style="vertical-align: middle;text-align:center;"><img src="' . base_url() . '/assets/img/check1.png" width="25">';
                                                } else {
                                                    echo '<td style="vertical-align: middle;text-align:center;"><img src="' . base_url() . '/assets/img/error1.png" width="25">';
                                                } 
                                                        
                                                if($data->CHR_FLAG_APP_GM == 1){                                                            
                                                    echo '<td style="vertical-align: middle;text-align:center;"><img src="' . base_url() . '/assets/img/check1.png" width="25">';
                                                } else {
                                                    echo '<td style="vertical-align: middle;text-align:center;"><img src="' . base_url() . '/assets/img/error1.png" width="25">';
                                                } 
                                                
                                                if($data->CHR_FLAG_APP_DIR == 1){                                                            
                                                    echo '<td style="vertical-align: middle;text-align:center;"><img src="' . base_url() . '/assets/img/check1.png" width="25">';
                                                } else {
                                                    echo '<td style="vertical-align: middle;text-align:center;"><img src="' . base_url() . '/assets/img/error1.png" width="25">';
                                                } 
                                                
                                                echo '</tr>';
                                                
                                                $sum_bln04 = $sum_bln04 + $data->MON_AMT_BLN04;
                                                $sum_bln05 = $sum_bln05 + $data->MON_AMT_BLN05;
                                                $sum_bln06 = $sum_bln06 + $data->MON_AMT_BLN06;
                                                $sum_bln07 = $sum_bln07 + $data->MON_AMT_BLN07;
                                                $sum_bln08 = $sum_bln08 + $data->MON_AMT_BLN08;
                                                $sum_bln09 = $sum_bln09 + $data->MON_AMT_BLN09;
                                                $sum_bln10 = $sum_bln10 + $data->MON_AMT_BLN10;
                                                $sum_bln11 = $sum_bln11 + $data->MON_AMT_BLN11;
                                                $sum_bln12 = $sum_bln12 + $data->MON_AMT_BLN12;
                                                $sum_bln01 = $sum_bln01 + $data->MON_AMT_BLN01;
                                                $sum_bln02 = $sum_bln02 + $data->MON_AMT_BLN02;
                                                $sum_bln03 = $sum_bln03 + $data->MON_AMT_BLN03; 
                                                $sum_all = $sum_all + $data->MON_AMT_SUM;
                                            }
                                            echo '<tr>';
                                            echo '<td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>';
                                            echo '<td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>';
                                            echo '<td style="font-weight: bold;text-align: right;background-color: #dddddd;">Total</td>';
                                            
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln04) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln05) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln06) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln07) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln08) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln09) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln10) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln11) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln12) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln01) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln02) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_bln03) . '</td>';
                                            echo '<td style="vertical-align: middle;text-align:center;">' . number_format($sum_all) . '</td>';
                                            
                                            echo '<td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>';
                                            echo '<td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>';
                                            echo '<td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
            <div class="col-md-12">
                <div class="grid-header">
                    <span class="grid-title"><i> No Available Data Sales</i></span>
                </div>
            </div>
            <?php } ?>            
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
            order: [[1, 'desc']],
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>