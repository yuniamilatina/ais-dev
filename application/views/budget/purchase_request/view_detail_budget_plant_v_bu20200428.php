<div class="pull">
    <table width='100%' style="font-size: 10px;">
        <?php 
            $act_month = date('Ym');
            $bg_color = 'background-color:blue;' 
        ?>
        <tr>
            <td width='4%'></td>
            <td width='1%'></td>
            <td width='6.5%' align='center' style="font-weight: bold;">APR</td>
            <td width='6.5%' align='center' style="font-weight: bold;">MEI</td>
            <td width='6.5%' align='center' style="font-weight: bold;">JUN</td>
            <td width='6.5%' align='center' style="font-weight: bold;">JUL</td>
            <td width='6.5%' align='center' style="font-weight: bold;">AGU</td>
            <td width='6.5%' align='center' style="font-weight: bold;">SEP</td>
            <td width='6.5%' align='center' style="font-weight: bold;">OKT</td>
            <td width='6.5%' align='center' style="font-weight: bold;">NOV</td>
            <td width='6.5%' align='center' style="font-weight: bold;">DES</td>
            <td width='6.5%' align='center' style="font-weight: bold;">JAN</td>
            <td width='6.5%' align='center' style="font-weight: bold;">FEB</td>
            <td width='6.5%' align='center' style="font-weight: bold;">MAR</td>
            <td width='7%' align='center' style="font-weight: bold;">YTD</td>
            <td width='7%' align='center' style="font-weight: bold;">TOTAL</td>
            <td width='3%' align='center' style="font-weight: bold;">(%)</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <!-- //===== Update for Data SALES --- By ANU 20200417 -->
        <?php if($detail_sales != NULL && $bgt_type <> 'CAPEX'){ ?>
                                <tr>
                                    <td width='4%' style="font-weight: bold;">Sales Ori</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                            $tot_sales = 0;
                                            $ytd_sales = 0;
                                                echo number_format($detail_sales->PBLN04, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN04;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php
                                                echo number_format($detail_sales->PBLN05, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN05;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                                echo number_format($detail_sales->PBLN06, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN06;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                                echo number_format($detail_sales->PBLN07, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN07;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN08, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN08;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php   
                                                echo number_format($detail_sales->PBLN09, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN09;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php
                                                echo number_format($detail_sales->PBLN10, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_sales = $ytd_sales + $detail_budget->PBLN10;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN11, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN11;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN12, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN12;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN13, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN13;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN14, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN14;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN15, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN15;
                                                }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($ytd_sales, 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($tot_sales, 0, ',', '.'); ?>
                                    </td>
                                    <td width='3%' align='right'>
                                        <?php                                              
                                                echo '100,00%';
                                        ?>
                                    </td> 
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr style="background-color: yellow;">
                                    <td width='4%' style="font-weight: bold; font-size:8px;">Sal Rev <?php echo substr($detail_sales->CHR_UPLOAD_DATE,6,2) . "/" . substr($detail_sales->CHR_UPLOAD_DATE,4,2); ?></td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                            $tot_salesrev = 0;
                                            $ytd_salesrev = 0;
                                                echo number_format($detail_sales->REVBLN04, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN04;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php
                                                echo number_format($detail_sales->REVBLN05, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN05;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                                echo number_format($detail_sales->REVBLN06, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN06;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                                echo number_format($detail_sales->REVBLN07, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN07;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN08, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN08;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php   
                                                echo number_format($detail_sales->REVBLN09, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN09;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php
                                                echo number_format($detail_sales->REVBLN10, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_budget->REVBLN10;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN11, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN11;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN12, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN12;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN13, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN13;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN14, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN14;
                                                }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN15, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN15;
                                                }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($ytd_salesrev, 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($tot_salesrev, 0, ',', '.'); ?>
                                    </td>
                                    <td width='3%' align='right'>
                                        <?php                                              
                                                if($detail_sales != NULL){
                                                    $percent_salesrev = ($tot_salesrev/$tot_sales)*100;
                                                } else {
                                                    $percent_salesrev = 0;
                                                }
                                                
                                                echo number_format($percent_salesrev, 2, ',', '.') . '%';
                                        ?>
                                    </td> 
                                </tr>
                                <?php } ?>
                                <!-- //===== End Update by ANU =====// -->
                                <tr><td>&nbsp;</td></tr>
        <tr>
            <td width='4%' style="font-weight: bold;">Plan</td>
            <td width='1%' align='center'>:</td>
            <td width='6.5%' align='right'>
                <?php 
                    $tot_plan = 0;
                    $ytd_plan = 0;
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN04, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN04;
                        if ($act_month >= $tahun . '04'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN04;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN05, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN05;
                        if ($act_month >= $tahun . '05'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN05;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN06, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN06;
                        if ($act_month >= $tahun . '06'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN06;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN07, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN07;
                        if ($act_month >= $tahun . '07'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN07;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN08, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN08;
                        if ($act_month >= $tahun . '08'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN08;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN09, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN09;
                        if ($act_month >= $tahun . '09'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN09;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN10, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN10;
                        if ($act_month >= $tahun . '10'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN10;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN11, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN11;
                        if ($act_month >= $tahun . '11'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN11;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN12, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN12;
                        if ($act_month >= $tahun . '12'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN12;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN13, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN13;
                        if ($act_month >= $tahun + 1 . '01'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN13;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN14, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN14;
                        if ($act_month >= $tahun + 1 . '02'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN14;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($detail_budget != NULL){ 
                        echo number_format($detail_budget->PBLN15, 0, ',', '.');
                        $tot_plan = $tot_plan + $detail_budget->PBLN15;
                        if ($act_month >= $tahun + 1 . '03'){
                            $ytd_plan = $ytd_plan + $detail_budget->PBLN15;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='7%' align='right'>
                <?php echo number_format($ytd_plan, 0, ',', '.'); ?>
            </td>
            <td width='7%' align='right'>
                <?php echo number_format($tot_plan, 0, ',', '.'); ?>
            </td>
            <td width='3%' align='right'>
                <?php  
                    if($act_periode < $periode_smt2){
                        if($detail_sales != NULL && $bgt_type <> 'CAPEX'){
                            $percent_plan = ($tot_plan/$tot_sales)*100;
                        } else {
                            $percent_plan = 100;
                        }   
                    } else {
                        $percent_plan = 0;
                    }

                    echo number_format($percent_plan, 2, ',', '.') . '%';
                ?>
            </td> 
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr style="background-color: yellow;">
                                    <td width='4%' style="font-weight: bold;">Revise</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                            $tot_rev = 0;
                                            $ytd_rev = 0;
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln04 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln04 = ($detail_budget->PBLN04 / $detail_sales->PBLN04) * ($detail_sales->REVBLN04); 
                                                        echo number_format($mon_bln04, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln04;
                                                        if ($act_month >= $tahun . '04'){
                                                            $ytd_rev = $ytd_rev + $mon_bln04;
                                                        }
                                                    } else {
                                                        echo $mon_bln04;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN04, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN04;
                                                    if ($act_month >= $tahun . '04'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN04;
                                                    }
                                                }
                                            } else {                                                
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln05 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln05 = ($detail_budget->PBLN05 / $detail_sales->PBLN05) * ($detail_sales->REVBLN05); 
                                                        echo number_format($mon_bln05, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln05;
                                                        if ($act_month >= $tahun . '05'){
                                                            $ytd_rev = $ytd_rev + $mon_bln05;
                                                        }
                                                    } else {
                                                        echo $mon_bln05;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN05, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN05;
                                                    if ($act_month >= $tahun . '05'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN05;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php 
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln06 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln06 = ($detail_budget->PBLN06 / $detail_sales->PBLN06) * ($detail_sales->REVBLN06); 
                                                        echo number_format($mon_bln06, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln06;
                                                        if ($act_month >= $tahun . '06'){
                                                            $ytd_rev = $ytd_rev + $mon_bln06;
                                                        }
                                                    } else {
                                                        echo $mon_bln06;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN06, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN06;
                                                    if ($act_month >= $tahun . '06'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN06;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln07 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln07 = ($detail_budget->PBLN07 / $detail_sales->PBLN07) * ($detail_sales->REVBLN07); 
                                                        echo number_format($mon_bln07, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln07;
                                                        if ($act_month >= $tahun . '07'){
                                                            $ytd_rev = $ytd_rev + $mon_bln07;
                                                        }
                                                    } else {
                                                        echo $mon_bln07;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN07, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN07;
                                                    if ($act_month >= $tahun . '07'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN07;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln08 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln08 = ($detail_budget->PBLN08 / $detail_sales->PBLN08) * ($detail_sales->REVBLN08); 
                                                        echo number_format($mon_bln08, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln08;
                                                        if ($act_month >= $tahun . '08'){
                                                            $ytd_rev = $ytd_rev + $mon_bln08;
                                                        }
                                                    } else {
                                                        echo $mon_bln08;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN08, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN08;
                                                    if ($act_month >= $tahun . '08'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN08;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln09 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln09 = ($detail_budget->PBLN09 / $detail_sales->PBLN09) * ($detail_sales->REVBLN09); 
                                                        echo number_format($mon_bln09, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln09;
                                                        if ($act_month >= $tahun . '09'){
                                                            $ytd_rev = $ytd_rev + $mon_bln09;
                                                        }
                                                    } else {
                                                        echo $mon_bln09;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN09, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN09;
                                                    if ($act_month >= $tahun . '09'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN09;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln10 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln10 = ($detail_budget->PBLN10 / $detail_sales->PBLN10) * ($detail_sales->REVBLN10); 
                                                        echo number_format($mon_bln10, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln10;
                                                        if ($act_month >= $tahun . '10'){
                                                            $ytd_rev = $ytd_rev + $mon_bln10;
                                                        }
                                                    } else {
                                                        echo $mon_bln10;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN10, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN10;
                                                    if ($act_month >= $tahun . '10'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN10;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln11 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln11 = ($detail_budget->PBLN11 / $detail_sales->PBLN11) * ($detail_sales->REVBLN11); 
                                                        echo number_format($mon_bln11, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln11;
                                                        if ($act_month >= $tahun . '11'){
                                                            $ytd_rev = $ytd_rev + $mon_bln11;
                                                        }
                                                    } else {
                                                        echo $mon_bln11;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN11, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN11;
                                                    if ($act_month >= $tahun . '11'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN11;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln12 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln12 = ($detail_budget->PBLN12 / $detail_sales->PBLN12) * ($detail_sales->REVBLN12); 
                                                        echo number_format($mon_bln12, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln12;
                                                        if ($act_month >= $tahun . '12'){
                                                            $ytd_rev = $ytd_rev + $mon_bln12;
                                                        }
                                                    } else {
                                                        echo $mon_bln12;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN12, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN12;
                                                    if ($act_month >= $tahun . '12'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN12;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln13 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln13 = ($detail_budget->PBLN13 / $detail_sales->PBLN13) * ($detail_sales->REVBLN13); 
                                                        echo number_format($mon_bln13, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln13;
                                                        if ($act_month >= $tahun + 1 . '01'){
                                                            $ytd_rev = $ytd_rev + $mon_bln13;
                                                        }
                                                    } else {
                                                        echo $mon_bln13;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN13, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN13;
                                                    if ($act_month >= $tahun + 1 . '01'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN13;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln14 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln14 = ($detail_budget->PBLN14 / $detail_sales->PBLN14) * ($detail_sales->REVBLN14); 
                                                        echo number_format($mon_bln14, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln14;
                                                        if ($act_month >= $tahun + 1 . '02'){
                                                            $ytd_rev = $ytd_rev + $mon_bln14;
                                                        }
                                                    } else {
                                                        echo $mon_bln14;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN14, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN14;
                                                    if ($act_month >= $tahun + 1 . '02'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN14;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                    $mon_bln15 = 0;
                                                    if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                        $mon_bln15 = ($detail_budget->PBLN15 / $detail_sales->PBLN15) * ($detail_sales->REVBLN15); 
                                                        echo number_format($mon_bln15, 0, ',', '.');

                                                        $tot_rev = $tot_rev + $mon_bln15;
                                                        if ($act_month >= $tahun + 1 . '03'){
                                                            $ytd_rev = $ytd_rev + $mon_bln15;
                                                        }
                                                    } else {
                                                        echo $mon_bln15;
                                                    }
                                                    //=====  Additional Sales Data --- Update by ANU 20200421 =====//
                                                } else {
                                                    echo number_format($revisi_budget->PBLN15, 0, ',', '.');
                                                    $tot_rev = $tot_rev + $revisi_budget->PBLN15;
                                                    if ($act_month >= $tahun + 1 . '03'){
                                                        $ytd_rev = $ytd_rev + $revisi_budget->PBLN15;
                                                    }
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>  
                                    <td width='7%' align='right'>
                                        <?php  
                                            echo number_format($ytd_rev, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            echo number_format($tot_rev, 0, ',', '.');
                                        ?>
                                    </td> 
                                    <td width='3%' align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                    $percent_rev = ($tot_rev/$tot_salesrev)*100;
                                                } else {
                                                    $percent_rev = 0;
                                                }                                                
                                            } else {
                                                $percent_rev = 0;
                                            }   
                                            
                                            echo number_format($percent_rev, 2, ',', '.') . '%';
                                        ?>
                                    </td> 
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
                    echo number_format($percent_lim2, 2, ',', '.') . '%';
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
                    echo number_format($percent_topup, 2, ',', '.') . '%';
                ?>
            </td>
        </tr>-->
        <!-- LIMIT AFTER TOP UP -->
        <tr>
            <td width='4%' style="font-weight: bold;">Limit</td>
            <td width='1%' align='center'>:</td>
            <td width='6.5%' align='right'>
                <?php 
                    $tot_lim = 0;
                    $ytd_lim = 0;
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN04, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN04;
                        if ($act_month >= $tahun . '04'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN04;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN05, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN05;
                        if ($act_month >= $tahun . '05'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN05;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN06, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN06;
                        if ($act_month >= $tahun . '06'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN06;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN07, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN07;
                        if ($act_month >= $tahun . '07'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN07;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN08, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN08;
                        if ($act_month >= $tahun . '08'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN08;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN09, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN09;
                        if ($act_month >= $tahun . '09'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN09;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN10, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN10;
                        if ($act_month >= $tahun . '10'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN10;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN11, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN11;
                        if ($act_month >= $tahun . '11'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN11;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN12, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN12;
                        if ($act_month >= $tahun . '12'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN12;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN13, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN13;
                        if ($act_month >= $tahun + 1 . '01'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN13;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN14, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN14;
                        if ($act_month >= $tahun + 1 . '02'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN14;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL){ 
                        echo number_format($limit_budget->PBLN15, 0, ',', '.');
                        $tot_lim = $tot_lim + $limit_budget->PBLN15;
                        if ($act_month >= $tahun + 1 . '03'){
                            $ytd_lim = $ytd_lim + $limit_budget->PBLN15;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='7%' align='right'>
                <?php  
                    echo number_format($ytd_lim, 0, ',', '.');                                                
                ?>
            </td>
            <td width='7%' align='right'>
                <?php  
                    echo number_format($tot_lim, 0, ',', '.');                                                
                ?>
            </td>
            <td width='3%' align='right'>
                <?php
                    $percent_lim = ($tot_lim/$tot_plan)*100;
                    echo number_format($percent_lim, 2, ',', '.') . '%';
                ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr style="background-color: yellow;">
            <td width='4%' style="font-weight: bold;">Act PR</td>
            <td width='1%' align='center'>:</td>
            <td width='6.5%' align='right'>
                <?php 
                    $tot_pr = 0;
                    $ytd_pr = 0;
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN04, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN04;
                        if ($act_month >= $tahun . '04'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN04;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN05, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN05;
                        if ($act_month >= $tahun . '05'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN05;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN06, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN06;
                        if ($act_month >= $tahun . '06'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN06;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN07, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN07;
                        if ($act_month >= $tahun . '07'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN07;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN08, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN08;
                        if ($act_month >= $tahun . '08'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN08;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN09, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN09;
                        if ($act_month >= $tahun . '09'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN09;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN10, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN10;
                        if ($act_month >= $tahun . '10'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN10;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN11, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN11;
                        if ($act_month >= $tahun . '11'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN11;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN12, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN12;
                        if ($act_month >= $tahun . '12'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN12;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN13, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN13;
                        if ($act_month >= $tahun + 1 . '01'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN13;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN14, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN14;
                        if ($act_month >= $tahun + 1 . '02'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN14;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($actual_real != NULL){ 
                        echo number_format($actual_real->OPRBLN15, 0, ',', '.');
                        $tot_pr = $tot_pr + $actual_real->OPRBLN15;
                        if ($act_month >= $tahun + 1 . '03'){
                            $ytd_pr = $ytd_pr + $actual_real->OPRBLN15;
                        }
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='7%' align='right'>
                <?php  
                    echo number_format($ytd_pr, 0, ',', '.');
                ?>
            </td>
            <td width='7%' align='right'>
                <?php  
                    echo number_format($tot_pr, 0, ',', '.');
                ?>
            </td>
            <td width='3%' align='right'>
                <?php
                    if($act_periode < $periode_smt2){
                        if($tot_rev != 0 && $bgt_type <> 'CAPEX'){
                            // $percent_pr = ($tot_pr/$tot_rev)*100;
                            $percent_pr = ($tot_pr/$tot_salesrev)*100;
                        } else {
                            if($tot_plan != 0){
                                $percent_pr = ($tot_pr/$tot_plan)*100;
                            } else {
                                $percent_pr = 0;
                            } 
                        }                                                                                               
                    } else {
                        if($tot_rev != 0 && $bgt_type <> 'CAPEX'){
                            // $percent_pr = ($tot_pr/$tot_rev)*100;
                            $percent_pr = ($tot_pr/$tot_salesrev)*100;
                        } else {
                            if($tot_rev != 0){
                                $percent_pr = ($tot_pr/$tot_rev)*100;
                            } else {
                                $percent_pr = 0;
                            } 
                        }                                                                                               
                    }

                    echo number_format($percent_pr, 2, ',', '.') . '%';
                ?>
            </td>
        </tr> 
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td width='4%' style="font-weight: bold;">Balance</td>
            <td width='1%' align='center'>:</td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN04 - $actual_real->OPRBLN04;
                        $balance = ($detail_budget->PBLN04 * 0.7) - $actual_real->OPRBLN04;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN05 - $actual_real->OPRBLN05;
                        $balance = ($detail_budget->PBLN05 * 0.7) - $actual_real->OPRBLN05;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN06 - $actual_real->OPRBLN06;
                        $balance = ($detail_budget->PBLN06 * 0.7) - $actual_real->OPRBLN06;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN07 - $actual_real->OPRBLN07;
                        $balance = ($detail_budget->PBLN07 * 0.7) - $actual_real->OPRBLN07;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN08 - $actual_real->OPRBLN08;
                        $balance = ($detail_budget->PBLN08 * 0.7) - $actual_real->OPRBLN08;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN09 - $actual_real->OPRBLN09;
                        $balance = ($detail_budget->PBLN09 * 0.7) - $actual_real->OPRBLN09;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN10 - $actual_real->OPRBLN10;
                        $balance = ($detail_budget->PBLN10 * 0.7) - $actual_real->OPRBLN10;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN11 - $actual_real->OPRBLN11;
                        $balance = ($detail_budget->PBLN11 * 0.7) - $actual_real->OPRBLN11;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN12 - $actual_real->OPRBLN12;
                        $balance = ($detail_budget->PBLN12 * 0.7) - $actual_real->OPRBLN12;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN13 - $actual_real->OPRBLN13;
                        $balance = ($detail_budget->PBLN13 * 0.7) - $actual_real->OPRBLN13;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN14 - $actual_real->OPRBLN14;
                        $balance = ($detail_budget->PBLN14 * 0.7) - $actual_real->OPRBLN14;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='6.5%' align='right' >
                <?php  
                    if($limit_budget != NULL && $actual_real != NULL){
                        //$balance = $limit_budget->PBLN15 - $actual_real->OPRBLN15;
                        $balance = ($detail_budget->PBLN15 * 0.7) - $actual_real->OPRBLN15;
                        echo number_format($balance, 0, ',', '.');
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td width='7%' align='right' >
                <?php  
                    $ytd_bal = $ytd_lim - $ytd_pr;
                    echo number_format($ytd_bal, 0, ',', '.');
                ?>
            </td>
            <td width='7%' align='right' >
                <?php  
                    $tot_bal = $tot_lim - $tot_pr;
                    echo number_format($tot_bal, 0, ',', '.');
                ?>
            </td>
            <td width='3%' align='right'>
                <?php
                    $percent_bal = ($tot_bal/$tot_plan)*100;
                    echo number_format($percent_bal, 2, ',', '.') . '%';
                ?>
            </td>
        </tr>
        <?php if($detail_sales != NULL && $bgt_type <> 'CAPEX'){ ?>
                                <tr><td>&nbsp;</td></tr>
                                <tr style="background-color: yellow;">
                                    <td width='4%' style="font-weight: bold; font-size:8px;">Balan Rev</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln04 - $actual_real->OPRBLN04;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln05 - $actual_real->OPRBLN05;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln06 - $actual_real->OPRBLN06;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln07 - $actual_real->OPRBLN07;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln08 - $actual_real->OPRBLN08;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln09 - $actual_real->OPRBLN09;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.56%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln10 - $actual_real->OPRBLN10;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln11 - $actual_real->OPRBLN11;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln12 - $actual_real->OPRBLN12;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln13 - $actual_real->OPRBLN13;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln14 - $actual_real->OPRBLN14;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='6.5%' align='right' >
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln14 - $actual_real->OPRBLN15;
                                                echo number_format($balance_rev, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right' >
                                        <?php  
                                            $ytd_bal_rev = $ytd_rev - $ytd_pr;
                                            echo number_format($ytd_bal_rev, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td width='7%' align='right' >
                                        <?php  
                                            $tot_bal_rev = $tot_rev - $tot_pr;
                                            echo number_format($tot_bal_rev, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td width='3%' align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                if($tot_rev != 0){
                                                    $percent_bal_rev = ($tot_bal_rev/$tot_rev)*100;
                                                } else {
                                                    $percent_bal_rev = 0;
                                                }                                                
                                            } else {
                                                if($tot_rev != 0){
                                                    $percent_bal_rev = ($tot_bal_rev/$tot_rev)*100;
                                                } else {
                                                    $percent_bal_rev = 0;
                                                }                                                
                                            }
                                            
                                            echo number_format($percent_bal_rev, 2, ',', '.') . '%';
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td width='4%' style="font-weight: bold;">Act GR</td>
            <td width='1%' align='center'>:</td>
            <td width='6.5%' align='right'>
                <?php
                    $tot_gr = 0;
                    $ytd_gr = 0;
                    echo number_format($actual_gr[0], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[0];
                    $ytd_gr = $ytd_gr + $actual_gr[0];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[1], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[1];
                    $ytd_gr = $ytd_gr + $actual_gr[1];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[2], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[2];   
                    $ytd_gr = $ytd_gr + $actual_gr[2]; 
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[3], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[3];
                    $ytd_gr = $ytd_gr + $actual_gr[3];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[4], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[4];  
                    $ytd_gr = $ytd_gr + $actual_gr[4];  
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[5], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[5];
                    $ytd_gr = $ytd_gr + $actual_gr[5];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[6], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[6];
                    $ytd_gr = $ytd_gr + $actual_gr[6];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[7], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[7];
                    $ytd_gr = $ytd_gr + $actual_gr[7];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[8], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[8];
                    $ytd_gr = $ytd_gr + $actual_gr[8];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[9], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[9];
                    $ytd_gr = $ytd_gr + $actual_gr[9];
                ?>
            </td>
            <td width='6.5%' align='right'>
                <?php 
                    echo number_format($actual_gr[10], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[10];
                    $ytd_gr = $ytd_gr + $actual_gr[10];
                ?>
            </td>
            <td width='6.5%' align='right' >
                <?php 
                    echo number_format($actual_gr[11], 0, ',', '.'); 
                    $tot_gr = $tot_gr + $actual_gr[11];
                    $ytd_gr = $ytd_gr + $actual_gr[11];
                ?>
            </td>
            <td width='7%' align='right' >
                <?php 
                    echo number_format($ytd_gr, 0, ',', '.');
                ?>
            </td>
            <td width='7%' align='right' >
                <?php 
                    echo number_format($tot_gr, 0, ',', '.');
                ?>
            </td>
            <td width='3%' align='right'>
                <?php
                    $percent_gr = ($tot_gr/$tot_plan)*100;
                    echo number_format($percent_gr, 2, ',', '.') . '%';
                ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</div>
    
    
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function() {
        document.body.style.zoom = 0.75;
        
        var table = $('#dataTable').DataTable({
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>
