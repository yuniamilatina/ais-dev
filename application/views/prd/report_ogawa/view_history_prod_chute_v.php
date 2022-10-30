                    <div class="grid-body">
                        <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">No</th>
                                    <th rowspan="2" style="text-align:center;">Part No</th>
                                    <th rowspan="2" style="text-align:center;">Back No</th>
                                    <th rowspan="2" style="text-align:center;">Part No Cust</th>
                                    <th colspan="4" style="text-align:center;">MTD</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Plan</th>
                                    <th style="text-align:center;background-color:#55D785;color:white;">Act OK</th>
                                    <th style="text-align:center;background-color:red;color:white;">Act NG</th>
                                    <th style="text-align:center;">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $mtd_plan = 0;
                                $mtd_act = 0;
                                foreach ($data as $val) {
                                    if ($val->CHR_BACK_NO == 'TOTAL') {
                                        echo "<tr align='center' style='background-color:whitesmoke; font-weight:900;'>";
                                        echo "<td style='color:whitesmoke'>" . $no . "</td>";
                                    } else {
                                        echo "<tr align='center'>";
                                        echo "<td>" . $no . "</td>";
                                    }
                                    echo "<td align='left'>" . $val->CHR_PART_NO . "</td>";
                                    echo "<td>" . $val->CHR_BACK_NO . "</td>";
                                    
                                    $part_no_cust = $this->db->query("select distinct CHR_CUS_PART_NO from TM_SHIPPING_PARTS where CHR_PART_NO = '$val->CHR_PART_NO'")->result();
                                    $part_no_cust_value = "";
                                    if (count($part_no_cust) > 0) {
                                        foreach ($part_no_cust as $key => $value) {
                                            $part_no_cust_value .= $value->CHR_CUS_PART_NO;
                                            if ($key <> count($part_no_cust) - 1) {
                                                $part_no_cust_value .= " | ";
                                            }
                                        }
                                    }
                                    echo "<td>" . $part_no_cust_value . "</td>";

                                    $mtd_plan = $val->PLAN_01 + $val->PLAN_02 + $val->PLAN_03 + $val->PLAN_04 + $val->PLAN_05 + $val->PLAN_06 + $val->PLAN_07 + $val->PLAN_08 + $val->PLAN_09 + $val->PLAN_10 +
                                        $val->PLAN_11 + $val->PLAN_12 + $val->PLAN_13 + $val->PLAN_14 + $val->PLAN_15 + $val->PLAN_16 + $val->PLAN_17 + $val->PLAN_18 + $val->PLAN_19 + $val->PLAN_20 +
                                        $val->PLAN_21 + $val->PLAN_22 + $val->PLAN_23 + $val->PLAN_24 + $val->PLAN_25 + $val->PLAN_26 + $val->PLAN_27 + $val->PLAN_28 + $val->PLAN_29 + $val->PLAN_30 +
                                        $val->PLAN_31;
                                    $mtd_act = $val->ACT_01 + $val->ACT_02 + $val->ACT_03 + $val->ACT_04 + $val->ACT_05 + $val->ACT_06 + $val->ACT_07 + $val->ACT_08 + $val->ACT_09 + $val->ACT_10 +
                                        $val->ACT_11 + $val->ACT_12 + $val->ACT_13 + $val->ACT_14 + $val->ACT_15 + $val->ACT_16 + $val->ACT_17 + $val->ACT_18 + $val->ACT_19 + $val->ACT_20 +
                                        $val->ACT_21 + $val->ACT_22 + $val->ACT_23 + $val->ACT_24 + $val->ACT_25 + $val->ACT_26 + $val->ACT_27 + $val->ACT_28 + $val->ACT_29 + $val->ACT_30 +
                                        $val->ACT_31;
                                    $mtd_ng = $val->NG_01 + $val->NG_02 + $val->NG_03 + $val->NG_04 + $val->NG_05 + $val->NG_06 + $val->NG_07 + $val->NG_08 + $val->NG_09 + $val->NG_10 +
                                        $val->NG_11 + $val->NG_12 + $val->NG_13 + $val->NG_14 + $val->NG_15 + $val->NG_16 + $val->NG_17 + $val->NG_18 + $val->NG_19 + $val->NG_20 +
                                        $val->NG_21 + $val->NG_22 + $val->NG_23 + $val->NG_24 + $val->NG_25 + $val->NG_26 + $val->NG_27 + $val->NG_28 + $val->NG_29 + $val->NG_30 +
                                        $val->NG_31;
                                    $balance = $mtd_act - $mtd_plan;
                                    echo "<td>" . $mtd_plan . "</td>";
                                    echo "<td>" . $mtd_act . "</td>";
                                    echo "<td>" . $mtd_ng . "</td>";
                                    if($balance < 0){
                                        echo "<td style='color:red;font-weight:bold;'>" . $balance . "</td>";
                                    } else {
                                        echo "<td>" . $balance . "</td>";
                                    }
                                    
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <script>

                    $(document).ready(function() {
                        $('#dataTables2').DataTable({
                            scrollX: true,
                            lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, "All"]
                            ],
                            fixedColumns: {
                                leftColumns: 4,
                                rightColumns: 3
                            }
                        });
                    });

                    </script>