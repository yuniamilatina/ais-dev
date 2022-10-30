<?php header("Content-type: text/html; charset=iso-8859-1"); ?>
<style>
#filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

div.scrollmenu {
    overflow: auto;
    white-space: nowrap;
    font-size: 11px;
}

</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Approval Purchase Request</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>APPROVAL PURCHASE REQUEST - ADMIN</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <form method="post" id="filter_form" action="<?php echo site_url("budget/purchase_request_c/filter_purchase_request") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                        <div class="pull">
                            <table width="100%" id="filter">
                                <tr>
                                    <td width="10%">Year</td>
                                    <td width="20%">
                                        <select name="CHR_YEAR" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -1; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . date("Y", strtotime("+$x year"))) . '/CAPEX'; ?>" <?php
                                                if ($tahun == date("Y", strtotime("+$x year"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Y", strtotime("+$x year")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="15%"></td>
                                    <td width="15%">Department</td>
                                    <td width="20%">
                                        <input name="DEPARTMENT_NAME" readonly id="dept_name" class="form-control" required type="text" style="width: 203px;" value="<?php echo $dept_name; ?>">
                                    </td> 
                                </tr>
                                <tr>
                                    <td width="10%">Budget Type</td>
                                    <td width="20%">
                                        <select name="CHR_BUDGET_TYPE" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($list_budget_type as $bgt) { ?>
                                                <option value="<?php echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . $tahun . '/' . trim($bgt->CHR_BUDGET_TYPE)); ?>" <?php
                                                if ($bgt_type == trim($bgt->CHR_BUDGET_TYPE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                    <?php } ?>
                                        </select>                                        
                                    </td>
                                    <td width="20%"><input name="BUDGET_TYPE_DESCRIPTION" readonly id="bgt_desc" class="form-control" required type="text" style="width: 203px;" value="<?php echo $bgt_type_name->CHR_BUDGET_TYPE_DESC; ?>"></td>
                                    <td width="15%"></td>
                                    <td width="15%">Transaction Date</td>
                                    <td width="20%">
                                        <input name="PR_DATE" readonly id="date" class='form-control' required type="text" style="width: 203px;" value="<?php echo $pr_date; ?>">                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Status</td>
                                    <td width="20%">
                                        <select name="CHR_STATUS_BGT" class="form-control" id="status_bgt" onchange="document.location.href = this.options[this.selectedIndex].value;" >
                                            <?php if($status_bgt == 0 || $status_bgt == NULL){ ?>
                                                <option value="<?php echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . $tahun . '/' . $bgt_type . '/0'); ?>" SELECTED>UNAPPROVED</option>
                                                <option value="<?php echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . $tahun . '/' . $bgt_type . '/1'); ?>">APPROVED</option>
                                            <?php } else { ?>
                                                <option value="<?php echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . $tahun . '/' . $bgt_type . '/0'); ?>">UNAPPROVED</option>
                                                <option value="<?php echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . $tahun . '/' . $bgt_type . '/1'); ?>" SELECTED>APPROVED</option>
                                            <?php } ?>                                 
                                        </select>                                        
                                    </td>
                                    <td width="20%"></td>
                                    <td width="15%"></td>
                                    <td width="15%"></td>
                                    <td width="20%"></td>
                                                                                   
                                </tr>
                                <tr>
                                    <td width="10%">No Reg</td>
                                    <td width="20%">
                                        <select name="CHR_KODE_TRANSAKSI" class="form-control" id="e2" onchange="document.location.href = this.options[this.selectedIndex].value;" autofocus>
                                            <option value=""></option>
                                            <?php foreach ($list_kode_transaksi as $kode) { ?>
                                            <option value="<?php echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . $tahun . '/' . $bgt_type . '/' . $status_bgt . '/' . trim($kode->CHR_KODE_TRANSAKSI)); ?>" <?php
                                                if ($kode_transaksi == trim($kode->CHR_KODE_TRANSAKSI)) {
                                                    echo 'SELECTED';
                                                }
//                                                ?> > <?php echo $kode->CHR_KODE_TRANSAKSI; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="15%"></td>
                                    <td width="15%"></td>
                                    <td width="20%" align="center">
                                        <a href="<?php echo base_url('index.php/budget/purchase_request_c/save_approved_pr') . "/" . $tahun . '/' . $bgt_type . '/' . $status_bgt . '/' . $kode_transaksi; ?>" class="btn btn-primary" title="Approve PR" style="width:130px;" <?php if($status_bgt == 1 || $kode_transaksi == NULL){ echo "disabled"; } ?>>Approve PR</a>
                                    </td>                                  
                                </tr>                                                         
                            </table>
                        </div>
                        </form>
                        <div>&nbsp;</div>
                        <div class="scrollmenu">
                        <table id="dataTable" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                            <thead>
                                <tr style=" background-color: #002a80; color: white;">
                                    <td align='center' style="font-weight: bold;">No</td>
                                    <td align='center' style="font-weight: bold;">Budget No</td>                                    
                                    <td align='center' style="font-weight: bold;">Estimation GR</td>
                                    <td align='center' style="font-weight: bold;">Qty</td>
                                    <td align='center' style="font-weight: bold;">Description</td>
                                    <td align='center' style="font-weight: bold;">Amount</td>
                                    <td align='center' style="font-weight: bold;">Budget</td>
                                    <td align='center' style="font-weight: bold;">Limit</td>
                                    <td align='center' style="font-weight: bold;">Realisasi</td>
                                    <td align='center' style="font-weight: bold;">Current Saldo</td>
                                    <?php if ($bgt_type == 'CAPEX'){ ?>
                                        <td align='center' style="font-weight: bold;">Next Saldo</td>
                                    <?php } ?>                                    
                                    <td align='center' style="font-weight: bold;">Approved GM</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $session = $this->session->all_userdata();
                                $i = 1;
                                $tot_amount = 0;
                                
                                if($list_pr != NULL){
                                    $curr_saldo = $list_pr[0]->LIMIT - $list_pr[0]->REALISASI;
                                }
                                
                                foreach ($list_pr as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_NO_BUDGET</td>";                                    
                                    echo "<td align='center'>".substr($isi->CHR_TGL_ESTIMASI_KEDATANGAN,6,2).'/'.substr($isi->CHR_TGL_ESTIMASI_KEDATANGAN,4,2).'/'.substr($isi->CHR_TGL_ESTIMASI_KEDATANGAN,0,4)."</td>";
                                    echo "<td align='center'>$isi->INT_QTY</td>";
                                    echo "<td>$isi->CHR_PURCHASE_PART</td>";
                                    echo "<td align='right'>Rp ". number_format($isi->MON_TOTAL_PRICE_SUPPLIER, 2, ',', '.') ."</td>";
                                    echo "<td align='right'>Rp ". number_format($isi->BUDGET, 2, ',', '.') ."</td>";
                                    echo "<td align='right'>Rp ". number_format($isi->LIMIT, 2, ',', '.') ."</td>";
                                    echo "<td align='right'>Rp ". number_format($isi->REALISASI, 2, ',', '.') ."</td>";
                                    $saldo_now = $isi->LIMIT - $isi->REALISASI;
                                    echo "<td align='right'>Rp ". number_format($saldo_now, 2, ',', '.') ."</td>";
                                    $curr_saldo = $curr_saldo - $isi->MON_TOTAL_PRICE_SUPPLIER;
                                    if($bgt_type == 'CAPEX'){
                                        echo "<td align='right'>Rp ". number_format($curr_saldo, 2, ',', '.') ."</td>";
                                    }
                                    
                                    if($isi->CHR_FLG_APPROVE_GM == 1){
                                        echo "<td align='center'><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                    } else {
                                        echo "<td align='center'><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                    }
                                    
                                    echo "</tr>";
                                    $i++;
                                    $tot_amount = $tot_amount + $isi->MON_TOTAL_PRICE_SUPPLIER;
                                }
                                ?>
                                <tr style="font-weight: bold;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right'>Total Amount : </td>
                                    <td align='right'>Rp <?php echo number_format($tot_amount, 2, ',', '.'); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php if ($bgt_type == 'CAPEX') {?>
                                        <td></td>
                                    <?php } ?>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>                        
                        <div>&nbsp;</div>
                        <div style=" font-size: 11px;">
                            <table width="100%">
                                <tr>
                                    <td width='10%'></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;">Budget Dep. <?php echo $kode_dept . ' (' . $bgt_type . ')'; ?></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;">Realisasi Dep. <?php echo $kode_dept . ' (' . $bgt_type . ')'; ?></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;">Saldo Dep. <?php echo $kode_dept . ' (' . $bgt_type . ')'; ?></td>
                                    <td width='1%'></td>
                                    <td colspan='3' width='35%'align='center' style="font-weight: bold;">
                                        <?php if($group_name != NULL){ 
                                                echo $group_name->CHR_GROUP_DESCRIPTION;
                                              }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width='10%'>Budget</th>
                                    <td width='2%' align='center'>:</td>
                                    <td width='15%' align='right'>
                                    <?php if($total_budget_plan->TOT_BGTPLAN == NULL){ //BUDGET PLAN
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                          } else {
                                                echo 'Rp ' . number_format($total_budget_plan->TOT_BGTPLAN,2,',','.'); 
                                          }
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'>
                                    <?php if($total_budget_real->TOT_BUDGET_REAL == NULL){ //BUDGET REALIZATION
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                          } else {
                                                echo 'Rp ' . number_format($total_budget_real->TOT_BUDGET_REAL,2,',','.'); 
                                          }
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'>
                                    <?php //SALDO BUDGET
                                          $saldo_budget = $total_budget_plan->TOT_BGTPLAN - $total_budget_real->TOT_BUDGET_REAL;
                                          echo 'Rp ' . number_format($saldo_budget, 2, ',', '.');
                                    ?>
                                    </td>
                                    <td width='1%'></td>
                                    <td width='17%'></td>
                                    <td width='2%'></td>
                                    <td width='17%'></td>
                                </tr>
                                <tr>
                                    <th width='10%'>Unbudget</th>
                                    <td width='2%' align='center'>:</td>
                                    <td width='15%' align='right'>
                                    <?php if($total_unbudget_plan->TOT_UNBUDGET == NULL){ //UNBUDGET PLAN
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                          } else {
                                                echo 'Rp ' . number_format($total_unbudget_plan->TOT_UNBUDGET,2,',','.'); 
                                          }
                                        
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'>
                                    <?php if($total_unbudget_real->TOT_UNBUDGET_REAL == NULL){ //UNBUDGET REALIZATION
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                          } else {
                                                echo 'Rp ' . number_format($total_unbudget_real->TOT_UNBUDGET_REAL,2,',','.'); 
                                          }
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'>
                                    <?php //SALDO UNBUDGET
                                          $saldo_unbudget = $total_unbudget_plan->TOT_UNBUDGET - $total_unbudget_real->TOT_UNBUDGET_REAL;
                                          echo 'Rp ' . number_format($saldo_unbudget, 2, ',', '.');                                          
                                    ?>
                                    </td>
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;">Total Budget Group</td>
                                    <td width='2%' align='center'>:</td>
                                    <td width='17%' align='right' style="font-weight: bold;">Rp <?php echo number_format($total_budget_group->TOT_BUDGET_GROUP, 2, ',', '.');  ?></td>
                                </tr>
                                <tr>  
                                    <th width='10%'>CIP</th>
                                    <td width='2%' align='center'>:</td>
                                    <td width='15%' align='right'>
                                    <?php if($total_cip_plan->TOT_CIPPLAN == NULL){ //BUDGET PLAN
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                          } else {
                                                echo 'Rp ' . number_format($total_cip_plan->TOT_CIPPLAN,2,',','.'); 
                                          }
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'>
                                    <?php if($total_cip_real->TOT_CIP_REAL == NULL){ //REALIZATION
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                          } else {
                                                echo 'Rp ' . number_format($total_cip_real->TOT_CIP_REAL,2,',','.'); 
                                          }
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'>
                                    <?php //SALDO CIP
                                        $saldo_cip =  $total_cip_plan->TOT_CIPPLAN -  $total_cip_real->TOT_CIP_REAL;
                                        echo 'Rp ' . number_format($saldo_cip, 2, ',', '.');                                          
                                    ?>
                                    </td>
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;">Total Realisasi Group</td>
                                    <td width='2%' align='center'>:</td>
                                    <td width='17%' align='right' style="font-weight: bold;">Rp <?php echo number_format($total_real_group->TOT_REAL_GROUP, 2, ',', '.');  ?></td>
                                </tr>
                                <tr style=" border-top-style: solid;">  
                                    <th width='10%'>Total</th>
                                    <td width='2%' align='center'>:</td>
                                    <td width='15%' align='right' style="background-color: #DDDDDD; font-weight: bold;">
                                    <?php //TOTAL_BUDGET_PLAN
                                        $total_plan = $total_budget_plan->TOT_BGTPLAN + $total_unbudget_plan->TOT_UNBUDGET + $total_cip_plan->TOT_CIPPLAN;
                                        echo 'Rp ' . number_format($total_plan, 2, ',', '.');
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right' style="background-color: #DDDDDD; font-weight: bold;">
                                    <?php //TOTAL REALIZATION
                                          $total_real = $total_budget_real->TOT_BUDGET_REAL + $total_unbudget_real->TOT_UNBUDGET_REAL + $total_cip_real->TOT_CIP_REAL;
                                          echo 'Rp ' . number_format($total_real, 2, ',', '.');                                          
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right' style="background-color: #DDDDDD; font-weight: bold;">
                                    <?php //TOTAL SALDO
                                          $total_saldo = $saldo_budget + $saldo_unbudget + $saldo_cip;
                                          echo 'Rp ' . number_format($total_saldo, 2, ',', '.');                                          
                                    ?>
                                    </td>
                                    <td width='1%'></td>
                                    <td width='17%'></td>
                                    <td width='2%'></td>
                                    <td width='17%'></td>
                                </tr>
                                <tr>
                                    <td width='10%'></td>
                                    <td width='2%'></td>
                                    <td width='15%'></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right' style="font-weight: bold;">Total Amount</td>
                                    <td width='2%' align='center'>:</td>
                                    <td width='15%' align='right' style="font-weight: bold;">Rp <?php echo number_format($tot_amount, 2, ',', '.'); ?></td>
                                    <td width='1%'></td>
                                    <td width='17%'></td>
                                    <td width='2%'></td>
                                    <td width='17%'></td>
                                </tr>
                                <tr style=" border-top-style: solid;">
                                    <td width='10%'></td>
                                    <td width='2%'></td>
                                    <td width='15%'></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right' style="font-weight: bold;">Saldo Dep. <?php echo $kode_dept. ' (' . $bgt_type . ') '; ?></td>
                                    <td width='2%' align='center'>:</td>
                                    <?php
                                        $next_saldo = $total_saldo - $tot_amount;
                                    ?>
                                    <td width='15%' align='right' style="background-color: #DDDDDD; font-weight: bold;">Rp <?php echo number_format($next_saldo, 2, ',', '.'); ?></td>
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;">Total Saldo Group</td>
                                    <td width='2%' align='center'>:</td>
                                    <?php
                                        $saldo_group = $total_budget_group->TOT_BUDGET_GROUP - $total_real_group->TOT_REAL_GROUP;
                                    ?>
                                    <td width='17%' align='right' style="background-color: #DDDDDD; font-weight: bold;">Rp <?php echo number_format($saldo_group, 2, ',', '.');  ?></td>
                                </tr>                                
                            </table>                            
                        </div>
                        <div> &nbsp;</div>
                        <div> &nbsp;</div>
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
                                </tr>
                                <tr>
                                    <td width='4%' style="font-weight: bold;">Plan</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN04, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN05, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN06, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN07, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN08, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN09, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN10, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN11, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN12, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN13, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN14, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($detail_budget != NULL){ 
                                                echo number_format($detail_budget->PBLN15, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td width='4%' style="font-weight: bold;">Limit</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN04, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN05, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN06, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN07, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN08, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN09, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN10, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN11, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN12, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN13, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN14, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL){ 
                                                echo number_format($limit_budget->PBLN15, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width='4%' style="font-weight: bold;">Actual</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN04, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN05, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php 
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN06, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN07, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN08, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN09, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN10, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN11, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN12, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN13, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN14, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($actual_real != NULL){ 
                                                echo number_format($actual_real->OPRBLN15, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                </tr>                                
                                <tr>
                                    <td width='4%' style="font-weight: bold;">Balance</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='7%' align='right'>
                                        <?php  
                                            if($limit_budget != NULL && $actual_real != NULL){
                                                $balance = $limit_budget->PBLN04 - $actual_real->OPRBLN04;
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
                                                echo number_format($balance, 0, ',', '.');
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width='4%' style="font-weight: bold;">GR</td>
                                    <td width='1%' align='center'>:</td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[0], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[1], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[2], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[3], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[4], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[5], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[6], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[7], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[8], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[9], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right'>
                                        <?php echo number_format($actual_gr[10], 0, ',', '.'); ?>
                                    </td>
                                    <td width='7%' align='right' >
                                        <?php echo number_format($actual_gr[11], 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <div align="right">
                            <?php if($budget_by_no == NULL OR $actual_by_bgtno == NULL){ ?>
                                <button data-toggle="modal" data-target="#detailBudget" class="btn btn-primary" data-placement="left" title="View Detail Budget" disabled>View Detail Budget</button>
                            <?php } else { ?>
                                <button data-toggle="modal" data-target="#detailBudget" class="btn btn-primary" data-placement="left" title="View Detail Budget">View Detail Budget</button>
                            <?php } ?>
                            <a href="<?php echo base_url('index.php/budget/purchase_request_c/') . "/" . $tahun . '/' . $bgt_type . '/' . $status_bgt . '/' . $kode_transaksi; ?>" class="btn btn-primary" title="View Detail GR" style="width:130px;" disabled>View Detail GR</a>
                        </div>
                        <div class="modal fade" id="detailBudget" tabindex="-1" role="dialog" aria-labelledby="modalBudgetDetail" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog" style="width:1100px;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                            <h4 class="modal-title" id="modalBudgetDetail"><strong>View Detail Budget</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <table width="100%">                                   
                                                <tr>
                                                    <td width="20%" valign="top">Budget Number</td>
                                                    <td width="2%" valign="top">:</td>
                                                    <td width="78%" valign="top"><strong><?php echo $budget_by_no->CHR_NO_BUDGET; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" valign="top">Budget Description</td>
                                                    <td width="2%" valign="top">:</td>
                                                    <td width="78%" valign="top"><strong><?php echo trim($budget_by_no->CHR_DESC_BUDGET); ?></strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal-body">
                                            <table width="100%" style="font-size:11px; font-weight: bold;">
                                                <tr>
                                                    <td width="4%" align="center"></td>
                                                    <td width="1%" align="center"></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">APR</td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">MEI</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">JUN</td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">JUL</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">AGU</td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">SEP</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">OKT</td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">NOV</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">DES</td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">JAN</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">FEB</td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">MAR</td>
                                                </tr>
                                                <tr>
                                                    <td width="4%" align="left">Plan</td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $budget_by_no->APR; ?></td>
                                                    <td width="7%" align="center"><?php echo $budget_by_no->MEI; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $budget_by_no->JUN; ?></td>
                                                    <td width="7%" align="center"><?php echo $budget_by_no->JUL; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $budget_by_no->AGU; ?></td>
                                                    <td width="7%" align="center"><?php echo $budget_by_no->SEP; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $budget_by_no->OKT; ?></td>
                                                    <td width="7%" align="center"><?php echo $budget_by_no->NOV; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $budget_by_no->DES; ?></td>
                                                    <td width="7%" align="center"><?php echo $budget_by_no->JAN; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $budget_by_no->FEB; ?></td>
                                                    <td width="7%" align="center"><?php echo $budget_by_no->MAR; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="4%" align="left">Actual</td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $actual_by_bgtno->APR; ?></td>
                                                    <td width="7%" align="center"><?php echo $actual_by_bgtno->MEI; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $actual_by_bgtno->JUN; ?></td>
                                                    <td width="7%" align="center"><?php echo $actual_by_bgtno->JUL; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $actual_by_bgtno->AGU; ?></td>
                                                    <td width="7%" align="center"><?php echo $actual_by_bgtno->SEP; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $actual_by_bgtno->OKT; ?></td>
                                                    <td width="7%" align="center"><?php echo $actual_by_bgtno->NOV; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $actual_by_bgtno->DES; ?></td>
                                                    <td width="7%" align="center"><?php echo $actual_by_bgtno->JAN; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo $actual_by_bgtno->FEB; ?></td>
                                                    <td width="7%" align="center"><?php echo $actual_by_bgtno->MAR; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script>
    
    function getDataReg(value) {
        var no_reg = value.substring(2,11);
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/purchase_request_c/get_dept_name'); ?>",
            data: "no_reg=" + no_reg,
            dataType: "json",
            success: function(data) {
                var dept = data["DEPT"];
                var date = data["DATE"];
                var yy = date.substring(0,4);
                var mm = date.substring(4,6);
                var dd = date.substring(6,8);
                var ddmmyy = dd + '-' + mm + '-' + yy;
                $("#dept_name").val(dept);
                $("#date").val(ddmmyy);
            }
        });
    }

    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>