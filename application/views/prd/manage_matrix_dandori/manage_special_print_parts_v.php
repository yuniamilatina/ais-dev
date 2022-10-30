
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
            <li><a href="<?php echo base_url('index.php/prd/manage_special_print_parts_c') ?>"><strong>Manage Parts for Special Print</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE PARTS FOR SPECIAL PRINT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-toggle="modal" data-target="#modalAddParts" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Add Special Parts" style="height:30px;font-size:13px;width:100px;color:grey;margin-top:-5px;margin-bottom:-5px;">Add Parts</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('prd/manage_matrix_dandori_c/search_special_print_parts', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Dept</td>
                                    <td width="5%">
                                        <select name="CHR_DEPT" id="dept_to_work_center" onchange="get_data_work_center(); document.getElementById('dept_id').value=this.options[this.selectedIndex].value;" class="ddl2" style="width:150px;">
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
                                    </td>
                                    <td width="4%"></td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                    <td width="25%"></td>
                                </tr>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select id="work_center" name="CHR_WORK_CENTER" class="ddl2" style="width:150px;" onchange="document.getElementById('work_center_id').value=this.options[this.selectedIndex].value;" <?php if($id_dept == 'pass'){ echo 'disabled'; } ?>>
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
                                    </td>
                                    <td width="5%">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%"></td>                                        
                                    <td width="4%"></td>
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
                                        <th style='text-align:center;'>No</th>
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;">Back No</th>
                                        <th style="text-align:center;">Part Name</th>
                                        <th style="text-align:center;">Printer</th>
                                        <th style="text-align:center;">IP Address</th>
                                        <th style="text-align:center;">Status</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i = 1;
                                        foreach($data as $isi){
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>$i</td>";
                                            echo "<td align='center'>" . trim($isi->CHR_WORK_CENTER) . "</td>";
                                            echo "<td align='center'>" . trim($isi->CHR_PART_NO) . "</td>";
                                            if(trim($isi->CHR_BACK_NO) == NULL){
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'>" . trim($isi->CHR_BACK_NO) . "</td>";
                                            } 
                                            
                                            echo "<td align='left'>" . $isi->CHR_PART_NAME . "</td>"; 
                                            echo "<td align='left'>" . $isi->CHR_USAGE . "</td>"; 
                                            echo "<td align='left'>" . $isi->CHR_IP . "</td>";  

                                            if($isi->INT_FLG_DEL == 0){
                                                echo "<td align='center'>Active</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                    ?>
                                            <td align='center'>
                                                <?php if($isi->INT_FLG_DEL == 1){ ?>
                                                    <a data-toggle="modal" data-target="#" data-toggle="tooltip" data-placement="left" title="Edit Part" class="label label-default"><span class="fa fa-edit"></span></a>
                                                    <a href="<?php echo base_url('index.php/prd/manage_matrix_dandori_c/update_special_print_parts') . "/" . $isi->INT_ID ?>" data-placement="left" data-toggle="tooltip" title="Enable" class="label label-success"><span class="fa fa-check"></span></a>
                                                <?php } else { ?>
                                                    <a data-toggle="modal" data-target="#modalEditParts<?php echo $isi->INT_ID; ?>" data-toggle="tooltip" data-placement="left" title="Edit Part" class="label label-warning"><span class="fa fa-edit"></span></a>
                                                    <a href="<?php echo base_url('index.php/prd/manage_matrix_dandori_c/update_special_print_parts') . "/" . $isi->INT_ID ?>" data-placement="left" data-toggle="tooltip" title="Disable" class="label label-danger"><span class="fa fa-times"></span></a>
                                                <?php } ?>
                                            </td>
                                    <?php
                                            
                                            echo "</tr>";
                                            $i++;
                                        }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalAddParts" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">                                    
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Add Part for Special Print</strong></h4>
                                </div>
                                        
                                <div class="modal-body">
                                <?php echo form_open('prd/manage_matrix_dandori_c/add_new_special_part', 'class="form-horizontal"'); ?>

                                    <input name="dept" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($id_dept) ?>">
                                    <input name="work_center" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Part No</label>
                                        <div class="col-sm-2">
                                            <select name="part_no" id="e1" class="form-control" onchange="getPartName(value);" style="width: 200px;">
                                                <?php foreach ($all_part_no as $part) { ?>
                                                    <option value="<?php echo trim($part->CHR_PART_NO); ?>"><?php echo trim($part->CHR_PART_NO); ?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Back No - Part Name</label>
                                        <div class="col-sm-2">
                                            <input name="part_name" readonly id="part_name" class='form-control' type="text" style="width: 500px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Printer</label>
                                        <div class="col-sm-2">
                                            <select name="printer" id="e2" class="form-control" style="width: 300px;">
                                                <?php foreach ($all_printer as $print) { ?>
                                                    <option value="<?php echo trim($print->INT_ID); ?>"><?php echo trim($print->CHR_IP) . ' (' . trim($print->CHR_USAGE) . ')'; ?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save Part</button>
                                    <?php echo form_close(); ?>
                                    </div>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php foreach($data as $isi){ ?>
                <div class="modal fade" id="modalEditParts<?php echo $isi->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">                                    
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Edit Part for Special Print</strong></h4>
                                </div>
                                        
                                <div class="modal-body">
                                <?php echo form_open('prd/manage_matrix_dandori_c/edit_special_parts', 'class="form-horizontal"'); ?>
                                    <input name="id" class="form-control" id='id' type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID; ?>">
                                    <input name="dept" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($id_dept); ?>">
                                    <input name="work_center" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center); ?>">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Part No</label>
                                        <div class="col-sm-2">
                                            <select name="part_no" id="e1" class="form-control" onchange="getPartName(value);" style="width: 200px;" disabled>
                                                <?php 
                                                    foreach ($all_part_no as $part) {
                                                        if(trim($isi->CHR_PART_NO) == trim($part->CHR_PART_NO)){
                                                ?>                                                    
                                                    <option selected value="<?php echo trim($part->CHR_PART_NO); ?>"><?php echo trim($part->CHR_PART_NO); ?></option>
                                                <?php 
                                                        } else {
                                                ?>
                                                    <option value="<?php echo trim($part->CHR_PART_NO); ?>"><?php echo trim($part->CHR_PART_NO); ?></option>
                                                <?php
                                                        }
                                                    } 
                                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Back No - Part Name</label>
                                        <div class="col-sm-2">
                                            <input name="part_name" readonly id="part_name" class='form-control' type="text" style="width: 500px;" value="<?php echo trim($isi->CHR_BACK_NO) . '-' . trim($isi->CHR_PART_NAME); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Printer</label>
                                        <div class="col-sm-2">
                                            <select name="printer" id="e2" class="form-control" style="width: 350px;">
                                                <?php 
                                                    foreach ($all_printer as $print) { 
                                                        if($isi->INT_ID_PRINTER == $print->INT_ID){
                                                ?>
                                                    <option selected value="<?php echo trim($print->INT_ID); ?>"><?php echo trim($print->CHR_IP) . ' (' . trim($print->CHR_USAGE) . ')'; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($print->INT_ID); ?>"><?php echo trim($print->CHR_IP) . ' (' . trim($print->CHR_USAGE) . ')'; ?></option>
                                                <?php 
                                                        }
                                                    } 
                                                ?> 
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update Part</button>
                                    <?php echo form_close(); ?>
                                    </div>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 2               
            }
        });
    });

    function get_data_work_center(){
        var dept_to_work_center = document.getElementById('dept_to_work_center').value;

        if(dept_to_work_center != "pass"){
            $.ajax({
                async: false,
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
                data:  {
                        INT_ID_DEPT: dept_to_work_center
                        },
                success: function (json_data) {
                    //$("#work_center").attr('disabled', false).css("background-color","#FFF");    
                    $("#work_center").attr('disabled', false);                                   
                    $("#work_center").html(json_data['data']);
                },
                error: function (request) {
                    alert(request.responseText);
                }
            });
        } else {
            //$("#work_center").attr('disabled', true).css("background-color","#E7E7E7");
            $("#work_center").val("");
            $("#work_center").attr('disabled', true);   
        }        
    }

    function getPartName(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('prd/manage_matrix_dandori_c/get_part_name'); ?>",
            data: "part_no=" + value,
            success: function(data) {
                $("#part_name").val(data);
            }
        });
    }
</script>