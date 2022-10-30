<?php header("Content-type: text/html; charset=iso-8859-1"); ?>
<style>
    #filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }
 
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Manage Preventive Activities</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE ACTIVITIES FOR "<?php echo $checksheet->CHR_CHECKSHEET_CODE  . '" - ' . $checksheet->CHR_CHECKSHEET_NAME; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-target='#modalActivity' class='btn btn-info' data-placement='left' data-toggle='modal' title='Add Activity' style='color:white;'><i class='fa fa-plus'></i> Add Activity</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>                            
                        </div>
                    </div>
                    <div class="grid-body">                    
                        <div style="font-size:11px;">
                            <table id="dataTable" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>Sequence</strong></td>
                                        <td align="center"><strong>Activity</strong></td>
                                        <td align="center"><strong>Item Check</strong></td>
                                        <td align="center"><strong>Tool</strong></td>
                                        <td align="center"><strong>Standard</strong></td>                                        
                                        <td align="center"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($data != NULL){
                                            $no = 1;
                                            foreach ($data as $row) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td align='left'>" . $no . "</td>";
                                                echo "<td align='left'><strong>" . $row->INT_SEQUENCE . "</strong></td>";
                                                echo "<td align='left' colspan='4'><strong>" . $row->CHR_ACTIVITY . "</strong></td>"; 
                                                echo "<td align='center'>";
                                                    echo "<a data-target='#modalAddDetail" . $row->INT_ID . "' class='label label-info' data-placement='left' data-toggle='modal' title='Add Detail'><span class='fa fa-plus'></span></a>";
                                                    echo "<a data-target='#modalEditActivity" . $row->INT_ID . "' class='label label-warning' data-placement='left' data-toggle='modal' title='Edit Activity'><span class='fa fa-edit'></span></a>";
                                                    echo "<a href='" . base_url('index.php/mte/master_preventive_c/delete_activity') . "/" . $row->INT_ID_CHECKSHEET . "/" . $row->INT_ID . "' class='label label-danger' data-placement='left' title='Delete'><span class='fa fa-times'></span></a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $id_act = $row->INT_ID;
                                                $get_detail = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL WHERE INT_ID_ACTIVITY = '$id_act' AND INT_FLG_DEL = '0'");
                                                if($get_detail->num_rows() > 0){
                                                    $data_detail = $get_detail->result();
                                                    foreach ($data_detail as $row2){
                                                        $no++;
                                                        echo "<tr class='gradeX'>";
                                                        echo "<td align='left'>" . $no . "</td>";
                                                        echo "<td align='right'>" . $row2->INT_SEQUENCE . "</td>";
                                                        echo "<td align='left'>" . $row2->CHR_ACTIVITY_DETAIL . "</td>";
                                                        echo "<td align='left'>" . $row2->CHR_ITEM_CHECK . "</td>";  
                                                        echo "<td align='left'>" . $row2->CHR_TOOL . "</td>"; 
                                                        echo "<td align='left'>" . $row2->CHR_STD_CHECK . "</td>"; 
                                                        echo "<td align='center'>";
                                                            echo "<a data-target='#modalEditDetail_" . $row->INT_ID . "_" . $row2->INT_ID ."' class='label label-warning' data-toggle='modal' data-placement='left' title='Edit Detail'><span class='fa fa-edit'></span></a>";
                                                            echo "<a href='" . base_url('index.php/mte/master_preventive_c/delete_activity_detail') . "/" . $row->INT_ID_CHECKSHEET . "/" . $row->INT_ID . "/" . $row2->INT_ID . "' class='label label-danger' data-placement='left' title='Delete'><span class='fa fa-times'></span></a>";
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                }  
                                                $no++;
                                            }
                                        } else {
                                            echo "<tr style='background-color: whitesmoke;'>";
                                            echo "<td colspan='7'><strong>No Data Available</strong></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>                                
                            </table>                            
                        </div>
                        <!-- START MODAL 1 -->  
                        <div class="modal fade" id="modalActivity" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Activity</strong></h4>
                                        </div>
                                        <?php echo form_open('mte/master_preventive_c/add_main_activity', 'class="form-horizontal"'); ?>
                                        <input name="ID_CHECKSHEET" class="form-control" type="hidden" value="<?php echo $checksheet->INT_ID; ?>">
                                        <div class="modal-body">
                                            <table class="table table-condensed table-striped table-hover display" style="font-size:11px;" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Activity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    for($i=1; $i<=5; $i++){
                                                        echo "<tr>";
                                                        echo "<td>" . $i . "</td>";
                                                        echo "<td><textarea class='form-control' name='ACTIVITY_" . $i . "'></textarea></td>";
                                                        echo "</tr>";
                                                    }                                                                                                       
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="add_main_activity" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                            </div>                                            
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL 1 -->
                        <!-- START MODAL 2 -->  
                        <?php foreach ($data as $act) { ?>                      
                        <div class="modal fade" id="modalAddDetail<?php echo $act->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Detail Activity</strong></h4>
                                        </div>
                                        <?php echo form_open('mte/master_preventive_c/add_activity_detail', 'class="form-horizontal"'); ?>
                                        <input name="ID_CHECKSHEET" class="form-control" type="hidden" value="<?php echo $checksheet->INT_ID; ?>">
                                        <input name="ID_ACTIVITY" class="form-control" type="hidden" value="<?php echo $act->INT_ID; ?>">
                                        <div class="modal-body">
                                            <div>
                                                <label><?php echo $act->INT_SEQUENCE . '. ' . $act->CHR_ACTIVITY; ?></label>
                                            </div>
                                            <table class="table table-condensed table-striped table-hover display" style="font-size:11px;" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Activity</th>
                                                        <th>Item Check</th>
                                                        <th>Tool</th>
                                                        <th>Standard</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    for($i=1; $i<=5; $i++){
                                                        echo "<tr>";
                                                        echo "<td>" . $i . "</td>";
                                                        echo "<td style='width:30%;'><textarea class='form-control' name='ACTIVITY_DETAIL_" . $i . "'></textarea></td>";
                                                        echo "<td style='width:30%;'><textarea class='form-control' name='ITEM_CHECK_" . $i . "'></textarea></td>";
                                                        echo "<td style='width:20%;'><textarea class='form-control' name='TOOL_" . $i . "'></textarea></td>";  
                                                        echo "<td style='width:20%;'><textarea class='form-control' name='STD_CHECK_" . $i . "'></textarea></td>"; 
                                                        echo "</tr>";
                                                    }                                                                                                       
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="update_activities_<?php echo $act->INT_ID; ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                            </div>                                            
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END MODAL 2 -->
                        <!-- START MODAL 3 -->  
                        <?php foreach ($data as $act) { ?>                      
                        <div class="modal fade" id="modalEditActivity<?php echo $act->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Activity</strong></h4>
                                        </div>
                                        <?php echo form_open('mte/master_preventive_c/update_activity', 'class="form-horizontal"'); ?>
                                        <input name="ID_CHECKSHEET" class="form-control" type="hidden" value="<?php echo $checksheet->INT_ID; ?>">
                                        <input name="ID_ACTIVITY" class="form-control" type="hidden" value="<?php echo $act->INT_ID; ?>">
                                        <div class="modal-body">
                                            <table class="table table-condensed table-striped table-hover display" style="font-size:11px;" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Activity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php                                                    
                                                        echo "<tr>";
                                                        // echo "<td width='15%'><input type='number' class='form-control' name='SEQUENCE_" . $act->INT_ID . "' value='" . $act->INT_SEQUENCE . "'></td>";
                                                        echo "<td width='15%'>" . $act->INT_SEQUENCE . "</td>";
                                                        echo "<td width='85%'><textarea class='form-control' name='ACTIVITY_" . $act->INT_ID . "'>" . $act->CHR_ACTIVITY . "</textarea></td>";
                                                        echo "</tr>";                                                                                       
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="update_activities_<?php echo $act->INT_ID; ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-check"></i> Update</button>
                                            </div>                                            
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END MODAL 3 -->
                        <!-- START MODAL 4 -->  
                        <?php 
                            foreach ($data as $act) {
                                $id_act = $act->INT_ID;
                                $get_detail = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL WHERE INT_ID_ACTIVITY = '$id_act' AND INT_FLG_DEL = '0'");
                                if($get_detail->num_rows() > 0){
                                    foreach($get_detail->result() as $act2){
                                 
                        ?>                      
                        <div class="modal fade" id="modalEditDetail_<?php echo $act->INT_ID . '_' . $act2->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Detail Activity</strong></h4>
                                        </div>
                                        <?php echo form_open('mte/master_preventive_c/update_activity_detail', 'class="form-horizontal"'); ?>
                                        <input name="ID_CHECKSHEET" class="form-control" type="hidden" value="<?php echo $checksheet->INT_ID; ?>">
                                        <input name="ID_ACTIVITY" class="form-control" type="hidden" value="<?php echo $act->INT_ID; ?>">
                                        <input name="ID_ACTIVITY_DETAIL" class="form-control" type="hidden" value="<?php echo $act2->INT_ID; ?>">
                                        <div class="modal-body">
                                            <div>
                                                <label><?php echo $act->INT_SEQUENCE . '. ' . $act->CHR_ACTIVITY; ?></label>
                                            </div>
                                            <table class="table table-condensed table-striped table-hover display" style="font-size:11px;" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Activity</th>
                                                        <th>Item Check</th>
                                                        <th>Tool</th>
                                                        <th>Standard</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>" . $act2->INT_SEQUENCE . "</td>";
                                                        echo "<td style='width:25%;'><textarea class='form-control' name='ACTIVITY_DETAIL_" . $act2->INT_ID . "'>" . $act2->CHR_ACTIVITY_DETAIL . "</textarea></td>";
                                                        echo "<td style='width:25%;'><textarea class='form-control' name='ITEM_CHECK_" . $act2->INT_ID . "'>" . $act2->CHR_ITEM_CHECK . "</textarea></td>";
                                                        echo "<td style='width:25%;'><textarea class='form-control' name='TOOL_" . $act2->INT_ID . "'>" . $act2->CHR_TOOL . "</textarea></td>";  
                                                        echo "<td style='width:25%;'><textarea class='form-control' name='STD_CHECK_" . $act2->INT_ID . "'>" . $act2->CHR_STD_CHECK . "</textarea></td>"; 
                                                        echo "</tr>";                                                                                       
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="update_activities_<?php echo $act->INT_ID . "_" . $act2->INT_ID; ?>" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-check"></i> Update</button>
                                            </div>                                            
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } } } ?>
                        <!-- END MODAL 4 -->
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
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>
