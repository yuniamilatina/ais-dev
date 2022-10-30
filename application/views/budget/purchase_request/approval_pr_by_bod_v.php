<?php header("Content-type: text/html; charset=iso-8859-1"); ?>
<style>
#filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

div.scrollmenu {
    overflow: auto;
    white-space: nowrap;
    font-size: 12px;
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
                        <span class="grid-title"><strong>APPROVAL PURCHASE REQUEST - BOD</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <form method="post" id="filter_form" action="<?php echo site_url("budget/purchase_request_c/filter_purchase_request") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                        <div class="pull">
                            <table width="100%" id="filter">
                                <tr>
                                    <td width="10%">Fiscal Year</td>
                                    <td width="20%">
                                        <select name="CHR_YEAR" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -1; $x <= 0; $x++) { ?>
                                                <option value="<?PHP echo site_url('budget/purchase_request_c/approval_purchase_request/0/' . date("Y", strtotime("+$x year"))) . '/CAPEX'; ?>" <?php
                                                if ($tahun == date("Y", strtotime("+$x year"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php $y = $x+1; echo date("Y", strtotime("+$x year")) . ' - ' . date("Y", strtotime("+$y year")); ?> </option>
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
                                    <!--<td width="15%">Transaction Date</td>
                                    <td width="20%">
                                        <input name="PR_DATE" readonly id="date" class='form-control' required type="text" style="width: 203px;" value="<?php echo $pr_date; ?>">                                        
                                    </td>-->
                                    <!-- UPDATE 04/07/2017 -->
                                    <td width="15%">Estimation GR Date</td>
                                    <td width="20%">
                                        <?php
                                            $obsolete = 0;
                                            $warn = '';
                                            if($status_bgt == 0){ //Hanya muncul ketika belum di Approve
                                                if($est_date != ''){
                                                    if(substr($est_date, 0, 6) < date('Ym')){
                                                        $obsolete = 1;
                                                        $warn = '* OBSOLETE Estimation GR Date';
                                                    } else if(substr($est_date, 0, 6) == date('Ym')){
                                                        if(date('d') > 27){
                                                            $obsolete = 1;
                                                            $warn = '* End of month, POTENTIAL OBSOLETE Estimation GR Date.';
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                        <input name="GR_DATE" readonly id="date" class='form-control' required type="text" style="width: 203px;" value="<?php if($est_date != '') { echo strtoupper(date("F", mktime(null, null, null, substr($est_date, 4, 2)))).' '.substr($est_date, 0, 4); } ?>">                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Status</td>
                                    <td width="20%">
                                        <select name="CHR_STATUS_BGT" class="form-control" id="status_bgt" onchange="document.location.href = this.options[this.selectedIndex].value;" >
                                            <?php if($status_bgt == 0){ ?>
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
                                    <td width="20%"><?php echo " " . "<i class='mandatory'>" . $warn . "</i>";  ?></td>                                                                                   
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
                                        <a href="<?php echo base_url('index.php/budget/purchase_request_c/save_approved_pr_bod') . "/" . $tahun . '/' . $bgt_type . '/' . $status_bgt . '/' . $kode_transaksi; ?>" class="btn btn-primary" title="Approve this Purchase Request" style="width:90px;" <?php if($status_bgt == 1 || $kode_transaksi == NULL || $obsolete == 1){ echo "disabled"; } ?>>Approve</a>
                                        <a href="<?php echo base_url('index.php/budget/purchase_request_c/save_unapproved_pr_bod') . "/" . $tahun . '/' . $bgt_type . '/' . $status_bgt . '/' . $kode_transaksi; ?>" class="btn btn-danger" title="Unapprove this Purchase Request" style="width:90px;" <?php if($status_bgt == 0 || $kode_transaksi == NULL){ echo "disabled"; } ?>>Unapprove</a>
                                    </td>                                  
                                </tr>                                                         
                            </table>
                        </div>
                        </form>
                        <div>&nbsp;</div>
                        <div id='overbudget' class='alert alert-danger' hidden><strong>WARNING! </strong> Approving this PR will make <strong>OVERBUDGET</strong> (<i>based on <?php if($act_periode < $periode_smt2) { echo "Planning Original"; } else { echo "Revise Budget"; } ?> </i>) on <strong> <?php if($est_date != ''){ echo strtoupper(date("F", mktime(null, null, null, substr($est_date, 4, 2)))).' '.substr($est_date, 0, 4); } ?></strong></div >
                        <div id='overbudget50' class='alert alert-warning' hidden><strong>WARNING! </strong> Approving this PR will make <strong>OVER 50% USAGE BUDGET</strong> (<i>based on <?php if($act_periode < $periode_smt2) { echo "Planning Original"; } else { echo "Revise Budget"; } ?> </i>) on <strong> <?php if($est_date != ''){ if(substr($est_date, 4, 2) == '02') { echo "FEBRUARY " . substr($est_date, 0, 4); } else{ echo strtoupper(date("F", mktime(null, null, null, substr($est_date, 4, 2)))).' '.substr($est_date, 0, 4); }} ?></strong></div >
                        <div id='overbudget60' class='alert alert-danger' hidden><strong>WARNING!! </strong> Approving this PR will make <strong>OVER 60% USAGE BUDGET</strong> (<i>based on <?php if($act_periode < $periode_smt2) { echo "Planning Original"; } else { echo "Revise Budget"; } ?> </i>) on <strong> <?php if($est_date != ''){ if(substr($est_date, 4, 2) == '02') { echo "FEBRUARY " . substr($est_date, 0, 4); } else{ echo strtoupper(date("F", mktime(null, null, null, substr($est_date, 4, 2)))).' '.substr($est_date, 0, 4); }} ?></strong></div >
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
                                    <td align='center' style="font-weight: bold;">Approved BOD</td>
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
                                    if($bgt_type == 'CAPEX'){
                                        if($act_periode < $periode_smt2){
                                            echo "<td align='right'>Rp ". number_format($isi->BUDGET, 2, ',', '.') ."</td>";
                                        } else {
                                            echo "<td align='right'>Rp ". number_format($isi->REVISI, 2, ',', '.') ."</td>";
                                        }
                                    } else {
                                        echo "<td align='right'>Rp ". number_format($isi->BUDGET, 2, ',', '.') ."</td>";
                                    }
                                    echo "<td align='right'>Rp ". number_format($isi->LIMIT, 2, ',', '.') ."</td>";
                                    echo "<td align='right'>Rp ". number_format($isi->REALISASI, 2, ',', '.') ."</td>";
                                    $saldo_now = $isi->LIMIT - $isi->REALISASI;
                                    echo "<td align='right'>Rp ". number_format($saldo_now, 2, ',', '.') ."</td>";
                                    $curr_saldo = $curr_saldo - $isi->MON_TOTAL_PRICE_SUPPLIER;
                                    if($bgt_type == 'CAPEX'){
                                        echo "<td align='right'>Rp ". number_format($curr_saldo, 2, ',', '.') ."</td>";
                                    }
                                    if($isi->CHR_FLG_APPROVE_BOD == 1){
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
                        <!-- <div>&nbsp;</div> -->
                        <?php
                            $warn_over = 0;;
                            $warn_over85 = 0;
                            $warn_over100 = 0;
                            $new_balance = 0;

                            if($actual_real != NULL){
                                $real_04 = $actual_real->OPRBLN04;
                                $real_05 = $actual_real->OPRBLN05;
                                $real_06 = $actual_real->OPRBLN06;
                                $real_07 = $actual_real->OPRBLN07;
                                $real_08 = $actual_real->OPRBLN08;
                                $real_09 = $actual_real->OPRBLN09;
                                $real_10 = $actual_real->OPRBLN10;
                                $real_11 = $actual_real->OPRBLN11;
                                $real_12 = $actual_real->OPRBLN12;
                                $real_13 = $actual_real->OPRBLN13;
                                $real_14 = $actual_real->OPRBLN14;
                                $real_15 = $actual_real->OPRBLN15;
                            } else {
                                $real_04 = 0;
                                $real_05 = 0;
                                $real_06 = 0;
                                $real_07 = 0;
                                $real_08 = 0;
                                $real_09 = 0;
                                $real_10 = 0;
                                $real_11 = 0;
                                $real_12 = 0;
                                $real_13 = 0;
                                $real_14 = 0;
                                $real_15 = 0;
                            }

                            if($status_bgt == 0){
                                if($act_periode < $periode_smt2){
                                    if($detail_budget != NULL){
                                        if(substr($est_date,4,2) == '01'){
                                            $new_balance = $detail_budget->PBLN13 - ($tot_amount + $real_13);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN13 / $detail_sales->PBLN13) * ($detail_sales->REVBLN13) * 0.85) - ($tot_amount + $real_13);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN13 / $detail_sales->PBLN13) * ($detail_sales->REVBLN13)) - ($tot_amount + $real_13);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }
                                            

                                        } elseif (substr($est_date,4,2) == '02'){
                                            $new_balance = $detail_budget->PBLN14 - ($tot_amount + $real_14);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN14 / $detail_sales->PBLN14) * ($detail_sales->REVBLN14) * 0.85) - ($tot_amount + $real_14);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN14 / $detail_sales->PBLN14) * ($detail_sales->REVBLN14)) - ($tot_amount + $real_14);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '03'){
                                            $new_balance = $detail_budget->PBLN15 - ($tot_amount + $real_15);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN15 / $detail_sales->PBLN15) * ($detail_sales->REVBLN15) * 0.85) - ($tot_amount + $real_15);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN15 / $detail_sales->PBLN15) * ($detail_sales->REVBLN15)) - ($tot_amount + $real_15);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '04'){
                                            $new_balance = $detail_budget->PBLN04 - ($tot_amount + $real_04);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN04 / $detail_sales->PBLN04) * ($detail_sales->REVBLN04) * 0.85) - ($tot_amount + $real_04);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN04 / $detail_sales->PBLN04) * ($detail_sales->REVBLN04)) - ($tot_amount + $real_04);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '05'){
                                            $new_balance = $detail_budget->PBLN05 - ($tot_amount + $real_05);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN05 / $detail_sales->PBLN05) * ($detail_sales->REVBLN05) * 0.85) - ($tot_amount + $real_05);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN05 / $detail_sales->PBLN05) * ($detail_sales->REVBLN05)) - ($tot_amount + $real_05);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '06'){
                                            $new_balance = $detail_budget->PBLN06 - ($tot_amount + $real_06);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN06 / $detail_sales->PBLN06) * ($detail_sales->REVBLN06) * 0.85) - ($tot_amount + $real_06);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN06 / $detail_sales->PBLN06) * ($detail_sales->REVBLN06)) - ($tot_amount + $real_06);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '07'){
                                            $new_balance = $detail_budget->PBLN07 - ($tot_amount + $real_07);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN07 / $detail_sales->PBLN07) * ($detail_sales->REVBLN07) * 0.85) - ($tot_amount + $real_07);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN07 / $detail_sales->PBLN07) * ($detail_sales->REVBLN07)) - ($tot_amount + $real_07);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '08'){
                                            $new_balance = $detail_budget->PBLN08 - ($tot_amount + $real_08);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN08 / $detail_sales->PBLN08) * ($detail_sales->REVBLN08) * 0.85) - ($tot_amount + $real_08);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN08 / $detail_sales->PBLN08) * ($detail_sales->REVBLN08)) - ($tot_amount + $real_08);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '09'){
                                            $new_balance = $detail_budget->PBLN09 - ($tot_amount + $real_09);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN09 / $detail_sales->PBLN09) * ($detail_sales->REVBLN09) * 0.85) - ($tot_amount + $real_09);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN09 / $detail_sales->PBLN09) * ($detail_sales->REVBLN09)) - ($tot_amount + $real_09);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '10'){
                                            $new_balance = $detail_budget->PBLN10 - ($tot_amount + $real_10);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN10 / $detail_sales->PBLN10) * ($detail_sales->REVBLN10) * 0.85) - ($tot_amount + $real_10);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN10 / $detail_sales->PBLN10) * ($detail_sales->REVBLN10)) - ($tot_amount + $real_10);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '11'){
                                            $new_balance = $detail_budget->PBLN11 - ($tot_amount + $real_11);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN11 / $detail_sales->PBLN11) * ($detail_sales->REVBLN11) * 0.85) - ($tot_amount + $real_11);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN11 / $detail_sales->PBLN11) * ($detail_sales->REVBLN11)) - ($tot_amount + $real_11);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '12'){
                                            $new_balance = $detail_budget->PBLN12 - ($tot_amount + $real_12);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($detail_budget->PBLN12 / $detail_sales->PBLN12) * ($detail_sales->REVBLN12) * 0.85) - ($tot_amount + $real_12);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($detail_budget->PBLN12 / $detail_sales->PBLN12) * ($detail_sales->REVBLN12)) - ($tot_amount + $real_12);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        }
                                    }
                                }  else {
                                    if($revisi_budget != NULL){
                                        if(substr($est_date,4,2) == '01'){
                                            $new_balance = $revisi_budget->PBLN13 - ($tot_amount + $real_13);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN13 / $detail_sales->PBLN13) * ($detail_sales->REVBLN13) * 0.85) - ($tot_amount + $real_13);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN13 / $detail_sales->PBLN13) * ($detail_sales->REVBLN13)) - ($tot_amount + $real_13);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '02'){
                                            $new_balance = $revisi_budget->PBLN14 - ($tot_amount + $real_14);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN14 / $detail_sales->PBLN14) * ($detail_sales->REVBLN14) * 0.85) - ($tot_amount + $real_14);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN14 / $detail_sales->PBLN14) * ($detail_sales->REVBLN14)) - ($tot_amount + $real_14);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '03'){
                                            $new_balance = $revisi_budget->PBLN15 - ($tot_amount + $real_15);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN15 / $detail_sales->PBLN15) * ($detail_sales->REVBLN15) * 0.85) - ($tot_amount + $real_15);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN15 / $detail_sales->PBLN15) * ($detail_sales->REVBLN15)) - ($tot_amount + $real_15);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '04'){
                                            $new_balance = $revisi_budget->PBLN04 - ($tot_amount + $real_04);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN04 / $detail_sales->PBLN04) * ($detail_sales->REVBLN04) * 0.85) - ($tot_amount + $real_04);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN04 / $detail_sales->PBLN04) * ($detail_sales->REVBLN04)) - ($tot_amount + $real_04);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '05'){
                                            $new_balance = $revisi_budget->PBLN05 - ($tot_amount + $real_05);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN05 / $detail_sales->PBLN05) * ($detail_sales->REVBLN05) * 0.85) - ($tot_amount + $real_05);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN05 / $detail_sales->PBLN05) * ($detail_sales->REVBLN05)) - ($tot_amount + $real_05);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '06'){
                                            $new_balance = $revisi_budget->PBLN06 - ($tot_amount + $real_06);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN06 / $detail_sales->PBLN06) * ($detail_sales->REVBLN06) * 0.85) - ($tot_amount + $real_06);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN06 / $detail_sales->PBLN06) * ($detail_sales->REVBLN06)) - ($tot_amount + $real_06);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '07'){
                                            $new_balance = $revisi_budget->PBLN07 - ($tot_amount + $real_07);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN07 / $detail_sales->PBLN07) * ($detail_sales->REVBLN07) * 0.85) - ($tot_amount + $real_07);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN07 / $detail_sales->PBLN07) * ($detail_sales->REVBLN07)) - ($tot_amount + $real_07);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '08'){
                                            $new_balance = $revisi_budget->PBLN08 - ($tot_amount + $real_08);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN08 / $detail_sales->PBLN08) * ($detail_sales->REVBLN08) * 0.85) - ($tot_amount + $real_08);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN08 / $detail_sales->PBLN08) * ($detail_sales->REVBLN08)) - ($tot_amount + $real_08);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '09'){
                                            $new_balance = $revisi_budget->PBLN09 - ($tot_amount + $real_09);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN09 / $detail_sales->PBLN09) * ($detail_sales->REVBLN09) * 0.85) - ($tot_amount + $real_09);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN09 / $detail_sales->PBLN09) * ($detail_sales->REVBLN09)) - ($tot_amount + $real_09);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '10'){
                                            $new_balance = $revisi_budget->PBLN10 - ($tot_amount + $real_10);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN10 / $detail_sales->PBLN10) * ($detail_sales->REVBLN10) * 0.85) - ($tot_amount + $real_10);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN10 / $detail_sales->PBLN10) * ($detail_sales->REVBLN10)) - ($tot_amount + $real_10);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }

                                        } elseif (substr($est_date,4,2) == '11'){
                                            $new_balance = $revisi_budget->PBLN11 - ($tot_amount + $real_11);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN11 / $detail_sales->PBLN11) * ($detail_sales->REVBLN11) * 0.85) - ($tot_amount + $real_11);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN11 / $detail_sales->PBLN11) * ($detail_sales->REVBLN11)) - ($tot_amount + $real_11);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }
                                            
                                        } elseif (substr($est_date,4,2) == '12'){
                                            $new_balance = $revisi_budget->PBLN12 - ($tot_amount + $real_12);
                                            if($new_balance < 0){
                                                $warn_over = 1;
                                            }

                                            if($detail_budget != NULL && $detail_sales != NULL && $bgt_type <> 'CAPEX'){
                                                $new_balance85 = (($revisi_budget->PBLN12 / $detail_sales->PBLN12) * ($detail_sales->REVBLN12) * 0.85) - ($tot_amount + $real_12);
                                                if($new_balance85 < 0){
                                                    $warn_over85 = 1;
                                                }

                                                $new_balance100 = (($revisi_budget->PBLN12 / $detail_sales->PBLN12) * ($detail_sales->REVBLN12)) - ($tot_amount + $real_12);
                                                if($new_balance100 < 0){
                                                    $warn_over100 = 1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                        <div style=" font-size: 14px;">
                            <table width="100%" >
                                <tr>
                                    <td width='10%'></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;"></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;">DETAIL BUDGET DEP. <?php echo $kode_dept; ?></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;"></td>
                                    <td width='1%'></td>
                                    <td colspan='3' width='35%'align='center' style="font-weight: bold;">TOTAL BUDGET PLANT</td>
                                </tr>
                                <tr>
                                    <th width='10%'></th>
                                    <td width='2%' align='center'></td>
                                    <td width='15%' align='right'></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right'></td>
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;"></td>
                                    <td width='2%' align='center'></td>
                                    <td width='17%' align='right' style="font-weight: bold;"></td>
                                </tr>
                                <tr>
                                    <th width='10%'></th>
                                    <td width='2%' align='center'></td>
                                    <td width='15%' align='center' style="font-weight: bold;">Budget Dep. <?php echo $kode_dept . ' (' . $bgt_type . ')'; ?></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;">Realisasi Dep. <?php echo $kode_dept . ' (' . $bgt_type . ')'; ?></td>
                                    <td width='2%'></td>
                                    <td width='15%' align='center' style="font-weight: bold;">Saldo Dep. <?php echo $kode_dept . ' (' . $bgt_type . ')'; ?></td>
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;"></td>
                                    <td width='2%' align='center'></td>
                                    <td width='17%' align='right' style="font-weight: bold;"></td>
                                </tr>
                                <tr>
                                    <!-- RBG BASED ON SALES -->
                                    <?php 
                                    $tot_sales = 0;
                                    $tot_salesrev = 0;
                                    if($bgt_type <> 'CAPEX'){
                                        if($detail_sales != NULL){
                                            $tot_sales = $detail_sales->PBLN04 + $detail_sales->PBLN05 + $detail_sales->PBLN06 + $detail_sales->PBLN07 + $detail_sales->PBLN08 + $detail_sales->PBLN09 + $detail_sales->PBLN10 + $detail_sales->PBLN11 + $detail_sales->PBLN12 + $detail_sales->PBLN13 + $detail_sales->PBLN14 + $detail_sales->PBLN15;
                                            $tot_salesrev = $detail_sales->REVBLN04 + $detail_sales->REVBLN05 + $detail_sales->REVBLN06 + $detail_sales->REVBLN07 + $detail_sales->REVBLN08 + $detail_sales->REVBLN09 + $detail_sales->REVBLN10 + $detail_sales->REVBLN11 + $detail_sales->REVBLN12 + $detail_sales->REVBLN13 + $detail_sales->REVBLN14 + $detail_sales->REVBLN15;
                                                                                    
                                            if($revisi_budget_by_sales != NULL && $bgt_type <> 'CONSU'){
                                                $total_budget_plant_rbg = $revisi_budget_by_sales->PBLN04 + $revisi_budget_by_sales->PBLN05 + $revisi_budget_by_sales->PBLN06 + $revisi_budget_by_sales->PBLN07 + $revisi_budget_by_sales->PBLN08 + $revisi_budget_by_sales->PBLN09 + $revisi_budget_by_sales->PBLN10 + $revisi_budget_by_sales->PBLN11 + $revisi_budget_by_sales->PBLN12 + $revisi_budget_by_sales->PBLN13 + $revisi_budget_by_sales->PBLN14 + $revisi_budget_by_sales->PBLN15;
                                                $total_budget_plant_guide = ($total_budget_plant_rbg/$tot_sales)*$tot_salesrev;
                                            } else {
                                                $total_budget_plant_rbg = $tot_sales*($ratio_sales->DEC_RATIO/100);
                                                $total_budget_plant_guide = $tot_salesrev*($ratio_sales->DEC_RATIO/100);
                                            }

                                            //==== Budget Dept Guide
                                            if($kode_dept != NULL){
                                                if($revisi_budget_by_sales_dept != NULL && $bgt_type <> 'CONSU'){
                                                    $total_budget_dept_guide = $revisi_budget_by_sales_dept->PBLN04 + $revisi_budget_by_sales_dept->PBLN05 + $revisi_budget_by_sales_dept->PBLN06 + $revisi_budget_by_sales_dept->PBLN07 + $revisi_budget_by_sales_dept->PBLN08 + $revisi_budget_by_sales_dept->PBLN09 + $revisi_budget_by_sales_dept->PBLN10 + $revisi_budget_by_sales_dept->PBLN11 + $revisi_budget_by_sales_dept->PBLN12 + $revisi_budget_by_sales_dept->PBLN13 + $revisi_budget_by_sales_dept->PBLN14 + $revisi_budget_by_sales_dept->PBLN15;
                                                } else {
                                                    if($act_periode < $periode_smt2){
                                                        $total_budget_dept_guide = ($total_budget_plant_guide)*($total_all_budget_plan_dept->TOT_BGTPLAN/$total_budget_plant->TOT_BUDGET_PLANT);
                                                    } else {
                                                        $total_budget_dept_guide = ($total_budget_plant_guide)*($total_all_budget_revisi_dept->TOT_BGTREV/$total_all_budget_revisi->TOT_BGTREV);
                                                    }
                                                }                                                
                                            } else {
                                                $total_budget_dept_guide = 0;
                                            }
                                            
                                        }
                                    }
                                    ?>
                                    <!-- RBG BASED ON SALES -->
                                    <th width='10%'>Budget</th>
                                    <td width='2%' align='center'>:</td>
                                    <td width='15%' align='right'>
                                    <?php //BUDGET PLAN
                                        if($bgt_type == 'CAPEX'){
                                            if($total_budget_plan->TOT_BGTPLAN == NULL){ 
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                            } else {
                                                echo 'Rp ' . number_format($total_budget_plan->TOT_BGTPLAN,2,',','.'); 
                                            }
                                        } else {
                                            if($total_budget_dept_guide == NULL){ 
                                                echo 'Rp ' . number_format(0, 2, ',', '.');
                                            } else {
                                                echo 'Rp ' . number_format($total_budget_dept_guide,2,',','.'); 
                                            }
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
                                          if($bgt_type == 'CAPEX'){
                                            $saldo_budget = $total_budget_plan->TOT_BGTPLAN - $total_budget_real->TOT_BUDGET_REAL;
                                          } else {
                                            $saldo_budget = $total_budget_dept_guide - $total_budget_real->TOT_BUDGET_REAL;
                                          }
                                          
                                          echo 'Rp ' . number_format($saldo_budget, 2, ',', '.');
                                    ?>
                                    </td>                                    
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;">Total RBG FY <?php echo $tahun; ?></td>
                                    <td width='2%' align='center'>:</td>
                                    <td width='17%' align='right' style="font-weight: bold;">
                                        Rp <?php 
                                                if($bgt_type == 'CAPEX'){
                                                    if($act_periode < $periode_smt2){
                                                        echo number_format($total_budget_plant->TOT_BUDGET_PLANT, 2, ',', '.') . ' (100,0%)'; 
                                                    } else {
                                                        echo number_format($total_budget_plant->TOT_BUDGET_PLANT, 2, ',', '.') . ' (---,-%)';
                                                    }
                                                } else {
                                                    echo number_format($total_budget_plant_rbg, 2, ',', '.') . ' (---,-%)';
                                                }
                                            ?>
                                    </td>
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
                                    <td width='17%' align='right' style="font-weight: bold;">Outlook Guideline FY <?php echo $tahun; ?></td>
                                    <td width='2%' align='center'>:</td>
                                    <td width='17%' align='right' style="font-weight: bold;">
                                        Rp <?php 
                                                if($bgt_type == 'CAPEX'){
                                                    if($act_periode < $periode_smt2){
                                                        echo number_format(0, 2, ',', '.') . ' (0,0%)'; 
                                                    } else {
                                                        echo number_format($total_all_budget_revisi->TOT_BGTREV, 2, ',', '.') . ' (100,0%)'; 
                                                    }
                                                } else {
                                                    echo number_format($total_budget_plant_guide, 2, ',', '.') . ' (100,0%)';
                                                }
                                           ?>
                                    </td>
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
                                    <?php                                         
                                        if($bgt_type == 'CAPEX'){
                                            if($act_periode < $periode_smt2){ //--- BEFORE REVISION
                                                if($total_budget_plant->TOT_BUDGET_PLANT == 0){
                                                    $percent_real = 0;
                                                } else {
                                                    if($total_real_plant != NULL){
                                                        $percent_real = ($total_real_plant->TOT_REAL_PLANT / $total_budget_plant->TOT_BUDGET_PLANT)*100;
                                                    } else {
                                                        $percent_real = 0;
                                                    }                                                
                                                }
                                            } else { //--- AFTER REVISION
                                               if($total_all_budget_revisi->TOT_BGTREV == 0){
                                                    $percent_real = 0;
                                                } else {
                                                    if($total_real_plant != NULL){
                                                        $percent_real = ($total_real_plant->TOT_REAL_PLANT / $total_all_budget_revisi->TOT_BGTREV)*100;
                                                    } else {
                                                        $percent_real = 0;
                                                    }                                                
                                                } 
                                            }
                                        } else {
                                            if($total_real_plant != NULL){
                                                if($total_budget_plant_guide == 0){
                                                    $percent_real = 0;
                                                } else {
                                                    $percent_real = ($total_real_plant->TOT_REAL_PLANT / $total_budget_plant_guide)*100;
                                                }
                                                
                                            } else {
                                                $percent_real = 0;
                                            }  
                                        }
                                        
                                    ?>
                                    
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;">Total Realisasi FY <?php echo $tahun; ?></td>
                                    <td width='2%' align='center'>:</td>
                                    <td width='17%' align='right' style="font-weight: bold;">Rp 
                                        <?php 
                                            if($total_real_plant != NULL){
                                                echo number_format($total_real_plant->TOT_REAL_PLANT, 2, ',', '.') . ' (' . number_format($percent_real, 1, ',', '.') . '%)';
                                            } else {
                                                echo number_format(0, 2, ',', '.') . ' (' . number_format($percent_real, 1, ',', '.') . '%)';
                                            }                                              
                                        ?>
                                    </td>
                                </tr>
                                <tr style=" border-top-style: solid;">  
                                    <th width='10%'>Total</th>
                                    <td width='2%' align='center'>:</td>
                                    <td width='15%' align='right' style="background-color: #FBEDC8; font-weight: bold;">
                                    <?php //TOTAL_BUDGET_PLAN
                                        if($bgt_type == 'CAPEX'){
                                            $total_plan = $total_budget_plan->TOT_BGTPLAN + $total_unbudget_plan->TOT_UNBUDGET + $total_cip_plan->TOT_CIPPLAN;
                                        } else {
                                            $total_plan = $total_budget_dept_guide + $total_unbudget_plan->TOT_UNBUDGET + $total_cip_plan->TOT_CIPPLAN;
                                        }
                                        
                                        echo 'Rp ' . number_format($total_plan, 2, ',', '.');
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right' style="background-color: #FBEDC8; font-weight: bold;">
                                    <?php //TOTAL REALIZATION
                                          $total_real = $total_budget_real->TOT_BUDGET_REAL + $total_unbudget_real->TOT_UNBUDGET_REAL + $total_cip_real->TOT_CIP_REAL;
                                          echo 'Rp ' . number_format($total_real, 2, ',', '.');                                          
                                    ?>
                                    </td>
                                    <td width='2%'></td>
                                    <td width='15%' align='right' style="background-color: #FBEDC8; font-weight: bold;">
                                    <?php //TOTAL SALDO
                                          $total_saldo = $saldo_budget + $saldo_unbudget + $saldo_cip;
                                          echo 'Rp ' . number_format($total_saldo, 2, ',', '.');                                          
                                    ?>
                                    </td>
                                    
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;">Total Saldo FY <?php echo $tahun; ?></td>
                                    <td width='2%' align='center'>:</td>
                                    <?php
                                        if($bgt_type == 'CAPEX'){
                                            if($act_periode < $periode_smt2){ //--- BEFORE REVISION
                                                if($total_real_plant != NULL){
                                                    $saldo_plant = $total_budget_plant->TOT_BUDGET_PLANT - $total_real_plant->TOT_REAL_PLANT;
                                                } else {
                                                    $saldo_plant = $total_budget_plant->TOT_BUDGET_PLANT - 0;
                                                }   
                                                
                                                if($total_budget_plant->TOT_BUDGET_PLANT == 0){
                                                    $percent_saldo = 0;
                                                } else {
                                                    $percent_saldo = ($saldo_plant / $total_budget_plant->TOT_BUDGET_PLANT)*100;
                                                }
                                            } else { //--- AFTER REVISION
                                                if($total_real_plant != NULL){
                                                    $saldo_plant =  $total_all_budget_revisi->TOT_BGTREV - $total_real_plant->TOT_REAL_PLANT;
                                                } else {
                                                    $saldo_plant =  $total_all_budget_revisi->TOT_BGTREV - 0;
                                                }
                                                
                                                if($total_all_budget_revisi->TOT_BGTREV == 0){
                                                    $percent_saldo = 0;
                                                } else {
                                                    $percent_saldo = ($saldo_plant / $total_all_budget_revisi->TOT_BGTREV)*100;
                                                }
                                            }
                                        } else {
                                            if($total_real_plant != NULL){
                                                $saldo_plant = $total_budget_plant_guide - $total_real_plant->TOT_REAL_PLANT;
                                            } else {
                                                $saldo_plant = $total_budget_plant_guide - 0;
                                            }

                                            if($total_budget_plant_guide == 0){
                                                $percent_saldo = 0;
                                            } else {
                                                $percent_saldo = ($saldo_plant / $total_budget_plant_guide)*100;
                                            }
                                        }
                                        
                                    ?>
                                    <td width='17%' align='right' style="background-color: #FBEDC8; font-weight: bold;">Rp <?php echo number_format($saldo_plant, 2, ',', '.') . ' (' . number_format($percent_saldo, 1, ',', '.') . '%)';  ?></td>
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
                                    <td width='15%' align='right' style="font-weight: bold;">Next Saldo <?php echo $kode_dept. ' (' . $bgt_type . ') '; ?></td>
                                    <td width='2%' align='center'>:</td>
                                    <?php
                                        $next_saldo = $total_saldo - $tot_amount;
                                    ?>
                                    <td width='15%' align='right' style="background-color: #FBEDC8; font-weight: bold;">Rp <?php echo number_format($next_saldo, 2, ',', '.'); ?></td>
                                    <td width='1%'></td>
                                    <td width='17%' align='right' style="font-weight: bold;">Next Saldo FY <?php echo $tahun; ?></td>
                                    <td width='2%' align='center'>:</td>
                                    <?php
                                        $next_saldo_plant = $saldo_plant - $tot_amount;
                                        if($bgt_type == 'CAPEX'){
                                            if($act_periode < $periode_smt2){
                                                if($total_budget_plant->TOT_BUDGET_PLANT == 0){
                                                    $percent_next_saldo = 0;
                                                } else {
                                                    $percent_next_saldo = ($next_saldo_plant / $total_budget_plant->TOT_BUDGET_PLANT)*100;
                                                } 
                                            } else { //AFTER REVISION
                                                if($total_all_budget_revisi->TOT_BGTREV == 0){
                                                    $percent_next_saldo = 0;
                                                } else {
                                                    $percent_next_saldo = ($next_saldo_plant / $total_all_budget_revisi->TOT_BGTREV)*100;
                                                }
                                            }
                                        } else {
                                            if($total_budget_plant_guide == 0){
                                                $percent_next_saldo = 0;
                                            } else {
                                                $percent_next_saldo = ($next_saldo_plant / $total_budget_plant_guide)*100;
                                            }
                                        }
                                        
                                    ?>
                                    <td width='17%' align='right' style="background-color: #FBEDC8; font-weight: bold;">Rp <?php echo number_format($next_saldo_plant, 2, ',', '.') . ' (' . number_format($percent_next_saldo, 1, ',', '.') . '%)';  ?></td>
                                </tr>                                
                            </table>                            
                        </div>
                        <div> &nbsp;</div>
                        <div> &nbsp;</div>
                        <div>
                            <table width='100%' style="font-size: 14px;">
                                <?php 
                                    $act_month = date('Ym');
                                    $bg_color = 'background-color:blue;' 
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
                                                $ytd_sales = 0;
                                                echo number_format($detail_sales->PBLN04/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN04;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->PBLN05/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN05;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->PBLN06/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN06;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->PBLN07/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN07;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN08/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN08;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php   
                                                echo number_format($detail_sales->PBLN09/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN09;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->PBLN10/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN10;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN11/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN11;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN12/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN12;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN13/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN13;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN14/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_sales = $ytd_sales + $detail_sales->PBLN14;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->PBLN15/1000000, 0, ',', '.');
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
                                                $ytd_salesrev = 0;
                                                echo number_format($detail_sales->REVBLN04/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '04'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN04;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->REVBLN05/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '05'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN05;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->REVBLN06/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '06'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN06;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                                echo number_format($detail_sales->REVBLN07/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '07'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN07;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN08/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '08'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN08;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php   
                                                echo number_format($detail_sales->REVBLN09/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '09'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN09;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php
                                                echo number_format($detail_sales->REVBLN10/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '10'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN10;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN11/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '11'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN11;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN12/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun . '12'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN12;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN13/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun + 1 . '01'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN13;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN14/1000000, 0, ',', '.');
                                                if ($act_month >= $tahun + 1 . '02'){
                                                    $ytd_salesrev = $ytd_salesrev + $detail_sales->REVBLN14;
                                                }
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php  
                                                echo number_format($detail_sales->REVBLN15/1000000, 0, ',', '.');
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
                                <?php } else { ?>
                                <!-- NEW REVISE METHODE - AFTER CR -->
                                <?php if($revisi_budget_by_sales != NULL && $bgt_type <> 'CONSU'){ ?>
                                <tr>
                                    <td style="font-weight: bold;">Expense</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                    <?php 
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
                                            $tot_plan = 0;
                                            $ytd_plan = 0;
                                            $mon_rbg04 = 0;
                                            if($detail_sales != NULL){ 
                                                $mon_rbg04 = $detail_sales->PBLN04*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg05 = $detail_sales->PBLN05*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg06 = $detail_sales->PBLN06*($ratio_sales->DEC_RATIO/100);
                                                echo number_format($mon_rbg06/1000000, 0, ',', '.');
                                                $tot_plan = $tot_plan + $mon_rbg04;
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
                                                $mon_rbg07 = $detail_sales->PBLN07*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg08 = $detail_sales->PBLN08*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg09 = $detail_sales->PBLN09*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg10 = $detail_sales->PBLN10*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg11 = $detail_sales->PBLN11*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg12 = $detail_sales->PBLN12*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg13 = $detail_sales->PBLN13*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg14 = $detail_sales->PBLN14*($ratio_sales->DEC_RATIO/100);
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
                                                $mon_rbg15 = $detail_sales->PBLN15*($ratio_sales->DEC_RATIO/100);
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
                                <?php if($bgt_type == 'CAPEX'){ ?>                                                           
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
                                <tr>
                                    <td style="font-weight: bold;">Top Up</td>
                                    <td align='center'>:</td>
                                    <td align='right'>
                                        <?php
                                            $tot_topup = 0;
                                            $ytd_topup = 0;
                                            echo number_format($topup_budget[0]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[0];
                                            $ytd_topup = $ytd_topup + $topup_budget[0];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[1]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[1];
                                            $ytd_topup = $ytd_topup + $topup_budget[1];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[2]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[2]; 
                                            $ytd_topup = $ytd_topup + $topup_budget[2];   
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[3]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[3];
                                            $ytd_topup = $ytd_topup + $topup_budget[3];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[4]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[4];
                                            $ytd_topup = $ytd_topup + $topup_budget[4];    
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[5]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[5];
                                            $ytd_topup = $ytd_topup + $topup_budget[5];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[6]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[6];
                                            $ytd_topup = $ytd_topup + $topup_budget[6];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[7]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[7];
                                            $ytd_topup = $ytd_topup + $topup_budget[7];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[8]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[8];
                                            $ytd_topup = $ytd_topup + $topup_budget[8];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[9]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[9];
                                            $ytd_topup = $ytd_topup + $topup_budget[9];
                                        ?>
                                    </td>
                                    <td align='right'>
                                        <?php 
                                            echo number_format($topup_budget[10]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[10];
                                            $ytd_topup = $ytd_topup + $topup_budget[10];
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php 
                                            echo number_format($topup_budget[11]/1000000, 0, ',', '.'); 
                                            $tot_topup = $tot_topup + $topup_budget[11];
                                            $ytd_topup = $ytd_topup + $topup_budget[11];
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php 
                                            echo number_format($ytd_topup/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td align='right' >
                                        <?php 
                                            echo number_format($tot_topup/1000000, 0, ',', '.');
                                        ?>
                                    </td>
                                    <td></td>
                                    <td align='right'>
                                        <?php
                                            if($act_periode < $periode_smt2){
                                                if($tot_plan != 0){
                                                    $percent_topup = ($tot_topup/$tot_plan)*100;
                                                } else {
                                                    $percent_topup = 0;
                                                }                                                
                                            } else {
                                                if($tot_rev != 0){
                                                    $percent_topup = ($tot_topup/$tot_rev)*100;
                                                } else {
                                                    $percent_topup = 0;
                                                }                                                
                                            }
                                            
                                            echo number_format($percent_topup, 2, ',', '.') . '%';
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
        <!-- DETAIL BUDGET DEPT -->        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL USAGE BUDGET - DEPT <?php echo $dept_name; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe style="background-color:white;" frameBorder="0" width='100%' height='180px' src="<?php echo site_url("budget/report_budget_c/view_detail_budget_dept/" . $tahun . "/" . $bgt_type . "/" . $kode_dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- DETAIL BUDGET DEPT -->
        <!-- DETAIL BUDGET GROUP -->        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL USAGE BUDGET - GROUP</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='180px' src="<?php echo site_url("budget/report_budget_c/view_detail_budget_gm/" . $tahun . "/" . $bgt_type . "/" . $kode_dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- DETAIL BUDGET GROUP -->
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        document.body.style.zoom = 0.75;

        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
    
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

    $(document).ready(function () {
        var over = <?php echo $warn_over; ?>;
        var over85 = <?php echo $warn_over85; ?>;
        var over100 = <?php echo $warn_over100; ?>;

        if(over === 1){
            document.getElementById("overbudget").removeAttribute("hidden");
        } else {
            if(over100 === 1){
                document.getElementById("overbudget100").removeAttribute("hidden");
            } else {
                if(over85 === 1){
                    document.getElementById("overbudget85").removeAttribute("hidden");
                }
            }  
        }
    });
</script>