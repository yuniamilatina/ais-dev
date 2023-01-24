<div> <!--style="overflow-x: scroll; overflow-y: hidden" width="100%" height="100%">-->
    <table id='example' class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="font-size: 11px;">
        <thead>
            <tr>
                <!-- <td rowspan='2' align='center' style="font-weight: bold;">No</td> -->
                <td rowspan='2' align='center' style="font-weight: bold;">Section</td>
                <td colspan='5' align='center' style="font-weight: bold;">Total Quota Period - <?php echo date('M Y', strtotime($periode)); ?></td>
                <td rowspan='2' align='center' style="font-weight: bold;">Avg <br> OT / MP</td>
                <td colspan='3' align='center' style="font-weight: bold;">AVG Period (Est. 22 Day/Month)</td>
                <!-- <td rowspan='2' align='center' style="font-weight: bold;"> % <br> Act / Budget</td> -->
            </tr>
            <tr>
                <td align='center' style="font-weight: bold;">MP</td>
                <!-- <td align='center' style="font-weight: bold;">Quota STD</td>
                <td align='center' style="font-weight: bold;">Quota Plan</td>
                <td align='center' style="font-weight: bold;">Actual OT</td>
                <td align='center' style="font-weight: bold;">Saldo Quota</td> -->
                <td align='center' style="font-weight: bold;">Std</td>
                <td align='center' style="font-weight: bold;">Plan</td>
                <td align='center' style="font-weight: bold;">Act</td>
                <td align='center' style="font-weight: bold;">Balance</td>
                <!-- <td align='center' style="font-weight: bold;">Budget</td> -->
                <td align='center' style="font-weight: bold;">Plan</td>
                <td align='center' style="font-weight: bold;">Act</td>
                <td align='center' style="font-weight: bold;">Balance</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $tot_mp = 0;
            $tot_std = 0;
            $tot_plan = 0;
            $tot_ot = 0;
            $tot_saldo = 0;
            $avg_plan = 0;
            $avg_ot = 0;
            $avg_saldo = 0;
            $no = 1;
            foreach ($detail_quota_section as $ot) {
                $tot_mp = $tot_mp + $ot->KRY;
                $tot_std = $tot_std + $ot->QUOTA_STD;

                ////==== Quota PRD
                // $tot_plan = $tot_plan + $ot->QUOTAPLAN;
                // $tot_ot = $tot_ot + $ot->TERPAKAIPLAN;
                // $tot_saldo = $tot_saldo + $ot->SISAPLAN;
                // $avg_plan = $avg_plan + $ot->AVG_QUOTA;
                // $avg_ot = $avg_ot + $ot->AVG_OT;
                // $avg_saldo = $avg_saldo + $ot->AVG_SISA;

                ////==== Quota PRD + IMP
                $tot_plan = $tot_plan + $ot->QUOTAPLAN + $ot->QUOTAPLAN1;
                $tot_ot = $tot_ot + $ot->TERPAKAIPLAN + $ot->TERPAKAIPLAN1;
                $tot_saldo = $tot_saldo + $ot->SISAPLAN + $ot->SISAPLAN1;
                $avg_plan = $avg_plan + $ot->AVG_QUOTA + $ot->AVG_QUOTA1;
                $avg_ot = $avg_ot + $ot->AVG_OT + $ot->AVG_OT1;
                $avg_saldo = $avg_saldo + $ot->AVG_SISA + $ot->AVG_SISA1;

                echo "<tr align='center' valign='middle'>";
                // echo "<td>" . $no . "</td>";
                echo "<td>" . $ot->KD_SECTION . "</td>";
                echo "<td>" . $ot->KRY . "</td>";
                echo "<td>" . number_format($ot->QUOTA_STD, 2, ',', '.') . "</td>";

                ////==== Quota PRD
                // echo "<td>" . number_format($ot->QUOTAPLAN, 2, ',', '.') . "</td>";
                // echo "<td>" . number_format($ot->TERPAKAIPLAN, 2, ',', '.') . "</td>";
                // echo "<td>" . number_format($ot->SISAPLAN, 2, ',', '.') . "</td>";
                // // echo "<td> - </td>";
                // echo "<td>" . number_format(($ot->TERPAKAIPLAN/$ot->KRY), 2, ',', '.') . "</td>";
                // echo "<td>" . number_format($ot->AVG_QUOTA, 2, ',', '.') . "</td>";
                // echo "<td>" . number_format($ot->AVG_OT, 2, ',', '.') . "</td>";
                // echo "<td>" . number_format($ot->AVG_SISA, 2, ',', '.') . "</td>";

                ////==== Quota PRD + IMP                
                echo "<td>" . number_format(($ot->QUOTAPLAN + $ot->QUOTAPLAN1), 2, ',', '.') . "</td>";
                echo "<td>" . number_format(($ot->TERPAKAIPLAN + $ot->TERPAKAIPLAN1), 2, ',', '.') . "</td>";
                echo "<td>" . number_format(($ot->SISAPLAN + $ot->SISAPLAN1), 2, ',', '.') . "</td>";
                // echo "<td> - </td>";
                echo "<td>" . number_format((($ot->TERPAKAIPLAN + $ot->TERPAKAIPLAN1)/$ot->KRY), 2, ',', '.') . "</td>";
                echo "<td>" . number_format(($ot->AVG_QUOTA + $ot->AVG_QUOTA1), 2, ',', '.') . "</td>";
                echo "<td>" . number_format(($ot->AVG_OT + $ot->AVG_OT1), 2, ',', '.') . "</td>";
                echo "<td>" . number_format(($ot->AVG_SISA + $ot->AVG_SISA1), 2, ',', '.') . "</td>";
                // echo "<td> - </td>";
                echo "</tr>";
                $no++;
            }

            if (!$detail_quota_section) {
                
            } else {
                $avg_plan = $avg_plan / ($no - 1);
                $avg_ot = $avg_ot / ($no - 1);
                $avg_saldo = $avg_saldo / ($no - 1);
                echo "<tr align='center'>";
                echo "<td colspan='1'><strong>SUMMARY DEPT</strong></td>";
                echo "<td><strong>" . $tot_mp . "</strong></td>";
                echo "<td><strong>" . number_format($tot_std, 2, ',', '.') . "</strong></td>";
                echo "<td><strong>" . number_format($tot_plan, 2, ',', '.') . "</strong></td>";
                echo "<td><strong>" . number_format($tot_ot, 2, ',', '.') . "</strong></td>";
                echo "<td><strong>" . number_format($tot_saldo, 2, ',', '.') . "</strong></td>";
                // echo "<td><strong>" . number_format($budget_quota, 2, ',', '.') . "</strong></td>";
                echo "<td><strong>" . number_format(($tot_ot/$tot_mp), 2, ',', '.') . "</strong></td>";
                echo "<td><strong>" . number_format($avg_plan, 2, ',', '.') . "</strong></td>";
                echo "<td><strong>" . number_format($avg_ot, 2, ',', '.') . "</strong></td>";
                echo "<td><strong>" . number_format($avg_saldo, 2, ',', '.') . "</strong></td>";
                // echo "<td><strong>" . number_format($tot_ot/$budget_quota*100, 2, ',', '.') . "%</strong></td>";
                echo "</tr>";

            }
            ?>
        </tbody>
    </table>
</div>
<div align="center">
    <button class="btn btn-primary" style="width:150px;font-size:12px;">Budget OT: <?php echo " <strong>" . number_format($budget_quota, 2, ',', '.') . " H</strong>"; ?></button>
    &nbsp;
    <button class="btn btn-primary" style="width:150px;font-size:12px;">Quota OT: <?php echo " <strong>" . number_format($tot_plan, 2, ',', '.') . " H</strong>"; ?></button>    
    &nbsp;
    <button class="btn btn-primary" style="width:150px;font-size:12px;">Actual OT: <?php echo " <strong>" . number_format($tot_ot, 2, ',', '.') . " H</strong>"; ?></button>    
    &nbsp;
    <?php if($budget_quota != 0) { if($tot_ot <= ($budget_quota*0.9) ){ ?>
        <button class="btn btn-success" style="width:170px;font-size:12px;">% Act vs Budget: <?php echo " <strong>" . number_format($tot_ot/$budget_quota*100, 2, ',', '.') . "%</strong>"; ?></button>
    <?php } else if($tot_ot > ($budget_quota*0.9) && $tot_ot <= $budget_quota) { ?>
        <button class="btn btn-warning" style="width:170px;font-size:12px;">% Act vs Budget: <?php echo " <strong>" . number_format($tot_ot/$budget_quota*100, 2, ',', '.') . "%</strong>"; ?></button>
    <?php } else if($tot_ot > $budget_quota){ ?>
        <button class="btn btn-danger" style="width:170px;font-size:12px;">% Act vs Budget: <?php echo " <strong>" . number_format($tot_ot/$budget_quota*100, 2, ',', '.') . "%</strong>"; ?></button>
    <?php } ?>
    &nbsp;  
    <?php } else { ?>
        <button class="btn btn-success" style="width:170px;font-size:12px;">% Act vs Budget: <?php echo " <strong>" . number_format(0, 2, ',', '.') . "%</strong>"; ?></button>
    <?php } ?>  
</div>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function () {
        var table = $('#dataTable').DataTable({
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>
