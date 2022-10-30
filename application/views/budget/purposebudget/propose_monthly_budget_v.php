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
    
    .amo_cpx {
        font-size: 11px;
        width: 90px;
        height: 23px;
        text-align: right;
    }
    
    .prop_amo_cpx {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_rmb {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_teq {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_off {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_emp {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_tri {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_eng {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_ren {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_ite {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_rnd {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    .prop_amo_don {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    
    #tot_prop_amo {
        font-size: 11px;
        width: 100px;
        height: 23px;
        background-color: paleturquoise;
        text-align: right;
    }
    
    #tot_all_prop_amo {
        font-size: 11px;
        width: 100px;
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
    
    #budget_no_unb {
        font-size: 13px;
        font-weight: bold;
        width: 220px;
        height: 30px;
    }
    
    #input_amo {
        font-size: 13px;
        font-weight: bold;
        width: 170px;
        height: 30px;
        text-align: right;
    }
    
    #input_qty {
        font-size: 13px;
        font-weight: bold;
        width: 80px;
        height: 30px;
        text-align: right;
    }
    
    #textarea {
        width: 380px;
        height: 50px;
    }
    
    #note {
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
        <?php if($num_budget == 0){ ?>
            <div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>No OPEN budget for this month.</strong> All budget already proposed, wait until approval process is done </div >
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>PROPOSE BUDGET FOR <?php echo strtoupper(date("F", mktime(null, null, null, $month))) . ' ' . substr($year_month,0,4); ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/propose_budget_c/export_propose_unbudget', 'class="form-horizontal"'); ?>
                                <input name="CHR_NO_PROPOSE" value="<?php echo $no_propose; ?>" type="hidden">
                                <input name="CHR_YEAR_MONTH" value="<?php echo $year_month; ?>" type="hidden">
                                <input name="CHR_DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                <button type="submit" name="btn_submit_unb" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export UNB</button>
                            <?php echo form_close() ?>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/propose_budget_c/export_only_propose_budget', 'class="form-horizontal"'); ?>
                                <input name="CHR_NO_PROPOSE" value="<?php echo $no_propose; ?>" type="hidden">
                                <input name="CHR_YEAR_MONTH" value="<?php echo $year_month; ?>" type="hidden">
                                <input name="CHR_DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export Prop</button>
                            <?php echo form_close() ?>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/propose_budget_c/export_propose_budget', 'class="form-horizontal"'); ?>
                                <input name="CHR_NO_PROPOSE" value="<?php echo $no_propose; ?>" type="hidden">
                                <input name="CHR_YEAR_MONTH" value="<?php echo $year_month; ?>" type="hidden">
                                <input name="CHR_DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export ALL</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <form method="post" id="filter_form" action="<?php echo site_url("budget/propose_budget_c/save_proposed_budget") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                    <div class="grid-body">
                        <div class="pull">                            
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Fiscal</td>                                    
                                    <td width="20%">
                                        <select name="CHR_FISCAL" class="form-control" id="fiscal" onChange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/propose_budget/' . $data->CHR_FISCAL_YEAR_START . '/' . $year_month . '/' . $kode_dept); ?>" <?php
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
<!--                                        <select class="ddl" id="month" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <option value="<?php echo site_url('budget/propose_budget_c/propose_budget/' . $fiscal_start . '/201604/' . $kode_dept); ?>" <?php if($year_month == '201604'){ echo 'SELECTED';}?>>Apr 2016</option>
                                            <option value="<?php echo site_url('budget/propose_budget_c/propose_budget/' . $fiscal_start . '/201605/' . $kode_dept); ?>" <?php if($year_month == '201605'){ echo 'SELECTED';}?>>Mei 2016</option>
                                        </select>-->
                                        <select class="form-control" id="month" onChange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                            <?php for ($x = 0; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/propose_budget/' . $fiscal_start . '/' . date("Ym", strtotime("+$x month")) . '/' . $kode_dept); ?>" <?php
                                                if ($year_month == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>Department</td>
                                    <td>
                                        <?php if($role == '5' || $role == '39'){ ?>
                                            <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                        <?php } else { ?>
                                            <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                        <?php } ?> 
                                            <option value=""></option>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/propose_budget_c/propose_budget/' . $fiscal_start . '/' . $year_month . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
                                                if (trim($kode_dept) == trim($dept->CHR_KODE_DEPARTMENT)) {
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
                            <table style="font-size:11px;" id="table_cpx" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>CAPEX (Capital Expenditure)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($cpx->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($cpx->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($cpx->CHR_FLG_PROPOSED == '0'){
                                                if($cpx->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($cpx->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_cpx = 0;
                                            $plan_cpx = 0;
                                            $limit_cpx = 0;
                                            if($cpx->CHR_FLG_DELETE == '0'){
                                                $prop_cpx = $cpx->MON_PROPOSE_BLN;
                                                $plan_cpx = $cpx->MON_PLAN_BLN;
                                                $limit_cpx = $cpx->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $cpx->CHR_NO_BUDGET ."' value='" . number_format($cpx->MON_PROPOSE_BLN,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_prop_amo_". $cpx->CHR_NO_BUDGET ."' class='prop_amo_cpx' value='" . number_format($prop_cpx,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($cpx->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($cpx->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($cpx->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($cpx->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($cpx->CHR_NO_BUDGET) . "' id='check_" . $cpx->CHR_NO_BUDGET . "' value='1' onchange='disableBudget_cpx();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_notes' value='". $cpx->CHR_NOTES ."'></td>";
                                            
                                            if($cpx->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($cpx->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($cpx->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $cpx->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($cpx->CHR_NO_BUDGET) ."' value='". $cpx->CHR_YEAR_ACTUAL . $cpx->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_cpx = $tot_plan_cpx + $plan_cpx;
                                            $tot_limit_cpx = $tot_limit_cpx + $limit_cpx;
                                            $tot_real_cpx = $tot_real_cpx + $cpx->MON_REAL_BLN;
                                            $tot_prop_cpx = $tot_prop_cpx + $prop_cpx;
                                            $no_cpx++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_cpx" value="<?php echo number_format($tot_prop_cpx,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_rmb" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>REPMA (Repair Maintenance)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($rmb->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rmb->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($rmb->CHR_FLG_PROPOSED == '0'){
                                                if($rmb->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($rmb->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_rmb = 0;
                                            $plan_rmb = 0;
                                            $limit_rmb = 0;
                                            if($rmb->CHR_FLG_DELETE == '0'){
                                                $prop_rmb = $rmb->MON_PROPOSE_BLN;
                                                $plan_rmb = $rmb->MON_PLAN_BLN;
                                                $limit_rmb = $rmb->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $rmb->CHR_NO_BUDGET ."' value='" . number_format($rmb->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rmb->CHR_NO_BUDGET ."' class='prop_amo_rmb' value='" . number_format($prop_rmb,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($rmb->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($rmb->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($rmb->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($rmb->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                                                                        
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rmb->CHR_NO_BUDGET) . "' id='check_". $rmb->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_rmb();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_notes' value='". $rmb->CHR_NOTES ."'></td>";
                                            
                                            if($rmb->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($rmb->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($rmb->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $rmb->CHR_REMARK . "</td>";                                            
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($rmb->CHR_NO_BUDGET) ."' value='". $rmb->CHR_YEAR_ACTUAL . $rmb->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_rmb = $tot_plan_rmb + $plan_rmb;
                                            $tot_limit_rmb = $tot_limit_rmb + $limit_rmb;
                                            $tot_real_rmb = $tot_real_rmb + $rmb->MON_REAL_BLN;
                                            $tot_prop_rmb = $tot_prop_rmb + $prop_rmb;
                                            $no_rmb++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rmb" value="<?php echo number_format($tot_prop_rmb,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_teq" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>TOOEQ (Tools Equipment)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($teq->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($teq->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($teq->CHR_FLG_PROPOSED == '0'){
                                                if($teq->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($teq->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_teq = 0;
                                            $plan_teq = 0;
                                            $limit_teq = 0;
                                            if($teq->CHR_FLG_DELETE == '0'){
                                                $prop_teq = $teq->MON_PROPOSE_BLN;
                                                $plan_teq = $teq->MON_PLAN_BLN;
                                                $limit_teq = $teq->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $teq->CHR_NO_BUDGET ."' value='" . number_format($teq->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($teq->CHR_NO_BUDGET) . "' id='input_prop_amo_". $teq->CHR_NO_BUDGET ."' class='prop_amo_teq' value='" . number_format($prop_teq,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($teq->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($teq->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($teq->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($teq->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($teq->CHR_NO_BUDGET) . "' id='check_". $teq->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_teq();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($teq->CHR_NO_BUDGET) . "' id='input_notes' value='". $teq->CHR_NOTES ."'></td>";
                                            
                                            if($teq->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($teq->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($teq->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $teq->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($teq->CHR_NO_BUDGET) ."' value='". $teq->CHR_YEAR_ACTUAL . $teq->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_teq = $tot_plan_teq + $plan_teq;
                                            $tot_limit_teq = $tot_limit_teq + $limit_teq;
                                            $tot_real_teq = $tot_real_teq + $teq->MON_REAL_BLN;
                                            $tot_prop_teq = $tot_prop_teq + $prop_teq;
                                            $no_teq++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_teq" value="<?php echo number_format($tot_prop_teq,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_off" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>OFFEQ (Office Equipment)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($off->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($off->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($off->CHR_FLG_PROPOSED == '0'){
                                                if($off->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($off->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_off = 0;
                                            $plan_off = 0;
                                            $limit_off = 0;
                                            if($off->CHR_FLG_DELETE == '0'){
                                                $prop_off = $off->MON_PROPOSE_BLN;
                                                $plan_off = $off->MON_PLAN_BLN;
                                                $limit_off = $off->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $off->CHR_NO_BUDGET ."' value='" . number_format($off->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($off->CHR_NO_BUDGET) . "' id='input_prop_amo_". $off->CHR_NO_BUDGET ."' class='prop_amo_off' value='" . number_format($prop_off,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($off->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($off->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($off->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($off->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($off->CHR_NO_BUDGET) ."' id='check_". $off->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_off();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($off->CHR_NO_BUDGET) . "' id='input_notes' value='". $off->CHR_NOTES ."'></td>";
                                            
                                            if($off->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($off->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($off->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $off->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($off->CHR_NO_BUDGET) ."' value='". $off->CHR_YEAR_ACTUAL . $off->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_off = $tot_plan_off + $plan_off;
                                            $tot_limit_off = $tot_limit_off + $limit_off;
                                            $tot_real_off = $tot_real_off + $off->MON_REAL_BLN;
                                            $tot_prop_off = $tot_prop_off + $prop_off;
                                            $no_off++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_off" value="<?php echo number_format($tot_prop_off,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_tri" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>TRIAL (Trial and Inspection Cost)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($tri->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($tri->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($tri->CHR_FLG_PROPOSED == '0'){
                                                if($tri->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($tri->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_tri = 0;
                                            $plan_tri = 0;
                                            $limit_tri = 0;
                                            if($tri->CHR_FLG_DELETE == '0'){
                                                $prop_tri = $tri->MON_PROPOSE_BLN;
                                                $plan_tri = $tri->MON_PLAN_BLN;
                                                $limit_tri = $tri->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $tri->CHR_NO_BUDGET ."' value='" . number_format($tri->MON_PROPOSE_BLN,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($tri->CHR_NO_BUDGET) . "' id='input_prop_amo_". $tri->CHR_NO_BUDGET ."' class='prop_amo_tri' value='" . number_format($prop_tri,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($tri->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($tri->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($tri->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($tri->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($tri->CHR_NO_BUDGET) ."' id='check_". $tri->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_tri();' ". $state ."></td>";  
                                            echo "<td align='center'><input type='text' name='note_" . trim($tri->CHR_NO_BUDGET) . "' id='input_notes' value='". $tri->CHR_NOTES ."'></td>";
                                            
                                            if($tri->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($tri->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($tri->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $tri->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($tri->CHR_NO_BUDGET) ."' value='". $tri->CHR_YEAR_ACTUAL . $tri->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_tri = $tot_plan_tri + $plan_tri;
                                            $tot_limit_tri = $tot_limit_tri + $limit_tri;
                                            $tot_real_tri = $tot_real_tri + $tri->MON_REAL_BLN;
                                            $tot_prop_tri = $tot_prop_tri + $prop_tri;
                                            $no_tri++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_tri" value="<?php echo number_format($tot_prop_tri,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_emp" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>EMPWA (Employee Welfare)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($emp->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($emp->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($emp->CHR_FLG_PROPOSED == '0'){
                                                if($emp->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($emp->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_emp = 0;
                                            $plan_emp = 0;
                                            $limit_emp = 0;
                                            if($emp->CHR_FLG_DELETE == '0'){
                                                $prop_emp = $emp->MON_PROPOSE_BLN;
                                                $plan_emp = $emp->MON_PLAN_BLN;
                                                $limit_emp = $emp->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $emp->CHR_NO_BUDGET ."' value='" . number_format($emp->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($emp->CHR_NO_BUDGET) . "' id='input_prop_amo_". $emp->CHR_NO_BUDGET ."' class='prop_amo_emp' value='" . number_format($prop_emp,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($emp->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($emp->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($emp->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($emp->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                               echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($emp->CHR_NO_BUDGET) ."' id='check_". $emp->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_emp();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($emp->CHR_NO_BUDGET) . "' id='input_notes' value='". $emp->CHR_NOTES ."'></td>";
                                            
                                            if($emp->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($emp->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($emp->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $emp->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($emp->CHR_NO_BUDGET) ."' value='". $emp->CHR_YEAR_ACTUAL . $emp->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_emp = $tot_plan_emp + $plan_emp;
                                            $tot_limit_emp = $tot_limit_emp + $limit_emp;
                                            $tot_real_emp = $tot_real_emp + $emp->MON_REAL_BLN;
                                            $tot_prop_emp = $tot_prop_emp + $prop_emp;
                                            $no_emp++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_emp" value="<?php echo number_format($tot_prop_emp,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_eng" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>ENGFE (Engineer Fee)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($eng->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($eng->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($eng->CHR_FLG_PROPOSED == '0'){
                                                if($eng->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($eng->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_eng = 0;
                                            $plan_eng = 0;
                                            $limit_eng = 0;
                                            if($eng->CHR_FLG_DELETE == '0'){
                                                $prop_eng = $eng->MON_PROPOSE_BLN;
                                                $plan_eng = $eng->MON_PLAN_BLN;
                                                $limit_eng = $eng->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $eng->CHR_NO_BUDGET ."' value='" . number_format($eng->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($eng->CHR_NO_BUDGET) . "' id='input_prop_amo_". $eng->CHR_NO_BUDGET ."' class='prop_amo_eng' value='" . number_format($prop_eng,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($eng->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($eng->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($eng->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($eng->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($eng->CHR_NO_BUDGET) ."' id='check_". $eng->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_eng();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($eng->CHR_NO_BUDGET) . "' id='input_notes' value='". $eng->CHR_NOTES ."'></td>";
                                            
                                            if($eng->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($eng->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($eng->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $eng->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($eng->CHR_NO_BUDGET) ."' value='". $eng->CHR_YEAR_ACTUAL . $eng->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_eng = $tot_plan_eng + $plan_eng;
                                            $tot_limit_eng = $tot_limit_eng + $limit_eng;
                                            $tot_real_eng = $tot_real_eng + $eng->MON_REAL_BLN;
                                            $tot_prop_eng = $tot_prop_eng + $prop_eng;
                                            $no_eng++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_eng" value="<?php echo number_format($tot_prop_eng,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_ite" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>ITEXP (IT Expenses)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($ite->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ite->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($ite->CHR_FLG_PROPOSED == '0'){
                                                if($ite->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($ite->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_ite = 0;
                                            $plan_ite = 0;
                                            $limit_ite = 0;
                                            if($ite->CHR_FLG_DELETE == '0'){
                                                $prop_ite = $ite->MON_PROPOSE_BLN;
                                                $plan_ite = $ite->MON_PLAN_BLN;
                                                $limit_ite = $ite->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $ite->CHR_NO_BUDGET ."' value='" . number_format($ite->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ite->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ite->CHR_NO_BUDGET ."' class='prop_amo_ite' value='" . number_format($prop_ite,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($ite->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ite->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($ite->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ite->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($ite->CHR_NO_BUDGET) ."' id='check_". $ite->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_ite();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($ite->CHR_NO_BUDGET) . "' id='input_notes' value='". $ite->CHR_NOTES ."'></td>";
                                            
                                            if($ite->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($ite->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($ite->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $ite->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($ite->CHR_NO_BUDGET) ."' value='". $ite->CHR_YEAR_ACTUAL . $ite->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_ite = $tot_plan_ite + $plan_ite;
                                            $tot_limit_ite = $tot_limit_ite + $limit_ite;
                                            $tot_real_ite = $tot_real_ite + $ite->MON_REAL_BLN;
                                            $tot_prop_ite = $tot_prop_ite + $prop_ite;
                                            $no_ite++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ite" value="<?php echo number_format($tot_prop_ite,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_ren" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>RENTA (Rental Expenses)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($ren->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ren->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($ren->CHR_FLG_PROPOSED == '0'){
                                                if($ren->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($ren->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_ren = 0;
                                            $plan_ren = $ren->MON_PLAN_BLN;
                                            $limit_ren = $ren->MON_LIMIT_BLN;
                                            if($ren->CHR_FLG_DELETE == '0'){
                                                $prop_ren = $ren->MON_PROPOSE_BLN;
                                                $plan_ren = $ren->MON_PLAN_BLN;
                                                $limit_ren = $ren->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $ren->CHR_NO_BUDGET ."' value='" . number_format($ren->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ren->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ren->CHR_NO_BUDGET ."' class='prop_amo_ren' value='" . number_format($prop_ren,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($ren->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ren->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($ren->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($ren->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($ren->CHR_NO_BUDGET) ."' id='check_". $ren->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_ren();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($ren->CHR_NO_BUDGET) . "' id='input_notes' value='". $ren->CHR_NOTES ."'></td>";
                                            
                                            if($ren->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($ren->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($ren->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            echo "<td align='center'>". $ren->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($ren->CHR_NO_BUDGET) ."' value='". $ren->CHR_YEAR_ACTUAL . $ren->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_ren = $tot_plan_ren + $plan_ren;
                                            $tot_limit_ren = $tot_limit_ren + $limit_ren;
                                            $tot_real_ren = $tot_real_ren + $ren->MON_REAL_BLN;
                                            $tot_prop_ren = $tot_prop_ren + $prop_ren;
                                            $no_ren++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ren" value="<?php echo number_format($tot_prop_ren,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_rnd" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>RNDEV (Research Development)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($rnd->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rnd->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($rnd->CHR_FLG_PROPOSED == '0'){
                                                if($rnd->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($rnd->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_rnd = 0;
                                            $plan_rnd = 0;
                                            $limit_rnd = 0;
                                            if($rnd->CHR_FLG_DELETE == '0'){
                                                $prop_rnd = $rnd->MON_PROPOSE_BLN;
                                                $plan_rnd = $rnd->MON_PLAN_BLN;
                                                $limit_rnd = $rnd->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $rnd->CHR_NO_BUDGET ."' value='" . number_format($rnd->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rnd->CHR_NO_BUDGET ."' class='prop_amo_rnd' value='" . number_format($prop_rnd,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($rnd->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'></td>";
                                            }
                                            
                                            if($rnd->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($rnd->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($rnd->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($rnd->CHR_NO_BUDGET) ."' id='check_". $rnd->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_rnd();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_notes' value='". $rnd->CHR_NOTES ."'></td>";
                                            
                                            if($rnd->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($rnd->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($rnd->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $rnd->CHR_REMARK . "</td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='ym_". trim($rnd->CHR_NO_BUDGET) ."' value='". $rnd->CHR_YEAR_ACTUAL . $rnd->CHR_MONTH_ACTUAL  ."'>";
                                            $tot_plan_rnd = $tot_plan_rnd + $plan_rnd;
                                            $tot_limit_rnd = $tot_limit_rnd + $limit_rnd;
                                            $tot_real_rnd = $tot_real_rnd + $rnd->MON_REAL_BLN;
                                            $tot_prop_rnd = $tot_prop_rnd + $prop_rnd;
                                            $no_rnd++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rnd" value="<?php echo number_format($tot_prop_rnd,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_don" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr style="background-color: #002a80; color: white; font-size: 14px;">
                                        <td colspan="14"><strong>DONAT (Donation)</strong></td>
                                    </tr>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit</strong></td> 
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>Propose</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>CHA</strong></td>
                                        <td align="center"><strong>RES</strong></td>
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
                                            echo "<td align='right'>" . number_format($don->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($don->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($don->CHR_FLG_PROPOSED == '0'){
                                                if($don->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($don->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = 'readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_don = 0;
                                            $plan_don = 0;
                                            $limit_don = 0;
                                            if($don->CHR_FLG_DELETE == '0'){
                                                $prop_don = $don->MON_PROPOSE_BLN;
                                                $plan_don = $don->MON_PLAN_BLN;
                                                $limit_don = $don->MON_LIMIT_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $don->CHR_NO_BUDGET ."' value='" . number_format($don->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($don->CHR_NO_BUDGET) . "' id='input_prop_amo_". $don->CHR_NO_BUDGET ."' class='prop_amo_don' value='" . number_format($prop_don,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            if($don->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            if($don->CHR_FLG_CHANGE_AMOUNT == '1'){
                                                echo "<td align='center'><i class='fa fa-check' id='change_amo_'" . trim($don->CHR_NO_BUDGET) ."></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            if($don->CHR_FLG_RESCHEDULE == '1'){
                                                echo "<td align='center'><i class='fa fa-check'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($don->CHR_NO_BUDGET) ."' id='check_". $don->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_don();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($don->CHR_NO_BUDGET) . "' id='input_notes' value='". $don->CHR_NOTES ."'></td>";
                                            
                                            if($don->CHR_FLG_PROPOSED == '1'){
                                                echo "<td align='center'><strong>WAIT</strong></td>";
                                            } else if ($don->CHR_FLG_PROPOSED == '2'){
                                                echo "<td align='center'><strong>HOLD</strong></td>";
                                            } else if ($don->CHR_FLG_PROPOSED == '3') {
                                                echo "<td align='center'><strong>OK</strong></td>";
                                            } else {
                                                echo "<td align='center'><strong>OPEN</strong></td>";
                                            }
                                            
                                            echo "<td align='center'>". $don->CHR_REMARK . "</td>";
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
                                        <td colspan="7"></td>
                                    </tr>
                                </tbody>                                
                            </table>
                            <?php } ?>
                        </div>
                        <div align="right">
                            <?php if($num_budget != 0){
                                    if($switch != 0){
                                        echo '<input type="button" data-toggle="modal" data-target="#modalreschedule" data-placement="left" title="Reschedule" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Reschedule" disabled>&nbsp;';
                                        echo '<input type="button" data-toggle="modal" data-target="#modalunbudget" data-placement="left" title="Unbudget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Unbudget" disabled>';
                                    } else {
                                        echo '<input type="button" data-toggle="modal" data-target="#modalreschedule" data-placement="left" title="Reschedule" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Reschedule">&nbsp;';
                                        echo '<input type="button" data-toggle="modal" data-target="#modalunbudget" data-placement="left" title="Unbudget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Unbudget">';
                                    }                                
                                } else {
                                    echo '<input type="button" data-toggle="modal" data-target="#modalreschedule" data-placement="left" title="Reschedule" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Reschedule">&nbsp;';
                                    echo '<input type="button" data-toggle="modal" data-target="#modalunbudget" data-placement="left" title="Unbudget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Unbudget">';
                                }
                            ?>
                            
                        </div>                        
                        <div style="max-width: 500px;">
                            <table style="font-size:11px;" id="table_summary" class="table table-condensed display" cellspacing="0" width="100%" border="1px">
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
                            <?php 
                                echo anchor('budget/propose_budget_c/index/0/' . $fiscal_start . '/' . $year_month, 'Back', 'class="btn btn-default"');
                            ?>                            
                            <?php if($num_budget == 0) {
                                    echo '<button type="submit" name="save" class="btn btn-primary" id="propose_budget" value="save" disabled><i class="fa fa-check"></i> Save</button>&nbsp;';
                                    echo '<button type="submit" name="save" class="btn btn-primary" id="propose_budget" value="propose" disabled><i class="fa fa-send"></i> Propose</button>';
                                } else {
                                    if($switch != 0){
                                       echo '<button type="submit" name="save" class="btn btn-primary" id="propose_budget" value="save" disabled><i class="fa fa-check"></i> Save</button>&nbsp;';
                                       echo '<button type="submit" name="save" class="btn btn-primary" id="propose_budget" value="propose" disabled><i class="fa fa-send"></i> Propose</button>';   
                                    } else {
                                       echo '<button type="submit" name="save" class="btn btn-primary" id="propose_budget" value="save"><i class="fa fa-check"></i> Save</button>&nbsp;';
                                       echo '<button type="submit" name="save" class="btn btn-primary" id="propose_budget" value="propose"><i class="fa fa-send"></i> Propose</button>';  
                                    }
                                } 
                            ?>
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
        <div class="modal fade" id="modalreschedule" tabindex="-1" role="dialog" aria-labelledby="modalLabelReschedule" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:900px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalLabelReschedule"><strong>RESCHEDULE BUDGET</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <?php echo form_open('budget/propose_budget_c/add_reschedule_budget', 'class="form-horizontal" enctype="multipart/form-data"'); ?>
                            <input name="CHR_NO_PROPOSE_RES" class="form-control" required type="hidden" value="<?php echo $no_propose; ?>">
                            <input name="CHR_FIS_START_RES" class="form-control" required type="hidden" value="<?php echo $fiscal_start; ?>">
                            <input name="CHR_YM_PROPOSE_RES" class="form-control" required type="hidden" value="<?php echo $year_month; ?>">
                            <input name="CHR_DEPT_RES" class="form-control" required type="hidden" value="<?php echo trim($kode_dept); ?>">
                            <table id="filter" width="100%">
                                <tr>
                                    <td width="16%">Fiscal Year</td>
                                    <td width="24%">
                                        <select name="CHR_FISCAL_RES" class="form-control" id="fiscal_res" disabled>
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?php echo $data->CHR_FISCAL_YEAR_START; ?>" 
                                                <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="16%">Department</td>
                                    <td width="24%">
                                        <select name="CHR_DEPT" class="form-control" id="dept_res" disabled>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo trim($dept->CHR_KODE_DEPARTMENT); ?>" 
                                                <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($dept->CHR_KODE_DEPARTMENT); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Month</td>
                                    <td>
                                        <select name="CHR_MONTH_RES" class="form-control" id="month_res" onchange="getBudgetList();">
                                            <option value=""></option>
                                            <?php                                                
                                                for($i = 0; $i < 12; $i++) { 
                                            ?>
                                                <option value="<?PHP echo $all_month[$i][0]; ?>" 
                                                <?php if($year_month == $all_month[$i][0]) { echo " disabled"; } ?> > 
                                            <?php echo $all_month[$i][1]; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>Budget Type</td>
                                    <td>
                                        <select name="CHR_BUDGET_TYPE_RES" class="form-control" id="bgt_type_res" onchange="getBudgetList();">
                                            <?php foreach ($all_budget_type as $bgt) { ?>
                                                <option value="<?php echo $bgt->CHR_BUDGET_TYPE; ?>"> 
                                                <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div>&nbsp;</div>
                            <div id="list_budget_permonth" style=" overflow-y: scroll; max-height: 350px;">
                                <!--- VALUE FROM JSON --->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Add budget to list propose"><i class="fa fa-check"></i> Add to List</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalunbudget" tabindex="-1" role="dialog" aria-labelledby="modalLabelUnbudget" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalLabelUnbudget"><strong>PROPOSE UNBUDGET</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <?php echo form_open('budget/propose_budget_c/add_propose_unbudget', 'class="form-horizontal" enctype="multipart/form-data"'); ?>
                            <input name="NO_PROPOSE_UNB" class="form-control" required type="hidden" value="<?php echo $no_propose; ?>">
                            <input name="FIS_START_UNB" class="form-control" required type="hidden" value="<?php echo $fiscal_start; ?>">
                            <input name="YM_PROPOSE_UNB" class="form-control" required type="hidden" value="<?php echo $year_month; ?>">
                            <input name="DEPT_UNB" class="form-control" required type="hidden" value="<?php echo trim($kode_dept); ?>">
                            <table id="filter" width="100%">
                                <tr>
                                    <td width="24%">Fiscal Year</td>
                                    <td width="24%">
                                        <select name="CHR_FISCAL_UNB" class="form-control" id="fiscal_unb" disabled>
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?php echo $data->CHR_FISCAL_YEAR_START; ?>" 
                                                <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="4%"></td>
                                    <td width="24%">Department</td>
                                    <td width="24%">
                                        <select name="CHR_DEPT_UNB" class="form-control" id="dept_unb" disabled>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo $dept->CHR_KODE_DEPARTMENT; ?>" 
                                                <?php
                                                if (trim($kode_dept) == $dept->CHR_KODE_DEPARTMENT) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $dept->CHR_KODE_DEPARTMENT; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Month</td>
                                    <td>
                                        <select name="CHR_MONTH_UNB" class="form-control" id="month_unb" disabled>
                                            <?php                                                
                                                for($i = 0; $i < 12; $i++) { 
                                            ?>
                                                <option value="<?PHP echo $all_month[$i][0]; ?>"
                                                <?php if($all_month[$i][0] == $year_month){
                                                            echo ' SELECTED'; }
                                                ?> >
                                                <?php echo $all_month[$i][1]; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>Section</td>
                                    <td>
                                        <select name="CHR_SECTION_UNB" class="form-control" id="list_section_unb" onchange="getNoBudget();" required>
                                        <?php foreach ($list_section as $sect) { ?>
                                                <option value="<?php echo trim($sect->CHR_DETILGROUP); ?>"> 
                                                <?php echo $sect->CHR_DETILGROUP; ?> </option>
                                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Budget Type</td>
                                    <td>
                                        <select name="CHR_BUDGET_TYPE_UNB" class="form-control" id="bgt_type_unb" onchange="getCategory(value);getNoBudget();cekAmount();">
                                            <option value=""></option>
                                            <?php foreach ($all_budget_type as $bgt) { ?>
                                                <option value="<?php echo $bgt->CHR_BUDGET_TYPE; ?>"> 
                                                <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                <?php } ?>
                                        </select>                                        
                                    </td>
                                    <td></td>
                                    <td><label id="cip_label" style="display:none; font-weight: normal;">CIP / Non CIP</label></td>
                                    <td>
                                        <select name="CHR_CIP_UNB" class="form-control" id="cip" style="display:none;">
                                            <option value="0">Non CIP</option>
                                            <option value="1">CIP</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td colspan="3">
                                        <select name="CHR_CATEGORY_UNB" class="form-control" id="list_category" required>
                                            <!-- VALUE FROM JSON -->
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <select name="CHR_STATUS_UNB" class="form-control" id="status_unb" required>
                                            <option value=""></option>
                                            <option value="0">Non Project</option>
                                            <option value="1">Project</option>
                                        </select>
                                    </td>
                                    <td colspan="3">
                                        <select name="CHR_PURPOSE_UNB" class="form-control" id="project_unb" style="display:none;">
                                            <?php foreach ($list_project as $prj) { ?>
                                                <option value="<?php echo $prj->CHR_PROJECT_NUMBER; ?>"> <?php echo $prj->CHR_PROJECT_NUMBER . ' - ' . $prj->CHR_PROJECT_NAME; ?> </option>
                                            <?php } ?>
                                        </select>
                                        <select name="CHR_PROJECT_UNB" class="form-control" id="purpose_unb" style="display:none;">
                                            <?php foreach ($list_purpose as $pur) { ?>
                                                <?php $purpose_desc = preg_replace('/[^A-Za-z0-9 ]/', '', $pur->CHR_DESC_PURPOSE_BUDGET) ?>
                                                <option value="<?php echo $pur->CHR_KODE_PURPOSE_BUDGET; ?>"> <?php echo $pur->CHR_KODE_PURPOSE_BUDGET . ' - ' . $purpose_desc; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            <tr>
                                <td>Nomor Budget</td>
                                <td colspan="3">
                                    <input id="budget_no_unb" name="CHR_NO_BUDGET_UNB" style="background-color: whitesmoke" readonly>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td colspan="4">
                                    <textarea id="textarea" name="CHR_DESC_UNB"></textarea>
                                </td> 
                                <td></td>
                            </tr>
                            <tr>
                                <td>Request Budget</td>
                                <td colspan="4" align="left">
                                    <input name="REQ_AMO_UNB" onchange="cekAmount();" class="money_unb" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">  
                                    <input name="REQ_QTY_UNB" class="qty_unb" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                </td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td colspan="4">
                                    <textarea id="note" name="CHR_NOTES_UNB" required></textarea>
                                </td> 
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                   <strong><i id="alert_1" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  Amount Capex tidak boleh KURANG dari Rp 3.000.000,00</i></strong> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                   <strong><i id="alert_3" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  KETERANGAN harus minimal 5 huruf</i></strong> 
                                </td>
                            </tr>
                            </table>
                        </div>                        
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="propose_unb" class="btn btn-primary" data-placement="left" title="Add propose unbudget to list" onchange="cekAmount()"><i class="fa fa-check"></i> Add to List</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
    $('.prop_amo_cpx').mask("#.##0", {reverse: true});
    $('.prop_amo_rmb').mask("#.##0", {reverse: true});
    $('.prop_amo_teq').mask("#.##0", {reverse: true});
    $('.prop_amo_off').mask("#.##0", {reverse: true});
    $('.prop_amo_emp').mask("#.##0", {reverse: true});
    $('.prop_amo_eng').mask("#.##0", {reverse: true});
    $('.prop_amo_ite').mask("#.##0", {reverse: true});
    $('.prop_amo_ren').mask("#.##0", {reverse: true});
    $('.prop_amo_rnd').mask("#.##0", {reverse: true});
    $('.prop_amo_don').mask("#.##0", {reverse: true});
    $('.prop_amo_tri').mask("#.##0", {reverse: true});
    
    $('.money_unb').mask("#.##0", {reverse: true});
    $('.qty_unb').mask("#.##0", {reverse: true});
    $('.propose_amo').mask("#.##0", {reverse: true});
    
    function getNoBudget(value) {
        var kd_dept = document.getElementById('dept_unb').value;
        var kd_bgt = document.getElementById('bgt_type_unb').value;
        var kd_sect = document.getElementById('list_section_unb').value;
        var kd_thn = document.getElementById('fiscal_unb').value;
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/purposebudget_c/generate_no_budget'); ?>",
            data: "id_bgt=" + kd_bgt + "&id_dept=" + kd_dept + "&id_sect=" + kd_sect + "&id_thn=" + kd_thn,
            success: function(data) {
                console.log(data);
                $("#budget_no_unb").val(data);
            },
            error: function(data){
                console.log(data);
                alert('error');
            }
        });
    }
    
    function getCategory(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/propose_budget_c/get_list_category'); ?>",
            data: "type_budget=" + value,
            success: function(data) {
                console.log(data);
                $("#list_category").html(data);
            },
            error: function(data){
                console.log(data);
                alert('error');
            }
        });
    }
    
    $(document).on("change", "#bgt_type_unb", function() {
        if ($(this).val() == "CAPEX") {
            document.getElementById('cip').style.display = 'block';
            document.getElementById('cip_label').style.display = 'block';
        } else {
            document.getElementById('cip').style.display = 'none';
            document.getElementById('cip_label').style.display = 'none';
        }
    });
    
    $(document).on("change", "#status_unb", function() {
        if ($(this).val() == "1") {
            document.getElementById('project_unb').style.display = 'block';
            document.getElementById('purpose_unb').style.display = 'none';
        } else if ($(this).val() == "0"){
            document.getElementById('project_unb').style.display = 'none';
            document.getElementById('purpose_unb').style.display = 'block';
        } else {
            document.getElementById('project_unb').style.display = 'none';
            document.getElementById('purpose_unb').style.display = 'none';
        }
    });
    
    $(document).on("change", "#note", function() {
        if ($(this).val().length < 5) {
            document.getElementById('alert_3').style.display = 'block';
        } else {
            document.getElementById('alert_3').style.display = 'none';
        }
    });
    
    function cekAmount() {
        var amo = document.getElementById("input_amo").value.replace(/[.]/g,"");
        var bgt_type = document.getElementsByName("CHR_BUDGET_TYPE_UNB")[0].value;
        if(bgt_type == "CAPEX"){
            if(amo < 3000000){
                document.getElementById('alert_1').style.display = 'block';
                document.getElementById("propose_unb").disabled = true;
            } else {
                document.getElementById('alert_1').style.display = 'none';
                document.getElementById("propose_unb").disabled = false;
            }            
        } else {
            document.getElementById('alert_1').style.display = 'none';
            document.getElementById("propose_unb").disabled = false;
        }
    };
    
    $(document).on("change", ".prop_amo_cpx", function() {
        var sum_cpx = 0;
        var old_cpx_prop = document.getElementsByClassName('tot_prop_amo_cpx')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_cpx").each(function(){
            var amo_cpx = $(this).val().replace(/[.]/g,"");
            sum_cpx += +amo_cpx;            
        });
        var tot_amo_cpx = sum_cpx.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_cpx").val(tot_amo_cpx);
        
        var new_tot_all_prop = (old_tot_all_prop - old_cpx_prop) + sum_cpx;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_rmb", function() {
        var sum_rmb = 0;
        var old_rmb_prop = document.getElementsByClassName('tot_prop_amo_rmb')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_rmb").each(function(){
            var amo_rmb = $(this).val().replace(/[.]/g,"");
            sum_rmb += +amo_rmb;            
        });
        var tot_amo_rmb = sum_rmb.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_rmb").val(tot_amo_rmb);
        
        var new_tot_all_prop = (old_tot_all_prop - old_rmb_prop) + sum_rmb;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_teq", function() {
        var sum_teq = 0;
        var old_teq_prop = document.getElementsByClassName('tot_prop_amo_teq')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_teq").each(function(){
            var amo_teq = $(this).val().replace(/[.]/g,"");
            sum_teq += +amo_teq;            
        });
        var tot_amo_teq = sum_teq.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_teq").val(tot_amo_teq);
        
        var new_tot_all_prop = (old_tot_all_prop - old_teq_prop) + sum_teq;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_off", function() {
        var sum_off = 0;
        var old_off_prop = document.getElementsByClassName('tot_prop_amo_off')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_off").each(function(){
            var amo_off = $(this).val().replace(/[.]/g,"");
            sum_off += +amo_off;            
        });
        var tot_amo_off = sum_off.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_off").val(tot_amo_off);
        
        var new_tot_all_prop = (old_tot_all_prop - old_off_prop) + sum_off;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_emp", function() {
        var sum_emp = 0;
        var old_emp_prop = document.getElementsByClassName('tot_prop_amo_emp')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_emp").each(function(){
            var amo_emp = $(this).val().replace(/[.]/g,"");
            sum_emp += +amo_emp;            
        });
        var tot_amo_emp = sum_emp.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_emp").val(tot_amo_emp);
        
        var new_tot_all_prop = (old_tot_all_prop - old_emp_prop) + sum_emp;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_eng", function() {
        var sum_eng = 0;
        var old_eng_prop = document.getElementsByClassName('tot_prop_amo_eng')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_eng").each(function(){
            var amo_eng = $(this).val().replace(/[.]/g,"");
            sum_eng += +amo_eng;            
        });
        var tot_amo_eng = sum_eng.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_eng").val(tot_amo_eng);
        
        var new_tot_all_prop = (old_tot_all_prop - old_eng_prop) + sum_eng;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_ren", function() {
        var sum_ren = 0;
        var old_ren_prop = document.getElementsByClassName('tot_prop_amo_ren')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_ren").each(function(){
            var amo_ren = $(this).val().replace(/[.]/g,"");
            sum_ren += +amo_ren;            
        });
        var tot_amo_ren = sum_ren.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_ren").val(tot_amo_ren);
        
        var new_tot_all_prop = (old_tot_all_prop - old_ren_prop) + sum_ren;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_ite", function() {
        var sum_ite = 0;
        var old_ite_prop = document.getElementsByClassName('tot_prop_amo_ite')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_ite").each(function(){
            var amo_ite = $(this).val().replace(/[.]/g,"");
            sum_ite += +amo_ite;            
        });
        var tot_amo_ite = sum_ite.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_ite").val(tot_amo_ite);
        
        var new_tot_all_prop = (old_tot_all_prop - old_ite_prop) + sum_ite;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_tri", function() {
        var sum_tri = 0;
        var old_tri_prop = document.getElementsByClassName('tot_prop_amo_tri')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_tri").each(function(){
            var amo_tri = $(this).val().replace(/[.]/g,"");
            sum_tri += +amo_tri;            
        });
        var tot_amo_tri = sum_tri.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_tri").val(tot_amo_tri);
        
        var new_tot_all_prop = (old_tot_all_prop - old_tri_prop) + sum_tri;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_rnd", function() {
        var sum_rnd = 0;
        var old_rnd_prop = document.getElementsByClassName('tot_prop_amo_rnd')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_rnd").each(function(){
            var amo_rnd = $(this).val().replace(/[.]/g,"");
            sum_rnd += +amo_rnd;            
        });
        var tot_amo_rnd = sum_rnd.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_rnd").val(tot_amo_rnd);
        
        var new_tot_all_prop = (old_tot_all_prop - old_rnd_prop) + sum_rnd;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    $(document).on("change", ".prop_amo_don", function() {
        var sum_don = 0;
        var old_don_prop = document.getElementsByClassName('tot_prop_amo_don')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        $(".prop_amo_don").each(function(){
            var amo_don = $(this).val().replace(/[.]/g,"");
            sum_don += +amo_don;            
        });
        var tot_amo_don = sum_don.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".tot_prop_amo_don").val(tot_amo_don);
        
        var new_tot_all_prop = (old_tot_all_prop - old_don_prop) + sum_don;
        var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".sum_all_prop_amo").val(update_tot_all_prop);
    });
    
    function getBudgetList() {
        var kd_dept_res = document.getElementById('dept_res').value;
        var kd_bgt_res = document.getElementById('bgt_type_res').value;
        var kd_fis_res = document.getElementById('fiscal_res').value;
        var kd_month_res = document.getElementById('month_res').value;
        
        if(kd_month_res == ''){
            alert('Please select month...');
            return;
        }
        
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/propose_budget_c/get_budget_list'); ?>",
            data: "dt_dept=" + kd_dept_res + "&dt_bgt_type=" + kd_bgt_res + "&dt_fiscal=" + kd_fis_res + "&dt_month=" + kd_month_res,
            success: function(data) {
                console.log(data);
                $("#list_budget_permonth").html(data);
            },
            error: function(data){
                console.log(data);
                alert('error');
            }
        });
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
