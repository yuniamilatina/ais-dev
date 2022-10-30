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
            <li><a href="#"><strong>Report Usage Budget</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT USAGE BUDGET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_budget_c/new_export_report_usage_budget', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_EXP" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_DEPT_EXP" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_SECT_EXP" value="<?php echo $kode_sect; ?>" type="hidden">
                                <input name="CHR_BUDGET_TYPE_EXP" value="<?php echo $bgt_type; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id="filter">
                                <tr>
                                    <td width="10%">Fiscal Year</td>
                                    <td width="20%">
                                        <select name="CHR_FISCAL_YEAR" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($data_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/report_budget_c/report_usage_budget/' . $data->CHR_FISCAL_YEAR_START . '/' . $bgt_type . '/' . $kode_dept . '/' . $kode_sect); ?>" <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="10%">Department</td>
                                    <td width="20%">
                                        <?php if($role == '1' || $role == '2' || $role == '13' || $npk == '0483' || $npk == '0483a' || $npk == '7520' || $npk == '1582' || $npk == '3394' || $npk == '9692') { ?>
                                            <select name="CHR_DEPARTMENT" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                        <?php } else { ?>
                                            <select name="CHR_DEPARTMENT" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                        <?php } ?>
                                                <option value=""> --  Select Department -- </option>
                                            <?php foreach ($list_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/report_usage_budget/' . $fiscal_start . '/' . $bgt_type . '/' . trim($dept->CHR_KODE_DEPARTMENT) . '/' . $kode_sect); ?>" <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($dept->CHR_KODE_DEPARTMENT) . ' - ' . $dept->CHR_DEPARTMENT_DESCRIPTION; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td> 
                                </tr>
                                <tr>
                                    <td>Budget Type</td>
                                    <td>
                                        <select name="CHR_BUDGET_TYPE" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""> -- Select Type Budget -- </option>
                                            <?php foreach ($list_budget_type as $bgt) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/report_usage_budget/' . $fiscal_start . '/' . trim($bgt->CHR_BUDGET_TYPE) . '/' . $kode_dept . '/' . $kode_sect); ?>" <?php
                                                if ($bgt_type == trim($bgt->CHR_BUDGET_TYPE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                    <?php } ?>
                                        </select>                                        
                                    </td>
                                    <td></td>
                                    <td>Section</td>
                                    <td>
                                        <?php if($role == '6') { ?>
                                            <select name="CHR_SECTION" class="form-control" id="sect_name" onchange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                        <?php } else { ?>
                                            <select name="CHR_SECTION" class="form-control" id="sect_name" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                        <?php } ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/report_usage_budget/' . $fiscal_start . '/' . $bgt_type. '/' . $kode_dept . '/ALL'); ?>">ALL</option>
                                            <?php foreach ($list_sect as $sect) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/report_usage_budget/' . $fiscal_start . '/' . $bgt_type. '/' . $kode_dept . '/' . trim($sect->CHR_KODE_SECTION)); ?>" <?php
                                                if ($kode_sect == trim($sect->CHR_KODE_SECTION)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($sect->CHR_KODE_SECTION); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>                                                     
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <div>
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style=" font-size: 11px;">
                            <thead>
                                <tr>
                                    <th rowspan='2' align='center'>No</th>
                                    <th rowspan='2' align='center'>Approval Sheet</th>
                                    <th rowspan='2' align='center'>Budget No</th>
                                    <th rowspan='2' align='center'>Description</th>
                                    <th rowspan='2' align='center'>Budget Plan</th>                                    
                                    <th rowspan='2' align='center'>Remark</th>
                                    <th rowspan='2' align='center'>Quantity</th>
                                    <th rowspan='2' align='center'>Unit</th>
                                    <th rowspan='2' align='center'>Amount/Unit</th>
                                    <th rowspan='2' align='center'>Total Amount</th>
                                    <th rowspan='2' align='center'>Trans Date</th>
                                    <th rowspan='2' align='center'>Est. Date</th>
                                    <th rowspan='2' align='center'>Stat GR</th>
                                    <th rowspan='2' align='center'>Date GR</th>
                                    <th colspan='3' align='center'>Manager</th>
                                    <th colspan='3' align='center'>Group Man</th>
                                    <th colspan='3' align='center'>Director</th>
                                    <?php
                                        if($bgt_type == 'CAPEX'){
                                    ?>
                                    <th colspan='4' align='center'>Accounting</th>
                                    <?php
                                        } 
                                    ?>
                                    <th colspan='3' align='center'>Vice Pres</th>
                                    <th colspan='3' align='center'>Pres Dir</th>
                                    <th colspan='4' align='center'>Gudang Tool</th>
                                    <th colspan='4' align='center'>Purchasing</th>
                                    <?php
                                    if($role == '1'){
                                    ?>
                                    <th rowspan='2' align='center'>Action</th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th>                                    
                                    
                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th> 

                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th> 
                                    <?php
                                        if($bgt_type == 'CAPEX'){
                                    ?>
                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th> 
                                    <th align='center'>Asset No</th>
                                    <?php
                                        } 
                                    ?>
                                    
                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th> 

                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th> 

                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th>                                     
                                    <th align='center'>PR No</th>

                                    <th align='center'>Stat</th>
                                    <th align='center'>Date In</th>
                                    <th align='center'>Date Out</th> 
                                    <th align='center'>PO No</th>                                    
                                </tr>                                
                            </thead>
                            <tbody>
                                <?php                                
                                $session = $this->session->all_userdata();
                                $amo_pr_approved = 0;
                                $amo_pr_process = 0;
                                $i = 1;
                                foreach ($list_data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td align='center'>" . $i . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_KODE_TRANSAKSI . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_NO_BUDGET . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_PURCHASE_PART . "</td>";                                                                                
                                        echo "<td align='right'>" . number_format($isi->MON_AMOUNT_BUDGET,0,',','.') . "</td>";                                             
                                        echo "<td align='left'>" . $isi->CHR_REMARK . "</td>";
                                        echo "<td align='left'>" . $isi->INT_QTY . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_UNIT . "</td>";
                                        echo "<td align='right'>" . number_format($isi->MON_UNIT_PRICE_SUPPLIER,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->MON_TOTAL_PRICE_SUPPLIER,0,',','.') . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_TGL_TRANS . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_TGL_ESTIMASI_KEDATANGAN . "</td>";
                                        
                                        $part = substr(str_replace("'","",$isi->CHR_PURCHASE_PART),0,15); //Sampling 10 first character
                                        $bgt_aii = $this->load->database("bgt_aii", TRUE);                                        
                                        if ($bgt_type == 'CAPEX'){
                                            
                                            $gr = $bgt_aii->query("SELECT CHR_NO_BUDGET, BUDAT 
                                                                FROM BDGT_TT_REPORT_CAPEX 
                                                                WHERE (BEDNR LIKE '%$isi->CHR_KODE_TRANSAKSI%') AND (TXZ01 LIKE '%$part%')")->row();
                                            $match = count($gr);
                                            if($match == 0){
                                                $status_gr = '-';
                                                $date_gr = '-';
                                            } else {
                                                $status_gr = 'SUDAH GR';
                                                $date_gr = $gr->BUDAT;
                                            }     
                                        } else {
                                            $gr = $bgt_aii->query("SELECT CHR_NO_BUDGET, BUDAT 
                                                                FROM BDGT_TT_REPORT_EXPENSES 
                                                                WHERE (BEDNR LIKE '%$isi->CHR_KODE_TRANSAKSI%') AND (TXZ01 LIKE '%$part%')")->row();
                                            $match = count($gr);
                                            if($match == 0){
                                                $status_gr = '-';
                                                $date_gr = '-';
                                            } else {
                                                $status_gr = 'SUDAH GR';
                                                $date_gr = $gr->BUDAT;
                                            }
                                        }                                        
                                       
                                        echo "<td align='left'>" . $status_gr . "</td>";
                                        echo "<td align='left'>" . $date_gr . "</td>";

                                        //===== App MANAGER
                                        if ($isi->CHR_FLG_APPROVE_MAN == '1'){
                                            echo "<td align='center'><img src='" . base_url() . "/assets/img/check1.png' width='25'>    </td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_MAN_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_MAN ."</td>";                                            
                                        } else {
                                            echo "<td align='center'></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_MAN_IN ."</td>";                                            
                                            echo "<td align='center'></td>";
                                        }   

                                        //===== App GM
                                        if ($isi->CHR_FLG_APPROVE_GM == '1'){
                                            echo "<td align='center'><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GM_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GM ."</td>";                                            
                                        } else {
                                            echo "<td align='center'></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GM_IN ."</td>";
                                            echo "<td align='center'></td>";                                            
                                        }

                                        //===== App DIR
                                        if ($isi->CHR_FLG_APPROVE_BOD == '1'){
                                            $amo_pr_approved = $amo_pr_approved + $isi->MON_TOTAL_PRICE_SUPPLIER;
                                            echo "<td align='center'><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_BOD_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_BOD ."</td>";                                            
                                        } else {
                                            $amo_pr_process = $amo_pr_process + $isi->MON_TOTAL_PRICE_SUPPLIER;
                                            echo "<td align='center'></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_BOD_IN ."</td>";
                                            echo "<td align='center'></td>";                                            
                                        }

                                        
                                        //===== Accouting Asset
                                        if($bgt_type == 'CAPEX'){
                                            if ($isi->CHR_FLG_ACC == '1'){
                                                echo "<td align='center'>" ?> <a onclick="modalUpdateAcc(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdateAcc<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                                echo "<td align='center'>". $isi->CHR_DATE_ACC_IN ."</td>";
                                                echo "<td align='center'>". $isi->CHR_DATE_ACC ."</td>";
                                                echo "<td align='center'>". $isi->CHR_ASSET_NO ."</td>";
                                            } else {
                                                echo "<td align='center'>" ?> <a onclick="modalUpdateAcc(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdateAcc<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                                echo "<td align='center'>". $isi->CHR_DATE_ACC_IN ."</td>";
                                                echo "<td align='center'></td>";
                                                echo "<td align='center'></td>";
                                            }
                                        }
                                        
                                        //===== App VP
                                        if ($isi->CHR_FLG_VP == '1'){                                            
                                            echo "<td align='center'>" ?> <a onclick="modalUpdateVp(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdateVp<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_VP_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_VP ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="modalUpdateVp(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdateVp<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_VP_IN ."</td>";
                                            echo "<td align='center'></td>";
                                        }
                                        
                                        //===== App Pres Dir
                                        if ($isi->CHR_FLG_PRESDIR == '1'){ 
                                            echo "<td align='center'>" ?> <a onclick="modalUpdatePresdir(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdatePresdir<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PRESDIR_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PRESDIR ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="modalUpdatePresdir(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdatePresdir<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PRESDIR_IN ."</td>";
                                            echo "<td align='center'></td>";
                                        }
                                        
                                        //===== Gudang Tool
                                        if ($isi->CHR_FLG_GUDTOOL == '1'){ 
                                            echo "<td align='center'>" ?> <a onclick="modalUpdateGudtool(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdateGudtool<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GUDTOOL_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GUDTOOL ."</td>";
                                            echo "<td align='center'>". $isi->CHR_PR_NO ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="modalUpdateGudtool(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdateGudtool<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GUDTOOL_IN ."</td>";
                                            echo "<td align='center'></td>";
                                            echo "<td align='center'></td>";
                                        }

                                        //===== Purchasing
                                        if ($isi->CHR_FLG_PURC == '1'){ 
                                            echo "<td align='center'>" ?> <a onclick="modalUpdatePurc(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdatePurc<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PURC_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PURC ."</td>";
                                            echo "<td align='center'>". $isi->CHR_PO_NO ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="modalUpdatePurc(<?php echo $isi->CHR_KODE_TRANSAKSI; ?>);" data-toggle="modal" data-target="#modalUpdatePurc<?php echo $isi->CHR_KODE_TRANSAKSI; ?>" data-toggle="tooltip" title="Edit"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PURC_IN ."</td>";
                                            echo "<td align='center'></td>";
                                            echo "<td align='center'></td>";
                                        }

                                        
                                        if($role == '1'){ 
                                        ?>                                           
                                            <td align='center'><a data-toggle="modal" data-target="#modalEdit<?php echo $isi->CHR_KODE_TRANSAKSI;; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit" <?php echo $isi->CHR_KODE_TRANSAKSI; ?>><span class="fa fa-pencil"></span></a></td>
                                        <?php
                                        }
                                                                                
                                        $i++;
                                }
                                ?>
                                
                            </tbody>
                        </table>
                        </div>                        
                        <div>
                            Total PR <strong>Approved</strong> : <span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($amo_pr_approved, 0, ',', '.'); ?></span> &nbsp; &nbsp; &nbsp;
                            Total PR <strong>In Process</strong> : <span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($amo_pr_process, 0, ',', '.'); ?></span>
                        </div>
                        <?php 
                        //===== Modal Edit
                        foreach ($list_data as $val) { ?>                        
                        <div class="modal fade" id="modalEdit<?php echo $val->CHR_KODE_TRANSAKSI; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Approval Progress - <?php echo $val->CHR_KODE_TRANSAKSI; ?></strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('budget/report_budget_c/update_progress_all', 'class="form-horizontal"'); ?>

                                            <input name="KODE_TRANSAKSI" type="hidden" value="<?php echo trim($val->CHR_KODE_TRANSAKSI); ?>">
                                            <input name="FISCAL" value="<?php echo $fiscal_start; ?>" type="hidden">
                                            <input name="DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                            <input name="SECT" value="<?php echo $kode_sect; ?>" type="hidden">
                                            <input name="BUDGET_TYPE" value="<?php echo $bgt_type; ?>" type="hidden">

                                            <!-- MANAGER -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish MGR</strong></label>
                                                    <input type="radio" class="icheck" disabled name="flg_mgr" value="1" <?php if($val->CHR_FLG_APPROVE_MAN == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" disabled name="flg_mgr" value="0" <?php if($val->CHR_FLG_APPROVE_MAN == '0' || $val->CHR_FLG_APPROVE_MAN == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_mgr_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_MAN_IN != NULL && $val->CHR_DATE_MAN_IN != ""){ echo substr(trim($val->CHR_DATE_MAN_IN),4,2) . '/' . substr(trim($val->CHR_DATE_MAN_IN),6,2) . '/' . substr(trim($val->CHR_DATE_MAN_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_mgr" disabled style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_APPROVE_MAN == '1'){ echo substr(trim($val->CHR_DATE_MAN),4,2) . '/' . substr(trim($val->CHR_DATE_MAN),6,2) . '/' . substr(trim($val->CHR_DATE_MAN),0,4); }?>">
                                                </div>
                                            </div>

                                            <!-- GROUP MANAGER -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish GM</strong></label>
                                                    <input type="radio" class="icheck" disabled name="flg_gm" value="1" <?php if($val->CHR_FLG_APPROVE_GM == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" disabled name="flg_gm" value="0" <?php if($val->CHR_FLG_APPROVE_GM == '0' || $val->CHR_FLG_APPROVE_GM == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_gm_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_GM_IN != NULL && $val->CHR_DATE_GM_IN != ""){ echo substr(trim($val->CHR_DATE_GM_IN),4,2) . '/' . substr(trim($val->CHR_DATE_GM_IN),6,2) . '/' . substr(trim($val->CHR_DATE_GM_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_gm" disabled style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_APPROVE_GM == '1'){ echo substr(trim($val->CHR_DATE_GM),4,2) . '/' . substr(trim($val->CHR_DATE_GM),6,2) . '/' . substr(trim($val->CHR_DATE_GM),0,4); }?>">
                                                </div>
                                            </div>

                                            <!-- GROUP DIREKTUR -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish DIR</strong></label>
                                                    <input type="radio" class="icheck" disabled name="flg_dir" value="1" <?php if($val->CHR_FLG_APPROVE_BOD == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" disabled name="flg_dir" value="0" <?php if($val->CHR_FLG_APPROVE_BOD == '0' || $val->CHR_FLG_APPROVE_BOD == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_dir_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_BOD_IN != NULL && $val->CHR_DATE_BOD_IN != ""){ echo substr(trim($val->CHR_DATE_BOD_IN),4,2) . '/' . substr(trim($val->CHR_DATE_BOD_IN),6,2) . '/' . substr(trim($val->CHR_DATE_BOD_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_dir" disabled style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_APPROVE_BOD == '1'){ echo substr(trim($val->CHR_DATE_BOD),4,2) . '/' . substr(trim($val->CHR_DATE_BOD),6,2) . '/' . substr(trim($val->CHR_DATE_BOD),0,4); }?>">
                                                </div>
                                            </div>

                                            <?php if($bgt_type == 'CAPEX'){ ?>
                                            <!-- ACCOUNTING -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Acc</strong></label>
                                                    <input type="radio" class="icheck" name="flg_acc" value="1" <?php if($val->CHR_FLG_ACC == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_acc" value="0" <?php if($val->CHR_FLG_ACC == '0' || $val->CHR_FLG_ACC == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_acc_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_ACC_IN != NULL && $val->CHR_DATE_ACC_IN != ""){ echo substr(trim($val->CHR_DATE_ACC_IN),4,2) . '/' . substr(trim($val->CHR_DATE_ACC_IN),6,2) . '/' . substr(trim($val->CHR_DATE_ACC_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_acc" style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_ACC == '1'){ echo substr(trim($val->CHR_DATE_ACC),4,2) . '/' . substr(trim($val->CHR_DATE_ACC),6,2) . '/' . substr(trim($val->CHR_DATE_ACC),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Asset No</label>
                                                    <input type="text" name="asset_no" style="width:110px;" class="form-control" value="<?php if($val->CHR_ASSET_NO != NULL && $val->CHR_ASSET_NO != ""){ echo $val->CHR_ASSET_NO; }?>">
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <!-- VP -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish VP</strong></label>
                                                    <input type="radio" class="icheck" name="flg_vp" value="1" <?php if($val->CHR_FLG_VP == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_vp" value="0" <?php if($val->CHR_FLG_VP == '0' || $val->CHR_FLG_VP == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_vp_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_VP_IN != NULL && $val->CHR_DATE_VP_IN != ""){ echo substr(trim($val->CHR_DATE_VP_IN),4,2) . '/' . substr(trim($val->CHR_DATE_VP_IN),6,2) . '/' . substr(trim($val->CHR_DATE_VP_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_vp" style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_VP == "1"){ echo substr(trim($val->CHR_DATE_VP),4,2) . '/' . substr(trim($val->CHR_DATE_VP),6,2) . '/' . substr(trim($val->CHR_DATE_VP),0,4); }?>">
                                                </div>
                                            </div>

                                            <!-- PRESDIR -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Presdir</strong></label>
                                                    <input type="radio" class="icheck" name="flg_presdir" value="1" <?php if($val->CHR_FLG_PRESDIR == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_presdir" value="0" <?php if($val->CHR_FLG_PRESDIR == '0' || $val->CHR_FLG_PRESDIR == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_presdir_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_PRESDIR_IN != NULL && $val->CHR_DATE_PRESDIR_IN != ""){ echo substr(trim($val->CHR_DATE_PRESDIR_IN),4,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR_IN),6,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_presdir" style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_PRESDIR == "1"){ echo substr(trim($val->CHR_DATE_PRESDIR),4,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR),6,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR),0,4); }?>">
                                                </div>
                                            </div>

                                            <!-- GUDTOOL -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Gudang</strong></label>
                                                    <input type="radio" class="icheck" name="flg_gudtool" value="1" <?php if($val->CHR_FLG_GUDTOOL == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_gudtool" value="0" <?php if($val->CHR_FLG_GUDTOOL == '0' || $val->CHR_FLG_GUDTOOL == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_gudtool_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_GUDTOOL_IN != NULL && $val->CHR_DATE_GUDTOOL_IN != ""){ echo substr(trim($val->CHR_DATE_GUDTOOL_IN),4,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL_IN),6,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_gudtool" style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_GUDTOOL == "1"){ echo substr(trim($val->CHR_DATE_GUDTOOL),4,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL),6,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL),0,4); }?>">
                                                </div>                                                
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">PR No</label>
                                                    <input type="text" name="pr_no" class="form-control" value="<?php if($val->CHR_PR_NO != NULL && $val->CHR_PR_NO != "") { echo trim($val->CHR_PR_NO);} ?>">
                                                </div>
                                            </div>

                                            <!-- PURCHASING -->
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Purch</strong></label>
                                                    <input type="radio" class="icheck" name="flg_purc" value="1" <?php if($val->CHR_FLG_PURC == '1'){ echo 'checked="true"';} ?>> &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_purc" value="0" <?php if($val->CHR_FLG_PURC == '0' || $val->CHR_FLG_PURC == NULL){ echo 'checked="true"';} ?>> &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_purc_in" style="width:110px;" class="datepicker" value="<?php if($val->CHR_DATE_PURC_IN != NULL && $val->CHR_DATE_PURC_IN != ""){ echo substr(trim($val->CHR_DATE_PURC_IN),4,2) . '/' . substr(trim($val->CHR_DATE_PURC_IN),6,2) . '/' . substr(trim($val->CHR_DATE_PURC_IN),0,4); }?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_purc" style="width:110px;" class="datepicker" value="<?php if($val->CHR_FLG_PURC == "1"){ echo substr(trim($val->CHR_DATE_PURC),4,2) . '/' . substr(trim($val->CHR_DATE_PURC),6,2) . '/' . substr(trim($val->CHR_DATE_PURC),0,4); }?>">
                                                </div>                                                
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">PO No</label>
                                                    <input type="text" name="po_no" class="form-control" value="<?php if($val->CHR_PO_NO != NULL && $val->CHR_PO_NO != "") { echo trim($val->CHR_PO_NO);} ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php }
                        //===== Modal ACC
                        foreach ($list_data as $val) { ?>                        
                        <div class="modal fade" id="modalUpdateAcc<?php echo $val->CHR_KODE_TRANSAKSI; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Progress Accounting - <?php echo $val->CHR_KODE_TRANSAKSI; ?></strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('budget/report_budget_c/update_progress/acc', 'class="form-horizontal"'); ?>

                                            <input name="KODE_TRANSAKSI" type="hidden" value="<?php echo trim($val->CHR_KODE_TRANSAKSI); ?>">
                                            <input name="FISCAL" value="<?php echo $fiscal_start; ?>" type="hidden">
                                            <input name="DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                            <input name="SECT" value="<?php echo $kode_sect; ?>" type="hidden">
                                            <input name="BUDGET_TYPE" value="<?php echo $bgt_type; ?>" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Finish Acc</label>
                                                <div class="col-sm-5">
                                                    <input type="radio" name="flg_acc" value="1"> &nbsp; Yes &nbsp;
                                                    <input type="radio" name="flg_acc" value="0" checked="true"> &nbsp; No
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date In (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_acc_in" class="datepicker" value="<?php if($val->CHR_DATE_ACC_IN != NULL && $val->CHR_DATE_ACC_IN != ""){ echo substr(trim($val->CHR_DATE_ACC_IN),4,2) . '/' . substr(trim($val->CHR_DATE_ACC_IN),6,2) . '/' . substr(trim($val->CHR_DATE_ACC_IN),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date Out (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_acc" class="datepicker" value="<?php if($val->CHR_DATE_ACC != NULL && $val->CHR_DATE_ACC != ""){ echo substr(trim($val->CHR_DATE_ACC),4,2) . '/' . substr(trim($val->CHR_DATE_ACC),6,2) . '/' . substr(trim($val->CHR_DATE_ACC),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Asset No</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="asset_no" class="form-control" value="<?php if($val->CHR_ASSET_NO != NULL && $val->CHR_ASSET_NO != ""){ echo $val->CHR_ASSET_NO; }?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php }
                        //===== Modal VP
                        foreach ($list_data as $val) { ?>                        
                        <div class="modal fade" id="modalUpdateVp<?php echo $val->CHR_KODE_TRANSAKSI; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Progress VP - <?php echo $val->CHR_KODE_TRANSAKSI; ?></strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('budget/report_budget_c/update_progress/vp', 'class="form-horizontal"'); ?>

                                            <input name="KODE_TRANSAKSI" type="hidden" value="<?php echo trim($val->CHR_KODE_TRANSAKSI); ?>">
                                            <input name="FISCAL" value="<?php echo $fiscal_start; ?>" type="hidden">
                                            <input name="DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                            <input name="SECT" value="<?php echo $kode_sect; ?>" type="hidden">
                                            <input name="BUDGET_TYPE" value="<?php echo $bgt_type; ?>" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Finish VP</label>
                                                <div class="col-sm-5">
                                                    <input type="radio" name="flg_vp" value="1"> &nbsp; Yes &nbsp;
                                                    <input type="radio" name="flg_vp" value="0" checked="true"> &nbsp; No
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date In (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_vp_in" class="datepicker" value="<?php if($val->CHR_DATE_VP_IN != NULL && $val->CHR_DATE_VP_IN != ""){ echo substr(trim($val->CHR_DATE_VP_IN),4,2) . '/' . substr(trim($val->CHR_DATE_VP_IN),6,2) . '/' . substr(trim($val->CHR_DATE_VP_IN),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date Out (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_vp" class="datepicker" value="<?php if($val->CHR_DATE_VP != NULL && $val->CHR_DATE_VP != ""){ echo substr(trim($val->CHR_DATE_VP),4,2) . '/' . substr(trim($val->CHR_DATE_VP),6,2) . '/' . substr(trim($val->CHR_DATE_VP),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <?php }
                        //===== Modal Presdir
                        foreach ($list_data as $val) { ?>                        
                        <div class="modal fade" id="modalUpdatePresdir<?php echo $val->CHR_KODE_TRANSAKSI; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Progress Presdir - <?php echo $val->CHR_KODE_TRANSAKSI; ?></strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('budget/report_budget_c/update_progress/presdir', 'class="form-horizontal"'); ?>

                                            <input name="KODE_TRANSAKSI" type="hidden" value="<?php echo trim($val->CHR_KODE_TRANSAKSI); ?>">
                                            <input name="FISCAL" value="<?php echo $fiscal_start; ?>" type="hidden">
                                            <input name="DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                            <input name="SECT" value="<?php echo $kode_sect; ?>" type="hidden">
                                            <input name="BUDGET_TYPE" value="<?php echo $bgt_type; ?>" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Finish VP</label>
                                                <div class="col-sm-5">
                                                    <input type="radio" name="flg_presdir" value="1"> &nbsp; Yes &nbsp;
                                                    <input type="radio" name="flg_presdir" value="0" checked="true"> &nbsp; No
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date In (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_presdir_in" class="datepicker" value="<?php if($val->CHR_DATE_PRESDIR_IN != NULL && $val->CHR_DATE_PRESDIR_IN != ""){ echo substr(trim($val->CHR_DATE_PRESDIR_IN),4,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR_IN),6,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR_IN),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date Out (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_presdir" class="datepicker" value="<?php if($val->CHR_DATE_PRESDIR != NULL && $val->CHR_DATE_PRESDIR != ""){ echo substr(trim($val->CHR_DATE_PRESDIR),4,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR),6,2) . '/' . substr(trim($val->CHR_DATE_PRESDIR),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <?php }
                        //===== Modal Gudtool
                        foreach ($list_data as $val) { ?>                        
                        <div class="modal fade" id="modalUpdateGudtool<?php echo $val->CHR_KODE_TRANSAKSI; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Progress Gudang Tool - <?php echo $val->CHR_KODE_TRANSAKSI; ?></strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('budget/report_budget_c/update_progress/gudtool', 'class="form-horizontal"'); ?>

                                            <input name="KODE_TRANSAKSI" type="hidden" value="<?php echo trim($val->CHR_KODE_TRANSAKSI); ?>">
                                            <input name="FISCAL" value="<?php echo $fiscal_start; ?>" type="hidden">
                                            <input name="DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                            <input name="SECT" value="<?php echo $kode_sect; ?>" type="hidden">
                                            <input name="BUDGET_TYPE" value="<?php echo $bgt_type; ?>" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Finish Gud Tool</label>
                                                <div class="col-sm-5">
                                                    <input type="radio" name="flg_gudtool" value="1"> &nbsp; Yes &nbsp;
                                                    <input type="radio" name="flg_gudtool" value="0" checked="true"> &nbsp; No
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date In (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_gudtool_in" class="datepicker" value="<?php if($val->CHR_DATE_GUDTOOL_IN != NULL && $val->CHR_DATE_GUDTOOL_IN != ""){ echo substr(trim($val->CHR_DATE_GUDTOOL_IN),4,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL_IN),6,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL_IN),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date Out (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_gudtool" class="datepicker" value="<?php if($val->CHR_DATE_GUDTOOL != NULL && $val->CHR_DATE_GUDTOOL != ""){ echo substr(trim($val->CHR_DATE_GUDTOOL),4,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL),6,2) . '/' . substr(trim($val->CHR_DATE_GUDTOOL),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">PR No</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="pr_no" class="form-control" value="<?php if($val->CHR_PR_NO != NULL && $val->CHR_PR_NO != "") { echo trim($val->CHR_PR_NO);} ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <?php }
                        //===== Modal Purc
                        foreach ($list_data as $val) { ?>                        
                        <div class="modal fade" id="modalUpdatePurc<?php echo $val->CHR_KODE_TRANSAKSI; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Progress Purchasing - <?php echo $val->CHR_KODE_TRANSAKSI; ?></strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('budget/report_budget_c/update_progress/purc', 'class="form-horizontal"'); ?>

                                            <input name="KODE_TRANSAKSI" type="hidden" value="<?php echo trim($val->CHR_KODE_TRANSAKSI); ?>">
                                            <input name="FISCAL" value="<?php echo $fiscal_start; ?>" type="hidden">
                                            <input name="DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                            <input name="SECT" value="<?php echo $kode_sect; ?>" type="hidden">
                                            <input name="BUDGET_TYPE" value="<?php echo $bgt_type; ?>" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Finish Purc</label>
                                                <div class="col-sm-5">
                                                    <input type="radio" name="flg_purc" value="1"> &nbsp; Yes &nbsp;
                                                    <input type="radio" name="flg_purc" value="0" checked="true"> &nbsp; No
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date In (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_purc_in" class="datepicker" value="<?php if($val->CHR_DATE_PURC_IN != NULL && $val->CHR_DATE_PURC_IN != ""){ echo substr(trim($val->CHR_DATE_PURC_IN),4,2) . '/' . substr(trim($val->CHR_DATE_PURC_IN),6,2) . '/' . substr(trim($val->CHR_DATE_PURC_IN),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date (mm/dd/yyyy)</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="date_purc" class="datepicker" value="<?php if($val->CHR_DATE_PURC_IN != NULL && $val->CHR_DATE_PURC_IN != ""){ echo substr(trim($val->CHR_DATE_PURC),4,2) . '/' . substr(trim($val->CHR_DATE_PURC),6,2) . '/' . substr(trim($val->CHR_DATE_PURC),0,4); }?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">PO No</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="po_no" class="form-control" value="<?php if($val->CHR_PO_NO != NULL && $val->CHR_PO_NO != "") { echo trim($val->CHR_PO_NO);} ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php }   ?>
                        <!-- END MODAL -->
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
    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 4
            }
        });
    });

    $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>