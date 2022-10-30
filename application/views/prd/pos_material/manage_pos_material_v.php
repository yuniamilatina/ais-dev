
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE POS MATERIAL</strong></a></li>
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
                        <i class="fa fa-puzzle-piece"></i>
                        <span class="grid-title"><strong>MANAGE POS MATERIAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/pos_material_c/create_pos_material/'.$work_center) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Mapping comp. to Pos" style="height:30px;font-size:13px;width:100px;color:grey;margin-top:-5px;margin-bottom:-5px;">Create / Edit</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('prd/pos_material_c/index/' . trim($row->CHR_WORK_CENTER)); ?>"  <?php
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
                        <div class="table-luar">
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  style='vertical-align: middle;text-align:center;'>No</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Work Center</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Part No. FG.</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Part No. Comp.</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Back No. Comp.</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Scan Needed</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Pos</th>
                                    <!-- <th  style='vertical-align: middle;text-align:center;'>Image</th> -->
                                    <th  style='vertical-align: middle;text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;'>$i</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_PART_NO_FG</td>";
                                    echo "<td style='text-align:center;'><strong>$row->CHR_PART_NO_COMP</strong></td>";
                                    echo "<td style='text-align:center;'><strong>$row->CHR_BACK_NO_COMP</strong></td>";
                                    if($row->INT_FLG_IGNORE_SCAN == 1){
                                        $flag_scan = '<div class="checkbox">
                                        <input type="checkbox" disabled unchecked class="icheck"></div>';
                                    }else{
                                        $flag_scan = '<div class="checkbox">
                                        <input type="checkbox" disabled checked class="icheck"></div>';
                                    }
                                    echo "<td style='text-align:center;'>$flag_scan</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_POS_PRD</td>";
                                    // echo "<td>$row->CHR_IMG_FILE_NAME</td>";
                                   
                                    ?>
                                <td  style='text-align:center;'>
                                    <a href="<?php echo base_url('index.php/prd/pos_material_c/view_pos_material') . "/" . trim($row->INT_ID). "/" . trim($row->CHR_PART_NO_FG). "/" . trim($row->CHR_WORK_CENTER); ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a onclick="get_pos_by_work_center_and_part('<?php echo $row->INT_ID ?>','<?php echo $row->CHR_POS_PRD ?>','<?php echo trim($row->CHR_PART_NO_FG) ?>','<?php echo $work_center ?>');" data-toggle="modal" data-target="#modalEditPos<?php echo trim($row->INT_ID) ?>" data-placement="left" data-toggle="tooltip" title="Edit Lot" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/prd/pos_material_c/delete_pos_material') . "/" . trim($row->INT_ID).'/'.$work_center ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this pos_material?');"><span class="fa fa-times"></span></a>
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

                <?php foreach ($data as $row) { ?>
                    <div class="modal fade" id="modalEditPos<?php echo trim($row->INT_ID) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Pos Material</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                        <?php echo form_open('prd/pos_material_c/updating_pos_material', 'class="form-horizontal"'); ?>

                                            <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">
                                            <input name="INT_ID" class="form-control" type="hidden" style="width: 300px;" value="<?php echo trim($row->INT_ID) ?>">

                                             <div class="form-group">
                                                <label class="col-sm-3 control-label">Pos</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control" name="CHR_POS_PRD" id="pos<?php echo trim($row->INT_ID) ?>">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                </div>
                                            </div>
                                        </div>

                                        <?php echo form_close(); ?>

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


function get_pos_by_work_center_and_part(id, pos, part_no, wc){
    
    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('prd/pos_material_c/get_pos_by_work_center_and_part'); ?>",
        data:  {
                CHR_POS_PRD: pos, CHR_PART_NO: part_no, CHR_WORK_CENTER : wc
                },
        success: function (json_data) {
            $("#pos"+id).html(json_data['data']);
        },
        error: function (request) {
            alert(request.responseText);
        }
    });

}

</script>