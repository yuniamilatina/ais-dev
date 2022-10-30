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
    
    .prop_amo_rig {
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
    
    .prop_amo_ent {
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
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>PROPOSE BUDGET : <?php echo $no_propose; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/budget/new_propose_budget_c/export_excel') . "/" . str_replace('/','<',trim($no_propose)) ?>" class="btn btn-primary" data-placement="left" style="color:white;" title="Export proposed to Excel"><i class='fa fa-download'></i> Export Excel</a>
                        </div>
                    </div>
                    <form method="post" id="filter_form" action="<?php echo site_url("budget/new_propose_budget_c/save_proposed_budget") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                    <div class="grid-body">
                        <div class="pull">                            
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Fiscal</td>                                    
                                    <td width="20%">
                                        <select name="CHR_FISCAL" class="form-control" id="fiscal" onChange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/new_propose_budget_c/propose_budget/' . $data->CHR_FISCAL_YEAR_START . '/' . $year_month . '/' . $kode_dept); ?>" <?php
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
                                        <select class="form-control" id="month" onChange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                            <?php for ($x = -5; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/' . date("Ym", strtotime("+$x month")) . '/' . $kode_dept); ?>" <?php
                                                if ($year_month == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo strtoupper(date("M Y", strtotime("+$x month"))); ?> </option>
                                            <?php } ?>
                                            
                                            <!-- TEMPORARY ACTION ERROR MONTH FEBRUARI -->
<!--                                            <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/201710/' . $kode_dept); ?>" <?php if ($year_month == '201710') {echo 'selected'; } ?> >OCT 2017</option>
                                            <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/201711/' . $kode_dept); ?>" <?php if ($year_month == '201711') {echo 'selected'; } ?> >NOV 2017</option>
                                            <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/201712/' . $kode_dept); ?>" <?php if ($year_month == '201712') {echo 'selected'; } ?> >DEC 2017</option>
                                            <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/201801/' . $kode_dept); ?>" <?php if ($year_month == '201801') {echo 'selected'; } ?> >JAN 2018</option>
                                            <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/201802/' . $kode_dept); ?>" <?php if ($year_month == '201802') {echo 'selected'; } ?> >FEB 2018</option>
                                            <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/201803/' . $kode_dept); ?>" <?php if ($year_month == '201803') {echo 'selected'; } ?> >MAR 2018</option>-->
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>Department</td>
                                    <td>
                                        <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                            <option value=""></option>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/new_propose_budget_c/propose_budget/' . $fiscal_start . '/' . $year_month . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
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
                        <?php
                            if($all_list_propose == NULL){
                                    echo "<div class ='alert alert-info'><button type = 'button' class ='close' data-dismiss ='alert'>x</button><strong>No number budget to proposed. </strong> Please add number budget or add unbudget. </div >";
                            }
                        ?> 
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
                                        <td colspan="15" style="font-size: 14px; background-color: whitesmoke;"><strong>CAPEX (Capital Expenditure)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_cpx = 0;
                                            if($cpx->CHR_FLG_DELETE == '0'){
                                                $prop_cpx = $cpx->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $cpx->CHR_NO_BUDGET ."' value='" . number_format($prop_cpx,0,',','.') . "'>"; //default value
                                            echo "<td align='right'><input type='text' name='amo_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_prop_amo_". $cpx->CHR_NO_BUDGET ."' class='prop_amo_cpx' value='" . number_format($prop_cpx,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($cpx->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($cpx->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        $dis = "";
                                                        
                                                        if($mon[0] < $year_month){
                                                            $dis = 'disabled'; 
                                                        } else {
                                                            if($cpx->CHR_ESTIMATE_GR_DATE != NULL){
                                                                if($mon[0] == $cpx->CHR_ESTIMATE_GR_DATE){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            } else {
                                                                if($mon[0] == $year_month){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($cpx->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                                                                                                                   
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($cpx->CHR_NO_BUDGET) . "' id='check_" . $cpx->CHR_NO_BUDGET . "' value='1' onchange='disableBudget_cpx();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($cpx->CHR_NO_BUDGET) . "' id='input_notes_". $cpx->CHR_NO_BUDGET ."' value='". $cpx->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($cpx->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($cpx->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($cpx->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($cpx->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($cpx->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($cpx->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($cpx->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($cpx->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $cpx->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_cpx = $tot_plan_cpx + $cpx->MON_PLAN_BLN;
                                            $tot_ori_limit_cpx = $tot_ori_limit_cpx + ($cpx->MON_PLAN_BLN*0.7);
                                            $tot_limit_cpx = $tot_limit_cpx + $cpx->MON_LIMIT_BLN;
                                            $tot_real_cpx = $tot_real_cpx + $cpx->MON_REAL_BLN;
                                            $tot_prop_cpx = $tot_prop_cpx + $prop_cpx;
                                            $no_cpx++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_cpx" value="<?php echo number_format($tot_prop_cpx,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>REPMA (Repair Maintenance)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($rmb->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_rmb = 0;
                                            if($rmb->CHR_FLG_DELETE == '0'){
                                                $prop_rmb = $rmb->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $rmb->CHR_NO_BUDGET ."' value='" . number_format($prop_rmb,0,',','.') . "'>"; //default value
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rmb->CHR_NO_BUDGET ."' class='prop_amo_rmb' value='" . number_format($rmb->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($rmb->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($rmb->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        $dis = "";
                                                        
                                                        if($mon[0] < $year_month){
                                                            $dis = 'disabled'; 
                                                        } else {
                                                            if($rmb->CHR_ESTIMATE_GR_DATE != NULL){
                                                                if($mon[0] == $rmb->CHR_ESTIMATE_GR_DATE){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            } else {
                                                                if($mon[0] == $year_month){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($rmb->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rmb->CHR_NO_BUDGET) . "' id='check_". $rmb->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_rmb();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($rmb->CHR_NO_BUDGET) . "' id='input_notes_". $rmb->CHR_NO_BUDGET ."' value='". $rmb->CHR_NOTES ."' ". $required ."></td>";
                                                                                        
                                            echo "<td align='center'>";
                                                if($rmb->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($rmb->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($rmb->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($rmb->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($rmb->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($rmb->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($rmb->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($rmb->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $rmb->CHR_REMARK ."</td>";
                                                                                     
                                            echo "</tr>";
                                            $tot_plan_rmb = $tot_plan_rmb + $rmb->MON_PLAN_BLN;
                                            $tot_ori_limit_rmb = $tot_ori_limit_rmb + ($rmb->MON_PLAN_BLN*0.7);
                                            $tot_limit_rmb = $tot_limit_rmb + $rmb->MON_LIMIT_BLN;
                                            $tot_real_rmb = $tot_real_rmb + $rmb->MON_REAL_BLN;
                                            $tot_prop_rmb = $tot_prop_rmb + $prop_rmb;
                                            $no_rmb++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rmb,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rmb" value="<?php echo number_format($tot_prop_rmb,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>RIGHT (Right and Patent)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($rig->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rig->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($rig->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($rig->CHR_FLG_PROPOSED == '0'){
                                                if($rig->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($rig->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_rig = 0;
                                            if($rig->CHR_FLG_DELETE == '0'){
                                                $prop_rig = $rig->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $rig->CHR_NO_BUDGET ."' value='" . number_format($prop_rig,0,',','.') . "'>"; //default value
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rig->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rig->CHR_NO_BUDGET ."' class='prop_amo_rig' value='" . number_format($rig->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($rig->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($rig->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        $dis = "";
                                                        
                                                        if($mon[0] < $year_month){
                                                            $dis = 'disabled'; 
                                                        } else {
                                                            if($rig->CHR_ESTIMATE_GR_DATE != NULL){
                                                                if($mon[0] == $rig->CHR_ESTIMATE_GR_DATE){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            } else {
                                                                if($mon[0] == $year_month){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($rig->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($rig->CHR_NO_BUDGET) . "' id='check_". $rig->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_rig();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($rig->CHR_NO_BUDGET) . "' id='input_notes_". $rig->CHR_NO_BUDGET ."' value='". $rig->CHR_NOTES ."' ". $required ."></td>";
                                                                                        
                                            echo "<td align='center'>";
                                                if($rig->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($rig->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($rig->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($rig->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($rig->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($rig->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($rig->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($rig->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $rig->CHR_REMARK ."</td>";
                                                                                     
                                            echo "</tr>";
                                            $tot_plan_rig = $tot_plan_rig + $rig->MON_PLAN_BLN;
                                            $tot_ori_limit_rig = $tot_ori_limit_rig + ($rig->MON_PLAN_BLN*0.7);
                                            $tot_limit_rig = $tot_limit_rig + $rig->MON_LIMIT_BLN;
                                            $tot_real_rig = $tot_real_rig + $rig->MON_REAL_BLN;
                                            $tot_prop_rig = $tot_prop_rig + $prop_rig;
                                            $no_rig++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rig,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rig" value="<?php echo number_format($tot_prop_rig,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style="font-size: 14px; background-color: whitesmoke;"><strong>TOOEQ (Tools Equipment)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($teq->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_teq = 0;
                                            if($teq->CHR_FLG_DELETE == '0'){
                                                $prop_teq = $teq->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $teq->CHR_NO_BUDGET ."' value='" . number_format($prop_teq,0,',','.') . "'>"; //default value     
                                            echo "<td align='right'><input type='text' name='amo_" . trim($teq->CHR_NO_BUDGET) . "' id='input_prop_amo_". $teq->CHR_NO_BUDGET ."' class='prop_amo_teq' value='" . number_format($teq->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($teq->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($teq->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        $dis = "";
                                                        
                                                        if($mon[0] < $year_month){
                                                            $dis = 'disabled'; 
                                                        } else {
                                                            if($teq->CHR_ESTIMATE_GR_DATE != NULL){
                                                                if($mon[0] == $teq->CHR_ESTIMATE_GR_DATE){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            } else {
                                                                if($mon[0] == $year_month){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($teq->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_" . trim($teq->CHR_NO_BUDGET) . "' id='check_". $teq->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_teq();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($teq->CHR_NO_BUDGET) . "' id='input_notes_". $teq->CHR_NO_BUDGET ."' value='". $teq->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($teq->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($teq->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($teq->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($teq->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($teq->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($teq->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($teq->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($teq->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $teq->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_teq = $tot_plan_teq + $teq->MON_PLAN_BLN;
                                            $tot_ori_limit_teq = $tot_ori_limit_teq + ($teq->MON_PLAN_BLN*0.7);
                                            $tot_limit_teq = $tot_limit_teq + $teq->MON_LIMIT_BLN;
                                            $tot_real_teq = $tot_real_teq + $teq->MON_REAL_BLN;
                                            $tot_prop_teq = $tot_prop_teq + $prop_teq;
                                            $no_teq++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_teq,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_teq" value="<?php echo number_format($tot_prop_teq,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>OFFEQ (Office Equipment)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($off->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = ' readonly';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_off = 0;
                                            if($off->CHR_FLG_DELETE == '0'){
                                                $prop_off = $off->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $off->CHR_NO_BUDGET ."' value='" . number_format($off->MON_PROPOSE_BLN,0,',','.') . "'>";
                                            echo "<td align='right'><input type='text' name='amo_" . trim($off->CHR_NO_BUDGET) . "' id='input_prop_amo_". $off->CHR_NO_BUDGET ."' class='prop_amo_off' value='" . number_format($prop_off,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($off->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($off->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                        $sel = "";
                                                        $dis = "";
                                                        
                                                        if($mon[0] < $year_month){
                                                            $dis = 'disabled'; 
                                                        } else {
                                                            if($off->CHR_ESTIMATE_GR_DATE != NULL){
                                                                if($mon[0] == $off->CHR_ESTIMATE_GR_DATE){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            } else {
                                                                if($mon[0] == $year_month){ 
                                                                    $sel = 'selected';                                                            
                                                                }
                                                            }
                                                        }
                                                        echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                    }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($off->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($off->CHR_NO_BUDGET) ."' id='check_". $off->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_off();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($off->CHR_NO_BUDGET) . "' id='input_notes_". $off->CHR_NO_BUDGET ."' value='". $off->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($off->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($off->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($off->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($off->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($off->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($off->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($off->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($off->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $off->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_off = $tot_plan_off + $off->MON_PLAN_BLN;
                                            $tot_ori_limit_off = $tot_ori_limit_off + ($off->MON_PLAN_BLN*0.7);
                                            $tot_limit_off = $tot_limit_off + $off->MON_LIMIT_BLN;
                                            $tot_real_off = $tot_real_off + $off->MON_REAL_BLN;
                                            $tot_prop_off = $tot_prop_off + $prop_off;
                                            $no_off++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_off,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_off" value="<?php echo number_format($tot_prop_off,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>TRIAL (Trial and Inspection Cost)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($tri->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_tri = 0;
                                            if($tri->CHR_FLG_DELETE == '0'){
                                                $prop_tri = $tri->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $tri->CHR_NO_BUDGET ."' value='" . number_format($prop_tri,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($tri->CHR_NO_BUDGET) . "' id='input_prop_amo_". $tri->CHR_NO_BUDGET ."' class='prop_amo_tri' value='" . number_format($tri->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($tri->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($tri->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($cpx->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $tri->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($tri->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($tri->CHR_NO_BUDGET) ."' id='check_". $tri->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_tri();' ". $state ."></td>";  
                                            echo "<td align='center'><input type='text' name='note_" . trim($tri->CHR_NO_BUDGET) . "' id='input_notes_". $tri->CHR_NO_BUDGET ."' value='". $tri->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($tri->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($tri->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($tri->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($tri->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($tri->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($tri->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($tri->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($tri->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $tri->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_tri = $tot_plan_tri + $tri->MON_PLAN_BLN;
                                            $tot_ori_limit_tri = $tot_ori_limit_tri + ($tri->MON_PLAN_BLN*0.7);
                                            $tot_limit_tri = $tot_limit_tri + $tri->MON_LIMIT_BLN;
                                            $tot_real_tri = $tot_real_tri + $tri->MON_REAL_BLN;
                                            $tot_prop_tri = $tot_prop_tri + $prop_tri;
                                            $no_tri++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_tri,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_tri" value="<?php echo number_format($tot_prop_tri,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                            <table style="font-size:11px;" id="table_emp" class="table table-condensed table-hover display" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr>
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>EMPWA (Employee Welfare)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($emp->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_emp = 0;
                                            if($emp->CHR_FLG_DELETE == '0'){
                                                $prop_emp = $emp->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $emp->CHR_NO_BUDGET ."' value='" . number_format($prop_emp,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($emp->CHR_NO_BUDGET) . "' id='input_prop_amo_". $emp->CHR_NO_BUDGET ."' class='prop_amo_emp' value='" . number_format($emp->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($emp->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($emp->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($emp->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $emp->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($emp->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($emp->CHR_NO_BUDGET) ."' id='check_". $emp->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_emp();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($emp->CHR_NO_BUDGET) . "' id='input_notes_". $emp->CHR_NO_BUDGET ."' value='". $emp->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($emp->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($emp->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($emp->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($emp->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($emp->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($emp->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($emp->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($emp->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $emp->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_emp = $tot_plan_emp + $emp->MON_PLAN_BLN;
                                            $tot_ori_limit_emp = $tot_ori_limit_emp + ($emp->MON_PLAN_BLN*0.7);
                                            $tot_limit_emp = $tot_limit_emp + $emp->MON_LIMIT_BLN;
                                            $tot_real_emp = $tot_real_emp + $emp->MON_REAL_BLN;
                                            $tot_prop_emp = $tot_prop_emp + $prop_emp;
                                            $no_emp++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_emp,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_emp" value="<?php echo number_format($tot_prop_emp,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>ENGFE (Engineer Fee)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($eng->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_eng = 0;
                                            if($eng->CHR_FLG_DELETE == '0'){
                                                $prop_eng = $eng->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $eng->CHR_NO_BUDGET ."' value='" . number_format($prop_eng,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($eng->CHR_NO_BUDGET) . "' id='input_prop_amo_". $eng->CHR_NO_BUDGET ."' class='prop_amo_eng' value='" . number_format($eng->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($eng->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($eng->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($eng->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $eng->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($eng->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($eng->CHR_NO_BUDGET) ."' id='check_". $eng->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_eng();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($eng->CHR_NO_BUDGET) . "' id='input_notes_". $eng->CHR_NO_BUDGET ."' value='". $eng->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($eng->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($eng->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($eng->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($eng->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($eng->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($eng->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($eng->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($eng->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $eng->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_eng = $tot_plan_eng + $eng->MON_PLAN_BLN;
                                            $tot_ori_limit_eng = $tot_ori_limit_eng + ($eng->MON_PLAN_BLN*0.7);
                                            $tot_limit_eng = $tot_limit_eng + $eng->MON_LIMIT_BLN;
                                            $tot_real_eng = $tot_real_eng + $eng->MON_REAL_BLN;
                                            $tot_prop_eng = $tot_prop_eng + $prop_eng;
                                            $no_eng++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_eng,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_eng" value="<?php echo number_format($tot_prop_eng,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= ENG ENGFE ===================================== -->
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>ITEXP (IT Expenses)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($ite->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_ite = 0;
                                            if($ite->CHR_FLG_DELETE == '0'){
                                                $prop_ite = $ite->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $ite->CHR_NO_BUDGET ."' value='" . number_format($prop_ite,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ite->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ite->CHR_NO_BUDGET ."' class='prop_amo_ite' value='" . number_format($ite->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($ite->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($ite->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($ite->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $ite->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($ite->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($ite->CHR_NO_BUDGET) ."' id='check_". $ite->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_ite();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($ite->CHR_NO_BUDGET) . "' id='input_notes_". $ite->CHR_NO_BUDGET ."' value='". $ite->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($ite->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($ite->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($ite->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($ite->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($ite->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($ite->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($ite->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($ite->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $ite->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_ite = $tot_plan_ite + $ite->MON_PLAN_BLN;
                                            $tot_ori_limit_ite = $tot_ori_limit_ite + ($ite->MON_PLAN_BLN*0.7);
                                            $tot_limit_ite = $tot_limit_ite + $ite->MON_LIMIT_BLN;
                                            $tot_real_ite = $tot_real_ite + $ite->MON_REAL_BLN;
                                            $tot_prop_ite = $tot_prop_ite + $prop_ite;
                                            $no_ite++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ite,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ite" value="<?php echo number_format($tot_prop_ite,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>RENTA (Rental Expenses)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                            echo "<td align='right'>" . number_format(($ren->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_ren = 0;
                                            if($ren->CHR_FLG_DELETE == '0'){
                                                $prop_ren = $ren->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $ren->CHR_NO_BUDGET ."' value='" . number_format($prop_ren,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ren->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ren->CHR_NO_BUDGET ."' class='prop_amo_ren' value='" . number_format($ren->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($ren->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($ren->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($ren->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $ren->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($ren->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($ren->CHR_NO_BUDGET) ."' id='check_". $ren->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_ren();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($ren->CHR_NO_BUDGET) . "' id='input_notes_". $ren->CHR_NO_BUDGET ."' value='". $ren->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($ren->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($ren->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($ren->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($ren->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($ren->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($ren->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($ren->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($ren->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $ren->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_ren = $tot_plan_ren + $ren->MON_PLAN_BLN;
                                            $tot_ori_limit_ren = $tot_ori_limit_ren + ($ren->MON_PLAN_BLN*0.7);
                                            $tot_limit_ren = $tot_limit_ren + $ren->MON_LIMIT_BLN;
                                            $tot_real_ren = $tot_real_ren + $ren->MON_REAL_BLN;
                                            $tot_prop_ren = $tot_prop_ren + $prop_ren;
                                            $no_ren++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_ren,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_ren" value="<?php echo number_format($tot_prop_ren,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>RNDEV (Research Development)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                            echo "<td align='right'>" . number_format(($rnd->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_rnd = 0;
                                            if($rnd->CHR_FLG_DELETE == '0'){
                                                $prop_rnd = $rnd->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $rnd->CHR_NO_BUDGET ."' value='" . number_format($prop_rnd,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_prop_amo_". $rnd->CHR_NO_BUDGET ."' class='prop_amo_rnd' value='" . number_format($rnd->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($rnd->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($rnd->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($rnd->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $rnd->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($rnd->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($rnd->CHR_NO_BUDGET) ."' id='check_". $rnd->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_rnd();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($rnd->CHR_NO_BUDGET) . "' id='input_notes_". $rnd->CHR_NO_BUDGET ."' value='". $rnd->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($rnd->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($rnd->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($rnd->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($rnd->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($rnd->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($rnd->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($rnd->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($rnd->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $rnd->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_rnd = $tot_plan_rnd + $rnd->MON_PLAN_BLN;
                                            $tot_ori_limit_rnd = $tot_ori_limit_rnd + ($rnd->MON_PLAN_BLN*0.7);
                                            $tot_limit_rnd = $tot_limit_rnd + $rnd->MON_LIMIT_BLN;
                                            $tot_real_rnd = $tot_real_rnd + $rnd->MON_REAL_BLN;
                                            $tot_prop_rnd = $tot_prop_rnd + $prop_rnd;
                                            $no_rnd++;
                                    } ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_plan_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_ori_limit_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_limit_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_real_rnd,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type="text" id="tot_prop_amo" class="tot_prop_amo_rnd" value="<?php echo number_format($tot_prop_rnd,0,',','.'); ?>" readonly></strong></td>
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>DONAT (Donation)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($don->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
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
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_don = 0;
                                            if($don->CHR_FLG_DELETE == '0'){
                                                $prop_don = $don->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $don->CHR_NO_BUDGET ."' value='" . number_format($prop_don,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($don->CHR_NO_BUDGET) . "' id='input_prop_amo_". $don->CHR_NO_BUDGET ."' class='prop_amo_don' value='" . number_format($don->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($don->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($don->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($don->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $don->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($don->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($don->CHR_NO_BUDGET) ."' id='check_". $don->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_don();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($don->CHR_NO_BUDGET) . "' id='input_notes_". $don->CHR_NO_BUDGET ."' value='". $don->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($don->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($don->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($don->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($don->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($don->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($don->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($don->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($don->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $don->CHR_REMARK ."</td>";
                                            
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
                                        <td colspan="7"></td>
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
                                        <td colspan="15" style=" font-size: 14px; background-color: whitesmoke;"><strong>ENTER (Entertainment)</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>No Budget</strong></td>
                                        <td align="center"><strong>Description</strong></td>
                                        <td align="center"><strong>Planning <br/> (FY)</strong></td>
                                        <td align="center"><strong>Limit <br/> (FY)</strong></td>
                                        <td align="center"><strong>Proposed <br/> (FY)</strong></td>
                                        <td align="center"><strong>Realization <br/> (FY)</strong></td>
                                        <td align="center"><strong>Propose <br/>This Month</strong></td>                                        
                                        <td align="center"><strong>UNB</strong></td>
                                        <td align="center"><strong>Est. GR</strong></td>
                                        <td align="center"><strong>Check</strong></td>                                        
                                        <td align="center"><strong>Notes</strong></td>                                        
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Approval</strong></td>
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
                                             echo "<td align='right'>" . number_format(($ent->MON_PLAN_BLN*0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ent->MON_LIMIT_BLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ent->MON_REAL_BLN,0,',','.') . "</td>";
                                            
                                            $state = '';
                                            $style_input = '';
                                            if($ent->CHR_FLG_PROPOSED == '0'){
                                                if($ent->CHR_FLG_DELETE == '0'){
                                                    $state = ' checked';
                                                    $style_input = '';
                                                } else {
                                                    $state = '';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }                                                
                                            } else {
                                                if($ent->CHR_FLG_DELETE == '0'){
                                                    $state = ' disabled';
                                                    $style_input = '';
                                                } else {
                                                    $state = ' disabled';
                                                    $style_input = 'style="background-color:grey;" readonly';
                                                }
                                            }
                                            
                                            $prop_ent = 0;
                                            if($ent->CHR_FLG_DELETE == '0'){
                                                $prop_ent = $ent->MON_PROPOSE_BLN;
                                            }
                                            
                                            echo "<input type='hidden' id='hidden_prop_amo_". $ent->CHR_NO_BUDGET ."' value='" . number_format($prop_ent,0,',','.') . "'>"; 
                                            echo "<td align='right'><input type='text' name='amo_" . trim($ent->CHR_NO_BUDGET) . "' id='input_prop_amo_". $ent->CHR_NO_BUDGET ."' class='prop_amo_ent' value='" . number_format($ent->MON_PROPOSE_BLN,0,',','.') . "' onfocus='if(this.value == '0'){ this.value = ''; }' onblur='if (this.value == '') { this.value = '0'; }' ". $style_input ."></td>";
                                            
                                            //==== FLAG UNBUDGET ===============
                                            if($ent->CHR_FLG_UNBUDGET == '1'){
                                                echo "<td align='center'><i class='fa fa-check-circle' style='color:red;'></i></td>";
                                            } else {
                                                echo "<td align='center'>-</i></td>";
                                            }
                                            
                                            //==== EST GR DATE =================
                                            echo "<td align='center'>";
                                                echo "<select name='month_gr_". trim($ent->CHR_NO_BUDGET) ."'>";
                                                foreach($all_month as $mon) { 
                                                    $sel = "";
                                                    $dis = "";

                                                    if($mon[0] < $year_month){
                                                        $dis = 'disabled'; 
                                                    } else {
                                                        if($ent->CHR_ESTIMATE_GR_DATE != NULL){
                                                            if($mon[0] == $ent->CHR_ESTIMATE_GR_DATE){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        } else {
                                                            if($mon[0] == $year_month){ 
                                                                $sel = 'selected';                                                            
                                                            }
                                                        }
                                                    }
                                                    echo "<option value='" . $mon[0] . "'". $sel . $dis .">" . $mon[1] . "</option>";
                                                }
                                                echo "</select>";
                                            echo "</td>";
                                            
                                            $required = "";
                                            if($ent->CHR_FLG_OVERBUDGET == '2'){
                                                $required = "required";
                                            } else {
                                                $required = "";
                                            }
                                            
                                            echo "<td align='center'><input type='checkbox' name='check_". trim($ent->CHR_NO_BUDGET) ."' id='check_". $ent->CHR_NO_BUDGET ."' value='1' onchange='disableBudget_ent();' ". $state ."></td>"; 
                                            echo "<td align='center'><input type='text' name='note_" . trim($ent->CHR_NO_BUDGET) . "' id='input_notes_". $ent->CHR_NO_BUDGET ."' value='". $ent->CHR_NOTES ."' ". $required ."></td>";
                                            
                                            echo "<td align='center'>";
                                                if($ent->CHR_FLG_OVERBUDGET == '0'){
                                                    echo "<button type='button' class='btn btn-success' id='over_'" . trim($ent->CHR_NO_BUDGET) .">OK</button>";
                                                } else if($ent->CHR_FLG_OVERBUDGET == '1') {
                                                    echo "<button type='button' class='btn btn-warning' id='over_'" . trim($ent->CHR_NO_BUDGET) .">OL</button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-danger' id='over_'" . trim($ent->CHR_NO_BUDGET) .">OB</button>";
                                                }
                                            echo "</td>";
                                            
                                            echo "<td align='center'>";
                                                if($ent->CHR_FLG_PROPOSED == '1'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>WAIT</strong></button>";
                                                } else if ($ent->CHR_FLG_PROPOSED == '2'){
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>HOLD</strong></button>";
                                                } else if ($ent->CHR_FLG_PROPOSED == '3') {
                                                    echo "<button type='button' class='btn btn-info' style='width:55px;'><strong>OK</strong></button>";
                                                } else {
                                                    echo "<button type='button' class='btn btn-default' style='width:55px;'><strong>OPEN</strong></button>";
                                                }
                                            echo "</td>";
                                            echo "<td>". $ent->CHR_REMARK ."</td>";
                                            
                                            echo "</tr>";
                                            $tot_plan_ent = $tot_plan_ent + $ent->MON_PLAN_BLN;
                                            $tot_ori_limit_ent = $tot_ori_limit_don + ($ent->MON_PLAN_BLN*0.7);
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
                                        <td colspan="7"></td>
                                    </tr>
                                </tbody>                                
                            </table>
<!-- ======================= END ENTER ===================================== -->
                            <?php } ?>
                        </div>
                        <div align="right">
                            <?php if($num_budget != 0){
                                    if($switch != 0){
                                        echo '<input type="button" data-toggle="modal" data-target="#modalreschedule" data-placement="left" title="Add number budget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Add Budget" disabled>&nbsp;';
                                        echo '<input type="button" data-toggle="modal" data-target="#modalunbudget" data-placement="left" title="Add unbudget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Unbudget" disabled>';
                                    } else {
                                        echo '<input type="button" data-toggle="modal" data-target="#modalreschedule" data-placement="left" title="Add number budget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Add Budget">&nbsp;';
                                        echo '<input type="button" data-toggle="modal" data-target="#modalunbudget" data-placement="left" title="Add unbudget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Unbudget">';
                                    }                                
                                } else {
                            ?>
                                <a href="<?php echo base_url('index.php/budget/new_propose_budget_c/insert_default_budget') . "/" . $fiscal_start . "/" . $year_month . "/" . $kode_dept . "/" . str_replace('/','<',trim($no_propose)) ?>" class="btn btn-primary" data-placement="left" title="Add all available budget">Add All Budget</a>
                            <?php
                                    echo '<input type="button" data-toggle="modal" data-target="#modalreschedule" data-placement="left" title="Add number budget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Add Budget">&nbsp;';
                                    echo '<input type="button" data-toggle="modal" data-target="#modalunbudget" data-placement="left" title="Add unbudget" class="btn btn-primary" style="height:30px; width:100px; color:white;" value="Unbudget">';
                                }
                            ?>
                            
                        </div>                        
                        <div style="max-width: 900px;">
                            <table style="font-size: 12px;" id="table_summary" class="table table-hover table-condensed display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="8" align="center" style=" font-size: 14px; background-color: whitesmoke;"><strong>SUMMARY TOTAL PROPOSED BUDGET - <?php echo strtoupper(date("F", mktime(null, null, null, $month))) . ' ' . substr($year_month,0,4); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>Budget Type</strong></td>
                                        <td align="center"><strong>Planning</strong></td>
                                        <td align="center"><strong>Limit (70%)</strong></td>
                                        <td align="center"><strong>Proposed</strong></td>
                                        <td align="center"><strong>Realization</strong></td>
                                        <td align="center"><strong>New Propose</strong></td>
                                        <td align="center"><strong>Status</strong></td>
                                        <td align="center"><strong>Notes</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
//========================== SUMMARY BUDGET CAPEX ============================//
                                    $status_over = '';
                                    $tot_sum_plan_cpx = 0;
                                    $tot_sum_ori_limit_cpx = 0;
                                    $tot_sum_limit_cpx = 0;
                                    $tot_sum_real_cpx = 0;
                                    if($propose_capex != NULL){
                                        echo "<tr>";
                                        echo "<td>CAPEX (". ($no_cpx-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_cpx,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_cpx,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_cpx,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_cpx,0,',','.') . "</td>";
                                        if(count($ori_capex) != 0){
                                            echo "<td align='right'>" . number_format($ori_capex->PBLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format(($ori_capex->PBLN * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ori_capex->LBLN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($ori_capex->OBLN,0,',','.') . "</td>";
                                            echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_cpx' value='" . number_format($tot_prop_cpx,0,',','.') . "' readonly></strong></td>"; 
                                            echo "<td align='center'>";
                                                if(($tot_prop_cpx + $ori_capex->LBLN) <= ($ori_capex->PBLN * 0.7)){
                                                    echo "<button type='button' class='btn btn-success' id='over_cpx' value='0'>OK</button>";
                                                } else if(($ori_capex->PBLN * 0.7) < ($tot_prop_cpx + $ori_capex->LBLN) && ($tot_prop_cpx + $ori_capex->LBLN) <= $ori_capex->PBLN) {
                                                    echo "<button type='button' class='btn btn-warning' id='over_cpx' value='1'>OL</button>";
                                                } else {
                                                    $status_over .= 'CAPEX ';
                                                    echo "<button type='button' class='btn btn-danger' id='over_cpx' value='2'>OB</button>";
                                                }
                                            echo "</td>";
                                            $get_notes_cpx = $this->db->query("SELECT CHR_NOTES_CAPEX FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                            $notes_cpx = '';
                                            if($get_notes_cpx != NULL){
                                                $notes_cpx = $get_notes_cpx->CHR_NOTES_CAPEX;
                                            }
                                            echo "<td align='center'><input type='text' name='notes_capex' value='". $notes_cpx ."'></td>";
                                            echo "</tr>";

                                            $tot_sum_plan_cpx = $tot_sum_plan_cpx + $ori_capex->PBLN;
                                            $tot_sum_ori_limit_cpx = $tot_sum_ori_limit_cpx + ($ori_capex->PBLN * 0.7);
                                            $tot_sum_limit_cpx = $tot_sum_limit_cpx + $ori_capex->LBLN;
                                            $tot_sum_real_cpx = $tot_sum_real_cpx + $ori_capex->OBLN;
                                        } else {
                                            echo "<td align='right'>" . number_format(0,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format((0 * 0.7),0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format(0,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format(0,0,',','.') . "</td>";
                                            echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_cpx' value='" . number_format($tot_prop_cpx,0,',','.') . "' readonly></strong></td>"; 
                                            echo "<td align='center'>";
                                                if(($tot_prop_cpx + 0) <= (0 * 0.7)){
                                                    echo "<button type='button' class='btn btn-success' id='over_cpx' value='0'>OK</button>";
                                                } else if((0 * 0.7) < ($tot_prop_cpx + 0) && ($tot_prop_cpx + 0) <= 0) {
                                                    echo "<button type='button' class='btn btn-warning' id='over_cpx' value='1'>OL</button>";
                                                } else {
                                                    $status_over .= 'CAPEX ';
                                                    echo "<button type='button' class='btn btn-danger' id='over_cpx' value='2'>OB</button>";
                                                }
                                            echo "</td>";
                                            $get_notes_cpx = $this->db->query("SELECT CHR_NOTES_CAPEX FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                            $notes_cpx = '';
                                            if($get_notes_cpx != NULL){
                                                $notes_cpx = $get_notes_cpx->CHR_NOTES_CAPEX;
                                            }
                                            echo "<td align='center'><input type='text' name='notes_capex' value='". $notes_cpx ."'></td>";
                                            echo "</tr>";

                                            $tot_sum_plan_cpx = $tot_sum_plan_cpx + 0;
                                            $tot_sum_ori_limit_cpx = $tot_sum_ori_limit_cpx + (0 * 0.7);
                                            $tot_sum_limit_cpx = $tot_sum_limit_cpx + 0;
                                            $tot_sum_real_cpx = $tot_sum_real_cpx + 0;
                                        }
                                    }
                                    ?>
                                    <tr style="background-color: whitesmoke; border-top-style: solid; border-bottom-style: solid;">
                                        <td align="center"><strong>TOTAL CAPEX</strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_plan_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_ori_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_limit_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($tot_sum_real_cpx,0,',','.'); ?></strong></td>
                                        <td align="right"><strong><input type='text' id="tot_prop_amo" class="tot_prop_amo_cpx" name="summary_prop_cpx" value="<?php echo number_format($tot_prop_cpx,0,',','.');?>" readonly></strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                <?php
//========================== SUMMARY BUDGET EXPENSE ==========================//
                                    $tot_sum_plan = 0;
                                    $tot_sum_ori_limit = 0;
                                    $tot_sum_limit = 0;
                                    $tot_sum_real = 0;
                                    if($propose_repma != NULL){
                                        echo "<tr>";
                                        echo "<td>REPMA (". ($no_rmb-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_rmb,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_rmb,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_rmb,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_rmb,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_repma->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_repma->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_repma->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_repma->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rmb' value='" . number_format($tot_prop_rmb,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_rmb + $ori_repma->LBLN) <= ($ori_repma->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_rmb' value='0'>OK</button>";
                                            } else if(($ori_repma->PBLN * 0.7) < ($tot_prop_rmb + $ori_repma->LBLN) && ($tot_prop_rmb + $ori_repma->LBLN) <= $ori_repma->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_rmb' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'REPMA ';
                                                echo "<button type='button' class='btn btn-danger' id='over_rmb' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_rmb = $this->db->query("SELECT CHR_NOTES_REPMA FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_rmb = '';
                                        if($get_notes_rmb != NULL){
                                            $notes_rmb = $get_notes_rmb->CHR_NOTES_REPMA;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_repma' value='". $notes_rmb ."'></td>";
                                        echo "</tr>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_repma->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_repma->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_repma->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_repma->OBLN;
                                    }
                                    if($propose_right != NULL){
                                        echo "<tr>";
                                        echo "<td>RIGHT (". ($no_rig-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_rig,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_rig,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_rig,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_rig,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_right->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_right->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_right->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_right->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rig' value='" . number_format($tot_prop_rig,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_rig + $ori_right->LBLN) <= ($ori_right->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_rig' value='0'>OK</button>";
                                            } else if(($ori_right->PBLN * 0.7) < ($tot_prop_rig + $ori_right->LBLN) && ($tot_prop_rig + $ori_right->LBLN) <= $ori_right->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_rig' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'RIGHT ';
                                                echo "<button type='button' class='btn btn-danger' id='over_rig' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_rig = $this->db->query("SELECT CHR_NOTES_RIGHT FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_rig = '';
                                        if($get_notes_rig != NULL){
                                            $notes_rig = $get_notes_rig->CHR_NOTES_RIGHT;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_right' value='". $notes_rig ."'></td>";
                                        echo "</tr>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_right->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_right->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_right->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_right->OBLN;
                                    }
                                    if($propose_tooeq != NULL){
                                        echo "<tr>";
                                        echo "<td>TOOEQ (". ($no_teq-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_teq,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_teq,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_teq,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_teq,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_tooeq->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_tooeq->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_tooeq->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_tooeq->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_teq' value='" . number_format($tot_prop_teq,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_teq + $ori_tooeq->LBLN) <= ($ori_tooeq->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_teq' value='0'>OK</button>";
                                            } else if(($ori_tooeq->PBLN * 0.7) < ($tot_prop_teq + $ori_tooeq->LBLN) && ($tot_prop_teq + $ori_tooeq->LBLN) <= $ori_tooeq->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_teq' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'TOOEQ ';
                                                echo "<button type='button' class='btn btn-danger' id='over_teq' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_teq = $this->db->query("SELECT CHR_NOTES_TOOEQ FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_teq = '';
                                        if($get_notes_teq != NULL){
                                            $notes_teq = $get_notes_teq->CHR_NOTES_TOOEQ;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_tooeq' value='". $notes_teq ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_tooeq->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_tooeq->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_tooeq->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_tooeq->OBLN;
                                    }
                                    if($propose_offeq != NULL){
                                        echo "<tr>";
                                        echo "<td>OFFEQ (". ($no_off-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_off,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_off,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_off,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_off,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_offeq->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_offeq->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_offeq->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_offeq->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_off' value='" . number_format($tot_prop_off,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_off + $ori_offeq->LBLN) <= ($ori_offeq->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_off' value='0'>OK</button>";
                                            } else if(($ori_offeq->PBLN * 0.7) < ($tot_prop_off + $ori_offeq->LBLN) && ($tot_prop_off + $ori_offeq->LBLN) <= $ori_offeq->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_off' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'OFFEQ ';
                                                echo "<button type='button' class='btn btn-danger' id='over_off' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_off = $this->db->query("SELECT CHR_NOTES_OFFEQ FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_off = '';
                                        if($get_notes_off != NULL){
                                            $notes_off = $get_notes_off->CHR_NOTES_OFFEQ;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_offeq' value='". $notes_off ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_offeq->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_offeq->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_offeq->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_offeq->OBLN;
                                    }
                                    if($propose_trial != NULL){
                                        echo "<tr>";
                                        echo "<td>TRIAL (". ($no_tri-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_tri,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_tri,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_tri,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_tri,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_trial->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_trial->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_trial->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_trial->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_tri' value='" . number_format($tot_prop_tri,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_tri + $ori_trial->LBLN) <= ($ori_trial->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_tri' value='0'>OK</button>";
                                            } else if(($ori_trial->PBLN * 0.7) < ($tot_prop_tri + $ori_trial->LBLN) && ($tot_prop_tri + $ori_trial->LBLN) <= $ori_trial->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_tri' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'TRIAL ';
                                                echo "<button type='button' class='btn btn-danger' id='over_tri' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_tri = $this->db->query("SELECT CHR_NOTES_TRIAL FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_tri = '';
                                        if($get_notes_tri != NULL){
                                            $notes_tri = $get_notes_tri->CHR_NOTES_TRIAL;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_trial' value='". $notes_tri ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_trial->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_trial->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_trial->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_trial->OBLN;
                                    }
                                    if($propose_empwa != NULL){
                                        echo "<tr>";
                                        echo "<td>EMPWA (". ($no_emp-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_emp,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_emp,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_emp,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_emp,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_empwa->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_empwa->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_empwa->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_empwa->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_emp' value='" . number_format($tot_prop_emp,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_emp + $ori_empwa->LBLN) <= ($ori_empwa->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_emp' value='0'>OK</button>";
                                            } else if(($ori_empwa->PBLN * 0.7) < ($tot_prop_emp + $ori_empwa->LBLN) && ($tot_prop_emp + $ori_empwa->LBLN) <= $ori_empwa->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_emp' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'EMPWA ';
                                                echo "<button type='button' class='btn btn-danger' id='over_emp' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_emp = $this->db->query("SELECT CHR_NOTES_EMPWA FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_emp = '';
                                        if($get_notes_emp != NULL){
                                            $notes_emp = $get_notes_emp->CHR_NOTES_EMPWA;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_empwa' value='". $notes_emp ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_empwa->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_empwa->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_empwa->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_empwa->OBLN; 
                                    }
                                    if($propose_engfe != NULL){
                                        echo "<tr>";
                                        echo "<td>ENGFE (". ($no_eng-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_eng,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_eng,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_eng,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_eng,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_engfe->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_engfe->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_engfe->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_engfe->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_eng' value='" . number_format($tot_prop_eng,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_eng + $ori_engfe->LBLN) <= ($ori_engfe->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_eng' value='0'>OK</button>";
                                            } else if(($ori_engfe->PBLN * 0.7) < ($tot_prop_eng + $ori_engfe->LBLN) && ($tot_prop_eng + $ori_engfe->LBLN) <= $ori_engfe->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_eng' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'ENGFE ';
                                                echo "<button type='button' class='btn btn-danger' id='over_eng' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_eng = $this->db->query("SELECT CHR_NOTES_ENGFE FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_eng = '';
                                        if($get_notes_eng != NULL){
                                            $notes_eng = $get_notes_eng->CHR_NOTES_ENGFE;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_engfe' value='". $notes_eng ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_engfe->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_engfe->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_engfe->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_engfe->OBLN;
                                    }
                                    if($propose_itexp != NULL){
                                        echo "<tr>";
                                        echo "<td>ITEXP (". ($no_ite-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_ite,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_ite,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_ite,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_ite,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_itexp->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_itexp->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_itexp->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_itexp->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ite' value='" . number_format($tot_prop_ite,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_ite + $ori_itexp->LBLN) <= ($ori_itexp->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_ite' value='0'>OK</button>";
                                            } else if(($ori_itexp->PBLN * 0.7) < ($tot_prop_ite + $ori_itexp->LBLN) && ($tot_prop_ite + $ori_itexp->LBLN) <= $ori_itexp->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_ite' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'ITEXP ';
                                                echo "<button type='button' class='btn btn-danger' id='over_ite' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_ite = $this->db->query("SELECT CHR_NOTES_ITEXP FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_ite = '';
                                        if($get_notes_ite != NULL){
                                            $notes_ite = $get_notes_ite->CHR_NOTES_ITEXP;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_itexp' value='". $notes_ite ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_itexp->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_itexp->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_itexp->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_itexp->OBLN;
                                    }
                                    if($propose_renta != NULL){
                                        echo "<tr>";
                                        echo "<td>RENTA (". ($no_ren-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_ren,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_ren,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_ren,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_ren,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_renta->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_renta->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_renta->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_renta->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ren' value='" . number_format($tot_prop_ren,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_ren + $ori_renta->LBLN) <= ($ori_renta->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_ren' value='0'>OK</button>";
                                            } else if(($ori_renta->PBLN * 0.7) < ($tot_prop_ren + $ori_renta->LBLN) && ($tot_prop_ren + $ori_renta->LBLN) <= $ori_renta->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_ren' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'RENTA ';
                                                echo "<button type='button' class='btn btn-danger' id='over_ren' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_ren = $this->db->query("SELECT CHR_NOTES_RENTA FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_ren = '';
                                        if($get_notes_ren != NULL){
                                            $notes_ren = $get_notes_ren->CHR_NOTES_RENTA;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_renta' value='". $notes_ren ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_renta->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_renta->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_renta->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_renta->OBLN;
                                    }
                                    if($propose_rndev != NULL){
                                        echo "<tr>";
                                        echo "<td>RNDEV (". ($no_rnd-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_rnd,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_rnd,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_rnd,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_rnd,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_rndev->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_rndev->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_rndev->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_rndev->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_rnd' value='" . number_format($tot_prop_rnd,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_rnd + $ori_rndev->LBLN) <= ($ori_rndev->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_rnd' value='0'>OK</button>";
                                            } else if(($ori_rndev->PBLN * 0.7) < ($tot_prop_rnd + $ori_rndev->LBLN) && ($tot_prop_rnd + $ori_rndev->LBLN) <= $ori_rndev->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_rnd' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'RNDEV ';
                                                echo "<button type='button' class='btn btn-danger' id='over_rnd' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_rnd = $this->db->query("SELECT CHR_NOTES_RNDEV FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_rnd = '';
                                        if($get_notes_rnd != NULL){
                                            $notes_rnd = $get_notes_rnd->CHR_NOTES_RNDEV;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_rndev' value='". $notes_rnd ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_rndev->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_rndev->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_rndev->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_rndev->OBLN;
                                    }
                                    if($propose_donat != NULL){
                                        echo "<tr>";
                                        echo "<td>DONAT (". ($no_don-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_don,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_don,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_don,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_don,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_donat->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_donat->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_donat->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_donat->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_don' value='" . number_format($tot_prop_don,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_don + $ori_donat->LBLN) <= ($ori_donat->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_don' value='0'>OK</button>";
                                            } else if(($ori_donat->PBLN * 0.7) < ($tot_prop_don + $ori_donat->LBLN) && ($tot_prop_don + $ori_donat->LBLN) <= $ori_donat->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_don' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'DONAT ';
                                                echo "<button type='button' class='btn btn-danger' id='over_don' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_don = $this->db->query("SELECT CHR_NOTES_DONAT FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_don = '';
                                        if($get_notes_don != NULL){
                                            $notes_don = $get_notes_don->CHR_NOTES_DONAT;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_donat' value='". $notes_don ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_donat->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_donat->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_donat->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_donat->OBLN;
                                    }
                                    if($propose_enter != NULL){
                                        echo "<tr>";
                                        echo "<td>ENTER (". ($no_ent-1) .")</td>";
//                                        echo "<td align='right'>" . number_format($tot_plan_ent,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_ori_limit_ent,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_limit_ent,0,',','.') . "</td>";
//                                        echo "<td align='right'>" . number_format($tot_real_ent,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_enter->PBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format(($ori_enter->PBLN * 0.7),0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_enter->LBLN,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($ori_enter->OBLN,0,',','.') . "</td>";
                                        echo "<td align='right'><strong><input type='text' id='tot_prop_amo' class='tot_prop_amo_ent' value='" . number_format($tot_prop_ent,0,',','.') . "' readonly></strong></td>"; 
                                        echo "<td align='center'>";
                                            if(($tot_prop_ent + $ori_enter->LBLN) <= ($ori_enter->PBLN * 0.7)){
                                                echo "<button type='button' class='btn btn-success' id='over_ent' value='0'>OK</button>";
                                            } else if(($ori_enter->PBLN * 0.7) < ($tot_prop_ent + $ori_enter->LBLN) && ($tot_prop_ent + $ori_enter->LBLN) <= $ori_enter->PBLN) {
                                                echo "<button type='button' class='btn btn-warning' id='over_ent' value='1'>OL</button>";
                                            } else {
                                                $status_over .= 'ENTER ';
                                                echo "<button type='button' class='btn btn-danger' id='over_ent' value='2'>OB</button>";
                                            }
                                        echo "</td>";
                                        $get_notes_ent = $this->db->query("SELECT CHR_NOTES_ENTER FROM CPL.TT_NOTES_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
                                        $notes_ent = '';
                                        if($get_notes_ent != NULL){
                                            $notes_ent = $get_notes_ent->CHR_NOTES_ENTER;
                                        }
                                        echo "<td align='center'><input type='text' name='notes_enter' value='". $notes_ent ."'></td>";
                                        echo "</tr>";
                                        
                                        $tot_sum_plan = $tot_sum_plan + $ori_enter->PBLN;
                                        $tot_sum_ori_limit = $tot_sum_ori_limit + ($ori_enter->PBLN * 0.7);
                                        $tot_sum_limit = $tot_sum_limit + $ori_enter->LBLN;
                                        $tot_sum_real = $tot_sum_real + $ori_enter->OBLN;
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
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
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
                                echo anchor('budget/new_propose_budget_c/index/0/' . $fiscal_start . '/' . $year_month . '/' . $kode_dept, 'Back', 'class="btn btn-default"');                                
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
                                       echo '<button type="submit" name="save" class="btn btn-primary" id="propose_budget" value="propose" onclick="return confirmFunction()"><i class="fa fa-send"></i> Propose</button>';  
                                    }
                                } 
                            ?>
                        </div>                        
                    </div>                        
                    </form>                    
                </div>
            </div>            
        </div>        
        <div class="modal fade" id="modalreschedule" tabindex="-1" role="dialog" aria-labelledby="modalLabelReschedule" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalLabelReschedule"><strong>ALL AVAILABLE BUDGET</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <?php echo form_open('budget/new_propose_budget_c/add_reschedule_budget', 'class="form-horizontal" enctype="multipart/form-data"'); ?>
                            <input name="CHR_NO_PROPOSE_RES" id="no_prop_res" class="form-control" required type="hidden" value="<?php echo $no_propose; ?>">
                            <input name="CHR_FISCAL_YEAR_RES" id="fiscal_year_res" class="form-control" required type="hidden" value="<?php echo $fiscal_start.$fiscal_end; ?>">
                            <input name="CHR_YM_PROPOSE_RES" id="month_prop" class="form-control" required type="hidden" value="<?php echo $year_month; ?>">
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
                                                if (trim($kode_dept) == trim($dept->CHR_KODE_DEPARTMENT)) {
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
                                            <option value="ALL">ALL MONTH</option>
                                            <?php                                                
                                                for($i = 0; $i < 12; $i++) { 
                                            ?>
                                                <option value="<?PHP echo $all_month[$i][0]; ?>"> 
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
                            <div align="right">
                                <table width="100%">
                                    <tr>                                        
                                        <td width="80%"></td>
                                        <td width="16%" align="right"><strong>Choose All </strong>&nbsp;<input type="checkbox" id="select_all"></td>
                                        <td width="4%"></td>
                                    </tr>
                                </table>                                
                            </div>
                            <div>&nbsp;</div>
                            <div id="all_list_budget" style="overflow-y: scroll; max-height: 350px;">
                                <!-- VALUE FROM JSON -->
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
                            <?php echo form_open('budget/new_propose_budget_c/add_propose_unbudget', 'class="form-horizontal" enctype="multipart/form-data"'); ?>
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
                                <td>Price per Unit (Rp) <b class="mandatory">*</b></td>
                                <td colspan="4" align="left">
                                    <input name="REQ_AMO_UNB" onchange="cekAmount();" class="money_unb" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }"> 
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Qty <b class="mandatory">*</b></td>
                                <td colspan="4" align="left">
                                    <input name="REQ_QTY_UNB" class="qty_unb" id="input_qty" style="background-color: paleturquoise;" value="1" onfocus="if(this.value == '1'){ this.value = ''; }" onblur="if (this.value == '' || this.value == '0') { this.value = '1'; }">
                                </td>
                            </tr>
                            <tr>
                                <td>Notes <b class="mandatory">*</td>
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
                            <b class="mandatory">*</b> = mandatory
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
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script> 
//    $(document).ready(function() {
//        $('#example').DataTable({
//            scrollX: true,
//            fixedColumns: {
//                leftColumns: 3
//            }
//        });
//    });

    $(document).ready(function() {

        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
    
    function confirmFunction() {
        if (confirm("Are You sure to propose this number propose <?php echo $no_propose; ?>?\n\Please check OVERBUDGET (OB) : <?php echo $status_over; ?>")){
           yourformelement.submit(); 
        } else {
           return false;
        }
    }
    
//    function saveFunction() {
//        if(confirm("Are You sure to save this number propose <?php echo $no_propose; ?> ?")){
//            yourformelement.submit();
//        } else {
//            return false;
//        }
//    }
    
    
    $('.prop_amo_cpx').mask("#.##0", {reverse: true});
    $('.prop_amo_rmb').mask("#.##0", {reverse: true});
    $('.prop_amo_rig').mask("#.##0", {reverse: true});
    $('.prop_amo_teq').mask("#.##0", {reverse: true});
    $('.prop_amo_off').mask("#.##0", {reverse: true});
    $('.prop_amo_emp').mask("#.##0", {reverse: true});
    $('.prop_amo_eng').mask("#.##0", {reverse: true});
    $('.prop_amo_ite').mask("#.##0", {reverse: true});
    $('.prop_amo_ren').mask("#.##0", {reverse: true});
    $('.prop_amo_rnd').mask("#.##0", {reverse: true});
    $('.prop_amo_don').mask("#.##0", {reverse: true});
    $('.prop_amo_tri').mask("#.##0", {reverse: true});
    $('.prop_amo_ent').mask("#.##0", {reverse: true});
    
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
    
    $(document).on("change", "#select_all", function() {
        if(document.getElementById("select_all").checked){
            $(".list_bgt").attr("checked", true);
        } else {
            $(".list_bgt").attr("checked", false);
        }
    });
    
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
        var bdgt = <?php echo json_encode($propose_capex); ?>;
        var i = 0;
        var sum_cpx = 0;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = Number(bdgt[i]['MON_LIMIT_BLN']);
            var amo_cpx = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_cpx += +amo_cpx; 
            var next_prop = parseInt(amo_cpx) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_cpx = sum_cpx.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_cpx").val(tot_amo_cpx);
            i++;
        });
    });

    $(document).on("change", ".prop_amo_rmb", function() {
        var bdgt = <?php echo json_encode($propose_repma); ?>;
        var i = 0;
        var sum_rmb = 0;
        var old_rmb_prop = document.getElementsByClassName('tot_prop_amo_rmb')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_rmb = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_rmb += +amo_rmb; 
            var next_prop = parseInt(amo_rmb) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_rmb = sum_rmb.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_rmb").val(tot_amo_rmb);
            
            var new_tot_all_prop = (old_tot_all_prop - old_rmb_prop) + sum_rmb;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });
    
    $(document).on("change", ".prop_amo_rig", function() {
        var bdgt = <?php echo json_encode($propose_repma); ?>;
        var i = 0;
        var sum_rig = 0;
        var old_rig_prop = document.getElementsByClassName('tot_prop_amo_rig')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_rig = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_rig += +amo_rig; 
            var next_prop = parseInt(amo_rmb) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_rig = sum_rig.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_rig").val(tot_amo_rig);
            
            var new_tot_all_prop = (old_tot_all_prop - old_rig_prop) + sum_rig;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });
    
    $(document).on("change", ".prop_amo_teq", function() {
        var bdgt = <?php echo json_encode($propose_tooeq); ?>;
        var i = 0;
        var sum_teq = 0;
        var old_teq_prop = document.getElementsByClassName('tot_prop_amo_teq')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_teq = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_teq += +amo_teq; 
            var next_prop = parseInt(amo_teq) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_teq = sum_teq.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_teq").val(tot_amo_teq);
            
            var new_tot_all_prop = (old_tot_all_prop - old_teq_prop) + sum_teq;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });
    
    $(document).on("change", ".prop_amo_off", function() {
        var bdgt = <?php echo json_encode($propose_offeq); ?>;
        var i = 0;
        var sum_off = 0;
        var old_off_prop = document.getElementsByClassName('tot_prop_amo_off')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_off = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_off += +amo_off; 
            var next_prop = parseInt(amo_off) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_off = sum_off.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_off").val(tot_amo_off);
            
            var new_tot_all_prop = (old_tot_all_prop - old_off_prop) + sum_off;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });
    
    $(document).on("change", ".prop_amo_emp", function() {
        var bdgt = <?php echo json_encode($propose_empwa); ?>;
        var i = 0;
        var sum_emp = 0;
        var old_emp_prop = document.getElementsByClassName('tot_prop_amo_emp')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_emp = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_emp += +amo_emp; 
            var next_prop = parseInt(amo_emp) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_emp = sum_emp.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_emp").val(tot_amo_emp);
            
            var new_tot_all_prop = (old_tot_all_prop - old_emp_prop) + sum_emp;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });

    $(document).on("change", ".prop_amo_eng", function() {
        var bdgt = <?php echo json_encode($propose_engfe); ?>;
        var i = 0;
        var sum_eng = 0;
        var old_eng_prop = document.getElementsByClassName('tot_prop_amo_eng')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_eng = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_eng += +amo_eng; 
            var next_prop = parseInt(amo_eng) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_eng = sum_eng.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_eng").val(tot_amo_eng);
            
            var new_tot_all_prop = (old_tot_all_prop - old_eng_prop) + sum_eng;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });

    $(document).on("change", ".prop_amo_ren", function() {
        var bdgt = <?php echo json_encode($propose_renta); ?>;
        var i = 0;
        var sum_ren = 0;
        var old_ren_prop = document.getElementsByClassName('tot_prop_amo_ren')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_ren = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_ren += +amo_ren; 
            var next_prop = parseInt(amo_ren) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_ren = sum_ren.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_ren").val(tot_amo_ren);
            
            var new_tot_all_prop = (old_tot_all_prop - old_ren_prop) + sum_ren;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });

    $(document).on("change", ".prop_amo_ite", function() {
        var bdgt = <?php echo json_encode($propose_itexp); ?>;
        var i = 0;
        var sum_ite = 0;
        var old_ite_prop = document.getElementsByClassName('tot_prop_amo_ite')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_ite = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_ite += +amo_ite; 
            var next_prop = parseInt(amo_ite) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_ite = sum_ite.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_ite").val(tot_amo_ite);
            
            var new_tot_all_prop = (old_tot_all_prop - old_ite_prop) + sum_ite;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });

    $(document).on("change", ".prop_amo_tri", function() {
        var bdgt = <?php echo json_encode($propose_trial); ?>;
        var i = 0;
        var sum_tri = 0;
        var old_tri_prop = document.getElementsByClassName('tot_prop_amo_tri')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_tri = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_tri += +amo_tri; 
            var next_prop = parseInt(amo_tri) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_tri = sum_tri.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_tri").val(tot_amo_tri);
            
            var new_tot_all_prop = (old_tot_all_prop - old_tri_prop) + sum_tri;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });

    $(document).on("change", ".prop_amo_rnd", function() {
        var bdgt = <?php echo json_encode($propose_rndev); ?>;
        var i = 0;
        var sum_rnd = 0;
        var old_rnd_prop = document.getElementsByClassName('tot_prop_amo_rnd')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_rnd = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_rnd += +amo_rnd; 
            var next_prop = parseInt(amo_rnd) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_rnd = sum_rnd.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_rnd").val(tot_amo_rnd);
            
            var new_tot_all_prop = (old_tot_all_prop - old_rnd_prop) + sum_rnd;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });

    $(document).on("change", ".prop_amo_don", function() {
        var bdgt = <?php echo json_encode($propose_donat); ?>;
        var i = 0;
        var sum_don = 0;
        var old_don_prop = document.getElementsByClassName('tot_prop_amo_don')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_don = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_don += +amo_don; 
            var next_prop = parseInt(amo_don) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_don = sum_don.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_don").val(tot_amo_don);
            
            var new_tot_all_prop = (old_tot_all_prop - old_don_prop) + sum_don;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });
    
    $(document).on("change", ".prop_amo_ent", function() {
        var bdgt = <?php echo json_encode($propose_enter); ?>;
        var i = 0;
        var sum_ent = 0;
        var old_ent_prop = document.getElementsByClassName('tot_prop_amo_ent')[0].value.replace(/[.]/g,"");
        var old_tot_all_prop = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var plan_amo = bdgt[i]['MON_PLAN_BLN'];
            var limit_amo = bdgt[i]['MON_LIMIT_BLN'];
            var amo_ent = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == true){
                //=== updated 20170907 ===
                document.getElementById('hidden_prop_amo_' + check_amo).value = document.getElementById('input_prop_amo_' + check_amo).value;
                //=== end ===
            }
            sum_ent += +amo_ent; 
            var next_prop = parseInt(amo_ent) + parseInt(limit_amo);
            if(next_prop > plan_amo){
                document.getElementById('input_notes_' + check_amo).required = true;
            } else {
                document.getElementById('input_notes_' + check_amo).required = false;
            }
            var tot_amo_ent = sum_ent.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_ent").val(tot_amo_ent);
            
            var new_tot_all_prop = (old_tot_all_prop - old_ent_prop) + sum_ent;
            var update_tot_all_prop = new_tot_all_prop.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".sum_all_prop_amo").val(update_tot_all_prop);
            i++;
        });
    });
    
    function getBudgetList() {
        var kd_dept_res = document.getElementById('dept_res').value;
        var kd_bgt_res = document.getElementById('bgt_type_res').value;
        var kd_fis_res = document.getElementById('fiscal_year_res').value;
        var kd_month_res = document.getElementById('month_res').value;
        var kd_prop_res = document.getElementById('no_prop_res').value;
        
        if(kd_month_res == ''){
            alert('Please select month...');
            return;
        }
        
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/new_propose_budget_c/get_budget_list'); ?>",
            data: "dt_dept=" + kd_dept_res + "&dt_bgt_type=" + kd_bgt_res + "&dt_fiscal=" + kd_fis_res + "&dt_prop=" + kd_prop_res + "&dt_month=" + kd_month_res,
            success: function(data) {
                console.log(data);
                $("#all_list_budget").html(data);
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "whitesmoke";
            }
            var amo_money = amo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            $(".tot_prop_amo_cpx").val(amo_money);
            i++;
        });
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
    
    function disableBudget_rig(){
        var bdgt = <?php echo json_encode($propose_right); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_rig')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value;
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
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
    
    function disableBudget_ent(){
        var bdgt = <?php echo json_encode($propose_enter); ?>;
        var i = 0;
        var amo = 0;
        var old_all_amo = document.getElementsByClassName('sum_all_prop_amo')[0].value.replace(/[.]/g,"");
        var old_amo = document.getElementsByClassName('tot_prop_amo_ent')[0].value.replace(/[.]/g,"");
        old_all_amo = old_all_amo - old_amo;
        jQuery.each(bdgt, function(){
            var check_amo = bdgt[i]['CHR_NO_BUDGET'];
            var hidden_amo = document.getElementById('hidden_prop_amo_' + check_amo).value; 
            var state = document.getElementById('check_' + check_amo).checked;
            if(state == false){
                document.getElementById('input_prop_amo_' + check_amo).value = 0; //not include calculation
                document.getElementById('input_prop_amo_' + check_amo).readOnly = true;
                document.getElementById('input_prop_amo_' + check_amo).style.backgroundColor = "grey";                
            } else {
                //=== update 20170907 ===
                document.getElementById('input_prop_amo_' + check_amo).value = hidden_amo;
                //=== end ===
                var amo_checked = document.getElementById('input_prop_amo_' + check_amo).value.replace(/[.]/g,"");
                amo += +amo_checked;                
                
                document.getElementById('input_prop_amo_' + check_amo).readOnly = false;
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
