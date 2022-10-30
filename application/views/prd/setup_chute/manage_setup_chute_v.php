<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/setup_chute_c') ?>"><strong>Manage Setup Chute</strong></a></li>
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
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>MANAGE SETUP CHUTE</strong></span>
                        <div class="pull-right grid-tools">
                            <?php if ($role == '1' || $role == '14' || $role == '69' || $role == '26' || ($role == '16' && substr($work_center, 0, 2) != 'AS') || ($role == '17' && substr($work_center, 0, 2) != 'AS')) { //For ROLE 
                            ?>
                                <a href="<?php echo base_url('index.php/prd/setup_chute_c/rearrange_setup_chute/0/' . $id_dept . '/' . trim($work_center)) ?>" class="btn btn-info" data-placement="left" data-toggle="tooltip" title="Rearrange Chute" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;"><i class="fa fa-sort-numeric-asc"></i> Rearrange</a>
                                <a href="<?php echo base_url('index.php/prd/setup_chute_c/create_special_order/0/' . $id_dept . '/' . trim($work_center)) ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Create Special Order" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;"><i class="fa fa-certificate"></i> Create SO</a>
                            <?php } ?>
                            <!--                            <a href="<?php echo base_url('index.php/prd/setup_chute_c/dandory_oneway') ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Kanban" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Dandory</a>
                            <a href="<?php echo base_url('index.php/prd/setup_chute_c/print_kanban') ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Kanban" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Scan</a>
                            <a href="<?php echo base_url('index.php/prd/setup_chute_c/reprint_kanban') ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Reprint Kanban" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Reprint</a>-->
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php //echo form_open('prd/setup_chute_c/search_setup_chute', 'class="form-horizontal"'); 
                        ?>
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Dept / Work Center</td>
                                    <!-- USING BUTTON FILTER -->
                                    <!-- <td width="5%">
                                        <select class="ddl" style="width:120px;" name="INT_ID_DEPT" id="dept_to_work_center" onchange="get_data_work_center(); document.getElementById('dept_id').value=this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                <option value="<?php echo trim($row->INT_ID_DEPT); ?>"  <?php
                                                                                                        if ($id_dept == trim($row->INT_ID_DEPT)) {
                                                                                                            echo 'selected';
                                                                                                        }
                                                                                                        ?> > <?php echo trim($row->CHR_DEPT); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td> -->
                                    <!-- USING DIRECT LINK FILTER -->
                                    <td width="5%">
                                        <select class="ddl" style="width:180px;" onChange="document.location.href = this.options[this.selectedIndex].value;" <?php if ($role != 1 && $role != 14 && $role != 69 && $role != 26 && $role != 22 && $role != 12) {
                                                                                                                                                                    echo "disabled";
                                                                                                                                                                } ?>>
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                <option value="<?php echo site_url('prd/setup_chute_c/search_setup_chute/0/' . trim($row->INT_ID_DEPT)); ?>" <?php
                                                                                                                                                                if ($id_dept == trim($row->INT_ID_DEPT)) {
                                                                                                                                                                    echo 'selected';
                                                                                                                                                                }
                                                                                                                                                                ?>> <?php echo trim($row->CHR_DEPT); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <!-- USING BUTTON FILTER -->
                                    <!-- <td width="5%">
                                        <select class="ddl" style="width:120px;" id="work_center" name="CHR_WORK_CENTER" onchange="document.getElementById('work_center_id').value=this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo ($row->CHR_WORK_CENTER); ?>"  <?php
                                                                                                        if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                                                                            echo 'selected';
                                                                                                        }
                                                                                                        ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td> -->
                                    <!-- USING DIRECT LINK FILTER -->
                                    <td width="5%">
                                        <select class="ddl" style="width:120px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('prd/setup_chute_c/search_setup_chute/0/' . $id_dept . '/' . trim($row->CHR_WORK_CENTER)); ?>" <?php
                                                                                                                                                                                    if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                                                                                                                                                        echo 'selected';
                                                                                                                                                                                    }
                                                                                                                                                                                    ?>> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                </tr>
                                <tr>
                                    <td width="5%">Status Prod</td>
                                    <!-- USING BUTTON FILTER -->
                                    <!-- <td width="5%">
                                        <select class="ddl" style="width:120px;" id="status_prod" name="CHR_STATUS_PROD" onchange="document.getElementById('status_id').value=this.options[this.selectedIndex].value;">
                                            <option value="0" <?php if ($status == 0) {
                                                                    echo 'selected';
                                                                } ?>>Waiting Prod</option>
                                            <option value="1" <?php if ($status == 1) {
                                                                    echo 'selected';
                                                                } ?>>Already Prod</option>
                                            <option value="2" <?php if ($status == 2) {
                                                                    echo 'selected';
                                                                } ?>>Uncomplete Prod</option>
                                        </select>
                                    </td> -->
                                    <!-- USING DIRECT LINK FILTER -->
                                    <td width="5%">
                                        <select class="ddl" style="width:180px;" id="work_center" name="CHR_WORK_CENTER" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?php echo site_url('prd/setup_chute_c/search_setup_chute/0/' . $id_dept . '/' . $work_center . '/0'); ?>" <?php if ($status == 0) {
                                                                                                                                                                            echo 'selected';
                                                                                                                                                                        } ?>>Waiting Prod</option>
                                            <option value="<?php echo site_url('prd/setup_chute_c/search_setup_chute/0/' . $id_dept . '/' . $work_center . '/1'); ?>" <?php if ($status == 1) {
                                                                                                                                                                            echo 'selected';
                                                                                                                                                                        } ?>>Already Prod</option>
                                            <option value="<?php echo site_url('prd/setup_chute_c/search_setup_chute/0/' . $id_dept . '/' . $work_center . '/2'); ?>" <?php if ($status == 2) {
                                                                                                                                                                            echo 'selected';
                                                                                                                                                                        } ?>>Uncomplete Prod</option>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4">
                                        <!-- <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td> -->
                                    </td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                </tr>
                            </table>
                        </div>
                        <?php //echo form_close(); 
                        ?>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Prod Order No</th>
                                    <th style="text-align:center;">Part No AII</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Dandori Group</th>
                                    <th style="text-align:center;">Part No Customer</th>
                                    <!-- <th style="text-align:center;">Date</th> -->
                                    <th style="text-align:center;">Stock ELINA</th>
                                    <th style="text-align:center;">Lot Size</th>
                                    <th style="text-align:center;">Qty/Box</th>
                                    <th style="text-align:center;">Total Qty</th>
                                    <th style="text-align:center;">Status Prepare</th>                                    
                                    <th style="text-align:center;">Act Lot Size</th>
                                    <th style="text-align:center;">Act Qty</th>
                                    <th style="text-align:center;">Act Qty Ecer</th>
                                    <th style="text-align:center;">Act Total Qty</th>
                                    <th style="text-align:center;">Remain Qty</th>
                                    <th style="text-align:center;">Stock SAP</th>
                                    <th style="text-align:center;">Special Order</th>
                                    <?php if ($role == '1' || $role == '14' || $role == '69' || ($role == '17' && substr($work_center, 0, 2) != 'AS')) { //Fore ROLE 
                                    ?>
                                        <th style="text-align:center;">Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $last_seq = 0;
                                foreach ($data as $isi) {
                                    if ($isi->INT_FLG_SO == 1) {
                                        if($isi->INT_CAVITY > 0 && $isi->INT_CAVITY != $isi->INT_ID){
                                            echo "<tr class='gradeX' style='color:blue;'>";
                                        } else {
                                            echo "<tr class='gradeX' style='color:red;'>";
                                        }                                        
                                    } else {
                                        echo "<tr class='gradeX'>";
                                    }

                                    $cek_prepare = $this->db->query("select CHR_FLAG from PRD.TT_ELINA_H where CHR_PRD_ORDER_NO = '$isi->CHR_PRD_ORDER_NO'");
                                    if ($cek_prepare->num_rows() > 0) {
                                        $stat_prep = $cek_prepare->row()->CHR_FLAG;
                                        if ($stat_prep == 1) {
                                            $color = 'background:yellow;color:#fff;'; //Not Yet/Wait Order OH/IH
                                        } else if ($stat_prep == 2) {
                                            $color = 'background:orange;color:#fff;'; //Stock OK/Progress OH
                                        } else if ($stat_prep == 3) {
                                            if ($isi->INT_SEQUENCE == 0) {
                                                if ($status == 1) {
                                                    $color = 'background:grey;color:#fff;'; //Finish Prod
                                                } else {
                                                    $color = 'background:#8A2BE2;color:#fff;'; //On Prod
                                                }
                                            } else {
                                                $color = 'background:#0066ff;color:#fff;'; //Ready to Pickup OH
                                            }
                                        } else if ($stat_prep == 4) {
                                            $color = 'background:orangered;color:#fff;'; //On Prepare IH
                                        } else if ($stat_prep == 5) {
                                            if ($isi->INT_SEQUENCE == 0) {
                                                if ($status == 1) {
                                                    $color = 'background:grey;color:#fff;'; //Finish Prod
                                                } else {
                                                    $color = 'background:#8A2BE2;color:#fff;'; //On Prod
                                                }
                                            } else {
                                                $color = 'background:#33cc33;color:#fff;'; //Finish Prepare
                                            }
                                        } else if ($stat_prep == 6) {
                                            $color = 'background:#8A2BE2;color:#fff;'; //On Prod
                                        } else if ($stat_prep == 7) {
                                            $color = 'background:grey;color:#fff;'; //Finish Prod
                                        } else if ($stat_prep == 8) {
                                            $color = 'background:blue;color:#fff;'; //Uncomplete prod
                                        } else if ($stat_prep == 9) {
                                            $color = 'background:red;color:#fff;'; //Shortage Material
                                        } else if ($stat_prep == 'X') {
                                            $color = 'background:red;color:#fff;'; //Shortage Material
                                        } else {
                                            $color = '';
                                        }
                                    } else {
                                        $color = '';
                                    }

                                    echo "<td style='$color'>$isi->INT_SEQUENCE</td>";
                                    $recycle = "";
                                    if ($isi->INT_FLG_RECOVERY == 1) {
                                        $recycle = "<span style='color:blue;width:10px;' data-toggle='tooltip' title='Recovery " . $isi->INT_RECOVERY . " Origin:" . substr($isi->CHR_PRD_ORDER_NO_REFF, 0, 19) . "  Parent:" . substr($isi->CHR_PRD_ORDER_NO_REFF, 20, 19) . "' class='fa fa-recycle'></span>";
                                    }
                                    echo "<td>" . $isi->CHR_PRD_ORDER_NO . $recycle . "</td>";

                                    $cavity = "";
                                    if(substr($work_center,0,1) == 'P'){
                                        if($isi->INT_CAVITY > 0 && $isi->INT_CAVITY != $isi->INT_ID){
                                            $cav_mate = $this->db->query("select CHR_PART_NO, CHR_PRD_ORDER_NO from PRD.TT_SETUP_CHUTE where INT_ID = '$isi->INT_CAVITY'")->row();
                                            $cavity = "<span style='color:blue;width:10px;' data-toggle='tooltip' title='Cavity " . $cav_mate->CHR_PRD_ORDER_NO . "' class='fa fa-chain'></span>";
                                        }
                                    }

                                    $over = "";
                                    $check_over = $this->db->query("select CHR_PART_NO, CHR_NOTES from PRD.TT_PARTS_OVERSTOCK where CHR_PART_NO = '$isi->CHR_PART_NO' AND INT_FLG_DELETE = '0'");
                                    if($check_over->num_rows() > 0){
                                        $over = "<span style='color:red;width:10px;' data-toggle='tooltip' title='Overstock " . $check_over->row()->CHR_NOTES . "' class='fa fa-cubes'></span>";
                                    }

                                    echo "<td style='text-align:center;'>" . $isi->CHR_PART_NO . " " . $cavity . " " . $over . "</td>";
                                    $part_no_cust = $this->db->query("select distinct CHR_CUS_PART_NO from TM_SHIPPING_PARTS where CHR_PART_NO = '$isi->CHR_PART_NO'")->result();
                                    $part_no_cust_value = "";
                                    if (count($part_no_cust) > 0) {
                                        foreach ($part_no_cust as $key => $value) {
                                            $part_no_cust_value .= $value->CHR_CUS_PART_NO;
                                            if ($key <> count($part_no_cust) - 1) {
                                                $part_no_cust_value .= " | ";
                                            }
                                        }
                                    }

                                    $back_no = $this->db->query("select distinct CHR_BACK_NO from TM_KANBAN where CHR_PART_NO = '$isi->CHR_PART_NO'")->row();
                                    //===== ADDITIONAL FUNCTION TO CHECK POS LINE & POS MATERIAL --- BY ANU 20191212 =====//
                                    $warning = "";
                                    $pos_no = "";
                                    $cek_pos = $this->db->query("select CHR_POS_PRD from PRD.TM_POS where CHR_WORK_CENTER = '$work_center' and CHR_PART_NO = '$isi->CHR_PART_NO' and INT_FLG_DEL = '0' ORDER BY CHR_POS_PRD ASC");
                                    if ($cek_pos->num_rows() == 0) {
                                        $warning = "<span style='color:red;' data-toggle='tooltip' title='Pos Line Not Found' class='fa fa-warning'></span>";
                                    } else {
                                        $p = 1;
                                        $last_pos = $cek_pos->num_rows();
                                        foreach ($cek_pos->result() as $pos) {
                                            if ($p < $last_pos) { //===== LAST POS BIASANYA PACKING, JADI TIDAK ADA DI POS MATERIAL
                                                $cek_bom_pos = $this->db->query("select count(INT_ID) as ROW from PRD.TM_POS_MATERIAL where CHR_WORK_CENTER = '$work_center' and CHR_PART_NO_FG = '$isi->CHR_PART_NO' and CHR_POS_PRD = '$pos->CHR_POS_PRD'")->row();
                                                if ($cek_bom_pos->ROW == 0) {
                                                    $pos_no .= " " . $pos->CHR_POS_PRD;
                                                    $warning = "<span style='color:orange;' data-toggle='tooltip' title='BOM Pos" . $pos_no . " Not Found' class='fa fa-warning'></span>";
                                                }
                                            }
                                            $p++;
                                        }
                                    }
                                    //===== END ADDITIONAL FUNCTION TO CHECK POS LINE & POS MATERIAL --- BY ANU 20191212 =====//

                                    echo "<td style='text-align:center;'>" . $back_no->CHR_BACK_NO . " " . $warning . "</td>";
                                    if ($isi->CHR_MATRIX_DANDORI == NULL) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'><strong>$isi->CHR_MATRIX_DANDORI</strong></td>";
                                    }

                                    $cek_add_info = $this->db->query("select CHR_KANBAN_ADDITIONAL_INFO from PRD.TM_KANBAN_ADDITIONAL_INFO where CHR_PART_NO = '$isi->CHR_PART_NO' and INT_FLAG_DELETE <> '1'");
                                    if($cek_add_info->num_rows() > 0){
                                        $add_info = $cek_add_info->row()->CHR_KANBAN_ADDITIONAL_INFO;
                                        $part_no_cust_value = $part_no_cust_value . ' (' . $add_info . ')';
                                    } 
                                    echo "<td style='text-align:center;'>$part_no_cust_value</td>";
                                    // echo "<td style='text-align:center;'>" . date('d-m-Y', strtotime($isi->CHR_DATE)) . "</td>";


                                    //if($isi->INT_SEQUENCE <= 5){
                                    if ($cek_prepare->num_rows() > 0) {
                                        $cek_stock = $this->db->query("select CHR_PART_NO from PRD.TT_ELINA_L where CHR_PRD_ORDER_NO = '$isi->CHR_PRD_ORDER_NO' and CHR_FLAG_STOCK = 'F'");
                                        if ($cek_stock->num_rows() > 0) {
                                            echo "<td style='text-align:center;font-weight:bold;'><a data-toggle='modal'data-target='#modalShortage" . $isi->INT_ID . "'>Shortage (" . $cek_stock->num_rows() . ") </a></td>";
                                        } else {
                                            echo "<td style='text-align:center;font-weight:bold;'>OK</td>";
                                        }
                                    } else {
                                        echo "<td style='text-align:center;font-weight:bold;'>-</td>";
                                    }
                                    //} 

                                    echo "<td style='text-align:center;'>$isi->INT_LOT_SIZE</td>";
                                    echo "<td style='text-align:center;'>$isi->INT_QTY_PER_BOX</td>";
                                    echo "<td style='text-align:center;'>$isi->INT_QTY_PCS</td>";

                                    //if($isi->INT_SEQUENCE <= 5){
                                    //    $cek_prepare = $this->db->query("select CHR_FLAG from PRD.TT_ELINA_H where CHR_PRD_ORDER_NO = '$isi->CHR_PRD_ORDER_NO'");
                                    if ($cek_prepare->num_rows() > 0) {
                                        $stat_prep = $cek_prepare->row()->CHR_FLAG;
                                        if ($stat_prep == 1) {
                                            echo "<td style='text-align:center;font-weight:bold;'>Not Yet</a></td>";
                                        } else if ($stat_prep == 2) {
                                            echo "<td style='text-align:center;font-weight:bold;'>Progress OH</a></td>";
                                        } else if ($stat_prep == 3) {
                                            echo "<td style='text-align:center;font-weight:bold;'>Finish OH</a></td>";
                                        } else if ($stat_prep == 4) {
                                            echo "<td style='text-align:center;font-weight:bold;'>Progress IH</a></td>";
                                        } else if ($stat_prep == 5) {
                                            echo "<td style='text-align:center;font-weight:bold;'>Finish Prep</a></td>";
                                        } else if ($stat_prep == 6) {
                                            echo "<td style='text-align:center;font-weight:bold;'>On Prod</a></td>";
                                        } else if ($stat_prep == 7) {
                                            echo "<td style='text-align:center;font-weight:bold;'>Finish Prod</a></td>";
                                        } else if ($stat_prep == 8) {
                                            echo "<td style='text-align:center;font-weight:bold;'>Uncomplete Prod</a></td>";
                                        } else {
                                            echo "<td style='text-align:center;font-weight:bold;'>-</td>";
                                        }
                                    } else {
                                        echo "<td style='text-align:center;font-weight:bold;'>-</td>";
                                    }
                                    //} else {
                                    //    echo "<td style='text-align:center;font-weight:bold;'>-</td>";
                                    //}                                    

                                    $act_lot = $isi->INT_LOT_SIZE - $isi->INT_LOT_SIZE_ACTUAL;
                                    $act_qty = $act_lot * $isi->INT_QTY_PER_BOX;
                                    echo "<td style='text-align:center;'>$act_lot</td>";
                                    echo "<td style='text-align:center;'>$act_qty</td>";

                                    $qty_ecer = ($isi->INT_QTY_PCS_ACTUAL - $act_qty) % $isi->INT_QTY_PER_BOX;
                                    echo "<td style='text-align:center;'>$qty_ecer</td>";

                                    $tot_qty = $act_qty + $qty_ecer;
                                    echo "<td style='text-align:center;'>$tot_qty</td>";

                                    $qty_remain = $isi->INT_QTY_PCS - $tot_qty;
                                    echo "<td style='text-align:center;font-weight:bold;'>$qty_remain</td>";

                                    if ($status == 0) {
                                        if ($isi->INT_SEQUENCE <= 15) {
                                            $cek_stock_sap = $this->db->query("select CHR_FLAG_STOCK from PRD.TW_CHECK_STOCK_SETUP_CHUTE where CHR_PRD_ORDER_NO = '$isi->CHR_PRD_ORDER_NO' AND CHR_FLAG_STOCK = 'T'");
                                            if ($cek_stock_sap->num_rows() > 0) {
                                                echo "<td style='text-align:center;font-weight:bold;'><a data-toggle='modal'data-target='#modalShortageSAP" . $isi->INT_ID . "'>Shortage (" . $cek_stock_sap->num_rows() . ") </a></td>";
                                            } else {
                                                echo "<td style='text-align:center;font-weight:bold;'>OK</td>";
                                            }
                                        } else {
                                            echo "<td style='text-align:center;font-weight:bold;'>-</td>";
                                        }
                                    } else {
                                        echo "<td style='text-align:center;font-weight:bold;'>-</td>";
                                    }

                                    if ($isi->INT_FLG_SO == '1') {
                                        echo "<td style='text-align:center;'>Yes</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>-</td>";
                                    }

                                    $stat_recovery = "";
                                    $stat_list_recovery = "";
                                    $qty_remain = $isi->INT_QTY_PCS - ($act_qty + $qty_ecer);
                                    if ($qty_remain > 0) {
                                        $cek_recovery = $this->db->query("select count(INT_ID) as tot_recovery from PRD.TT_SETUP_CHUTE where CHR_PRD_ORDER_NO_REFF like '%$isi->CHR_PRD_ORDER_NO%' AND INT_FLG_DEL = '0'")->row();
                                        if ($cek_recovery->tot_recovery > 0) {
                                            $stat_recovery = "style='display:none;'";
                                        } else {
                                            $stat_list_recovery = "style='display:none;'";
                                        }
                                    } else {
                                        $stat_recovery = "style='display:none;'";
                                        $stat_list_recovery = "style='display:none;'";
                                    }



                                ?>
                                    <?php if ($role == '1' || $role == '14' || $role == '69' || ($role == '16' && substr($work_center, 0, 2) != 'AS') || ($role == '17' && substr($work_center, 0, 2) != 'AS')) { //Fore ROLE 
                                    ?>
                                        <td style='text-align:center;'>
                                            <?php if ($isi->INT_SEQUENCE == 0 && $isi->INT_FLG_PRD == 1 && $isi->INT_STATUS_UNCOMPLETE == 1 && $isi->INT_FLG_DEL == 0) { ?>
                                                <a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Edit" <?php echo $stat_recovery; ?>><span class="fa fa-pencil"></span></a>
                                                <?php if ($isi->INT_FLG_ADJUST_FINISH == 0) { ?>
                                                    <a href="<?php echo base_url('index.php/prd/setup_chute_c/adjust_finish_lot') . "/" . $isi->INT_ID . "/1" ?>" class="label label-primary" data-placement="right" data-toggle="tooltip" title="Finish" onclick="return confirm('Are you sure want to UNLOCK DANDORI this Prod Order : ' + <?php echo $isi->CHR_PRD_ORDER_NO ?>);"><span class="fa fa-lock"></span></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url('index.php/prd/setup_chute_c/adjust_finish_lot') . "/" . $isi->INT_ID . "/0" ?>" class="label label-primary" data-placement="right" data-toggle="tooltip" title="Finish" onclick="return confirm('Are you sure want to LOCK DANDORI this Prod Order : ' + <?php echo $isi->CHR_PRD_ORDER_NO ?>);"><span class="fa fa-unlock"></span></a>
                                                <?php } ?>
                                                <a href="#" class="label label-default" data-placement="right" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                            <?php } else if ($isi->INT_SEQUENCE == 0 && $isi->INT_FLG_PRD == 2 && $isi->INT_STATUS_UNCOMPLETE == 1 && $isi->INT_FLG_DEL == 0) { ?>
                                                <a href="<?php echo base_url('index.php/prd/setup_chute_c/recovery_setup_chute') . "/" . $isi->INT_ID ?>" class="label label-primary" data-placement="top" data-toggle="tooltip" title="Recovery" onclick="return confirm('Are you sure want to RECOVERY this Setup Chute : ' + <?php echo $isi->CHR_PRD_ORDER_NO ?>);" <?php echo $stat_recovery; ?>><span class="fa fa-recycle"></span></a>
                                                <a data-target="#modalRecoveryChute<?php echo $isi->INT_ID; ?>" class="label label-info" data-placement="top" data-toggle="modal" title="Recovery List" <?php echo $stat_list_recovery; ?>><span class="fa fa-folder-open"></span></a>
                                                <a onclick="get_update_chute(<?php echo $isi->INT_ID . ',' . $isi->INT_SEQUENCE; ?>);" data-toggle="modal" data-target="#modalEditSetupChute<?php echo $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit" <?php echo $stat_recovery; ?>><span class="fa fa-pencil"></span></a>
                                                <a href="#" class="label label-default" data-placement="right" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                            <?php } else if ($isi->INT_SEQUENCE > 0 && $isi->INT_SEQUENCE <= 3 && $isi->INT_FLG_PRD == 1 && $isi->INT_STATUS_UNCOMPLETE == 1 && $isi->INT_FLG_DEL == 0 && $flg_phantom == 0 && ($role != '1' && $role != '16' && $role != '17' && $role != '14')) { ?>
                                                <a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                                <a href="#" class="label label-default" data-placement="right" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                            <?php } else if ($isi->INT_SEQUENCE == 0 && $isi->INT_FLG_PRD == 2 && $isi->INT_STATUS_UNCOMPLETE == 0 && $isi->INT_FLG_DEL == 0) { ?>
                                                <a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                                <a href="#" class="label label-default" data-placement="right" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                            <?php } else { 
                                                    if($isi->INT_CAVITY > 0 && $isi->INT_CAVITY != $isi->INT_ID){
                                            ?>
                                                    <a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                                <?php } else { ?>
                                                    <a onclick="get_update_chute(<?php echo $isi->INT_ID . ',' . $isi->INT_SEQUENCE; ?>);" data-toggle="modal" data-target="#modalEditSetupChute<?php echo $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit" <?php echo $stat_recovery; ?>><span class="fa fa-pencil"></span></a>                                                
                                                <?php } ?>
                                                <?php if ($isi->CHR_FLAG != NULL && $isi->CHR_FLAG != 'X') { ?>
                                                    <a href="#" class="label label-default" data-placement="right" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                                <?php } else { 
                                                            //===== If cavity -> function delete disabled
                                                            if($isi->INT_CAVITY > 0 && $isi->INT_CAVITY != $isi->INT_ID){
                                                ?>
                                                    <a href="#" class="label label-default" data-placement="right" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url('index.php/prd/setup_chute_c/delete_setup_chute') . "/" . $isi->INT_ID ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick='confirm_delete()'><span class="fa fa-times"></span></a>
                                                <?php }
                                                }
                                                ?>
                                            <?php } ?>
                                        </td>
                                    <?php } //For ROLE 
                                    ?>
                                    </tr>
                                <?php
                                    $last_seq = $max_seq; //$isi->INT_SEQUENCE;
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d : </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:grey;width:25px;height:25px;color:white;'></button> : Already Prod
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#8A2BE2;width:25px;height:25px;color:white;'></button> : Process Prod
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#33cc33;width:25px;height:25px;color:white;'></button> : Finish Preparation
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:orangered;width:25px;height:25px;color:white;'></button> : On Prepare IH
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#0066ff;width:25px;height:25px;color:white;'></button> : Finish OH
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:orange;width:25px;height:25px;color:white;'></button> : Stock OK/On Prepare OH
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:yellow;width:25px;height:25px;color:white;'></button> : Order to OH/IH
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <span style="font-size:9pt">* hanya berstatus ... yang bisa ditranspose </span>
                        <!--(40 hours) -->
                    </div>
                    <?php foreach ($data as $isi) { ?>
                        <div class="modal fade" id="modalEditSetupChute<?php echo $isi->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Setup Chute</strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open('prd/setup_chute_c/update_setup_chute', 'class="form-horizontal"'); ?>

                                            <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center); ?>">
                                            <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_PART_NO); ?>">
                                            <input name="INT_ID_DEPT" class="form-control" id='dept_id' required type="hidden" style="width: 300px;" value="<?php echo $id_dept; ?>">
                                            <input name="INT_OLD_SEQUENCE" class="form-control" id='old_seq' required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_SEQUENCE; ?>">
                                            <input name="INT_ID" class="form-control" id='id' required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID; ?>">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Sequence Chute</label>
                                                <div class="col-sm-5">
                                                    <?php
                                                    $min_val = 1;
                                                    if ($role == 1 || $role == 14 || ($role == '17' && substr($work_center, 0, 2) != 'AS')) {
                                                        $min_val = 1;
                                                    } else {
                                                        if ($isi->INT_SEQUENCE <= 5 && $isi->INT_SEQUENCE > 3) {
                                                            if ($last_seq >= 3) {
                                                                $min_val = 4;
                                                            } else {
                                                                $min_val = $last_seq;
                                                            }
                                                        } else if ($isi->INT_SEQUENCE == 0) {
                                                            $min_val = 5;
                                                            $last_seq = $max_seq;
                                                        } else {
                                                            if ($last_seq >= 5) {
                                                                $min_val = 5;
                                                            } else {
                                                                $min_val = $last_seq;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <input type="number" min="<?php echo $min_val; ?>" max="<?php echo $last_seq; ?>" name="INT_SEQUENCE" class="form-control" required value="<?php if ($isi->INT_SEQUENCE == 0) {
                                                                                                                                                                                                    echo $min_val;
                                                                                                                                                                                                } else {
                                                                                                                                                                                                    echo trim($isi->INT_SEQUENCE);
                                                                                                                                                                                                } ?>">
                                                </div>
                                            </div>
                                            <?php if ($isi->INT_SEQUENCE <= 5) { ?>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Notes <i><b class='mandatory'>*Required</m></b></i></label>
                                                    <div class="col-sm-5">
                                                        <input type="text" name="NOTES" class="form-control" style="width:400px;" <?php if ($isi->INT_SEQUENCE <= 5) {
                                                                                                                                        echo "required";
                                                                                                                                    } ?> value="">
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div id="test<?php echo $isi->INT_ID; ?>" style="display:none;">
                                                <!-- AJAX -->
                                                <label class='col-sm-12 control-label'><i><b class='mandatory'>Sequence chute alreary change, please REFRESH first!</m></b></i></label>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <a href="<?php echo site_url('prd/setup_chute_c/search_setup_chute/' . $status . '/' . $id_dept . '/' . $work_center . '/0'); ?>" id="refresh_seq<?php echo $isi->INT_ID; ?>" style="display:none;" class="btn btn-info" data-placement="left" data-toggle="tooltip" title="Refresh Chute">Refresh</a>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="update_seq<?php echo $isi->INT_ID; ?>" style="display:block;" onclick='callMqtt()' class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- MODAL FOR SHORTAGE MATERIAL -->
                        <div class="modal fade" id="modalShortage<?php echo $isi->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Shortage Material</strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Part No</th>
                                                        <th>Back No</th>
                                                        <th>Part Name</th>
                                                        <th>Area</th>
                                                        <th>Box Order</th>
                                                        <th>Qty Order</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cek_stock_2 = $this->db->query("select CHR_PART_NO, CHR_BACK_NO, CHR_PART_NAME, INT_ORDER_BOX, INT_ORDER_PCS, CHR_PREPARE_AREA from PRD.TT_ELINA_L where CHR_PRD_ORDER_NO = '$isi->CHR_PRD_ORDER_NO' and CHR_FLAG_STOCK = 'F'");
                                                    if ($cek_stock_2->num_rows() > 0) {
                                                        $part_shortage = $cek_stock_2->result();
                                                        foreach ($part_shortage as $part) {
                                                            echo "<tr>";
                                                            echo "<td>" . $part->CHR_PART_NO . "</td>";
                                                            echo "<td>" . $part->CHR_BACK_NO . "</td>";
                                                            echo "<td>" . $part->CHR_PART_NAME . "</td>";
                                                            if ($part->CHR_PREPARE_AREA == 'A') {
                                                                $area = 'CKD';
                                                            } else if ($part->CHR_PREPARE_AREA == 'B') {
                                                                $area = 'OH';
                                                            } else {
                                                                $area = 'IH';
                                                            }

                                                            echo "<td align='center'>" . $area . "</td>";
                                                            echo "<td align='center'>" . $part->INT_ORDER_BOX . "</td>";
                                                            echo "<td align='center'>" . $part->INT_ORDER_PCS . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL -->
                        <!-- MODAL FOR SHORTAGE MATERIAL -- FROM SAP -->
                        <div class="modal fade" id="modalShortageSAP<?php echo $isi->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Shortage Material</strong></h4>
                                        </div>

                                        <div class="modal-body">
                                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Part No</th>
                                                        <th>Back No</th>
                                                        <th>Part Name</th>
                                                        <th>Area</th>
                                                        <th>Box Order</th>
                                                        <th>Qty Order</th>
                                                        <th>Qty SAP</th>
                                                        <th>Qty Diff</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cek_stock_sap_2 = $this->db->query("select CHR_PART_NO, CHR_BACK_NO, CHR_PART_NAME, CHR_PREPARE_AREA, INT_ORDER_BOX, INT_ORDER_PCS, INT_STOCK_PCS_SAP, INT_SUM_PCS_CAL from PRD.TW_CHECK_STOCK_SETUP_CHUTE where CHR_PRD_ORDER_NO = '$isi->CHR_PRD_ORDER_NO' and CHR_FLAG_STOCK = 'T'");
                                                    if ($cek_stock_sap_2->num_rows() > 0) {
                                                        $part_shortage_sap = $cek_stock_sap_2->result();
                                                        foreach ($part_shortage_sap as $part) {
                                                            echo "<tr>";
                                                            echo "<td>" . $part->CHR_PART_NO . "</td>";
                                                            echo "<td>" . $part->CHR_BACK_NO . "</td>";
                                                            echo "<td>" . $part->CHR_PART_NAME . "</td>";
                                                            echo "<td align='center'>" . $part->CHR_PREPARE_AREA . "</td>";
                                                            echo "<td align='center'>" . $part->INT_ORDER_BOX . "</td>";
                                                            echo "<td align='center'>" . $part->INT_ORDER_PCS . "</td>";
                                                            $stock_ready = $part->INT_STOCK_PCS_SAP - ($part->INT_SUM_PCS_CAL - $part->INT_ORDER_PCS);
                                                            $qty_diff = $stock_ready - $part->INT_ORDER_PCS;
                                                            echo "<td align='center'>" . $stock_ready . "</td>";
                                                            echo "<td align='center'>" . $qty_diff . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL -->
                    <?php }   ?>
                </div>
            </div>
            <!-- VIEW PROD RESULT -->  
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-bars"></i>
                            <span class="grid-title"><strong>SUMMARY HISTORY PRODUCTION CHUTE</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>                            
                            </div>
                            <div class="pull-right grid-tools"></div>
                        </div>
                        <div class="grid-body">
                            <iframe frameBorder="0" width='100%' height='450px' src="<?php echo site_url("prd/report_ogawa_c/view_history_production_chute/" . $work_center . "/" . date('Ym')); ?>"></iframe>
                        </div>
                    </div>
                </div>
            <!-- VIEW PROD RESULT -->
            <?php //if($role == 1){ ?>
            <!-- VIEW STOCK -->  
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-bars"></i>
                            <span class="grid-title"><strong>VIEW STOCK SAP</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>                            
                            </div>
                            <div class="pull-right grid-tools"></div>
                        </div>
                        <div class="grid-body">
                            <iframe frameBorder="0" width='100%' height='450px' src="<?php echo site_url("prd/report_ogawa_c/view_movement_stock/" . $work_center . "/" . date('Ym')); ?>"></iframe>
                        </div>
                    </div>
                </div>
            <!-- VIEW STOCK --> 
            <?php //} ?>
    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/mqtt/mqttws31.min.js"></script>

<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            fixedColumns: {
                leftColumns: 4,
                rightColumns: 1
            }
        });
    });

    function get_data_work_center() {
        var dept_to_work_center = document.getElementById('dept_to_work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
            data: {
                INT_ID_DEPT: dept_to_work_center
            },
            success: function(json_data) {
                $("#work_center").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function get_update_chute(id_chute, old_seq) {
        // $("#test").html("");
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/setup_chute_c/get_updated_chute'); ?>",
            data: "id=" + id_chute + "&seq=" + old_seq,
            success: function(data) {
                var new_seq = parseInt(data);
                if (new_seq === old_seq) {
                    document.getElementById("test" + id_chute).style.display = 'none';
                    document.getElementById("refresh_seq" + id_chute).style.display = 'none';
                    document.getElementById("update_seq" + id_chute).style.display = 'block';
                } else {
                    document.getElementById("test" + id_chute).style.display = 'block';
                    document.getElementById("refresh_seq" + id_chute).style.display = 'block';
                    document.getElementById("update_seq" + id_chute).style.display = 'none';
                }

                // $("#test" + id_chute).html(data);
            }
        });
    }

    function confirm_delete() {
        callMqtt();

        return confirm("Are you sure want to DELETE this Setup Chute ?");
    }

    function callMqtt() {
        client = new Paho.MQTT.Client("192.168.0.234", 9001, 'setup_chute');
        client.connect({
            onSuccess: onConnect
        });
    }

    function onConnect() {
        var wc = document.getElementById('work_center_id').value;
        message = new Paho.MQTT.Message(wc);

        var pos1 = 1;
        message.destinationName = 'SETUPCHUTE/' + wc + '/' + pos1;
        client.send(message);

        var pos2 = 2;
        message.destinationName = 'SETUPCHUTE/' + wc + '/' + pos2;
        client.send(message);

        var pos3 = 3;
        message.destinationName = 'SETUPCHUTE/' + wc + '/' + pos3;
        client.send(message);

        var pos4 = 4;
        message.destinationName = 'SETUPCHUTE/' + wc + '/' + pos4;
        client.send(message);

        var pos5 = 5;
        message.destinationName = 'SETUPCHUTE/' + wc + '/' + pos5;
        client.send(message);

        var pos6 = 6;
        message.destinationName = 'SETUPCHUTE/' + wc + '/' + pos6;
        client.send(message);

    }
</script>