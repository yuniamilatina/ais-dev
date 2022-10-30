<div>
                            <table width='100%' height='180px' style="font-size: 14px;">
                                <?php 
                                    $act_month = date('Ym');
                                ?>
                                <tr>
                                    <td width='7%' align='center' style="font-weight: bold;">MIO IDR</td>
                                    <td width='1%'></td>
                                    <td width='6%' align='center' style="font-weight: bold;">APR</td>
                                    <td width='6%' align='center' style="font-weight: bold;">MEI</td>
                                    <td width='6%' align='center' style="font-weight: bold;">JUN</td>
                                    <td width='6%' align='center' style="font-weight: bold;">JUL</td>
                                    <td width='6%' align='center' style="font-weight: bold;">AGU</td>
                                    <td width='6%' align='center' style="font-weight: bold;">SEP</td>
                                    <td width='6%' align='center' style="font-weight: bold;">OKT</td>
                                    <td width='6%' align='center' style="font-weight: bold;">NOV</td>
                                    <td width='6%' align='center' style="font-weight: bold;">DES</td>
                                    <td width='6%' align='center' style="font-weight: bold;">JAN</td>
                                    <td width='6%' align='center' style="font-weight: bold;">FEB</td>
                                    <td width='6%' align='center' style="font-weight: bold;">MAR</td>
                                    <td width='8%' align='center' style="font-weight: bold;">YTD</td>
                                    <td width='8%' align='center' style="font-weight: bold;">TOTAL</td>
                                    <td width='1%'></td>
                                    <td width='3%' align='center' style="font-weight: bold;">(%)</td>
                                </tr>
                                <!-- //===== Update for Data SALES --- By ANU 20200417 -->
                                <?php if($detail_sales != NULL && $bgt_type <> 'CAPEX'){ ?>
                                <tr>
                                    <td style="font-weight: bold;">Sales</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            $tot_sales = 0;
                                            $ytd_sales = 0;
                                                echo number_format($detail_sales->PBLN04/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN04;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->PBLN05/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN05;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->PBLN06/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN06;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->PBLN07/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN07;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN08/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN08;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php   
                                                echo number_format($detail_sales->PBLN09/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN09;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->PBLN10/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN10;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN11/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN11;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN12/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN12;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN13/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN13;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN14/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN14;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN15/1000000, 0, ',', '.');
                                                $tot_sales = $tot_sales + $detail_sales->PBLN15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN15;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($ytd_sales/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($tot_sales/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php                                              
                                                echo '100,00%';
                                        ?>
                                    </td> 
                                </tr>
                                <tr style="background-color: yellow;">
                                    <td style="font-weight: bold;">Sales Guideline <?php //echo substr($detail_sales->CHR_UPLOAD_DATE,6,2) . "/" . substr($detail_sales->CHR_UPLOAD_DATE,4,2); ?></td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            $tot_salesrev = 0;
                                            $ytd_salesrev = 0;
                                                echo number_format($detail_sales->REVBLN04/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN04;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->REVBLN05/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN05;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->REVBLN06/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN06;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->REVBLN07/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN07;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN08/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN08;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php   
                                                echo number_format($detail_sales->REVBLN09/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN09;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->REVBLN10/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN10;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN11/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN11;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN12/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN12;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN13/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN13;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN14/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN14;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN15/1000000, 0, ',', '.');
                                                $tot_salesrev = $tot_salesrev + $detail_sales->REVBLN15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN15;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($ytd_salesrev/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($tot_salesrev/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
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
                                <?php if($bgt_type == 'CAPEX'){ ?>
                                <tr>
                                    <td style="font-weight: bold;">Plan</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            $tot_plan = 0;
                                            $ytd_plan = 0;
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN04/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN04;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN05/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN05;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN06/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN06;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN07/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN07;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN08/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN08;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN09/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN09;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN10/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN10;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN11/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN11;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN12/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN12;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN13/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN13;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN14/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN14;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN15/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $detail_budget->PBLN15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_plan = $ytd_plan + $detail_budget->PBLN15;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($ytd_plan/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($tot_plan/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
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
                                <tr style="background-color: yellow;">
                                    <td style="font-weight: bold;">Revise</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            $tot_rev = 0;
                                            $ytd_rev = 0;
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN04/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php 
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN05/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php 
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN06/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN07/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN08/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN09/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN10/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN11/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN12/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN13/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN14/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget != NULL){ 
                                                if($act_periode < $periode_smt2){
                                                    echo '0';
                                                } else {
                                                    echo number_format($revisi_budget->PBLN15/1000000, 0, ',', '.');
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
                                    <td align='right'>
                                        <?php  
                                            echo number_format($ytd_rev/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($tot_rev/1000000, 0, ',', '.');
                                        ?>
                                    </td> 
                                    <td></td>
                                    <td align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                $percent_rev = 0;                             
                                            } else {
                                                $percent_rev = 100;
                                            }   
                                            
                                            echo number_format($percent_rev, 2, ',', '.') . '%';                                            
                                        ?>
                                    </td> 
                                </tr>
                                <!-- LIMIT 70% BEFORE TOP UP -->
                                <tr>
                                    <td style="font-weight: bold;">Limit 70%</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            $tot_lim = 0;
                                            $ytd_lim = 0;
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN04 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN04 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN05 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN05 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN06 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN06 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN07 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN07 * 0.7;
                                            }
                                        
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN08 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN08 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN09 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN09 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN10 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN10 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN11 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN11 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN12 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN12 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN13 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN13 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN14 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN14 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget = $detail_budget->PBLN15 * 0.7;
                                            } else {
                                                $lim_budget = $revisi_budget->PBLN15 * 0.7;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget/1000000, 0, ',', '.');
                                                $tot_lim = $tot_lim + $lim_budget;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_lim = $ytd_lim + $lim_budget;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($ytd_lim/1000000, 0, ',', '.');                                                
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($tot_lim/1000000, 0, ',', '.');                                                
                                        ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                if($tot_plan != 0){
                                                    $percent_lim = ($tot_lim/$tot_plan)*100;
                                                } else {
                                                    $percent_lim = 0;
                                                }                                                
                                            } else {
                                                if($tot_rev != 0){
                                                    $percent_lim = ($tot_lim/$tot_rev)*100;
                                                } else {
                                                    $percent_lim = 0;
                                                }                                                
                                            }
                                            
                                            echo number_format($percent_lim, 2, ',', '.') . '%';
                                        ?>
                                    </td> 
                                </tr>                                
                                <!-- LIMIT 50% BEFORE TOP UP -->
                                <tr>
                                    <td style="font-weight: bold;">Limit 50%</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            $tot_lim2 = 0;
                                            $ytd_lim2 = 0;
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN04 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN04 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN05 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN05 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN06 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN06 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN07 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN07 * 0.5;
                                            }
                                        
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN08 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN08 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN09 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN09 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN10 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN10 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN11 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN11 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN12 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN12 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN13 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN13 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN14 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN14 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                $lim_budget2 = $detail_budget->PBLN15 * 0.5;
                                            } else {
                                                $lim_budget2 = $revisi_budget->PBLN15 * 0.5;
                                            }
                                            
                                            if($limit_budget != NULL){ 
                                                echo number_format($lim_budget2/1000000, 0, ',', '.');
                                                $tot_lim2 = $tot_lim2 + $lim_budget2;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_lim2 = $ytd_lim2 + $lim_budget2;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($ytd_lim2/1000000, 0, ',', '.');                                                
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($tot_lim2/1000000, 0, ',', '.');                                                
                                        ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                if($tot_plan != 0){
                                                    $percent_lim2 = ($tot_lim2/$tot_plan)*100;
                                                } else {
                                                    $percent_lim2 = 0;
                                                }                                                
                                            } else {
                                                if($tot_rev != 0){
                                                    $percent_lim2 = ($tot_lim2/$tot_rev)*100;
                                                } else {
                                                    $percent_lim2 = 0;
                                                }                                                
                                            }

                                            echo number_format($percent_lim2, 2, ',', '.') . '%';
                                        ?>
                                    </td> 
                                </tr>
                                <?php } else { ?>
                                <!-- NEW REVISE METHODE - AFTER CR -->
                                <?php if($revisi_budget_by_sales != NULL && $bgt_type <> 'CONSU'){ ?>
                                <tr>
                                    <td style="font-weight: bold;">Expense</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                    <?php 
                                            $tot_plan_rbg = $revisi_budget_by_sales->PBLN04 + $revisi_budget_by_sales->PBLN05 + $revisi_budget_by_sales->PBLN06 + $revisi_budget_by_sales->PBLN07 + $revisi_budget_by_sales->PBLN08 + $revisi_budget_by_sales->PBLN09 + $revisi_budget_by_sales->PBLN10 + $revisi_budget_by_sales->PBLN11 + $revisi_budget_by_sales->PBLN12 + $revisi_budget_by_sales->PBLN13 + $revisi_budget_by_sales->PBLN14 + $revisi_budget_by_sales->PBLN15;
                                            $total_budget_plant_guide = ($tot_plan_rbg/$tot_sales)*$tot_salesrev;;
                                            $ytd_plan = 0;
                                            $tot_plan = 0;
                                            $mon_bln04 = 0;                              
                                            if($revisi_budget_by_sales != NULL){                                                
                                                echo number_format($revisi_budget_by_sales->PBLN04/1000000, 0, ',', '.');
                                                $mon_bln04 = $revisi_budget_by_sales->PBLN04;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN04;
                                                }
                                            } else {                                                
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            $mon_bln05 = 0; 
                                            if($revisi_budget_by_sales != NULL){                                                 
                                                echo number_format($revisi_budget_by_sales->PBLN05/1000000, 0, ',', '.');
                                                $mon_bln05 = $revisi_budget_by_sales->PBLN05;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN05;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            $mon_bln06 = 0; 
                                            if($revisi_budget_by_sales != NULL){                                                
                                                echo number_format($revisi_budget_by_sales->PBLN06/1000000, 0, ',', '.');
                                                $mon_bln06 = $revisi_budget_by_sales->PBLN06;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN06;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln07 = 0;
                                            if($revisi_budget_by_sales != NULL){                                                 
                                                echo number_format($revisi_budget_by_sales->PBLN07/1000000, 0, ',', '.');
                                                $mon_bln07 = $revisi_budget_by_sales->PBLN07;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN07;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln08 = 0;
                                            if($revisi_budget_by_sales != NULL){                                                
                                                echo number_format($revisi_budget_by_sales->PBLN08/1000000, 0, ',', '.');
                                                $mon_bln08 = $revisi_budget_by_sales->PBLN08;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN08;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln09 = 0;
                                            if($revisi_budget_by_sales != NULL){ 
                                                echo number_format($revisi_budget_by_sales->PBLN09/1000000, 0, ',', '.');
                                                $mon_bln09 = $revisi_budget_by_sales->PBLN09;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN09;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln10 = 0;
                                            if($revisi_budget_by_sales != NULL){ 
                                                echo number_format($revisi_budget_by_sales->PBLN10/1000000, 0, ',', '.');
                                                $mon_bln10 = $revisi_budget_by_sales->PBLN10;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN10;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln11 = 0;
                                            if($revisi_budget_by_sales != NULL){
                                                echo number_format($revisi_budget_by_sales->PBLN11/1000000, 0, ',', '.');
                                                $mon_bln11 = $revisi_budget_by_sales->PBLN11;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN11;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln12 = 0;
                                            if($revisi_budget_by_sales != NULL){
                                                echo number_format($revisi_budget_by_sales->PBLN12/1000000, 0, ',', '.');
                                                $mon_bln12 = $revisi_budget_by_sales->PBLN12;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN12;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln13 = 0;
                                            if($revisi_budget_by_sales != NULL){ 
                                                echo number_format($revisi_budget_by_sales->PBLN13/1000000, 0, ',', '.');
                                                $mon_bln13 = $revisi_budget_by_sales->PBLN13;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN13;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln14 = 0;
                                            if($revisi_budget_by_sales != NULL){
                                                echo number_format($revisi_budget_by_sales->PBLN14/1000000, 0, ',', '.');
                                                $mon_bln14 = $revisi_budget_by_sales->PBLN14;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN14;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln15 = 0;
                                            if($revisi_budget_by_sales != NULL){ 
                                                echo number_format($revisi_budget_by_sales->PBLN15/1000000, 0, ',', '.');
                                                $mon_bln15 = $revisi_budget_by_sales->PBLN15;
                                                $tot_plan = $tot_plan + $revisi_budget_by_sales->PBLN15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_plan = $ytd_plan + $revisi_budget_by_sales->PBLN15;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>  
                                    <td align='right'>
                                        <?php  
                                            echo number_format($ytd_plan/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($tot_plan/1000000, 0, ',', '.');
                                        ?>
                                    </td> 
                                    <td></td>
                                    <td align='right'>
                                        <?php  
                                            if($revisi_budget_by_sales != NULL && $detail_sales != NULL){
                                                $percent_rev = ($tot_plan/$tot_sales)*100;
                                            } else {
                                                $percent_rev = 0;
                                            } 
                                            
                                            echo number_format($percent_rev, 2, ',', '.') . '%';
                                        ?>
                                    </td> 
                                </tr>
                                <?php } else { ?>
                                <!-- NEW PLAN & REVISE - BY RATIO EXPENSE -->
                                <tr>
                                    <td style="font-weight: bold;">Expense</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            if($act_periode < $periode_smt2){
                                                $tot_plan_rbg = $detail_budget->PBLN04 + $detail_budget->PBLN05 + $detail_budget->PBLN06 + $detail_budget->PBLN07 + $detail_budget->PBLN08 + $detail_budget->PBLN09 + $detail_budget->PBLN10 + $detail_budget->PBLN11 + $detail_budget->PBLN12 + $detail_budget->PBLN13 + $detail_budget->PBLN14 + $detail_budget->PBLN15;
                                                $percent_from_total_plant = $tot_plan_rbg/$total_budget_plant;
                                            } else {
                                                $tot_plan_rbg = $revisi_budget->PBLN04 + $revisi_budget->PBLN05 + $revisi_budget->PBLN06 + $revisi_budget->PBLN07 + $revisi_budget->PBLN08 + $revisi_budget->PBLN09 + $revisi_budget->PBLN10 + $revisi_budget->PBLN11 + $revisi_budget->PBLN12 + $revisi_budget->PBLN13 + $revisi_budget->PBLN14 + $revisi_budget->PBLN15;
                                                $percent_from_total_plant = $tot_plan_rbg/$total_all_budget_revisi;                                             
                                            }

                                            $total_budget_plant_rbg = ($tot_sales*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                            $total_budget_plant_guide = ($tot_salesrev*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                                                        
                                            $ytd_plan = 0;
                                            $tot_plan = 0;
                                            // $ratio_sales_dept = ($tot_plan_rbg/$tot_sales)*100;
                                            $mon_rbg04 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg04 = ($detail_sales->PBLN04*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg04/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg04;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            $mon_rbg05 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg05 = ($detail_sales->PBLN05*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg05/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg05;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            $mon_rbg06 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg06 = ($detail_sales->PBLN06*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg06/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg06;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg07 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg07 = ($detail_sales->PBLN07*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg07/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg07;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg08 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg08 = ($detail_sales->PBLN08*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg08/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg08;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg09 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg09 = ($detail_sales->PBLN09*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg09/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg09;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg10 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg10 = ($detail_sales->PBLN10*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg10/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg10;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg11 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg11 = ($detail_sales->PBLN11*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg11/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg11;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg12 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg12 = ($detail_sales->PBLN12*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg12/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg12;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg13 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg13 = ($detail_sales->PBLN13*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg13/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg13;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg14 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg14 = ($detail_sales->PBLN14*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg14/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg14;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_rbg15 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg15 = ($detail_sales->PBLN15*($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant;
                                                echo number_format($mon_rbg15/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_plan = $ytd_plan + $mon_rbg15;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($ytd_plan/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td align='right'>
                                        <?php echo number_format($tot_plan/1000000, 0, ',', '.'); ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php  
                                            $percent_plan = ($tot_plan/$tot_sales)*100;

                                            echo number_format($percent_plan, 2, ',', '.') . '%';
                                        ?>
                                    </td> 
                                </tr>
                                <?php } ?>
                                <tr style="background-color: yellow;">
                                    <td style="font-weight: bold;">Expense Guide</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                    <?php 
                                            $tot_rev = 0;
                                            $ytd_rev = 0;
                                            $tot_month = 12; 
                                            $count_month = 0; 
                                            // $ratio_sales_dept_rev = ($tot_plan_rbg/$tot_salesrev)*100;
                                            $mon_bln04 = 0;
                                            $diff = 0;
                                            if($detail_sales != NULL){                                           
                                                // $mon_bln04 = ($detail_sales->REVBLN04 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln04/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln04;
                                                // if ($act_month >= $tahun . '04'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln04;
                                                // }
                                                if ($act_month > $tahun . '04'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln04 = $actual_real->OPRBLN04;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN04 - $actual_real->OPRBLN04);
                                                    } else {
                                                        $mon_bln04 = 0;
                                                    } 

                                                    $tot_rev = $tot_rev + $mon_bln04;
                                                    $ytd_rev = $ytd_rev + $mon_bln04;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '04') {
                                                    // $mon_bln04 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln04 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN04)*($revisi_budget_by_sales->PBLN04 / $detail_sales->PBLN04));
                                                    $tot_rev = $tot_rev + $mon_bln04;
                                                    $ytd_rev = $ytd_rev + $mon_bln04;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln04 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln04 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN04)*($revisi_budget_by_sales->PBLN04 / $detail_sales->PBLN04));
                                                    $tot_rev = $tot_rev + $mon_bln04;
                                                }
                                                echo number_format($mon_bln04/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                           $mon_bln05 = 0;
                                           if($detail_sales != NULL){
                                                // $mon_bln05 = ($detail_sales->REVBLN05 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln05/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln05;
                                                // if ($act_month >= $tahun . '05'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln05;
                                                // }
                                                if ($act_month > $tahun . '05'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln05 = $actual_real->OPRBLN05;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN05 - $actual_real->OPRBLN05);
                                                    } else {
                                                        $mon_bln05 = 0;
                                                    } 

                                                    $tot_rev = $tot_rev + $mon_bln05;
                                                    $ytd_rev = $ytd_rev + $mon_bln05;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '05') {
                                                    // $mon_bln05 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln05 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN05)*($revisi_budget_by_sales->PBLN05 / $detail_sales->PBLN05));
                                                    $tot_rev = $tot_rev + $mon_bln05;
                                                    $ytd_rev = $ytd_rev + $mon_bln05;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln05 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln05 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN05)*($revisi_budget_by_sales->PBLN05 / $detail_sales->PBLN05));
                                                    $tot_rev = $tot_rev + $mon_bln05;
                                                }
                                                echo number_format($mon_bln05/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            $mon_bln06 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln06 = ($detail_sales->REVBLN06 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln06/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln06;
                                                // if ($act_month >= $tahun . '06'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln06;
                                                // }
                                                if ($act_month > $tahun . '06'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln06 = $actual_real->OPRBLN06;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN06 - $actual_real->OPRBLN06);
                                                    } else {
                                                        $mon_bln06 = 0;
                                                    } 

                                                    $tot_rev = $tot_rev + $mon_bln06;
                                                    $ytd_rev = $ytd_rev + $mon_bln06;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '06') {
                                                    // $mon_bln06 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln06 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN06)*($revisi_budget_by_sales->PBLN06 / $detail_sales->PBLN06));
                                                    $tot_rev = $tot_rev + $mon_bln06;
                                                    $ytd_rev = $ytd_rev + $mon_bln06;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln06 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln06 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN06)*($revisi_budget_by_sales->PBLN06 / $detail_sales->PBLN06));
                                                    $tot_rev = $tot_rev + $mon_bln06;
                                                }
                                                echo number_format($mon_bln06/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln07 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln07 = ($detail_sales->REVBLN07 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln07/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln07;
                                                // if ($act_month >= $tahun . '07'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln07;
                                                // }
                                                if ($act_month > $tahun . '07'){  
                                                    if($actual_real != NULL){
                                                        $mon_bln07 = $actual_real->OPRBLN07;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN07 - $actual_real->OPRBLN07);
                                                    } else {
                                                        $mon_bln07 = 0;
                                                    }

                                                    $tot_rev = $tot_rev + $mon_bln07;
                                                    $ytd_rev = $ytd_rev + $mon_bln07;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '07') {
                                                    // $mon_bln07 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln07 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN07)*($revisi_budget_by_sales->PBLN07 / $detail_sales->PBLN07));
                                                    $tot_rev = $tot_rev + $mon_bln07;
                                                    $ytd_rev = $ytd_rev + $mon_bln07;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln07 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln07 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN07)*($revisi_budget_by_sales->PBLN07 / $detail_sales->PBLN07));
                                                    $tot_rev = $tot_rev + $mon_bln07;
                                                }
                                                echo number_format($mon_bln07/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln08 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln08 = ($detail_sales->REVBLN08 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln08/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln08;
                                                // if ($act_month >= $tahun . '08'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln08;
                                                // }
                                                if ($act_month > $tahun . '08'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln08 = $actual_real->OPRBLN08;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN08 - $actual_real->OPRBLN08);
                                                    } else {
                                                        $mon_bln08 = 0;
                                                    }

                                                    $tot_rev = $tot_rev + $mon_bln08;
                                                    $ytd_rev = $ytd_rev + $mon_bln08;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '08') {
                                                    // $mon_bln08 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln08 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN08)*($revisi_budget_by_sales->PBLN08 / $detail_sales->PBLN08));
                                                    $tot_rev = $tot_rev + $mon_bln08;
                                                    $ytd_rev = $ytd_rev + $mon_bln08;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln08 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln08 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN08)*($revisi_budget_by_sales->PBLN08 / $detail_sales->PBLN08));
                                                    $tot_rev = $tot_rev + $mon_bln08;
                                                }
                                                echo number_format($mon_bln08/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln09 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln09 = ($detail_sales->REVBLN09 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln09/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln09;
                                                // if ($act_month >= $tahun . '09'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln09;
                                                // }
                                                if ($act_month > $tahun . '09'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln09 = $actual_real->OPRBLN09;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN09 - $actual_real->OPRBLN09);
                                                    } else {
                                                        $mon_bln09 = 0;
                                                    }

                                                    $tot_rev = $tot_rev + $mon_bln09;
                                                    $ytd_rev = $ytd_rev + $mon_bln09;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '09') {
                                                    // $mon_bln09 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln09 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN09)*($revisi_budget_by_sales->PBLN09 / $detail_sales->PBLN09));
                                                    $tot_rev = $tot_rev + $mon_bln09;
                                                    $ytd_rev = $ytd_rev + $mon_bln09;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln09 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln09 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN09)*($revisi_budget_by_sales->PBLN09 / $detail_sales->PBLN09));
                                                    $tot_rev = $tot_rev + $mon_bln09;
                                                }
                                                echo number_format($mon_bln09/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln10 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln10 = ($detail_sales->REVBLN10 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln10/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln10;
                                                // if ($act_month >= $tahun . '10'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln10;
                                                // }
                                                if ($act_month > $tahun . '10'){
                                                    if($actual_real != NULL){
                                                        $mon_bln10 = $actual_real->OPRBLN10;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN10 - $actual_real->OPRBLN10);
                                                    } else {
                                                        $mon_bln10 = 0;
                                                    }                                                    
                                                                                           
                                                    $tot_rev = $tot_rev + $mon_bln10;
                                                    $ytd_rev = $ytd_rev + $mon_bln10;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '10') {
                                                    // $mon_bln10 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln10 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN10)*($revisi_budget_by_sales->PBLN10 / $detail_sales->PBLN10));
                                                    $tot_rev = $tot_rev + $mon_bln10;
                                                    $ytd_rev = $ytd_rev + $mon_bln10;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln10 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln10 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN10)*($revisi_budget_by_sales->PBLN10 / $detail_sales->PBLN10));
                                                    $tot_rev = $tot_rev + $mon_bln10;
                                                }
                                                echo number_format($mon_bln10/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln11 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln11 = ($detail_sales->REVBLN11 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln11/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln11;
                                                // if ($act_month >= $tahun . '11'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln11;
                                                // }
                                                if ($act_month > $tahun . '11'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln11 = $actual_real->OPRBLN11;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN11 - $actual_real->OPRBLN11);
                                                    } else {
                                                        $mon_bln11 = 0;
                                                    } 

                                                    $tot_rev = $tot_rev + $mon_bln11;
                                                    $ytd_rev = $ytd_rev + $mon_bln11;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '11') {
                                                    // $mon_bln11 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln11 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN11)*($revisi_budget_by_sales->PBLN11 / $detail_sales->PBLN11));
                                                    $tot_rev = $tot_rev + $mon_bln11;
                                                    $ytd_rev = $ytd_rev + $mon_bln11;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln11 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln11 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN11)*($revisi_budget_by_sales->PBLN11 / $detail_sales->PBLN11));
                                                    $tot_rev = $tot_rev + $mon_bln11;
                                                }
                                                echo number_format($mon_bln11/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln12 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln12 = ($detail_sales->REVBLN12 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln12/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln12;
                                                // if ($act_month >= $tahun . '12'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln12;
                                                // }
                                                if ($act_month > $tahun . '12'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln12 = $actual_real->OPRBLN12;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN12 - $actual_real->OPRBLN12);
                                                    } else {
                                                        $mon_bln12 = 0;
                                                    } 

                                                    $tot_rev = $tot_rev + $mon_bln12;
                                                    $ytd_rev = $ytd_rev + $mon_bln12;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun . '12') {
                                                    // $mon_bln12 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln12 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN12)*($revisi_budget_by_sales->PBLN12 / $detail_sales->PBLN12));
                                                    $tot_rev = $tot_rev + $mon_bln12;
                                                    $ytd_rev = $ytd_rev + $mon_bln12;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln12 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln12 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN12)*($revisi_budget_by_sales->PBLN12 / $detail_sales->PBLN12));
                                                    $tot_rev = $tot_rev + $mon_bln12;
                                                }
                                                echo number_format($mon_bln12/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln13 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln13 = ($detail_sales->REVBLN13 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln13/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln13;
                                                // if ($act_month >= $tahun + 1 . '01'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln13;
                                                // }
                                                if ($act_month > $tahun + 1 . '01'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln13 = $actual_real->OPRBLN13;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN13 - $actual_real->OPRBLN13);
                                                    } else {
                                                        $mon_bln13 = 0;
                                                    } 

                                                    $tot_rev = $tot_rev + $mon_bln13;
                                                    $ytd_rev = $ytd_rev + $mon_bln13;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun + 1 . '01') {
                                                    // $mon_bln13 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln13 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN13)*($revisi_budget_by_sales->PBLN13 / $detail_sales->PBLN13));
                                                    $tot_rev = $tot_rev + $mon_bln13;
                                                    $ytd_rev = $ytd_rev + $mon_bln13;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln13 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln13 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN13)*($revisi_budget_by_sales->PBLN13 / $detail_sales->PBLN13));
                                                    $tot_rev = $tot_rev + $mon_bln13;
                                                }
                                                echo number_format($mon_bln13/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln14 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln14 = ($detail_sales->REVBLN14 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln14/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln14;
                                                // if ($act_month >= $tahun + 1 . '02'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln14;
                                                // }
                                                if ($act_month > $tahun + 1 . '02'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln14 = $actual_real->OPRBLN14;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN14 - $actual_real->OPRBLN14);
                                                    } else {
                                                        $mon_bln14 = 0;
                                                    } 

                                                    $tot_rev = $tot_rev + $mon_bln14;
                                                    $ytd_rev = $ytd_rev + $mon_bln14;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun + 1 . '02') {
                                                    // $mon_bln14 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln14 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN14)*($revisi_budget_by_sales->PBLN14 / $detail_sales->PBLN14));
                                                    $tot_rev = $tot_rev + $mon_bln14;
                                                    $ytd_rev = $ytd_rev + $mon_bln14;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln14 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln14 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN14)*($revisi_budget_by_sales->PBLN14 / $detail_sales->PBLN14));
                                                    $tot_rev = $tot_rev + $mon_bln14;
                                                }
                                                echo number_format($mon_bln14/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            $mon_bln15 = 0;
                                            if($detail_sales != NULL){
                                                // $mon_bln15 = ($detail_sales->REVBLN15 * ($ratio_sales->DEC_RATIO/100))*$percent_from_total_plant; 
                                                // echo number_format($mon_bln15/1000000, 0, ',', '.');
                                                // $tot_rev = $tot_rev + $mon_bln15;
                                                // if ($act_month >= $tahun + 1 . '03'){
                                                //     $ytd_rev = $ytd_rev + $mon_bln15;
                                                // }
                                                if ($act_month > $tahun + 1 . '03'){                                                    
                                                    if($actual_real != NULL){
                                                        $mon_bln15 = $actual_real->OPRBLN15;
                                                        $diff = $diff + ($revisi_budget_by_sales->PBLN15 - $actual_real->OPRBLN15);
                                                    } else {
                                                        $mon_bln15 = 0;
                                                    }

                                                    $tot_rev = $tot_rev + $mon_bln15;
                                                    $ytd_rev = $ytd_rev + $mon_bln15;
                                                    $count_month = $count_month + 1;
                                                } else if($act_month == $tahun + 1 . '03') {
                                                    // $mon_bln15 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln15 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN15)*($revisi_budget_by_sales->PBLN15 / $detail_sales->PBLN15));
                                                    $tot_rev = $tot_rev + $mon_bln15;
                                                    $ytd_rev = $ytd_rev + $mon_bln15;
                                                    $count_month = $count_month + 1;
                                                } else {
                                                    // $mon_bln15 = ($total_budget_plant_guide - $ytd_rev)/($tot_month - $count_month);
                                                    $mon_bln15 = ($diff/($tot_month - $count_month)) + (($detail_sales->REVBLN15)*($revisi_budget_by_sales->PBLN15 / $detail_sales->PBLN15));
                                                    $tot_rev = $tot_rev + $mon_bln15;
                                                }
                                                echo number_format($mon_bln15/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>  
                                    <td align='right'>
                                        <?php  
                                            echo number_format($ytd_rev/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($tot_rev/1000000, 0, ',', '.');
                                        ?>
                                    </td> 
                                    <td></td>
                                    <td align='right'>
                                        <?php  
                                            $percent_rev = ($tot_rev/$tot_salesrev)*100;
                                            
                                            echo number_format($percent_rev, 2, ',', '.') . '%';
                                        ?>
                                    </td> 
                                </tr>
                                <?php } ?> 
                                <tr style="background-color: #FBEDC8;">
                                    <td style="font-weight: bold;">Act PR</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php 
                                            $tot_pr = 0;
                                            $ytd_pr = 0;
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN04/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN04;
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN04;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN05/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN05;
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN05;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN06/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN06;
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN06;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN07/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN07;
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN07;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN08/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN08;
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN08;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN09/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN09;
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN09;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN10/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN10;
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN10;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN11/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN11;
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN11;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN12/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN12;
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN12;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN13/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN13;
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN13;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN14/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN14;
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN14;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN15/1000000, 0, ',', '.');
                                                $tot_pr = $tot_pr + $actual_real->OPRBLN15;
                                                if ($act_month >= $tahun + 1 . '03'){
                                                    $ytd_pr = $ytd_pr + $actual_real->OPRBLN15;
                                                }
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($ytd_pr/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            echo number_format($tot_pr/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
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
                                <?php if($bgt_type == 'CAPEX') { ?>                            
                                <tr>
                                    <td style="font-weight: bold;">Balance</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN04 - $actual_real->OPRBLN04;
                                                $balance = ($detail_budget->PBLN04 * 0.7) - $actual_real->OPRBLN04;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN05 - $actual_real->OPRBLN05;
                                                $balance = ($detail_budget->PBLN05 * 0.7) - $actual_real->OPRBLN05;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN06 - $actual_real->OPRBLN06;
                                                $balance = ($detail_budget->PBLN06 * 0.7) - $actual_real->OPRBLN06;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN07 - $actual_real->OPRBLN07;
                                                $balance = ($detail_budget->PBLN07 * 0.7) - $actual_real->OPRBLN07;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN08 - $actual_real->OPRBLN08;
                                                $balance = ($detail_budget->PBLN08 * 0.7) - $actual_real->OPRBLN08;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN09 - $actual_real->OPRBLN09;
                                                $balance = ($detail_budget->PBLN09 * 0.7) - $actual_real->OPRBLN09;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN10 - $actual_real->OPRBLN10;
                                                $balance = ($detail_budget->PBLN10 * 0.7) - $actual_real->OPRBLN10;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN11 - $actual_real->OPRBLN11;
                                                $balance = ($detail_budget->PBLN11 * 0.7) - $actual_real->OPRBLN11;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN12 - $actual_real->OPRBLN12;
                                                $balance = ($detail_budget->PBLN12 * 0.7) - $actual_real->OPRBLN12;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN13 - $actual_real->OPRBLN13;
                                                $balance = ($detail_budget->PBLN13 * 0.7) - $actual_real->OPRBLN13;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN14 - $actual_real->OPRBLN14;
                                                $balance = ($detail_budget->PBLN14 * 0.7) - $actual_real->OPRBLN14;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                //$balance = $limit_budget->PBLN15 - $actual_real->OPRBLN15;
                                                $balance = ($detail_budget->PBLN15 * 0.7) - $actual_real->OPRBLN15;
                                                echo number_format($balance/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php  
                                            $ytd_bal = $ytd_lim - $ytd_pr;
                                            echo number_format($ytd_bal/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php  
                                            $tot_bal = $tot_lim - $tot_pr;
                                            echo number_format($tot_bal/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                if($tot_plan != 0){
                                                    $percent_bal = ($tot_bal/$tot_plan)*100;
                                                } else {
                                                    $percent_bal = 0;
                                                }                                                
                                            } else {
                                                if($tot_rev != 0){
                                                    $percent_bal = ($tot_bal/$tot_rev)*100;
                                                } else {
                                                    $percent_bal = 0;
                                                }                                                
                                            }
                                            
                                            echo number_format($percent_bal, 2, ',', '.') . '%';
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if($detail_sales != NULL && $bgt_type <> 'CAPEX'){ ?>
                                <tr style="background-color: yellow;">
                                    <td style="font-weight: bold;">Balance</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln04 - $actual_real->OPRBLN04;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln05 - $actual_real->OPRBLN05;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln06 - $actual_real->OPRBLN06;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln07 - $actual_real->OPRBLN07;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln08 - $actual_real->OPRBLN08;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln09 - $actual_real->OPRBLN09;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln10 - $actual_real->OPRBLN10;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln11 - $actual_real->OPRBLN11;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln12 - $actual_real->OPRBLN12;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln13 - $actual_real->OPRBLN13;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln14 - $actual_real->OPRBLN14;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php  
                                            if($detail_sales != NULL && $actual_real != NULL){
                                                $balance_rev = $mon_bln14 - $actual_real->OPRBLN15;
                                                echo number_format($balance_rev/1000000, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php  
                                            $ytd_bal_rev = $ytd_rev - $ytd_pr;
                                            echo number_format($ytd_bal_rev/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php  
                                            $tot_bal_rev = $tot_rev - $tot_pr;
                                            echo number_format($tot_bal_rev/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php                                            
                                            if($tot_rev != 0){
                                                $percent_bal_rev = ($tot_bal_rev/$tot_rev)*100;
                                            } else {
                                                $percent_bal_rev = 0;
                                            } 
                                            
                                            echo number_format($percent_bal_rev, 2, ',', '.') . '%';
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td style="font-weight: bold;">Act GR</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php
                                            $tot_gr = 0;
                                            $ytd_gr = 0;
                                            echo number_format($actual_gr[0]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[0];
                                            $ytd_gr = $ytd_gr + $actual_gr[0];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[1]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[1];
                                            $ytd_gr = $ytd_gr + $actual_gr[1];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[2]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[2];    
                                            $ytd_gr = $ytd_gr + $actual_gr[2];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[3]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[3];
                                            $ytd_gr = $ytd_gr + $actual_gr[3];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[4]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[4]; 
                                            $ytd_gr = $ytd_gr + $actual_gr[4];   
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[5]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[5];
                                            $ytd_gr = $ytd_gr + $actual_gr[5];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[6]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[6];
                                            $ytd_gr = $ytd_gr + $actual_gr[6];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[7]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[7];
                                            $ytd_gr = $ytd_gr + $actual_gr[7];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[8]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[8];
                                            $ytd_gr = $ytd_gr + $actual_gr[8];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[9]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[9];
                                            $ytd_gr = $ytd_gr + $actual_gr[9];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($actual_gr[10]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[10];
                                            $ytd_gr = $ytd_gr + $actual_gr[10];
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php 
                                            echo number_format($actual_gr[11]/1000000, 0, ',', '.'); 
                                            $tot_gr = $tot_gr + $actual_gr[11];
                                            $ytd_gr = $ytd_gr + $actual_gr[11];
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php 
                                            echo number_format($ytd_gr/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php 
                                            echo number_format($tot_gr/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                if($tot_plan != 0){
                                                    $percent_gr = ($tot_gr/$tot_plan)*100;
                                                } else {
                                                    $percent_gr = 0;
                                                }                                                
                                            } else {
                                                if($tot_rev != 0){
                                                    $percent_gr = ($tot_gr/$tot_rev)*100;
                                                } else {
                                                    $percent_gr = 0;
                                                }                                                
                                            }
                                            
                                            echo number_format($percent_gr, 2, ',', '.') . '%';
                                        ?>
                                    </td>
                                </tr>
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
