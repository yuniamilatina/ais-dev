
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
            <li><a href="<?php echo base_url('index.php/prd/manage_matrix_dandori_c') ?>"><strong>Manage Matrix Dandori Parts</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE MATRIX DANDORI PARTS</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/manage_matrix_dandori_c/create_matrix_dandori/0/'.$id_dept.'/'.$work_center) ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Upload Matrix Dandori" style="height:30px;font-size:13px;width:100px;color:grey;margin-top:-5px;margin-bottom:-5px;">Upload</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('prd/manage_matrix_dandori_c/search_part_no', 'class="form-horizontal"'); ?>
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
                                                <option <?php if(trim($id_dept) == 'pass'){ echo 'selected'; } ?> value="pass">Passthrough</option>
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
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;">Back No</th> 
                                        <th style="text-align:center;">Kanban Type</th>
                                        <th style="text-align:center;">Part Name</th>
                                        <?php if($id_dept != 'pass'){ ?>
                                        <th style="text-align:center;">Dandori Group</th>
                                        <?php } ?>
                                        <th style="text-align:center;">Rack No</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i = 1;
                                        foreach($data as $isi){
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>$i</td>";
                                            echo "<td align='center'>" . trim($isi->CHR_PART_NO) . "</td>";
                                            if(trim($isi->CHR_BACK_NO) == NULL){
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'>" . trim($isi->CHR_BACK_NO) . "</td>";
                                            }                                            
                                            
                                            if(trim($isi->CHR_KANBAN_TYPE) == '0'){
                                                echo "<td align='center'>" . trim($isi->CHR_KANBAN_TYPE) . " (Order)</td>";
                                            } else if(trim($isi->CHR_KANBAN_TYPE) == '1'){
                                                echo "<td align='center'>" . trim($isi->CHR_KANBAN_TYPE) . " (Process)</td>";
                                            } else if(trim($isi->CHR_KANBAN_TYPE) == '4'){
                                                echo "<td align='center'>" . trim($isi->CHR_KANBAN_TYPE) . " (Supply)</td>";
                                            } else if(trim($isi->CHR_KANBAN_TYPE) == '5'){
                                                echo "<td align='center'>" . trim($isi->CHR_KANBAN_TYPE) . " (Pickup)</td>";
                                            } else if(trim($isi->CHR_KANBAN_TYPE) == '6'){
                                                echo "<td align='center'>" . trim($isi->CHR_KANBAN_TYPE) . " (Passthrough)</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                            
                                            echo "<td align='left'>" . $isi->CHR_PART_NAME . "</td>"; 
                                            if($id_dept != 'pass'){
                                                if($isi->CHR_MATRIX_DANDORI == NULL){
                                                    echo "<td align='center'>-</td>";
                                                } else {
                                                    echo "<td align='center'>" . $isi->CHR_MATRIX_DANDORI . "</td>";
                                                }
                                            }
                                            
                                            if($isi->CHR_RAKNO == NULL){
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'>" . $isi->CHR_RAKNO . "</td>";
                                            }
                                            
                                    ?>
                                            <td align='center'>
                                                <?php if($id_dept != 'pass'){ ?>
                                                <a data-toggle="modal" data-target="#modalEditMatrix<?php echo trim($isi->CHR_PART_NO) ?>" data-placement="left" data-toggle="tooltip" title="Edit Dandori Group" class="label label-warning"><span class="fa fa-edit"></span></a>
                                                <?php } ?>
                                                <a data-toggle="modal" data-target="#modalEditRack<?php echo trim($isi->CHR_PART_NO) . "-" . trim($isi->CHR_KANBAN_TYPE) ?>" data-placement="left" data-toggle="tooltip" title="Edit Rack" class="label label-warning"><span class="fa fa-cube"></span></a>                                                    
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

                <?php foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditMatrix<?php echo trim($isi->CHR_PART_NO) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Matrix Dandori Part</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                        <?php echo form_open('prd/manage_matrix_dandori_c/update_matrix_part', 'class="form-horizontal"'); ?>

                                            <input name="CHR_DEPT" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($id_dept) ?>">
                                            <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">
                                            <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_PART_NO) ?>">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Dandori Group</label>
                                                <div class="col-sm-5">
                                                    <input type="text" id="group" name="DANDORI_GROUP" minlength="2" maxlength="2" class="form-control" required value="<?php echo trim($isi->CHR_MATRIX_DANDORI); ?>" >
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

                 <?php foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditRack<?php echo trim($isi->CHR_PART_NO) . "-" . trim($isi->CHR_KANBAN_TYPE) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Rack</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                        <?php echo form_open('prd/manage_matrix_dandori_c/update_rack_no', 'class="form-horizontal"'); ?>

                                            <input name="CHR_DEPT" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($id_dept) ?>">
                                            <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">
                                            <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_PART_NO) ?>">
                                            <input name="CHR_KANBAN_TYPE" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_KANBAN_TYPE) ?>">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Rack No</label>
                                                <div class="col-sm-5">
                                                    <input type="text" id="group" name="RACKNO" minlength="2" maxlength="11" class="form-control" required value="<?php echo trim($isi->CHR_RAKNO); ?>" >
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
</script>