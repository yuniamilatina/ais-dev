    <div> <!--style="overflow-x: scroll; overflow-y: hidden" width="100%" height="100%">-->
        <table id='example' class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="font-size: 10px;">
            <thead>
                <tr>
                    <td rowspan="2"></td>
                    <td rowspan="2"></td>                    
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">APR <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">MAY <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">JUN <?php echo $year; ?></td>
                    <td colspan="1" align='center' style="font-weight: bold;">Q1</td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">JUL <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">AUG <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">SEP <?php echo $year; ?></td>
                    <td colspan="1" align='center' style="font-weight: bold;">Q2</td>
                    <td colspan="1" align='center' style="font-weight: bold;">SMT 1</td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">OCT <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">NOV <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">DEC <?php echo $year; ?></td>  
                    <td colspan="1" align='center' style="font-weight: bold;">Q3</td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">JAN <?php echo $year+1; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">FEB <?php echo $year+1; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">MAR <?php echo $year+1; ?></td>
                    <td colspan="1" align='center' style="font-weight: bold;">Q4</td>
                    <td colspan="1" align='center' style="font-weight: bold;">SMT 2</td>
                    <td colspan="1" align='center' style="font-weight: bold;">1 FY</td>
                </tr>
                <tr>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $tot_04 = 0;
                $tot_05 = 0;
                $tot_06 = 0;
                $tot_07 = 0;
                $tot_08 = 0;
                $tot_09 = 0;
                $tot_10 = 0;
                $tot_11 = 0;
                $tot_12 = 0;
                $tot_13 = 0;
                $tot_14 = 0;
                $tot_15 = 0;
                $tot_04_MP = 0;
                $tot_05_MP = 0;
                $tot_06_MP = 0;
                $tot_07_MP = 0;
                $tot_08_MP = 0;
                $tot_09_MP = 0;
                $tot_10_MP = 0;
                $tot_11_MP = 0;
                $tot_12_MP = 0;
                $tot_13_MP = 0;
                $tot_14_MP = 0;
                $tot_15_MP = 0;
                $i = 1;
                foreach($all_dept as $dept){
                    $aortadb = $this->load->database("aorta", TRUE);
                    $detail_quota_used = $aortadb->query("EXEC zsp_get_detail_quota_used_dept_ver2 '$year', '$year_end', '$dept->KODE'")->row();
                    if(count($detail_quota_used) > 0){
                ?>
                <tr align="right">
                    <td><strong><?php echo $dept->KODE; ?></strong></td>
                    <td>:</td>
                <?php
                        //Per QUARTER
                        $tot_Q1_used = $detail_quota_used->BLN04 + $detail_quota_used->BLN05 + $detail_quota_used->BLN06;
                        $tot_Q1_MP = $detail_quota_used->MP04 + $detail_quota_used->MP05 + $detail_quota_used->MP06;
                        if($tot_Q1_MP == 0){
                            $avg_Q1_used = 0;
                        } else {
                            $avg_Q1_used = $tot_Q1_used / $tot_Q1_MP;
                        }                        
                        
                        $tot_Q2_used = $detail_quota_used->BLN07 + $detail_quota_used->BLN08 + $detail_quota_used->BLN09;
                        $tot_Q2_MP = $detail_quota_used->MP07 + $detail_quota_used->MP08 + $detail_quota_used->MP09;
                        if($tot_Q2_MP == 0){
                            $avg_Q2_used = 0;
                        } else {
                            $avg_Q2_used = $tot_Q2_used / $tot_Q2_MP;
                        }                        
                        
                        $tot_Q3_used = $detail_quota_used->BLN10 + $detail_quota_used->BLN11 + $detail_quota_used->BLN12;
                        $tot_Q3_MP = $detail_quota_used->MP10 + $detail_quota_used->MP11 + $detail_quota_used->MP12;
                        if($tot_Q3_MP == 0){
                            $avg_Q3_used = 0;
                        } else {
                            $avg_Q3_used = $tot_Q3_used / $tot_Q2_MP;
                        }                        
                        
                        $tot_Q4_used = $detail_quota_used->BLN13 + $detail_quota_used->BLN14 + $detail_quota_used->BLN15;
                        $tot_Q4_MP = $detail_quota_used->MP13 + $detail_quota_used->MP14 + $detail_quota_used->MP15;
                        if($tot_Q4_MP == 0){
                            $avg_Q4_used = 0;
                        } else {
                            $avg_Q4_used = $tot_Q4_used / $tot_Q4_MP;
                        }
                        
                        //Per SEMESTER
                        $tot_smt1_used = $tot_Q1_used + $tot_Q2_used;
                        $tot_smt1_MP = $tot_Q1_MP + $tot_Q2_MP;
                        if($tot_smt1_MP == 0){
                            $avg_smt1_used = 0;
                        } else {
                            $avg_smt1_used = $tot_smt1_used / $tot_smt1_MP;
                        }
                        
                        $tot_smt2_used = $tot_Q3_used + $tot_Q4_used;
                        $tot_smt2_MP = $tot_Q3_MP + $tot_Q4_MP;
                        if($tot_smt2_MP == 0){
                            $avg_smt2_used = 0;
                        } else {
                            $avg_smt2_used = $tot_smt2_used / $tot_smt2_MP;
                        }                        
                        
                        //Total 1FY
                        $tot_fy_used = $tot_smt1_used + $tot_smt2_used;
                        $tot_fy_MP = $tot_smt1_MP + $tot_smt2_MP;
                        if($tot_fy_MP == 0){
                            $avg_fy_used = 0;
                        } else {
                            $avg_fy_used = $tot_fy_used / $tot_fy_MP;
                        }                        
                        
                        //Tot All Dept MONTHLY
                        $tot_04 = $tot_04 + $detail_quota_used->BLN04;
                        $tot_05 = $tot_05 + $detail_quota_used->BLN05;
                        $tot_06 = $tot_06 + $detail_quota_used->BLN06;
                        $tot_07 = $tot_07 + $detail_quota_used->BLN07;
                        $tot_08 = $tot_08 + $detail_quota_used->BLN08;
                        $tot_09 = $tot_09 + $detail_quota_used->BLN09;
                        $tot_10 = $tot_10 + $detail_quota_used->BLN10;
                        $tot_11 = $tot_11 + $detail_quota_used->BLN11;
                        $tot_12 = $tot_12 + $detail_quota_used->BLN12;
                        $tot_13 = $tot_13 + $detail_quota_used->BLN13;
                        $tot_14 = $tot_14 + $detail_quota_used->BLN14;
                        $tot_15 = $tot_15 + $detail_quota_used->BLN15;
                        
                        $tot_04_MP = $tot_04_MP + $detail_quota_used->MP04;
                        $tot_05_MP = $tot_05_MP + $detail_quota_used->MP05;
                        $tot_06_MP = $tot_06_MP + $detail_quota_used->MP06;
                        $tot_07_MP = $tot_07_MP + $detail_quota_used->MP07;
                        $tot_08_MP = $tot_08_MP + $detail_quota_used->MP08;
                        $tot_09_MP = $tot_09_MP + $detail_quota_used->MP09;
                        $tot_10_MP = $tot_10_MP + $detail_quota_used->MP10;
                        $tot_11_MP = $tot_11_MP + $detail_quota_used->MP11;
                        $tot_12_MP = $tot_12_MP + $detail_quota_used->MP12;
                        $tot_13_MP = $tot_13_MP + $detail_quota_used->MP13;
                        $tot_14_MP = $tot_14_MP + $detail_quota_used->MP14;
                        $tot_15_MP = $tot_15_MP + $detail_quota_used->MP15;
                    ?>
                    <td><?php echo number_format($detail_quota_used->AVG04,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG05,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG06,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($avg_Q1_used,1,',','.'); ?></strong></td>
                    <td><?php echo number_format($detail_quota_used->AVG07,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG08,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG09,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($avg_Q2_used,1,',','.'); ?></strong></td>
                            <td><strong><?php echo number_format($avg_smt1_used,1,',','.'); ?></strong></td>
                    <td><?php echo number_format($detail_quota_used->AVG10,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG11,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG12,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($avg_Q3_used,1,',','.'); ?></strong></td>
                    <td><?php echo number_format($detail_quota_used->AVG13,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG14,1,',','.'); ?></td>
                    <td><?php echo number_format($detail_quota_used->AVG15,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($avg_Q4_used,1,',','.'); ?></strong></td>
                            <td><strong><?php echo number_format($avg_smt2_used,1,',','.'); ?></strong></td>
                    <td><strong><?php echo number_format($avg_fy_used,1,',','.'); ?></strong></td>
                </tr>
                <?php
                    $i++;
                    } 
                }
                
                ?>
                <tr align="right">
                    <td><strong>OT/MP GROUP</strong></td>
                    <td>:</td>
                    <?php
                        //Summary per MONTH
                        if($tot_04_MP == 0){ $sum_avg_04 = 0; } else { $sum_avg_04 = $tot_04/$tot_04_MP; }
                        if($tot_05_MP == 0){ $sum_avg_05 = 0; } else { $sum_avg_05 = $tot_05/$tot_05_MP; }
                        if($tot_06_MP == 0){ $sum_avg_06 = 0; } else { $sum_avg_06 = $tot_06/$tot_06_MP; }
                        if($tot_07_MP == 0){ $sum_avg_07 = 0; } else { $sum_avg_07 = $tot_07/$tot_07_MP; }
                        if($tot_08_MP == 0){ $sum_avg_08 = 0; } else { $sum_avg_08 = $tot_08/$tot_08_MP; }
                        if($tot_09_MP == 0){ $sum_avg_09 = 0; } else { $sum_avg_09 = $tot_09/$tot_09_MP; }
                        if($tot_10_MP == 0){ $sum_avg_10 = 0; } else { $sum_avg_10 = $tot_10/$tot_10_MP; }
                        if($tot_11_MP == 0){ $sum_avg_11 = 0; } else { $sum_avg_11 = $tot_11/$tot_11_MP; }
                        if($tot_12_MP == 0){ $sum_avg_12 = 0; } else { $sum_avg_12 = $tot_12/$tot_12_MP; }
                        if($tot_13_MP == 0){ $sum_avg_13 = 0; } else { $sum_avg_13 = $tot_13/$tot_13_MP; }
                        if($tot_14_MP == 0){ $sum_avg_14 = 0; } else { $sum_avg_14 = $tot_14/$tot_14_MP; }
                        if($tot_15_MP == 0){ $sum_avg_15 = 0; } else { $sum_avg_15 = $tot_04/$tot_15_MP; }
                        
                        //Summary per QUARTER
                        $sum_tot_Q1_used = $tot_04 + $tot_05 + $tot_06;
                        $sum_tot_Q1_MP = $tot_04_MP + $tot_05_MP + $tot_06_MP;
                        if($sum_tot_Q1_MP == 0){
                            $sum_avg_Q1_used = 0; 
                        } else {
                            $sum_avg_Q1_used = $sum_tot_Q1_used / $sum_tot_Q1_MP;
                        }
                        
                        $sum_tot_Q2_used = $tot_07 + $tot_08 + $tot_09;
                        $sum_tot_Q2_MP = $tot_07_MP + $tot_08_MP + $tot_09_MP;
                        if($sum_tot_Q2_MP == 0){
                            $sum_avg_Q2_used = 0; 
                        } else {
                            $sum_avg_Q2_used = $sum_tot_Q2_used / $sum_tot_Q2_MP;
                        }
                        
                        $sum_tot_Q3_used = $tot_10 + $tot_11 + $tot_12;
                        $sum_tot_Q3_MP = $tot_10_MP + $tot_11_MP + $tot_12_MP;
                        if($sum_tot_Q3_MP == 0){
                            $sum_avg_Q3_used = 0; 
                        } else {
                            $sum_avg_Q3_used = $sum_tot_Q3_used / $sum_tot_Q3_MP;
                        }
                        
                        $sum_tot_Q4_used = $tot_13 + $tot_14 + $tot_15;
                        $sum_tot_Q4_MP = $tot_13_MP + $tot_14_MP + $tot_15_MP;
                        if($sum_tot_Q4_MP == 0){
                            $sum_avg_Q4_used = 0; 
                        } else {
                            $sum_avg_Q4_used = $sum_tot_Q4_used / $sum_tot_Q4_MP;
                        }
                        
                        //Summary per SEMESTER
                        $sum_tot_smt1_used = $sum_tot_Q1_used + $sum_tot_Q2_used;
                        $sum_tot_smt1_MP = $sum_tot_Q1_MP + $sum_tot_Q2_MP;
                        if($sum_tot_smt1_MP == 0){
                            $sum_avg_smt1_used = 0; 
                        } else {
                            $sum_avg_smt1_used = $sum_tot_smt1_used / $sum_tot_smt1_MP;
                        }
                        
                        $sum_tot_smt2_used = $sum_tot_Q3_used + $sum_tot_Q4_used;
                        $sum_tot_smt2_MP = $sum_tot_Q3_MP + $sum_tot_Q4_MP;
                        if($sum_tot_smt2_MP == 0){
                            $sum_avg_smt2_used = 0; 
                        } else {
                            $sum_avg_smt2_used = $sum_tot_smt2_used / $sum_tot_smt2_MP;
                        }
                        
                        //Summary FISCAL YEAR
                        $sum_tot_fy_used = $sum_tot_smt1_used = $sum_tot_smt2_used;
                        $sum_tot_fy_MP = $sum_tot_smt1_MP + $sum_tot_smt2_MP;
                        if($sum_tot_fy_MP == 0){
                            $sum_avg_fy_used = 0; 
                        } else {
                            $sum_avg_fy_used = $sum_tot_fy_used / $sum_tot_fy_MP;
                        }
                    ?>
                    <td><?php echo number_format($sum_avg_04,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_05,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_06,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($sum_avg_Q1_used,1,',','.'); ?></strong></td>
                    <td><?php echo number_format($sum_avg_07,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_08,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_09,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($sum_avg_Q2_used,1,',','.'); ?></strong></td>
                            <td><strong><?php echo number_format($sum_avg_smt1_used,1,',','.'); ?></strong></td>
                    <td><?php echo number_format($sum_avg_10,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_11,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_12,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($sum_avg_Q3_used,1,',','.'); ?></strong></td>
                    <td><?php echo number_format($sum_avg_13,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_14,1,',','.'); ?></td>
                    <td><?php echo number_format($sum_avg_15,1,',','.'); ?></td>
                        <td><strong><?php echo number_format($sum_avg_Q4_used,1,',','.'); ?></strong></td>
                            <td><strong><?php echo number_format($sum_avg_smt2_used,1,',','.'); ?></strong></td>
                    <td><strong><?php echo number_format($sum_avg_fy_used,1,',','.'); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>
