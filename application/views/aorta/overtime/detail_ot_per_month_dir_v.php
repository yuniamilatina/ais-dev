    <div>
        <!--style="overflow-x: scroll; overflow-y: hidden" width="100%" height="100%">-->
        <table id='example' class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="font-size: 10px;">
            <thead>
                <tr>
                    <td rowspan="2"></td>
                    <td rowspan="2"></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">APR <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">MAY <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">JUN <?php echo $year; ?></td>
                    <td colspan="2" align='center' style="font-weight: bold;">Q1</td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">JUL <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">AUG <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">SEP <?php echo $year; ?></td>
                    <td colspan="2" align='center' style="font-weight: bold;">Q2</td>
                    <td colspan="2" align='center' style="font-weight: bold;">SMT 1</td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">OCT <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">NOV <?php echo $year; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">DEC <?php echo $year; ?></td>
                    <td colspan="2" align='center' style="font-weight: bold;">Q3</td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">JAN <?php echo $year + 1; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">FEB <?php echo $year + 1; ?></td>
                    <td rowspan="2" align='center' style="vertical-align: middle; font-weight: bold;">MAR <?php echo $year + 1; ?></td>
                    <td colspan="2" align='center' style="font-weight: bold;">Q4</td>
                    <td colspan="2" align='center' style="font-weight: bold;">SMT 2</td>
                    <td colspan="2" align='center' style="font-weight: bold;">1 FY</td>
                </tr>
                <tr>
                    <td align='center' style="font-weight: bold;">Tot</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Tot</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Tot</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Tot</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Tot</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Tot</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                    <td align='center' style="font-weight: bold;">Tot</td>
                    <td align='center' style="font-weight: bold;">Avg</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($detail_quota_std) > 0) {
                ?>
                    <tr align="right">
                        <td><strong>STD</strong></td>
                        <td>:</td>
                        <?php
                        //Per QUARTER
                        $tot_Q1_std = $detail_quota_std->BLN04 + $detail_quota_std->BLN05 + $detail_quota_std->BLN06;
                        $avg_Q1_std = $tot_Q1_std / 3;
                        $tot_Q2_std = $detail_quota_std->BLN07 + $detail_quota_std->BLN08 + $detail_quota_std->BLN09;
                        $avg_Q2_std = $tot_Q2_std / 3;
                        $tot_Q3_std = $detail_quota_std->BLN10 + $detail_quota_std->BLN11 + $detail_quota_std->BLN12;
                        $avg_Q3_std = $tot_Q3_std / 3;
                        $tot_Q4_std = $detail_quota_std->BLN13 + $detail_quota_std->BLN14 + $detail_quota_std->BLN15;
                        $avg_Q4_std = $tot_Q4_std / 3;

                        //Per SEMESTER
                        $tot_smt1_std = $tot_Q1_std + $tot_Q2_std;
                        $avg_smt1_std = ($tot_Q1_std + $tot_Q2_std) / 6;
                        $tot_smt2_std = $tot_Q3_std + $tot_Q4_std;
                        $avg_smt2_std = ($tot_Q3_std + $tot_Q4_std) / 6;

                        //Total 1FY
                        $tot_fy_std = $detail_quota_std->BLN04 + $detail_quota_std->BLN05 + $detail_quota_std->BLN06 + $detail_quota_std->BLN07 + $detail_quota_std->BLN08 + $detail_quota_std->BLN09 +
                            $detail_quota_std->BLN10 + $detail_quota_std->BLN11 + $detail_quota_std->BLN12 + $detail_quota_std->BLN13 + $detail_quota_std->BLN14 + $detail_quota_std->BLN15;
                        $avg_fy_std = $tot_fy_std / 12;
                        ?>
                        <td><?php echo number_format($detail_quota_std->BLN04, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN05, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN06, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q1_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q1_std, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_std->BLN07, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN08, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN09, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q2_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q2_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt1_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt1_std, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_std->BLN10, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN11, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN12, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q3_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q3_std, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_std->BLN13, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN14, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_std->BLN15, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q4_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q4_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt2_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt2_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_fy_std, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_fy_std, 0, ',', '.'); ?></strong></td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr align="right">
                        <td><strong>STD</strong></td>
                        <td>:</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                    </tr>
                <?php
                }
                if (count($detail_quota_plan) > 0) {
                ?>
                    <tr align="right">
                        <td><strong>PLAN</strong></td>
                        <td>:</td>
                        <?php
                        //Per QUARTER
                        $tot_Q1_plan = $detail_quota_plan->BLN04 + $detail_quota_plan->BLN05 + $detail_quota_plan->BLN06;
                        $avg_Q1_plan = $tot_Q1_plan / 3;
                        $tot_Q2_plan = $detail_quota_plan->BLN07 + $detail_quota_plan->BLN08 + $detail_quota_plan->BLN09;
                        $avg_Q2_plan = $tot_Q2_plan / 3;
                        $tot_Q3_plan = $detail_quota_plan->BLN10 + $detail_quota_plan->BLN11 + $detail_quota_plan->BLN12;
                        $avg_Q3_plan = $tot_Q3_plan / 3;
                        $tot_Q4_plan = $detail_quota_plan->BLN13 + $detail_quota_plan->BLN14 + $detail_quota_plan->BLN15;
                        $avg_Q4_plan = $tot_Q4_plan / 3;

                        //Per SEMESTER
                        $tot_smt1_plan = $tot_Q1_plan + $tot_Q2_plan;
                        $avg_smt1_plan = ($tot_Q1_plan + $tot_Q2_plan) / 6;
                        $tot_smt2_plan = $tot_Q3_plan + $tot_Q4_plan;
                        $avg_smt2_plan = ($tot_Q3_plan + $tot_Q4_plan) / 6;

                        //Total 1FY
                        $tot_fy_plan = $detail_quota_plan->BLN04 + $detail_quota_plan->BLN05 + $detail_quota_plan->BLN06 + $detail_quota_plan->BLN07 + $detail_quota_plan->BLN08 + $detail_quota_plan->BLN09 +
                            $detail_quota_plan->BLN10 + $detail_quota_plan->BLN11 + $detail_quota_plan->BLN12 + $detail_quota_plan->BLN13 + $detail_quota_plan->BLN14 + $detail_quota_plan->BLN15;
                        $avg_fy_plan = $tot_fy_plan / 12;
                        ?>
                        <td><?php echo number_format($detail_quota_plan->BLN04, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN05, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN06, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q1_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q1_plan, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_plan->BLN07, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN08, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN09, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q2_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q2_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt1_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt1_plan, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_plan->BLN10, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN11, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN12, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q3_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q3_plan, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_plan->BLN13, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN14, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_plan->BLN15, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q4_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q4_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt2_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt2_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_fy_plan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_fy_plan, 0, ',', '.'); ?></strong></td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr align="right">
                        <td><strong>PLAN</strong></td>
                        <td>:</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                    </tr>
                <?php
                }
                if (count($detail_quota_used) > 0) {
                ?>
                    <tr align="right">
                        <td><strong>ACT OT</strong></td>
                        <td>:</td>
                        <?php
                        //Per QUARTER
                        $tot_Q1_used = $detail_quota_used->BLN04 + $detail_quota_used->BLN05 + $detail_quota_used->BLN06;
                        $avg_Q1_used = $tot_Q1_used / 3;
                        $tot_Q2_used = $detail_quota_used->BLN07 + $detail_quota_used->BLN08 + $detail_quota_used->BLN09;
                        $avg_Q2_used = $tot_Q2_used / 3;
                        $tot_Q3_used = $detail_quota_used->BLN10 + $detail_quota_used->BLN11 + $detail_quota_used->BLN12;
                        $avg_Q3_used = $tot_Q3_used / 3;
                        $tot_Q4_used = $detail_quota_used->BLN13 + $detail_quota_used->BLN14 + $detail_quota_used->BLN15;
                        $avg_Q4_used = $tot_Q4_used / 3;

                        //Per SEMESTER
                        $tot_smt1_used = $tot_Q1_used + $tot_Q2_used;
                        $avg_smt1_used = ($tot_Q1_used + $tot_Q2_used) / 6;
                        $tot_smt2_used = $tot_Q3_used + $tot_Q4_used;
                        $avg_smt2_used = ($tot_Q3_used + $tot_Q4_used) / 6;

                        //Total 1FY
                        $tot_fy_used = $detail_quota_used->BLN04 + $detail_quota_used->BLN05 + $detail_quota_used->BLN06 + $detail_quota_used->BLN07 + $detail_quota_used->BLN08 + $detail_quota_used->BLN09 +
                            $detail_quota_used->BLN10 + $detail_quota_used->BLN11 + $detail_quota_used->BLN12 + $detail_quota_used->BLN13 + $detail_quota_used->BLN14 + $detail_quota_used->BLN15;
                        $avg_fy_used = $tot_fy_used / 12;
                        ?>
                        <td><?php echo number_format($detail_quota_used->BLN04, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN05, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN06, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q1_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q1_used, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_used->BLN07, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN08, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN09, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q2_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q2_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt1_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt1_used, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_used->BLN10, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN11, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN12, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q3_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q3_used, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_used->BLN13, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN14, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_used->BLN15, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q4_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q4_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt2_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt2_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_fy_used, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_fy_used, 0, ',', '.'); ?></strong></td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr align="right">
                        <td><strong>ACT OT</strong></td>
                        <td>:</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                    </tr>
                <?php
                }
                if (count($detail_quota_saldo) > 0) {
                ?>
                    <tr align="right">
                        <td><strong>SALDO</strong></td>
                        <td>:</td>
                        <?php
                        //Per QUARTER
                        $tot_Q1_saldo = $detail_quota_saldo->BLN04 + $detail_quota_saldo->BLN05 + $detail_quota_saldo->BLN06;
                        $avg_Q1_saldo = $tot_Q1_saldo / 3;
                        $tot_Q2_saldo = $detail_quota_saldo->BLN07 + $detail_quota_saldo->BLN08 + $detail_quota_saldo->BLN09;
                        $avg_Q2_saldo = $tot_Q2_saldo / 3;
                        $tot_Q3_saldo = $detail_quota_saldo->BLN10 + $detail_quota_saldo->BLN11 + $detail_quota_saldo->BLN12;
                        $avg_Q3_saldo = $tot_Q3_saldo / 3;
                        $tot_Q4_saldo = $detail_quota_saldo->BLN13 + $detail_quota_saldo->BLN14 + $detail_quota_saldo->BLN15;
                        $avg_Q4_saldo = $tot_Q4_saldo / 3;

                        //Per SEMESTER
                        $tot_smt1_saldo = $tot_Q1_saldo + $tot_Q2_saldo;
                        $avg_smt1_saldo = ($tot_Q1_saldo + $tot_Q2_saldo) / 6;
                        $tot_smt2_saldo = $tot_Q3_saldo + $tot_Q4_saldo;
                        $avg_smt2_saldo = ($tot_Q3_saldo + $tot_Q4_saldo) / 6;

                        //Total 1FY
                        $tot_fy_saldo = $detail_quota_saldo->BLN04 + $detail_quota_saldo->BLN05 + $detail_quota_saldo->BLN06 + $detail_quota_saldo->BLN07 + $detail_quota_saldo->BLN08 + $detail_quota_saldo->BLN09 +
                            $detail_quota_saldo->BLN10 + $detail_quota_saldo->BLN11 + $detail_quota_saldo->BLN12 + $detail_quota_saldo->BLN13 + $detail_quota_saldo->BLN14 + $detail_quota_saldo->BLN15;
                        $avg_fy_saldo = $tot_fy_saldo / 12;
                        ?>
                        <td><?php echo number_format($detail_quota_saldo->BLN04, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN05, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN06, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q1_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q1_saldo, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN07, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN08, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN09, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q2_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q2_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt1_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt1_saldo, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN10, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN11, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN12, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q3_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q3_saldo, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN13, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN14, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_saldo->BLN15, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q4_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q4_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt2_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt2_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_fy_saldo, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_fy_saldo, 0, ',', '.'); ?></strong></td>
                    </tr>
                <?php
                }
                if (count($detail_quota_budget) > 0) {
                ?>
                    <tr align="right">
                        <td><strong>BUDGET</strong></td>
                        <td>:</td>

                        <?php
                        //Per QUARTER
                        $tot_Q1_budget = $detail_quota_budget->DATA_04 + $detail_quota_budget->DATA_05 + $detail_quota_budget->DATA_06;
                        $avg_Q1_budget = $tot_Q1_budget / 3;
                        $tot_Q2_budget = $detail_quota_budget->DATA_07 + $detail_quota_budget->DATA_08 + $detail_quota_budget->DATA_09;
                        $avg_Q2_budget = $tot_Q2_budget / 3;
                        $tot_Q3_budget = $detail_quota_budget->DATA_10 + $detail_quota_budget->DATA_11 + $detail_quota_budget->DATA_12;
                        $avg_Q3_budget = $tot_Q3_budget / 3;
                        $tot_Q4_budget = $detail_quota_budget->DATA_01 + $detail_quota_budget->DATA_02 + $detail_quota_budget->DATA_03;
                        $avg_Q4_budget = $tot_Q4_budget / 3;
                        //Per SEMESTER
                        $tot_smt1_budget = $tot_Q1_budget + $tot_Q2_budget;
                        $avg_smt1_budget = ($tot_Q1_budget + $tot_Q2_budget) / 6;
                        $tot_smt2_budget = $tot_Q3_budget + $tot_Q4_budget;
                        $avg_smt2_budget = ($tot_Q3_budget + $tot_Q4_budget) / 6;
                        //Total 1FY
                        $tot_fy_budget = $detail_quota_budget->DATA_01 + $detail_quota_budget->DATA_02 + $detail_quota_budget->DATA_03 + $detail_quota_budget->DATA_04 + $detail_quota_budget->DATA_05 + $detail_quota_budget->DATA_06 +
                            $detail_quota_budget->DATA_07 + $detail_quota_budget->DATA_08 + $detail_quota_budget->DATA_09 + $detail_quota_budget->DATA_10 + $detail_quota_budget->DATA_11 + $detail_quota_budget->DATA_12;
                        $avg_fy_budget = $tot_fy_budget / 12;
                        ?>

                        <td><?php echo number_format($detail_quota_budget->DATA_04, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_05, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_06, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q1_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q1_budget, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_07, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_08, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_09, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q2_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q2_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt1_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt1_budget, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_10, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_11, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_12, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q3_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q3_budget, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_01, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_02, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($detail_quota_budget->DATA_03, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format($tot_Q4_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_Q4_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_smt2_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_smt2_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($tot_fy_budget, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format($avg_fy_budget, 0, ',', '.'); ?></strong></td>
                    </tr>
                    <tr align="center">
                        <td><strong>ACT/BGT (%)</strong></td>
                        <td>:</td>

                        <td><?php echo number_format(($detail_quota_used->BLN04/$detail_quota_budget->DATA_04)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN05/$detail_quota_budget->DATA_05)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN06/$detail_quota_budget->DATA_06)*100, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format(($tot_Q1_used/$tot_Q1_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format(($avg_Q1_used/$avg_Q1_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><?php echo number_format(($detail_quota_used->BLN07/$detail_quota_budget->DATA_07)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN08/$detail_quota_budget->DATA_08)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN09/$detail_quota_budget->DATA_09)*100, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format(($tot_Q2_used/$tot_Q2_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format(($avg_Q2_used/$avg_Q2_budget)*100, 0, ',', '.');; ?></strong></td>
                        <td><strong><?php echo number_format(($tot_smt1_used/$tot_smt1_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format(($avg_smt1_used/$avg_smt1_budget)*100, 0, ',', '.');; ?></strong></td>
                        <td><?php echo number_format(($detail_quota_used->BLN10/$detail_quota_budget->DATA_10)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN11/$detail_quota_budget->DATA_11)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN12/$detail_quota_budget->DATA_12)*100, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format(($tot_Q3_used/$tot_Q3_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format(($avg_Q3_used/$avg_Q3_budget)*100, 0, ',', '.');; ?></strong></td>
                        <td><?php echo number_format(($detail_quota_used->BLN12/$detail_quota_budget->DATA_01)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN12/$detail_quota_budget->DATA_02)*100, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(($detail_quota_used->BLN12/$detail_quota_budget->DATA_03)*100, 0, ',', '.'); ?></td>
                        <td><strong><?php echo number_format(($tot_Q4_used/$tot_Q4_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format(($avg_Q4_used/$avg_Q4_budget)*100, 0, ',', '.');; ?></strong></td>
                        <td><strong><?php echo number_format(($tot_smt2_used/$tot_smt2_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format(($avg_smt2_used/$avg_smt2_budget)*100, 0, ',', '.');; ?></strong></td>
                        <td><strong><?php echo number_format(($tot_fy_used/$tot_fy_budget)*100, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo number_format(($avg_fy_used/$avg_fy_budget)*100, 0, ',', '.');; ?></strong></td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr align="right">
                        <td><strong>BUDGET</strong></td>
                        <td>:</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>0</strong></td>
                    </tr>
                    <tr align="center">
                            <td><strong>ACT/BGT %<</strong></td>
                            <td>:</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                            <td><strong>0</strong></td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
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