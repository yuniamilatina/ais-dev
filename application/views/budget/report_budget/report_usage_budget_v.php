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
                                        <?php if($role == '1' || $role == '2' || $role == '13' || $npk == '0483' || $npk == '0483a' || $npk == '7520' || $npk == '1582' || $npk == '3394' || $npk == '9692' || $npk == '3333') { ?>
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
                                    <!-- <th rowspan='2' align='center'>Budget Plan</th>                                     -->
                                    <th rowspan='2' align='center'>Remark</th>
                                    <th rowspan='2' align='center'>Quantity</th>
                                    <th rowspan='2' align='center'>Unit</th>
                                    <th rowspan='2' align='center'>Amount/Unit</th>
                                    <th rowspan='2' align='center'>Total Amount</th>
                                    <th rowspan='2' align='center'>Trans Date</th>
                                    <th rowspan='2' align='center'>Est. Date</th>
                                    <th rowspan='2' align='center'>Stat GR</th>
                                    <th rowspan='2' align='center'>Date GR</th>
                                    <th colspan='3' align='center'>Manager 
                                        <a onclick="show_modal('mgr');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit Manager"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('mgr');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit Manager"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <th colspan='3' align='center'>Group Man 
                                        <a onclick="show_modal('gm');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit GM"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('gm');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit GM"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <th colspan='3' align='center'>Director 
                                        <a onclick="show_modal('dir');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit Director"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('dir');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit Director"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <?php
                                        if($bgt_type == 'CAPEX'){
                                    ?>
                                    <th colspan='4' align='center'>Accounting 
                                        <a onclick="show_modal('acc');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit Acc"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('acc');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit Acc"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <?php
                                        } 
                                    ?>
                                    <th colspan='3' align='center'>Vice Pres 
                                        <a onclick="show_modal('vp');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit VP"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('vp');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit VP"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <th colspan='3' align='center'>Pres Dir 
                                        <a onclick="show_modal('presdir');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit Presdir"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('presdir');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit Presdir"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <th colspan='4' align='center'>Gudang Tool 
                                        <a onclick="show_modal('gudtool');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit Gudang"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('gudtool');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit Gudang"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <th colspan='4' align='center'>Purchasing 
                                        <a onclick="show_modal('purc');" data-toggle="modal" data-target="#modalEdit" class="label label-warning" title="Edit Purchasing"><span class="fa fa-pencil"></span></a>
                                        <!-- <a onclick="edit_batch('purc');" data-toggle="tooltip" class="label label-warning" data-placement="top" title="Edit Purchasing"><span class="fa fa-pencil"></span></a> -->
                                    </th>
                                    <?php //if($role == '1'){ ?>
                                    <!-- <th rowspan='2' align='center'>Action</th> -->
                                    <?php //} ?>
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
                                        // echo "<td align='right'>" . number_format($isi->MON_AMOUNT_BUDGET,0,',','.') . "</td>";                                             
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
                                                                WHERE (BEDNR LIKE '%$isi->CHR_KODE_TRANSAKSI%') AND ((TXZ01 LIKE '%$part%') OR (TXT50 LIKE '%$part%'))")->row();
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
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('mgr', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Manager"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_MAN_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_MAN ."</td>";                                            
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('mgr', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Manager"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_MAN_IN ."</td>";                                            
                                            echo "<td align='center'></td>";
                                        }   

                                        //===== App GM
                                        if ($isi->CHR_FLG_APPROVE_GM == '1'){
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('gm', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit GM"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GM_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GM ."</td>";                                            
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('gm', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit GM"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GM_IN ."</td>";
                                            echo "<td align='center'></td>";                                            
                                        }

                                        //===== App DIR
                                        if ($isi->CHR_FLG_APPROVE_BOD == '1'){
                                            $amo_pr_approved = $amo_pr_approved + $isi->MON_TOTAL_PRICE_SUPPLIER;
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('dir', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Director"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_BOD_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_BOD ."</td>";                                            
                                        } else {
                                            $amo_pr_process = $amo_pr_process + $isi->MON_TOTAL_PRICE_SUPPLIER;
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('dir', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Director"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_BOD_IN ."</td>";
                                            echo "<td align='center'></td>";                                            
                                        }

                                        
                                        //===== Accouting Asset
                                        if($bgt_type == 'CAPEX'){
                                            if ($isi->CHR_FLG_ACC == '1'){
                                                echo "<td align='center'>" ?> <a onclick="edit_progress_v2('acc', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Acc"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                                echo "<td align='center'>". $isi->CHR_DATE_ACC_IN ."</td>";
                                                echo "<td align='center'>". $isi->CHR_DATE_ACC ."</td>";
                                                echo "<td align='center'>". $isi->CHR_ASSET_NO ."</td>";
                                            } else {
                                                echo "<td align='center'>" ?> <a onclick="edit_progress_v2('acc', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Acc"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                                echo "<td align='center'>". $isi->CHR_DATE_ACC_IN ."</td>";
                                                echo "<td align='center'></td>";
                                                echo "<td align='center'></td>";
                                            }
                                        }
                                        
                                        //===== App VP
                                        if ($isi->CHR_FLG_VP == '1'){                                            
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('vp', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit VP"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_VP_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_VP ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('vp', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit VP"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_VP_IN ."</td>";
                                            echo "<td align='center'></td>";
                                        }
                                        
                                        //===== App Pres Dir
                                        if ($isi->CHR_FLG_PRESDIR == '1'){ 
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('presdir', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Presdir"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PRESDIR_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PRESDIR ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('presdir', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Presdir"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PRESDIR_IN ."</td>";
                                            echo "<td align='center'></td>";
                                        }
                                        
                                        //===== Gudang Tool
                                        if ($isi->CHR_FLG_GUDTOOL == '1'){ 
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('gudtool', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Gudang"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GUDTOOL_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GUDTOOL ."</td>";
                                            echo "<td align='center'>". $isi->CHR_PR_NO ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('gudtool', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Gudang"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_GUDTOOL_IN ."</td>";
                                            echo "<td align='center'></td>";
                                            echo "<td align='center'></td>";
                                        }

                                        //===== Purchasing
                                        if ($isi->CHR_FLG_PURC == '1'){ 
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('purc', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Purchasing"><?php echo "<img src='" . base_url() . "/assets/img/check1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PURC_IN ."</td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PURC ."</td>";
                                            echo "<td align='center'>". $isi->CHR_PO_NO ."</td>";
                                        } else {
                                            echo "<td align='center'>" ?> <a onclick="edit_progress_v2('purc', '<?php echo $isi->CHR_KODE_TRANSAKSI; ?>');" data-toggle="tooltip" title="Edit Purchasing"><?php echo "<img src='" . base_url() . "/assets/img/error1.png' width='25'></a></td>";
                                            echo "<td align='center'>". $isi->CHR_DATE_PURC_IN ."</td>";
                                            echo "<td align='center'></td>";
                                            echo "<td align='center'></td>";
                                        }
                                        ?>     
                                        <?php //if($role == '1'){ ?>  
                                            <!-- <td style="text-align:center;"> -->
                                                <!-- <a data-toggle="modal" data-target="#modalUpdateAcc" class="label label-warning" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a> -->
                                                <!-- <input type="checkbox" class='icheck' id="check_<?php //echo $isi->CHR_KODE_TRANSAKSI; ?>" name="<?php //echo $isi->CHR_KODE_TRANSAKSI; ?>" value="1"> -->
                                            <!-- </td>                                     -->
                                            <!-- <td align='center'>
                                                <a onclick="edit_progress('<?php //echo $isi->CHR_KODE_TRANSAKSI; ?>')" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit" <?php //echo $isi->CHR_KODE_TRANSAKSI; ?>><span class="fa fa-pencil"></span></a>
                                            </td> -->
                                        <?php //} ?>
                                        <?php                                
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
                        <!-- START MODAL -->                         
                        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Approval Progress</strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('budget/report_budget_c/update_progress_all', 'class="form-horizontal"'); ?>

                                            <input name="FISCAL" value="<?php echo $fiscal_start; ?>" type="hidden">
                                            <input name="DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                            <input name="SECT" value="<?php echo $kode_sect; ?>" type="hidden">
                                            <input name="BUDGET_TYPE" value="<?php echo $bgt_type; ?>" type="hidden">
                                            <input name="STEP" id="step" value="" type="hidden">
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><strong>Approval Sheet No</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="KODE_TRANSAKSI[]" multiple id="e2" class="form-control" style="width:300px">';
        
                                                    <?php foreach ($list_pr_no as $pr) { ?>
                                                        <option value="<?php echo $pr->CHR_KODE_TRANSAKSI; ?>"><?php echo $pr->CHR_KODE_TRANSAKSI; ?></option>
                                                    <?php } ?>
        
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- MANAGER -->
                                            <div class="form-group" id="mgr" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish MGR</strong></label>
                                                    <input type="radio" class="icheck" disabled name="flg_mgr" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" disabled name="flg_mgr" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_mgr_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_mgr" disabled style="width:110px;" class="datepicker" value="">
                                                </div>
                                            </div>

                                            <!-- GROUP MANAGER -->
                                            <div class="form-group" id="gm" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish GM</strong></label>
                                                    <input type="radio" class="icheck" disabled name="flg_gm" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" disabled name="flg_gm" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_gm_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_gm" disabled style="width:110px;" class="datepicker" value="">
                                                </div>
                                            </div>

                                            <!-- GROUP DIREKTUR -->
                                            <div class="form-group" id="dir" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish DIR</strong></label>
                                                    <input type="radio" class="icheck" disabled name="flg_dir" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" disabled name="flg_dir" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_dir_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_dir" disabled style="width:110px;" class="datepicker" value="">
                                                </div>
                                            </div>

                                            <?php //if($bgt_type == 'CAPEX'){ ?>
                                            <!-- ACCOUNTING -->
                                            <div class="form-group" id="acc" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Acc</strong></label>
                                                    <input type="radio" class="icheck" name="flg_acc" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_acc" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_acc_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_acc" style="width:110px;" class="datepicker" value="">
                                                </div>
                                            </div>
                                            <?php //} ?>

                                            <!-- VP -->
                                            <div class="form-group" id="vp" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish VP</strong></label>
                                                    <input type="radio" class="icheck" name="flg_vp" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_vp" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_vp_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_vp" style="width:110px;" class="datepicker" value="">
                                                </div>
                                            </div>

                                            <!-- PRESDIR -->
                                            <div class="form-group" id="presdir" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Presdir</strong></label>
                                                    <input type="radio" class="icheck" name="flg_presdir" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_presdir" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_presdir_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_presdir" style="width:110px;" class="datepicker" value="">
                                                </div>
                                            </div>

                                            <!-- GUDTOOL -->
                                            <div class="form-group" id="gudtool" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Gudang</strong></label>
                                                    <input type="radio" class="icheck" name="flg_gudtool" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_gudtool" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_gudtool_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_gudtool" style="width:110px;" class="datepicker" value="">
                                                </div>
                                            </div>

                                            <!-- PURCHASING -->
                                            <div class="form-group" id="purc" style="display:none;">
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label"><strong>Finish Purch</strong></label>
                                                    <input type="radio" class="icheck" name="flg_purc" value="1" > &nbsp; Yes &nbsp;
                                                    <input type="radio" class="icheck" name="flg_purc" value="0" > &nbsp; No
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date In</label>
                                                    <input type="text" name="date_purc_in" style="width:110px;" class="datepicker" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-sm-2 control-label">Date Out</label>
                                                    <input type="text" name="date_purc" style="width:110px;" class="datepicker" value="">
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

                        <div id="modalUpdateBatch" class="modal" align="center" style="display: none;">
                        </div>

                        <div id="modalEditProgress" class="modal" align="center" style="display: none;">
                        </div>
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
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 4
                //,rightColumns: 1
            }
        });
    });

    // function edit_progress(pr_code) {
    //     var type_bgt = '<?php //echo $bgt_type; ?>';
    //     var fy = '<?php //echo $fiscal_start; ?>';
    //     var dept = '<?php //echo $kode_dept; ?>';
    //     var sect = '<?php //echo $kode_sect; ?>';

    //     $.ajax({
    //         async: false,
    //         type: "POST",
    //         url: "<?php //echo site_url('budget/report_budget_c/edit_progress'); ?>",
    //         data: "id_pr=" + pr_code + "&id_type=" + type_bgt + "&id_fy=" + fy + "&id_dept=" + dept + "&id_sect=" + sect,
    //         success: function (data) {
    //             // alert(data);     
    //             document.getElementById("modalEditProgress").style.display = "block"; 
    //             $("#modalEditProgress").html(data);
    //         }
    //     });
    // }    

    function hide_edit_progress() {
        document.getElementById("modalEditProgress").style.display = "none"; 
    }

    function edit_progress_v2(step, pr_code) {
        var type_bgt = '<?php echo $bgt_type; ?>';
        var fy = '<?php echo $fiscal_start; ?>';
        var dept = '<?php echo $kode_dept; ?>';
        var sect = '<?php echo $kode_sect; ?>';

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/report_budget_c/edit_progress_v2'); ?>",
            data: "id_step=" + step + "&id_pr=" + pr_code + "&id_type=" + type_bgt + "&id_fy=" + fy + "&id_dept=" + dept + "&id_sect=" + sect,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalEditProgress").style.display = "block"; 
                $("#modalEditProgress").html(data);
            }
        });
    } 

    // function hide_edit_batch() {
    //     document.getElementById("modalUpdateBatch").style.display = "none"; 
    // }

    // function edit_batch(step) {
    //     var type_bgt = '<?php //echo $bgt_type; ?>';
    //     var fy = '<?php //echo $fiscal_start; ?>';
    //     var dept = '<?php //echo $kode_dept; ?>';
    //     var sect = '<?php //echo $kode_sect; ?>';

    //     $.ajax({
    //         async: false,
    //         type: "POST",
    //         url: "<?php //echo site_url('budget/report_budget_c/edit_batch'); ?>",
    //         data: "id_step=" + step + "&id_type=" + type_bgt + "&id_fy=" + fy + "&id_dept=" + dept + "&id_sect=" + sect,
    //         success: function (data) {
    //             // alert(data);     
    //             document.getElementById("modalUpdateBatch").style.display = "block"; 
    //             $("#modalUpdateBatch").html(data);
    //         }
    //     });
    // } 

    function show_modal(proc) {
        if(proc == 'mgr'){
            document.getElementById("mgr").style.display = "block"; 
            document.getElementById("gm").style.display = "none"; 
            document.getElementById("dir").style.display = "none"; 
            document.getElementById("acc").style.display = "none"; 
            document.getElementById("vp").style.display = "none"; 
            document.getElementById("presdir").style.display = "none"; 
            document.getElementById("gudtool").style.display = "none"; 
            document.getElementById("purc").style.display = "none"; 

            document.getElementById("step").value = "mgr";
        } else if(proc == 'gm'){
            document.getElementById("mgr").style.display = "none"; 
            document.getElementById("gm").style.display = "block"; 
            document.getElementById("dir").style.display = "none"; 
            document.getElementById("acc").style.display = "none"; 
            document.getElementById("vp").style.display = "none"; 
            document.getElementById("presdir").style.display = "none"; 
            document.getElementById("gudtool").style.display = "none"; 
            document.getElementById("purc").style.display = "none"; 

            document.getElementById("step").value = "gm";
        } else if(proc == 'dir'){
            document.getElementById("mgr").style.display = "none"; 
            document.getElementById("gm").style.display = "none"; 
            document.getElementById("dir").style.display = "block"; 
            document.getElementById("acc").style.display = "none"; 
            document.getElementById("vp").style.display = "none"; 
            document.getElementById("presdir").style.display = "none"; 
            document.getElementById("gudtool").style.display = "none"; 
            document.getElementById("purc").style.display = "none"; 

            document.getElementById("step").value = "dir";
        } else if(proc == 'acc'){
            document.getElementById("mgr").style.display = "none"; 
            document.getElementById("gm").style.display = "none"; 
            document.getElementById("dir").style.display = "none"; 
            document.getElementById("acc").style.display = "block"; 
            document.getElementById("vp").style.display = "none"; 
            document.getElementById("presdir").style.display = "none"; 
            document.getElementById("gudtool").style.display = "none"; 
            document.getElementById("purc").style.display = "none"; 

            document.getElementById("step").value = "acc";
        } else if(proc == 'vp'){
            document.getElementById("mgr").style.display = "none"; 
            document.getElementById("gm").style.display = "none"; 
            document.getElementById("dir").style.display = "none"; 
            document.getElementById("acc").style.display = "none"; 
            document.getElementById("vp").style.display = "block"; 
            document.getElementById("presdir").style.display = "none"; 
            document.getElementById("gudtool").style.display = "none"; 
            document.getElementById("purc").style.display = "none"; 

            document.getElementById("step").value = "vp";
        } else if(proc == 'presdir'){
            document.getElementById("mgr").style.display = "none"; 
            document.getElementById("gm").style.display = "none"; 
            document.getElementById("dir").style.display = "none"; 
            document.getElementById("acc").style.display = "none"; 
            document.getElementById("vp").style.display = "none"; 
            document.getElementById("presdir").style.display = "block"; 
            document.getElementById("gudtool").style.display = "none"; 
            document.getElementById("purc").style.display = "none"; 

            document.getElementById("step").value = "presdir";
        } else if(proc == 'gudtool'){
            document.getElementById("mgr").style.display = "none"; 
            document.getElementById("gm").style.display = "none"; 
            document.getElementById("dir").style.display = "none"; 
            document.getElementById("acc").style.display = "none"; 
            document.getElementById("vp").style.display = "none"; 
            document.getElementById("presdir").style.display = "none"; 
            document.getElementById("gudtool").style.display = "block"; 
            document.getElementById("purc").style.display = "none"; 

            document.getElementById("step").value = "gudtool";
        } else if(proc == 'purc'){
            document.getElementById("mgr").style.display = "none"; 
            document.getElementById("gm").style.display = "none"; 
            document.getElementById("dir").style.display = "none"; 
            document.getElementById("acc").style.display = "none"; 
            document.getElementById("vp").style.display = "none"; 
            document.getElementById("presdir").style.display = "none"; 
            document.getElementById("gudtool").style.display = "none"; 
            document.getElementById("purc").style.display = "block"; 

            document.getElementById("step").value = "purc";
        } 
    }

    $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>