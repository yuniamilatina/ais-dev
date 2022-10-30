
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
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
            <li><a href="<?php echo base_url('index.php/prd/lot_kanban_c') ?>"><strong>Manage Std Lot kanban</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE STD LOT KANBAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/lot_kanban_c/create_lot_kanban/'.$id_dept.'/'.$work_center) ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Upload Lot Kanban" style="height:30px;font-size:13px;width:100px;color:grey;margin-top:-5px;margin-bottom:-5px;">Upload</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('prd/lot_kanban_c/search_lot_kanban', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%">
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%">
                                        
                                    </td>
                                    <td width="55%">
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr> 
                                    <td width="5%">Dept</td>
                                        <td width="5%">
                                            <select name="INT_ID_DEPT" id="dept_to_work_center" onchange="get_data_work_center(); document.getElementById('dept_id').value=this.options[this.selectedIndex].value;" class="ddl2" style="width:150px;">
                                                <?php
                                                foreach ($all_dept_prod as $row) {
                                                    if (trim($row->INT_ID_DEPT) == trim($id_dept)) {
                                                        ?>
                                                        <option selected value="<? echo $id_dept; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                    <?php } else { ?>
                                                        <option value="<? echo $row->INT_ID_DEPT; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="55%">    
                                        
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select id="work_center" name="CHR_WORK_CENTER" class="ddl2" style="width:150px;" onchange="document.getElementById('work_center_id').value=this.options[this.selectedIndex].value;">
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                                    ?>
                                                    <option selected value="<?php echo trim($work_center); ?>" > <?php echo trim($work_center); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select></td>
                                    <td width="5%" colspan="4">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                        <?php form_close(); ?></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'>
                                        <!-- <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Production Per Hour')" value="Export to Excel" style="margin-bottom: 0px;"> -->
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style='text-align:center;'>No</th>
                                        <th rowspan="2" style="text-align:left;">Part No</th>
                                        <th rowspan="2" style="text-align:center;">Back No</th> 
                                        <th rowspan="2" style="text-align:center;">Kanban Type</th>                                                
                                        <th rowspan="2" style="text-align:center;">Qty Per Box</th>
                                        <th rowspan="2" style="text-align:center;">Lot Kanban</th>
                                        <th rowspan="2" style="text-align:center;">Total Qty Pcs</th>
                                        <th colspan="2" style="text-align:center; background-color:whitesmoke;">Progress Lot Making</th>
                                        <th rowspan="2" style="text-align:center;">Actions</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center; background-color:whitesmoke;">Actual Lot</th>
                                        <th style="text-align:center; background-color:whitesmoke;">Actual Pcs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        $part_no = $isi->CHR_PART_NO;
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='text-align:left;'>$part_no</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>"; 
                                        if($isi->CHR_KANBAN_TYPE == '1'){
                                            echo "<td style='text-align:center;'>Proses</td>"; 
                                        } elseif ($isi->CHR_KANBAN_TYPE == '5'){
                                            echo "<td style='text-align:center;'>Pickup</td>"; 
                                        } elseif($isi->CHR_KANBAN_TYPE == '6'){
                                            echo "<td style='text-align:center;'>Special</td>";
                                        } elseif($isi->CHR_KANBAN_TYPE == '0'){
                                            echo "<td style='text-align:center;'>Order</td>";
                                        } elseif($isi->CHR_KANBAN_TYPE == '4'){
                                            echo "<td style='text-align:center;'>Subcont</td>";
                                        } else {
                                            echo "<td style='text-align:center;'>-</td>";
                                        }                                       
                                        echo "<td style='text-align:center;'>$isi->INT_QTY_PER_BOX</td>";
                                        echo "<td style='text-align:center;'><strong>$isi->INT_LOT_SIZE</strong></td>";
                                        $total_qty = $isi->INT_QTY_PER_BOX * $isi->INT_LOT_SIZE;
                                        echo "<td style='text-align:center;'>$total_qty</td>";
                                        
                                        $tw_lot = $this->db->query("select * from PRD.TW_LOT_KANBAN where CHR_PART_NO = '$part_no'");
                                        if($tw_lot->num_rows() == 0){
                                            echo "<td style='text-align:center;'>0</td>";
                                            echo "<td style='text-align:center;'>0</td>";
                                        } else {
                                            $act_lot = $tw_lot->row()->INT_LOT_ACTUAL;
                                            $act_qty = ($tw_lot->row()->INT_LOT_ACTUAL * $isi->INT_QTY_PER_BOX) + ($tw_lot->row()->INT_QTY_ACTUAL - ($isi->INT_QTY_PER_BOX * $tw_lot->row()->INT_LOT_ACTUAL));
                                            echo "<td style='text-align:center;'>$act_lot</td>";
                                            echo "<td style='text-align:center;'>$act_qty</td>";
                                        }
                                        
                                        ?>
                                    <td style='text-align:center;'>
                                            <!-- <a data-toggle="modal" data-target="#modalEditLot<?php echo trim($isi->CHR_PART_NO) ?>" data-placement="left" data-toggle="tooltip" title="Edit Lot" class="label label-warning"><span class="fa fa-pencil"></span></a> -->
                                            <a href="<?php echo base_url('index.php/prd/lot_kanban_c/edit_lot_kanban') . "/" . trim($id_dept) . "/" . trim($work_center) . "/" . $part_no ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <?php foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditLot<?php echo trim($isi->CHR_PART_NO) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Lot Kanban</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                        <?php echo form_open('prd/lot_kanban_c/update_lot_kanban', 'class="form-horizontal"'); ?>

                                            <input name="INT_ID_DEPT" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($id_dept) ?>">
                                            <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">
                                            <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_PART_NO) ?>">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Lot Size (Pcs)</label>
                                                <div class="col-sm-5">
                                                    <input type="number" id="qty_pcs" name="INT_LOT_PCS" class="form-control" onkeyup="calc_kanban();" required value="<?php echo trim($isi->INT_LOT_SIZE * $isi->INT_QTY_PER_BOX) ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Qty per Box</label>
                                                <div class="col-sm-5">
                                                    <input type="number" id="qty_per_box" name="INT_QTY_PER_BOX" class="form-control" readonly value="<?php echo trim($isi->INT_QTY_PER_BOX) ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Lot Kanban</label>
                                                <div class="col-sm-5">
                                                    <input type="number" id="qty_kanban" name="INT_LOT_SIZE" class="form-control" readonly value="<?php echo trim($isi->INT_LOT_SIZE) ?>" >
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



<script type="text/javascript" language="javascript">

function get_data_work_center(){
    var dept_to_work_center = document.getElementById('dept_to_work_center').value;

    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
        data:  {
                INT_ID_DEPT: dept_to_work_center
                },
        success: function (json_data) {
            $("#work_center").html(json_data['data']);
        },
        error: function (request) {
            alert(request.responseText);
        }
    });
}

function calc_kanban(){
    var pcs = document.getElementById('qty_pcs').value;
    var qty_per_box = document.getElementById('qty_per_box').value;

    var tot_kanban = parseInt(pcs) / parseInt(qty_per_box);

    document.getElementById('qty_kanban').value = tot_kanban;
}
</script>