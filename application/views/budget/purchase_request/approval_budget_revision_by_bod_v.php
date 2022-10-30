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
    
    #input {
        font-size: 10px;
        max-width: 77px;
        max-height: 20px;
    }
    
    #input2 {
        font-size: 10px;
        max-width: 23px;
        max-height: 20px;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Approval Revision Master Budget</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>LIST MASTER BUDGET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="25%">Fiscal Year</td>                                    
                                    <td width="60%">
                                        <select name="CHR_FISCAL" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/purchase_request_c/approval_budget_revision/0/' . $data->CHR_FISCAL_YEAR_START . '/CAPEX'); ?>" <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="15%"></td>
                                </tr>
                                <tr>
                                    <td width="25%">Budget Type</td>
                                    <td width="60%">
                                        <select name="CHR_BUDGET_TYPE" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_bgt_type as $bgt) { ?>
                                                <option value="<?php echo site_url('budget/purchase_request_c/approval_budget_revision/0/' . $fiscal_start . '/' . trim($bgt->CHR_BUDGET_TYPE)); ?>" <?php
                                                if ($budget_type == trim($bgt->CHR_BUDGET_TYPE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="15%"></td>
                                </tr>
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <div style="font-size:9px;">
                            <table style="font-size:12px;" id="dataTables3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td width="15%" align="center"><strong>No</strong></td>
                                        <td width="60%" align="center"><strong>No Budget</strong></td>
                                        <td width="25%" align="center"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        foreach ($list_budget_rev as $list_bgt) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td width='15%' align='center'>" . $no . "</td>";
                                            echo "<td width='60%'>" . $list_bgt->CHR_NO_BUDGET . "</td>";
                                            if(trim($list_bgt->CHR_NO_BUDGET) == $no_budget){
                                                echo "<td width='25%' align='center'><a href='" . base_url('index.php/budget/purchase_request_c/approval_budget_revision/0') . "/" . $fiscal_start . "/" . $budget_type . "/" . str_replace('/','<',trim($list_bgt->CHR_NO_BUDGET)) . "' class='label label-success' data-placement='left' data-toggle='tooltip' title='View'><span class='fa fa-folder-open' ></span></a></td>";
                                            } else {
                                                echo "<td width='25%' align='center'><a href='" . base_url('index.php/budget/purchase_request_c/approval_budget_revision/0') . "/" . $fiscal_start . "/" . $budget_type . "/" . str_replace('/','<',trim($list_bgt->CHR_NO_BUDGET)) . "' class='label label-primary' data-placement='left' data-toggle='tooltip' title='View'><span class='fa fa-folder' ></span></a></td>";
                                            }
                                            echo "</tr>";
                                            $no++;
                                    } ?>
                                </tbody>                                
                            </table>                                                      
                        </div>
                        <div>&nbsp;</div>
                        <div>
                            <table width="100%">
                                <tr>
                                    <td width="100%" align="right">
                                        <button data-toggle="modal" <?php if($no_budget == NULL){ echo 'disabled'; }?> data-target="#detailBudget" class="btn btn-primary" data-placement="left" title="View Detail Budget">View Detail Budget</button>
                                    </td>
                                </tr>
                            </table>  
                        </div>
                        <div class="modal fade" id="detailBudget" tabindex="-1" role="dialog" aria-labelledby="modalBudgetDetail" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog" style="width:1250px;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                            <h4 class="modal-title" id="modalBudgetDetail"><strong>View Detail Budget</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <table width="100%">                                   
                                                <tr>
                                                    <td width="20%" valign="top">Department</td>
                                                    <td width="2%" valign="top">:</td>
                                                    <td width="78%" valign="top"><strong><?php echo $curr_detail_budget->CHR_KODE_DEPARTMENT; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" valign="top">Fiscal Year</td>
                                                    <td width="2%" valign="top">:</td>
                                                    <td width="78%" valign="top"><strong><?php echo $fiscal_start . '-' . $fiscal_end; ?></strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal-body">
                                            <table width="100%" style="font-size:11px; font-weight: 600;">
                                                <tr>
                                                    <td width="4%" align="center"></td>
                                                    <td width="1%" align="center"></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">APR <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">MEI <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">JUN <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">JUL <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">AGU <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">SEP <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">OKT <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">NOV <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">DES <?php echo $fiscal_start; ?></td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">JAN <?php echo $fiscal_end; ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray; border-bottom: solid;">FEB <?php echo $fiscal_end; ?></td>
                                                    <td width="7%" align="center" style=" border-bottom: solid;">MAR <?php echo $fiscal_end; ?></td>
                                                </tr>
                                                <?php  
                                                    if($detail_plan != NULL){ 
                                                ?>
                                                <tr>
                                                    <td width="4%" align="left">Plan</td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_plan->PBLN04,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_plan->PBLN05,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_plan->PBLN06,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_plan->PBLN07,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_plan->PBLN08,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_plan->PBLN09,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_plan->PBLN10,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_plan->PBLN11,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_plan->PBLN12,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_plan->PBLN13,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_plan->PBLN14,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_plan->PBLN15,0,',','.'); ?></td>
                                                </tr>
                                                <?php } 
                                                    if($detail_rev1 != NULL){ 
                                                ?>
                                                <tr>
                                                    <td width="4%" align="left">Plan R2</td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_rev1->PBLN04,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_rev1->PBLN05,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_rev1->PBLN06,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_rev1->PBLN07,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_rev1->PBLN08,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_rev1->PBLN09,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_rev1->PBLN10,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_rev1->PBLN11,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_rev1->PBLN12,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_rev1->PBLN13,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_rev1->PBLN14,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_rev1->PBLN15,0,',','.'); ?></td>
                                                </tr>
                                                <?php } 
                                                    if($detail_limit != NULL){ 
                                                ?>
                                                <tr>
                                                    <td width="4%" align="left">Plafond</td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_limit->PBLN04,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_limit->PBLN05,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_limit->PBLN06,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_limit->PBLN07,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_limit->PBLN08,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_limit->PBLN09,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_limit->PBLN10,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_limit->PBLN11,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_limit->PBLN12,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_limit->PBLN13,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_limit->PBLN14,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_limit->PBLN15,0,',','.'); ?></td>
                                                </tr>                                                
                                                <?php }
                                                    if($detail_unbudget != NULL){ 
                                                ?>
                                                <tr>
                                                    <td width="4%" align="left">Unbudget</td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_unbudget->PBLN04,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_unbudget->PBLN05,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_unbudget->PBLN06,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_unbudget->PBLN07,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_unbudget->PBLN08,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_unbudget->PBLN09,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_unbudget->PBLN10,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_unbudget->PBLN11,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_unbudget->PBLN12,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_unbudget->PBLN13,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_unbudget->PBLN14,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_unbudget->PBLN15,0,',','.'); ?></td>
                                                </tr>
                                                <?php } 
                                                    if($detail_actual != NULL){ 
                                                ?>
                                                <tr>
                                                    <td width="4%" align="left">Actual PR</td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_actual->PBLN04,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_actual->PBLN05,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_actual->PBLN06,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_actual->PBLN07,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_actual->PBLN08,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_actual->PBLN09,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_actual->PBLN10,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_actual->PBLN11,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_actual->PBLN12,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_actual->PBLN13,0,',','.'); ?></td>
                                                    <td width="7%" align="center" style=" background-color: lightgray;"><?php echo number_format($detail_actual->PBLN14,0,',','.'); ?></td>
                                                    <td width="7%" align="center"><?php echo number_format($detail_actual->PBLN15,0,',','.'); ?></td>
                                                </tr>
                                                    <?php } ?>
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
            <?php
                $count = count($curr_detail_budget);
                if($count != 0){
            ?>
            <form method="post" action="<?php echo site_url("budget/purchase_request_c/save_approved_rev_budget_bod") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DETAIL REVISION BUDGET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>                    
                    <div class="grid-body">
                        <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                            <tr>
                                <td colspan="7" align="center" style="border-bottom:solid;"><strong>BUDGET HEADER</strong></td>
                            </tr>
                            <tr>
                                <td width="13%">No Budget</td>
                                <td width="1%">:</td>
                                <td width="45%"><strong><?php echo $curr_detail_budget->CHR_NO_BUDGET; ?></strong></td>
                                <td width="3%"></td>
                                <td width="13%">Type</td>
                                <td width="1%">:</td>
                                <td width="30%"><strong><?php echo $curr_detail_budget->CHR_KODE_TYPE_BUDGET; ?></strong></td>
                            </tr>
                            <tr>
                                <td width="13%" valign="top">Description</td>
                                <td width="1%" valign="top">:</td>
                                <td width="45%" valign="top"><strong><?php echo $curr_detail_budget->CHR_DESC_BUDGET; ?></strong></td>
                                <td width="3%" valign="top"></td>
                                <td width="13%" valign="top">Department</td>
                                <td width="1%" valign="top">:</td>
                                <td width="30%" valign="top"><strong><?php echo $curr_detail_budget->CHR_KODE_DEPARTMENT; ?></strong></td>
                            </tr>                            
                        </table>
                        <input name="CHR_NO_BUDGET" type="hidden" value="<?php echo $curr_detail_budget->CHR_NO_BUDGET; ?>">
                        <input name="CHR_TYPE_BUDGET" type="hidden" value="<?php echo $curr_detail_budget->CHR_KODE_TYPE_BUDGET; ?>">
                        <input name="CHR_FISCAL_START" type="hidden" value="<?php echo $fiscal_start; ?>">
                        <input name="CHR_FISCAL_END" type="hidden" value="<?php echo $fiscal_end; ?>">
                    </div>
                    <div class="grid-body">
                        <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                            <tr>
                                <td colspan="5" align="center" style="border-bottom:solid;"><strong>BUDGET BEFORE</strong></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">APR <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">MEI <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">JUN <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">JUL <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">AGU <?php echo $fiscal_start; ?></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN04" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN04,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN04; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN05" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN05,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN05; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN06" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN06,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN06; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN06" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN07,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN07; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN07" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN08,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN08; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">SEP <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">OKT <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">NOV <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">DES <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">JAN <?php echo $fiscal_end; ?></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN09" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN09,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN09; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN10" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN10,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN10; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN11" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN11,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN11; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN12" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN12,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN12; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN13" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN13,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN13; ?>" style="background-color: whitesmoke;" readonly>
                                </td>                                
                            </tr>
                            <tr>
                                <td width="20%" align="center">FEB <?php echo $fiscal_end; ?></td>
                                <td width="20%" align="center">MAR <?php echo $fiscal_end; ?></td>
                                <td width="20%" align="center"></td>
                                <td width="20%" align="center"></td>
                                <td width="20%" align="center"></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN14" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN14,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN14; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="CURR_BGT_LIMBLN15" id="input" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN15,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN15; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="right">Total Budget</td>
                                <?php
                                    $tot_curr_budget = $curr_detail_budget->MON_LIMBLN04 + $curr_detail_budget->MON_LIMBLN05 + $curr_detail_budget->MON_LIMBLN06 +
                                                       $curr_detail_budget->MON_LIMBLN07 + $curr_detail_budget->MON_LIMBLN08 + $curr_detail_budget->MON_LIMBLN09 +
                                                       $curr_detail_budget->MON_LIMBLN10 + $curr_detail_budget->MON_LIMBLN11 + $curr_detail_budget->MON_LIMBLN12 +
                                                       $curr_detail_budget->MON_LIMBLN13 + $curr_detail_budget->MON_LIMBLN14 + $curr_detail_budget->MON_LIMBLN15;
                                ?>
                                <td colspan="2" align="center"><input value="Rp <?php echo number_format($tot_curr_budget,2,',','.'); ?>" style="background-color: buttonhighlight; font-weight: bold" readonly></td>                                
                            </tr>                            
                        </table>
                    </div>
                    <div class="grid-body">
                        <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                            <tr>
                                <td colspan="5" align="center" style="border-bottom:solid;"><strong>BUDGET CHANGE REQUEST</strong></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">APR <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">MEI <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">JUN <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">JUL <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">AGU <?php echo $fiscal_start; ?></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN04" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN04,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN04; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN05" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN05,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN05; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN06" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN06,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN06; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN07" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN07,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN07; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN08" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN08,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN08; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">SEP <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">OKT <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">NOV <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">DES <?php echo $fiscal_start; ?></td>
                                <td width="20%" align="center">JAN <?php echo $fiscal_end; ?></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN09" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN09,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN09; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN10" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN10,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN10; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN11" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN11,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN11; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN12" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN12,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN12; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN13" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN13,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN13; ?>" style="background-color: whitesmoke;" readonly>
                                </td>                                
                            </tr>
                            <tr>                                
                                <td width="20%" align="center">FEB <?php echo $fiscal_end; ?></td>
                                <td width="20%" align="center">MAR <?php echo $fiscal_end; ?></td>
                                <td width="20%" align="center"></td>
                                <td width="20%" align="center"></td>
                                <td width="20%" align="center"></td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN14" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN14,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN14; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="center">
                                    <input name="REQ_BGT_LIMBLN15" id="input" value="<?php echo number_format($req_detail_budget->MON_LIMBLN15,0,',','.'); ?>" style="background-color: whitesmoke;" readonly>
                                    <input id="input2" value="<?php echo $req_detail_budget->INT_QTY_LIMBLN15; ?>" style="background-color: whitesmoke;" readonly>
                                </td>
                                <td width="20%" align="right">Total Budget</td>
                                <?php
                                    $tot_req_budget = $req_detail_budget->MON_LIMBLN04 + $req_detail_budget->MON_LIMBLN05 + $req_detail_budget->MON_LIMBLN06 +
                                                      $req_detail_budget->MON_LIMBLN07 + $req_detail_budget->MON_LIMBLN08 + $req_detail_budget->MON_LIMBLN09 +
                                                      $req_detail_budget->MON_LIMBLN10 + $req_detail_budget->MON_LIMBLN11 + $req_detail_budget->MON_LIMBLN12 +
                                                      $req_detail_budget->MON_LIMBLN13 + $req_detail_budget->MON_LIMBLN14 + $req_detail_budget->MON_LIMBLN15;
                                ?>
                                <td colspan="2" align="center"><input value="Rp <?php echo number_format($tot_req_budget,2,',','.'); ?>" style="background-color: buttonhighlight; font-weight: bold" readonly></td>                                
                            </tr>                            
                        </table>
                        <div>&nbsp;</div>
                        <table width="100%">
                            <tr>
                                <td width="15%">Status</td>
                                <td width="3%">:</td>
                                <td width="82%"><strong>
                                    <?php 
                                        if($curr_detail_budget->CHR_FLG_RESCHEDULE != '0'){ 
                                            echo 'RESCHEDULE &nbsp;';                                            
                                        } 
                                        
                                        if($curr_detail_budget->CHR_FLG_UNBUDGET != '0'){
                                            echo 'UNBUDGET &nbsp;';
                                        }
                                        
                                        if($curr_detail_budget->CHR_FLG_CHANGE_AMOUNT != '0'){
                                            echo 'CHANGE AMOUNT &nbsp;';
                                        }
                                    ?>
                                </strong>
                                </td>
                            </tr>                            
                            <tr>
                                <td width="15%">Reason</td>
                                <td width="3%">:</td>
                                <td width="82%"><strong><?php echo $req_detail_budget->CHR_FLG_NOTES; ?></strong></td>
                            </tr>
                            <tr>
                                <td width="15%">&nbsp;</td>
                                <td width="3%">&nbsp;</td>
                                <td width="82%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="15%"></td>
                                <td width="3%"></td>
                                <td width="82%" align="right">
                                    <!--<input type="submit" name="APPROVAL_STATE" class="btn btn-primary" data-placement="left" title="Approve Revisi Master Budget" value="Approved">
                                    <input type="submit" name="APPROVAL_STATE" class="btn btn-danger" data-placement="left" title="Reject Revisi Master Budget" value="Rejected">-->
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/save_approved_rev_budget_bod') . "/" . $fiscal_start . "/" . $fiscal_end . "/" . $budget_type . "/" . str_replace('/','<',$req_detail_budget->CHR_NO_BUDGET) . "/" . $req_detail_budget->INT_NO_REVISI; ?>" class="btn btn-primary" data-placement="left" title="Approve Revision of Master Budget" onclick="return confirm('Are you sure want to APPROVE this revision of Master Budget?');"><span class="fa fa-check" ></span> Approved</a>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/save_rejected_rev_budget_bod') . "/" . $fiscal_start . "/" . $fiscal_end . "/" . $budget_type . "/" . str_replace('/','<',$req_detail_budget->CHR_NO_BUDGET) . "/" . $req_detail_budget->INT_NO_REVISI; ?>" class="btn btn-danger" data-placement="left" title="Reject Revision of Master Budget" onclick="return confirm('Are you sure want to REJECT this revision of Master Budget?');"><span class="fa fa-times" ></span> Rejected</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            </form>
            <?php        
                }
            ?>
        </div>
         <div class="row">
            <div class="col-md-5">
                <div class="grid">
                    
                </div>
            </div>            
        </div>
    </section>
</aside>

