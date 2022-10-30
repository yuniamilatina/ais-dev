<div>
<table width='100%' style="font-size: 10px;">
    <tr>
        <td width='4%'></td>
        <td width='1%'></td>
        <td width='7%' align='center' style="font-weight: bold;">APR</td>
        <td width='7%' align='center' style="font-weight: bold;">MEI</td>
        <td width='7%' align='center' style="font-weight: bold;">JUN</td>
        <td width='7%' align='center' style="font-weight: bold;">JUL</td>
        <td width='7%' align='center' style="font-weight: bold;">AGU</td>
        <td width='7%' align='center' style="font-weight: bold;">SEP</td>
        <td width='7%' align='center' style="font-weight: bold;">OKT</td>
        <td width='7%' align='center' style="font-weight: bold;">NOV</td>
        <td width='7%' align='center' style="font-weight: bold;">DES</td>
        <td width='7%' align='center' style="font-weight: bold;">JAN</td>
        <td width='7%' align='center' style="font-weight: bold;">FEB</td>
        <td width='7%' align='center' style="font-weight: bold;">MAR</td>
        <td width='7%' align='center' style="font-weight: bold;">TOTAL</td>
        <!--<td width='7%' align='center' style="font-weight: bold;">%</td>-->
    </tr>
    <tr><td>&nbsp;</td></tr>
    <?php
        //=== LIMIT BUDGET END OF FY
        if($budget_type == 'CAPEX'){
            $limit_budget = 9688246367; 
        } else if($budget_type == 'REPMA'){
            $limit_budget = 31828746166; 
        } else if($budget_type == 'TOOEQ'){
            $limit_budget = 9562751395; 
        }
           
    ?>
    <tr>
        <td width='4%' style="font-weight: bold;">Limit</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'><?php echo number_format($limit_budget, 0, ',', '.'); ?></td>
        <td width='7%' align='right'><?php echo number_format($limit_budget, 0, ',', '.'); ?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td width='4%' style="font-weight: bold;">Act PR</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <?php
            if($actual_real != NULL){
                echo "<td width='7%' align='right'>" . number_format($actual_real->TOTAL,0,',','.') . "</td>";
                echo "<td width='7%' align='right'>" . number_format($actual_real->TOTAL,0,',','.') . "</td>";
            } else {
        ?>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <?php
            }         
        ?>
        
    </tr> 
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td width='4%' style="font-weight: bold;">Balance</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <?php
            if($actual_real != NULL){
                $balance = $limit_budget - $actual_real->TOTAL;
                echo "<td width='7%' align='right'>" . number_format($balance,0,',','.') . "</td>";
                echo "<td width='7%' align='right'>" . number_format($balance,0,',','.') . "</td>";
            } else {
        ?>
        <td width='7%' align='right'>0</td>
        <td width='7%' align='right'>0</td>
        <?php
            }         
        ?>
    </tr>
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
