
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
            <li><a href="<?php echo base_url('index.php/inventory/temp_part_c/manage_phantom_parts') ?>"><strong>Manage Phantom Parts</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE PHANTOM PARTS</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/inventory/temp_part_c/upload_phantom_parts/'.$id_dept.'/'.$work_center) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Upload Lot Kanban" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Upload</a>
                            <a data-toggle="modal" data-target="#modalAddPart"  class="btn btn-primary" data-placement="left" title="Add Phantom Part" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Add Part</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('inventory/temp_part_c/search_phantom_parts', 'class="form-horizontal"'); ?>
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
                                            <select name="INT_ID_DEPT" id="dept_to_work_center" onchange="get_data_work_center();" class="ddl2" style="width:150px;">
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
                                        <select id="work_center" name="CHR_WORK_CENTER" class="ddl2" style="width:150px;">
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
                                        <?php form_close(); ?>
                                    </td>
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
                                        <th style="text-align:left;">Part No</th>
                                        <th style="text-align:center;">Back No</th> 
                                        <th style="text-align:center;">Part Name</th>
                                        <th style="text-align:center;">Actions</th>
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
                                        echo "<td style='text-align:center;'>$isi->CHR_PART_NAME</td>";                              
                                        ?>
                                    <td style='text-align:center;'>
                                        <a href="<?php echo base_url('index.php/inventory/temp_part_c/delete_phantom_part') . "/" . $isi->INT_ID . "/" . trim($id_dept) . "/" . trim($work_center) . "/" . $part_no ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this data?');" data-placement="top" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
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
                
                    <div class="modal fade" id="modalAddPart" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Phantom Part</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                        <?php echo form_open('inventory/temp_part_c/add_phantom_part', 'class="form-horizontal"'); ?>
                                            <input name="INT_ID_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $id_dept; ?>">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Work Center</label>
                                                <div class="col-sm-5">
                                                    <input type="text" id="chr_work_center" name="chr_work_center" class="form-control" required readonly value="<?php echo trim($work_center); ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Part No</label>
                                                <div class="col-sm-5">
                                                <select id="part_no" name="chr_part_no" class="ddl2">
                                                    <?php
                                                    foreach ($all_part_no as $row) { ?>
                                                        <option value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO); ?> </option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                        <?php echo form_close(); ?>
                                                </div>
                                            
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
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
</script>