
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/lot_kanban_c/sequence_lot_kanban') ?>"><strong>Sequence Lot Kanban</strong></a></li>
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
                        <span class="grid-title"><strong>SEQUENCE LOT KANBAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/lot_kanban_c/create_special_order/0/' . $id_dept . '/' . trim($work_center)) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Edit Sequence Lot Kanban" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Create SO</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Dept</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                <option value="<?php echo site_url('prd/lot_kanban_c/search_sequence_lot_kanban/0/' . trim($row->INT_ID_DEPT)); ?>"  <?php
                                            if ($id_dept == trim($row->INT_ID_DEPT)) {
                                                echo 'selected';
                                            }
                                                ?> > <?php echo trim($row->CHR_DEPT); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                </tr>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('prd/lot_kanban_c/search_sequence_lot_kanban/0/' . $id_dept . '/' . trim($row->CHR_WORK_CENTER)); ?>"  <?php
                                                if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4">
                                        <!-- <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td> -->
                                        <!-- <?php form_close(); ?></td> -->
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'>
                                        <!-- <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Production Per Hour')" value="Export to Excel" style="margin-bottom: 0px;"> -->
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Sequence</th>
                                    <th style="text-align:center;">Work Center</th>
                                    <th style="text-align:center;">Part No AII</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Part No Customer</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Lot Size</th>
                                    <th style="text-align:center;">Qty per Box</th>
                                    <th style="text-align:center;">Total Qty</th>
                                    <th style="text-align:center;">Special Order</th>
                                    <th style="text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($data as $isi) {
                                if($isi->INT_FLG_SO == '1'){
                                    echo "<tr class='gradeX' style='color:red;'>";
                                } else {
                                    echo "<tr class='gradeX'>";
                                }
                                
//                                if ($i == 1) {
//                                    $color = 'background:#FE2D45;color:#fff;';
//                                } elseif ($i == 2) {
//                                    $color = 'background:#F5811E;color:#fff;';
//                                } elseif ($i == 3) {
//                                    $color = 'background:#FFCA01;color:#fff;';
//                                } else {
                                    $color = '';
//                                }

                                echo "<td style='$color'>$i</td>";
                                echo "<td style='text-align:center;'>$isi->INT_SEQUENCE</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_PART_NO</td>";
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
                                echo "<td style='text-align:center;'>$back_no->CHR_BACK_NO</td>";
                                echo "<td style='text-align:center;'>$part_no_cust_value</td>";
                                echo "<td style='text-align:center;'>" . date('d-m-Y', strtotime($isi->CHR_DATE)) . "</td>";
                                echo "<td style='text-align:center;'>$isi->INT_LOT_SIZE</td>";
                                echo "<td style='text-align:center;'>$isi->INT_QTY_PER_BOX</td>";
                                echo "<td style='text-align:center;'>$isi->INT_QTY_PCS</td>";
                                
                                if($isi->INT_FLG_SO == '1'){
                                    echo "<td style='text-align:center;'>Yes</td>";
                                } else {
                                    echo "<td style='text-align:center;'>-</td>";
                                }
                                
                                ?>
                                <td style='text-align:center;'>
                                    <a data-toggle="modal" data-target="#modalEditSequenceLot<?php echo $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/prd/lot_kanban_c/delete_sequence_lot_kanban') . "/" . $isi->INT_ID ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to DELETE this sequence Lot : ' + <?php echo $isi->CHR_PART_NO ?>);"><span class="fa fa-times"></span></a>
                                </td>
                                </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditSequenceLot<?php echo $isi->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>Edit Sequence Lot Kanban</strong></h4>
                                    </div>

                                    <div class="modal-body">
                                    <?php echo form_open('prd/lot_kanban_c/update_sequence_lot_kanban', 'class="form-horizontal"'); ?>
                                        
                                        <?php
                                            $part_no = trim($isi->CHR_PART_NO);
                                            $wcenter = $this->db->query("SELECT CHR_WORK_CENTER FROM TM_PROCESS_PARTS WHERE CHR_PART_NO = '$part_no' AND CHR_FLAG_DELETE IS NULL")->result();                                            
                                        ?>
                                        
                                        <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">
                                        <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_PART_NO) ?>">
                                        <input name="INT_ID_DEPT" class="form-control" id='dept_id' required type="hidden" style="width: 300px;" value="<?php echo $id_dept; ?>">
                                        <input name="INT_QTY_PER_BOX" class="form-control" id='qty_per_box' required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_QTY_PER_BOX; ?>">
                                        <input name="INT_OLD_SEQUENCE" class="form-control" id='old_seq' required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_SEQUENCE; ?>">
                                        <input name="INT_ID" class="form-control" id='id' required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID; ?>">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Work Center</label>
                                            <div class="col-sm-5">
                                                <select name="CHR_NEW_WORK_CENTER" class="ddl">
                                                <?php foreach ($wcenter as $wc) { ?>
                                                    <option value="<?php echo trim($wc->CHR_WORK_CENTER); ?>"  <?php
                                                    if (trim($work_center) == trim($wc->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                    }
                                                ?> > <?php echo trim($wc->CHR_WORK_CENTER); ?> </option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Lot Kanban</label>
                                            <div class="col-sm-5">
                                                <input type="number" name="INT_LOT" class="form-control" required value="<?php echo trim($isi->INT_LOT_SIZE) ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Sequence Lot</label>
                                            <div class="col-sm-5">
                                                <input type="number" name="INT_SEQUENCE" max="<?php echo $i-1;?>" class="form-control" required value="<?php echo trim($isi->INT_SEQUENCE) ?>" >
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                    <?php echo form_close(); ?>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 <?php }   ?>
                </div>
            </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>

    $(document).ready(function () {
        var table = $('#dataTables2').DataTable({
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                bFilter: true,
                fixedColumns: {
                leftColumns: 4,
                rightColumns: 1
                }
        });
    });

</script>