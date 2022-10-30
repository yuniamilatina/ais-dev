<?php header("Content-type: text/html; charset=iso-8859-1"); ?>
<style>
    #filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }
    
    #detail_request { 
        border-spacing: 5px;
        border-collapse: separate;
    }
    
    .prop_amo_cpx {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_rmb {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_teq {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_off {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_emp {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_tri {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_eng {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_ren {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_ite {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_rnd {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_don {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    #tot_prop_amo {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: paleturquoise;
        text-align: right;
    }
    
    #tot_all_prop_amo {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: paleturquoise;
        text-align: right;
    }
    
    #input_notes {
        font-size: 11px;
        width: 120px;
        height: 23px;
        background-color: whitesmoke;
    }
    
    #textarea {
        width: 380px;
        height: 50px;
    }
    
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Propose Budget Monthly</strong></a></li>
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
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>APPROVAL BUDGET FOR <?php echo strtoupper(date("F", mktime(null, null, null, $month))) . ' ' . substr($year_month,0,4); ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <form method="post" id="filter_form" action="<?php if($role == '4' || $role == '1') { 
                                                                            echo site_url("budget/propose_budget_c/approved_propose_budget_gm"); 
                                                                        } else if ($role == '3'){
                                                                            echo site_url("budget/propose_budget_c/approved_propose_budget_bod");
                                                                        }
                                                                ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                    <div class="grid-body">
                        <div class="pull">                            
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Fiscal</td>                                    
                                    <td width="20%">
                                        <select name="CHR_FISCAL" class="form-control" id="fiscal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/propose_budget' . $data->CHR_FISCAL_YEAR_START . '/' . $year_month . '/' . $kode_dept); ?>" <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="10%">Policy Limit</td>
                                    <td width="20%">
                                        <select name="CHR_POLICY" class="form-control" id="policy" onchange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                            <option value="">70%</option>                                            
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                </tr>                                
                                <tr>
                                    <td>Month</td>                                    
                                    <td>
                                        <select class="form-control" id="month" onChange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                            <?php for($i = 0; $i < 12; $i++) { ?>
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/manage_approval_monthly_budget/' . $fiscal_start . '/' . $all_month[$i][0] . '/' . $kode_dept); ?>"
                                            <?php 
                                                if($year_month == $all_month[$i][0]){ 
                                                    echo " selected";
                                                }
                                            ?> > 
                                            <?php echo $all_month[$i][1]; ?> </option>
                                            <?php } ?>
                                    </td>
                                    <td></td>
                                    <td>Department</td>
                                    <td>
                                        <?php if($role == '5'){ ?>
                                            <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                        <?php } else { ?>
                                            <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                        <?php } ?> 
                                            <option value=""></option>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/propose_budget_c/propose_budget/' . $fiscal_start . '/' . $year_month . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $dept->CHR_KODE_DEPARTMENT; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>                                
                            </table>
                        </div>
                        <div>&nbsp;</div>                        
                        <div style="font-size:11px;">
                            <?php 
                                $tot_plan_cpx = 0;
                                $tot_limit_cpx = 0;
                                $tot_real_cpx = 0;
                                $tot_prop_cpx = 0;
                                
                                if($propose_capex != NULL){ 
                            ?>
                            <table style="font-size:11px;" id="table_cpx" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>CAPEX (Capital Expenditure)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>                                        
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_cpx = 1;
                                        foreach ($propose_capex as $cpx) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_cpx . "</td>";
                                            echo "<td align='left'>" . $cpx->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($cpx->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($cpx->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($cpx->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($cpx->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_prop_amo_". $cpx->CHR_NO_BUDGET ."' class='prop_amo_cpx' value='" . number_format($cpx->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($cpx->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($cpx->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($cpx->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($cpx->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $cpx->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($cpx->CHR_NO_BUDGET) . "' id='check_". $cpx->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_cpx();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_notes' value='". $cpx->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($cpx->CHR_NO_BUDGET) ."' value='". $cpx->CHR_YEAR_ACTUAL . $cpx->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_cpx = $tot_plan_cpx + $cpx->MON_PLAN_BLN;
                                            $tot_limit_cpx = $tot_limit_cpx + $cpx->MON_LIMIT_BLN;
                                            $tot_real_cpx = $tot_real_cpx + $cpx->MON_REAL_BLN;
                                            $tot_prop_cpx = $tot_prop_cpx + $cpx->MON_PROPOSE_BLN;
                                            $no_cpx++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_cpx" value="<?php echo number_format($tot_prop_cpx,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }                                
                                $tot_plan_rmb = 0;
                                $tot_limit_rmb = 0;
                                $tot_real_rmb = 0;
                                $tot_prop_rmb = 0;
                                
                                if($propose_repma != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_rmb" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>REPMA (Repair Maintenance)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>                                        
                                        <td width="10%" align="center"><strong>Remark</strong></td>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_rmb = 1;
                                        foreach ($propose_repma as $rmb) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_rmb . "</td>";
                                            echo "<td align='left'>" . $rmb->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($rmb->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($rmb->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rmb->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rmb->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rmb->CHR_NO_BUDGET ."' class='prop_amo_rmb' value='" . number_format($rmb->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($rmb->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($rmb->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($rmb->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }                                            
                                             
                                            if($rmb->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $rmb->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rmb->CHR_NO_BUDGET) . "' id='check_". $rmb->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_rmb();'></td>";                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_notes' value='". $rmb->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($rmb->CHR_NO_BUDGET) ."' value='". $rmb->CHR_YEAR_ACTUAL . $rmb->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_rmb = $tot_plan_rmb + $rmb->MON_PLAN_BLN;
                                            $tot_limit_rmb = $tot_limit_rmb + $rmb->MON_LIMIT_BLN;
                                            $tot_real_rmb = $tot_real_rmb + $rmb->MON_REAL_BLN;
                                            $tot_prop_rmb = $tot_prop_rmb + $rmb->MON_PROPOSE_BLN;
                                            $no_rmb++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rmb" value="<?php echo number_format($tot_prop_rmb,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_teq = 0;
                                $tot_limit_teq = 0;
                                $tot_real_teq = 0;
                                $tot_prop_teq = 0;
                                        
                                if($propose_tooeq != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_teq" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>TOOEQ (Tools Equipment)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_teq = 1;
                                        foreach ($propose_tooeq as $teq) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_teq . "</td>";
                                            echo "<td align='left'>" . $teq->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($teq->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($teq->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($teq->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($teq->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($teq->CHR_NO_BUDGET) . "' id='input_prop_amo_". $teq->CHR_NO_BUDGET ."' class='prop_amo_teq' value='" . number_format($teq->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($teq->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($teq->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($teq->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($teq->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $teq->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($teq->CHR_NO_BUDGET) . "' id='check_". $teq->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_teq();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($teq->CHR_NO_BUDGET) . "' id='input_notes' value='". $teq->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($teq->CHR_NO_BUDGET) ."' value='". $teq->CHR_YEAR_ACTUAL . $teq->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_teq = $tot_plan_teq + $teq->MON_PLAN_BLN;
                                            $tot_limit_teq = $tot_limit_teq + $teq->MON_LIMIT_BLN;
                                            $tot_real_teq = $tot_real_teq + $teq->MON_REAL_BLN;
                                            $tot_prop_teq = $tot_prop_teq + $teq->MON_PROPOSE_BLN;
                                            $no_teq++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_teq" value="<?php echo number_format($tot_prop_teq,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_off = 0;
                                $tot_limit_off = 0;
                                $tot_real_off = 0;
                                $tot_prop_off = 0;
                                        
                                if($propose_offeq != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_off" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>OFFEQ (Office Equipment)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_off = 1;
                                        foreach ($propose_offeq as $off) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_off . "</td>";
                                            echo "<td align='left'>" . $off->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($off->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($off->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($off->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($off->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($off->CHR_NO_BUDGET) . "' id='input_prop_amo_". $off->CHR_NO_BUDGET ."' class='prop_amo_off' value='" . number_format($off->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($off->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($off->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($off->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($off->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $off->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($off->CHR_NO_BUDGET) . "' id='check_". $off->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_off();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($off->CHR_NO_BUDGET) . "' id='input_notes' value='". $off->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($off->CHR_NO_BUDGET) ."' value='". $off->CHR_YEAR_ACTUAL . $off->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_off = $tot_plan_off + $off->MON_PLAN_BLN;
                                            $tot_limit_off = $tot_limit_off + $off->MON_LIMIT_BLN;
                                            $tot_real_off = $tot_real_off + $off->MON_REAL_BLN;
                                            $tot_prop_off = $tot_prop_off + $off->MON_PROPOSE_BLN;
                                            $no_off++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_off" value="<?php echo number_format($tot_prop_off,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_tri = 0;
                                $tot_limit_tri = 0;
                                $tot_real_tri = 0;
                                $tot_prop_tri = 0;
                                        
                                if($propose_trial != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_tri" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>TRIAL (Trial and Inspection Cost)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_tri = 1;
                                        foreach ($propose_trial as $tri) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_tri . "</td>";
                                            echo "<td align='left'>" . $tri->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($tri->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($tri->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($tri->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($tri->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($tri->CHR_NO_BUDGET) . "' id='input_prop_amo_". $tri->CHR_NO_BUDGET ."' class='prop_amo_tri' value='" . number_format($tri->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($tri->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($tri->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($tri->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($tri->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $tri->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($tri->CHR_NO_BUDGET) . "' id='check_". $tri->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_tri();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($tri->CHR_NO_BUDGET) . "' id='input_notes' value='". $tri->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($tri->CHR_NO_BUDGET) ."' value='". $tri->CHR_YEAR_ACTUAL . $tri->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_tri = $tot_plan_tri + $tri->MON_PLAN_BLN;
                                            $tot_limit_tri = $tot_limit_tri + $tri->MON_LIMIT_BLN;
                                            $tot_real_tri = $tot_real_tri + $tri->MON_REAL_BLN;
                                            $tot_prop_tri = $tot_prop_tri + $tri->MON_PROPOSE_BLN;
                                            $no_tri++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_tri" value="<?php echo number_format($tot_prop_tri,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_emp = 0;
                                $tot_limit_emp = 0;
                                $tot_real_emp = 0;
                                $tot_prop_emp = 0;
                                        
                                if($propose_empwa != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_emp" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>EMPWA (Employee Welfare)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_emp = 1;
                                        foreach ($propose_empwa as $emp) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_emp . "</td>";
                                            echo "<td align='left'>" . $emp->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($emp->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($emp->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($emp->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($emp->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($emp->CHR_NO_BUDGET) . "' id='input_prop_amo_". $emp->CHR_NO_BUDGET ."' class='prop_amo_emp' value='" . number_format($emp->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($emp->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($emp->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($emp->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                               echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($emp->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $emp->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($emp->CHR_NO_BUDGET) . "' id='check_". $emp->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_emp();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($emp->CHR_NO_BUDGET) . "' id='input_notes' value='". $emp->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($emp->CHR_NO_BUDGET) ."' value='". $emp->CHR_YEAR_ACTUAL . $emp->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_emp = $tot_plan_emp + $emp->MON_PLAN_BLN;
                                            $tot_limit_emp = $tot_limit_emp + $emp->MON_LIMIT_BLN;
                                            $tot_real_emp = $tot_real_emp + $emp->MON_REAL_BLN;
                                            $tot_prop_emp = $tot_prop_emp + $emp->MON_PROPOSE_BLN;
                                            $no_emp++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_emp" value="<?php echo number_format($tot_prop_emp,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_eng = 0;
                                $tot_limit_eng = 0;
                                $tot_real_eng = 0;
                                $tot_prop_eng = 0;
                                        
                                if($propose_engfe != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_eng" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>ENGFE (Engineer Fee)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_eng = 1;
                                        foreach ($propose_engfe as $eng) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_eng . "</td>";
                                            echo "<td align='left'>" . $eng->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($eng->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($eng->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($eng->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($eng->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($eng->CHR_NO_BUDGET) . "' id='input_prop_amo_". $eng->CHR_NO_BUDGET ."' class='prop_amo_eng' value='" . number_format($eng->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($eng->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($eng->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($eng->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($eng->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $eng->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($eng->CHR_NO_BUDGET) . "' id='check_". $eng->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_eng();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($eng->CHR_NO_BUDGET) . "' id='input_notes' value='". $eng->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($eng->CHR_NO_BUDGET) ."' value='". $eng->CHR_YEAR_ACTUAL . $eng->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_eng = $tot_plan_eng + $eng->MON_PLAN_BLN;
                                            $tot_limit_eng = $tot_limit_eng + $eng->MON_LIMIT_BLN;
                                            $tot_real_eng = $tot_real_eng + $eng->MON_REAL_BLN;
                                            $tot_prop_eng = $tot_prop_eng + $eng->MON_PROPOSE_BLN;
                                            $no_eng++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_eng" value="<?php echo number_format($tot_prop_eng,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_ite = 0;
                                $tot_limit_ite = 0;
                                $tot_real_ite = 0;
                                $tot_prop_ite = 0;
                                        
                                if($propose_itexp != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_ite" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>ITEXP (IT Expenses)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_ite = 1;
                                        foreach ($propose_itexp as $ite) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_ite . "</td>";
                                            echo "<td align='left'>" . $ite->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($ite->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($ite->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ite->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ite->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ite->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ite->CHR_NO_BUDGET ."' class='prop_amo_ite' value='" . number_format($ite->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($ite->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ite->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ite->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($ite->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $ite->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($ite->CHR_NO_BUDGET) . "' id='check_". $ite->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_ite();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($ite->CHR_NO_BUDGET) . "' id='input_notes' value='". $ite->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($ite->CHR_NO_BUDGET) ."' value='". $ite->CHR_YEAR_ACTUAL . $ite->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_ite = $tot_plan_ite + $ite->MON_PLAN_BLN;
                                            $tot_limit_ite = $tot_limit_ite + $ite->MON_LIMIT_BLN;
                                            $tot_real_ite = $tot_real_ite + $ite->MON_REAL_BLN;
                                            $tot_prop_ite = $tot_prop_ite + $ite->MON_PROPOSE_BLN;
                                            $no_ite++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ite" value="<?php echo number_format($tot_prop_ite,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_ren = 0;
                                $tot_limit_ren = 0;
                                $tot_real_ren = 0;
                                $tot_prop_ren = 0;
                                        
                                if($propose_renta != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_ren" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>RENTA (Rental Expenses)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_ren = 1;
                                        foreach ($propose_renta as $ren) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_ren . "</td>";
                                            echo "<td align='left'>" . $ren->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($ren->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($ren->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ren->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ren->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ren->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ren->CHR_NO_BUDGET ."' class='prop_amo_ren' value='" . number_format($ren->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($ren->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ren->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ren->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ren->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $ren->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($ren->CHR_NO_BUDGET) . "' id='check_". $ren->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_ren();'></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($ren->CHR_NO_BUDGET) . "' id='input_notes' value='". $ren->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($ren->CHR_NO_BUDGET) ."' value='". $ren->CHR_YEAR_ACTUAL . $ren->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_ren = $tot_plan_ren + $ren->MON_PLAN_BLN;
                                            $tot_limit_ren = $tot_limit_ren + $ren->MON_LIMIT_BLN;
                                            $tot_real_ren = $tot_real_ren + $ren->MON_REAL_BLN;
                                            $tot_prop_ren = $tot_prop_ren + $ren->MON_PROPOSE_BLN;
                                            $no_ren++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ren" value="<?php echo number_format($tot_prop_ren,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_rnd = 0;
                                $tot_limit_rnd = 0;
                                $tot_real_rnd = 0;
                                $tot_prop_rnd = 0;
                                        
                                if($propose_rndev != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_rnd" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>RNDEV (Research Development)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_rnd = 1;
                                        foreach ($propose_rndev as $rnd) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_rnd . "</td>";
                                            echo "<td align='left'>" . $rnd->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($rnd->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($rnd->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rnd->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rnd->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rnd->CHR_NO_BUDGET ."' class='prop_amo_rnd' value='" . number_format($rnd->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($rnd->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'></td>";
                                            }
                                            
                                            if($rnd->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($rnd->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($rnd->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $rnd->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rnd->CHR_NO_BUDGET) . "' id='check_". $rnd->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_rnd();'></td>";
                                            echo "<td align='center'><input type='text' name='note_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_notes' value='". $rnd->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($rnd->CHR_NO_BUDGET) ."' value='". $rnd->CHR_YEAR_ACTUAL . $rnd->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_rnd = $tot_plan_rnd + $rnd->MON_PLAN_BLN;
                                            $tot_limit_rnd = $tot_limit_rnd + $rnd->MON_LIMIT_BLN;
                                            $tot_real_rnd = $tot_real_rnd + $rnd->MON_REAL_BLN;
                                            $tot_prop_rnd = $tot_prop_rnd + $rnd->MON_PROPOSE_BLN;
                                            $no_rnd++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rnd" value="<?php echo number_format($tot_prop_rnd,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php  
                                }
                                $tot_plan_don = 0;
                                $tot_limit_don = 0;
                                $tot_real_don = 0;
                                $tot_prop_don = 0;
                                        
                                if($propose_donat != NULL){
                            ?>
                            <table style="font-size:11px;" id="table_don" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px;">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="13"><strong>DONAT (Donation)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="10%" align="center"><strong>No Budget</strong></td>
                                        <td width="10%" align="center"><strong>Budget Desc</strong></td>
                                        <td width="15%" align="center"><strong>Budget Plan</strong></td>
                                        <td width="15%" align="center"><strong>Limit Budget</strong></td> 
                                        <td width="15%" align="center"><strong>Realisasi</strong></td>
                                        <td width="15%" align="center"><strong>Propose</strong></td>                                        
                                        <td width="2%" align="center"><strong>Unbudget</strong></td>
                                        <td width="2%" align="center"><strong>Change Amount</strong></td>
                                        <td width="2%" align="center"><strong>Reschedule</strong></td>
                                        <td width="8%" align="center"><strong>Note</strong></td>
                                        <td width="2%" align="center"><strong>Check</strong></td>                                        
                                        <td width="10%" align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_don = 1;
                                        foreach ($propose_donat as $don) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_don . "</td>";
                                            echo "<td align='left'>" . $don->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($don->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($don->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($don->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($don->MON_REAL_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($don->CHR_NO_BUDGET) . "' id='input_prop_amo_". $don->CHR_NO_BUDGET ."' class='prop_amo_don' value='" . number_format($don->MON_PROPOSE_BLN,0,',','.') . "' readonly></td>";
                                            if($don->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($don->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($don->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($don->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $don->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($don->CHR_NO_BUDGET) . "' id='check_". $don->CHR_NO_BUDGET ."' value='1' checked onchange='disableBudget_don();'></td>";
                                            echo "<td align='center'><input type='text' name='note_" . trim($don->CHR_NO_BUDGET) . "' id='input_notes' value='". $don->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($don->CHR_NO_BUDGET) ."' value='". $don->CHR_YEAR_ACTUAL . $don->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_don = $tot_plan_don + $don->MON_PLAN_BLN;
                                            $tot_limit_don = $tot_limit_don + $don->MON_LIMIT_BLN;
                                            $tot_real_don = $tot_real_don + $don->MON_REAL_BLN;
                                            $tot_prop_don = $tot_prop_don + $prop_don;
                                            $no_don++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_don,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_don,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_don,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_don" value="<?php echo number_format($tot_prop_don,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php } ?>
                        </div>
                        <div style="max-width: 500px;">
                            <table style="font-size:11px;" id="table_summary" class="table table-condensed display" cellspacing="0" width="100%" border="1px;">
                                <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                    <td colspan="4"><strong>SUMMARY TOTAL</strong></td>
                                </tr>
                                <tr style="background-color: #002a80; color: white;">
                                    <td align="center"><strong>Budget Type</strong></td>
                                    <td align="center"><strong>Budget Plan</strong></td>
                                    <td align="center"><strong>Budget Limit</strong></td>
                                    <td align="center"><strong>Propose</strong></td>
                                </tr>
                                <?php
                                    if($propose_capex != NULL){
                                        echo "<tr>";
                                        echo "<td>CAPEX</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_cpx,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_cpx,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_cpx' value='" . number_format($tot_prop_cpx,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_repma != NULL){
                                        echo "<tr>";
                                        echo "<td>REPMA</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_rmb,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_rmb,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rmb' value='" . number_format($tot_prop_rmb,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_tooeq != NULL){
                                        echo "<tr>";
                                        echo "<td>TOOEQ</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_teq,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_teq,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_teq' value='" . number_format($tot_prop_teq,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_offeq != NULL){
                                        echo "<tr>";
                                        echo "<td>OFFEQ</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_off,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_off,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_off' value='" . number_format($tot_prop_off,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_trial != NULL){
                                        echo "<tr>";
                                        echo "<td>TRIAL</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_tri,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_tri,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_tri' value='" . number_format($tot_prop_tri,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_empwa != NULL){
                                        echo "<tr>";
                                        echo "<td>EMPWA</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_emp,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_emp,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_emp' value='" . number_format($tot_prop_emp,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_engfe != NULL){
                                        echo "<tr>";
                                        echo "<td>ENGFE</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_eng,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_eng,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_eng' value='" . number_format($tot_prop_eng,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_itexp != NULL){
                                        echo "<tr>";
                                        echo "<td>ITEXP</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_ite,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_ite,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ite' value='" . number_format($tot_prop_ite,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_renta != NULL){
                                        echo "<tr>";
                                        echo "<td>RENTA</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_ren,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_ren,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ren' value='" . number_format($tot_prop_ren,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_rndev != NULL){
                                        echo "<tr>";
                                        echo "<td>RNDEV</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_rnd,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_rnd,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rnd' value='" . number_format($tot_prop_rnd,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                    if($propose_donat != NULL){
                                        echo "<tr>";
                                        echo "<td>DONAT</td>";
                                        echo "<td align='right'>" . number_format($tot_plan_don,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit_don,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_don' value='" . number_format($tot_prop_don,0,',','.') . "' readonly></strong></td>"; 
                                        echo "</tr>";
                                    }
                                ?>
                                <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                    <td align="center"><strong>TOTAL</strong></td>
                                    <?php 
                                        $tot_sum_plan = $tot_plan_cpx + $tot_plan_rmb + $tot_plan_teq + $tot_plan_off + $tot_plan_tri + 
                                                        $tot_plan_emp + $tot_plan_eng + $tot_plan_ren + $tot_plan_rnd + $tot_plan_ite +
                                                        $tot_plan_don;
                                        $tot_sum_limit = $tot_limit_cpx + $tot_limit_rmb + $tot_limit_teq + $tot_limit_off + $tot_limit_tri + 
                                                        $tot_limit_emp + $tot_limit_eng + $tot_limit_ren + $tot_limit_rnd + $tot_limit_ite +
                                                        $tot_limit_don;
                                        $tot_sum_prop = $tot_prop_cpx + $tot_prop_rmb + $tot_prop_teq + $tot_prop_off + $tot_prop_tri + 
                                                        $tot_prop_emp + $tot_prop_eng + $tot_prop_ren + $tot_prop_rnd + $tot_prop_ite +
                                                        $tot_prop_don;
                                    ?>
                                    <td align="right"><strong>Rp <?php echo number_format($tot_sum_plan,0,',','.'); ?></strong></td>
                                    <td align="right"><strong>Rp <?php echo number_format($tot_sum_limit,0,',','.'); ?></strong></td>
                                    <td align="right"><strong>Rp <input type='text' id="tot_all_prop_amo" class="sum_all_prop_amo" name="summary_all_prop" value="<?php echo number_format($tot_sum_prop,0,',','.');?>" readonly></strong></td>
                                </tr>
                            </table>
                        </div>
                        <div align="right">
                            <input type="hidden" name="CHR_NO_PROPOSE" value="<?php echo $no_propose; ?>">
                            <input type="hidden" name="CHR_YM_PROPOSE" value="<?php echo $year_month; ?>">
                            <input type="hidden" name="CHR_FIS_START" value="<?php echo $fiscal_start; ?>">
                            <input type="hidden" name="CHR_DEPT_PROPOSE" value="<?php echo trim($kode_dept); ?>">
                            <?php 
                                echo anchor('budget/propose_budget_c/manage_approval_monthly_budget/0/' . $fiscal_start . '/' . $year_month . '/' . trim($kode_dept), 'Back', 'class="btn btn-default"');
                            ?>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Approved</button>
                        </div>                        
                    </div>
                    </form>                    
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL USAGE BUDGET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe scrolling="no" frameBorder="0" width='100%' height='350px' src="<?php echo site_url("budget/propose_budget_c/view_detail_budget_per_month/" . $fiscal_start . "/" . $kode_dept . "/CAPEX"); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
    function disableBudget_cpx(){
        var bdgt = <?php echo json_encode($propose_capex); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_cpx')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_cpx").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_rmb(){
        var bdgt = <?php echo json_encode($propose_repma); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_rmb')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_rmb").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_teq(){
        var bdgt = <?php echo json_encode($propose_tooeq); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_teq')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_teq").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_off(){
        var bdgt = <?php echo json_encode($propose_offeq); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_off')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_off").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_tri(){
        var bdgt = <?php echo json_encode($propose_trial); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_tri')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_tri").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_emp(){
        var bdgt = <?php echo json_encode($propose_empwa); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_emp')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_emp").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_eng(){
        var bdgt = <?php echo json_encode($propose_engfe); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_eng')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_eng").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_ite(){
        var bdgt = <?php echo json_encode($propose_itexp); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_ite')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_ite").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_ren(){
        var bdgt = <?php echo json_encode($propose_renta); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_ren')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_ren").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_rnd(){
        var bdgt = <?php echo json_encode($propose_rndev); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_rnd')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_rnd").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
    
    function disableBudget_don(){
        var bdgt = <?php echo json_encode($propose_donat); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_don')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_don").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
</script>
