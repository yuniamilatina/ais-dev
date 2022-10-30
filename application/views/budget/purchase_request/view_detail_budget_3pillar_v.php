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
    <tr>
        <td width='4%' style="font-weight: bold;">Plan</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php 
                $tot_plan = 0;
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN04, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN04;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN05, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN05;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN06, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN06;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN07, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN07;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN08, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN08;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN09, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN09;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN10, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN10;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN11, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN11;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN12, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN12;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN13, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN13;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN14, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN14;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($detail_budget != NULL){ 
                    echo number_format($detail_budget->PBLN15, 0, ',', '.');
                    $tot_plan = $tot_plan + $detail_budget->PBLN15;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php echo number_format($tot_plan, 0, ',', '.'); ?>
        </td>
<!--        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    echo '100,0%';
                } else {
                    echo '0,0%';
                }
            ?>
        </td> -->
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td width='4%' style="font-weight: bold;">Revisi</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php 
                $tot_rev = 0;
                if($revisi_budget != NULL){
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN04, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN04;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($revisi_budget != NULL){ 
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN05, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN05;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($revisi_budget != NULL){ 
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN06, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN06;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN07, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN07;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN08, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN08;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){ 
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN09, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN09;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){ 
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN10, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN10;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN11, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN11;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){ 
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN12, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN12;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){ 
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN13, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN13;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){ 
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN14, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN14;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($revisi_budget != NULL){
                    if($act_periode < $periode_smt2){
                        echo '0';
                    } else {
                        echo number_format($revisi_budget->PBLN15, 0, ',', '.');
                        $tot_rev = $tot_rev + $revisi_budget->PBLN15;
                    }
                } else {
                    echo '0';
                }
            ?>
        </td>  
        <td width='7%' align='right'>
            <?php  
                echo number_format($tot_rev, 0, ',', '.');
            ?>
        </td> 
<!--        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    echo '0,0%';
                } else {
                    echo '100,0%';
                }                                            
            ?>
        </td> -->
    </tr>
    <tr><td>&nbsp;</td></tr>
    <!-- LIMIT 70% BEFORE TOP UP -->
<!--    <tr>
        <td width='4%' style="font-weight: bold;">Limit 70%</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php 
                $tot_lim = 0;
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN04 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN04 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN05 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN05 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN06 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN06 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN07 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN07 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN08 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN08 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN09 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN09 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN10 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN10 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN11 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN11 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN12 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN12 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN13 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN13 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN14 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN14 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget = $detail_budget->PBLN15 * 0.7;
                } else {
                    $lim_budget = $revisi_budget->PBLN15 * 0.7;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget, 0, ',', '.');
                    $tot_lim = $tot_lim + $lim_budget;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                echo number_format($tot_lim, 0, ',', '.');                                                
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                $percent_lim = ($tot_lim/$tot_plan)*100;
                echo number_format($percent_lim, 1, ',', '.') . '%';
            ?>
        </td> 
    </tr>-->
    <!-- LIMIT 50% BEFORE TOP UP -->
<!--    <tr>
        <td width='4%' style="font-weight: bold;">Limit 50%</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php 
                $tot_lim2 = 0;
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN04 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN04 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN05 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN05 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN06 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN06 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN07 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN07 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN08 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN08 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN09 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN09 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN10 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN10 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN11 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN11 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN12 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN12 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN13 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN13 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN14 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN14 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                if($act_periode < $periode_smt2){
                    $lim_budget2 = $detail_budget->PBLN15 * 0.5;
                } else {
                    $lim_budget2 = $revisi_budget->PBLN15 * 0.5;
                }

                if($limit_budget != NULL){ 
                    echo number_format($lim_budget2, 0, ',', '.');
                    $tot_lim2 = $tot_lim2 + $lim_budget2;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                echo number_format($tot_lim2, 0, ',', '.');                                                
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                $percent_lim2 = ($tot_lim2/$tot_plan)*100;
                echo number_format($percent_lim2, 1, ',', '.') . '%';
            ?>
        </td> 
    </tr>
    <tr>
        <td width='4%' style="font-weight: bold;">Top Up</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php
                $tot_topup = 0;
                echo number_format($topup_budget[0], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[0];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[1], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[1];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[2], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[2];    
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[3], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[3];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[4], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[4];    
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[5], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[5];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[6], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[6];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[7], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[7];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[8], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[8];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[9], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[9];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($topup_budget[10], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[10];
            ?>
        </td>
        <td width='7%' align='right' >
            <?php 
                echo number_format($topup_budget[11], 0, ',', '.'); 
                $tot_topup = $tot_topup + $topup_budget[11];
            ?>
        </td>
        <td width='7%' align='right' >
            <?php 
                echo number_format($tot_topup, 0, ',', '.');
            ?>
        </td>
        <td width='7%' align='right'>
            <?php
                $percent_topup = ($tot_topup/$tot_plan)*100;
                echo number_format($percent_topup, 1, ',', '.') . '%';
            ?>
        </td>
    </tr>-->
    <!-- LIMIT AFTER TOP UP -->
    <tr>
        <td width='4%' style="font-weight: bold;">Limit</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php 
                $tot_lim = 0;
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN04, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN04;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN05, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN05;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN06, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN06;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN07, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN07;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN08, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN08;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN09, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN09;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN10, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN10;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN11, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN11;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN12, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN12;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN13, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN13;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN14, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN14;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL){ 
                    echo number_format($limit_budget->PBLN15, 0, ',', '.');
                    $tot_lim = $tot_lim + $limit_budget->PBLN15;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                echo number_format($tot_lim, 0, ',', '.');                                                
            ?>
        </td>
<!--        <td width='7%' align='right'>
            <?php
                $percent_lim = ($tot_lim/$tot_plan)*100;
                echo number_format($percent_lim, 1, ',', '.') . '%';
            ?>
        </td>-->
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td width='4%' style="font-weight: bold;">Act PR</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php 
                $tot_pr = 0;
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN04, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN04;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN05, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN05;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN06, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN06;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN07, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN07;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN08, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN08;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN09, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN09;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN10, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN10;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN11, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN11;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN12, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN12;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN13, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN13;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN14, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN14;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($actual_real != NULL){ 
                    echo number_format($actual_real->OPRBLN15, 0, ',', '.');
                    $tot_pr = $tot_pr + $actual_real->OPRBLN15;
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                echo number_format($tot_pr, 0, ',', '.');
            ?>
        </td>
<!--        <td width='7%' align='right'>
            <?php
                $percent_pr = ($tot_pr/$tot_plan)*100;
                echo number_format($percent_pr, 1, ',', '.') . '%';
            ?>
        </td>-->
    </tr> 
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td width='4%' style="font-weight: bold;">Balance</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN04 - $actual_real->OPRBLN04;
                    //$balance = ($detail_budget->PBLN04 * 0.7) - $actual_real->OPRBLN04;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN05 - $actual_real->OPRBLN05;
                    //$balance = ($detail_budget->PBLN05 * 0.7) - $actual_real->OPRBLN05;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN06 - $actual_real->OPRBLN06;
                    //$balance = ($detail_budget->PBLN06 * 0.7) - $actual_real->OPRBLN06;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN07 - $actual_real->OPRBLN07;
                    //$balance = ($detail_budget->PBLN07 * 0.7) - $actual_real->OPRBLN07;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN08 - $actual_real->OPRBLN08;
                    //$balance = ($detail_budget->PBLN08 * 0.7) - $actual_real->OPRBLN08;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN09 - $actual_real->OPRBLN09;
                    //$balance = ($detail_budget->PBLN09 * 0.7) - $actual_real->OPRBLN09;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN10 - $actual_real->OPRBLN10;
                    //$balance = ($detail_budget->PBLN10 * 0.7) - $actual_real->OPRBLN10;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN11 - $actual_real->OPRBLN11;
                    //$balance = ($detail_budget->PBLN11 * 0.7) - $actual_real->OPRBLN11;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN12 - $actual_real->OPRBLN12;
                    //$balance = ($detail_budget->PBLN12 * 0.7) - $actual_real->OPRBLN12;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN13 - $actual_real->OPRBLN13;
                    //$balance = ($detail_budget->PBLN13 * 0.7) - $actual_real->OPRBLN13;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right'>
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN14 - $actual_real->OPRBLN14;
                    //$balance = ($detail_budget->PBLN14 * 0.7) - $actual_real->OPRBLN14;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right' >
            <?php  
                if($limit_budget != NULL && $actual_real != NULL){
                    $balance = $limit_budget->PBLN15 - $actual_real->OPRBLN15;
                    //$balance = ($detail_budget->PBLN15 * 0.7) - $actual_real->OPRBLN15;
                    echo number_format($balance, 0, ',', '.');
                } else {
                    echo '0';
                }
            ?>
        </td>
        <td width='7%' align='right' >
            <?php  
                $tot_bal = $tot_lim - $tot_pr;
                echo number_format($tot_bal, 0, ',', '.');
            ?>
        </td>
<!--        <td width='7%' align='right'>
            <?php
                $percent_bal = ($tot_bal/$tot_plan)*100;
                echo number_format($percent_bal, 1, ',', '.') . '%';
            ?>
        </td>-->
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td width='4%' style="font-weight: bold;">Act GR</td>
        <td width='1%' align='center'>:</td>
        <td width='7%' align='right'>
            <?php
                $tot_gr = 0;
                echo number_format($actual_gr[0], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[0];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[1], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[1];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[2], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[2];    
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[3], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[3];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[4], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[4];    
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[5], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[5];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[6], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[6];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[7], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[7];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[8], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[8];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[9], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[9];
            ?>
        </td>
        <td width='7%' align='right'>
            <?php 
                echo number_format($actual_gr[10], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[10];
            ?>
        </td>
        <td width='7%' align='right' >
            <?php 
                echo number_format($actual_gr[11], 0, ',', '.'); 
                $tot_gr = $tot_gr + $actual_gr[11];
            ?>
        </td>
        <td width='7%' align='right' >
            <?php 
                echo number_format($tot_gr, 0, ',', '.');
            ?>
        </td>
<!--        <td width='7%' align='right'>
            <?php
                $percent_gr = ($tot_gr/$tot_plan)*100;
                echo number_format($percent_gr, 1, ',', '.') . '%';
            ?>
        </td>-->
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
