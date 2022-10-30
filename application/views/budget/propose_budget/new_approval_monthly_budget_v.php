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
    
    .prop_amo_rig {
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
    
    .prop_amo_ent {
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
    
    #tot_next_prop_amo {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: white;
        text-align: right;
    }
    
    #tot_all_prop_amo {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: paleturquoise;
        text-align: right;
    }
    
    #tot_next_all_prop_amo {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: white;
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
                        <span class="grid-title"><strong>APPROVAL BUDGET FOR : <?php echo $no_propose; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <form method="post" id="filter_form" action="<?php if($role == '4') { 
                                                                            echo site_url("budget/new_propose_budget_c/approved_propose_budget_gm"); 
                                                                        } else if ($role == '3'){
                                                                            echo site_url("budget/new_propose_budget_c/approved_propose_budget_bod");
                                                                        } else if ($role == '1' || $role == '2'){
                                                                            echo site_url("budget/new_propose_budget_c/approved_propose_budget_admin");
                                                                        }
                                                                ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                    <div class="grid-body">
                        <div class="pull">                            
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Fiscal</td>                                    
                                    <td width="20%">
                                        <select name="CHR_FISCAL" class="form-control" id="fiscal" onChange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/new_propose_budget_c/propose_budget' . $data->CHR_FISCAL_YEAR_START . '/' . $year_month . '/' . $kode_dept); ?>" <?php
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
                                                <option value="<?PHP echo site_url('budget/new_propose_budget_c/manage_approval_monthly_budget/' . $fiscal_start . '/' . $all_month[$i][0] . '/' . $kode_dept); ?>"
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
                                                <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/' . $year_month . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
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
<!-- ======================= CAPEX ========================================= -->
                        <div style="font-size:11px;">
                            <?php 
                                $tot_plan_cpx = 0;
                                $tot_ori_limit_cpx = 0;
                                $tot_limit_cpx = 0;
                                $tot_real_cpx = 0;
                                $tot_prop_cpx = 0;
                                
                                if($propose_capex != NULL){ 
                            ?>
                            <table id="table_cpx" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>CAPEX (Capital Expenditure)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>                                        
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
                                            echo "<td align='right'>" . number_format(($cpx->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($cpx->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($cpx->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($cpx->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_prop_amo_". $cpx->CHR_NO_BUDGET ."' class='prop_amo_cpx' value='" . number_format($cpx->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($cpx->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($cpx->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($cpx->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $cpx->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($cpx->CHR_NO_BUDGET) . "' id='check_". $cpx->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_cpx();'></td>"; 
                                            
                                            if($cpx->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $cpx->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'> - </td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($cpx->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($cpx->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($cpx->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($cpx->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($cpx->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_notes' value='". $cpx->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            $tot_plan_cpx = $tot_plan_cpx + $cpx->MON_PLAN_BLN;
                                            $tot_ori_limit_cpx = $tot_ori_limit_cpx + ($cpx->MON_PLAN_BLN*0.7);
                                            $tot_limit_cpx = $tot_limit_cpx + $cpx->MON_LIMIT_BLN;
                                            $tot_real_cpx = $tot_real_cpx + $cpx->MON_REAL_BLN;
                                            $tot_prop_cpx = $tot_prop_cpx + $cpx->MON_PROPOSE_BLN;
                                            $no_cpx++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_cpx" value="<?php echo number_format($tot_prop_cpx,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END CAPEX ===================================== -->
<!-- ======================= REPMA ========================================= -->
                            <?php  
                                }                                
                                $tot_plan_rmb = 0;
                                $tot_ori_limit_rmb = 0;
                                $tot_limit_rmb = 0;
                                $tot_real_rmb = 0;
                                $tot_prop_rmb = 0;
                                
                                if($propose_repma != NULL){
                            ?>
                            <table id="table_rmb" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>REPMA (Repair Maintenance)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>                                       
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
                                            echo "<td align='right'>" . number_format(($rmb->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rmb->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rmb->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($rmb->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rmb->CHR_NO_BUDGET ."' class='prop_amo_rmb' value='" . number_format($rmb->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($rmb->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($rmb->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($rmb->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $rmb->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rmb->CHR_NO_BUDGET) . "' id='check_". $rmb->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_rmb();'></td>";                                            
                                                                                         
                                            if($rmb->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $rmb->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($rmb->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($rmb->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($rmb->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($rmb->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($rmb->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_notes' value='". $rmb->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_rmb = $tot_plan_rmb + $rmb->MON_PLAN_BLN;
                                            $tot_ori_limit_rmb = $tot_ori_limit_rmb + ($rmb->MON_PLAN_BLN*0.7);
                                            $tot_limit_rmb = $tot_limit_rmb + $rmb->MON_LIMIT_BLN;
                                            $tot_real_rmb = $tot_real_rmb + $rmb->MON_REAL_BLN;
                                            $tot_prop_rmb = $tot_prop_rmb + $rmb->MON_PROPOSE_BLN;
                                            $no_rmb++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rmb" value="<?php echo number_format($tot_prop_rmb,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END REPMA ===================================== -->
<!-- ======================= RIGHT ========================================= -->
                            <?php  
                                }                                
                                $tot_plan_rig = 0;
                                $tot_ori_limit_rig = 0;
                                $tot_limit_rig = 0;
                                $tot_real_rig = 0;
                                $tot_prop_rig = 0;
                                
                                if($propose_right != NULL){
                            ?>
                            <table id="table_rig" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>RIGHT (Right and Patent)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_rig = 1;
                                        foreach ($propose_right as $rig) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_rig . "</td>";
                                            echo "<td align='left'>" . $rig->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($rig->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($rig->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format(($rig->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rig->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rig->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($rig->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rig->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rig->CHR_NO_BUDGET ."' class='prop_amo_rig' value='" . number_format($rig->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($rig->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($rig->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($rig->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $rig->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rig->CHR_NO_BUDGET) . "' id='check_". $rig->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_rig();'></td>";                                            
                                                                                         
                                            if($rig->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $rig->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($rig->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($rig->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($rig->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($rig->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($rig->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($rig->CHR_NO_BUDGET) . "' id='input_notes' value='". $rig->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_rig = $tot_plan_rig + $rig->MON_PLAN_BLN;
                                            $tot_ori_limit_rig = $tot_ori_limit_rig + ($rig->MON_PLAN_BLN*0.7);
                                            $tot_limit_rig = $tot_limit_rig + $rig->MON_LIMIT_BLN;
                                            $tot_real_rig = $tot_real_rig + $rig->MON_REAL_BLN;
                                            $tot_prop_rig = $tot_prop_rig + $rig->MON_PROPOSE_BLN;
                                            $no_rig++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rig" value="<?php echo number_format($tot_prop_rig,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END RIGHT ===================================== -->
<!-- ======================= TOOEQ ========================================= -->
                            <?php  
                                }
                                $tot_plan_teq = 0;
                                $tot_ori_limit_teq = 0;
                                $tot_limit_teq = 0;
                                $tot_real_teq = 0;
                                $tot_prop_teq = 0;
                                        
                                if($propose_tooeq != NULL){
                            ?>
                            <table id="table_teq" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>TOOEQ (Tools Equipment)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>                                        
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
                                            echo "<td align='right'>" . number_format(($teq->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($teq->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($teq->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($teq->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($teq->CHR_NO_BUDGET) . "' id='input_prop_amo_". $teq->CHR_NO_BUDGET ."' class='prop_amo_teq' value='" . number_format($teq->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($teq->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($teq->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($teq->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $teq->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($teq->CHR_NO_BUDGET) . "' id='check_". $teq->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_teq();'></td>"; 
                                            
                                            if($teq->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $teq->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($teq->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($teq->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($teq->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($teq->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($teq->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($teq->CHR_NO_BUDGET) . "' id='input_notes' value='". $teq->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_teq = $tot_plan_teq + $teq->MON_PLAN_BLN;
                                            $tot_ori_limit_teq = $tot_ori_limit_teq + ($teq->MON_PLAN_BLN*0.7);
                                            $tot_limit_teq = $tot_limit_teq + $teq->MON_LIMIT_BLN;
                                            $tot_real_teq = $tot_real_teq + $teq->MON_REAL_BLN;
                                            $tot_prop_teq = $tot_prop_teq + $teq->MON_PROPOSE_BLN;
                                            $no_teq++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_teq" value="<?php echo number_format($tot_prop_teq,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END TOOEQ ===================================== -->
<!-- ======================= OFFEQ ========================================= -->
                            <?php  
                                }
                                $tot_plan_off = 0;
                                $tot_ori_limit_off = 0;
                                $tot_limit_off = 0;
                                $tot_real_off = 0;
                                $tot_prop_off = 0;
                                        
                                if($propose_offeq != NULL){
                            ?>
                            <table id="table_off" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>OFFEQ (Office Equipment)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($off->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($off->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($off->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($off->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($off->CHR_NO_BUDGET) . "' id='input_prop_amo_". $off->CHR_NO_BUDGET ."' class='prop_amo_off' value='" . number_format($off->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($off->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($off->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($off->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $off->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($off->CHR_NO_BUDGET) . "' id='check_". $off->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_off();'></td>"; 
                                                                                        
                                            if($off->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $off->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($off->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($off->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($off->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($off->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($off->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($off->CHR_NO_BUDGET) . "' id='input_notes' value='". $off->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_off = $tot_plan_off + $off->MON_PLAN_BLN;
                                            $tot_ori_limit_off = $tot_ori_limit_off + ($off->MON_PLAN_BLN*0.7);
                                            $tot_limit_off = $tot_limit_off + $off->MON_LIMIT_BLN;
                                            $tot_real_off = $tot_real_off + $off->MON_REAL_BLN;
                                            $tot_prop_off = $tot_prop_off + $off->MON_PROPOSE_BLN;
                                            $no_off++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_off" value="<?php echo number_format($tot_prop_off,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END OFFEQ ===================================== -->
<!-- ======================= TRIAL ========================================= -->
                            <?php  
                                }
                                $tot_plan_tri = 0;
                                $tot_ori_limit_tri = 0;
                                $tot_limit_tri = 0;
                                $tot_real_tri = 0;
                                $tot_prop_tri = 0;
                                        
                                if($propose_trial != NULL){
                            ?>
                            <table id="table_tri" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>TRIAL (Trial and Inspection Cost)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($tri->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($tri->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($tri->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($tri->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($tri->CHR_NO_BUDGET) . "' id='input_prop_amo_". $tri->CHR_NO_BUDGET ."' class='prop_amo_tri' value='" . number_format($tri->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($tri->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($tri->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($tri->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $tri->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($tri->CHR_NO_BUDGET) . "' id='check_". $tri->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_tri();'></td>"; 
                                            
                                            if($tri->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $tri->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($tri->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($tri->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($tri->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($tri->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($tri->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";                                            
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($tri->CHR_NO_BUDGET) . "' id='input_notes' value='". $tri->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_tri = $tot_plan_tri + $tri->MON_PLAN_BLN;
                                            $tot_ori_limit_tri = $tot_ori_limit_tri + ($tri->MON_PLAN_BLN*0.7);
                                            $tot_limit_tri = $tot_limit_tri + $tri->MON_LIMIT_BLN;
                                            $tot_real_tri = $tot_real_tri + $tri->MON_REAL_BLN;
                                            $tot_prop_tri = $tot_prop_tri + $tri->MON_PROPOSE_BLN;
                                            $no_tri++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_tri" value="<?php echo number_format($tot_prop_tri,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END TRIAL ===================================== -->
<!-- ======================= EMPWA ========================================= -->
                            <?php  
                                }
                                $tot_plan_emp = 0;
                                $tot_ori_limit_emp = 0;
                                $tot_limit_emp = 0;
                                $tot_real_emp = 0;
                                $tot_prop_emp = 0;
                                        
                                if($propose_empwa != NULL){
                            ?>
                            <table id="table_emp" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>EMPWA (Employee Welfare)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($emp->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($emp->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($emp->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($emp->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($emp->CHR_NO_BUDGET) . "' id='input_prop_amo_". $emp->CHR_NO_BUDGET ."' class='prop_amo_emp' value='" . number_format($emp->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($emp->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($emp->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($emp->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $emp->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($emp->CHR_NO_BUDGET) . "' id='check_". $emp->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_emp();'></td>"; 
                                            
                                            if($emp->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $emp->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($emp->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($emp->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($emp->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($emp->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($emp->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";  
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($emp->CHR_NO_BUDGET) . "' id='input_notes' value='". $emp->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_emp = $tot_plan_emp + $emp->MON_PLAN_BLN;
                                            $tot_ori_limit_emp = $tot_ori_limit_emp + ($emp->MON_PLAN_BLN*0.7);
                                            $tot_limit_emp = $tot_limit_emp + $emp->MON_LIMIT_BLN;
                                            $tot_real_emp = $tot_real_emp + $emp->MON_REAL_BLN;
                                            $tot_prop_emp = $tot_prop_emp + $emp->MON_PROPOSE_BLN;
                                            $no_emp++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_emp" value="<?php echo number_format($tot_prop_emp,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END EMPWA ===================================== -->
<!-- ======================= ENGFE ========================================= -->
                            <?php  
                                }
                                $tot_plan_eng = 0;
                                $tot_ori_limit_eng = 0;
                                $tot_limit_eng = 0;
                                $tot_real_eng = 0;
                                $tot_prop_eng = 0;
                                        
                                if($propose_engfe != NULL){
                            ?>
                            <table id="table_eng" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>ENGFE (Engineer Fee)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($eng->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($eng->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($eng->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($eng->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($eng->CHR_NO_BUDGET) . "' id='input_prop_amo_". $eng->CHR_NO_BUDGET ."' class='prop_amo_eng' value='" . number_format($eng->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($eng->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($eng->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($eng->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $eng->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($eng->CHR_NO_BUDGET) . "' id='check_". $eng->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_eng();'></td>"; 
                                            
                                            if($eng->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $eng->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($eng->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($eng->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($eng->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($eng->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($eng->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";  
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($eng->CHR_NO_BUDGET) . "' id='input_notes' value='". $eng->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_eng = $tot_plan_eng + $eng->MON_PLAN_BLN;
                                            $tot_ori_limit_emp = $tot_ori_limit_eng + ($eng->MON_PLAN_BLN*0.7);
                                            $tot_limit_eng = $tot_limit_eng + $eng->MON_LIMIT_BLN;
                                            $tot_real_eng = $tot_real_eng + $eng->MON_REAL_BLN;
                                            $tot_prop_eng = $tot_prop_eng + $eng->MON_PROPOSE_BLN;
                                            $no_eng++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_eng" value="<?php echo number_format($tot_prop_eng,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END ENGFE ===================================== -->
<!-- ======================= ITEXP ========================================= -->
                            <?php  
                                }
                                $tot_plan_ite = 0;
                                $tot_ori_limit_ite = 0;
                                $tot_limit_ite = 0;
                                $tot_real_ite = 0;
                                $tot_prop_ite = 0;
                                        
                                if($propose_itexp != NULL){
                            ?>
                            <table id="table_ite" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>ITEXP (IT Expenses)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($ite->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ite->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ite->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($ite->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ite->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ite->CHR_NO_BUDGET ."' class='prop_amo_ite' value='" . number_format($ite->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($ite->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($ite->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($ite->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $ite->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($ite->CHR_NO_BUDGET) . "' id='check_". $ite->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_ite();'></td>"; 
                                            
                                            if($ite->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $ite->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($ite->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($ite->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($ite->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($ite->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($ite->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>"; 
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($ite->CHR_NO_BUDGET) . "' id='input_notes' value='". $ite->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_ite = $tot_plan_ite + $ite->MON_PLAN_BLN;
                                            $tot_ori_limit_ite = $tot_ori_limit_ite + ($ite->MON_PLAN_BLN*0.7);
                                            $tot_limit_ite = $tot_limit_ite + $ite->MON_LIMIT_BLN;
                                            $tot_real_ite = $tot_real_ite + $ite->MON_REAL_BLN;
                                            $tot_prop_ite = $tot_prop_ite + $ite->MON_PROPOSE_BLN;
                                            $no_ite++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ite" value="<?php echo number_format($tot_prop_ite,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END ITEXP ===================================== -->
<!-- ======================= RENTA ========================================= -->
                            <?php  
                                }
                                $tot_plan_ren = 0;
                                $tot_ori_limit_ren = 0;
                                $tot_limit_ren = 0;
                                $tot_real_ren = 0;
                                $tot_prop_ren = 0;
                                        
                                if($propose_renta != NULL){
                            ?>
                            <table id="table_ren" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>RENTA (Rental Expenses)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($ren->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ren->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ren->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($ren->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ren->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ren->CHR_NO_BUDGET ."' class='prop_amo_ren' value='" . number_format($ren->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($ren->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($ren->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($ren->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $ren->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($ren->CHR_NO_BUDGET) . "' id='check_". $ren->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_ren();'></td>"; 
                                            
                                            if($ren->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $ren->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($ren->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($ren->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($ren->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($ren->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($ren->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>"; 
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($ren->CHR_NO_BUDGET) . "' id='input_notes' value='". $ren->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_ren = $tot_plan_ren + $ren->MON_PLAN_BLN;
                                            $tot_ori_limit_ren = $tot_ori_limit_ren + ($ren->MON_PLAN_BLN*0.7);
                                            $tot_limit_ren = $tot_limit_ren + $ren->MON_LIMIT_BLN;
                                            $tot_real_ren = $tot_real_ren + $ren->MON_REAL_BLN;
                                            $tot_prop_ren = $tot_prop_ren + $ren->MON_PROPOSE_BLN;
                                            $no_ren++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ren" value="<?php echo number_format($tot_prop_ren,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END RENTA ===================================== -->
<!-- ======================= RNDEV ========================================= -->
                            <?php  
                                }
                                $tot_plan_rnd = 0;
                                $tot_ori_limit_rnd = 0;
                                $tot_limit_rnd = 0;
                                $tot_real_rnd = 0;
                                $tot_prop_rnd = 0;
                                        
                                if($propose_rndev != NULL){
                            ?>
                            <table id="table_rnd" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>RNDEV (Research Development)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($rnd->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rnd->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rnd->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($rnd->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rnd->CHR_NO_BUDGET ."' class='prop_amo_rnd' value='" . number_format($rnd->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($rnd->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($rnd->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($rnd->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $rnd->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rnd->CHR_NO_BUDGET) . "' id='check_". $rnd->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_rnd();'></td>";
                                            
                                            if($rnd->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $rnd->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($rnd->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($rnd->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($rnd->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($rnd->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($rnd->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>"; 
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_notes' value='". $rnd->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_rnd = $tot_plan_rnd + $rnd->MON_PLAN_BLN;
                                            $tot_ori_limit_rnd = $tot_ori_limit_rnd + ($rnd->MON_PLAN_BLN*0.7);
                                            $tot_limit_rnd = $tot_limit_rnd + $rnd->MON_LIMIT_BLN;
                                            $tot_real_rnd = $tot_real_rnd + $rnd->MON_REAL_BLN;
                                            $tot_prop_rnd = $tot_prop_rnd + $rnd->MON_PROPOSE_BLN;
                                            $no_rnd++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rnd" value="<?php echo number_format($tot_prop_rnd,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END RNDEV ===================================== -->
<!-- ======================= DONAT ========================================= -->
                            <?php  
                                }
                                $tot_plan_don = 0;
                                $tot_ori_limit_don = 0;
                                $tot_limit_don = 0;
                                $tot_real_don = 0;
                                $tot_prop_don = 0;
                                        
                                if($propose_donat != NULL){
                            ?>
                            <table id="table_don" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>DONAT (Donation)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
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
                                            echo "<td align='right'>" . number_format(($don->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($don->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($don->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($don->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($don->CHR_NO_BUDGET) . "' id='input_prop_amo_". $don->CHR_NO_BUDGET ."' class='prop_amo_don' value='" . number_format($don->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($don->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($don->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($don->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $don->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($don->CHR_NO_BUDGET) . "' id='check_". $don->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_don();'></td>";
                                            
                                            if($don->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $don->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($don->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($don->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($don->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($don->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($don->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($don->CHR_NO_BUDGET) . "' id='input_notes' value='". $don->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_don = $tot_plan_don + $don->MON_PLAN_BLN;
                                            $tot_ori_limit_don = $tot_ori_limit_don + ($don->MON_PLAN_BLN*0.7);
                                            $tot_limit_don = $tot_limit_don + $don->MON_LIMIT_BLN;
                                            $tot_real_don = $tot_real_don + $don->MON_REAL_BLN;
                                            $tot_prop_don = $tot_prop_don + $prop_don;
                                            $no_don++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_don,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_don,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_don,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_don,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_don" value="<?php echo number_format($tot_prop_don,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END DONAT ===================================== -->
<!-- ======================= ENTER ========================================= -->
                            <?php  
                                }
                                $tot_plan_ent = 0;
                                $tot_ori_limit_ent = 0;
                                $tot_limit_ent = 0;
                                $tot_real_ent = 0;
                                $tot_prop_ent = 0;
                                        
                                if($propose_enter != NULL){
                            ?>
                            <table id="table_ent" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="14" style="font-size: 14px; background-color: whitesmoke;"><strong>ENTER (Entertainment)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/> This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Remark</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        $no_ent = 1;
                                        foreach ($propose_enter as $ent) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no_ent . "</td>";
                                            echo "<td align='left'>" . $ent->CHR_NO_BUDGET . "</td>";
                                            echo "<td align='left'>" . substr($ent->CHR_BUDGET_DESC,0,25) . "</td>";
                                            echo "<td align='right'>" . number_format($ent->MON_PLAN_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format(($ent->MON_PLAN_BLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ent->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ent->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            //==== FLAG PROPOSED ===============
                                            $state = '';
                                            $style_input = '';
                                            if($ent->CHR_FLG_DELETE == '0'){
                                                $state = ' checked';
                                                $style_input = '';
                                            } else {
                                                $state = '';
                                                $style_input = 'style="background-color:grey;" readonly';
                                            }
                                            
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ent->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ent->CHR_NO_BUDGET ."' class='prop_amo_ent' value='" . number_format($ent->MON_PROPOSE_BLN,0,',','.') . "' ". $style_input ." readonly></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($ent->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($ent->CHR_NO_BUDGET) ."' disabled>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        if($ent->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $ent->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($ent->CHR_NO_BUDGET) . "' id='check_". $ent->CHR_NO_BUDGET ."' value='1' ". $state ." onchange='disableBudget_ent();'></td>";
                                            
                                            if($ent->CHR_NOTES != NULL){
                                                echo "<td align='center'>". $ent->CHR_NOTES ."</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'>";
                                                if($ent->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($ent->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($ent->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($ent->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($ent->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'><input type='text' name='note_" . trim($ent->CHR_NO_BUDGET) . "' id='input_notes' value='". $ent->CHR_REMARK ."'></td>";
                                            echo "</tr>";
                                            
                                            $tot_plan_ent = $tot_plan_ent + $ent->MON_PLAN_BLN;
                                            $tot_ori_limit_ent = $tot_ori_limit_ent + ($ent->MON_PLAN_BLN*0.7);
                                            $tot_limit_ent = $tot_limit_ent + $ent->MON_LIMIT_BLN;
                                            $tot_real_ent = $tot_real_ent + $ent->MON_REAL_BLN;
                                            $tot_prop_ent = $tot_prop_ent + $prop_ent;
                                            $no_ent++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ent,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_ent,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ent,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ent,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ent" value="<?php echo number_format($tot_prop_ent,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END DONAT ===================================== -->
                            <?php } ?>
                        </div>
                        <div style="max-width: 900px;">
                            <table style="font-size: 12px;" id="table_summary" class="table table-condensed display" cellspacing="0" width="100%">
                                <tr>
                                    <td colspan="9" align="center" style="font-size: 14px; background-color: whitesmoke;"><strong>SUMMARY TOTAL PROPOSED BUDGET - <?php echo strtoupper(date("F", mktime(null, null, null, $month))) . ' ' . substr($year_month,0,4); ?></strong></td>
                                </tr>
                                <tr>
                                    <td align="center"><strong>Budget Type</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit (70%)</strong></td>
                                        <td align="center"><strong>Proposed</strong></td>
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>New Propose</strong></td>
                                        <td align="center"><strong>Total Proposed</strong></td>
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Notes</strong></td>
                                </tr>
                                <?php
//========================== SUMMARY BUDGET CAPEX ============================//
                                    $status_over = '';
                                    $tot_sum_plan_cpx = 0;
                                    $tot_sum_ori_limit_cpx = 0;
                                    $tot_sum_limit_cpx = 0;
                                    $tot_sum_real_cpx = 0;
                                    $tot_sum_next_limit_cpx = 0;
                                    if($propose_capex != NULL){                                        
                                        echo "<tr>";
                                        // if($role == '4'){
                                            echo "<td>CAPEX (". ($no_cpx-1) .") in <strong>1FY</strong></td>";
                                        // } else {
                                        //    echo "<td>CAPEX (". ($no_cpx-1) .")</td>";
                                        // }
                                        
                                        echo "<td align='right'>" . number_format($ori_capex->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_capex->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_capex->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_capex->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_cpx' value='" . number_format($tot_prop_cpx,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_cpx' value='" . number_format(($tot_prop_cpx + $ori_capex->LBLN),0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_cpx + $ori_capex->LBLN) <= ($ori_capex->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_cpx'>OK</button>";
                                            } else if(($ori_capex->PBLN * 0.7) < ($tot_prop_cpx + $ori_capex->LBLN) && ($tot_prop_cpx + $ori_capex->LBLN) <= $ori_capex->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_cpx'>OL</button>";
                                            } else {
                                                $status_over .= 'CAPEX ';
                                                echo "<button type='button' class='btn btn-danger' id='over_cpx'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_cpx = $this->db->query("SELECT CHR_NOTES_CAPEX FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_cpx = '';
                                        if($get_notes_cpx != NULL){
                                            $notes_cpx = $get_notes_cpx->CHR_NOTES_CAPEX;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_capex' value='". $notes_cpx ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan_cpx = $tot_sum_plan_cpx + $ori_capex->PBLN;
                                        $tot_sum_ori_limit_cpx = $tot_sum_ori_limit_cpx + ($ori_capex->PBLN * 0.7);
                                        $tot_sum_limit_cpx = $tot_sum_limit_cpx + $ori_capex->LBLN;
                                        $tot_sum_real_cpx = $tot_sum_real_cpx + $ori_capex->OBLN;
                                        $tot_sum_next_limit_cpx = $tot_sum_next_limit_cpx + $tot_prop_cpx + $ori_capex->LBLN;
                                    }
                                    ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td align="center"><strong>TOTAL CAPEX</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_plan_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_ori_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_real_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type='text' id="tot_prop_amo" class="tot_prop_amo_cpx" name="summary_prop_cpx" value="<?php echo number_format($tot_prop_cpx,0,',','.');?>" readonly></strong></td>
                                        <td align="right"><strong><input type='text' id="tot_next_prop_amo" class="tot_next_prop_amo_cpx" name="summary_next_prop_cpx" value="<?php echo number_format($tot_sum_next_limit_cpx,0,',','.');?>" readonly></strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                <?php
//========================== SUMMARY BUDGET EXPENSE ==========================//
                                    $tot_sum_plan = 0;
                                    $tot_sum_ori_limit = 0;
                                    $tot_sum_limit = 0;
                                    $tot_sum_real = 0;
                                    $tot_sum_next_limit = 0;
                                    if($propose_repma != NULL){
                                        echo "<tr>";
                                        echo "<td>REPMA (". ($no_rmb-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_repma->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_repma->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_repma->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_repma->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rmb' value='" . number_format($tot_prop_rmb,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_rmb' value='" . number_format(($tot_prop_rmb + $ori_repma->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_rmb + $ori_repma->LBLN) <= ($ori_repma->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_rmb'>OK</button>";
                                            } else if(($ori_repma->PBLN * 0.7) < ($tot_prop_rmb + $ori_repma->LBLN) && ($tot_prop_rmb + $ori_repma->LBLN) <= $ori_repma->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_rmb'>OL</button>";
                                            } else {
                                                $status_over .= 'REPMA ';
                                                echo "<button type='button' class='btn btn-danger' id='over_rmb'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_rmb = $this->db->query("SELECT CHR_NOTES_REPMA FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_rmb = '';
                                        if($get_notes_rmb != NULL){
                                            $notes_rmb = $get_notes_rmb->CHR_NOTES_REPMA;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_repma' value='". $notes_rmb ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_repma->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_repma->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_repma->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_repma->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_rmb + $ori_repma->LBLN;
                                    }
                                    if($propose_right != NULL){
                                        echo "<tr>";
                                        echo "<td>RIGHT (". ($no_rig-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_right->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_right->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_right->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_right->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rig' value='" . number_format($tot_prop_rig,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_rig' value='" . number_format(($tot_prop_rig + $ori_right->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_rig + $ori_right->LBLN) <= ($ori_right->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_rig'>OK</button>";
                                            } else if(($ori_right->PBLN * 0.7) < ($tot_prop_rig + $ori_right->LBLN) && ($tot_prop_rig + $ori_right->LBLN) <= $ori_right->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_rig'>OL</button>";
                                            } else {
                                                $status_over .= 'RIGHT ';
                                                echo "<button type='button' class='btn btn-danger' id='over_rig'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_rig = $this->db->query("SELECT CHR_NOTES_RIGHT FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_rig = '';
                                        if($get_notes_rig != NULL){
                                            $notes_rig = $get_notes_rig->CHR_NOTES_RIGHT;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_right' value='". $notes_rig ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_right->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_right->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_right->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_right->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_rig + $ori_right->LBLN;
                                    }
                                    if($propose_tooeq != NULL){
                                        echo "<tr>";
                                        echo "<td>TOOEQ (". ($no_teq-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_tooeq->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_tooeq->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_tooeq->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_tooeq->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_teq' value='" . number_format($tot_prop_teq,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_teq' value='" . number_format(($tot_prop_teq + $ori_tooeq->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_teq + $ori_tooeq->LBLN) <= ($ori_tooeq->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_teq'>OK</button>";
                                            } else if(($ori_tooeq->PBLN * 0.7) < ($tot_prop_teq + $ori_tooeq->LBLN) && ($tot_prop_teq + $ori_tooeq->LBLN) <= $ori_tooeq->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_teq'>OL</button>";
                                            } else {
                                                $status_over .= 'TOOEQ ';
                                                echo "<button type='button' class='btn btn-danger' id='over_teq'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_teq = $this->db->query("SELECT CHR_NOTES_TOOEQ FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_teq = '';
                                        if($get_notes_teq != NULL){
                                            $notes_teq = $get_notes_teq->CHR_NOTES_TOOEQ;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_tooeq' value='". $notes_teq ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_tooeq->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_tooeq->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_tooeq->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_tooeq->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_teq + $ori_tooeq->LBLN;
                                    }
                                    if($propose_offeq != NULL){
                                        echo "<tr>";
                                        echo "<td>OFFEQ (". ($no_off-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_offeq->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_offeq->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_offeq->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_offeq->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_off' value='" . number_format($tot_prop_off,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_off' value='" . number_format(($tot_prop_off + $ori_offeq->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_off + $ori_offeq->LBLN) <= ($ori_offeq->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_off'>OK</button>";
                                            } else if(($ori_offeq->PBLN * 0.7) < ($tot_prop_off + $ori_offeq->LBLN) && ($tot_prop_off + $ori_offeq->LBLN) <= $ori_offeq->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_off'>OL</button>";
                                            } else {
                                                $status_over .= 'OFFEQ ';
                                                echo "<button type='button' class='btn btn-danger' id='over_off'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_off = $this->db->query("SELECT CHR_NOTES_OFFEQ FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_off = '';
                                        if($get_notes_off != NULL){
                                            $notes_off = $get_notes_off->CHR_NOTES_OFFEQ;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_offeq' value='". $notes_off ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_offeq->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_offeq->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_offeq->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_offeq->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_off + $ori_offeq->LBLN;
                                    }
                                    if($propose_trial != NULL){
                                        echo "<tr>";
                                        echo "<td>TRIAL (". ($no_tri-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_trial->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_trial->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_trial->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_trial->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_tri' value='" . number_format($tot_prop_tri,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_tri' value='" . number_format(($tot_prop_tri + $ori_trial->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_tri + $ori_trial->LBLN) <= ($ori_trial->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_tri'>OK</button>";
                                            } else if(($ori_trial->PBLN * 0.7) < ($tot_prop_tri + $ori_trial->LBLN) && ($tot_prop_tri + $ori_trial->LBLN) <= $ori_trial->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_tri'>OL</button>";
                                            } else {
                                                $status_over .= 'TRIAL ';
                                                echo "<button type='button' class='btn btn-danger' id='over_tri'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_tri = $this->db->query("SELECT CHR_NOTES_TRIAL FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_tri = '';
                                        if($get_notes_tri != NULL){
                                            $notes_tri = $get_notes_tri->CHR_NOTES_TRIAL;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_trial' value='". $notes_tri ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_trial->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_trial->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_trial->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_trial->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_tri + $ori_trial->LBLN;
                                    }
                                    if($propose_empwa != NULL){
                                        echo "<tr>";
                                        echo "<td>EMPWA (". ($no_emp-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_empwa->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_empwa->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_empwa->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_empwa->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_emp' value='" . number_format($tot_prop_emp,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_emp' value='" . number_format(($tot_prop_emp + $ori_empwa->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_emp + $ori_empwa->LBLN) <= ($ori_empwa->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_emp'>OK</button>";
                                            } else if(($ori_empwa->PBLN * 0.7) < ($tot_prop_emp + $ori_empwa->LBLN) && ($tot_prop_emp + $ori_empwa->LBLN) <= $ori_empwa->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_emp'>OL</button>";
                                            } else {
                                                $status_over .= 'EMPWA ';
                                                echo "<button type='button' class='btn btn-danger' id='over_emp'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_emp = $this->db->query("SELECT CHR_NOTES_EMPWA FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_emp = '';
                                        if($get_notes_emp != NULL){
                                            $notes_emp = $get_notes_emp->CHR_NOTES_EMPWA;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_empwa' value='". $notes_emp ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_empwa->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_empwa->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_empwa->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_empwa->OBLN; 
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_emp + $ori_empwa->LBLN;
                                    }
                                    if($propose_engfe != NULL){
                                        echo "<tr>";
                                        echo "<td>ENGFE (". ($no_eng-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_engfe->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_engfe->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_engfe->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_engfe->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_eng' value='" . number_format($tot_prop_eng,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_eng' value='" . number_format(($tot_prop_eng + $ori_engfe->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_eng + $ori_engfe->LBLN) <= ($ori_engfe->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_eng'>OK</button>";
                                            } else if(($ori_engfe->PBLN * 0.7) < ($tot_prop_eng + $ori_engfe->LBLN) && ($tot_prop_eng + $ori_engfe->LBLN) <= $ori_engfe->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_eng'>OL</button>";
                                            } else {
                                                $status_over .= 'ENGFE ';
                                                echo "<button type='button' class='btn btn-danger' id='over_eng'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_eng = $this->db->query("SELECT CHR_NOTES_ENGFE FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_eng = '';
                                        if($get_notes_eng != NULL){
                                            $notes_eng = $get_notes_eng->CHR_NOTES_ENGFE;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_engfe' value='". $notes_eng ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_engfe->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_engfe->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_engfe->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_engfe->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_eng + $ori_engfe->LBLN;
                                    }
                                    if($propose_itexp != NULL){
                                        echo "<tr>";
                                        echo "<td>ITEXP (". ($no_ite-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_itexp->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_itexp->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_itexp->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_itexp->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ite' value='" . number_format($tot_prop_ite,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_ite' value='" . number_format(($tot_prop_ite + $ori_itexp->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_ite + $ori_itexp->LBLN) <= ($ori_itexp->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_ite'>OK</button>";
                                            } else if(($ori_itexp->PBLN * 0.7) < ($tot_prop_ite + $ori_itexp->LBLN) && ($tot_prop_ite + $ori_itexp->LBLN) <= $ori_itexp->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_ite'>OL</button>";
                                            } else {
                                                $status_over .= 'ITEXP ';
                                                echo "<button type='button' class='btn btn-danger' id='over_ite'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_ite = $this->db->query("SELECT CHR_NOTES_ITEXP FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_ite = '';
                                        if($get_notes_ite != NULL){
                                            $notes_ite = $get_notes_ite->CHR_NOTES_ITEXP;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_itexp' value='". $notes_ite ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_itexp->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_itexp->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_itexp->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_itexp->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_ite + $ori_itexp->LBLN;
                                    }
                                    if($propose_renta != NULL){
                                        echo "<tr>";
                                        echo "<td>RENTA (". ($no_ren-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_renta->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_renta->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_renta->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_renta->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ren' value='" . number_format($tot_prop_ren,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_ren' value='" . number_format(($tot_prop_ren + $ori_renta->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_ren + $ori_renta->LBLN) <= ($ori_renta->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_ren'>OK</button>";
                                            } else if(($ori_renta->PBLN * 0.7) < ($tot_prop_ren + $ori_renta->LBLN) && ($tot_prop_ren + $ori_renta->LBLN) <= $ori_renta->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_ren'>OL</button>";
                                            } else {
                                                $status_over .= 'RENTA ';
                                                echo "<button type='button' class='btn btn-danger' id='over_ren'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_ren = $this->db->query("SELECT CHR_NOTES_RENTA FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_ren = '';
                                        if($get_notes_ren != NULL){
                                            $notes_ren = $get_notes_ren->CHR_NOTES_RENTA;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_renta' value='". $notes_ren ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_renta->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_renta->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_renta->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_renta->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_ren + $ori_renta->LBLN;
                                    }
                                    if($propose_rndev != NULL){
                                        echo "<tr>";
                                        echo "<td>RNDEV (". ($no_rnd-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_rndev->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_rndev->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_rndev->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_rndev->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rnd' value='" . number_format($tot_prop_rnd,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_rnd' value='" . number_format(($tot_prop_rnd + $ori_rndev->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_rnd + $ori_rndev->LBLN) <= ($ori_rndev->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_rnd'>OK</button>";
                                            } else if(($ori_rndev->PBLN * 0.7) < ($tot_prop_rnd + $ori_rndev->LBLN) && ($tot_prop_rnd + $ori_rndev->LBLN) <= $ori_rndev->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_rnd'>OL</button>";
                                            } else {
                                                $status_over .= 'RNDEV ';
                                                echo "<button type='button' class='btn btn-danger' id='over_rnd'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_rnd = $this->db->query("SELECT CHR_NOTES_RNDEV FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_rnd = '';
                                        if($get_notes_rnd != NULL){
                                            $notes_rnd = $get_notes_rnd->CHR_NOTES_RNDEV;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_rndev' value='". $notes_rnd ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_rndev->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_rndev->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_rndev->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_rndev->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_rnd + $ori_rndev->LBLN;
                                    }
                                    if($propose_donat != NULL){
                                        echo "<tr>";
                                        echo "<td>DONAT (". ($no_don-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_donat->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_donat->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_donat->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_donat->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_don' value='" . number_format($tot_prop_don,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_don' value='" . number_format(($tot_prop_don + $ori_donat->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_don + $ori_donat->LBLN) <= ($ori_donat->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_don'>OK</button>";
                                            } else if(($ori_donat->PBLN * 0.7) < ($tot_prop_don + $ori_donat->LBLN) && ($tot_prop_don + $ori_donat->LBLN) <= $ori_donat->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_don'>OL</button>";
                                            } else {
                                                $status_over .= 'DONAT ';
                                                echo "<button type='button' class='btn btn-danger' id='over_don'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_don = $this->db->query("SELECT CHR_NOTES_DONAT FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_don = '';
                                        if($get_notes_don != NULL){
                                            $notes_don = $get_notes_don->CHR_NOTES_DONAT;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_donat' value='". $notes_don ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_donat->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_donat->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_donat->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_donat->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_don + $ori_donat->LBLN;
                                    }
                                    if($propose_enter != NULL){
                                        echo "<tr>";
                                        echo "<td>ENTER (". ($no_ent-1) .")</td>";
                                        echo "<td align='right'>" . number_format($ori_enter->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_enter->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_enter->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_enter->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ent' value='" . number_format($tot_prop_ent,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='right'><strong><input type='text' id='tot_next_prop_amo' class='tot_next_prop_amo_ent' value='" . number_format(($tot_prop_ent + $ori_enter->LBLN),0,',','.') . "' readonly></strong></td>";
                                        echo "<td align='center'>";
                                            if(($tot_prop_ent + $ori_enter->LBLN) <= ($ori_enter->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_ent'>OK</button>";
                                            } else if(($ori_enter->PBLN * 0.7) < ($tot_prop_ent + $ori_enter->LBLN) && ($tot_prop_ent + $ori_enter->LBLN) <= $ori_enter->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_ent'>OL</button>";
                                            } else {
                                                $status_over .= 'DONAT ';
                                                echo "<button type='button' class='btn btn-danger' id='over_ent'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_ent = $this->db->query("SELECT CHR_NOTES_ENTER FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_ent = '';
                                        if($get_notes_ent != NULL){
                                            $notes_ent = $get_notes_ent->CHR_NOTES_DONAT;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_enter' value='". $notes_ent ."' readonly></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_enter->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_enter->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_enter->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_enter->OBLN;
                                        $tot_sum_next_limit = $tot_sum_next_limit + $tot_prop_ent + $ori_enter->LBLN;
                                    }
                                ?>
                                <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                    <td align="center"><strong>TOTAL EXPENSE</strong></td>
                                    <?php                                         
                                        $tot_sum_prop = $tot_prop_rmb + $tot_prop_rig + $tot_prop_teq + $tot_prop_off + $tot_prop_tri + 
                                                        $tot_prop_emp + $tot_prop_eng + $tot_prop_ren + $tot_prop_rnd + $tot_prop_ite +
                                                        $tot_prop_don + $tot_prop_ent;
                                    ?>
                                    <td align="right"><strong><?php echo number_format($tot_sum_plan,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format($tot_sum_ori_limit,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format($tot_sum_limit,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format($tot_sum_real,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><input type='text' id="tot_all_prop_amo" class="sum_all_prop_amo" name="summary_all_prop" value="<?php echo number_format($tot_sum_prop,0,',','.');?>" readonly></strong></td>
                                    <td align="right"><strong><input type='text' id="tot_next_all_prop_amo" class="sum_next_all_prop_amo" name="summary_next_all_prop" value="<?php echo number_format($tot_sum_next_limit,0,',','.');?>" readonly></strong></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                    <td align="center"><strong>TOTAL ALL</strong></td>
                                    <?php                                         
                                        $tot_sum_all_plan = $tot_sum_plan_cpx + $tot_sum_plan;
                                        $tot_sum_all_ori_lim = $tot_sum_ori_limit_cpx + $tot_sum_ori_limit;
                                        $tot_sum_all_lim = $tot_sum_limit_cpx + $tot_sum_limit;
                                        $tot_sum_all_real = $tot_sum_real_cpx + $tot_sum_real;
                                        $tot_sum_all_prop = $tot_prop_cpx + $tot_sum_prop;
                                        $tot_sum_all_next_lim = $tot_sum_next_limit_cpx + $tot_sum_next_limit;
                                        
                                    ?>
                                    <td align="right"><strong><?php echo number_format($tot_sum_all_plan,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format($tot_sum_all_ori_lim,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format($tot_sum_all_lim,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format($tot_sum_all_real,0,',','.'); ?></strong></td>
                                    <td align="right"><strong><input type='text' id="tot_all_prop_amo" class="sum_all_prop_amo" name="summary_all_prop_budget" value="<?php echo number_format($tot_sum_all_prop,0,',','.');?>" readonly></strong></td>
                                    <td align="right"><strong><input type='text' id="tot_next_all_prop_amo" class="sum_next_all_prop_amo" name="summary_next_all_prop_budget" value="<?php echo number_format($tot_sum_all_next_lim,0,',','.');?>" readonly></strong></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div> 
                        <div align="left">
                            <table width="100%">
                                <tr style="font-weight: bold;">
                                    <td width="5%" align="center">
                                        <button type='button' class='btn btn-success' id='over_don'>OK</button>
                                    </td>
                                    <td width="1%" align="center">:</td>
                                    <td width="5%">UNDERBUDGET</td>
                                    <td width="1%"></td>
                                    <td width="5%" align="center">
                                        <button type='button' class='btn btn-warning' id='over_don'>OL</button>
                                    </td>
                                    <td width="1%" align="center">:</td>
                                    <td width="5%">OVERLIMIT</td>
                                    <td width="1%"></td>
                                    <td width="5%" align="center">
                                        <button type='button' class='btn btn-danger' id='over_don'>OB</button>
                                    </td>
                                    <td width="1%" align="center">:</td>
                                    <td width="5%">OVERBUDGET</td>
                                    <td width="65%"></td>
                                </tr>
                            </table>
                        </div>
                        <div align="right">
                            <input type="hidden" name="CHR_NO_PROPOSE" value="<?php echo $no_propose; ?>">
                            <?php 
                                echo anchor('budget/new_propose_budget_c/manage_approval_monthly_budget/0/' . $fiscal_start . '/' . $year_month . '/' . trim($kode_dept), 'Back', 'class="btn btn-default"');
                                
                                if($role == '1' || $role == '2'){
                            ?>
                                <button type="submit" name="approve" value="gm" class="btn btn-primary" <?php if($switch > '1'){ echo "disabled"; } ?> ><i class="fa fa-check"></i> Approve GM</button>
                                <button type="submit" name="approve" value="bod" class="btn btn-primary" <?php if($switch > '2'){ echo "disabled"; } ?> ><i class="fa fa-check"></i> Approve BOD</button>
                            <?php
                                } else {
                                    $state_btn = '';
                                    if($role == '4'){
                                        if($switch >= 2){
                                            $state_btn = 'disabled';
                                        }
                                    } else if($role == '3'){
                                        if($switch >= 3){
                                            $state_btn = 'disabled';
                                        }
                                    }
                            ?>
                                <button type="submit" class="btn btn-primary" <?php echo $state_btn; ?> onclick="return confirmFunction()"><i class="fa fa-check"></i> Approved</button>
                            <?php } ?>
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
                        <iframe frameBorder="0" width='100%' height='660px' src="<?php echo site_url("budget/new_propose_budget_c/view_detail_budget_per_month/" . $fiscal_start . "/" . $kode_dept . "/CAPEX"); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {

        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
    
    function confirmFunction() {
        if (confirm("Are You sure to APPROVED this number propose <?php echo $no_propose; ?>? \n\Budget type status OVERBUDGET (OB) : <?php echo $status_over; ?>")){
           yourformelement.submit(); 
        } else {
           return false;
        }
    }
    
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
        
//        var new_all_amo = old_all_amo + amo;
//        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
//        $(".sum_all_prop_amo").val(all_amo_money);
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
    
    function disableBudget_rig(){
        var bdgt = <?php echo json_encode($propose_right); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_rig')[0].value.replace(/[.]/g,"");
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
            $(".tot_prop_amo_rig").val(amo_money);
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
    
    function disableBudget_ent(){
        var bdgt = <?php echo json_encode($propose_enter); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_ent')[0].value.replace(/[.]/g,"");
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
            $(".tot_prop_amo_ent").val(amo_money);
            i++;
        });
        
        var new_all_amo = old_all_amo + amo;
        var all_amo_money = new_all_amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(all_amo_money);
    }
</script>
