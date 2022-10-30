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
            <form method="post" id="filter_form" action="<?php echo site_url("budget/purchase_request_c/save_approval_summary_budget") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>LIST ALL MASTER BUDGET</strong></span>
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
                                                <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $data->CHR_FISCAL_YEAR_START . $kode_dept); ?>" <?php
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
                                    <td width="25%">Department</td>
                                    <td width="60%">
                                        <select name="CHR_DEPT" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $dept->CHR_KODE_DEPARTMENT; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="15%"></td>
                                </tr>
                                <tr>
                                    <td width="25%">Month</td>                                    
                                    <td width="60%">
                                        <select name="CHR_MONTH" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '04'); ?>" <?php if($month == $fiscal_start.'04') { echo ' SELECTED'; } ?>>April <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '05'); ?>" <?php if($month == $fiscal_start.'05') { echo ' SELECTED'; } ?>>Mei <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '06'); ?>" <?php if($month == $fiscal_start.'06') { echo ' SELECTED'; } ?>>Juni <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '07'); ?>" <?php if($month == $fiscal_start.'07') { echo ' SELECTED'; } ?>>Juli <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '08'); ?>" <?php if($month == $fiscal_start.'08') { echo ' SELECTED'; } ?>>Agustus <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '09'); ?>" <?php if($month == $fiscal_start.'09') { echo ' SELECTED'; } ?>>September <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '10'); ?>" <?php if($month == $fiscal_start.'10') { echo ' SELECTED'; } ?>>Oktober <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '11'); ?>" <?php if($month == $fiscal_start.'11') { echo ' SELECTED'; } ?>>November <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_start . '12'); ?>" <?php if($month == $fiscal_start.'12') { echo ' SELECTED'; } ?>>Desember <?php echo $fiscal_start; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_end . '01'); ?>" <?php if($month == $fiscal_end.'01') { echo ' SELECTED'; } ?>>Januari <?php echo $fiscal_end; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_end . '02'); ?>" <?php if($month == $fiscal_end.'02') { echo ' SELECTED'; } ?>>Februari <?php echo $fiscal_end; ?></option>
                                            <option value="<?PHP echo site_url('budget/purchase_request_c/approval_summary_budget_rev/0/' . $fiscal_start . '/' . $kode_dept . '/' . $fiscal_end . '03'); ?>" <?php if($month == $fiscal_end.'03') { echo ' SELECTED'; } ?>>Maret <?php echo $fiscal_end; ?></option>                                            
                                        </select>
                                    </td>
                                    <td width="15%"></td>
                                </tr>
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <div align="right">
                            Check All &nbsp;<input type="checkbox" value="1" id="cb_all_budget">  
                        </div>
                        <div style="font-size:10px;">
                            <table style="font-size:12px;" id="dataTable" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%" align="center"><strong>No</strong></td>
                                        <td width="25%" align="center"><strong>Budget Type</strong></td>
                                        <td width="25%" align="center"><strong>Plan</strong></td>
                                        <td width="25%" align="center"><strong>Propose</strong></td>
                                        <td width="25%" align="center"><strong>Check</strong></td>
                                        <td width="15%" align="center"><strong>View</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $tot_plan = 0;
                                        $tot_propose = 0;
                                        $no = 1;
                                        foreach ($all_budget as $bgt) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $no . "</td>";
                                            echo "<td align='center'>" . $bgt->CHR_KODE_TYPE_BUDGET . "</td>";
                                            echo "<td align='right'>" . number_format($bgt->TOT_PLAN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($bgt->TOT_LIMIT,0,',','.') . "</td>";
                                            echo "<td align='center'><input type='checkbox' id='cb_budget' name='CB_" . $bgt->CHR_KODE_TYPE_BUDGET ."' value='1'></td>";
                                            if($bgt->CHR_KODE_TYPE_BUDGET == $budget_type){
                                               echo "<td align='center'><a href='" . base_url('index.php/budget/purchase_request_c/approval_summary_budget_rev/0') . "/" . $fiscal_start . "/" . $kode_dept . "/" . $month . "/" . $bgt->CHR_KODE_TYPE_BUDGET . "' class='label label-success' data-placement='left' title='View'><span class='fa fa-check' ></span></a></td>"; 
                                            } else {
                                               echo "<td align='center'><a href='" . base_url('index.php/budget/purchase_request_c/approval_summary_budget_rev/0') . "/" . $fiscal_start . "/" . $kode_dept . "/" . $month . "/" . $bgt->CHR_KODE_TYPE_BUDGET . "' class='label label-primary' data-placement='left' title='View'><span class='fa fa-search' ></span></a></td>"; 
                                            }
                                            
                                            echo "</tr>";
                                            $tot_plan = $tot_plan + $bgt->TOT_PLAN;
                                            $tot_propose = $tot_propose + $bgt->TOT_LIMIT;
                                            $no++;
                                    } ?>
                                    <tr>
                                        <td colspan="2" align="right"><strong>TOTAL</strong></td>
                                        <td align="right"><strong>Rp <?php echo number_format($tot_plan,0,',','.'); ?></strong></td>
                                        <td align="right"><strong>Rp <?php echo number_format($tot_propose,0,',','.'); ?></strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>                                
                            </table>                            
                        </div>
                        <div align="right">
                        <button type="submit" class="btn btn-primary">Approved</button>
                        <button type="submit" class="btn btn-danger">Rejected</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if($budget_type != NULL || $budget_type != ''){
            ?>
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>LIST DETAIL BUDGET <?php echo $budget_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div style="font-size:9px;">
                            <table style="font-size:11px;" id="dataTable" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%" align="center"><strong>No</strong></td>
                                        <td width="25%" align="center"><strong>Budget No</strong></td>
                                        <td width="25%" align="center"><strong>Desc</strong></td>
                                        <td width="25%" align="center"><strong>Plan</strong></td>
                                        <td width="25%" align="center"><strong>Propose</strong></td>
                                        <td width="15%" align="center"><strong>View</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        foreach ($all_detail_budget as $bgt) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>" . $i . "</td>";
                                            echo "<td>" . $bgt->CHR_NO_BUDGET . "</td>";
                                            echo "<td>" . substr($bgt->CHR_DESC_BUDGET,0,30) . "</td>";
                                            echo "<td align='right'>" . number_format($bgt->TOT_PLAN,0,',','.') . "</td>";
                                            echo "<td align='right'>" . number_format($bgt->TOT_LIMIT,0,',','.') . "</td>";
                                            echo "<td align='center'><a href='" . base_url('index.php/budget/purchase_request_c/view_detail_budget_rev'). "/" . $fiscal_start . "/" . $budget_type . "/" . $month . "/" . str_replace('/', '<', trim($bgt->CHR_NO_BUDGET)) . "' class='label label-primary' data-placement='left' title='View'><span class='fa fa-search' ></span></a></td>";
                                            echo "</tr>";
                                            
                                            $i++;
                                    } ?>
                                </tbody>                                
                            </table>                                                      
                        </div>
                    </div>
                </div>                
            </div>
            <?php } ?>
            </form>
        </div>
    </section>
</aside>
<script>
   $(document).ready(function(){ 
    $('#cb_all_budget').change(function(){
        $(':checkbox').prop('checked', this.checked);
      });
   });
</script>

